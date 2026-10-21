# Pawtrait WordPress development

The current WordPress source lives in `wp-content/themes/pawtrait-phase1` and `wp-content/mu-plugins`. The root `dist/` remains the older static site; it does not preview this WordPress theme.

Requires WordPress 7.1.3, WooCommerce, and PHP 8.2 (the versions in the existing Local site). Copy the theme and mu-plugin into the matching WordPress directories, activate Pawtrait Phase One, and restore a local database backup for pages, products and settings. Private uploads and wp-config.php are intentionally excluded from GitHub.

## Modules

- `template-parts/home/hero.php`: introduction and primary action.
- `template-parts/home/collection.php`: four collection entry points.
- `template-parts/home/help.php`: shopping help links.
- `inc/navigation.php`: dropdown labels and destination groups.
- `header.php`, `footer.php`: shared site frame.
- `assets/store.js`: menu, disclosure and keyboard behavior.
- `style.css`: shared styling and responsive layout.

`front-page.php` composes the homepage modules. Story, design, signup and detailed help remain reachable on their existing pages. No product, checkout or release logic was changed.

## Demo workflow

Preserve the original on `snapshot/wordpress-2026-10-21`. Start each requested design change on a new `demo/<change>-<date>` branch, commit the complete module changes, and open a draft pull request before merging. Do not overwrite previous demo branches or change main automatically. Branches version the source; this repository currently has no hosted WordPress preview deployment.

The first redesign is `demo/simpler-homepage-2026-10-21`; view it on the Local development site at http://pawtrait-dev.local after copying its theme files. A local-only backup of the original files and database is stored separately; do not commit it to GitHub.
