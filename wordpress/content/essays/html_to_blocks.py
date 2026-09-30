"""Convert an essay's HTML (the format the blog-writer produces) into the block list
that wordpress/build/pages/blog.php renders as Elementor v4 atomic elements.
usage: python3 html_to_blocks.py essay.html > essay.json"""
import json, re, sys

src = open(sys.argv[1], encoding='utf-8').read()

def inline(h):
    """Keep <strong>, <em>, <a href>; drop every other tag (e.g. <code>) and attributes."""
    h = re.sub(r'<a\s+[^>]*href="([^"]+)"[^>]*>', r'<a href="\1">', h)
    h = re.sub(r'</?(?!strong\b|em\b|a\b|/a\b)[a-z][^>]*>', '', h)
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

blocks = []
for c in chunks:
    tag = re.match(r'<([a-z0-9]+)', c).group(1)
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
            blocks.append(['cta', ps[0], ps[1], inline(a.group(2)), a.group(1)])
        elif len(ps) == 2:          # labelled box with a title (framework)
            blocks.append(['callout', ps[0], ps[1], 'ol' if '<ol' in c else 'ul', lis])
        elif 'background' in c:     # shaded action box
            blocks.append(['note', ps[0], 'ol' if '<ol' in c else 'ul', lis])
        else:                       # ruled summary box (key takeaways)
            blocks.append(['box', ps[0], 'ol' if '<ol' in c else 'ul', lis])
    else:
        raise SystemExit('unhandled element: ' + c[:80])

json.dump(blocks, sys.stdout, ensure_ascii=False, indent=1)
