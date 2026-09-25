import math, sys
from fontTools.ttLib import TTFont
from fontTools.pens.svgPathPen import SVGPathPen
from fontTools.pens.transformPen import TransformPen
font = TTFont(sys.argv[1]); gs = font.getGlyphSet(); cmap = font.getBestCmap(); upm = font['head'].unitsPerEm
SIZE, TRACK = 56, -0.02*56
sc = SIZE/upm
def word(text):
    pen = SVGPathPen(gs, ntos=lambda v: ('%.1f' % v).rstrip('0').rstrip('.'))
    x = 0.0
    for i, ch in enumerate(text):
        g = cmap[ord(ch)]
        gs[g].draw(TransformPen(pen, (sc, 0, 0, -sc, x, 0)))
        x += gs[g].width*sc + (TRACK if i < len(text)-1 else 0)
    return pen.getCommands(), x
GAP, DOT, VIEW_W, VIEW_H, BASE, DOT_Y = 60, 12, 3000, 80, 60, 40
def build(names, ink='#1d1d1f', accent='#0066cc', secs=40):
    defs, widths = [], {}
    for i, n in enumerate(names):
        d, w = word(n); widths[n] = w; defs.append(f'<path id="w{i}" d="{d}"/>')
    items, x = [], 0.0
    for i, n in enumerate(names):
        items.append(f'<use href="#w{i}" x="{x:.1f}" y="{BASE}"/>'); x += widths[n] + GAP
        items.append(f'<circle cx="{x+DOT/2:.1f}" cy="{DOT_Y}" r="{DOT/2}" fill="{accent}"/>'); x += DOT + GAP
    T = round(x, 1)
    track = ''.join(items)
    copies = math.ceil((T + VIEW_W) / T)
    body = ''.join(f'<g transform="translate({c*T:.1f} 0)">{track}</g>' if c else f'<g>{track}</g>' for c in range(copies))
    label = ', '.join(names)
    return (f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {VIEW_W} {VIEW_H}" preserveAspectRatio="xMinYMid slice" role="img" aria-label="Brands: {label}">'
            f'<title>Brands: {label}</title><defs>{"".join(defs)}</defs><g fill="{ink}">'
            f'<g><animateTransform attributeName="transform" type="translate" from="0 0" to="-{T} 0" dur="{secs}s" repeatCount="indefinite"/>{body}</g></g></svg>'), T
home = ["Reem Hospital","Apollo Hospitals","Titan Watches","Myntra","ITC Foods","MTR Foods","Wipro","Kreditbee","Duroflex","Wavemaker WPP","IPG"]
exp = ["Reem Hospital","Apollo Hospitals","Titan Watches","Myntra","ITC Foods","MTR Foods","Wipro","Kreditbee","Duroflex","Modenik"]
for name, lst in (('home', home), ('experience', exp)):
    svg, T = build(lst); open(f'{sys.argv[2]}/brands-{name}.svg', 'w').write(svg); print(name, len(svg), 'bytes, period', T)
