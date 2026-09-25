/* Shared.jsx v2 — editorial components built on Apple tokens.
   Components exposed on window for use across pages. */

const { useState, useEffect, useRef, useLayoutEffect } = React;

/* ===================================================================
   CUSTOM CURSOR — single fixed element that follows the pointer.
   Hover state toggles on [data-cursor="hover"|"text"] selectors.
   =================================================================== */
function Cursor() {
  const ringRef = useRef(null);
  const dotRef  = useRef(null);
  const elRef   = useRef(null);
  const [state, setState] = useState('default');
  const [label, setLabel] = useState('');
  const target = useRef({ x: -50, y: -50 });
  const pos    = useRef({ x: -50, y: -50 });

  useEffect(() => {
    const onMove = (e) => { target.current.x = e.clientX; target.current.y = e.clientY; };
    const onDown = () => setState('press');
    const onUp   = () => setState(prev => prev === 'press' ? 'default' : prev);

    const onOver = (e) => {
      const t = e.target;
      if (!t || !(t.closest)) return;
      // Interactive elements
      if (t.closest('a, button, .chip, .nav__cta, [data-cursor="hover"]')) {
        const labeled = t.closest('[data-cursor-label]');
        setLabel(labeled ? labeled.getAttribute('data-cursor-label') : '');
        setState(labeled ? 'label' : 'hover');
      } else if (t.closest('input, textarea, select, [data-cursor="text"]')) {
        setLabel(''); setState('text');
      } else {
        setLabel(''); setState('default');
      }
    };

    window.addEventListener('mousemove', onMove);
    window.addEventListener('mousedown', onDown);
    window.addEventListener('mouseup', onUp);
    document.addEventListener('mouseover', onOver);

    let rafId;
    const tick = () => {
      pos.current.x += (target.current.x - pos.current.x) * 0.22;
      pos.current.y += (target.current.y - pos.current.y) * 0.22;
      if (elRef.current) {
        elRef.current.style.transform = 'translate3d(' + pos.current.x + 'px,' + pos.current.y + 'px,0)';
      }
      rafId = requestAnimationFrame(tick);
    };
    rafId = requestAnimationFrame(tick);

    return () => {
      window.removeEventListener('mousemove', onMove);
      window.removeEventListener('mousedown', onDown);
      window.removeEventListener('mouseup', onUp);
      document.removeEventListener('mouseover', onOver);
      cancelAnimationFrame(rafId);
    };
  }, []);

  return (
    <div ref={elRef} className="v-cursor" data-state={state} data-label={label}>
      {state !== 'label' && <div ref={ringRef} className="v-cursor__ring" />}
      {state !== 'label' && <div ref={dotRef}  className="v-cursor__dot" />}
    </div>
  );
}

/* ===================================================================
   NAV — fixed, frosted on scroll. Right-aligned section links.
   =================================================================== */
const NAV_LINKS = [
  { label: 'Index',           href: 'index.html' },
  { label: 'Experience',      href: 'experience.html' },
  { label: 'AI in Marketing', href: 'ai.html' },
  { label: 'AI Tools',        href: 'ai-tools.html' },
  { label: 'Writing',         href: 'blog.html' },
];

function Nav({ active }) {
  const [scrolled, setScrolled] = useState(false);
  const [open, setOpen] = useState(false);
  useEffect(() => {
    const on = () => setScrolled(window.scrollY > 20);
    window.addEventListener('scroll', on);
    on();
    return () => window.removeEventListener('scroll', on);
  }, []);
  useEffect(() => {
    document.body.style.overflow = open ? 'hidden' : '';
    return () => { document.body.style.overflow = ''; };
  }, [open]);
  const close = () => setOpen(false);
  return (
    <React.Fragment>
      <header className={"nav " + (scrolled ? "is-scrolled" : "")}>
        <a className="nav__brand" href="index.html" data-cursor-label="Home">
          <span className="dot"></span>
          <span>Vineet Vijay</span>
        </a>
        <nav className="nav__links">
          {NAV_LINKS.filter(l => l.label !== 'Index').map(l => (
            <a key={l.label} href={l.href} className={"nav__link " + (active === l.label ? "is-active" : "")}>
              {l.label}
            </a>
          ))}
        </nav>
        <a className="nav__cta" href="contact.html" data-cursor-label="Say hi">
          Get in touch
          <span className="arrow">
            <svg width="11" height="11" viewBox="0 0 12 12"><path d="M2 10 L10 2 M4 2 L10 2 L10 8" fill="none" stroke="currentColor" strokeWidth="1.4" strokeLinecap="round" strokeLinejoin="round"/></svg>
          </span>
        </a>
        <button
          className={"nav__burger " + (open ? "is-open" : "")}
          aria-label="Menu"
          aria-expanded={open}
          onClick={() => setOpen(v => !v)}>
          <span></span><span></span>
        </button>
      </header>

      <div className={"nav__overlay " + (open ? "is-open" : "")} aria-hidden={!open}>
        <nav className="nav__overlay-links">
          {NAV_LINKS.filter(l => l.label !== 'Index').map((l, i) => (
            <a key={l.label} href={l.href}
               className={"nav__overlay-link " + (active === l.label ? "is-active" : "")}
               style={{ transitionDelay: open ? (i * 60 + 100) + 'ms' : '0ms' }}
               onClick={close}>
              <span className="idx">{String(i + 1).padStart(2, '0')}</span>
              <span>{l.label}</span>
            </a>
          ))}
          <a href="contact.html"
             className="nav__overlay-link"
             style={{ transitionDelay: open ? (NAV_LINKS.length * 60 + 100) + 'ms' : '0ms' }}
             onClick={close}>
            <span className="idx">{String(NAV_LINKS.length).padStart(2, '0')}</span>
            <span>Contact</span>
          </a>
        </nav>
        <div className="nav__overlay-foot">
          <a href="mailto:vineetvijay88@gmail.com">vineetvijay88@gmail.com</a>
          <a href="https://linkedin.com/in/vineetvijay" target="_blank" rel="noopener">LinkedIn</a>
        </div>
      </div>
    </React.Fragment>
  );
}

/* ===================================================================
   REVEAL — element fades up when scrolled into view.
   Use as: <Reveal delay={120}><h2>…</h2></Reveal>
   or stamp [data-reveal] manually and call useReveal() to wire.
   =================================================================== */
function useReveal() {
  useEffect(() => {
    const els = document.querySelectorAll('[data-reveal]:not(.in)');
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -80px 0px' });
    els.forEach(el => io.observe(el));
    return () => io.disconnect();
  });
}

function Reveal({ delay = 0, as: Tag = 'div', className = '', children, ...rest }) {
  return (
    <Tag {...rest} data-reveal className={className} style={{ '--d': delay + 'ms' }}>
      {children}
    </Tag>
  );
}

/* Animated line — each <span> rises into view on .in */
function Line({ children, delay = 0 }) {
  return (
    <span className="line" data-reveal style={{ '--d': delay + 'ms' }}>
      <span>{children}</span>
    </span>
  );
}

/* When a Line is inside a [data-reveal] container, we want the inner span
   to also transition. CSS handles both: the wrapper fades+rises, the inner
   <span> uses .line.in > span. We achieve "in" by reusing the same class. */
function useLineSync() {
  useEffect(() => {
    const lines = document.querySelectorAll('.line[data-reveal]:not(.in)');
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { threshold: 0.1 });
    lines.forEach(l => io.observe(l));
    return () => io.disconnect();
  });
}

/* ===================================================================
   MARQUEE — horizontal scrolling type strip.
   =================================================================== */
function Marquee({ items, glyph = true }) {
  // Two identical tracks to make the loop seamless.
  const renderTrack = (key) => (
    <div className="marquee__track" key={key} aria-hidden={key === 'b'}>
      {items.map((it, i) => (
        <span className="marquee__item" key={i}>
          {it}
          {glyph && <span className="glyph" aria-hidden="true"></span>}
        </span>
      ))}
    </div>
  );
  return (
    <div className="marquee" role="presentation">
      {renderTrack('a')}
      {renderTrack('b')}
    </div>
  );
}

/* ===================================================================
   WORK ROW — large editorial project line.
   Hover surfaces a floating thumbnail next to the cursor.
   =================================================================== */
function WorkRow({ idx, title, tag, year, href, thumbId, thumbTone, onMouseEnter, onMouseLeave, onMouseMove }) {
  return (
    <a className="work-row" href={href}
       data-cursor-label="Open"
       data-thumb-id={thumbId} data-thumb-tone={thumbTone}
       onMouseEnter={onMouseEnter} onMouseLeave={onMouseLeave} onMouseMove={onMouseMove}>
      <span className="row-bg"></span>
      <span className="idx">{idx}</span>
      <span className="title">{title}</span>
      <span className="tag">{tag}</span>
      <span className="yr">{year}</span>
      <span className="arrow">
        <svg width="14" height="14" viewBox="0 0 14 14"><path d="M3 11 L11 3 M5 3 L11 3 L11 9" fill="none" stroke="currentColor" strokeWidth="1.4" strokeLinecap="round" strokeLinejoin="round"/></svg>
      </span>
    </a>
  );
}

/* WorkList wires a single floating thumb that tracks the cursor */
function WorkList({ items }) {
  const thumbRef = useRef(null);
  const [active, setActive] = useState(null);

  const onMove = (e) => {
    if (!thumbRef.current) return;
    thumbRef.current.style.left = e.clientX + 'px';
    thumbRef.current.style.top  = e.clientY + 'px';
  };
  const onEnter = (item) => () => setActive(item);
  const onLeave = () => setActive(null);

  // place thumb on body so it isn't clipped by parent overflow
  useEffect(() => {
    if (!thumbRef.current) return;
    const el = thumbRef.current;
    el.classList.toggle('is-visible', !!active);
  }, [active]);

  return (
    <React.Fragment>
      <ul className="work-list">
        {items.map((it, i) => (
          <li key={it.title} style={{ listStyle: 'none' }}>
            <WorkRow
              idx={String(i + 1).padStart(2, '0') + ' / ' + String(items.length).padStart(2, '0')}
              title={it.title}
              tag={it.tag}
              year={it.year}
              href={it.href}
              thumbId={it.slug}
              thumbTone={it.tone}
              onMouseEnter={onEnter(it)}
              onMouseLeave={onLeave}
              onMouseMove={onMove}
            />
          </li>
        ))}
      </ul>
      <div ref={thumbRef} className="thumb">
        {active && (
          <image-slot
            id={"work-thumb-" + active.slug}
            shape="rect"
            placeholder={active.title}
            class={active.tone}
          />
        )}
      </div>
    </React.Fragment>
  );
}

/* ===================================================================
   POST ROW — editorial blog line.
   =================================================================== */
function PostRow({ year, title, category, href = '#' }) {
  return (
    <a className="post-row" href={href} data-cursor-label="Read">
      <span className="yr">{year}</span>
      <span className="ttl">{title}</span>
      <span className="cat">{category}</span>
      <span className="arr">
        <svg width="14" height="14" viewBox="0 0 14 14"><path d="M3 11 L11 3 M5 3 L11 3 L11 9" fill="none" stroke="currentColor" strokeWidth="1.4" strokeLinecap="round" strokeLinejoin="round"/></svg>
      </span>
    </a>
  );
}

/* ===================================================================
   BUTTONS
   =================================================================== */
function Btn({ children, href, onClick, filled = false }) {
  const cls = "btn " + (filled ? "btn--filled" : "");
  const inner = (
    <React.Fragment>
      <span>{children}</span>
      <span className="arrow">
        <svg width="11" height="11" viewBox="0 0 12 12"><path d="M2 10 L10 2 M4 2 L10 2 L10 8" fill="none" stroke="currentColor" strokeWidth="1.4" strokeLinecap="round" strokeLinejoin="round"/></svg>
      </span>
    </React.Fragment>
  );
  if (href) return <a className={cls} href={href} onClick={onClick}>{inner}</a>;
  return <button className={cls} onClick={onClick}>{inner}</button>;
}

/* ===================================================================
   STAT GRID
   =================================================================== */
function StatGrid({ stats }) {
  return (
    <div className="stat-row">
      {stats.map((s, i) => (
        <div className="stat" key={i}>
          <div className="n">{s.v}{s.sup && <span className="sup">{s.sup}</span>}</div>
          <div className="l">{s.l}</div>
        </div>
      ))}
    </div>
  );
}

/* ===================================================================
   FOOTER
   =================================================================== */
function Footer() {
  return (
    <footer className="foot">
      <div className="wrap">
        <div className="t-mono muted" data-reveal>Get in touch · {new Date().toLocaleString('en-GB', { timeZone: 'Asia/Dubai', hour: '2-digit', minute: '2-digit', hour12: false })} GST</div>
        <div className="foot__mega mt-24" data-reveal style={{ '--d': '120ms', fontSize: 'clamp(28px, 4.4vw, 72px)', letterSpacing: '-0.03em' }}>
          <a href="mailto:vineetvijay88@gmail.com" data-cursor-label="Email">vineetvijay88@gmail.com</a>
        </div>
        <div className="foot__meta">
          <div>
            <div className="k">Based</div>
            Abu Dhabi · Dubai<br/>United Arab Emirates
          </div>
          <div>
            <div className="k">Phone</div>
            <a href="tel:+971586823646">+971 58 682 3646</a>
          </div>
          <div>
            <div className="k">Elsewhere</div>
            <a href="https://linkedin.com/in/vineetvijay" target="_blank" rel="noopener">LinkedIn</a><br/>
            <a href="blog.html#subscribe">Subscribe</a>
          </div>
          <div>
            <div className="k">Status</div>
            <span className="status"><span className="led"></span>Open to new conversations</span>
          </div>
        </div>
        <div className="foot__legal">
          <span>© {new Date().getFullYear()} Vineet Vijay. All rights reserved.</span>
          <span>Built with restraint in Dubai.</span>
        </div>
      </div>
    </footer>
  );
}

/* ===================================================================
   PAGE WRAPPER — handles cursor, reveal observers
   =================================================================== */
function Page({ active, children }) {
  useReveal();
  useLineSync();
  return (
    <React.Fragment>
      <Cursor />
      <Nav active={active} />
      {children}
      <Footer />
    </React.Fragment>
  );
}

Object.assign(window, {
  Cursor, Nav, Reveal, Line, Marquee, WorkRow, WorkList, PostRow, Btn, StatGrid, Footer, Page,
  useReveal, useLineSync, NAV_LINKS
});
