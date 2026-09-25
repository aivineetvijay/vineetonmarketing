"""Builds the header logo: pulsing blue dot + "Vineet Vijay" as Inter 600 outlines.

The design's brand is a 10px #0066cc dot with a pulsing ring, 12px gap, and the
name at 16px / 600 / -0.01em in #1d1d1f. The pulse is a SMIL loop inside the SVG,
so it animates as a plain <img> logo with no CSS.
usage: python3 build_logo.py Inter-SemiBold.ttf out.svg
"""
import sys
from fontTools.ttLib import TTFont
from fontTools.pens.svgPathPen import SVGPathPen
from fontTools.pens.transformPen import TransformPen

font = TTFont(sys.argv[1]); gs = font.getGlyphSet(); cmap = font.getBestCmap(); upm = font['head'].unitsPerEm
SIZE, TRACK, INK, ACCENT = 16, -0.01 * 16, '#1d1d1f', '#0066cc'
H, CY, DOT_X = 28, 14, 10          # ring grows to r=10, so the dot sits 10px in
TEXT_X = DOT_X + 5 + 12             # dot radius + design gap
BASE = CY + 0.727 * SIZE / 2        # centre the cap height on the dot
sc = SIZE / upm
pen = SVGPathPen(gs, ntos=lambda v: ('%.2f' % v).rstrip('0').rstrip('.'))
x = TEXT_X
text = 'Vineet Vijay'
for i, ch in enumerate(text):
    g = cmap[ord(ch)]
    gs[g].draw(TransformPen(pen, (sc, 0, 0, -sc, x, BASE)))
    x += gs[g].width * sc + (TRACK if i < len(text) - 1 else 0)
W = round(x + 1)
svg = (f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}" width="{W}" height="{H}" role="img" aria-label="Vineet Vijay">'
       f'<title>Vineet Vijay</title>'
       f'<circle cx="{DOT_X}" cy="{CY}" r="5" fill="{ACCENT}" opacity="0.45">'
       f'<animate attributeName="r" values="5;10;10" keyTimes="0;0.7;1" dur="2.4s" repeatCount="indefinite"/>'
       f'<animate attributeName="opacity" values="0.45;0;0" keyTimes="0;0.7;1" dur="2.4s" repeatCount="indefinite"/></circle>'
       f'<circle cx="{DOT_X}" cy="{CY}" r="5" fill="{ACCENT}"/>'
       f'<path fill="{INK}" d="{pen.getCommands()}"/></svg>')
open(sys.argv[2], 'w').write(svg)
print(W, H, len(svg))
