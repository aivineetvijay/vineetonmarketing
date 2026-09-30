"""Convert an essay's HTML (the format the blog-writer produces) into the block list
that wordpress/build/pages/blog.php renders as Elementor v4 atomic elements.
usage: python3 html_to_blocks.py essay.html > essay.json"""
import json, re, sys

src = open(sys.argv[1], encoding='utf-8').read()

def inline(h):
    """Keep <strong>, <em>, <a href>; drop every other tag (e.g. <code>) and attributes."""
    h = re.sub(r'<a\s+[^>]*href="([^"]+)"[^>]*>', r'<a href="\1">', h)
    h = re.sub(r'<br\s*/?>', '<br>', h)
    h = re.sub(r'</?(?!strong\b|em\b|a\b|/a\b|br\b)[a-z][^>]*>', '', h)
    h = re.sub(r'<(strong|em)\s[^>]*>', r'<\1>', h)
    return re.sub(r'\s+', ' ', h).strip()

def items(h, tag):
    return [inline(x) for x in re.findall(r'<li[^>]*>(.*?)</li>', h, re.S)]

def cells(row, tag):
    return [inline(x) for x in re.findall(r'<%s[^>]*>(.*?)</%s>' % (tag, tag), row, re.S)]

# Split into top-level elements: every element starts at column 0.
chunks, cur = [], []
for line in src.splitlines():
    if re.match(r'<(?!/)', line) and cur and not re.match(r'<(li|tr|td|th|thead|tbody|table|/)', line):
        chunks.append('\n'.join(cur)); cur = []
    if line.strip():
        cur.append(line)
if cur:
    chunks.append('\n'.join(cur))

def columns(c):
    """The inner flex columns of a two-column box."""
    return re.split(r'<div style="flex:1 1', c)[1:]

def caption(c):
    m = re.findall(r'<p style="font-size:13px[^"]*">(.*?)</p>', c, re.S)
    return inline(m[-1]) if m else ''

blocks = []
for c in chunks:
    m = re.match(r'<!-- INSERT IMAGE HERE: (\S+)', c)
    if m:  # screenshot marker: filled with attachment id, alt and caption at build time
        blocks.append(['figure', m.group(1)]); continue
    tag = re.match(r'<([a-z0-9]+)', c).group(1)
    ps_all = [inline(x) for x in re.findall(r'<p[^>]*>(.*?)</p>', c, re.S)]
    if tag == 'div' and '>Diagram<' in c:  # hierarchy diagram: stepped boxes + supporting boxes
        cols = []
        for col in columns(c):
            label = inline(re.search(r'<p[^>]*>(.*?)</p>', col, re.S).group(1))
            boxes = [[inline(t), inline(d)] for t, d in re.findall(r'<strong>(.*?)</strong><br><span[^>]*>(.*?)</span>', col, re.S)]
            cols.append([label, 'dashed' in col, boxes])
        blocks.append(['diagram', ps_all[0], ps_all[1], cols, caption(c)]); continue
    if tag == 'div' and ('✓' in c or '✗' in c):  # comparison: marked rows in two columns
        cols = []
        for col in columns(c):
            label = inline(re.search(r'<p[^>]*>(.*?)</p>', col, re.S).group(1))
            rows = [[{'✓': 'good', '✗': 'bad', '~': 'warn'}[k], inline(t)] for k, t in re.findall(r'<strong style="color:[^"]*">(.)</strong>(.*?)</p>', col, re.S)]
            cols.append([label, rows])
        blocks.append(['compare', ps_all[0], ps_all[1], cols, caption(c)]); continue
    if tag == 'div' and '>Template<' in c:  # brief template: label, title, then paragraphs and lists in order
        parts = []
        for t, body in re.findall(r'<(p|ol|ul)[^>]*>(.*?)</\1>', c, re.S)[2:]:
            parts.append(['p', inline(body)] if t == 'p' else [t, items(body, 'li')])
        blocks.append(['brief', ps_all[0], ps_all[1], parts]); continue
    if tag == 'p':
        body = re.match(r'<p[^>]*>(.*)</p>\s*$', c, re.S).group(1)
        if 'font-size:13px' in c:  # caption under a code sample or table
            blocks.append(['cite', inline(body)])
        else:
            blocks.append(['p', inline(body)])
    elif tag == 'h2':
        m = re.match(r'<h2 id="([^"]+)">(.*?)</h2>', c, re.S)
        blocks.append(['h2', inline(m.group(2)), m.group(1)])
    elif tag == 'h3':
        blocks.append(['h3s', inline(re.sub(r'</?h3[^>]*>', '', c))])
    elif tag in ('ul', 'ol'):
        blocks.append([tag, items(c, tag)])
    elif tag == 'pre':
        code = re.search(r'<code>(.*?)</code>', c, re.S).group(1)
        blocks.append(['code', code.split('\n')])
    elif tag == 'nav':
        label = inline(re.search(r'<p[^>]*>(.*?)</p>', c, re.S).group(1))
        links = re.findall(r'<a href="#([^"]+)">(.*?)</a>', c)
        blocks.append(['toc', label, [[inline(t), a] for a, t in links]])
    elif tag == 'blockquote':
        blocks.append(['quote', inline(re.search(r'<p[^>]*>(.*?)</p>', c, re.S).group(1)), ''])
    elif tag == 'div' and '<table' in c:
        head = cells(re.search(r'<thead>(.*?)</thead>', c, re.S).group(1), 'th')
        rows = [cells(r, 'td') for r in re.findall(r'<tr>(.*?)</tr>', re.search(r'<tbody>(.*?)</tbody>', c, re.S).group(1), re.S)]
        blocks.append(['table', head, rows])
    elif tag == 'div':
        ps = [inline(x) for x in re.findall(r'<p[^>]*>(.*?)</p>', c, re.S)]
        lis = items(c, 'li')
        if '<a ' in c and not lis:  # closing call to action
            a = re.search(r'<a href="([^"]+)"[^>]*>(.*?)</a>', c, re.S)
            blocks.append(['cta', ps[0], ps[1] if len(ps) > 1 else '', inline(a.group(2)), a.group(1)])
        elif len(ps) == 2:          # labelled box with a title (framework)
            blocks.append(['callout', ps[0], ps[1], 'ol' if '<ol' in c else 'ul', lis])
        elif 'background' in c:     # shaded action box
            blocks.append(['note', ps[0], 'ol' if '<ol' in c else 'ul', lis])
        else:                       # ruled summary box (key takeaways)
            blocks.append(['box', ps[0], 'ol' if '<ol' in c else 'ul', lis])
    else:
        raise SystemExit('unhandled element: ' + c[:80])

json.dump(blocks, sys.stdout, ensure_ascii=False, indent=1)
