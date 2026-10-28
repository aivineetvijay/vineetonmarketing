# UTM Builder

Free UTM builders on vineetonmarketing.com, under AI Tools:

| Builder | URL |
|---|---|
| UTM Builder (basic, the hub) | `/ai-tools/utm-builder/` |
| Healthcare | `/ai-tools/utm-builder/healthcare/` |
| Ecommerce | `/ai-tools/utm-builder/ecommerce/` |
| Real estate | `/ai-tools/utm-builder/real-estate/` |
| Travel & tourism | `/ai-tools/utm-builder/travel-tourism/` |
| B2B | `/ai-tools/utm-builder/b2b/` |

Each builder builds the link as you type, predicts the GA4 default channel group, checks for common mistakes (missing tags, PII, uppercase, `meta` as a source, click IDs, long links), imports tags from a pasted URL, adds platform macros (Google Ads ValueTrack, Meta, TikTok), copies the link or the tags, makes a QR code and keeps a recent-links list in the visitor's browser. Industry builders add channel presets and a campaign naming convention. Nothing is sent anywhere.

## Files

```
src/configs.js   builder definitions: presets, conventions, copy, FAQs   ← edit this
src/engine.js    the builder UI and logic (shared by every builder)
src/ga4.js       GA4 default channel group rules (browser and build.mjs)
src/qrcode.js    QR code generator (qrcode-generator, MIT, Kazuhiko Arase)
page.js          picks the builder for the page and starts the engine; copy-brief button
utm.css          styles, scoped to the tool (.vvu / #utm-app)
build.mjs        builds pages.json from src/configs.js
pages.json       page copy for each builder (generated: run build.mjs)
install.php      server installer (files, mu-plugin, pages, Rank Math meta)
```

The mu-plugin that renders the pages inside the theme is `wordpress/mu-plugins/vv-utm.php`.

## How the pages work

Each builder is a WordPress page with post meta `vv_utm` set to the builder id. `vv-utm.php` draws the page between the theme header and footer: the hero, the builder tabs, the builder (`#utm-app`, filled in by `engine.js`) and the guide below it. The guide comes from `pages.json`, so it is in the HTML that search engines read. `{{YYYYMM}}` in the guide becomes the current month when the page is served.

Scripts load deferred in this order: `configs.js` (wrapped so its definitions stay out of the global scope), `ga4.js`, `qrcode.js`, `page.js`, `engine.js`. `utm.css` is printed inline in the head.

Rank Math handles the title, description, robots, breadcrumbs and sitemap. FAQPage schema comes from the `vv_faq` post meta (`vv-schema.php`); `vv-utm.php` adds WebApplication schema.

## Changing a builder

1. Edit `src/configs.js` (copy, presets, conventions or FAQs).
2. Run `node build.mjs` to rebuild `pages.json`.
3. Commit, then run the body of `install.php` through Novamira execute-php with `$vv_base` set to the raw GitHub URL of `wordpress/` at that commit.

To add a builder, copy one of the industry objects in `src/configs.js`, change `id`, `slug`, `nav`, the copy, `channels`, `campaign` and `content`, add it to the `builders` array and add its audience line to `AUDIENCE` in `build.mjs`. The installer creates its page.

## Design

The page uses the site's own patterns: the standard hero (meta strip, large headline with an italic tail, lead and pill buttons), then numbered sections with alternating white, parchment and black backgrounds (the builder, the basics, why it matters, how it works, cheat sheet, tips, the developer brief, questions, more builders). The builder itself comes from the Apple design system mock-up (`UTM Builder.html`): a two-column form with a sticky "Your link" panel. Industry builders show only the required campaign parts and the formatting rules; the basic builder also shows the extra GA4 fields.

## Accessibility

- One screen-reader live region (`#live`). The link preview is not a live region: after typing pauses (1.5 s) the engine announces one short summary ("Link updated. GA4 channel: Paid Search. No issues found."), and only when it changed. Copy, import, macros and clearing announce their result once.
- Builder tabs are links with `aria-current="page"`; channel chips use `aria-pressed`; the QR button uses `aria-expanded` and `aria-controls`.
- Decorative arrows in buttons are `aria-hidden`.

## Notes

- The GA4 prediction uses Google's rule order and a practical subset of its source lists, so treat it as a close prediction rather than a guarantee.
- `qr` and `syndication` mediums deliberately show as Unassigned; the tool tells users to add a custom channel group rule.
