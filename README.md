# Vineet on Marketing — website

Static website exported from Claude Design. It will later be converted into a WordPress theme.

## Structure

| Path | Contents |
|---|---|
| `*.html` | Site pages (`index.html` is the home page) |
| `Mobile Preview.html` | Design preview showing the pages in a phone frame |
| `css/` | Stylesheets (`colors_and_type.css` design tokens, `site.css` layout) |
| `js/` | Shared React components (`Shared.jsx`) and image helper (`image-slot.js`) |
| `assets/` | Headshot and icons used by the pages |
| `design-reference/` | Screenshots, profile image and resume used while designing; not loaded by the site |

## Preview locally

Open `index.html` in a browser, or run `python3 -m http.server` in this folder and visit http://localhost:8000.
