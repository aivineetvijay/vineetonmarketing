/* @ds-bundle: {"format":4,"namespace":"AppleDesignSystem_013f8c","components":[],"sourceHashes":{"ui_kits/apple-com/Buttons.jsx":"802c11c756ab","ui_kits/apple-com/Footer.jsx":"36475b6cb585","ui_kits/apple-com/GlobalNav.jsx":"dc6ad3afc2bb","ui_kits/apple-com/ProductPuck.jsx":"70dbdac18fec","ui_kits/apple-com/ProductTile.jsx":"111e50518dbd","ui_kits/apple-com/SubNav.jsx":"e852406270a0","ui_kits/apple-store/BuyPage.jsx":"e12aeebce7e6","ui_kits/apple-store/ConfiguratorChip.jsx":"a98863cf3b53","ui_kits/apple-store/FloatingStickyBar.jsx":"282050ecba0d","ui_kits/apple-store/SearchInput.jsx":"db54e0737a4a","ui_kits/apple-store/StoreSubNav.jsx":"4b27a51e2823","ui_kits/apple-store/UtilityCard.jsx":"ddcee1bc348e"},"inlinedExternals":[],"unexposedExports":[]} */

(() => {

const __ds_ns = (window.AppleDesignSystem_013f8c = window.AppleDesignSystem_013f8c || {});

const __ds_scope = {};

(__ds_ns.__errors = __ds_ns.__errors || []);

// ui_kits/apple-com/Buttons.jsx
try { (() => {
/* Buttons.jsx — PillButton (fill/ghost), DarkUtilityButton, IconChip */

function PillButton({
  variant = 'fill',
  children,
  onClick,
  href
}) {
  const cls = "btn " + (variant === 'fill' ? 'btn--fill' : 'btn--ghost');
  if (href) return /*#__PURE__*/React.createElement("a", {
    className: cls,
    href: href,
    onClick: onClick
  }, children);
  return /*#__PURE__*/React.createElement("button", {
    className: cls,
    onClick: onClick
  }, children);
}
function DarkUtilityButton({
  children,
  onClick
}) {
  return /*#__PURE__*/React.createElement("button", {
    className: "btn--dark-utility",
    onClick: onClick
  }, children);
}
function IconChip({
  children,
  ariaLabel,
  onClick,
  style
}) {
  return /*#__PURE__*/React.createElement("button", {
    onClick: onClick,
    "aria-label": ariaLabel,
    style: {
      width: 44,
      height: 44,
      borderRadius: '50%',
      background: 'rgba(210,210,215,0.64)',
      border: 0,
      cursor: 'pointer',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      color: 'var(--color-ink)',
      ...style
    }
  }, children);
}
Object.assign(window, {
  PillButton,
  DarkUtilityButton,
  IconChip
});
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-com/Buttons.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-com/Footer.jsx
try { (() => {
/* Footer.jsx — dense parchment footer with link columns + legal row */

const FOOTER_COLS = [{
  heading: 'Shop and Learn',
  links: ['Store', 'Mac', 'iPad', 'iPhone', 'Watch', 'Vision', 'AirPods', 'TV & Home', 'AirTag', 'Accessories', 'Gift Cards']
}, {
  heading: 'Apple Wallet',
  links: ['Wallet', 'Apple Card', 'Apple Pay', 'Apple Cash']
}, {
  heading: 'Account',
  links: ['Manage Your Apple Account', 'Apple Store Account', 'iCloud.com']
}, {
  heading: 'Entertainment',
  links: ['Apple One', 'Apple TV+', 'Apple Music', 'Apple Arcade', 'Apple Fitness+', 'Apple News+', 'Apple Podcasts', 'Apple Books', 'App Store']
}, {
  heading: 'About Apple',
  links: ['Newsroom', 'Apple Leadership', 'Career Opportunities', 'Investors', 'Ethics & Compliance', 'Events', 'Contact Apple']
}];
function Footer() {
  return /*#__PURE__*/React.createElement("footer", {
    className: "ft",
    role: "contentinfo"
  }, /*#__PURE__*/React.createElement("div", {
    className: "ft__inner"
  }, /*#__PURE__*/React.createElement("div", {
    className: "ft__copy"
  }, "1. Trade-in values vary based on the condition, year, and configuration of your eligible trade-in device. Not all devices are eligible for credit. ", /*#__PURE__*/React.createElement("a", {
    href: "#"
  }, "More trade-in details"), "."), /*#__PURE__*/React.createElement("div", {
    className: "ft__cols"
  }, FOOTER_COLS.map(col => /*#__PURE__*/React.createElement("div", {
    key: col.heading
  }, /*#__PURE__*/React.createElement("h5", null, col.heading), col.links.map(l => /*#__PURE__*/React.createElement("a", {
    key: l,
    href: "#",
    onClick: e => e.preventDefault()
  }, l))))), /*#__PURE__*/React.createElement("div", {
    className: "ft__legal"
  }, /*#__PURE__*/React.createElement("span", null, "Copyright \xA9 2026 Apple Inc. All rights reserved."), /*#__PURE__*/React.createElement("nav", null, /*#__PURE__*/React.createElement("a", {
    href: "#"
  }, "Privacy Policy"), /*#__PURE__*/React.createElement("a", {
    href: "#"
  }, "Terms of Use"), /*#__PURE__*/React.createElement("a", {
    href: "#"
  }, "Sales and Refunds"), /*#__PURE__*/React.createElement("a", {
    href: "#"
  }, "Legal"), /*#__PURE__*/React.createElement("a", {
    href: "#"
  }, "Site Map")))));
}
window.Footer = Footer;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-com/Footer.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-com/GlobalNav.jsx
try { (() => {
/* GlobalNav.jsx — 44px true-black bar pinned to top of every apple.com page */
const {
  useState
} = React;
function GnIcon({
  kind
}) {
  if (kind === 'search') {
    return /*#__PURE__*/React.createElement("svg", {
      viewBox: "0 0 17 17",
      width: "14",
      height: "14"
    }, /*#__PURE__*/React.createElement("path", {
      fill: "none",
      stroke: "#f5f5f7",
      strokeWidth: "1.5",
      strokeLinecap: "round",
      strokeLinejoin: "round",
      d: "M7.25 1.5a5.75 5.75 0 1 1 0 11.5 5.75 5.75 0 0 1 0-11.5zM11.5 11.5l4 4"
    }));
  }
  if (kind === 'bag') {
    return /*#__PURE__*/React.createElement("svg", {
      viewBox: "0 0 17 19",
      width: "14",
      height: "16"
    }, /*#__PURE__*/React.createElement("path", {
      fill: "none",
      stroke: "#f5f5f7",
      strokeWidth: "1.4",
      strokeLinecap: "round",
      strokeLinejoin: "round",
      d: "M3 6h11l-.9 11.2a1 1 0 0 1-1 .9H4.9a1 1 0 0 1-1-.9L3 6zM5.5 6V4.25A3 3 0 0 1 8.5 1.25h0a3 3 0 0 1 3 3V6"
    }));
  }
  return null;
}
function GnLogo() {
  return /*#__PURE__*/React.createElement("svg", {
    viewBox: "0 0 22 27",
    width: "14",
    height: "17",
    "aria-label": "Apple"
  }, /*#__PURE__*/React.createElement("path", {
    fill: "#f5f5f7",
    d: "M17.62 14.34c-.02-2.61 2.13-3.87 2.23-3.93-1.22-1.78-3.11-2.02-3.78-2.05-1.61-.16-3.14.95-3.96.95-.82 0-2.08-.93-3.42-.9-1.76.03-3.38 1.02-4.29 2.6-1.83 3.18-.47 7.88 1.32 10.46.87 1.26 1.91 2.68 3.27 2.63 1.31-.05 1.81-.85 3.4-.85 1.59 0 2.04.85 3.43.83 1.42-.03 2.31-1.29 3.18-2.56 1-1.47 1.41-2.89 1.44-2.96-.03-.01-2.77-1.07-2.82-4.22zM15.04 6.66c.72-.88 1.21-2.1 1.07-3.31-1.04.04-2.29.69-3.04 1.56-.67.77-1.26 2.02-1.1 3.21 1.16.09 2.35-.58 3.07-1.46z"
  }));
}
const NAV_CATEGORIES = ['Store', 'Mac', 'iPad', 'iPhone', 'Watch', 'Vision', 'AirPods', 'TV & Home', 'Entertainment', 'Accessories', 'Support'];
function GlobalNav({
  active,
  onSelect
}) {
  return /*#__PURE__*/React.createElement("nav", {
    className: "gn",
    "aria-label": "Global"
  }, /*#__PURE__*/React.createElement("div", {
    className: "gn__inner"
  }, /*#__PURE__*/React.createElement("a", {
    className: "gn__logo",
    href: "#",
    "aria-label": "Apple"
  }, /*#__PURE__*/React.createElement(GnLogo, null)), NAV_CATEGORIES.map(label => /*#__PURE__*/React.createElement("span", {
    key: label,
    className: "gn-link " + (active === label ? "is-active" : ""),
    onClick: () => onSelect && onSelect(label)
  }, label)), /*#__PURE__*/React.createElement("span", {
    className: "gn__spacer"
  }), /*#__PURE__*/React.createElement("span", {
    className: "gn__icon",
    "aria-label": "Search"
  }, /*#__PURE__*/React.createElement(GnIcon, {
    kind: "search"
  })), /*#__PURE__*/React.createElement("span", {
    className: "gn__icon",
    "aria-label": "Bag"
  }, /*#__PURE__*/React.createElement(GnIcon, {
    kind: "bag"
  }))));
}
window.GlobalNav = GlobalNav;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-com/GlobalNav.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-com/ProductPuck.jsx
try { (() => {
/* ProductPuck.jsx — placeholder for a real product photograph.
   Tones map to common iPhone / Mac / Watch finishes so the demo feels
   varied without ever shipping real imagery. */

function ProductPuck({
  tone = 'light',
  width = 360,
  height = 200,
  style = {}
}) {
  const cls = "puck puck--" + tone;
  return /*#__PURE__*/React.createElement("div", {
    className: cls,
    style: {
      width,
      height,
      ...style
    }
  });
}
window.ProductPuck = ProductPuck;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-com/ProductPuck.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-com/ProductTile.jsx
try { (() => {
/* ProductTile.jsx — full-bleed alternating tile.
   surface: 'light' | 'parchment' | 'dark' | 'dark-2' | 'dark-3' */

function ProductTile({
  surface = 'light',
  eyebrow,
  name,
  tagline,
  primaryCta,
  /* { label, onClick } — filled blue pill */
  secondaryCta,
  /* { label, onClick } — ghost blue pill */
  children,
  /* product render slot */
  paddingY,
  /* override section padding */
  textBefore /* render text BEFORE media (default) or after (when false) */
}) {
  const cls = "pt pt--" + surface;
  const before = textBefore !== false;
  const stack = /*#__PURE__*/React.createElement(React.Fragment, null, eyebrow && /*#__PURE__*/React.createElement("div", {
    className: "pt__eyebrow"
  }, eyebrow), name && /*#__PURE__*/React.createElement("h2", {
    className: "pt__name"
  }, name), tagline && /*#__PURE__*/React.createElement("p", {
    className: "pt__tagline"
  }, tagline), (primaryCta || secondaryCta) && /*#__PURE__*/React.createElement("div", {
    className: "pt__ctas"
  }, secondaryCta && /*#__PURE__*/React.createElement(PillButton, {
    variant: "ghost",
    onClick: secondaryCta.onClick
  }, secondaryCta.label), primaryCta && /*#__PURE__*/React.createElement(PillButton, {
    variant: "fill",
    onClick: primaryCta.onClick
  }, primaryCta.label)));
  return /*#__PURE__*/React.createElement("section", {
    className: cls,
    style: paddingY ? {
      paddingTop: paddingY,
      paddingBottom: paddingY
    } : null
  }, /*#__PURE__*/React.createElement("div", {
    className: "pt__inner"
  }, before && stack, children && /*#__PURE__*/React.createElement("div", {
    className: "pt__media"
  }, children), !before && stack));
}
window.ProductTile = ProductTile;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-com/ProductTile.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-com/SubNav.jsx
try { (() => {
/* SubNav.jsx — sticky 52px frosted-glass sub-nav under the global nav */

function SubNav({
  category,
  links = [],
  price,
  ctaLabel = 'Buy',
  onCta
}) {
  return /*#__PURE__*/React.createElement("div", {
    className: "sn",
    "aria-label": "Sub-navigation for " + category
  }, /*#__PURE__*/React.createElement("div", {
    className: "sn__inner"
  }, /*#__PURE__*/React.createElement("span", {
    className: "sn__cat"
  }, category), /*#__PURE__*/React.createElement("span", {
    className: "sn__links"
  }, links.map(l => /*#__PURE__*/React.createElement("a", {
    key: l,
    href: "#",
    onClick: e => e.preventDefault()
  }, l))), /*#__PURE__*/React.createElement("span", {
    className: "sn__right"
  }, price && /*#__PURE__*/React.createElement("span", null, price), /*#__PURE__*/React.createElement("button", {
    className: "btn btn--fill",
    style: {
      fontSize: 12,
      padding: '6px 14px'
    },
    onClick: onCta
  }, ctaLabel))));
}
window.SubNav = SubNav;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-com/SubNav.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-store/BuyPage.jsx
try { (() => {
/* BuyPage.jsx — iPhone 17 Pro configurator.
   Composes ConfiguratorChip groups + FloatingStickyBar. Running total
   is computed from the picked storage + color price deltas. */

const {
  useState: useStateBuy,
  useMemo
} = React;
const STORAGE_OPTIONS = [{
  id: '256',
  label: '256GB',
  delta: 0
}, {
  id: '512',
  label: '512GB',
  delta: 200
}, {
  id: '1TB',
  label: '1TB',
  delta: 400
}, {
  id: '2TB',
  label: '2TB',
  delta: 800
}];
const COLOR_OPTIONS = [{
  id: 'black',
  title: 'Black Titanium',
  tone: 'dark',
  delta: 0
}, {
  id: 'desert',
  title: 'Desert Titanium',
  tone: 'gold',
  delta: 0
}, {
  id: 'natural',
  title: 'Natural Titanium',
  tone: 'silver',
  delta: 0
}, {
  id: 'blue',
  title: 'Blue Titanium',
  tone: 'blue',
  delta: 0
}];
const BASE_PRICE = 999;
function ColorSwatch({
  tone,
  large = false
}) {
  const sz = large ? 240 : 34;
  return /*#__PURE__*/React.createElement("div", {
    style: {
      width: sz,
      height: sz,
      borderRadius: large ? 32 : 8,
      background: tone === 'gold' ? 'linear-gradient(160deg,#cbb89a,#7e6647)' : tone === 'silver' ? 'linear-gradient(160deg,#e6e6ea,#b5b5bd)' : tone === 'blue' ? 'linear-gradient(160deg,#728ea6,#2c4356)' : 'linear-gradient(160deg,#3a3a3c,#1d1d1f)',
      boxShadow: large ? 'var(--shadow-product)' : 'none'
    }
  });
}
function BuyPage({
  onAddToBag
}) {
  const [storageId, setStorageId] = useStateBuy('256');
  const [colorId, setColorId] = useStateBuy('desert');
  const storage = STORAGE_OPTIONS.find(s => s.id === storageId);
  const color = COLOR_OPTIONS.find(c => c.id === colorId);
  const total = BASE_PRICE + storage.delta + color.delta;
  const monthly = (total / 36).toFixed(2);
  const stageTone = color.tone;
  return /*#__PURE__*/React.createElement("div", {
    className: "page"
  }, /*#__PURE__*/React.createElement("div", {
    className: "page__inner"
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-text)',
      fontSize: 14,
      color: 'var(--color-ink-muted-48)',
      letterSpacing: '-0.224px'
    }
  }, "iPhone \xA0\u203A\xA0 iPhone 17 Pro \xA0\u203A\xA0 Buy"), /*#__PURE__*/React.createElement("h1", {
    className: "page__title"
  }, "Buy iPhone 17 Pro"), /*#__PURE__*/React.createElement("p", {
    className: "page__lead"
  }, "From $", BASE_PRICE, ".", /*#__PURE__*/React.createElement("br", null), "Or $27.75/mo. for 36 mo.*"), /*#__PURE__*/React.createElement("div", {
    className: "cfg"
  }, /*#__PURE__*/React.createElement("div", {
    className: "cfg__stage"
  }, /*#__PURE__*/React.createElement(ColorSwatch, {
    tone: stageTone,
    large: true
  })), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    className: "cfg__section"
  }, /*#__PURE__*/React.createElement("div", {
    className: "cfg__step"
  }, "Step 1"), /*#__PURE__*/React.createElement("h2", {
    className: "cfg__heading"
  }, "Color. Pick your favorite."), /*#__PURE__*/React.createElement("div", {
    className: "cfg__chips"
  }, COLOR_OPTIONS.map(c => /*#__PURE__*/React.createElement(ConfiguratorChip, {
    key: c.id,
    thumb: /*#__PURE__*/React.createElement(ColorSwatch, {
      tone: c.tone
    }),
    title: c.title,
    selected: colorId === c.id,
    onClick: () => setColorId(c.id)
  })))), /*#__PURE__*/React.createElement("div", {
    className: "cfg__section"
  }, /*#__PURE__*/React.createElement("div", {
    className: "cfg__step"
  }, "Step 2"), /*#__PURE__*/React.createElement("h2", {
    className: "cfg__heading"
  }, "How much storage do you need?"), /*#__PURE__*/React.createElement("div", {
    className: "cfg__chips"
  }, STORAGE_OPTIONS.map(s => /*#__PURE__*/React.createElement(ConfiguratorChip, {
    key: s.id,
    title: s.label,
    subtitle: s.delta === 0 ? 'Included' : `+$${s.delta}`,
    price: s.delta === 0 ? `$${BASE_PRICE}` : `$${BASE_PRICE + s.delta}`,
    selected: storageId === s.id,
    onClick: () => setStorageId(s.id)
  }))))))), /*#__PURE__*/React.createElement("div", {
    className: "fsb-spacer"
  }), /*#__PURE__*/React.createElement(FloatingStickyBar, {
    sku: `iPhone 17 Pro · ${color.title} · ${storage.label}`,
    monthly: `Or $${monthly}/mo. for 36 mo.`,
    price: `$${total.toLocaleString()}.00`,
    onAddToBag: onAddToBag
  }));
}
window.BuyPage = BuyPage;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-store/BuyPage.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-store/ConfiguratorChip.jsx
try { (() => {
/* ConfiguratorChip.jsx — tappable pill in a configurator grid.
   Selected = 2px Focus Blue border. */

function ConfiguratorChip({
  thumb,
  title,
  subtitle,
  price,
  selected,
  onClick
}) {
  return /*#__PURE__*/React.createElement("button", {
    type: "button",
    className: "chip " + (selected ? 'is-selected' : ''),
    onClick: onClick,
    "aria-pressed": !!selected
  }, thumb && /*#__PURE__*/React.createElement("div", {
    className: "chip__thumb"
  }, thumb), /*#__PURE__*/React.createElement("div", {
    className: "chip__info"
  }, /*#__PURE__*/React.createElement("b", null, title), subtitle && /*#__PURE__*/React.createElement("span", null, subtitle)), price && /*#__PURE__*/React.createElement("span", {
    className: "chip__right"
  }, price), selected && /*#__PURE__*/React.createElement("span", {
    className: "chip__check",
    "aria-hidden": "true"
  }, /*#__PURE__*/React.createElement("svg", {
    viewBox: "0 0 16 16",
    width: "14",
    height: "14"
  }, /*#__PURE__*/React.createElement("path", {
    fill: "none",
    stroke: "currentColor",
    strokeWidth: "2",
    strokeLinecap: "round",
    strokeLinejoin: "round",
    d: "M3 8.5l3.5 3.5L13 4.5"
  }))));
}
window.ConfiguratorChip = ConfiguratorChip;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-store/ConfiguratorChip.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-store/FloatingStickyBar.jsx
try { (() => {
/* FloatingStickyBar.jsx — frosted bottom bar that follows scroll.
   Used on the iPhone 17 Pro buy page. */

function FloatingStickyBar({
  sku,
  monthly,
  price,
  onAddToBag
}) {
  return /*#__PURE__*/React.createElement("div", {
    className: "fsb",
    role: "region",
    "aria-label": "Buy bar"
  }, /*#__PURE__*/React.createElement("div", {
    className: "fsb__inner"
  }, /*#__PURE__*/React.createElement("div", {
    className: "fsb__sku"
  }, sku, monthly && /*#__PURE__*/React.createElement("small", null, monthly)), /*#__PURE__*/React.createElement("div", {
    className: "fsb__price"
  }, price), /*#__PURE__*/React.createElement("div", {
    className: "fsb__cta"
  }, /*#__PURE__*/React.createElement(PillButton, {
    variant: "fill",
    onClick: onAddToBag
  }, "Add to Bag"))));
}
window.FloatingStickyBar = FloatingStickyBar;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-store/FloatingStickyBar.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-store/SearchInput.jsx
try { (() => {
/* SearchInput.jsx — pill search */

function SearchInput({
  placeholder = 'Search apple.com',
  value,
  onChange,
  onSubmit
}) {
  return /*#__PURE__*/React.createElement("form", {
    className: "search-input",
    onSubmit: e => {
      e.preventDefault();
      onSubmit && onSubmit(value);
    }
  }, /*#__PURE__*/React.createElement("span", {
    className: "glyph"
  }, /*#__PURE__*/React.createElement("svg", {
    viewBox: "0 0 17 17",
    width: "14",
    height: "14"
  }, /*#__PURE__*/React.createElement("path", {
    fill: "none",
    stroke: "currentColor",
    strokeWidth: "1.5",
    strokeLinecap: "round",
    strokeLinejoin: "round",
    d: "M7.25 1.5a5.75 5.75 0 1 1 0 11.5 5.75 5.75 0 0 1 0-11.5zM11.5 11.5l4 4"
  }))), /*#__PURE__*/React.createElement("input", {
    type: "search",
    placeholder: placeholder,
    value: value || '',
    onChange: e => onChange && onChange(e.target.value)
  }));
}
window.SearchInput = SearchInput;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-store/SearchInput.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-store/StoreSubNav.jsx
try { (() => {
/* StoreSubNav.jsx — Store-flavored sub-nav. Slimmer than the iPhone sub-nav.
   Active category name + horizontal mini-nav of category groupings +
   right-aligned bag glance. */

function StoreSubNav({
  active,
  categories,
  bagCount
}) {
  return /*#__PURE__*/React.createElement("div", {
    className: "ssn"
  }, /*#__PURE__*/React.createElement("div", {
    className: "ssn__inner"
  }, /*#__PURE__*/React.createElement("span", {
    className: "ssn__cat"
  }, "Store"), /*#__PURE__*/React.createElement("span", {
    className: "ssn__links"
  }, categories.map(c => /*#__PURE__*/React.createElement("a", {
    key: c,
    href: "#",
    onClick: e => e.preventDefault(),
    className: active === c ? 'is-active' : ''
  }, c))), /*#__PURE__*/React.createElement("span", {
    className: "ssn__right"
  }, /*#__PURE__*/React.createElement("span", {
    className: "ssn__bag",
    "aria-label": "Bag " + bagCount
  }, /*#__PURE__*/React.createElement("svg", {
    viewBox: "0 0 17 19",
    width: "14",
    height: "16"
  }, /*#__PURE__*/React.createElement("path", {
    fill: "none",
    stroke: "currentColor",
    strokeWidth: "1.4",
    strokeLinecap: "round",
    strokeLinejoin: "round",
    d: "M3 6h11l-.9 11.2a1 1 0 0 1-1 .9H4.9a1 1 0 0 1-1-.9L3 6zM5.5 6V4.25A3 3 0 0 1 8.5 1.25h0a3 3 0 0 1 3 3V6"
  })), /*#__PURE__*/React.createElement("span", null, "Bag\xA0(", bagCount, ")")))));
}
window.StoreSubNav = StoreSubNav;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-store/StoreSubNav.jsx", error: String((e && e.message) || e) }); }

// ui_kits/apple-store/UtilityCard.jsx
try { (() => {
/* UtilityCard.jsx — store / accessories grid cell.
   White, hairline border, radius-lg, centered stack. */

function UtilityCard({
  thumb,
  name,
  price,
  ctaLabel = 'Buy',
  onCta
}) {
  return /*#__PURE__*/React.createElement("article", {
    className: "uc",
    onClick: onCta
  }, /*#__PURE__*/React.createElement("div", {
    className: "uc__thumb"
  }, thumb), /*#__PURE__*/React.createElement("h3", {
    className: "uc__name"
  }, name), /*#__PURE__*/React.createElement("p", {
    className: "uc__price"
  }, price), /*#__PURE__*/React.createElement("a", {
    className: "uc__link",
    href: "#",
    onClick: e => {
      e.preventDefault();
      onCta && onCta();
    }
  }, ctaLabel));
}
window.UtilityCard = UtilityCard;
})(); } catch (e) { __ds_ns.__errors.push({ path: "ui_kits/apple-store/UtilityCard.jsx", error: String((e && e.message) || e) }); }

})();
