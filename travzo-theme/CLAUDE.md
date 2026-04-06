# Travzo Holidays — WordPress Theme Development Guardrails

## Project Overview
Custom WordPress theme for Travzo Holidays, a travel agency based in 
Tamil Nadu, India. The theme is plugin-free (except optional WPForms) 
and uses WordPress native systems only.

## Tech Stack
- WordPress custom theme (no page builders)
- Native WordPress Customizer for site-wide settings
- Native WordPress Meta Boxes for page/post content
- Custom Post Type: package
- No ACF, no Elementor, no page builder plugins
- CSS variables for all colours and tokens
- Vanilla JS only (no jQuery dependency in frontend)

## Brand Colours
--navy:      #1A2A5E  (primary)
--gold:      #C9A227  (accent)
--white:     #FFFFFF
--off-white: #F5F5F5
--text-dark: #1A1A1A
--text-muted:#6B7280
--border:    #E5E7EB

## Typography
- Headings: Playfair Display (serif)
- Body: Inter (sans-serif)
- Nav/Labels: Raleway (sans-serif)

## File Structure
travzo-theme/
├── style.css              — Theme header only
├── functions.php          — ALL PHP logic (customizer, meta boxes, CPT, helpers)
├── header.php             — Site header with mega menu
├── footer.php             — Site footer
├── front-page.php         — Homepage (set via Settings > Reading)
├── archive-package.php    — Package listing with filters
├── single-package.php     — Individual package detail
├── archive.php            — Blog listing
├── single.php             — Blog post detail
├── page-about.php         — About page (Template Name: About Page)
├── page-contact.php       — Contact page (Template Name: Contact Page)
├── page-faq.php           — FAQ page (Template Name: FAQ Page)
├── page-media.php         — Media page (Template Name: Media Page)
├── 404.php                — 404 error page
├── assets/css/main.css    — All styles
├── assets/js/main.js      — All JavaScript
└── CLAUDE.md              — This file

## Package Type Values — CANONICAL LIST
These are the ONLY valid values for _package_type meta field.
Use these EXACTLY everywhere — in meta boxes, queries, filters, URLs.
NEVER add or remove an S. NEVER change capitalisation.

- Group Tour
- Honeymoon
- Solo Trip
- Devotional
- Destination Wedding
- International

## Content Architecture

### Site-Wide Settings (Customizer)
Go to: Appearance → Customize → Travzo Settings

Sections:
- Contact Information: travzo_phone, travzo_email, travzo_whatsapp, travzo_address, travzo_hours
- Social Media Links: travzo_instagram, travzo_facebook, travzo_youtube
- Header Settings: travzo_utility_text
- Footer Settings: travzo_footer_tagline, travzo_footer_address, travzo_footer_hours, travzo_footer_copyright
- Header - Mega Menu URLs: travzo_menu_group_all, travzo_menu_honeymoon_all etc
- Homepage - Hero Section: travzo_hero_badge, travzo_hero_heading etc
- Homepage - Stats Bar: travzo_stat_1_number, travzo_stat_1_label (x4)
- Homepage - About Snippet: travzo_about_label, travzo_about_heading etc
- Homepage - Our Packages Section: travzo_packages_label, travzo_packages_heading
- Homepage - Why Choose Us: travzo_why_us_label, travzo_why_us_heading, travzo_why_us_tiles
- Homepage - Contact Section: travzo_contact_label, travzo_contact_heading, travzo_contact_desc
- Homepage - Newsletter: travzo_newsletter_heading, travzo_newsletter_subtext
- Packages List Page - Hero: travzo_packages_hero_title, travzo_packages_hero_desc etc
- About Page - Hero: travzo_about_hero_title, travzo_about_hero_desc, travzo_about_hero_image
- About Page - Stats: travzo_about_stat1_number, travzo_about_stat1_label etc
- Contact Page - Hero: travzo_contact_hero_title etc
- FAQ Page - Hero: travzo_faq_hero_title etc
- Media Page - Hero: travzo_media_hero_title etc
- Blog Page - Hero: travzo_blog_hero_title etc
- WPForms Integration: travzo_form_contact, travzo_form_enquiry, travzo_form_newsletter, travzo_form_package

### Page-Specific Content (Meta Boxes)
Visible when editing pages in WP admin.

Homepage (front page):
- _testimonials: pipe-separated textarea "Name | Trip | Quote"
- _package_tiles_v2: serialized array from repeater UI

About Page (template: page-about.php):
- _about_story_heading, _about_story_text, _about_story_image
- _about_team: pipe-separated "Name | Role | Photo URL | Bio"
- _about_awards: pipe-separated "Award Name | Year | Image URL"
- _about_accreditations: pipe-separated "Name | Logo URL"

Contact Page (template: page-contact.php):
- _branches: pipe-separated "City | Address | Phone"

FAQ Page (template: page-faq.php):
- _faqs: pipe-separated "Question | Answer"

Media Page (template: page-media.php):
- _media_videos: pipe-separated "Title | YouTube URL | Thumbnail URL"
- _media_press: pipe-separated "Publication | Headline | Date | URL"
- _media_awards: pipe-separated "Title | Year | Body | Image URL"

### Package Post Type Fields (Meta Boxes)
Visible when editing any Package post.

Package Details:
- _package_type: select (canonical values only)
- _package_price: number only e.g. 15000
- _package_duration: text e.g. 4 Nights / 5 Days
- _package_destinations: comma-separated e.g. Ooty, Kodaikanal
- _package_group_size: text e.g. 2-15 People

Package Content:
- _package_highlights: one per line
- _package_inclusions: one per line
- _package_exclusions: one per line
- _package_itinerary: one day per line "Day Title | Description"
- _package_hotels: one per line "Hotel Name | Stars | Location | Room Type"
- _package_download_url: URL to PDF

Package Pricing:
- _price_standard_twin, _price_standard_triple
- _price_deluxe_twin, _price_deluxe_triple
- _price_premium_twin, _price_premium_triple
- _price_child_bed, _price_child_no_bed

Package Flags (sidebar):
- _is_trending: checkbox — shows on homepage trending section

### Blog Post Fields
- _is_featured_blog: checkbox — shows in homepage blog section

## Helper Functions
travzo_get($key, $fallback)     — Get customizer value with fallback
travzo_parse_lines($text, $n)   — Parse pipe-separated textarea into array
travzo_get_hero($post_id)       — Get hero image/heading/subtext from post meta
travzo_render_form($key, $html) — Render WPForms shortcode or fallback HTML
travzo_default_enquiry_form()   — Returns default enquiry form HTML
travzo_default_package_form($id)— Returns default package enquiry form HTML

## Development Rules — READ BEFORE EVERY CHANGE

### Rule 1 — Package Types
ALWAYS use the canonical package type values (see above).
NEVER use plural forms in meta values or query arguments.
Display labels can be plural (Group Tours) but stored values must be singular (Group Tour).

### Rule 2 — No Hardcoding
Never hardcode content that an admin should control.
If it is text visible to site visitors it must come from:
- Customizer (site-wide settings)
- Post meta (page or post specific content)
- WP_Query (dynamic data from posts)

### Rule 3 — Fallbacks Always
Every get_theme_mod() and get_post_meta() call must have a 
sensible fallback value so the site never shows blank content.

### Rule 4 — CSS Changes
All colours must use CSS variables from :root.
Never hardcode hex colours in CSS.
Never use !important unless fixing a specific known conflict.
Mobile breakpoints: 1024px (tablet), 768px (mobile), 480px (small mobile).

### Rule 5 — JavaScript
No jQuery on the frontend.
All JS goes in assets/js/main.js.
Use event delegation for dynamically added elements.
Always check if element exists before adding event listeners.

### Rule 6 — Security
Always use wp_nonce_field() and wp_verify_nonce() for all forms.
Always sanitize inputs: sanitize_text_field(), sanitize_email(), esc_url_raw().
Always escape outputs: esc_html(), esc_attr(), esc_url().

### Rule 7 — Surgical Changes Only
When fixing a bug, change only what is broken.
Do not rewrite entire files for a small fix.
Read the relevant section first, then make the minimal change.

### Rule 8 — Test Before Reporting Done
After making changes verify:
- No PHP syntax errors (check for unclosed tags, missing semicolons)
- All get_theme_mod() keys match exactly what is registered in customize_register
- All get_post_meta() keys match exactly what is saved in save_post hooks
- Package type values match canonical list

## Known Issues Log
Track bugs and fixes here as they are resolved.

| # | Issue | Status | Fixed In |
|---|-------|--------|----------|
| 1 | Package type filter broken (plural vs singular) | Fixed | functions.php, archive-package.php, front-page.php |
| 2 | Hero search bar awkward | Removed | front-page.php |
| 3 | Package tiles using pipe format | Fixed | Proper repeater UI in meta box |
| 4 | About page stats hardcoded | Fixed | Customizer travzo_about_stats section |
| 5 | Footer package links all href=# | Fixed | Dynamic URLs in footer.php |
| 6 | Nav menu not using wp_nav_menu | Partial | Mega menu stays custom, note added to customizer |
| 7 | Individual package page overlap | Fixed | CSS padding fix in main.css |
| 8 | Blog newsletter hardcoded | Fixed | archive.php uses travzo_render_form |
| 9 | Customizer naming conflict address/hours | Fixed | Clear separation in footer.php and page-contact.php |
| 10 | Our Packages section labels hardcoded | Fixed | Customizer travzo_packages_section |

## Deployment
- Hosting: Hostinger WordPress
- Domain: travzoholidays.com
- GitHub: https://github.com/sabareeshsr/travzo-website
- Branch: main
- Deploy method: Zip theme → WP Admin → Appearance → Themes → Upload

## Git Commit Convention
feat: description — new feature
fix: description  — bug fix
style: description — CSS only change
content: description — content/copy change
refactor: description — code restructure, no behaviour change
