# Travzo Holidays — WordPress Theme

Custom WordPress theme for Travzo Holidays travel agency.

## Quick Start for Developers

1. Clone the repo
2. Zip the travzo-theme folder
3. Upload to WordPress via Appearance → Themes → Upload Theme
4. Activate the theme
5. Go to Appearance → Customize → Travzo Settings to configure

## For Content Editors (No Code Required)

### Editing Site-Wide Content
Go to **Appearance → Customize → Travzo Settings**

You will find sections for:
- Contact details (phone, email, WhatsApp, address, hours)
- Social media links
- Header utility bar text
- Footer content
- All homepage sections (hero, stats, packages, why us, newsletter etc)
- All page hero sections
- WPForms integration (enter form IDs after creating forms in WPForms)

### Adding a New Package
1. Go to **Packages → Add New** in the left sidebar
2. Enter the package name as the title
3. Add the main package description in the editor
4. Scroll down to fill in Package Details (type, price, duration etc)
5. Fill in Package Content (highlights, itinerary, hotels etc)
6. Fill in Package Pricing table
7. Set Featured Image for the package hero photo
8. Check "Show as Trending Package" in Package Flags to feature it on homepage
9. Click Publish

**Itinerary format:** One day per line: `Day Title | Description of activities`
Example: `Arrival Day | Arrive at Ooty, check in to hotel, welcome dinner`

**Hotels format:** One hotel per line: `Hotel Name | Stars | Location | Room Type`
Example: `Savoy Hotel | 5 | Ooty Town Centre | Deluxe Twin Room`

### Adding a Blog Post
1. Go to **Posts → Add New**
2. Write your article
3. Set a Featured Image
4. Check "Feature this blog on Homepage" to show it in the homepage blog section
5. Click Publish

### Editing Homepage Package Tiles
1. Go to **Pages → Home → Edit**
2. Scroll down to **Homepage - Package Tiles** meta box
3. Edit tile names, select package type (count is auto-fetched)
4. Upload background images
5. Add or remove tiles using the buttons
6. Click Update

### Editing Testimonials
1. Go to **Pages → Home → Edit**
2. Scroll down to **Homepage - Testimonials** meta box
3. One testimonial per line: `Customer Name | Trip Taken | Quote text`
4. Click Update

### Setting Up WPForms
1. Install and activate WPForms Lite plugin
2. Go to WPForms → Add New and create your forms
3. Note the form ID (shown in the forms list)
4. Go to Appearance → Customize → Travzo Settings → WPForms Integration
5. Enter the form IDs for each form type
6. Click Publish

### Editing Navigation Menus
1. Go to **Appearance → Menus**
2. Create or edit a menu
3. Assign it to "Primary Navigation" or "Footer Navigation"

## Plugin Requirements
- **None required** — the theme works without any plugins
- **Optional:** WPForms Lite — for advanced form management with captcha

## Theme Files Reference
See CLAUDE.md for complete technical documentation.
