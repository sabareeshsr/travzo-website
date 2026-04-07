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
├── home.php               — Blog index (Posts page — requires Settings > Reading setup)
├── archive.php            — Blog category/date archives
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
- Header – Navigation Labels: REMOVED — moved to Travzo Header admin page (admin.php?page=travzo-header-menu)
- Footer Settings: travzo_footer_tagline, travzo_footer_address, travzo_footer_hours, travzo_footer_copyright
- Header - Mega Menu URLs: REMOVED — moved to Travzo Header admin page
- Header - Mega Menu Column Headings: REMOVED — moved to Travzo Header admin page
- Header - Mega Menu Destinations: REMOVED — moved to Travzo Header admin page
- Homepage - Hero Section: MOVED TO META BOX (see _homepage_hero_* below)
- Homepage - Stats Bar: MOVED TO META BOX (see _homepage_stats below)
- Homepage - About Snippet: MOVED TO META BOX (see _homepage_about_* below)
- Homepage - Our Packages Section: MOVED TO TILES META BOX (see _homepage_packages_* below)
- Homepage - Why Choose Us: MOVED TO META BOX (see _homepage_whyus below)
- Homepage - Contact Section: MOVED TO META BOX (see _homepage_contact_* below). Form rendered by theme, AJAX submit
- Homepage - Newsletter: MOVED TO META BOX (see _homepage_newsletter_* below). Form rendered by theme, AJAX submit
- Packages List Page - Hero: travzo_packages_hero_title, travzo_packages_hero_desc etc
- About Page - Hero: MOVED TO PAGE HERO META BOX (see _page_hero_* below)
- About Page - Stats: travzo_about_stat1_number, travzo_about_stat1_label etc
- Contact Page - Hero: MOVED TO PAGE HERO META BOX (see _page_hero_* below)
- FAQ Page - Hero: MOVED TO PAGE HERO META BOX (see _page_hero_* below)
- Media Page - Hero: MOVED TO PAGE HERO META BOX (see _page_hero_* below)
- Blog Page - Hero: MOVED TO PAGE HERO META BOX (see _page_hero_* below)
- WPForms Integration: REMOVED — all forms now use native AJAX submission via travzo_handle_form_submit()

### Page-Specific Content (Meta Boxes)
Visible when editing pages in WP admin.

Homepage (front page):
- _homepage_hero_badge, _homepage_hero_heading, _homepage_hero_subtext, _homepage_hero_btn1_text, _homepage_hero_btn1_url, _homepage_hero_btn2_text, _homepage_hero_btn2_url, _homepage_hero_image
- _homepage_hero_mode: radio — "single" (default) or "slideshow"
- _homepage_hero_slides: JSON array of attachment IDs for slideshow images (wp.media multi-select, sortable)
- _homepage_hero_interval: number 2-30, default 5 — seconds per slide
- _homepage_hero_search_enabled: checkbox — show search bar overlapping hero bottom
- _homepage_hero_search_placeholder: text — placeholder for search input
- _homepage_hero_filters_enabled: array of filter keys (type, region, duration, budget) — which dropdowns to show
- _homepage_about_label, _homepage_about_heading, _homepage_about_description, _homepage_about_keypoints, _homepage_about_image, _homepage_about_btn_text, _homepage_about_btn_url
- _homepage_packages_label, _homepage_packages_heading (saved with tiles nonce)
- _homepage_contact_label, _homepage_contact_heading, _homepage_contact_description, _homepage_contact_hours
- _homepage_newsletter_heading, _homepage_newsletter_subtext
- _homepage_stats: serialized array [ { number, label, sublabel } ] from repeater UI
- _homepage_whyus: serialized array { label, heading, tiles: [ { icon, title, desc } ] } from repeater UI
- _testimonials: serialized array from repeater UI [ { name, trip, quote, rating } ]
- _package_tiles_v2: serialized array of tile objects [ { name, type, region, country, subregion, destination, duration, budget, url, image (attachment ID) } ]
  - Each tile is a flexible filter combination, not locked to a single package type
  - image stores attachment ID (not URL); backward compat: image_url fallback for migrated tiles
  - Count auto-calculated via travzo_tile_count_packages() with 1-hour transient cache
  - URL auto-built via travzo_tile_build_url() if custom url is empty

About Page (template: page-about.php):
- Our Story: _about_story_label, _about_story_heading, _about_story_text, _about_story_keypoints (one per line), _about_story_btn_text, _about_story_btn_url, _about_story_image
- Stats Bar: _about_stats_visible (checkbox), _about_stats (JSON array [{number, label, sublabel}])
- Why Travel With Us: _about_whyus_label, _about_whyus_heading, _about_whyus_tiles (JSON array [{icon, title, desc}])
- Accreditation Partners: _about_accreditation_visible (checkbox), _about_accreditation_label, _about_accreditation_heading, _about_accreditation_partners (JSON array [{name, logo, url}])
- Testimonials: _about_testimonials_label, _about_testimonials_heading, _about_testimonials (JSON array [{name, trip, quote, rating}])
- CTA: _about_cta_visible (checkbox), _about_cta_heading, _about_cta_description, _about_cta_btn1_text, _about_cta_btn1_url, _about_cta_btn2_text, _about_cta_btn2_url

Contact Page (template: page-contact.php):
- Contact Info Card: _contact_info_heading, _contact_info_subtext, _contact_info_address_label, _contact_info_address, _contact_info_phone_label, _contact_info_phone, _contact_info_email_label, _contact_info_email, _contact_info_hours_label, _contact_info_hours, _contact_info_follow_label, _contact_info_show_follow (checkbox)
- Message Form: _contact_form_heading, _contact_form_subtext (form itself via Customizer WPForms)
- Branch Offices: _contact_branches_visible (checkbox), _contact_branches_label, _contact_branches_heading, _contact_branches_subtext, _contact_branches (JSON array [{city, address, phone, email, map_url}])

FAQ Page (template: page-faq.php):
- _faq_categories: serialized array of category names from repeater UI
- _faq_items_v2: serialized array [ { category, question, answer } ] from repeater UI

Page Hero (templates: page-about.php, page-contact.php, page-faq.php, page-media.php + Blog Posts page):
- _page_hero_title: text — overrides the_title() in hero, empty = page title
- _page_hero_subtitle: text — description below title
- _page_hero_image: URL — hero background image

Media Page (template: page-media.php):
- _media_videos: pipe-separated "Title | YouTube URL | Thumbnail URL"
- _media_press: pipe-separated "Publication | Headline | Date | URL"
- _media_awards: pipe-separated "Title | Year | Body | Image URL"

### Package Post Type Fields (Meta Boxes)
Visible when editing any Package post. Each meta box has its own independent nonce.

Package Details (nonce: travzo_package_nonce):
- _package_type: select (canonical values only)
- _pkg_country: select — comprehensive ~195 country list (India at top, alphabetical)
- _pkg_region: auto-computed on save — "domestic" if India, "international" otherwise
- _package_price: number only e.g. 15000 (saved via absint(), displayed with ₹ + number_format)
- _package_duration: text e.g. 4 Nights / 5 Days
- _package_destinations: comma-separated e.g. Ooty, Kodaikanal (commas only, no pipes)
- _package_group_size: text (optional, all types) — leave empty to hide pill on frontend. e.g. 2-15 People
- _package_download_url: URL to PDF

Type-Specific Details (4 independent nonces — one per type):
Conditional fields shown/hidden via jQuery based on _package_type value.

Group Tour fields (nonce: travzo_pkg_group_nonce):
- _pkg_departure_cities: text (comma-separated)
- _pkg_tour_manager: checkbox (Tour Manager Included)
- _pkg_languages: text (comma-separated)

Honeymoon fields (nonce: travzo_pkg_honeymoon_nonce):
- _pkg_couple_inclusions: textarea (one per line)
- _pkg_romantic_activities: textarea (one per line)
- _pkg_privacy_level: select (Standard / Private / Ultra-Private)
- _pkg_suite_type: text

Solo Trip fields (nonce: travzo_pkg_solo_nonce):
- _pkg_age_group: text
- _pkg_safety_rating: select (1–5 scale)
- _pkg_female_friendly: checkbox
- _pkg_mixer_activities: textarea (one per line)
- _pkg_single_room: checkbox

Devotional fields (nonce: travzo_pkg_devotional_nonce):
- _pkg_religion: select (Hinduism / Buddhism / Jainism / Sikhism / Christianity / Islam / Multi-faith)
- _pkg_temples: textarea (one per line)
- _pkg_pujas: textarea (one per line)
- _pkg_dress_code: text
- _pkg_vegetarian: checkbox
- _pkg_priest: select (Included / Available on Request / Not Available)

Package Highlights (nonce: travzo_pkg_highlights_nonce):
- _pkg_highlights: textarea, one highlight per line
- OLD: _pkg_highlights_v2 (JSON array) and _package_highlights (textarea) — auto-migrated on first load

Package Inclusions & Exclusions (nonce: travzo_pkg_content_nonce):
- _package_inclusions: one per line (textarea)
- _package_exclusions: one per line (textarea)

Day by Day Itinerary (nonce: travzo_pkg_itinerary_nonce):
- _pkg_itinerary_v2: JSON array [ { day_title, description } ] from repeater UI
- OLD: _package_itinerary (pipe-separated) — auto-imported on first load

Hotel & Accommodation Details (nonce: travzo_pkg_hotels_nonce):
- _pkg_hotels_v2: JSON array [ { name, stars, location, room_type, image } ] from repeater UI
- OLD: _package_hotels (pipe-separated) — auto-imported on first load

Package Pricing (nonce: travzo_pkg_pricing_nonce):
- _pkg_pricing_visible: checkbox (default checked) — show/hide pricing section on frontend
- _pkg_pricing_note: text — subtitle below "Package Pricing" heading
- _pkg_pricing_recommended: select (None / Standard / Deluxe / Premium) — which tier gets "Recommended" badge
- _price_standard_twin, _price_standard_triple, _price_standard_single
- _price_deluxe_twin, _price_deluxe_triple, _price_deluxe_single
- _price_premium_twin, _price_premium_triple, _price_premium_single
- _price_child_bed, _price_child_no_bed
- All prices saved via absint(), displayed with ₹ + number_format()
- Single room column only shows if any single price is set

Important Information (nonce: travzo_pkg_important_info_nonce):
- _pkg_important_info_visible: checkbox (default checked)
- _pkg_important_info_heading: text (default "Important Information")
- _pkg_important_info: JSON array [ { title, content } ] from repeater UI
- Content supports HTML (sanitized via wp_kses_post)
- Default 5 items on first load: Cancellation Policy, Payment Terms, Visa Info, Things to Carry, Important Notes
- Frontend falls back to hardcoded defaults if meta is empty

Photo Gallery (nonce: travzo_pkg_gallery_nonce):
- _pkg_gallery: JSON array of attachment IDs from wp.media multi-select
- Admin: sortable thumbnail grid, wp.media picker, hidden JSON input
- Frontend: 4-col grid (3-col tablet, 2-col mobile), aspect-square, click opens lightbox

Package Flags (sidebar, nonce: travzo_flags_nonce):
- _is_trending: checkbox — shows on homepage trending section

### Package Destination Taxonomy
Hierarchical taxonomy `package_destination` registered on `package` CPT.
3-level hierarchy auto-assigned on save_post_package (priority 30):

Level 1 (master categories): Group Tour, Honeymoon, Devotional, Solo Trip, Destination Wedding
Level 2 (under each): India, International
Level 3 (under India): North India, South India, East India, West India, Northeast India, Himalayas
Level 3 (under International): Southeast Asia, East Asia, Middle East, Europe, Americas, Africa, Oceania

Terms seeded on theme activation (after_switch_theme) and admin_init (once, tracked via option).
Auto-assignment reads _package_type, _pkg_country, _package_destinations to determine terms.
"International" package type has no taxonomy term (skipped).

### Admin Package Filters
- restrict_manage_posts: Package Type + Region dropdowns on Packages list
- pre_get_posts: Applies meta_query filters for admin list

### Blog Post Fields
- _is_featured_blog: checkbox — shows in homepage blog section

## Helper Functions
travzo_get($key, $fallback)                              — Get customizer value with fallback
travzo_parse_lines($text, $n)                            — Parse pipe-separated textarea into array
travzo_render_form($html)                                — Output form HTML (no plugin dependency)
travzo_default_enquiry_form()                            — Returns homepage enquiry form HTML (AJAX)
travzo_default_package_form($id)                         — Returns package sidebar enquiry form HTML (AJAX)
travzo_handle_form_submit()                              — AJAX handler: CAPTCHA, validates, emails via wp_mail(), stores in form_submission CPT
travzo_get_forms_settings()                              — Get travzo_forms_settings option with defaults
travzo_render_captcha()                                  — Output CAPTCHA widget (math/reCAPTCHA v2/v3) based on settings
travzo_render_email_template($key, $data, $type)         — Replace placeholders in email template, returns ['subject','body']
travzo_render_mega_col($heading_key, $items_key, $url, $text) — Render a mega menu destination column from customizer textarea; items one per line, optional URL via pipe separator
travzo_get_countries()                                   — Returns ~195 country list (India first, alphabetical, filterable)
travzo_get_country_continent_map()                       — Maps international countries to continent/sub-region
travzo_get_india_region_map()                            — Maps Indian cities/states to India sub-regions
travzo_detect_india_subregion($destinations_str)         — Returns first matching India sub-region from comma-separated destinations
travzo_tile_count_packages($filters)                     — Count published packages matching tile filter combo (type/region/country/subregion/destination/duration/budget); 1-hour transient cache
travzo_tile_build_url($filters)                          — Build packages archive URL from tile filter values, only includes non-empty params
travzo_duplicate_package($post_id)                       — Clone a package post with all meta + taxonomy terms; returns new post ID (draft, title + " (Copy)")
travzo_get_menu_items()                                  — Get main menu items from travzo_main_menu option (with defaults fallback)
travzo_fetch_menu_packages($mega)                        — Fetch packages for mega menu auto-fetch column; 1-hour transient cache
travzo_mega_viewmore_url($mega)                          — Build View More URL from mega menu filter values

### Dynamic Header Menu System
- Admin page: Travzo Header (top-level menu, dashicons-menu-alt, position 25, manage_options capability)
- Option key: travzo_main_menu (JSON array of menu items)
- Each item: label, url, visible, has_mega, mega config (auto_fetch filters, custom links, view more buttons)
- Auto-fetch uses travzo_fetch_menu_packages() with WP_Query + transient cache
- Save via admin-post action: travzo_save_header_menu
- header.php reads travzo_get_menu_items() for both desktop nav and mobile drawer
- Mega menu columns: 1col (auto only or custom only) or 2col (both)
- Existing mega-panel CSS reused; added mega-panel--1col and mega-panel--2col grid rules

### Form System (Travzo Forms)
- Admin page: Travzo Forms (top-level menu, dashicons-feedback, position 27)
- Option key: travzo_forms_settings (serialized array)
- 3 tabs: General Settings (CAPTCHA), Email Recipients, Email Templates
- CAPTCHA types: Math (no dependency), reCAPTCHA v2 (checkbox), reCAPTCHA v3 (invisible)
- Per-form recipients: contact, enquiry, package_enquiry, newsletter
- Global: CC, BCC, From Email, From Name, auto-reply toggle
- Email templates with placeholders: {full_name}, {email}, {all_fields}, {site_name}, etc.
- Submissions stored as form_submission CPT with _form_type and _submitted_data meta
- CSV export from Form Submissions list with form type + date range filters
- Forms rendered by theme HTML, submitted via AJAX to travzo_handle_form_submit()

### Duplicate Package Feature
- Row action "Duplicate" on Packages list (between Edit and Trash)
- "Duplicate this Package" button in Publish box on edit screen
- Clones all post meta (except _edit_lock/_edit_last), all taxonomy terms, featured image
- New post created as draft with " (Copy)" title suffix
- Nonce: travzo_duplicate_package_{post_id}
- Admin-post action: travzo_duplicate_package
- Success notice shown on the new draft's edit screen

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

## Blog Page — WordPress Setup Required
The blog archive page (home.php) requires WordPress to have a "Posts page" configured:
1. Go to **Pages → Add New**, create a page titled "Blog" (leave content empty), publish it
2. Go to **Settings → Reading**
3. Set "Posts page" to the Blog page just created
This makes WordPress load home.php for the blog listing URL instead of index.php.

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
| 8 | Blog newsletter hardcoded | Fixed | archive.php uses native AJAX form |
| 9 | Customizer naming conflict address/hours | Fixed | Clear separation in footer.php and page-contact.php |
| 10 | Our Packages section labels hardcoded | Fixed | Customizer travzo_packages_section |
| 11 | Package detail page content overlap with hero | Fixed | z-index stacking in main.css (.package-layout z-index:10) |
| 12 | Footer customizer fields showing empty | Fixed | functions.php — added defaults + transport:refresh to all footer/contact/header settings |
| 13 | Header nav labels not editable by client | Fixed | Customizer travzo_nav_labels section + header.php wired |
| 14 | Blog page showing raw content (no home.php) | Fixed | Created home.php — WordPress blog index template |
| 15 | Blog page needs Posts page set in Reading settings | Documented | See Blog Page Setup section above |
| 16 | Mega menu showing same packages across all types (LIKE vs =) | Fixed | header.php — compare changed to = for all 5 menus |
| 17 | Mobile drawer had hardcoded destination lists | Fixed | header.php — dynamic WP_Query for all 5 accordion panels |
| 18 | Why Choose Us was customizer textarea (error-prone) | Fixed | Moved to meta box repeater UI with icon/title/desc fields |
| 19 | Stats Bar was in customizer (inconvenient) | Fixed | Moved to meta box repeater UI with number/label/sublabel fields |
| 20 | About Snippet was in customizer | Fixed | Moved to meta box with individual fields + image upload + key points textarea |
| 21 | Hero Section was in customizer | Fixed | Moved to meta box with text fields + image upload, nl2br for heading |
| 22 | Contact Section text was hardcoded + customizer | Fixed | Moved text to meta box; form ID stays in Customizer → WPForms |
| 23 | FAQ meta box was pipe-separated textarea, never saved (nonce bug) | Fixed | Proper repeater UI with categories + items, independent nonces |
| 24 | Our Packages label/heading in customizer | Fixed | Moved into existing Package Tiles meta box, saved with tiles nonce |
| 25 | Newsletter heading/subtext in customizer | Fixed | Moved to own meta box, form ID stays in Customizer → WPForms |
| 26 | Page heroes (About/Contact/FAQ/Media/Blog) in customizer | Fixed | Moved to reusable Page Hero meta box with _page_hero_* keys |
| 27 | About page had single meta box with pipe-separated fields | Fixed | Restructured into 6 dedicated meta boxes matching frontend sections |
| 28 | Contact page had pipe-separated branch offices textarea | Fixed | Restructured into 3 meta boxes (Info Card, Form Section, Branch Offices repeater) |
| 29 | Package itinerary/hotels used pipe-separated textarea | Fixed | Repeater UIs with _pkg_itinerary_v2 and _pkg_hotels_v2 JSON arrays |
| 30 | Package highlights used plain textarea | Fixed | Repeater UI with _pkg_highlights_v2 JSON array |
| 31 | Package had no Country/Region field | Fixed | _pkg_country dropdown + auto-computed _pkg_region, Region filter on archive |
| 32 | Package prices stored without validation, displayed raw | Fixed | absint() on save, number_format() with ₹ on all frontend displays |
| 33 | Package save handler used single nonce for all fields | Fixed | Independent nonces per meta box (details, highlights, content, itinerary, hotels, pricing) |
| 34 | No type-specific fields (Group Tour, Honeymoon, Solo, Devotional) | Fixed | Conditional meta box with jQuery show/hide per package type + independent nonce |
| 35 | No hierarchical destination taxonomy | Fixed | package_destination taxonomy (3 levels), auto-assigned on save |
| 36 | Pricing section always shown, no recommended tier control, no single room | Fixed | Visibility toggle, recommended dropdown, single room prices, dynamic pricing table |
| 37 | Important Information accordion hardcoded | Fixed | Editable repeater meta box, visibility toggle, custom heading, wp_kses_post content |
| 38 | Package archive had no search bar, limited filters | Fixed | 4-row filter bar (search, 7 filters, chips, sort), debounced search, admin filters |
| 39 | No admin-side package filters | Fixed | restrict_manage_posts + pre_get_posts for Type and Region |
| 40 | Type-specific details not rendering on frontend | Fixed | switch/case in single-package.php with pkg-type-card |
| 41 | "Package Overview" heading showing empty content | Fixed | Removed heading, content conditional on non-empty |
| 42 | Active tab has no visual indicator | Fixed | Inactive gray/muted, active navy+gold underline |
| 43 | No admin upload for Photo Gallery | Fixed | wp.media meta box + _pkg_gallery + lightbox frontend |
| 44 | Package tiles locked to single type, no flexible filters | Fixed | 10-field tile config (type/region/country/subregion/destination/duration/budget/url/image), collapsible cards, transient-cached counts |
| 45 | No way to duplicate/clone a package | Fixed | Duplicate action in row actions + edit screen, copies all meta + taxonomies, creates draft |
| 46 | Homepage hero only supports single image | Fixed | Added slideshow mode with multi-image, arrows, dots, auto-advance, touch swipe |
| 47 | Slideshow arrows not clickable (z-index stacking context bug) | Fixed | Moved arrows/dots outside .hero-slideshow to be direct children of .hero-section; z-index 5 |
| 48 | Hero too tall (95vh), not compact like Thomas Cook | Fixed | Reduced to 60vh/480px-600px, smaller heading/badge/gaps |
| 49 | No search/filter bar in homepage hero | Fixed | Optional search bar with configurable filters, overlaps into next section |
| 50 | Hero full-width and too thin/letterbox | Fixed | Contained rounded rectangle with .hero-wrapper padding, border-radius 24px, box-shadow, 70vh/540-680px |
| 51 | Header nav hardcoded, not editable by admin | Fixed | Dynamic menu system via travzo_main_menu option, admin page under Appearance → Travzo Header |

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
