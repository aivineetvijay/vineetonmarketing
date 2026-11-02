"""Banner for the What is SEO essay: a search bar leading through Find, Understand, Trust and Choose."""
import sys, math
from PIL import Image, ImageDraw, ImageFont, ImageFilter
OUT=sys.argv[1]  
F='/usr/share/fonts/opentype/inter/'
def font(w,s): return ImageFont.truetype(F+{'r':'Inter-Regular.otf','m':'Inter-Medium.otf','sb':'Inter-SemiBold.otf','b':'Inter-Bold.otf'}[w],s)
INK=(20,20,22); MUTED=(110,110,116); LINE=(200,200,206); CARD=(255,255,255); ACC=(37,99,235)
def bg(W,H):
    im=Image.new('RGB',(W,H)); d=ImageDraw.Draw(im)
    for y in range(H):
        t=y/H; c=int(246-10*t); d.line([(0,y),(W,y)],fill=(c,c,c+2))
    # soft dot grid
    for x in range(0,W,28):
        for y in range(0,H,28): d.point((x,y),fill=(222,222,226))
    return im
def shadow_card(im,box,r,s):
    x0,y0,x1,y1=box
    sh=Image.new('L',im.size,0); ImageDraw.Draw(sh).rounded_rectangle((x0,y0+6*s,x1,y1+10*s),r,fill=70)
    sh=sh.filter(ImageFilter.GaussianBlur(14*s))
    im.paste((0,0,0),(0,0),sh.point(lambda v:int(v*0.35)))
    d=ImageDraw.Draw(im); d.rounded_rectangle(box,r,fill=CARD,outline=(228,228,232),width=max(1,int(1.5*s)))
def icon(d,kind,cx,cy,s,col):
    w=max(2,int(3*s))
    if kind=='find':   # magnifier
        r=11*s; d.ellipse((cx-r-3*s,cy-r-3*s,cx+r-3*s,cy+r-3*s),outline=col,width=w); d.line((cx+5*s,cy+5*s,cx+13*s,cy+13*s),fill=col,width=w+1)
    elif kind=='understand': # page lines
        d.rounded_rectangle((cx-11*s,cy-14*s,cx+11*s,cy+14*s),3*s,outline=col,width=w)
        for i,l in enumerate([12,12,8]): d.line((cx-6*s,cy-6*s+i*7*s,cx-6*s+l*s,cy-6*s+i*7*s),fill=col,width=w)
    elif kind=='trust': # shield + tick
        pts=[(cx,cy-15*s),(cx+13*s,cy-9*s),(cx+11*s,cy+5*s),(cx,cy+15*s),(cx-11*s,cy+5*s),(cx-13*s,cy-9*s)]
        d.polygon(pts,outline=col,width=w); d.line([(cx-6*s,cy),(cx-1*s,cy+5*s),(cx+7*s,cy-5*s)],fill=col,width=w,joint='curve')
    elif kind=='choose': # cursor click
        pts=[(cx-8*s,cy-13*s),(cx+10*s,cy+2*s),(cx+2*s,cy+3*s),(cx+7*s,cy+13*s),(cx+3*s,cy+15*s),(cx-2*s,cy+5*s),(cx-8*s,cy+11*s)]
        d.polygon(pts,fill=col)
STEPS=[('find','Find','Can search engines reach it?'),('understand','Understand','Is it clear what it is about?'),('trust','Trust','Do others vouch for it?'),('choose','Choose','Will a person click it?')]
def searchbar(im,x,y,w,h,s):
    shadow_card(im,(x,y,x+w,y+h),h//2,s); d=ImageDraw.Draw(im)
    icon(d,'find',x+h//2+4*s,y+h//2,s*0.9,MUTED)
    d.text((x+h//2+30*s,y+h//2),'what is seo',font=font('r',int(22*s)),fill=INK,anchor='lm')
    cx=x+h//2+30*s+font('r',int(22*s)).getlength('what is seo')+3*s
    d.line((cx,y+h*0.3,cx,y+h*0.7),fill=ACC,width=max(2,int(2*s)))
def step(im,x,y,w,h,s,i,k,t,sub):
    shadow_card(im,(x,y,x+w,y+h),int(16*s),s); d=ImageDraw.Draw(im)
    r=int(26*s); cx=x+int(22*s)+r; cy=y+h//2
    col=ACC if i==3 else INK
    d.ellipse((cx-r,cy-r,cx+r,cy+r),fill=(238,242,253) if i==3 else (242,242,244))
    icon(d,k,cx,cy,s*0.85,col)
    tx=cx+r+int(16*s)
    d.text((tx,cy-int(12*s)),f'0{i+1}  {t}',font=font('sb',int(21*s)),fill=INK,anchor='lm')
    d.text((tx,cy+int(14*s)),sub,font=font('r',int(14.5*s)),fill=MUTED,anchor='lm')
def dashed(d,p0,p1,s):
    x0,y0=p0;x1,y1=p1; L=math.hypot(x1-x0,y1-y0); n=int(L/(10*s))
    for i in range(0,n,2):
        a=i/n;b=min(1,(i+1)/n); d.line((x0+(x1-x0)*a,y0+(y1-y0)*a,x0+(x1-x0)*b,y0+(y1-y0)*b),fill=(150,150,158),width=max(2,int(2*s)))
def result(im,x,y,w,h,s):
    shadow_card(im,(x,y,x+w,y+h),int(16*s),s); d=ImageDraw.Draw(im)
    d.text((x+20*s,y+24*s),'yourwebsite.com',font=font('r',int(14*s)),fill=MUTED,anchor='lm')
    d.text((x+20*s,y+54*s),'Your page, in your',font=font('sb',int(20*s)),fill=ACC,anchor='lm')
    d.text((x+20*s,y+80*s),"customers' words",font=font('sb',int(20*s)),fill=ACC,anchor='lm')
    for i,l in enumerate([0.85,0.7]): d.rounded_rectangle((x+20*s,y+(104+i*16)*s,x+20*s+(w-40*s)*l,y+(111+i*16)*s),4*s,fill=(226,226,230))
def desktop():
    W,H=1600,534; s=1.0; im=bg(W,H); d=ImageDraw.Draw(im)
    searchbar(im,48,int(H/2-36),318,72,1.0)
    cw,ch=268,120; y=int(H/2-ch/2); gap=22; x0=402
    xs=[x0+i*(cw+gap) for i in range(4)]
    dashed(d,(366,H//2),(x0,H//2),s)
    for i in range(3): dashed(d,(xs[i]+cw,H//2),(xs[i+1],H//2),s)
    for i,(k,t,sub) in enumerate(STEPS):
        step(im,xs[i],y,cw,ch,0.9,i,k,t,sub)
    im.save(OUT+'/what-is-seo-banner-desktop.webp','WEBP',quality=88,method=6)
def mobile():
    W,H=1024,640; s=1.0; im=bg(W,H); d=ImageDraw.Draw(im)
    sbw=420; searchbar(im,(W-sbw)//2,44,sbw,72,1.05)
    cw,ch=420,112; gx=(W-2*cw-36)//2; ys=[176,176,372,372]
    xs=[gx,gx+cw+36,gx,gx+cw+36]
    dashed(d,(W//2,116),(W//2,166),s)
    dashed(d,(xs[0]+cw,ys[0]+ch//2),(xs[1],ys[1]+ch//2),s)
    dashed(d,(xs[1]+cw//2,ys[1]+ch),(xs[2]+cw//2,ys[2]),s)
    dashed(d,(xs[2]+cw,ys[2]+ch//2),(xs[3],ys[3]+ch//2),s)
    for i,(k,t,sub) in enumerate(STEPS): step(im,xs[i],ys[i],cw,ch,1.15,i,k,t,sub)
    d.text((W//2,560),'How SEO works: find, understand, trust, choose',font=font('m',22),fill=MUTED,anchor='mm')
    im.save(OUT+'/what-is-seo-banner-mobile.webp','WEBP',quality=88,method=6)
desktop(); mobile()
