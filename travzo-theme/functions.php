<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// ══════════════════════════════════════════════════════════════════════════════
// ENQUEUE SCRIPTS & STYLES
// ══════════════════════════════════════════════════════════════════════════════
function travzo_enqueue_scripts() {
    wp_enqueue_style(
        'travzo-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );

    $main_css = get_template_directory() . '/assets/css/main.css';
    wp_enqueue_style(
        'travzo-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        file_exists( $main_css ) ? filemtime( $main_css ) : '1.0.0'
    );

    $main_js = get_template_directory() . '/assets/js/main.js';
    if ( file_exists( $main_js ) ) {
        wp_enqueue_script(
            'travzo-main-script',
            get_template_directory_uri() . '/assets/js/main.js',
            array(),
            filemtime( $main_js ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'travzo_enqueue_scripts' );

// ══════════════════════════════════════════════════════════════════════════════
// THEME SUPPORT
// ══════════════════════════════════════════════════════════════════════════════
function travzo_theme_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ] );

    register_nav_menus( [
        'primary-menu' => __( 'Primary Menu', 'travzo' ),
        'footer-menu'  => __( 'Footer Menu', 'travzo' ),
        'footer-legal' => __( 'Footer Legal Links', 'travzo' ),
    ] );
}
add_action( 'after_setup_theme', 'travzo_theme_setup' );

// ══════════════════════════════════════════════════════════════════════════════
// IMAGE SIZES
// ══════════════════════════════════════════════════════════════════════════════
function travzo_add_image_sizes() {
    add_image_size( 'package-card', 600, 400, true );
    add_image_size( 'package-hero', 1440, 600, true );
}
add_action( 'after_setup_theme', 'travzo_add_image_sizes' );

// ══════════════════════════════════════════════════════════════════════════════
// WIDGET AREAS
// ══════════════════════════════════════════════════════════════════════════════
function travzo_register_widgets() {
    register_sidebar( [
        'name'          => __( 'Sidebar', 'travzo' ),
        'id'            => 'sidebar',
        'description'   => __( 'Main sidebar widget area.', 'travzo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );

    register_sidebar( [
        'name'          => __( 'Footer Widgets', 'travzo' ),
        'id'            => 'footer-widgets',
        'description'   => __( 'Footer widget area.', 'travzo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
}
add_action( 'widgets_init', 'travzo_register_widgets' );

// ══════════════════════════════════════════════════════════════════════════════
// CUSTOM POST TYPE: PACKAGE
// ══════════════════════════════════════════════════════════════════════════════
function travzo_register_package_cpt() {
    $labels = [
        'name'               => __( 'Packages', 'travzo' ),
        'singular_name'      => __( 'Package', 'travzo' ),
        'add_new'            => __( 'Add New', 'travzo' ),
        'add_new_item'       => __( 'Add New Package', 'travzo' ),
        'edit_item'          => __( 'Edit Package', 'travzo' ),
        'new_item'           => __( 'New Package', 'travzo' ),
        'view_item'          => __( 'View Package', 'travzo' ),
        'search_items'       => __( 'Search Packages', 'travzo' ),
        'not_found'          => __( 'No packages found', 'travzo' ),
        'not_found_in_trash' => __( 'No packages found in trash', 'travzo' ),
        'menu_name'          => __( 'Packages', 'travzo' ),
    ];

    register_post_type( 'package', [
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'rewrite'      => [ 'slug' => 'packages' ],
        'show_in_rest' => true,
    ] );
}
add_action( 'init', 'travzo_register_package_cpt' );

// ══════════════════════════════════════════════════════════════════════════════
// HIERARCHICAL TAXONOMY: PACKAGE DESTINATION
// Level 1: Package types (Group Tour, Honeymoon, etc.)
// Level 2: India / International (under each type)
// Level 3: Sub-regions (North India, South India... / Southeast Asia, Europe...)
// ══════════════════════════════════════════════════════════════════════════════
function travzo_register_package_destination_taxonomy() {
    $labels = [
        'name'              => __( 'Destination Categories', 'travzo' ),
        'singular_name'     => __( 'Destination Category', 'travzo' ),
        'search_items'      => __( 'Search Destination Categories', 'travzo' ),
        'all_items'         => __( 'All Destination Categories', 'travzo' ),
        'parent_item'       => __( 'Parent Category', 'travzo' ),
        'parent_item_colon' => __( 'Parent Category:', 'travzo' ),
        'edit_item'         => __( 'Edit Destination Category', 'travzo' ),
        'update_item'       => __( 'Update Destination Category', 'travzo' ),
        'add_new_item'      => __( 'Add New Destination Category', 'travzo' ),
        'new_item_name'     => __( 'New Destination Category Name', 'travzo' ),
        'menu_name'         => __( 'Destinations', 'travzo' ),
    ];

    register_taxonomy( 'package_destination', 'package', [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'destination', 'hierarchical' => true ],
        'query_var'         => true,
    ] );
}
add_action( 'init', 'travzo_register_package_destination_taxonomy' );

/**
 * Seed the package_destination taxonomy with the 3-level hierarchy.
 * Safe to call multiple times — uses term_exists() to skip duplicates.
 */
function travzo_seed_destination_terms() {
    // Level 1: Master package types
    $master_types = [ 'Group Tour', 'Honeymoon', 'Devotional', 'Solo Trip', 'Destination Wedding' ];

    // Level 2 under each master type
    $level2 = [ 'India', 'International' ];

    // Level 3 sub-regions
    $india_subregions = [ 'North India', 'South India', 'East India', 'West India', 'Northeast India', 'Himalayas' ];
    $intl_subregions  = [ 'Southeast Asia', 'East Asia', 'Middle East', 'Europe', 'Americas', 'Africa', 'Oceania' ];

    foreach ( $master_types as $type_name ) {
        $type_term = term_exists( $type_name, 'package_destination' );
        if ( ! $type_term ) {
            $type_term = wp_insert_term( $type_name, 'package_destination' );
        }
        $type_id = is_array( $type_term ) ? $type_term['term_id'] : $type_term;

        foreach ( $level2 as $l2_name ) {
            $l2_term = term_exists( $l2_name, 'package_destination', $type_id );
            if ( ! $l2_term ) {
                $l2_term = wp_insert_term( $l2_name, 'package_destination', [ 'parent' => $type_id ] );
            }
            $l2_id = is_array( $l2_term ) ? $l2_term['term_id'] : $l2_term;

            // Level 3: sub-regions under India or International
            $subregions = ( $l2_name === 'India' ) ? $india_subregions : $intl_subregions;
            foreach ( $subregions as $l3_name ) {
                if ( ! term_exists( $l3_name, 'package_destination', $l2_id ) ) {
                    wp_insert_term( $l3_name, 'package_destination', [ 'parent' => $l2_id ] );
                }
            }
        }
    }
}
add_action( 'after_switch_theme', 'travzo_seed_destination_terms' );

/**
 * Also seed on admin_init if terms don't exist yet (handles first install without theme switch).
 */
add_action( 'admin_init', function () {
    if ( get_option( 'travzo_destination_terms_seeded' ) ) return;
    if ( ! taxonomy_exists( 'package_destination' ) ) return;
    travzo_seed_destination_terms();
    update_option( 'travzo_destination_terms_seeded', '1' );
} );

/**
 * Auto-assign package_destination taxonomy terms when a package is saved.
 * Reads: _package_type, _pkg_country, _package_destinations
 * Assigns: Level 1 (type) → Level 2 (India/International) → Level 3 (sub-region)
 */
function travzo_auto_assign_destination_terms( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $pkg_type = get_post_meta( $post_id, '_package_type', true );
    $country  = get_post_meta( $post_id, '_pkg_country', true );
    $dests    = get_post_meta( $post_id, '_package_destinations', true );

    if ( ! $pkg_type ) return;

    $term_ids = [];

    // Level 1: Find the master type term
    // "International" package type maps to no specific master type — skip taxonomy assignment
    // Other types map directly to their taxonomy term
    $type_term = get_term_by( 'name', $pkg_type, 'package_destination' );
    if ( ! $type_term ) {
        // Package type doesn't have a taxonomy term (e.g. "International")
        wp_set_object_terms( $post_id, [], 'package_destination' );
        return;
    }
    $term_ids[] = $type_term->term_id;

    // Level 2: India or International
    $is_domestic = ( $country === 'India' || $country === '' );
    $l2_name     = $is_domestic ? 'India' : 'International';
    $l2_terms    = get_terms( [
        'taxonomy'   => 'package_destination',
        'parent'     => $type_term->term_id,
        'name'       => $l2_name,
        'hide_empty' => false,
    ] );
    if ( ! empty( $l2_terms ) && ! is_wp_error( $l2_terms ) ) {
        $l2_term    = $l2_terms[0];
        $term_ids[] = $l2_term->term_id;

        // Level 3: Sub-region
        $subregion = '';
        if ( $is_domestic && $dests ) {
            $subregion = travzo_detect_india_subregion( $dests );
        } elseif ( ! $is_domestic && $country ) {
            $continent_map = travzo_get_country_continent_map();
            $subregion     = isset( $continent_map[ $country ] ) ? $continent_map[ $country ] : '';
        }

        if ( $subregion ) {
            $l3_terms = get_terms( [
                'taxonomy'   => 'package_destination',
                'parent'     => $l2_term->term_id,
                'name'       => $subregion,
                'hide_empty' => false,
            ] );
            if ( ! empty( $l3_terms ) && ! is_wp_error( $l3_terms ) ) {
                $term_ids[] = $l3_terms[0]->term_id;
            }
        }
    }

    wp_set_object_terms( $post_id, $term_ids, 'package_destination' );
}
add_action( 'save_post_package', 'travzo_auto_assign_destination_terms', 30 );

// ══════════════════════════════════════════════════════════════════════════════
// WORDPRESS CUSTOMIZER – TRAVZO SETTINGS PANEL
// ══════════════════════════════════════════════════════════════════════════════
add_action( 'customize_register', function ( $wp_customize ) {

    // ── Main Panel ────────────────────────────────────────────────────────────
    $wp_customize->add_panel( 'travzo_panel', [
        'title'    => 'Travzo Settings',
        'priority' => 10,
    ] );

    // ── SECTION: Contact Information ─────────────────────────────────────────
    $wp_customize->add_section( 'travzo_contact', [
        'title' => 'Contact Information',
        'panel' => 'travzo_panel',
    ] );
    $contact_fields = [
        'travzo_phone'    => 'Phone Number',
        'travzo_email'    => 'Email Address',
        'travzo_whatsapp' => 'WhatsApp Number (digits only, e.g. 919940882200)',
        'travzo_address'  => 'Office Address',
        'travzo_hours'    => 'Working Hours',
    ];
    foreach ( $contact_fields as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_contact', 'type' => 'text' ] );
    }

    // ── SECTION: Social Media ─────────────────────────────────────────────────
    $wp_customize->add_section( 'travzo_social', [
        'title' => 'Social Media Links',
        'panel' => 'travzo_panel',
    ] );
    $social_fields = [
        'travzo_instagram' => 'Instagram URL',
        'travzo_facebook'  => 'Facebook URL',
        'travzo_youtube'   => 'YouTube URL',
    ];
    foreach ( $social_fields as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_social', 'type' => 'url' ] );
    }

    // ── SECTION: Header ───────────────────────────────────────────────────────
    $wp_customize->add_section( 'travzo_header', [
        'title' => 'Header Settings',
        'panel' => 'travzo_panel',
    ] );
    $wp_customize->add_setting( 'travzo_utility_text', [
        'default'           => "Tamil Nadu's Most Trusted Travel Partner",
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'travzo_utility_text', [
        'label'   => 'Utility Bar Text',
        'section' => 'travzo_header',
        'type'    => 'text',
    ] );

    // ── SECTION: Footer ───────────────────────────────────────────────────────
    $wp_customize->add_section( 'travzo_footer', [
        'title' => 'Footer Settings',
        'panel' => 'travzo_panel',
    ] );
    $footer_defaults = [
        'travzo_footer_tagline'   => [ 'label' => 'Footer Tagline',   'default' => 'Your trusted travel partner for unforgettable journeys across India and the world.' ],
        'travzo_footer_address'   => [ 'label' => 'Footer Address',   'default' => '123 Travel Street, Coimbatore, Tamil Nadu 641001' ],
        'travzo_footer_hours'     => [ 'label' => 'Footer Hours',     'default' => 'Mon – Sat: 9:00 AM – 7:00 PM' ],
        'travzo_footer_copyright'     => [ 'label' => 'Copyright Text',          'default' => '© 2026 Travzo Holidays. All Rights Reserved.' ],
        'travzo_footer_col2_heading'  => [ 'label' => 'Column 2 Heading',         'default' => 'Quick Links' ],
        'travzo_footer_col3_heading'  => [ 'label' => 'Column 3 Heading',         'default' => 'Our Packages' ],
        'travzo_footer_col4_heading'  => [ 'label' => 'Column 4 Heading',         'default' => 'Contact Us' ],
        'travzo_footer_whatsapp_text' => [ 'label' => 'WhatsApp Button Text',     'default' => 'Chat on WhatsApp' ],
    ];
    foreach ( $footer_defaults as $key => $field ) {
        $wp_customize->add_setting( $key, [
            'default'           => $field['default'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $key, [ 'label' => $field['label'], 'section' => 'travzo_footer', 'type' => 'text' ] );
    }

    // ── Homepage Hero (MOVED TO META BOX — see travzo_homepage_hero_cb) ──

    // ── Homepage Stats (MOVED TO META BOX — see travzo_homepage_stats_cb) ──

    // ── Homepage About Snippet (MOVED TO META BOX — see travzo_homepage_about_cb) ──

    // ── Homepage Newsletter (MOVED TO META BOX — see travzo_homepage_newsletter_cb) ──
} );

// ── WPForms Integration — REMOVED ─────────────────────────────────────────────
// All forms now use the theme's native HTML + AJAX submission via wp_mail().
// The old WPForms Customizer section has been removed.

// ── Homepage – Why Choose Us (MOVED TO META BOX — see travzo_homepage_whyus_cb) ──

// ── Header Navigation — MOVED TO dedicated admin page (Travzo Header) ──
// Old customizer sections for nav labels, mega menu URLs, and mega menu destinations
// have been removed. All header configuration is now in the Travzo Header admin page.
// Backward compat: travzo_get() still returns defaults for old keys like travzo_nav_cta_text.

// ── Homepage – Our Packages Section Labels (MOVED TO TILES META BOX) ──

// ── About Page Stats (FIX 4) ──────────────────────────────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'travzo_about_stats', [
        'title' => 'About Page – Stats',
        'panel' => 'travzo_panel',
    ] );
    $about_stat_fields = [
        'travzo_about_stat1_number' => 'Stat 1 Number (e.g. 500+)',
        'travzo_about_stat1_label'  => 'Stat 1 Label (e.g. Happy Travellers)',
        'travzo_about_stat2_number' => 'Stat 2 Number (e.g. 50+)',
        'travzo_about_stat2_label'  => 'Stat 2 Label (e.g. Destinations)',
        'travzo_about_stat3_number' => 'Stat 3 Number (e.g. 10+)',
        'travzo_about_stat3_label'  => 'Stat 3 Label (e.g. Years Experience)',
        'travzo_about_stat4_number' => 'Stat 4 Number (e.g. 100%)',
        'travzo_about_stat4_label'  => 'Stat 4 Label (e.g. Customised Itineraries)',
        'travzo_about_badge_text'   => 'Experience Badge (e.g. 10+ Years of Excellence)',
    ];
    foreach ( $about_stat_fields as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_about_stats', 'type' => 'text' ] );
    }
} );

// ── About Page – Section Labels & CTA ────────────────────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'travzo_about_sections', [
        'title' => 'About Page – Section Labels & CTA',
        'panel' => 'travzo_panel',
    ] );
    $about_section_fields = [
        'travzo_about_story_label'          => [ 'label' => 'Story – Section Label',          'default' => 'OUR STORY' ],
        'travzo_about_story_heading'        => [ 'label' => 'Story – Heading',                'default' => 'Who We Are' ],
        'travzo_about_whyus_label'          => [ 'label' => 'Why Us – Section Label',         'default' => 'WHY TRAVZO' ],
        'travzo_about_whyus_heading'        => [ 'label' => 'Why Us – Heading',               'default' => 'Why Travel With Us' ],
        'travzo_about_team_label'           => [ 'label' => 'Team – Section Label',           'default' => 'OUR PEOPLE' ],
        'travzo_about_team_heading'         => [ 'label' => 'Team – Heading',                 'default' => 'Meet the Team' ],
        'travzo_about_awards_label'         => [ 'label' => 'Awards – Section Label',         'default' => 'RECOGNITION' ],
        'travzo_about_awards_heading'       => [ 'label' => 'Awards – Heading',               'default' => 'Awards & Achievements' ],
        'travzo_about_accreditation_label'  => [ 'label' => 'Accreditation – Section Label',  'default' => 'TRUSTED BY' ],
        'travzo_about_accreditation_heading'=> [ 'label' => 'Accreditation – Heading',        'default' => 'Our Accreditation Partners' ],
        'travzo_about_testimonials_label'   => [ 'label' => 'Testimonials – Section Label',   'default' => 'HAPPY TRAVELLERS' ],
        'travzo_about_testimonials_heading' => [ 'label' => 'Testimonials – Heading',         'default' => 'What Our Travellers Say' ],
        'travzo_about_cta_heading'          => [ 'label' => 'CTA – Heading',                  'default' => 'Ready to Start Your Journey?' ],
        'travzo_about_cta_description'      => [ 'label' => 'CTA – Description',              'default' => 'Let us help you create memories that last a lifetime' ],
        'travzo_about_cta_btn1_text'        => [ 'label' => 'CTA – Button 1 Text',            'default' => 'Explore Packages' ],
        'travzo_about_cta_btn1_url'         => [ 'label' => 'CTA – Button 1 URL',             'default' => '/packages' ],
        'travzo_about_cta_btn2_text'        => [ 'label' => 'CTA – Button 2 Text',            'default' => 'Contact Us' ],
        'travzo_about_cta_btn2_url'         => [ 'label' => 'CTA – Button 2 URL',             'default' => '/contact' ],
    ];
    foreach ( $about_section_fields as $key => $field ) {
        $is_url = ( substr( $key, -4 ) === '_url' );
        $wp_customize->add_setting( $key, [
            'default'           => $field['default'],
            'sanitize_callback' => $is_url ? 'sanitize_text_field' : 'sanitize_text_field',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $key, [
            'label'   => $field['label'],
            'section' => 'travzo_about_sections',
            'type'    => 'text',
        ] );
    }
} );

// ── Mega Menu URLs & Destinations — MOVED TO Travzo Header admin page ──

// ── Homepage – Contact Section (MOVED TO META BOX — see travzo_homepage_contact_cb) ──

// ── Page Hero Sections ────────────────────────────────────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {

    // Packages List Page Hero
    $wp_customize->add_section( 'travzo_packages_hero', [
        'title' => 'Packages List Page – Hero',
        'panel' => 'travzo_panel',
    ] );
    foreach ( [
        'travzo_packages_hero_label' => 'Section Label',
        'travzo_packages_hero_title' => 'Page Title',
        'travzo_packages_hero_desc'  => 'Description',
        'travzo_packages_hero_pill1' => 'Stat Pill 1 (e.g. 100+ Packages Available)',
        'travzo_packages_hero_pill2' => 'Stat Pill 2 (e.g. 3 to 14 Days)',
        'travzo_packages_hero_pill3' => 'Stat Pill 3 (e.g. Starting ₹15,000)',
    ] as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_packages_hero', 'type' => 'text' ] );
    }
    $wp_customize->add_setting( 'travzo_packages_hero_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travzo_packages_hero_image', [
        'label'   => 'Hero Background Image',
        'section' => 'travzo_packages_hero',
    ] ) );

    // Page heroes (About, Contact, FAQ, Media, Blog) — MOVED TO Page Hero meta box
    // Old customizer values still read as backward-compat fallback in templates via travzo_get()

}, 50 );

// ══════════════════════════════════════════════════════════════════════════════
// GLOBAL HELPERS
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Render a mega menu destination column from customizer textarea fields.
 * Each line in the textarea is one item. Optional pipe separator for URL:
 *   Destination Name | https://example.com/page
 *
 * @param string $heading_key   Customizer key for the column heading.
 * @param string $items_key     Customizer key for the newline-separated items textarea.
 * @param string $view_all_url  Optional View All link URL.
 * @param string $view_all_text Optional View All link text.
 */
function travzo_render_mega_col( $heading_key, $items_key, $view_all_url = '', $view_all_text = '' ) {
    $heading   = travzo_get( $heading_key, '' );
    $items_raw = travzo_get( $items_key, '' );

    echo '<div class="mega-col">';
    if ( $heading ) {
        echo '<h4 class="mega-col__heading">' . esc_html( $heading ) . '</h4>';
    }
    echo '<ul>';

    $lines = array_filter( array_map( 'trim', explode( "\n", $items_raw ) ) );
    foreach ( $lines as $line ) {
        $parts = array_map( 'trim', explode( '|', $line, 2 ) );
        $name  = $parts[0] ?? '';
        $url   = ! empty( $parts[1] ) ? esc_url( $parts[1] ) : '#';
        if ( $name ) {
            echo '<li><a href="' . $url . '">' . esc_html( $name ) . '</a></li>';
        }
    }

    if ( $view_all_url && $view_all_text ) {
        echo '<li class="mega-viewmore"><a href="' . esc_url( $view_all_url ) . '">' . esc_html( $view_all_text ) . '</a></li>';
    }

    echo '</ul>';
    echo '</div>';
}

// ══════════════════════════════════════════════════════════════════════════════
// TRAVZO HEADER MENU SYSTEM
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Default main menu items (used on first load when no option exists).
 */
function travzo_default_menu_items() {
    return [
        [
            'label'    => 'Home',
            'url'      => '/',
            'visible'  => true,
            'has_mega' => false,
            'mega'     => [],
        ],
        [
            'label'    => 'Group Tours',
            'url'      => '/packages?type=Group+Tour',
            'visible'  => true,
            'has_mega' => true,
            'mega'     => [
                'auto_fetch'       => true,
                'auto_label'       => 'GROUP TOURS',
                'filter_type'      => 'Group Tour',
                'filter_region'    => '',
                'filter_country'   => '',
                'filter_subregion' => '',
                'filter_dest'      => '',
                'filter_duration'  => '',
                'filter_budget'    => '',
                'max_items'        => 6,
                'orderby'          => 'latest',
                'auto_viewmore'       => true,
                'auto_viewmore_label' => 'View All Group Tours →',
                'auto_viewmore_url'   => '',
                'custom_links'        => false,
                'custom_label'        => 'POPULAR DESTINATIONS',
                'links'               => [],
                'custom_viewmore'       => false,
                'custom_viewmore_label' => 'Explore All →',
                'custom_viewmore_url'   => '',
            ],
        ],
        [
            'label'    => 'Honeymoon',
            'url'      => '/packages?type=Honeymoon',
            'visible'  => true,
            'has_mega' => true,
            'mega'     => [
                'auto_fetch'       => true,
                'auto_label'       => 'HONEYMOON PACKAGES',
                'filter_type'      => 'Honeymoon',
                'filter_region'    => '',
                'filter_country'   => '',
                'filter_subregion' => '',
                'filter_dest'      => '',
                'filter_duration'  => '',
                'filter_budget'    => '',
                'max_items'        => 6,
                'orderby'          => 'latest',
                'auto_viewmore'       => true,
                'auto_viewmore_label' => 'View All Honeymoon →',
                'auto_viewmore_url'   => '',
                'custom_links'        => false,
                'custom_label'        => 'POPULAR DESTINATIONS',
                'links'               => [],
                'custom_viewmore'       => false,
                'custom_viewmore_label' => 'Explore All →',
                'custom_viewmore_url'   => '',
            ],
        ],
        [
            'label'    => 'Devotional',
            'url'      => '/packages?type=Devotional',
            'visible'  => true,
            'has_mega' => true,
            'mega'     => [
                'auto_fetch'       => true,
                'auto_label'       => 'DEVOTIONAL TOURS',
                'filter_type'      => 'Devotional',
                'filter_region'    => '',
                'filter_country'   => '',
                'filter_subregion' => '',
                'filter_dest'      => '',
                'filter_duration'  => '',
                'filter_budget'    => '',
                'max_items'        => 6,
                'orderby'          => 'latest',
                'auto_viewmore'       => true,
                'auto_viewmore_label' => 'View All Devotional →',
                'auto_viewmore_url'   => '',
                'custom_links'        => false,
                'custom_label'        => 'POPULAR DESTINATIONS',
                'links'               => [],
                'custom_viewmore'       => false,
                'custom_viewmore_label' => 'Explore All →',
                'custom_viewmore_url'   => '',
            ],
        ],
        [
            'label'    => 'Dest. Wedding',
            'url'      => '/packages?type=Destination+Wedding',
            'visible'  => true,
            'has_mega' => true,
            'mega'     => [
                'auto_fetch'       => true,
                'auto_label'       => 'DESTINATION WEDDINGS',
                'filter_type'      => 'Destination Wedding',
                'filter_region'    => '',
                'filter_country'   => '',
                'filter_subregion' => '',
                'filter_dest'      => '',
                'filter_duration'  => '',
                'filter_budget'    => '',
                'max_items'        => 6,
                'orderby'          => 'latest',
                'auto_viewmore'       => true,
                'auto_viewmore_label' => 'View All Weddings →',
                'auto_viewmore_url'   => '',
                'custom_links'        => false,
                'custom_label'        => 'POPULAR DESTINATIONS',
                'links'               => [],
                'custom_viewmore'       => false,
                'custom_viewmore_label' => 'Explore All →',
                'custom_viewmore_url'   => '',
            ],
        ],
        [
            'label'    => 'Solo Trips',
            'url'      => '/packages?type=Solo+Trip',
            'visible'  => true,
            'has_mega' => true,
            'mega'     => [
                'auto_fetch'       => true,
                'auto_label'       => 'SOLO TRIPS',
                'filter_type'      => 'Solo Trip',
                'filter_region'    => '',
                'filter_country'   => '',
                'filter_subregion' => '',
                'filter_dest'      => '',
                'filter_duration'  => '',
                'filter_budget'    => '',
                'max_items'        => 6,
                'orderby'          => 'latest',
                'auto_viewmore'       => true,
                'auto_viewmore_label' => 'View All Solo Trips →',
                'auto_viewmore_url'   => '',
                'custom_links'        => false,
                'custom_label'        => 'POPULAR DESTINATIONS',
                'links'               => [],
                'custom_viewmore'       => false,
                'custom_viewmore_label' => 'Explore All →',
                'custom_viewmore_url'   => '',
            ],
        ],
        [
            'label'    => 'Blog',
            'url'      => '/blog',
            'visible'  => true,
            'has_mega' => false,
            'mega'     => [],
        ],
        [
            'label'    => 'About',
            'url'      => '/about',
            'visible'  => true,
            'has_mega' => false,
            'mega'     => [],
        ],
        [
            'label'    => 'Contact',
            'url'      => '/contact',
            'visible'  => true,
            'has_mega' => false,
            'mega'     => [],
        ],
    ];
}

/**
 * Get the main menu items (from option, with defaults fallback).
 */
function travzo_get_menu_items() {
    $items = get_option( 'travzo_main_menu', false );
    if ( false === $items || ! is_array( $items ) || empty( $items ) ) {
        $items = travzo_default_menu_items();
    }
    return $items;
}

/**
 * Fetch packages for a mega menu's auto-fetch column.
 * Returns array of [ 'title' => ..., 'url' => ... ].
 * Cached via transient (1 hour).
 */
function travzo_fetch_menu_packages( $mega ) {
    $filters = [
        'type'      => $mega['filter_type']      ?? '',
        'region'    => $mega['filter_region']     ?? '',
        'country'   => $mega['filter_country']    ?? '',
        'subregion' => $mega['filter_subregion']  ?? '',
        'dest'      => $mega['filter_dest']       ?? '',
        'duration'  => $mega['filter_duration']   ?? '',
        'budget'    => $mega['filter_budget']     ?? '',
    ];
    $max     = min( absint( $mega['max_items'] ?? 6 ), 10 ) ?: 6;
    $orderby = $mega['orderby'] ?? 'latest';

    $cache_key = 'travzo_megamenu_' . md5( serialize( $filters ) . $max . $orderby );
    $cached = get_transient( $cache_key );
    if ( false !== $cached ) {
        return $cached;
    }

    $args = [
        'post_type'      => 'package',
        'posts_per_page' => $max,
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    ];

    $meta_query = [];
    if ( ! empty( $filters['type'] ) ) {
        $meta_query[] = [ 'key' => '_package_type', 'value' => $filters['type'], 'compare' => '=' ];
    }
    if ( ! empty( $filters['region'] ) ) {
        $meta_query[] = [ 'key' => '_pkg_region', 'value' => $filters['region'], 'compare' => '=' ];
    }
    if ( ! empty( $filters['country'] ) ) {
        $meta_query[] = [ 'key' => '_pkg_country', 'value' => $filters['country'], 'compare' => '=' ];
    }
    if ( ! empty( $filters['dest'] ) ) {
        $meta_query[] = [ 'key' => '_package_destinations', 'value' => $filters['dest'], 'compare' => 'LIKE' ];
    }
    if ( ! empty( $filters['duration'] ) ) {
        $meta_query[] = [ 'key' => '_package_duration', 'value' => $filters['duration'], 'compare' => 'LIKE' ];
    }
    if ( ! empty( $meta_query ) ) {
        $meta_query['relation'] = 'AND';
        $args['meta_query'] = $meta_query;
    }

    if ( ! empty( $filters['subregion'] ) ) {
        $term = get_term_by( 'name', $filters['subregion'], 'package_destination' );
        if ( $term ) {
            $args['tax_query'] = [ [ 'taxonomy' => 'package_destination', 'terms' => $term->term_id ] ];
        }
    }

    switch ( $orderby ) {
        case 'price_asc':
            $args['meta_key'] = '_package_price';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
            break;
        case 'popular':
            $args['orderby'] = 'comment_count';
            $args['order']   = 'DESC';
            break;
        default: // 'latest'
            $args['orderby'] = 'date';
            $args['order']   = 'DESC';
    }

    $q = new WP_Query( $args );
    $results = [];
    if ( $q->have_posts() ) {
        while ( $q->have_posts() ) {
            $q->the_post();
            $results[] = [ 'title' => get_the_title(), 'url' => get_permalink() ];
        }
        wp_reset_postdata();
    }

    set_transient( $cache_key, $results, HOUR_IN_SECONDS );
    return $results;
}

/**
 * Build auto-fetch View More URL from mega menu filters.
 */
function travzo_mega_viewmore_url( $mega ) {
    $base = get_post_type_archive_link( 'package' ) ?: home_url( '/packages/' );
    $params = [];
    if ( ! empty( $mega['filter_type'] ) )      $params['type']     = $mega['filter_type'];
    if ( ! empty( $mega['filter_region'] ) )     $params['region']   = $mega['filter_region'];
    if ( ! empty( $mega['filter_country'] ) )    $params['country']  = $mega['filter_country'];
    if ( ! empty( $mega['filter_subregion'] ) )  $params['subregion'] = $mega['filter_subregion'];
    if ( ! empty( $mega['filter_dest'] ) )       $params['destination'] = $mega['filter_dest'];
    if ( ! empty( $mega['filter_duration'] ) )   $params['duration'] = $mega['filter_duration'];
    if ( ! empty( $mega['filter_budget'] ) )     $params['budget']   = $mega['filter_budget'];
    return $params ? add_query_arg( $params, $base ) : $base;
}

// ── Admin Menu Page ──────────────────────────────────────────────────────────
add_action( 'admin_menu', function () {
    add_menu_page(
        'Travzo Header',
        'Travzo Header',
        'manage_options',
        'travzo-header-menu',
        'travzo_header_menu_page',
        'dashicons-menu-alt',
        25
    );
} );

// Enqueue jQuery UI Sortable on the Travzo Header admin page
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_travzo-header-menu' !== $hook ) return;
    wp_enqueue_script( 'jquery-ui-sortable' );
} );

/**
 * Render the Travzo Header admin page.
 */
function travzo_header_menu_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $items = travzo_get_menu_items();
    $pkg_types = [ '', 'Group Tour', 'Honeymoon', 'Solo Trip', 'Devotional', 'Destination Wedding', 'International' ];
    $regions   = [ '' => 'All Regions', 'domestic' => 'Domestic (India)', 'international' => 'International' ];
    $durations = [ '' => 'Any', '3-5' => '3-5 Days', '6-8' => '6-8 Days', '9-12' => '9-12 Days', '13+' => '13+ Days' ];
    $budgets   = [ '' => 'Any', 'under-15000' => 'Under ₹15K', '15000-30000' => '₹15K-30K', '30000-60000' => '₹30K-60K', 'above-60000' => '₹60K+' ];
    $orderbys  = [ 'latest' => 'Latest', 'popular' => 'Most Popular', 'price_asc' => 'Price Low→High' ];

    $success = isset( $_GET['saved'] ) && '1' === $_GET['saved'];
    ?>
    <div class="wrap">
        <h1>Travzo Header Menu</h1>
        <?php if ( $success ) : ?>
            <div class="notice notice-success is-dismissible"><p>Menu saved successfully.</p></div>
        <?php endif; ?>

        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="travzo_save_header_menu">
            <?php wp_nonce_field( 'travzo_header_menu_save', 'travzo_header_menu_nonce' ); ?>
            <input type="hidden" name="_menu_data" id="travzo-menu-data" value="<?php echo esc_attr( wp_json_encode( $items ) ); ?>">

            <p class="submit" style="margin-top:0"><input type="submit" class="button-primary" value="Save Menu"></p>

            <div id="travzo-menu-items" style="max-width:900px">
            <?php foreach ( $items as $i => $item ) :
                $m = $item['mega'] ?? [];
            ?>
            <div class="tmenu-card" data-index="<?php echo $i; ?>" style="background:#fff;border:1px solid #c3c4c7;border-radius:4px;margin-bottom:12px;box-shadow:0 1px 1px rgba(0,0,0,.04)">
                <div class="tmenu-header" style="display:flex;align-items:center;gap:8px;padding:12px 16px;cursor:pointer;background:#f6f7f7;border-bottom:1px solid #dcdcde">
                    <span class="tmenu-drag" style="cursor:grab;color:#999;font-size:18px" title="Drag to reorder">☰</span>
                    <strong class="tmenu-title" style="flex:1"><?php echo esc_html( $item['label'] ); ?></strong>
                    <span class="tmenu-badge" style="font-size:11px;color:#666"><?php echo $item['has_mega'] ? '▼ Mega Menu' : 'Link'; ?></span>
                    <button type="button" class="button tmenu-remove" style="color:#b32d2e;padding:2px 8px" title="Delete">✕</button>
                </div>
                <div class="tmenu-body" style="padding:16px;display:none">
                    <div style="display:grid;grid-template-columns:1fr 1fr 100px;gap:12px;margin-bottom:16px">
                        <div>
                            <label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">LABEL</label>
                            <input type="text" class="widefat tmf-label" value="<?php echo esc_attr( $item['label'] ); ?>">
                        </div>
                        <div>
                            <label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">URL</label>
                            <input type="text" class="widefat tmf-url" value="<?php echo esc_attr( $item['url'] ); ?>" placeholder="/packages">
                        </div>
                        <div style="display:flex;flex-direction:column;gap:4px;padding-top:18px">
                            <label><input type="checkbox" class="tmf-visible" <?php checked( $item['visible'] ?? true ); ?>> Visible</label>
                        </div>
                    </div>

                    <label style="display:block;margin-bottom:16px"><input type="checkbox" class="tmf-has-mega" <?php checked( $item['has_mega'] ?? false ); ?>> <strong>Enable Mega Menu</strong></label>

                    <div class="tmenu-mega-config" style="<?php echo empty( $item['has_mega'] ) ? 'display:none' : ''; ?>;border:1px solid #e0e0e0;border-radius:4px;padding:16px;background:#fafafa">
                        <h4 style="margin:0 0 12px;font-size:13px;color:#1d2327">Auto-Fetch Packages (Left Column)</h4>
                        <label style="display:block;margin-bottom:12px"><input type="checkbox" class="tmf-auto-fetch" <?php checked( $m['auto_fetch'] ?? true ); ?>> Enable Auto-Fetch</label>
                        <div class="tmenu-auto-fields" style="<?php echo empty( $m['auto_fetch'] ) ? 'display:none' : ''; ?>">
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px">
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">SECTION LABEL</label>
                                    <input type="text" class="widefat tmf-auto-label" value="<?php echo esc_attr( $m['auto_label'] ?? '' ); ?>">
                                </div>
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">PACKAGE TYPE</label>
                                    <select class="widefat tmf-filter-type">
                                        <?php foreach ( $pkg_types as $pt ) : ?>
                                        <option value="<?php echo esc_attr( $pt ); ?>" <?php selected( $m['filter_type'] ?? '', $pt ); ?>><?php echo $pt ?: '— Any —'; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:12px">
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">REGION</label>
                                    <select class="widefat tmf-filter-region">
                                        <?php foreach ( $regions as $rv => $rl ) : ?>
                                        <option value="<?php echo esc_attr( $rv ); ?>" <?php selected( $m['filter_region'] ?? '', $rv ); ?>><?php echo esc_html( $rl ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">DURATION</label>
                                    <select class="widefat tmf-filter-duration">
                                        <?php foreach ( $durations as $dv => $dl ) : ?>
                                        <option value="<?php echo esc_attr( $dv ); ?>" <?php selected( $m['filter_duration'] ?? '', $dv ); ?>><?php echo esc_html( $dl ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">BUDGET</label>
                                    <select class="widefat tmf-filter-budget">
                                        <?php foreach ( $budgets as $bv => $bl ) : ?>
                                        <option value="<?php echo esc_attr( $bv ); ?>" <?php selected( $m['filter_budget'] ?? '', $bv ); ?>><?php echo esc_html( $bl ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:12px">
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">DESTINATION</label>
                                    <input type="text" class="widefat tmf-filter-dest" value="<?php echo esc_attr( $m['filter_dest'] ?? '' ); ?>" placeholder="e.g. Kerala">
                                </div>
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">MAX ITEMS</label>
                                    <input type="number" class="widefat tmf-max-items" value="<?php echo esc_attr( $m['max_items'] ?? 6 ); ?>" min="1" max="10">
                                </div>
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">ORDER BY</label>
                                    <select class="widefat tmf-orderby">
                                        <?php foreach ( $orderbys as $ov => $ol ) : ?>
                                        <option value="<?php echo esc_attr( $ov ); ?>" <?php selected( $m['orderby'] ?? 'latest', $ov ); ?>><?php echo esc_html( $ol ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:auto 1fr 1fr;gap:10px;margin-bottom:8px;align-items:end">
                                <label style="padding-bottom:6px"><input type="checkbox" class="tmf-auto-vm" <?php checked( $m['auto_viewmore'] ?? true ); ?>> View More</label>
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">BUTTON LABEL</label>
                                    <input type="text" class="widefat tmf-auto-vm-label" value="<?php echo esc_attr( $m['auto_viewmore_label'] ?? '' ); ?>">
                                </div>
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">BUTTON URL <span style="font-weight:400;color:#999">(empty = auto)</span></label>
                                    <input type="text" class="widefat tmf-auto-vm-url" value="<?php echo esc_attr( $m['auto_viewmore_url'] ?? '' ); ?>">
                                </div>
                            </div>
                        </div>

                        <hr style="border:none;border-top:1px solid #e0e0e0;margin:16px 0">

                        <h4 style="margin:0 0 12px;font-size:13px;color:#1d2327">Custom Links (Right Column)</h4>
                        <label style="display:block;margin-bottom:12px"><input type="checkbox" class="tmf-custom-links" <?php checked( $m['custom_links'] ?? false ); ?>> Enable Custom Links</label>
                        <div class="tmenu-custom-fields" style="<?php echo empty( $m['custom_links'] ) ? 'display:none' : ''; ?>">
                            <div style="margin-bottom:12px">
                                <label style="font-size:11px;font-weight:600;color:#555">SECTION LABEL</label>
                                <input type="text" class="widefat tmf-custom-label" value="<?php echo esc_attr( $m['custom_label'] ?? '' ); ?>">
                            </div>
                            <div class="tmenu-links-list">
                                <?php if ( ! empty( $m['links'] ) ) : foreach ( $m['links'] as $lnk ) : ?>
                                <div class="tmenu-link-row" style="display:flex;gap:8px;margin-bottom:6px">
                                    <input type="text" class="widefat tml-text" value="<?php echo esc_attr( $lnk['text'] ?? '' ); ?>" placeholder="Link Label" style="flex:1">
                                    <input type="text" class="widefat tml-url" value="<?php echo esc_attr( $lnk['url'] ?? '' ); ?>" placeholder="/packages?..." style="flex:1">
                                    <button type="button" class="button tml-remove" style="color:#b32d2e">✕</button>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>
                            <button type="button" class="button tmenu-add-link" style="margin-bottom:12px">+ Add Link</button>
                            <div style="display:grid;grid-template-columns:auto 1fr 1fr;gap:10px;align-items:end">
                                <label style="padding-bottom:6px"><input type="checkbox" class="tmf-custom-vm" <?php checked( $m['custom_viewmore'] ?? false ); ?>> View More</label>
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">BUTTON LABEL</label>
                                    <input type="text" class="widefat tmf-custom-vm-label" value="<?php echo esc_attr( $m['custom_viewmore_label'] ?? '' ); ?>">
                                </div>
                                <div>
                                    <label style="font-size:11px;font-weight:600;color:#555">BUTTON URL</label>
                                    <input type="text" class="widefat tmf-custom-vm-url" value="<?php echo esc_attr( $m['custom_viewmore_url'] ?? '' ); ?>">
                                </div>
                            </div>
                        </div>
                    </div><!-- /.tmenu-mega-config -->
                </div><!-- /.tmenu-body -->
            </div><!-- /.tmenu-card -->
            <?php endforeach; ?>
            </div><!-- /#travzo-menu-items -->

            <button type="button" class="button" id="travzo-add-menu-item" style="margin-bottom:20px">+ Add Menu Item</button>
            <p class="submit"><input type="submit" class="button-primary" value="Save Menu"></p>
        </form>
    </div>

    <script>
    jQuery(function($) {
        var $container = $('#travzo-menu-items');
        var $hidden    = $('#travzo-menu-data');

        // Make sortable
        $container.sortable({ handle: '.tmenu-drag', axis: 'y', update: syncAll });

        // Toggle card body
        $container.on('click', '.tmenu-header', function(e) {
            if ($(e.target).closest('.tmenu-remove').length) return;
            $(this).next('.tmenu-body').slideToggle(200);
        });

        // Remove card
        $container.on('click', '.tmenu-remove', function() {
            $(this).closest('.tmenu-card').remove();
            syncAll();
        });

        // Toggle mega config
        $container.on('change', '.tmf-has-mega', function() {
            $(this).closest('.tmenu-body').find('.tmenu-mega-config').toggle(this.checked);
        });
        $container.on('change', '.tmf-auto-fetch', function() {
            $(this).closest('.tmenu-mega-config').find('.tmenu-auto-fields').toggle(this.checked);
        });
        $container.on('change', '.tmf-custom-links', function() {
            $(this).closest('.tmenu-mega-config').find('.tmenu-custom-fields').toggle(this.checked);
        });

        // Update title live
        $container.on('input', '.tmf-label', function() {
            $(this).closest('.tmenu-card').find('.tmenu-title').text($(this).val() || 'Untitled');
        });

        // Add custom link row
        $container.on('click', '.tmenu-add-link', function() {
            $(this).prev('.tmenu-links-list').append(
                '<div class="tmenu-link-row" style="display:flex;gap:8px;margin-bottom:6px">' +
                '<input type="text" class="widefat tml-text" placeholder="Link Label" style="flex:1">' +
                '<input type="text" class="widefat tml-url" placeholder="/packages?..." style="flex:1">' +
                '<button type="button" class="button tml-remove" style="color:#b32d2e">✕</button></div>'
            );
        });
        $container.on('click', '.tml-remove', function() { $(this).closest('.tmenu-link-row').remove(); syncAll(); });

        // Add new menu item
        $('#travzo-add-menu-item').on('click', function() {
            var idx = $container.children().length;
            var card = '<div class="tmenu-card" style="background:#fff;border:1px solid #c3c4c7;border-radius:4px;margin-bottom:12px;box-shadow:0 1px 1px rgba(0,0,0,.04)">' +
                '<div class="tmenu-header" style="display:flex;align-items:center;gap:8px;padding:12px 16px;cursor:pointer;background:#f6f7f7;border-bottom:1px solid #dcdcde">' +
                '<span class="tmenu-drag" style="cursor:grab;color:#999;font-size:18px" title="Drag to reorder">☰</span>' +
                '<strong class="tmenu-title" style="flex:1">New Item</strong>' +
                '<span class="tmenu-badge" style="font-size:11px;color:#666">Link</span>' +
                '<button type="button" class="button tmenu-remove" style="color:#b32d2e;padding:2px 8px" title="Delete">✕</button></div>' +
                '<div class="tmenu-body" style="padding:16px">' +
                '<div style="display:grid;grid-template-columns:1fr 1fr 100px;gap:12px;margin-bottom:16px">' +
                '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">LABEL</label><input type="text" class="widefat tmf-label" value="New Item"></div>' +
                '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">URL</label><input type="text" class="widefat tmf-url" value="/" placeholder="/packages"></div>' +
                '<div style="display:flex;flex-direction:column;gap:4px;padding-top:18px"><label><input type="checkbox" class="tmf-visible" checked> Visible</label></div></div>' +
                '<label style="display:block;margin-bottom:16px"><input type="checkbox" class="tmf-has-mega"> <strong>Enable Mega Menu</strong></label>' +
                '<div class="tmenu-mega-config" style="display:none;border:1px solid #e0e0e0;border-radius:4px;padding:16px;background:#fafafa">' +
                '<h4 style="margin:0 0 12px;font-size:13px;color:#1d2327">Auto-Fetch Packages (Left Column)</h4>' +
                '<label style="display:block;margin-bottom:12px"><input type="checkbox" class="tmf-auto-fetch" checked> Enable Auto-Fetch</label>' +
                '<div class="tmenu-auto-fields">' +
                '<div style="margin-bottom:12px"><label style="font-size:11px;font-weight:600;color:#555">SECTION LABEL</label><input type="text" class="widefat tmf-auto-label"></div>' +
                '<div style="margin-bottom:12px"><label style="font-size:11px;font-weight:600;color:#555">MAX ITEMS</label><input type="number" class="widefat tmf-max-items" value="6" min="1" max="10"></div>' +
                '<div style="display:grid;grid-template-columns:auto 1fr 1fr;gap:10px;margin-bottom:8px;align-items:end">' +
                '<label style="padding-bottom:6px"><input type="checkbox" class="tmf-auto-vm" checked> View More</label>' +
                '<div><label style="font-size:11px;font-weight:600;color:#555">BUTTON LABEL</label><input type="text" class="widefat tmf-auto-vm-label"></div>' +
                '<div><label style="font-size:11px;font-weight:600;color:#555">BUTTON URL</label><input type="text" class="widefat tmf-auto-vm-url"></div></div>' +
                '</div>' +
                '<hr style="border:none;border-top:1px solid #e0e0e0;margin:16px 0">' +
                '<h4 style="margin:0 0 12px;font-size:13px;color:#1d2327">Custom Links (Right Column)</h4>' +
                '<label style="display:block;margin-bottom:12px"><input type="checkbox" class="tmf-custom-links"> Enable Custom Links</label>' +
                '<div class="tmenu-custom-fields" style="display:none">' +
                '<div style="margin-bottom:12px"><label style="font-size:11px;font-weight:600;color:#555">SECTION LABEL</label><input type="text" class="widefat tmf-custom-label"></div>' +
                '<div class="tmenu-links-list"></div>' +
                '<button type="button" class="button tmenu-add-link" style="margin-bottom:12px">+ Add Link</button>' +
                '<div style="display:grid;grid-template-columns:auto 1fr 1fr;gap:10px;align-items:end">' +
                '<label style="padding-bottom:6px"><input type="checkbox" class="tmf-custom-vm"> View More</label>' +
                '<div><label style="font-size:11px;font-weight:600;color:#555">BUTTON LABEL</label><input type="text" class="widefat tmf-custom-vm-label"></div>' +
                '<div><label style="font-size:11px;font-weight:600;color:#555">BUTTON URL</label><input type="text" class="widefat tmf-custom-vm-url"></div></div>' +
                '</div></div></div></div>';
            $container.append(card);
        });

        // Sync all cards to hidden JSON before submit
        $('form').on('submit', function() { syncAll(); });

        function syncAll() {
            var items = [];
            $container.children('.tmenu-card').each(function() {
                var $c = $(this);
                var links = [];
                $c.find('.tmenu-link-row').each(function() {
                    var t = $(this).find('.tml-text').val().trim();
                    var u = $(this).find('.tml-url').val().trim();
                    if (t) links.push({ text: t, url: u });
                });
                items.push({
                    label:    $c.find('.tmf-label').val() || '',
                    url:      $c.find('.tmf-url').val() || '/',
                    visible:  $c.find('.tmf-visible').is(':checked'),
                    has_mega: $c.find('.tmf-has-mega').is(':checked'),
                    mega: {
                        auto_fetch:       $c.find('.tmf-auto-fetch').is(':checked'),
                        auto_label:       $c.find('.tmf-auto-label').val() || '',
                        filter_type:      $c.find('.tmf-filter-type').val() || '',
                        filter_region:    $c.find('.tmf-filter-region').val() || '',
                        filter_country:   $c.find('.tmf-filter-country').val() || '',
                        filter_subregion: $c.find('.tmf-filter-subregion').val() || '',
                        filter_dest:      $c.find('.tmf-filter-dest').val() || '',
                        filter_duration:  $c.find('.tmf-filter-duration').val() || '',
                        filter_budget:    $c.find('.tmf-filter-budget').val() || '',
                        max_items:        parseInt($c.find('.tmf-max-items').val()) || 6,
                        orderby:          $c.find('.tmf-orderby').val() || 'latest',
                        auto_viewmore:       $c.find('.tmf-auto-vm').is(':checked'),
                        auto_viewmore_label: $c.find('.tmf-auto-vm-label').val() || '',
                        auto_viewmore_url:   $c.find('.tmf-auto-vm-url').val() || '',
                        custom_links:        $c.find('.tmf-custom-links').is(':checked'),
                        custom_label:        $c.find('.tmf-custom-label').val() || '',
                        links:               links,
                        custom_viewmore:       $c.find('.tmf-custom-vm').is(':checked'),
                        custom_viewmore_label: $c.find('.tmf-custom-vm-label').val() || '',
                        custom_viewmore_url:   $c.find('.tmf-custom-vm-url').val() || '',
                    }
                });
            });
            $hidden.val(JSON.stringify(items));
        }
    });
    </script>
    <?php
}

// ── Save handler ─────────────────────────────────────────────────────────────
add_action( 'admin_post_travzo_save_header_menu', function () {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
    check_admin_referer( 'travzo_header_menu_save', 'travzo_header_menu_nonce' );

    $raw = isset( $_POST['_menu_data'] ) ? wp_unslash( $_POST['_menu_data'] ) : '[]';
    $decoded = json_decode( $raw, true );
    if ( ! is_array( $decoded ) ) $decoded = [];

    $clean = [];
    foreach ( $decoded as $item ) {
        $mega = $item['mega'] ?? [];
        $links_clean = [];
        if ( ! empty( $mega['links'] ) && is_array( $mega['links'] ) ) {
            foreach ( $mega['links'] as $lnk ) {
                $t = sanitize_text_field( $lnk['text'] ?? '' );
                if ( $t ) {
                    $links_clean[] = [
                        'text' => $t,
                        'url'  => sanitize_text_field( $lnk['url'] ?? '' ),
                    ];
                }
            }
        }
        $clean[] = [
            'label'    => sanitize_text_field( $item['label'] ?? '' ),
            'url'      => sanitize_text_field( $item['url'] ?? '/' ),
            'visible'  => ! empty( $item['visible'] ),
            'has_mega' => ! empty( $item['has_mega'] ),
            'mega'     => [
                'auto_fetch'          => ! empty( $mega['auto_fetch'] ),
                'auto_label'          => sanitize_text_field( $mega['auto_label'] ?? '' ),
                'filter_type'         => sanitize_text_field( $mega['filter_type'] ?? '' ),
                'filter_region'       => sanitize_text_field( $mega['filter_region'] ?? '' ),
                'filter_country'      => sanitize_text_field( $mega['filter_country'] ?? '' ),
                'filter_subregion'    => sanitize_text_field( $mega['filter_subregion'] ?? '' ),
                'filter_dest'         => sanitize_text_field( $mega['filter_dest'] ?? '' ),
                'filter_duration'     => sanitize_text_field( $mega['filter_duration'] ?? '' ),
                'filter_budget'       => sanitize_text_field( $mega['filter_budget'] ?? '' ),
                'max_items'           => min( absint( $mega['max_items'] ?? 6 ), 10 ) ?: 6,
                'orderby'             => sanitize_text_field( $mega['orderby'] ?? 'latest' ),
                'auto_viewmore'       => ! empty( $mega['auto_viewmore'] ),
                'auto_viewmore_label' => sanitize_text_field( $mega['auto_viewmore_label'] ?? '' ),
                'auto_viewmore_url'   => sanitize_text_field( $mega['auto_viewmore_url'] ?? '' ),
                'custom_links'        => ! empty( $mega['custom_links'] ),
                'custom_label'        => sanitize_text_field( $mega['custom_label'] ?? '' ),
                'links'               => $links_clean,
                'custom_viewmore'       => ! empty( $mega['custom_viewmore'] ),
                'custom_viewmore_label' => sanitize_text_field( $mega['custom_viewmore_label'] ?? '' ),
                'custom_viewmore_url'   => sanitize_text_field( $mega['custom_viewmore_url'] ?? '' ),
            ],
        ];
    }

    update_option( 'travzo_main_menu', $clean );

    // Flush mega menu transients
    global $wpdb;
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_travzo_megamenu_%' OR option_name LIKE '_transient_timeout_travzo_megamenu_%'" );

    wp_safe_redirect( admin_url( 'admin.php?page=travzo-header-menu&saved=1' ) );
    exit;
} );

// ══════════════════════════════════════════════════════════════════════════════
// END TRAVZO HEADER MENU SYSTEM
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Get a Customizer setting value with optional fallback.
 */
function travzo_get( $key, $fallback = '' ) {
    $val = get_theme_mod( $key, '' );
    return ( $val !== '' ) ? $val : $fallback;
}

/**
 * Parse a pipe-delimited textarea into an array of arrays.
 * Each line becomes an array; columns are split by |.
 *
 * @param string $text      Raw textarea value.
 * @param int    $num_cols  Expected number of columns (pads short rows with '').
 * @return array
 */
function travzo_parse_lines( $text, $num_cols = 2 ) {
    if ( empty( $text ) ) return [];
    $lines  = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $text ) ) );
    $result = [];
    foreach ( $lines as $line ) {
        if ( $line === '' ) continue;
        $parts = array_map( 'trim', explode( '|', $line ) );
        while ( count( $parts ) < $num_cols ) {
            $parts[] = '';
        }
        $result[] = $parts;
    }
    return $result;
}

/**
 * Legacy helper – kept for backwards compatibility.
 * Without ACF this always returns ''.
 */
function travzo_get_option( $field ) {
    return '';
}

// ══════════════════════════════════════════════════════════════════════════════
// HELPER – COUNTRY LIST, REGION MAPS, TAXONOMY HELPERS
// ══════════════════════════════════════════════════════════════════════════════

/** Complete world country list — India first, then alphabetical. */
function travzo_get_countries() {
    $countries = [
        'Afghanistan','Albania','Algeria','Andorra','Angola','Antigua and Barbuda','Argentina',
        'Armenia','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados',
        'Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia and Herzegovina','Botswana',
        'Brazil','Brunei','Bulgaria','Burkina Faso','Burundi','Cabo Verde','Cambodia','Cameroon',
        'Canada','Central African Republic','Chad','Chile','China','Colombia','Comoros',
        'Congo (Brazzaville)','Congo (Kinshasa)','Costa Rica','Croatia','Cuba','Cyprus',
        'Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','Ecuador','Egypt',
        'El Salvador','Equatorial Guinea','Eritrea','Estonia','Eswatini','Ethiopia','Fiji','Finland',
        'France','Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala',
        'Guinea','Guinea-Bissau','Guyana','Haiti','Honduras','Hong Kong','Hungary','Iceland',
        'Indonesia','Iran','Iraq','Ireland','Israel','Italy','Ivory Coast','Jamaica','Japan',
        'Jordan','Kazakhstan','Kenya','Kiribati','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon',
        'Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg','Madagascar','Malawi',
        'Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico',
        'Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar',
        'Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria',
        'North Korea','North Macedonia','Norway','Oman','Pakistan','Palau','Palestine','Panama',
        'Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Qatar','Romania',
        'Russia','Rwanda','Saint Kitts and Nevis','Saint Lucia','Saint Vincent and the Grenadines',
        'Samoa','San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia','Seychelles',
        'Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa',
        'South Korea','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Sweden','Switzerland',
        'Syria','Taiwan','Tajikistan','Tanzania','Thailand','Timor-Leste','Togo','Tonga',
        'Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu','UAE','Uganda','Ukraine',
        'United Kingdom','USA','Uruguay','Uzbekistan','Vanuatu','Vatican City','Venezuela',
        'Vietnam','Yemen','Zambia','Zimbabwe',
    ];
    // India always first
    array_unshift( $countries, 'India' );
    return apply_filters( 'travzo_countries', $countries );
}

/** Map international countries → continent/sub-region for Level 3 taxonomy. */
function travzo_get_country_continent_map() {
    return apply_filters( 'travzo_country_continent_map', [
        // Southeast Asia
        'Thailand' => 'Southeast Asia', 'Singapore' => 'Southeast Asia', 'Malaysia' => 'Southeast Asia',
        'Indonesia' => 'Southeast Asia', 'Vietnam' => 'Southeast Asia', 'Cambodia' => 'Southeast Asia',
        'Philippines' => 'Southeast Asia', 'Myanmar' => 'Southeast Asia', 'Laos' => 'Southeast Asia',
        'Brunei' => 'Southeast Asia', 'Timor-Leste' => 'Southeast Asia',
        // East Asia
        'Japan' => 'East Asia', 'South Korea' => 'East Asia', 'China' => 'East Asia',
        'Hong Kong' => 'East Asia', 'Taiwan' => 'East Asia', 'North Korea' => 'East Asia',
        'Mongolia' => 'East Asia',
        // South Asia (excl India)
        'Sri Lanka' => 'Southeast Asia', 'Nepal' => 'Southeast Asia', 'Bhutan' => 'Southeast Asia',
        'Maldives' => 'Southeast Asia', 'Bangladesh' => 'Southeast Asia', 'Pakistan' => 'Southeast Asia',
        'Afghanistan' => 'Middle East',
        // Middle East
        'UAE' => 'Middle East', 'Saudi Arabia' => 'Middle East', 'Oman' => 'Middle East',
        'Qatar' => 'Middle East', 'Bahrain' => 'Middle East', 'Jordan' => 'Middle East',
        'Israel' => 'Middle East', 'Turkey' => 'Middle East', 'Kuwait' => 'Middle East',
        'Iraq' => 'Middle East', 'Iran' => 'Middle East', 'Lebanon' => 'Middle East',
        'Syria' => 'Middle East', 'Yemen' => 'Middle East', 'Palestine' => 'Middle East',
        // Europe
        'France' => 'Europe', 'Italy' => 'Europe', 'Switzerland' => 'Europe', 'Germany' => 'Europe',
        'Spain' => 'Europe', 'Portugal' => 'Europe', 'Greece' => 'Europe', 'United Kingdom' => 'Europe',
        'Netherlands' => 'Europe', 'Belgium' => 'Europe', 'Austria' => 'Europe', 'Czech Republic' => 'Europe',
        'Hungary' => 'Europe', 'Croatia' => 'Europe', 'Iceland' => 'Europe', 'Norway' => 'Europe',
        'Sweden' => 'Europe', 'Denmark' => 'Europe', 'Finland' => 'Europe', 'Ireland' => 'Europe',
        'Russia' => 'Europe', 'Poland' => 'Europe', 'Romania' => 'Europe', 'Bulgaria' => 'Europe',
        'Serbia' => 'Europe', 'Montenegro' => 'Europe', 'Albania' => 'Europe', 'North Macedonia' => 'Europe',
        'Bosnia and Herzegovina' => 'Europe', 'Slovenia' => 'Europe', 'Slovakia' => 'Europe',
        'Estonia' => 'Europe', 'Latvia' => 'Europe', 'Lithuania' => 'Europe', 'Luxembourg' => 'Europe',
        'Malta' => 'Europe', 'Cyprus' => 'Europe', 'Monaco' => 'Europe', 'Liechtenstein' => 'Europe',
        'Andorra' => 'Europe', 'San Marino' => 'Europe', 'Vatican City' => 'Europe',
        'Moldova' => 'Europe', 'Belarus' => 'Europe', 'Ukraine' => 'Europe',
        'Georgia' => 'Europe', 'Armenia' => 'Europe', 'Azerbaijan' => 'Europe',
        // Africa
        'Egypt' => 'Africa', 'South Africa' => 'Africa', 'Kenya' => 'Africa', 'Tanzania' => 'Africa',
        'Morocco' => 'Africa', 'Mauritius' => 'Africa', 'Seychelles' => 'Africa', 'Tunisia' => 'Africa',
        'Ethiopia' => 'Africa', 'Ghana' => 'Africa', 'Nigeria' => 'Africa', 'Senegal' => 'Africa',
        'Rwanda' => 'Africa', 'Uganda' => 'Africa', 'Namibia' => 'Africa', 'Botswana' => 'Africa',
        'Madagascar' => 'Africa', 'Mozambique' => 'Africa', 'Zimbabwe' => 'Africa', 'Zambia' => 'Africa',
        'Cameroon' => 'Africa', 'Ivory Coast' => 'Africa', 'Algeria' => 'Africa', 'Libya' => 'Africa',
        'Angola' => 'Africa', 'Mali' => 'Africa', 'Niger' => 'Africa', 'Chad' => 'Africa',
        'Burkina Faso' => 'Africa', 'Benin' => 'Africa', 'Togo' => 'Africa', 'Sierra Leone' => 'Africa',
        'Liberia' => 'Africa', 'Guinea' => 'Africa', 'Guinea-Bissau' => 'Africa', 'Gambia' => 'Africa',
        'Gabon' => 'Africa', 'Congo (Brazzaville)' => 'Africa', 'Congo (Kinshasa)' => 'Africa',
        'Central African Republic' => 'Africa', 'Equatorial Guinea' => 'Africa', 'Burundi' => 'Africa',
        'Comoros' => 'Africa', 'Cabo Verde' => 'Africa', 'Djibouti' => 'Africa', 'Eritrea' => 'Africa',
        'Eswatini' => 'Africa', 'Lesotho' => 'Africa', 'Malawi' => 'Africa', 'Mauritania' => 'Africa',
        'Sao Tome and Principe' => 'Africa', 'Somalia' => 'Africa', 'South Sudan' => 'Africa',
        'Sudan' => 'Africa',
        // Americas
        'USA' => 'Americas', 'Canada' => 'Americas', 'Mexico' => 'Americas', 'Brazil' => 'Americas',
        'Argentina' => 'Americas', 'Peru' => 'Americas', 'Colombia' => 'Americas',
        'Costa Rica' => 'Americas', 'Cuba' => 'Americas', 'Chile' => 'Americas',
        'Ecuador' => 'Americas', 'Bolivia' => 'Americas', 'Paraguay' => 'Americas',
        'Uruguay' => 'Americas', 'Venezuela' => 'Americas', 'Panama' => 'Americas',
        'Guatemala' => 'Americas', 'Honduras' => 'Americas', 'El Salvador' => 'Americas',
        'Nicaragua' => 'Americas', 'Belize' => 'Americas', 'Jamaica' => 'Americas',
        'Trinidad and Tobago' => 'Americas', 'Barbados' => 'Americas', 'Bahamas' => 'Americas',
        'Dominican Republic' => 'Americas', 'Haiti' => 'Americas', 'Guyana' => 'Americas',
        'Suriname' => 'Americas', 'Grenada' => 'Americas', 'Saint Lucia' => 'Americas',
        'Dominica' => 'Americas', 'Saint Kitts and Nevis' => 'Americas',
        'Saint Vincent and the Grenadines' => 'Americas', 'Antigua and Barbuda' => 'Americas',
        // Oceania
        'Australia' => 'Oceania', 'New Zealand' => 'Oceania', 'Fiji' => 'Oceania',
        'Papua New Guinea' => 'Oceania', 'Samoa' => 'Oceania', 'Tonga' => 'Oceania',
        'Vanuatu' => 'Oceania', 'Solomon Islands' => 'Oceania', 'Kiribati' => 'Oceania',
        'Micronesia' => 'Oceania', 'Palau' => 'Oceania', 'Marshall Islands' => 'Oceania',
        'Nauru' => 'Oceania', 'Tuvalu' => 'Oceania',
        // Central Asia
        'Kazakhstan' => 'East Asia', 'Uzbekistan' => 'East Asia', 'Kyrgyzstan' => 'East Asia',
        'Tajikistan' => 'East Asia', 'Turkmenistan' => 'East Asia',
    ] );
}

/** Map Indian destinations (from _package_destinations) → India sub-region for Level 3. */
function travzo_get_india_region_map() {
    return apply_filters( 'travzo_india_region_map', [
        // North India
        'Delhi' => 'North India', 'Agra' => 'North India', 'Jaipur' => 'North India',
        'Lucknow' => 'North India', 'Varanasi' => 'North India', 'Amritsar' => 'North India',
        'Chandigarh' => 'North India', 'Haridwar' => 'North India', 'Rishikesh' => 'North India',
        'Mathura' => 'North India', 'Vrindavan' => 'North India', 'Allahabad' => 'North India',
        'Ayodhya' => 'North India', 'Udaipur' => 'North India', 'Jodhpur' => 'North India',
        'Jaisalmer' => 'North India', 'Pushkar' => 'North India', 'Ranthambore' => 'North India',
        'Rajasthan' => 'North India', 'Uttar Pradesh' => 'North India',
        // South India
        'Kerala' => 'South India', 'Munnar' => 'South India', 'Alleppey' => 'South India',
        'Kochi' => 'South India', 'Thekkady' => 'South India', 'Wayanad' => 'South India',
        'Ooty' => 'South India', 'Kodaikanal' => 'South India', 'Coorg' => 'South India',
        'Mysore' => 'South India', 'Hampi' => 'South India', 'Bangalore' => 'South India',
        'Chennai' => 'South India', 'Pondicherry' => 'South India', 'Madurai' => 'South India',
        'Rameswaram' => 'South India', 'Kanyakumari' => 'South India', 'Thanjavur' => 'South India',
        'Hyderabad' => 'South India', 'Tirupati' => 'South India', 'Vizag' => 'South India',
        'Tamil Nadu' => 'South India', 'Karnataka' => 'South India', 'Andhra Pradesh' => 'South India',
        'Telangana' => 'South India',
        // West India
        'Goa' => 'West India', 'Mumbai' => 'West India', 'Pune' => 'West India',
        'Lonavala' => 'West India', 'Mahabaleshwar' => 'West India', 'Shirdi' => 'West India',
        'Nashik' => 'West India', 'Aurangabad' => 'West India', 'Ajanta' => 'West India',
        'Ellora' => 'West India', 'Gujarat' => 'West India', 'Ahmedabad' => 'West India',
        'Kutch' => 'West India', 'Dwarka' => 'West India', 'Somnath' => 'West India',
        'Mount Abu' => 'West India', 'Daman' => 'West India', 'Diu' => 'West India',
        'Maharashtra' => 'West India',
        // East India
        'Kolkata' => 'East India', 'Darjeeling' => 'East India', 'Sikkim' => 'East India',
        'Gangtok' => 'East India', 'Puri' => 'East India', 'Bhubaneswar' => 'East India',
        'Konark' => 'East India', 'Odisha' => 'East India', 'West Bengal' => 'East India',
        'Jharkhand' => 'East India', 'Bihar' => 'East India', 'Patna' => 'East India',
        'Bodh Gaya' => 'East India', 'Ranchi' => 'East India',
        // Northeast India
        'Assam' => 'Northeast India', 'Meghalaya' => 'Northeast India', 'Shillong' => 'Northeast India',
        'Cherrapunji' => 'Northeast India', 'Kaziranga' => 'Northeast India',
        'Arunachal Pradesh' => 'Northeast India', 'Tawang' => 'Northeast India',
        'Nagaland' => 'Northeast India', 'Manipur' => 'Northeast India',
        'Mizoram' => 'Northeast India', 'Tripura' => 'Northeast India',
        'Guwahati' => 'Northeast India', 'Majuli' => 'Northeast India',
        // Himalayas
        'Shimla' => 'Himalayas', 'Manali' => 'Himalayas', 'Leh' => 'Himalayas',
        'Ladakh' => 'Himalayas', 'Spiti' => 'Himalayas', 'Dharamshala' => 'Himalayas',
        'McLeod Ganj' => 'Himalayas', 'Kasol' => 'Himalayas', 'Kullu' => 'Himalayas',
        'Dalhousie' => 'Himalayas', 'Mussoorie' => 'Himalayas', 'Nainital' => 'Himalayas',
        'Almora' => 'Himalayas', 'Auli' => 'Himalayas', 'Kedarnath' => 'Himalayas',
        'Badrinath' => 'Himalayas', 'Gangotri' => 'Himalayas', 'Yamunotri' => 'Himalayas',
        'Valley of Flowers' => 'Himalayas', 'Uttarakhand' => 'Himalayas',
        'Himachal Pradesh' => 'Himalayas', 'Jammu and Kashmir' => 'Himalayas',
        'Srinagar' => 'Himalayas', 'Pahalgam' => 'Himalayas', 'Gulmarg' => 'Himalayas',
        'Sonmarg' => 'Himalayas',
        'Andaman' => 'South India', 'Andaman and Nicobar' => 'South India',
        'Lakshadweep' => 'South India',
    ] );
}

/** Detect India sub-region from the destinations field. */
function travzo_detect_india_subregion( $destinations_str ) {
    $map   = travzo_get_india_region_map();
    $dests = array_map( 'trim', explode( ',', $destinations_str ) );
    foreach ( $dests as $d ) {
        if ( isset( $map[ $d ] ) ) return $map[ $d ];
    }
    return '';
}

/**
 * Count published packages matching a set of tile filters.
 * Uses a 1-hour transient cache keyed on the filter combination.
 *
 * @param array $filters { type, region, country, subregion, destination, duration, budget }
 * @return int
 */
function travzo_tile_count_packages( $filters ) {
    $cache_key = 'travzo_tile_cnt_' . md5( serialize( $filters ) );
    $cached    = get_transient( $cache_key );
    if ( false !== $cached ) {
        return (int) $cached;
    }

    $meta_query = [ 'relation' => 'AND' ];
    $tax_query  = [];

    // Package Type
    $type = trim( $filters['type'] ?? '' );
    if ( $type ) {
        $meta_query[] = [
            'key'     => '_package_type',
            'value'   => $type,
            'compare' => '=',
        ];
    }

    // Region
    $region = trim( $filters['region'] ?? '' );
    if ( $region ) {
        $meta_query[] = [
            'key'     => '_pkg_region',
            'value'   => $region,
            'compare' => '=',
        ];
    }

    // Country
    $country = trim( $filters['country'] ?? '' );
    if ( $country ) {
        $meta_query[] = [
            'key'     => '_pkg_country',
            'value'   => $country,
            'compare' => '=',
        ];
    }

    // Destination (LIKE match)
    $destination = trim( $filters['destination'] ?? '' );
    if ( $destination ) {
        $meta_query[] = [
            'key'     => '_package_destinations',
            'value'   => $destination,
            'compare' => 'LIKE',
        ];
    }

    // Sub-region (taxonomy)
    $subregion = trim( $filters['subregion'] ?? '' );
    if ( $subregion ) {
        $tax_query[] = [
            'taxonomy' => 'package_destination',
            'field'    => 'name',
            'terms'    => $subregion,
        ];
    }

    // Duration
    $duration = trim( $filters['duration'] ?? '' );
    if ( $duration ) {
        $dur_label_map = [
            '3-5'  => '3-5 Days',
            '6-8'  => '6-8 Days',
            '9-12' => '9-12 Days',
            '13+'  => '13+',
        ];
        if ( isset( $dur_label_map[ $duration ] ) ) {
            $meta_query[] = [
                'key'     => '_package_duration',
                'value'   => $dur_label_map[ $duration ],
                'compare' => 'LIKE',
            ];
        }
    }

    // Budget
    $budget = trim( $filters['budget'] ?? '' );
    if ( $budget ) {
        $budget_clauses = [
            'under-15000' => [ 'key' => '_package_price', 'value' => 15000,            'compare' => '<',       'type' => 'NUMERIC' ],
            '15000-30000' => [ 'key' => '_package_price', 'value' => [ 15000, 30000 ], 'compare' => 'BETWEEN', 'type' => 'NUMERIC' ],
            '30000-60000' => [ 'key' => '_package_price', 'value' => [ 30000, 60000 ], 'compare' => 'BETWEEN', 'type' => 'NUMERIC' ],
            'above-60000' => [ 'key' => '_package_price', 'value' => 60000,            'compare' => '>',       'type' => 'NUMERIC' ],
        ];
        if ( isset( $budget_clauses[ $budget ] ) ) {
            $meta_query[] = $budget_clauses[ $budget ];
        }
    }

    $args = [
        'post_type'      => 'package',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ];
    if ( count( $meta_query ) > 1 ) {
        $args['meta_query'] = $meta_query;
    }
    if ( ! empty( $tax_query ) ) {
        $args['tax_query'] = $tax_query;
    }

    $q     = new WP_Query( $args );
    $count = $q->found_posts;
    wp_reset_postdata();

    set_transient( $cache_key, $count, HOUR_IN_SECONDS );
    return $count;
}

/**
 * Build a packages archive URL from tile filter values.
 * Only includes params with non-empty values.
 *
 * @param array $filters { type, region, country, subregion, destination, duration, budget }
 * @return string
 */
function travzo_tile_build_url( $filters ) {
    $base   = get_post_type_archive_link( 'package' ) ?: home_url( '/packages/' );
    $params = [];

    $map = [
        'type'        => 'type',
        'region'      => 'region',
        'country'     => 'country',
        'subregion'   => 'subregion',
        'destination' => 'destination',
        'duration'    => 'duration',
        'budget'      => 'budget',
    ];

    foreach ( $map as $tile_key => $url_param ) {
        $val = trim( $filters[ $tile_key ] ?? '' );
        if ( $val ) {
            $params[ $url_param ] = $val;
        }
    }

    return $params ? add_query_arg( $params, $base ) : $base;
}

// ══════════════════════════════════════════════════════════════════════════════
// META BOXES – PACKAGE POST TYPE
// ══════════════════════════════════════════════════════════════════════════════
add_action( 'add_meta_boxes', function () {
    add_meta_box( 'travzo_package_details', 'Package Details',
        'travzo_package_details_cb', 'package', 'normal', 'high' );
    add_meta_box( 'travzo_package_type_fields', 'Type-Specific Details',
        'travzo_package_type_fields_cb', 'package', 'normal', 'high' );
    add_meta_box( 'travzo_package_highlights', 'Package Highlights',
        'travzo_package_highlights_cb', 'package', 'normal', 'default' );
    add_meta_box( 'travzo_package_content', 'Package Inclusions & Exclusions',
        'travzo_package_content_cb', 'package', 'normal', 'default' );
    add_meta_box( 'travzo_package_itinerary', 'Day by Day Itinerary',
        'travzo_package_itinerary_cb', 'package', 'normal', 'default' );
    add_meta_box( 'travzo_package_hotels', 'Hotel & Accommodation Details',
        'travzo_package_hotels_cb', 'package', 'normal', 'default' );
    add_meta_box( 'travzo_package_pricing', 'Package Pricing',
        'travzo_package_pricing_cb', 'package', 'normal', 'default' );
    add_meta_box( 'travzo_package_important_info', 'Important Information',
        'travzo_package_important_info_cb', 'package', 'normal', 'default' );
    add_meta_box( 'travzo_package_gallery', 'Photo Gallery',
        'travzo_package_gallery_cb', 'package', 'normal', 'default' );
} );

function travzo_package_details_cb( $post ) {
    wp_nonce_field( 'travzo_package_save', 'travzo_package_nonce' );

    $pkg_type    = get_post_meta( $post->ID, '_package_type', true );
    $pkg_country = get_post_meta( $post->ID, '_pkg_country', true );
    $pkg_region  = get_post_meta( $post->ID, '_pkg_region', true );
    $pkg_price   = get_post_meta( $post->ID, '_package_price', true );
    $pkg_dur     = get_post_meta( $post->ID, '_package_duration', true );
    $pkg_dest    = get_post_meta( $post->ID, '_package_destinations', true );
    $pkg_dl      = get_post_meta( $post->ID, '_package_download_url', true );
    $pkg_gs      = get_post_meta( $post->ID, '_package_group_size', true );

    $types     = [ 'Group Tour', 'Honeymoon', 'Solo Trip', 'Devotional', 'Destination Wedding', 'International' ];
    $countries = travzo_get_countries();

    // Package Type
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Package Type</label>';
    echo '<select name="_package_type" id="travzo_package_type" style="width:100%">';
    foreach ( $types as $opt ) {
        echo '<option value="' . esc_attr( $opt ) . '"' . selected( $pkg_type, $opt, false ) . '>' . esc_html( $opt ) . '</option>';
    }
    echo '</select></p>';

    // Country
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Country</label>';
    echo '<small style="color:#666;display:block;margin-bottom:6px">Region (Domestic / International) is auto-computed from this field.</small>';
    echo '<select name="_pkg_country" style="width:100%">';
    echo '<option value="">— Select Country —</option>';
    foreach ( $countries as $c ) {
        echo '<option value="' . esc_attr( $c ) . '"' . selected( $pkg_country, $c, false ) . '>' . esc_html( $c ) . '</option>';
    }
    echo '</select></p>';

    // Region (read-only display)
    if ( $pkg_region ) {
        echo '<p style="background:#f0f0f1;padding:8px 12px;border-radius:4px;margin-bottom:16px">';
        echo '<strong>Region:</strong> ' . esc_html( ucfirst( $pkg_region ) );
        echo '</p>';
    }

    // Starting Price
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Starting Price (numbers only, e.g. 15000)</label>';
    echo '<input type="number" name="_package_price" value="' . esc_attr( $pkg_price ) . '" style="width:100%" min="0" step="1" placeholder="e.g. 15000"></p>';

    // Duration
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Duration (e.g. 4 Nights / 5 Days)</label>';
    echo '<input type="text" name="_package_duration" value="' . esc_attr( $pkg_dur ) . '" style="width:100%"></p>';

    // Destinations
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Destinations Covered</label>';
    echo '<small style="color:#666;display:block;margin-bottom:6px">Use commas only — e.g. Dubai, Abu Dhabi. Do NOT use pipes (|).</small>';
    echo '<input type="text" name="_package_destinations" value="' . esc_attr( $pkg_dest ) . '" style="width:100%"></p>';

    // Group Size (optional, all types)
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Group Size</label>';
    echo '<small style="color:#666;display:block;margin-bottom:6px">Optional. Leave empty to hide this from the package page. e.g. 2-15 People</small>';
    echo '<input type="text" name="_package_group_size" value="' . esc_attr( $pkg_gs ) . '" style="width:100%" placeholder="e.g. 2-15 People"></p>';

    // Download URL
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Download Itinerary PDF URL</label>';
    echo '<small style="color:#666;display:block;margin-bottom:6px">Paste the full URL of the PDF file to download.</small>';
    echo '<input type="url" name="_package_download_url" value="' . esc_attr( $pkg_dl ) . '" style="width:100%" placeholder="https://example.com/itinerary.pdf"></p>';
}

// ── Type-Specific Fields (conditional on package type) ──────────────────────
function travzo_package_type_fields_cb( $post ) {
    wp_nonce_field( 'travzo_pkg_group_save', 'travzo_pkg_group_nonce' );
    wp_nonce_field( 'travzo_pkg_honeymoon_save', 'travzo_pkg_honeymoon_nonce' );
    wp_nonce_field( 'travzo_pkg_solo_save', 'travzo_pkg_solo_nonce' );
    wp_nonce_field( 'travzo_pkg_devotional_save', 'travzo_pkg_devotional_nonce' );

    $pkg_type = get_post_meta( $post->ID, '_package_type', true );

    // ── Group Tour fields ──
    $gt_departure_cities = get_post_meta( $post->ID, '_pkg_departure_cities', true );
    $gt_tour_manager     = get_post_meta( $post->ID, '_pkg_tour_manager', true );
    $gt_languages        = get_post_meta( $post->ID, '_pkg_languages', true );

    // ── Honeymoon fields ──
    $hm_couple_inclusions  = get_post_meta( $post->ID, '_pkg_couple_inclusions', true );
    $hm_romantic_activities = get_post_meta( $post->ID, '_pkg_romantic_activities', true );
    $hm_privacy_level      = get_post_meta( $post->ID, '_pkg_privacy_level', true );
    $hm_suite_type         = get_post_meta( $post->ID, '_pkg_suite_type', true );

    // ── Solo Trip fields ──
    $st_age_group       = get_post_meta( $post->ID, '_pkg_age_group', true );
    $st_safety_rating   = get_post_meta( $post->ID, '_pkg_safety_rating', true );
    $st_female_friendly = get_post_meta( $post->ID, '_pkg_female_friendly', true );
    $st_mixer_activities = get_post_meta( $post->ID, '_pkg_mixer_activities', true );
    $st_single_room     = get_post_meta( $post->ID, '_pkg_single_room', true );

    // ── Devotional fields ──
    $dv_religion    = get_post_meta( $post->ID, '_pkg_religion', true );
    $dv_temples     = get_post_meta( $post->ID, '_pkg_temples', true );
    $dv_pujas       = get_post_meta( $post->ID, '_pkg_pujas', true );
    $dv_dress_code  = get_post_meta( $post->ID, '_pkg_dress_code', true );
    $dv_vegetarian  = get_post_meta( $post->ID, '_pkg_vegetarian', true );
    $dv_priest      = get_post_meta( $post->ID, '_pkg_priest', true );

    $field_style = 'style="font-weight:600;display:block;margin-bottom:4px"';
    $small_style = 'style="color:#666;display:block;margin-bottom:6px;font-size:12px"';
    ?>
    <p <?php echo $small_style; ?>>These fields change based on the Package Type selected above. Save the post if you just changed the type and don't see the right fields.</p>

    <!-- ═══ GROUP TOUR FIELDS ═══ -->
    <div id="travzo-fields-group-tour" class="travzo-type-fields" data-type="group" style="display:none">
        <h4 style="border-bottom:1px solid #ddd;padding-bottom:8px;margin-top:16px">Group Tour Details</h4>
        <p><label <?php echo $field_style; ?>>Departure Cities</label>
        <small <?php echo $small_style; ?>>Comma-separated, e.g. Chennai, Bangalore, Mumbai</small>
        <input type="text" name="_pkg_departure_cities" value="<?php echo esc_attr( $gt_departure_cities ); ?>" style="width:100%"></p>

        <p><label style="display:flex;align-items:center;gap:8px;font-weight:600;cursor:pointer">
        <input type="checkbox" name="_pkg_tour_manager" value="1" <?php checked( $gt_tour_manager, '1' ); ?>>
        Tour Manager Included</label></p>

        <p><label <?php echo $field_style; ?>>Languages Offered</label>
        <small <?php echo $small_style; ?>>Comma-separated, e.g. English, Hindi, Tamil</small>
        <input type="text" name="_pkg_languages" value="<?php echo esc_attr( $gt_languages ); ?>" style="width:100%"></p>
    </div>

    <!-- ═══ HONEYMOON FIELDS ═══ -->
    <div id="travzo-fields-honeymoon" class="travzo-type-fields" data-type="honeymoon" style="display:none">
        <h4 style="border-bottom:1px solid #ddd;padding-bottom:8px;margin-top:16px">Honeymoon Details</h4>
        <p><label <?php echo $field_style; ?>>Couple Inclusions</label>
        <small <?php echo $small_style; ?>>One per line — e.g. Candlelight dinner, Couple spa, Flower decoration</small>
        <textarea name="_pkg_couple_inclusions" rows="4" style="width:100%"><?php echo esc_textarea( $hm_couple_inclusions ); ?></textarea></p>

        <p><label <?php echo $field_style; ?>>Romantic Activities</label>
        <small <?php echo $small_style; ?>>One per line — e.g. Sunset cruise, Private beach dinner</small>
        <textarea name="_pkg_romantic_activities" rows="4" style="width:100%"><?php echo esc_textarea( $hm_romantic_activities ); ?></textarea></p>

        <p><label <?php echo $field_style; ?>>Privacy Level</label>
        <select name="_pkg_privacy_level" style="width:100%">
            <option value="">— Select —</option>
            <?php foreach ( [ 'Standard', 'Private', 'Ultra-Private' ] as $pl ) : ?>
                <option value="<?php echo esc_attr( $pl ); ?>" <?php selected( $hm_privacy_level, $pl ); ?>><?php echo esc_html( $pl ); ?></option>
            <?php endforeach; ?>
        </select></p>

        <p><label <?php echo $field_style; ?>>Suite Type</label>
        <input type="text" name="_pkg_suite_type" value="<?php echo esc_attr( $hm_suite_type ); ?>" style="width:100%" placeholder="e.g. Honeymoon Suite, Pool Villa, Overwater Bungalow"></p>
    </div>

    <!-- ═══ SOLO TRIP FIELDS ═══ -->
    <div id="travzo-fields-solo-trip" class="travzo-type-fields" data-type="solo" style="display:none">
        <h4 style="border-bottom:1px solid #ddd;padding-bottom:8px;margin-top:16px">Solo Trip Details</h4>
        <p><label <?php echo $field_style; ?>>Target Age Group</label>
        <input type="text" name="_pkg_age_group" value="<?php echo esc_attr( $st_age_group ); ?>" style="width:100%" placeholder="e.g. 18-35, All Ages"></p>

        <p><label <?php echo $field_style; ?>>Safety Rating</label>
        <select name="_pkg_safety_rating" style="width:100%">
            <option value="">— Select —</option>
            <?php foreach ( [ '1 — Low', '2 — Moderate', '3 — Good', '4 — Very Safe', '5 — Excellent' ] as $sr ) : ?>
                <option value="<?php echo esc_attr( $sr ); ?>" <?php selected( $st_safety_rating, $sr ); ?>><?php echo esc_html( $sr ); ?></option>
            <?php endforeach; ?>
        </select></p>

        <p><label style="display:flex;align-items:center;gap:8px;font-weight:600;cursor:pointer">
        <input type="checkbox" name="_pkg_female_friendly" value="1" <?php checked( $st_female_friendly, '1' ); ?>>
        Female-Friendly Trip</label></p>

        <p><label <?php echo $field_style; ?>>Social Mixer Activities</label>
        <small <?php echo $small_style; ?>>One per line — e.g. Group dinner, City walking tour, Pub crawl</small>
        <textarea name="_pkg_mixer_activities" rows="4" style="width:100%"><?php echo esc_textarea( $st_mixer_activities ); ?></textarea></p>

        <p><label style="display:flex;align-items:center;gap:8px;font-weight:600;cursor:pointer">
        <input type="checkbox" name="_pkg_single_room" value="1" <?php checked( $st_single_room, '1' ); ?>>
        Single Room Guaranteed</label></p>
    </div>

    <!-- ═══ DEVOTIONAL FIELDS ═══ -->
    <div id="travzo-fields-devotional" class="travzo-type-fields" data-type="devotional" style="display:none">
        <h4 style="border-bottom:1px solid #ddd;padding-bottom:8px;margin-top:16px">Devotional Tour Details</h4>
        <p><label <?php echo $field_style; ?>>Religion / Faith</label>
        <select name="_pkg_religion" style="width:100%">
            <option value="">— Select —</option>
            <?php foreach ( [ 'Hinduism', 'Buddhism', 'Jainism', 'Sikhism', 'Christianity', 'Islam', 'Multi-faith' ] as $r ) : ?>
                <option value="<?php echo esc_attr( $r ); ?>" <?php selected( $dv_religion, $r ); ?>><?php echo esc_html( $r ); ?></option>
            <?php endforeach; ?>
        </select></p>

        <p><label <?php echo $field_style; ?>>Temples / Holy Sites Covered</label>
        <small <?php echo $small_style; ?>>One per line — e.g. Tirupati Balaji, Meenakshi Temple</small>
        <textarea name="_pkg_temples" rows="4" style="width:100%"><?php echo esc_textarea( $dv_temples ); ?></textarea></p>

        <p><label <?php echo $field_style; ?>>Pujas / Rituals Included</label>
        <small <?php echo $small_style; ?>>One per line — e.g. Ganga Aarti, Special Darshan</small>
        <textarea name="_pkg_pujas" rows="4" style="width:100%"><?php echo esc_textarea( $dv_pujas ); ?></textarea></p>

        <p><label <?php echo $field_style; ?>>Dress Code / Guidelines</label>
        <input type="text" name="_pkg_dress_code" value="<?php echo esc_attr( $dv_dress_code ); ?>" style="width:100%" placeholder="e.g. Traditional attire recommended, Modest clothing required"></p>

        <p><label style="display:flex;align-items:center;gap:8px;font-weight:600;cursor:pointer">
        <input type="checkbox" name="_pkg_vegetarian" value="1" <?php checked( $dv_vegetarian, '1' ); ?>>
        Vegetarian Meals Only</label></p>

        <p><label <?php echo $field_style; ?>>Priest / Pandit Availability</label>
        <select name="_pkg_priest" style="width:100%">
            <option value="">— Select —</option>
            <?php foreach ( [ 'Included', 'Available on Request', 'Not Available' ] as $pa ) : ?>
                <option value="<?php echo esc_attr( $pa ); ?>" <?php selected( $dv_priest, $pa ); ?>><?php echo esc_html( $pa ); ?></option>
            <?php endforeach; ?>
        </select></p>
    </div>

    <script>
    jQuery(function($){
        var map = {
            'Group Tour':     '#travzo-fields-group-tour',
            'Honeymoon':      '#travzo-fields-honeymoon',
            'Solo Trip':      '#travzo-fields-solo-trip',
            'Devotional':     '#travzo-fields-devotional'
        };
        function toggleTypeFields() {
            var val = $('#travzo_package_type').val();
            $('.travzo-type-fields').hide();
            if (map[val]) $(map[val]).show();
        }
        $('#travzo_package_type').on('change', toggleTypeFields);
        toggleTypeFields();
    });
    </script>
    <?php
}

// ── Highlights Repeater ──────────────────────────────────────────────────────
function travzo_package_highlights_cb( $post ) {
    wp_nonce_field( 'travzo_pkg_highlights_save', 'travzo_pkg_highlights_nonce' );

    $highlights = get_post_meta( $post->ID, '_pkg_highlights', true );

    // Backward compat: migrate from _pkg_highlights_v2 JSON array
    if ( ! $highlights ) {
        $v2 = get_post_meta( $post->ID, '_pkg_highlights_v2', true );
        if ( is_array( $v2 ) && ! empty( $v2 ) ) {
            $highlights = implode( "\n", $v2 );
            update_post_meta( $post->ID, '_pkg_highlights', $highlights );
        }
    }
    // Backward compat: migrate from old _package_highlights
    if ( ! $highlights ) {
        $old = get_post_meta( $post->ID, '_package_highlights', true );
        if ( $old ) {
            $highlights = $old;
        }
    }
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:8px">One highlight per line. Each item appears as a bullet point on the package page.</p>
    <textarea name="_pkg_highlights" class="widefat" rows="8" placeholder="Expert local guides&#10;All meals included&#10;Airport transfers"><?php echo esc_textarea( $highlights ); ?></textarea>
    <?php
}

// ── Inclusions & Exclusions ──────────────────────────────────────────────────
function travzo_package_content_cb( $post ) {
    wp_nonce_field( 'travzo_pkg_content_save', 'travzo_pkg_content_nonce' );
    $inclusions = get_post_meta( $post->ID, '_package_inclusions', true );
    $exclusions = get_post_meta( $post->ID, '_package_exclusions', true );
    ?>
    <p>
        <label style="font-weight:600;display:block;margin-bottom:4px">Inclusions (What's Included)</label>
        <small style="color:#666;display:block;margin-bottom:6px">One item per line. Example:<br>Return airfare (economy class)<br>Hotel accommodation as per package<br>Daily breakfast included</small>
        <textarea name="_package_inclusions" rows="6" style="width:100%"><?php echo esc_textarea( $inclusions ); ?></textarea>
    </p>
    <p>
        <label style="font-weight:600;display:block;margin-bottom:4px">Exclusions (What's Not Included)</label>
        <small style="color:#666;display:block;margin-bottom:6px">One item per line. Example:<br>Personal expenses<br>Travel insurance<br>Visa fees</small>
        <textarea name="_package_exclusions" rows="6" style="width:100%"><?php echo esc_textarea( $exclusions ); ?></textarea>
    </p>
    <?php
}

// ── Itinerary Repeater ────────────────────────────────────────────────────────
function travzo_package_itinerary_cb( $post ) {
    wp_nonce_field( 'travzo_pkg_itinerary_save', 'travzo_pkg_itinerary_nonce' );

    // Backward compat: import old pipe-separated data
    $itinerary = get_post_meta( $post->ID, '_pkg_itinerary_v2', true );
    if ( ! $itinerary || ! is_array( $itinerary ) ) {
        $old = get_post_meta( $post->ID, '_package_itinerary', true );
        if ( $old ) {
            $parsed   = travzo_parse_lines( $old, 2 );
            $itinerary = [];
            foreach ( $parsed as $row ) {
                $itinerary[] = [
                    'day_title'   => $row[0] ?? '',
                    'description' => $row[1] ?? '',
                ];
            }
        } else {
            $itinerary = [];
        }
    }
    $json = wp_json_encode( $itinerary );
    ?>
    <input type="hidden" name="_pkg_itinerary_v2" id="pkg_itinerary_data" value="<?php echo esc_attr( $json ); ?>">
    <div id="pkg-itinerary-repeater">
        <p style="color:#666;font-size:12px;margin-bottom:12px">Add each day of the itinerary. The Day Title appears as the badge label (e.g. "Day 1: Arrival & Welcome").</p>
        <div id="pkg-itinerary-rows"></div>
        <button type="button" class="button" id="pkg-itinerary-add" style="margin-top:8px">+ Add Day</button>
    </div>
    <script>
    jQuery(function($){
        var data = <?php echo $json; ?>;
        var $rows = $('#pkg-itinerary-rows');
        var $hidden = $('#pkg_itinerary_data');

        function sync() {
            var arr = [];
            $rows.find('.pkg-itin-row').each(function(){
                var dt = $(this).find('.itin-title').val().trim();
                var dd = $(this).find('.itin-desc').val().trim();
                if (dt || dd) arr.push({ day_title: dt, description: dd });
            });
            $hidden.val(JSON.stringify(arr));
        }

        function addRow(item) {
            item = item || { day_title: '', description: '' };
            var idx = $rows.find('.pkg-itin-row').length + 1;
            var $row = $('<div class="pkg-itin-row" style="border:1px solid #ddd;padding:12px;margin-bottom:10px;border-radius:4px;background:#fafafa">' +
                '<div style="display:flex;gap:8px;align-items:center;margin-bottom:8px">' +
                    '<strong style="white-space:nowrap">Day ' + idx + '</strong>' +
                    '<input type="text" class="itin-title" style="flex:1" placeholder="e.g. Day 1: Arrival & Welcome">' +
                    '<button type="button" class="button" style="color:#b32d2e">&times; Remove</button>' +
                '</div>' +
                '<textarea class="itin-desc" rows="3" style="width:100%" placeholder="Describe the day\'s activities..."></textarea>' +
            '</div>');
            $row.find('.itin-title').val(item.day_title || '');
            $row.find('.itin-desc').val(item.description || '');
            $rows.append($row);
        }

        function renumber() {
            $rows.find('.pkg-itin-row').each(function(i){
                $(this).find('strong').text('Day ' + (i + 1));
            });
        }

        if (data.length) {
            $.each(data, function(i, item){ addRow(item); });
        } else {
            addRow();
        }

        $('#pkg-itinerary-add').on('click', function(){ addRow(); renumber(); });
        $rows.on('click', '.button', function(){ $(this).closest('.pkg-itin-row').remove(); renumber(); sync(); });
        $rows.on('input change', 'input, textarea', sync);
    });
    </script>
    <?php
}

// ── Hotels Repeater ──────────────────────────────────────────────────────────
function travzo_package_hotels_cb( $post ) {
    wp_nonce_field( 'travzo_pkg_hotels_save', 'travzo_pkg_hotels_nonce' );
    wp_enqueue_media();

    // Backward compat: import old pipe-separated data
    $hotels = get_post_meta( $post->ID, '_pkg_hotels_v2', true );
    if ( ! $hotels || ! is_array( $hotels ) ) {
        $old = get_post_meta( $post->ID, '_package_hotels', true );
        if ( $old ) {
            $parsed = travzo_parse_lines( $old, 4 );
            $hotels = [];
            foreach ( $parsed as $row ) {
                $hotels[] = [
                    'name'      => $row[0] ?? '',
                    'stars'     => $row[1] ?? '3',
                    'location'  => $row[2] ?? '',
                    'room_type' => $row[3] ?? '',
                    'image'     => '',
                ];
            }
        } else {
            $hotels = [];
        }
    }
    $json = wp_json_encode( $hotels );
    ?>
    <input type="hidden" name="_pkg_hotels_v2" id="pkg_hotels_data" value="<?php echo esc_attr( $json ); ?>">
    <div id="pkg-hotels-repeater">
        <p style="color:#666;font-size:12px;margin-bottom:12px">Add hotel / accommodation details for this package.</p>
        <div id="pkg-hotels-rows"></div>
        <button type="button" class="button" id="pkg-hotels-add" style="margin-top:8px">+ Add Hotel</button>
    </div>
    <script>
    jQuery(function($){
        var data = <?php echo $json; ?>;
        var $rows = $('#pkg-hotels-rows');
        var $hidden = $('#pkg_hotels_data');

        function sync() {
            var arr = [];
            $rows.find('.pkg-hotel-row').each(function(){
                var $r = $(this);
                var name = $r.find('.hotel-name').val().trim();
                if (!name) return;
                arr.push({
                    name:      name,
                    stars:     $r.find('.hotel-stars').val(),
                    location:  $r.find('.hotel-location').val().trim(),
                    room_type: $r.find('.hotel-room').val().trim(),
                    image:     $r.find('.hotel-img-url').val().trim()
                });
            });
            $hidden.val(JSON.stringify(arr));
        }

        function addRow(item) {
            item = item || { name:'', stars:'3', location:'', room_type:'', image:'' };
            var imgPreview = item.image ? '<img src="' + item.image + '" style="max-width:80px;max-height:60px;border-radius:4px;margin-right:8px">' : '';
            var $row = $('<div class="pkg-hotel-row" style="border:1px solid #ddd;padding:12px;margin-bottom:10px;border-radius:4px;background:#fafafa">' +
                '<div style="display:flex;gap:8px;margin-bottom:8px">' +
                    '<div style="flex:2"><label style="font-size:12px;font-weight:600;display:block;margin-bottom:2px">Hotel Name *</label>' +
                        '<input type="text" class="hotel-name" style="width:100%" placeholder="e.g. The Grand Heritage Hotel"></div>' +
                    '<div style="flex:1"><label style="font-size:12px;font-weight:600;display:block;margin-bottom:2px">Stars</label>' +
                        '<select class="hotel-stars" style="width:100%">' +
                        '<option value="2">2 Star</option><option value="3">3 Star</option>' +
                        '<option value="4">4 Star</option><option value="5">5 Star</option></select></div>' +
                    '<div style="flex:1"><label style="font-size:12px;font-weight:600;display:block;margin-bottom:2px">Location</label>' +
                        '<input type="text" class="hotel-location" style="width:100%" placeholder="e.g. City Centre"></div>' +
                '</div>' +
                '<div style="display:flex;gap:8px;align-items:flex-end">' +
                    '<div style="flex:1"><label style="font-size:12px;font-weight:600;display:block;margin-bottom:2px">Room Type</label>' +
                        '<input type="text" class="hotel-room" style="width:100%" placeholder="e.g. Deluxe Twin Room"></div>' +
                    '<div style="flex:1"><label style="font-size:12px;font-weight:600;display:block;margin-bottom:2px">Hotel Image</label>' +
                        '<div style="display:flex;gap:6px;align-items:center">' +
                        '<span class="hotel-img-preview">' + imgPreview + '</span>' +
                        '<input type="hidden" class="hotel-img-url">' +
                        '<button type="button" class="button hotel-img-btn">Choose Image</button>' +
                        '<button type="button" class="button hotel-img-remove" style="color:#b32d2e;' + (item.image ? '' : 'display:none') + '">&times;</button>' +
                    '</div></div>' +
                    '<button type="button" class="button hotel-remove-row" style="color:#b32d2e;white-space:nowrap">&times; Remove Hotel</button>' +
                '</div>' +
            '</div>');
            $row.find('.hotel-name').val(item.name);
            $row.find('.hotel-stars').val(item.stars || '3');
            $row.find('.hotel-location').val(item.location);
            $row.find('.hotel-room').val(item.room_type);
            $row.find('.hotel-img-url').val(item.image || '');
            $rows.append($row);
        }

        if (data.length) {
            $.each(data, function(i, item){ addRow(item); });
        } else {
            addRow();
        }

        $('#pkg-hotels-add').on('click', function(){ addRow(); });
        $rows.on('click', '.hotel-remove-row', function(){ $(this).closest('.pkg-hotel-row').remove(); sync(); });
        $rows.on('input change', 'input, select', sync);

        // Image upload via wp.media
        $rows.on('click', '.hotel-img-btn', function(e){
            e.preventDefault();
            var $btn = $(this);
            var $row = $btn.closest('.pkg-hotel-row');
            var frame = wp.media({ title: 'Select Hotel Image', multiple: false, library: { type: 'image' } });
            frame.on('select', function(){
                var url = frame.state().get('selection').first().toJSON().url;
                $row.find('.hotel-img-url').val(url);
                $row.find('.hotel-img-preview').html('<img src="' + url + '" style="max-width:80px;max-height:60px;border-radius:4px;margin-right:8px">');
                $row.find('.hotel-img-remove').show();
                sync();
            });
            frame.open();
        });
        $rows.on('click', '.hotel-img-remove', function(){
            var $row = $(this).closest('.pkg-hotel-row');
            $row.find('.hotel-img-url').val('');
            $row.find('.hotel-img-preview').html('');
            $(this).hide();
            sync();
        });
    });
    </script>
    <?php
}

function travzo_package_pricing_cb( $post ) {
    wp_nonce_field( 'travzo_pkg_pricing_save', 'travzo_pkg_pricing_nonce' );

    $pricing_visible = get_post_meta( $post->ID, '_pkg_pricing_visible', true );
    if ( $pricing_visible === '' ) $pricing_visible = '1'; // default checked
    $pricing_note        = get_post_meta( $post->ID, '_pkg_pricing_note', true );
    $pricing_recommended = get_post_meta( $post->ID, '_pkg_pricing_recommended', true );

    // Visibility + Note + Recommended
    echo '<div style="margin-bottom:16px;padding:12px;background:#f9f9f9;border:1px solid #ddd;border-radius:4px">';
    echo '<p><label style="display:flex;align-items:center;gap:8px;font-weight:600;cursor:pointer">';
    echo '<input type="checkbox" name="_pkg_pricing_visible" value="1"' . checked( $pricing_visible, '1', false ) . '>';
    echo 'Show Pricing Section on Frontend</label></p>';

    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Pricing Note / Subtitle</label>';
    echo '<input type="text" name="_pkg_pricing_note" value="' . esc_attr( $pricing_note ) . '" style="width:100%" placeholder="e.g. Prices are per person, exclusive of GST"></p>';

    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Recommended Tier</label>';
    echo '<select name="_pkg_pricing_recommended" style="width:100%">';
    echo '<option value="">None</option>';
    foreach ( [ 'Standard', 'Deluxe', 'Premium' ] as $tier ) {
        echo '<option value="' . esc_attr( $tier ) . '"' . selected( $pricing_recommended, $tier, false ) . '>' . esc_html( $tier ) . '</option>';
    }
    echo '</select></p>';
    echo '</div>';

    $pricing_fields = [
        '_price_standard_twin'   => 'Standard - Twin Sharing (₹)',
        '_price_standard_triple' => 'Standard - Triple Sharing (₹)',
        '_price_standard_single' => 'Standard - Single Room (₹)',
        '_price_deluxe_twin'     => 'Deluxe - Twin Sharing (₹)',
        '_price_deluxe_triple'   => 'Deluxe - Triple Sharing (₹)',
        '_price_deluxe_single'   => 'Deluxe - Single Room (₹)',
        '_price_premium_twin'    => 'Premium - Twin Sharing (₹)',
        '_price_premium_triple'  => 'Premium - Triple Sharing (₹)',
        '_price_premium_single'  => 'Premium - Single Room (₹)',
        '_price_child_bed'       => 'Child with Extra Bed (₹)',
        '_price_child_no_bed'    => 'Child without Extra Bed (₹)',
    ];
    echo '<p style="color:#666;font-size:12px;margin-bottom:12px">Enter numbers only (no commas or ₹ symbol). Example: 25000</p>';
    echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">';
    foreach ( $pricing_fields as $key => $label ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<p><label style="font-weight:600;display:block;margin-bottom:4px;font-size:13px">' . esc_html( $label ) . '</label>';
        echo '<input type="number" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" placeholder="e.g. 25000" min="0" step="1" style="width:100%"></p>';
    }
    echo '</div>';
}

// ── Photo Gallery ───────────────────────────────────────────────────────────
function travzo_package_gallery_cb( $post ) {
    wp_nonce_field( 'travzo_pkg_gallery_save', 'travzo_pkg_gallery_nonce' );
    wp_enqueue_media();

    $gallery_ids = get_post_meta( $post->ID, '_pkg_gallery', true );
    if ( ! is_array( $gallery_ids ) ) {
        $gallery_ids = $gallery_ids ? array_filter( array_map( 'absint', explode( ',', $gallery_ids ) ) ) : [];
    }
    $json = wp_json_encode( $gallery_ids );
    ?>
    <input type="hidden" name="_pkg_gallery" id="pkg_gallery_ids" value="<?php echo esc_attr( $json ); ?>">
    <p style="color:#666;font-size:12px;margin-bottom:12px">Select images from the media library. Drag thumbnails to reorder.</p>
    <div id="pkg-gallery-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px"></div>
    <button type="button" class="button" id="pkg-gallery-add">+ Add Images</button>
    <script>
    jQuery(function($){
        var $hidden  = $('#pkg_gallery_ids');
        var $preview = $('#pkg-gallery-preview');
        var ids      = <?php echo $json; ?>;

        function render() {
            $preview.empty();
            ids.forEach(function(id, idx) {
                var $thumb = $('<div style="position:relative;width:100px;height:100px;border-radius:6px;overflow:hidden;cursor:grab" data-idx="' + idx + '">');
                $thumb.append('<img src="" style="width:100%;height:100%;object-fit:cover">');
                $thumb.append('<button type="button" style="position:absolute;top:2px;right:2px;background:rgba(0,0,0,0.6);color:#fff;border:none;border-radius:50%;width:20px;height:20px;font-size:12px;cursor:pointer;line-height:20px;text-align:center">&times;</button>');
                // Load thumbnail
                var img = $thumb.find('img');
                if (wp.media.attachment(id).get('url')) {
                    img.attr('src', wp.media.attachment(id).get('sizes') && wp.media.attachment(id).get('sizes').thumbnail ? wp.media.attachment(id).get('sizes').thumbnail.url : wp.media.attachment(id).get('url'));
                } else {
                    wp.media.attachment(id).fetch().then(function() {
                        var sizes = wp.media.attachment(id).get('sizes');
                        img.attr('src', sizes && sizes.thumbnail ? sizes.thumbnail.url : wp.media.attachment(id).get('url'));
                    });
                }
                $thumb.find('button').on('click', function() {
                    ids.splice(idx, 1);
                    sync();
                    render();
                });
                $preview.append($thumb);
            });
        }

        function sync() {
            $hidden.val(JSON.stringify(ids));
        }

        // Make sortable
        $preview.sortable({
            tolerance: 'pointer',
            update: function() {
                var sorted = [];
                $preview.children().each(function() {
                    sorted.push(ids[$(this).data('idx')]);
                });
                ids = sorted;
                sync();
                render();
            }
        });

        // Add images button
        $('#pkg-gallery-add').on('click', function() {
            var frame = wp.media({
                title: 'Select Gallery Images',
                button: { text: 'Add to Gallery' },
                multiple: true
            });
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                selection.each(function(attachment) {
                    ids.push(attachment.id);
                });
                sync();
                render();
            });
            frame.open();
        });

        render();
    });
    </script>
    <?php
}

// ── Important Information Repeater ──────────────────────────────────────────
function travzo_package_important_info_cb( $post ) {
    wp_nonce_field( 'travzo_pkg_important_info_save', 'travzo_pkg_important_info_nonce' );

    $visible = get_post_meta( $post->ID, '_pkg_important_info_visible', true );
    if ( $visible === '' ) $visible = '1';
    $heading = get_post_meta( $post->ID, '_pkg_important_info_heading', true );
    if ( ! $heading ) $heading = 'Important Information';

    $items = get_post_meta( $post->ID, '_pkg_important_info', true );
    if ( ! $items || ! is_array( $items ) ) {
        // Default items on first load
        $items = [
            [ 'title' => 'Cancellation Policy', 'content' => '' ],
            [ 'title' => 'Payment Terms', 'content' => '' ],
            [ 'title' => 'Visa Information', 'content' => '' ],
            [ 'title' => 'Things to Carry', 'content' => '' ],
            [ 'title' => 'Important Notes', 'content' => '' ],
        ];
    }
    $json = wp_json_encode( $items );

    echo '<div style="margin-bottom:16px;padding:12px;background:#f9f9f9;border:1px solid #ddd;border-radius:4px">';
    echo '<p><label style="display:flex;align-items:center;gap:8px;font-weight:600;cursor:pointer">';
    echo '<input type="checkbox" name="_pkg_important_info_visible" value="1"' . checked( $visible, '1', false ) . '>';
    echo 'Show Important Information Section on Frontend</label></p>';
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Section Heading</label>';
    echo '<input type="text" name="_pkg_important_info_heading" value="' . esc_attr( $heading ) . '" style="width:100%"></p>';
    echo '</div>';
    ?>
    <input type="hidden" name="_pkg_important_info" id="pkg_important_info_data" value="<?php echo esc_attr( $json ); ?>">
    <div id="pkg-important-info-repeater">
        <p style="color:#666;font-size:12px;margin-bottom:12px">Add accordion items for the Important Information section. HTML is allowed in the content field.</p>
        <div id="pkg-info-rows"></div>
        <button type="button" class="button" id="pkg-info-add" style="margin-top:8px">+ Add Item</button>
    </div>
    <script>
    jQuery(function($){
        var data = <?php echo $json; ?>;
        var $rows = $('#pkg-info-rows');
        var $hidden = $('#pkg_important_info_data');

        function sync() {
            var items = [];
            $rows.find('.pkg-info-row').each(function(){
                var title = $(this).find('.pkg-info-title').val();
                var content = $(this).find('.pkg-info-content').val();
                if (title || content) items.push({ title: title, content: content });
            });
            $hidden.val(JSON.stringify(items));
        }

        function addRow(item) {
            item = item || { title: '', content: '' };
            var html = '<div class="pkg-info-row" style="border:1px solid #ddd;padding:12px;margin-bottom:8px;border-radius:4px;background:#fff">';
            html += '<p style="margin:0 0 8px"><label style="font-weight:600;display:block;margin-bottom:4px">Title</label>';
            html += '<input type="text" class="pkg-info-title" value="' + $('<span>').text(item.title).html() + '" style="width:100%"></p>';
            html += '<p style="margin:0 0 8px"><label style="font-weight:600;display:block;margin-bottom:4px">Content (HTML allowed)</label>';
            html += '<textarea class="pkg-info-content" rows="4" style="width:100%">' + $('<span>').text(item.content).html() + '</textarea></p>';
            html += '<button type="button" class="button" style="color:#b32d2e">Remove</button>';
            html += '</div>';
            $rows.append(html);
        }

        data.forEach(function(item){ addRow(item); });
        $('#pkg-info-add').on('click', function(){ addRow(); sync(); });
        $rows.on('click', '.button', function(){ $(this).closest('.pkg-info-row').remove(); sync(); });
        $rows.on('input change', 'input, textarea', sync);
    });
    </script>
    <?php
}

add_action( 'save_post_package', function ( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // ── Package Details (type, country, price, duration, destinations, group size, download URL) ──
    if ( isset( $_POST['travzo_package_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_package_nonce'] ) ), 'travzo_package_save' ) ) {

        $text_fields = [ '_package_type', '_package_duration', '_package_destinations' ];
        foreach ( $text_fields as $f ) {
            if ( isset( $_POST[ $f ] ) ) {
                update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
            }
        }
        // Country + auto-compute region
        if ( isset( $_POST['_pkg_country'] ) ) {
            $country = sanitize_text_field( wp_unslash( $_POST['_pkg_country'] ) );
            update_post_meta( $post_id, '_pkg_country', $country );
            $region = ( $country === 'India' || $country === '' ) ? 'domestic' : 'international';
            update_post_meta( $post_id, '_pkg_region', $region );
        }
        // Starting price (numeric)
        if ( isset( $_POST['_package_price'] ) ) {
            update_post_meta( $post_id, '_package_price', absint( $_POST['_package_price'] ) );
        }
        // Download URL
        if ( isset( $_POST['_package_download_url'] ) ) {
            update_post_meta( $post_id, '_package_download_url', esc_url_raw( wp_unslash( $_POST['_package_download_url'] ) ) );
        }
        // Group Size (optional, all types)
        if ( isset( $_POST['_package_group_size'] ) ) {
            update_post_meta( $post_id, '_package_group_size', sanitize_text_field( wp_unslash( $_POST['_package_group_size'] ) ) );
        }
    }

    // ── Group Tour Fields ──
    if ( isset( $_POST['travzo_pkg_group_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_group_nonce'] ) ), 'travzo_pkg_group_save' ) ) {

        $gt_text = [ '_pkg_departure_cities', '_pkg_languages' ];
        foreach ( $gt_text as $f ) {
            if ( isset( $_POST[ $f ] ) ) {
                update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
            }
        }
        update_post_meta( $post_id, '_pkg_tour_manager', isset( $_POST['_pkg_tour_manager'] ) ? '1' : '0' );
    }

    // ── Honeymoon Fields ──
    if ( isset( $_POST['travzo_pkg_honeymoon_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_honeymoon_nonce'] ) ), 'travzo_pkg_honeymoon_save' ) ) {

        $hm_text = [ '_pkg_privacy_level', '_pkg_suite_type' ];
        foreach ( $hm_text as $f ) {
            if ( isset( $_POST[ $f ] ) ) {
                update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
            }
        }
        $hm_ta = [ '_pkg_couple_inclusions', '_pkg_romantic_activities' ];
        foreach ( $hm_ta as $f ) {
            if ( isset( $_POST[ $f ] ) ) {
                update_post_meta( $post_id, $f, sanitize_textarea_field( wp_unslash( $_POST[ $f ] ) ) );
            }
        }
    }

    // ── Solo Trip Fields ──
    if ( isset( $_POST['travzo_pkg_solo_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_solo_nonce'] ) ), 'travzo_pkg_solo_save' ) ) {

        $st_text = [ '_pkg_age_group', '_pkg_safety_rating' ];
        foreach ( $st_text as $f ) {
            if ( isset( $_POST[ $f ] ) ) {
                update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
            }
        }
        update_post_meta( $post_id, '_pkg_female_friendly', isset( $_POST['_pkg_female_friendly'] ) ? '1' : '0' );
        update_post_meta( $post_id, '_pkg_single_room', isset( $_POST['_pkg_single_room'] ) ? '1' : '0' );
        if ( isset( $_POST['_pkg_mixer_activities'] ) ) {
            update_post_meta( $post_id, '_pkg_mixer_activities', sanitize_textarea_field( wp_unslash( $_POST['_pkg_mixer_activities'] ) ) );
        }
    }

    // ── Devotional Fields ──
    if ( isset( $_POST['travzo_pkg_devotional_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_devotional_nonce'] ) ), 'travzo_pkg_devotional_save' ) ) {

        $dv_text = [ '_pkg_religion', '_pkg_dress_code', '_pkg_priest' ];
        foreach ( $dv_text as $f ) {
            if ( isset( $_POST[ $f ] ) ) {
                update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
            }
        }
        update_post_meta( $post_id, '_pkg_vegetarian', isset( $_POST['_pkg_vegetarian'] ) ? '1' : '0' );
        $dv_ta = [ '_pkg_temples', '_pkg_pujas' ];
        foreach ( $dv_ta as $f ) {
            if ( isset( $_POST[ $f ] ) ) {
                update_post_meta( $post_id, $f, sanitize_textarea_field( wp_unslash( $_POST[ $f ] ) ) );
            }
        }
    }

    // ── Photo Gallery ──
    if ( isset( $_POST['travzo_pkg_gallery_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_gallery_nonce'] ) ), 'travzo_pkg_gallery_save' ) ) {

        $raw = isset( $_POST['_pkg_gallery'] ) ? wp_unslash( $_POST['_pkg_gallery'] ) : '[]';
        $parsed = json_decode( $raw, true );
        if ( ! is_array( $parsed ) ) {
            $parsed = array_filter( array_map( 'absint', explode( ',', $raw ) ) );
        } else {
            $parsed = array_filter( array_map( 'absint', $parsed ) );
        }
        update_post_meta( $post_id, '_pkg_gallery', $parsed );
    }

    // ── Highlights (textarea, one per line) ──
    if ( isset( $_POST['travzo_pkg_highlights_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_highlights_nonce'] ) ), 'travzo_pkg_highlights_save' ) ) {

        $raw = isset( $_POST['_pkg_highlights'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_pkg_highlights'] ) ) : '';
        update_post_meta( $post_id, '_pkg_highlights', $raw );
    }

    // ── Inclusions & Exclusions ──
    if ( isset( $_POST['travzo_pkg_content_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_content_nonce'] ) ), 'travzo_pkg_content_save' ) ) {

        if ( isset( $_POST['_package_inclusions'] ) ) {
            update_post_meta( $post_id, '_package_inclusions', sanitize_textarea_field( wp_unslash( $_POST['_package_inclusions'] ) ) );
        }
        if ( isset( $_POST['_package_exclusions'] ) ) {
            update_post_meta( $post_id, '_package_exclusions', sanitize_textarea_field( wp_unslash( $_POST['_package_exclusions'] ) ) );
        }
    }

    // ── Itinerary repeater ──
    if ( isset( $_POST['travzo_pkg_itinerary_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_itinerary_nonce'] ) ), 'travzo_pkg_itinerary_save' ) ) {

        $raw = isset( $_POST['_pkg_itinerary_v2'] ) ? wp_unslash( $_POST['_pkg_itinerary_v2'] ) : '[]';
        $items = json_decode( $raw, true );
        if ( ! is_array( $items ) ) $items = [];
        $clean = [];
        foreach ( $items as $item ) {
            $dt = sanitize_text_field( $item['day_title'] ?? '' );
            $dd = sanitize_textarea_field( $item['description'] ?? '' );
            if ( $dt || $dd ) {
                $clean[] = [ 'day_title' => $dt, 'description' => $dd ];
            }
        }
        update_post_meta( $post_id, '_pkg_itinerary_v2', $clean );
    }

    // ── Hotels repeater ──
    if ( isset( $_POST['travzo_pkg_hotels_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_hotels_nonce'] ) ), 'travzo_pkg_hotels_save' ) ) {

        $raw = isset( $_POST['_pkg_hotels_v2'] ) ? wp_unslash( $_POST['_pkg_hotels_v2'] ) : '[]';
        $items = json_decode( $raw, true );
        if ( ! is_array( $items ) ) $items = [];
        $clean = [];
        foreach ( $items as $item ) {
            $name = sanitize_text_field( $item['name'] ?? '' );
            if ( ! $name ) continue;
            $clean[] = [
                'name'      => $name,
                'stars'     => absint( $item['stars'] ?? 3 ),
                'location'  => sanitize_text_field( $item['location'] ?? '' ),
                'room_type' => sanitize_text_field( $item['room_type'] ?? '' ),
                'image'     => esc_url_raw( $item['image'] ?? '' ),
            ];
        }
        update_post_meta( $post_id, '_pkg_hotels_v2', $clean );
    }

    // ── Pricing ──
    if ( isset( $_POST['travzo_pkg_pricing_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_pricing_nonce'] ) ), 'travzo_pkg_pricing_save' ) ) {

        // Visibility checkbox
        update_post_meta( $post_id, '_pkg_pricing_visible', isset( $_POST['_pkg_pricing_visible'] ) ? '1' : '0' );

        // Pricing note
        if ( isset( $_POST['_pkg_pricing_note'] ) ) {
            update_post_meta( $post_id, '_pkg_pricing_note', sanitize_text_field( wp_unslash( $_POST['_pkg_pricing_note'] ) ) );
        }

        // Recommended tier
        if ( isset( $_POST['_pkg_pricing_recommended'] ) ) {
            $allowed_tiers = [ '', 'Standard', 'Deluxe', 'Premium' ];
            $tier = sanitize_text_field( wp_unslash( $_POST['_pkg_pricing_recommended'] ) );
            if ( in_array( $tier, $allowed_tiers, true ) ) {
                update_post_meta( $post_id, '_pkg_pricing_recommended', $tier );
            }
        }

        // Price fields (including new single room prices)
        $price_keys = [
            '_price_standard_twin', '_price_standard_triple', '_price_standard_single',
            '_price_deluxe_twin', '_price_deluxe_triple', '_price_deluxe_single',
            '_price_premium_twin', '_price_premium_triple', '_price_premium_single',
            '_price_child_bed', '_price_child_no_bed',
        ];
        foreach ( $price_keys as $pk ) {
            if ( isset( $_POST[ $pk ] ) ) {
                $val = absint( $_POST[ $pk ] );
                update_post_meta( $post_id, $pk, $val ? $val : '' );
            }
        }
    }

    // ── Important Information repeater ──
    if ( isset( $_POST['travzo_pkg_important_info_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_pkg_important_info_nonce'] ) ), 'travzo_pkg_important_info_save' ) ) {

        update_post_meta( $post_id, '_pkg_important_info_visible', isset( $_POST['_pkg_important_info_visible'] ) ? '1' : '0' );

        if ( isset( $_POST['_pkg_important_info_heading'] ) ) {
            update_post_meta( $post_id, '_pkg_important_info_heading', sanitize_text_field( wp_unslash( $_POST['_pkg_important_info_heading'] ) ) );
        }

        $raw = isset( $_POST['_pkg_important_info'] ) ? wp_unslash( $_POST['_pkg_important_info'] ) : '[]';
        $items = json_decode( $raw, true );
        if ( ! is_array( $items ) ) $items = [];
        $clean = [];
        foreach ( $items as $item ) {
            $title   = sanitize_text_field( $item['title'] ?? '' );
            $content = wp_kses_post( $item['content'] ?? '' );
            if ( $title || $content ) {
                $clean[] = [ 'title' => $title, 'content' => $content ];
            }
        }
        update_post_meta( $post_id, '_pkg_important_info', $clean );
    }
} );

// ── Package Flags (Trending) ──────────────────────────────────────────────────
add_action( 'add_meta_boxes', function () {
    add_meta_box( 'travzo_package_flags', 'Package Flags', 'travzo_package_flags_cb', 'package', 'side', 'high' );
} );

function travzo_package_flags_cb( $post ) {
    wp_nonce_field( 'travzo_flags_save', 'travzo_flags_nonce' );
    $trending = get_post_meta( $post->ID, '_is_trending', true );
    echo '<label style="display:flex;align-items:center;gap:8px;font-weight:600;cursor:pointer">';
    echo '<input type="checkbox" name="_is_trending" value="1"' . checked( $trending, '1', false ) . '>';
    echo 'Show as Trending Package on Homepage</label>';
    echo '<p style="color:#666;font-size:12px;margin-top:8px">When checked this package appears in the Trending Tours section on the homepage.</p>';
}

add_action( 'save_post_package', function ( $post_id ) {
    if ( ! isset( $_POST['travzo_flags_nonce'] ) ) return;
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_flags_nonce'] ) ), 'travzo_flags_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    update_post_meta( $post_id, '_is_trending', isset( $_POST['_is_trending'] ) ? '1' : '0' );
}, 20 );

// ── Admin Package List Filters ──────────────────────────────────────────────
add_action( 'restrict_manage_posts', function ( $post_type ) {
    if ( $post_type !== 'package' ) return;

    // Package Type filter
    $types = [ 'Group Tour', 'Honeymoon', 'Solo Trip', 'Devotional', 'Destination Wedding', 'International' ];
    $sel_type = isset( $_GET['_package_type'] ) ? sanitize_text_field( wp_unslash( $_GET['_package_type'] ) ) : '';
    echo '<select name="_package_type"><option value="">All Types</option>';
    foreach ( $types as $t ) {
        printf( '<option value="%s"%s>%s</option>', esc_attr( $t ), selected( $sel_type, $t, false ), esc_html( $t ) );
    }
    echo '</select>';

    // Region filter
    $sel_region = isset( $_GET['_pkg_region'] ) ? sanitize_text_field( wp_unslash( $_GET['_pkg_region'] ) ) : '';
    echo '<select name="_pkg_region"><option value="">All Regions</option>';
    echo '<option value="domestic"' . selected( $sel_region, 'domestic', false ) . '>Domestic</option>';
    echo '<option value="international"' . selected( $sel_region, 'international', false ) . '>International</option>';
    echo '</select>';
} );

add_action( 'pre_get_posts', function ( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) return;
    if ( ( $query->get( 'post_type' ) ?? '' ) !== 'package' ) return;

    $meta_query = $query->get( 'meta_query' ) ?: [];

    if ( ! empty( $_GET['_package_type'] ) ) {
        $meta_query[] = [
            'key'     => '_package_type',
            'value'   => sanitize_text_field( wp_unslash( $_GET['_package_type'] ) ),
            'compare' => '=',
        ];
    }
    if ( ! empty( $_GET['_pkg_region'] ) ) {
        $meta_query[] = [
            'key'     => '_pkg_region',
            'value'   => sanitize_text_field( wp_unslash( $_GET['_pkg_region'] ) ),
            'compare' => '=',
        ];
    }

    if ( ! empty( $meta_query ) ) {
        $query->set( 'meta_query', $meta_query );
    }
} );

// ══════════════════════════════════════════════════════════════════════════════
// META BOXES – PAGE TEMPLATES
// ══════════════════════════════════════════════════════════════════════════════
add_action( 'add_meta_boxes', function () {
    add_meta_box( 'travzo_homepage_hero',          'Homepage – Hero Section',                 'travzo_homepage_hero_cb',         'page', 'normal', 'high' );
    add_meta_box( 'travzo_homepage_about',         'Homepage – About Us',                     'travzo_homepage_about_cb',        'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_stats',         'Homepage – Stats Bar',                    'travzo_homepage_stats_cb',        'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_whyus',         'Homepage – Why Choose Us',                'travzo_homepage_whyus_cb',        'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_contact',       'Homepage – Contact Section',              'travzo_homepage_contact_cb',      'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_newsletter',    'Homepage – Newsletter',                   'travzo_homepage_newsletter_cb',   'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_testimonials', 'Homepage – Testimonials',                 'travzo_homepage_testimonials_cb', 'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_tiles',        'Homepage – Package Tiles',                'travzo_homepage_tiles_cb',        'page', 'normal', 'default' );
    add_meta_box( 'travzo_about_story',            'About – Our Story Section',               'travzo_about_story_cb',           'page', 'normal', 'high' );
    add_meta_box( 'travzo_about_stats',            'About – Stats Bar',                       'travzo_about_stats_cb',           'page', 'normal', 'default' );
    add_meta_box( 'travzo_about_whyus',            'About – Why Travel With Us',              'travzo_about_whyus_cb',           'page', 'normal', 'default' );
    add_meta_box( 'travzo_about_accreditation',    'About – Accreditation Partners',          'travzo_about_accreditation_cb',   'page', 'normal', 'default' );
    add_meta_box( 'travzo_about_testimonials',     'About – Testimonials',                    'travzo_about_testimonials_cb',    'page', 'normal', 'default' );
    add_meta_box( 'travzo_about_cta',              'About – CTA Section',                     'travzo_about_cta_cb',             'page', 'normal', 'default' );
    add_meta_box( 'travzo_contact_info',           'Contact – Contact Information Card',      'travzo_contact_info_cb',          'page', 'normal', 'default' );
    add_meta_box( 'travzo_contact_form_section',  'Contact – Message Form Section',          'travzo_contact_form_section_cb',  'page', 'normal', 'default' );
    add_meta_box( 'travzo_contact_branches',      'Contact – Branch Offices Section',        'travzo_contact_branches_cb',      'page', 'normal', 'default' );
    add_meta_box( 'travzo_faq_content',           'FAQ Content',                             'travzo_faq_content_cb',           'page', 'normal', 'high' );
    add_meta_box( 'travzo_media_content',         'Media Page – Videos & Press',             'travzo_media_content_cb',         'page', 'normal', 'default' );
    add_meta_box( 'travzo_legal_content',         'Legal Page Content',                      'travzo_legal_content_cb',         'page', 'normal', 'high' );
    add_meta_box( 'travzo_page_hero',             'Page Hero',                               'travzo_page_hero_cb',             'page', 'normal', 'high' );
} );

// Show only relevant meta boxes per page/template
add_action( 'do_meta_boxes', function () {
    global $post;
    if ( ! $post ) return;

    $template       = get_page_template_slug( $post->ID );
    $is_front       = ( (int) $post->ID === (int) get_option( 'page_on_front' ) );
    $legal_templates = [ 'page-terms.php', 'page-privacy.php', 'page-cancellation.php' ];
    $is_legal       = in_array( $template, $legal_templates, true );

    // Homepage meta boxes — only on front page, never on legal pages
    if ( ! $is_front || $is_legal ) {
        remove_meta_box( 'travzo_homepage_hero',         'page', 'normal' );
        remove_meta_box( 'travzo_homepage_about',        'page', 'normal' );
        remove_meta_box( 'travzo_homepage_stats',        'page', 'normal' );
        remove_meta_box( 'travzo_homepage_whyus',        'page', 'normal' );
        remove_meta_box( 'travzo_homepage_contact',      'page', 'normal' );
        remove_meta_box( 'travzo_homepage_newsletter',   'page', 'normal' );
        remove_meta_box( 'travzo_homepage_testimonials', 'page', 'normal' );
        remove_meta_box( 'travzo_homepage_tiles',        'page', 'normal' );
    }
    if ( $template !== 'page-about.php' || $is_legal ) {
        remove_meta_box( 'travzo_about_story',         'page', 'normal' );
        remove_meta_box( 'travzo_about_stats',         'page', 'normal' );
        remove_meta_box( 'travzo_about_whyus',         'page', 'normal' );
        remove_meta_box( 'travzo_about_accreditation', 'page', 'normal' );
        remove_meta_box( 'travzo_about_testimonials',  'page', 'normal' );
        remove_meta_box( 'travzo_about_cta',           'page', 'normal' );
    }
    if ( $template !== 'page-contact.php' || $is_legal ) {
        remove_meta_box( 'travzo_contact_info',          'page', 'normal' );
        remove_meta_box( 'travzo_contact_form_section',  'page', 'normal' );
        remove_meta_box( 'travzo_contact_branches',      'page', 'normal' );
    }
    if ( $template !== 'page-faq.php' || $is_legal ) {
        remove_meta_box( 'travzo_faq_content', 'page', 'normal' );
    }
    if ( $template !== 'page-media.php' || $is_legal ) {
        remove_meta_box( 'travzo_media_content', 'page', 'normal' );
    }
    // Legal meta box — only on legal templates
    if ( ! $is_legal ) {
        remove_meta_box( 'travzo_legal_content', 'page', 'normal' );
    }
    // Page Hero meta box — only on About, Contact, FAQ, Media templates + Blog (Posts page)
    $hero_templates  = [ 'page-about.php', 'page-contact.php', 'page-faq.php', 'page-media.php' ];
    $is_posts_page   = ( (int) $post->ID === (int) get_option( 'page_for_posts' ) );
    if ( ! in_array( $template, $hero_templates, true ) && ! $is_posts_page ) {
        remove_meta_box( 'travzo_page_hero', 'page', 'normal' );
    }
} );

function travzo_homepage_hero_cb( $post ) {
    wp_enqueue_media();

    $badge     = get_post_meta( $post->ID, '_homepage_hero_badge', true );
    $heading   = get_post_meta( $post->ID, '_homepage_hero_heading', true );
    $subtext   = get_post_meta( $post->ID, '_homepage_hero_subtext', true );
    $btn1_text = get_post_meta( $post->ID, '_homepage_hero_btn1_text', true );
    $btn1_url  = get_post_meta( $post->ID, '_homepage_hero_btn1_url', true );
    $btn2_text = get_post_meta( $post->ID, '_homepage_hero_btn2_text', true );
    $btn2_url  = get_post_meta( $post->ID, '_homepage_hero_btn2_url', true );
    $image     = get_post_meta( $post->ID, '_homepage_hero_image', true );
    $hero_mode = get_post_meta( $post->ID, '_homepage_hero_mode', true ) ?: 'single';
    $hero_interval = get_post_meta( $post->ID, '_homepage_hero_interval', true );
    if ( '' === $hero_interval ) $hero_interval = 5;

    // Slideshow images
    $slides_raw = get_post_meta( $post->ID, '_homepage_hero_slides', true );
    if ( ! is_array( $slides_raw ) ) {
        $slides_raw = $slides_raw ? array_filter( array_map( 'absint', explode( ',', $slides_raw ) ) ) : [];
    }
    $slides_json = wp_json_encode( array_values( $slides_raw ) );

    // Backward compat: pull old customizer values
    if ( '' === $badge && '' === $heading && '' === $subtext ) {
        $badge     = get_theme_mod( 'travzo_hero_badge', '' );
        $heading   = get_theme_mod( 'travzo_hero_heading', '' );
        $subtext   = get_theme_mod( 'travzo_hero_subtext', '' );
        $btn1_text = $btn1_text ?: get_theme_mod( 'travzo_hero_btn1_text', '' );
        $btn1_url  = $btn1_url  ?: get_theme_mod( 'travzo_hero_btn1_url', '' );
        $btn2_text = $btn2_text ?: get_theme_mod( 'travzo_hero_btn2_text', '' );
        $btn2_url  = $btn2_url  ?: get_theme_mod( 'travzo_hero_btn2_url', '' );
        $image     = $image     ?: get_theme_mod( 'travzo_hero_image', '' );
    }

    // Defaults
    if ( ! $badge )     $badge     = 'Trusted by 500+ Happy Travellers';
    if ( ! $heading )   $heading   = 'Discover the World With Travzo Holidays';
    if ( ! $subtext )   $subtext   = 'Handcrafted itineraries for every kind of traveller.';
    if ( ! $btn1_text ) $btn1_text = 'EXPLORE PACKAGES';
    if ( ! $btn1_url )  $btn1_url  = '/packages';
    if ( ! $btn2_text ) $btn2_text = 'ENQUIRE NOW';
    if ( ! $btn2_url )  $btn2_url  = '#contact';

    wp_nonce_field( 'travzo_hero_home_save', 'travzo_hero_home_nonce' );

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div style="grid-column:1/-1"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">BADGE TEXT</label>';
    echo '<input type="text" name="_homepage_hero_badge" class="widefat" value="' . esc_attr( $badge ) . '" placeholder="Trusted by 500+ Happy Travellers"></div>';
    echo '</div>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">MAIN HEADING</label>';
    echo '<textarea name="_homepage_hero_heading" class="widefat" rows="2" placeholder="Discover the World With Travzo Holidays">' . esc_textarea( $heading ) . '</textarea>';
    echo '<p style="color:#999;font-size:11px;margin:4px 0 0">Line breaks are preserved on the frontend</p></div>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SUB TEXT</label>';
    echo '<input type="text" name="_homepage_hero_subtext" class="widefat" value="' . esc_attr( $subtext ) . '" placeholder="Handcrafted itineraries for every kind of traveller."></div>';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">PRIMARY BUTTON TEXT</label>';
    echo '<input type="text" name="_homepage_hero_btn1_text" class="widefat" value="' . esc_attr( $btn1_text ) . '" placeholder="EXPLORE PACKAGES"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">PRIMARY BUTTON URL</label>';
    echo '<input type="text" name="_homepage_hero_btn1_url" class="widefat" value="' . esc_attr( $btn1_url ) . '" placeholder="/packages"></div>';
    echo '</div>';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECONDARY BUTTON TEXT</label>';
    echo '<input type="text" name="_homepage_hero_btn2_text" class="widefat" value="' . esc_attr( $btn2_text ) . '" placeholder="ENQUIRE NOW"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECONDARY BUTTON URL</label>';
    echo '<input type="text" name="_homepage_hero_btn2_url" class="widefat" value="' . esc_attr( $btn2_url ) . '" placeholder="#contact"></div>';
    echo '</div>';

    // ── Hero Mode Toggle ──
    echo '<hr style="border:none;border-top:1px solid #e0e0e0;margin:0 0 16px">';
    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:8px">HERO MODE</label>';
    echo '<label style="margin-right:24px;cursor:pointer"><input type="radio" name="_homepage_hero_mode" value="single" id="hero-mode-single"' . checked( $hero_mode, 'single', false ) . '> Single Image</label>';
    echo '<label style="cursor:pointer"><input type="radio" name="_homepage_hero_mode" value="slideshow" id="hero-mode-slideshow"' . checked( $hero_mode, 'slideshow', false ) . '> Slideshow</label>';
    echo '</div>';

    // ── Single Image fields ──
    echo '<div id="hero-single-fields"' . ( $hero_mode !== 'single' ? ' style="display:none"' : '' ) . '>';
    echo '<div style="margin-bottom:8px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HERO BACKGROUND IMAGE</label>';
    echo '<div style="display:flex;gap:8px;align-items:flex-start">';
    echo '<input type="url" name="_homepage_hero_image" id="hero-home-image-input" class="widefat" value="' . esc_attr( $image ) . '" placeholder="https://... background image URL" style="flex:1">';
    echo '<button type="button" class="button" id="hero-home-upload-btn">Choose Image</button>';
    echo '<button type="button" class="button" id="hero-home-remove-btn" style="color:#dc2626">Remove</button>';
    echo '</div>';
    if ( $image ) {
        echo '<div id="hero-home-preview" style="margin-top:8px"><img src="' . esc_url( $image ) . '" style="max-width:300px;max-height:150px;border-radius:8px;border:1px solid #e0e0e0"></div>';
    } else {
        echo '<div id="hero-home-preview" style="margin-top:8px"></div>';
    }
    echo '</div>';
    echo '</div><!-- /#hero-single-fields -->';

    // ── Slideshow fields ──
    echo '<div id="hero-slideshow-fields"' . ( $hero_mode !== 'slideshow' ? ' style="display:none"' : '' ) . '>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SLIDESHOW IMAGES</label>';
    echo '<p style="color:#666;font-size:12px;margin-bottom:8px">Select images from the media library. Drag thumbnails to reorder.</p>';
    echo '<input type="hidden" name="_homepage_hero_slides" id="hero-slides-ids" value="' . esc_attr( $slides_json ) . '">';
    echo '<div id="hero-slides-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px"></div>';
    echo '<button type="button" class="button" id="hero-slides-add">+ Add Images</button>';
    echo '</div>';

    echo '<div style="margin-bottom:16px;max-width:200px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SLIDE DURATION (SECONDS)</label>';
    echo '<input type="number" name="_homepage_hero_interval" value="' . esc_attr( $hero_interval ) . '" min="2" max="30" step="1" style="width:100%">';
    echo '<p style="color:#999;font-size:11px;margin:4px 0 0">How long each slide displays before auto-advancing</p>';
    echo '</div>';

    echo '</div><!-- /#hero-slideshow-fields -->';

    // ── Search Bar Fields ──
    $search_enabled = get_post_meta( $post->ID, '_homepage_hero_search_enabled', true );
    $search_ph      = get_post_meta( $post->ID, '_homepage_hero_search_placeholder', true ) ?: 'Search destinations...';
    $filters_on     = get_post_meta( $post->ID, '_homepage_hero_filters_enabled', true );
    if ( ! is_array( $filters_on ) ) $filters_on = [];

    echo '<hr style="border:none;border-top:1px solid #e0e0e0;margin:16px 0">';
    echo '<div style="margin-bottom:12px"><label style="display:flex;align-items:center;gap:8px;font-weight:600;cursor:pointer">';
    echo '<input type="checkbox" name="_homepage_hero_search_enabled" id="hero-search-toggle" value="1"' . checked( $search_enabled, '1', false ) . '>';
    echo 'Show Search Bar in Hero</label></div>';

    echo '<div id="hero-search-fields"' . ( '1' !== $search_enabled ? ' style="display:none"' : '' ) . '>';
    echo '<div style="margin-bottom:12px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SEARCH PLACEHOLDER TEXT</label>';
    echo '<input type="text" name="_homepage_hero_search_placeholder" class="widefat" value="' . esc_attr( $search_ph ) . '" placeholder="Search destinations..."></div>';

    echo '<div style="margin-bottom:12px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:8px">QUICK FILTERS TO SHOW</label>';
    $filter_opts = [ 'type' => 'Package Type', 'region' => 'Region', 'duration' => 'Duration', 'budget' => 'Budget' ];
    foreach ( $filter_opts as $fkey => $flabel ) {
        echo '<label style="display:inline-flex;align-items:center;gap:6px;margin-right:20px;cursor:pointer">';
        echo '<input type="checkbox" name="_homepage_hero_filters_enabled[]" value="' . esc_attr( $fkey ) . '"' . ( in_array( $fkey, $filters_on, true ) ? ' checked' : '' ) . '>';
        echo esc_html( $flabel ) . '</label>';
    }
    echo '</div>';
    echo '</div><!-- /#hero-search-fields -->';

    ?>
    <script>
    jQuery(function($) {
        // ── Mode toggle ──
        $('input[name="_homepage_hero_mode"]').on('change', function() {
            var mode = $(this).val();
            $('#hero-single-fields').toggle(mode === 'single');
            $('#hero-slideshow-fields').toggle(mode === 'slideshow');
        });

        // ── Search bar toggle ──
        $('#hero-search-toggle').on('change', function() {
            $('#hero-search-fields').toggle(this.checked);
        });

        // ── Single image uploader ──
        $('#hero-home-upload-btn').on('click', function() {
            var frame = wp.media({ title: 'Select Hero Image', button: { text: 'Use Image' }, multiple: false });
            frame.on('select', function() {
                var url = frame.state().get('selection').first().toJSON().url;
                $('#hero-home-image-input').val(url);
                $('#hero-home-preview').html('<img src="' + url + '" style="max-width:300px;max-height:150px;border-radius:8px;border:1px solid #e0e0e0">');
            });
            frame.open();
        });
        $('#hero-home-remove-btn').on('click', function() {
            $('#hero-home-image-input').val('');
            $('#hero-home-preview').html('');
        });

        // ── Slideshow multi-image uploader ──
        var $slidesHidden  = $('#hero-slides-ids');
        var $slidesPreview = $('#hero-slides-preview');
        var slideIds       = <?php echo $slides_json; ?>;

        function renderSlides() {
            $slidesPreview.empty();
            slideIds.forEach(function(id, idx) {
                var $thumb = $('<div style="position:relative;width:120px;height:80px;border-radius:6px;overflow:hidden;cursor:grab" data-idx="' + idx + '">');
                $thumb.append('<img src="" style="width:100%;height:100%;object-fit:cover">');
                $thumb.append('<button type="button" style="position:absolute;top:2px;right:2px;background:rgba(0,0,0,0.6);color:#fff;border:none;border-radius:50%;width:20px;height:20px;font-size:12px;cursor:pointer;line-height:20px;text-align:center">&times;</button>');
                var img = $thumb.find('img');
                if (wp.media.attachment(id).get('url')) {
                    var sizes = wp.media.attachment(id).get('sizes');
                    img.attr('src', sizes && sizes.thumbnail ? sizes.thumbnail.url : wp.media.attachment(id).get('url'));
                } else {
                    wp.media.attachment(id).fetch().then(function() {
                        var sizes = wp.media.attachment(id).get('sizes');
                        img.attr('src', sizes && sizes.thumbnail ? sizes.thumbnail.url : wp.media.attachment(id).get('url'));
                    });
                }
                $thumb.find('button').on('click', function() {
                    slideIds.splice(idx, 1);
                    syncSlides();
                    renderSlides();
                });
                $slidesPreview.append($thumb);
            });
        }

        function syncSlides() {
            $slidesHidden.val(JSON.stringify(slideIds));
        }

        $slidesPreview.sortable({
            tolerance: 'pointer',
            update: function() {
                var sorted = [];
                $slidesPreview.children().each(function() {
                    sorted.push(slideIds[$(this).data('idx')]);
                });
                slideIds = sorted;
                syncSlides();
                renderSlides();
            }
        });

        $('#hero-slides-add').on('click', function() {
            var frame = wp.media({ title: 'Select Slideshow Images', button: { text: 'Add to Slideshow' }, multiple: true });
            frame.on('select', function() {
                frame.state().get('selection').each(function(att) {
                    slideIds.push(att.id);
                });
                syncSlides();
                renderSlides();
            });
            frame.open();
        });

        renderSlides();
    });
    </script>
    <?php
}

function travzo_homepage_about_cb( $post ) {
    $label     = get_post_meta( $post->ID, '_homepage_about_label', true );
    $heading   = get_post_meta( $post->ID, '_homepage_about_heading', true );
    $desc      = get_post_meta( $post->ID, '_homepage_about_description', true );
    $keypoints = get_post_meta( $post->ID, '_homepage_about_keypoints', true );
    $image     = get_post_meta( $post->ID, '_homepage_about_image', true );
    $btn_text  = get_post_meta( $post->ID, '_homepage_about_btn_text', true );
    $btn_url   = get_post_meta( $post->ID, '_homepage_about_btn_url', true );

    // Backward compat: pull old customizer values
    if ( '' === $label && '' === $heading && '' === $desc ) {
        $label     = get_theme_mod( 'travzo_about_label', '' );
        $heading   = get_theme_mod( 'travzo_about_heading', '' );
        $desc      = get_theme_mod( 'travzo_about_text', '' );
        $image     = $image ?: get_theme_mod( 'travzo_about_image', '' );
        $feat1     = get_theme_mod( 'travzo_about_feat1', 'Handcrafted Itineraries' );
        $feat2     = get_theme_mod( 'travzo_about_feat2', 'Best Price Guarantee' );
        $feat3     = get_theme_mod( 'travzo_about_feat3', '24/7 Support' );
        $kp_parts  = array_filter( [ $feat1, $feat2, $feat3 ] );
        $keypoints = $keypoints ?: implode( "\n", $kp_parts );
    }

    // Defaults
    if ( ! $label )     $label     = 'WHO WE ARE';
    if ( ! $heading )   $heading   = 'Your Trusted Travel Partner';
    if ( ! $desc )      $desc      = 'Travzo Holidays is a Coimbatore-based travel agency with over a decade of experience crafting unforgettable journeys. From serene backwater cruises in Kerala to sacred Char Dham pilgrimages, we design every itinerary with care, passion, and deep local knowledge — so you can travel with complete peace of mind.';
    if ( ! $keypoints ) $keypoints = "Handcrafted Itineraries\nBest Price Guarantee\n24/7 Support";
    if ( ! $btn_text )  $btn_text  = 'LEARN MORE ABOUT US';
    if ( ! $btn_url )   $btn_url   = '/about';

    wp_nonce_field( 'travzo_about_home_save', 'travzo_about_home_nonce' );

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION LABEL</label>';
    echo '<input type="text" name="_homepage_about_label" class="widefat" value="' . esc_attr( $label ) . '" placeholder="WHO WE ARE"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION HEADING</label>';
    echo '<input type="text" name="_homepage_about_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Your Trusted Travel Partner"></div>';
    echo '</div>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DESCRIPTION</label>';
    echo '<textarea name="_homepage_about_description" class="widefat" rows="4" placeholder="About your company…">' . esc_textarea( $desc ) . '</textarea></div>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">KEY POINTS</label>';
    echo '<p style="color:#999;font-size:11px;margin:0 0 4px">One point per line (shown as checkmark list on the frontend)</p>';
    echo '<textarea name="_homepage_about_keypoints" class="widefat" rows="4" placeholder="Handcrafted Itineraries&#10;Best Price Guarantee&#10;24/7 Support">' . esc_textarea( $keypoints ) . '</textarea></div>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION IMAGE</label>';
    echo '<div style="display:flex;gap:8px;align-items:flex-start">';
    echo '<input type="url" name="_homepage_about_image" id="about-home-image-input" class="widefat" value="' . esc_attr( $image ) . '" placeholder="https://... image URL" style="flex:1">';
    echo '<button type="button" class="button" id="about-home-upload-btn">Choose Image</button>';
    echo '<button type="button" class="button" id="about-home-remove-btn" style="color:#dc2626">Remove</button>';
    echo '</div>';
    if ( $image ) {
        echo '<div id="about-home-preview" style="margin-top:8px"><img src="' . esc_url( $image ) . '" style="max-width:200px;max-height:120px;border-radius:8px;border:1px solid #e0e0e0"></div>';
    } else {
        echo '<div id="about-home-preview" style="margin-top:8px"></div>';
    }
    echo '</div>';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">BUTTON TEXT</label>';
    echo '<input type="text" name="_homepage_about_btn_text" class="widefat" value="' . esc_attr( $btn_text ) . '" placeholder="LEARN MORE ABOUT US"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">BUTTON URL</label>';
    echo '<input type="text" name="_homepage_about_btn_url" class="widefat" value="' . esc_attr( $btn_url ) . '" placeholder="/about"></div>';
    echo '</div>';

    echo '<script>
    jQuery(function($) {
        $("#about-home-upload-btn").on("click", function() {
            var frame = wp.media({ title: "Select Image", button: { text: "Use Image" }, multiple: false });
            frame.on("select", function() {
                var url = frame.state().get("selection").first().toJSON().url;
                $("#about-home-image-input").val(url);
                $("#about-home-preview").html(\'<img src="\' + url + \'" style="max-width:200px;max-height:120px;border-radius:8px;border:1px solid #e0e0e0">\');
            });
            frame.open();
        });
        $("#about-home-remove-btn").on("click", function() {
            $("#about-home-image-input").val("");
            $("#about-home-preview").html("");
        });
    });
    </script>';
}

function travzo_homepage_stats_cb( $post ) {
    $raw = get_post_meta( $post->ID, '_homepage_stats', true );
    $items = [];

    if ( is_array( $raw ) && ! empty( $raw ) ) {
        $items = $raw;
    }

    // Backward compat: pull old customizer values
    if ( empty( $items ) ) {
        $defaults = [
            [ '500+', 'Happy Travellers',      'Memorable journeys created' ],
            [ '50+',  'Destinations',           'Across India and abroad' ],
            [ '10+',  'Years Experience',       'Of trusted travel expertise' ],
            [ '100%', 'Customised Itineraries', 'Tailored to your needs' ],
        ];
        for ( $i = 1; $i <= 4; $i++ ) {
            $num = get_theme_mod( "travzo_stat_{$i}_number", '' );
            $lbl = get_theme_mod( "travzo_stat_{$i}_label", '' );
            $sub = get_theme_mod( "travzo_stat_{$i}_description", '' );
            if ( $num || $lbl ) {
                $items[] = [
                    'number'   => $num ?: $defaults[ $i - 1 ][0],
                    'label'    => $lbl ?: $defaults[ $i - 1 ][1],
                    'sublabel' => $sub ?: $defaults[ $i - 1 ][2],
                ];
            }
        }
    }

    // Ultimate fallback
    if ( empty( $items ) ) {
        $items = [
            [ 'number' => '500+', 'label' => 'Happy Travellers',      'sublabel' => 'Memorable journeys created' ],
            [ 'number' => '50+',  'label' => 'Destinations',           'sublabel' => 'Across India and abroad' ],
            [ 'number' => '10+',  'label' => 'Years Experience',       'sublabel' => 'Of trusted travel expertise' ],
            [ 'number' => '100%', 'label' => 'Customised Itineraries', 'sublabel' => 'Tailored to your needs' ],
        ];
    }

    wp_nonce_field( 'travzo_stats_save', 'travzo_stats_nonce' );
    echo '<input type="hidden" id="travzo-stats-data" name="_homepage_stats_v2" value="' . esc_attr( wp_json_encode( $items ) ) . '">';
    echo '<p style="color:#666;margin-bottom:16px">Add statistics for the homepage stats bar. Each item shows a number, label, and sublabel.</p>';
    echo '<div id="travzo-stats-container">';

    foreach ( $items as $i => $item ) {
        $num = $i + 1;
        echo '<div class="travzo-stat-row" style="position:relative;padding:16px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;margin-bottom:10px">';
        echo '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong style="color:#1A2A5E">#' . $num . '</strong>';
        echo '<button type="button" class="button travzo-remove-stat" style="color:#dc2626;font-size:12px">&#x2715; Remove</button></div>';
        echo '<div style="display:grid;grid-template-columns:120px 1fr 1fr;gap:10px">';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">STAT NUMBER</label>';
        echo '<input type="text" class="stat-number widefat" value="' . esc_attr( $item['number'] ?? '' ) . '" placeholder="500+"></div>';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">STAT LABEL</label>';
        echo '<input type="text" class="stat-label widefat" value="' . esc_attr( $item['label'] ?? '' ) . '" placeholder="Happy Travellers"></div>';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SUBLABEL</label>';
        echo '<input type="text" class="stat-sublabel widefat" value="' . esc_attr( $item['sublabel'] ?? '' ) . '" placeholder="Memorable journeys created"></div>';
        echo '</div></div>';
    }

    echo '</div>';
    echo '<button type="button" id="travzo-add-stat" class="button button-primary" style="margin-top:12px">+ Add Stat</button>';

    echo '<script>
    jQuery(function($) {
        function syncStats() {
            var data = [];
            $(".travzo-stat-row").each(function() {
                var num = $(this).find(".stat-number").val() || "";
                if (!num) return;
                data.push({
                    number:   num,
                    label:    $(this).find(".stat-label").val() || "",
                    sublabel: $(this).find(".stat-sublabel").val() || ""
                });
            });
            $("#travzo-stats-data").val(JSON.stringify(data));
        }
        function renumberStats() {
            $(".travzo-stat-row").each(function(i) {
                $(this).find("strong").first().text("#" + (i + 1));
            });
        }
        function makeStatRow(item) {
            item = item || { number: "", label: "", sublabel: "" };
            return \'<div class="travzo-stat-row" style="position:relative;padding:16px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;margin-bottom:10px">\'
                + \'<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong style="color:#1A2A5E">#0</strong>\'
                + \'<button type="button" class="button travzo-remove-stat" style="color:#dc2626;font-size:12px">&#x2715; Remove</button></div>\'
                + \'<div style="display:grid;grid-template-columns:120px 1fr 1fr;gap:10px">\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">STAT NUMBER</label>\'
                + \'<input type="text" class="stat-number widefat" value="\' + (item.number || "") + \'" placeholder="500+"></div>\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">STAT LABEL</label>\'
                + \'<input type="text" class="stat-label widefat" value="\' + (item.label || "") + \'" placeholder="Happy Travellers"></div>\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SUBLABEL</label>\'
                + \'<input type="text" class="stat-sublabel widefat" value="\' + (item.sublabel || "") + \'" placeholder="Memorable journeys created"></div>\'
                + \'</div></div>\';
        }
        $(document).on("click", ".travzo-remove-stat", function() {
            $(this).closest(".travzo-stat-row").remove();
            renumberStats();
            syncStats();
        });
        $("#travzo-add-stat").on("click", function() {
            $("#travzo-stats-container").append(makeStatRow());
            renumberStats();
            syncStats();
        });
        $(document).on("input change", ".stat-number, .stat-label, .stat-sublabel", syncStats);
    });
    </script>';
}

function travzo_homepage_whyus_cb( $post ) {
    $raw = get_post_meta( $post->ID, '_homepage_whyus', true );
    $data = is_array( $raw ) ? $raw : [];

    // Backward compat: pull old customizer values on first load
    if ( empty( $data ) ) {
        $old_label   = get_theme_mod( 'travzo_why_us_label', '' );
        $old_heading = get_theme_mod( 'travzo_why_us_heading', '' );
        $old_tiles   = get_theme_mod( 'travzo_why_us_tiles', '' );
        $tiles = [];
        if ( ! empty( $old_tiles ) ) {
            foreach ( explode( "\n", $old_tiles ) as $line ) {
                $parts = array_map( 'trim', explode( '|', $line ) );
                if ( ! empty( $parts[0] ) ) {
                    $tiles[] = [ 'icon' => '', 'title' => $parts[0], 'desc' => $parts[1] ?? '' ];
                }
            }
        }
        $data = [
            'label'   => $old_label ?: 'WHY TRAVZO',
            'heading' => $old_heading ?: 'Why Travel With Us',
            'tiles'   => $tiles,
        ];
    }

    $label   = $data['label'] ?? 'WHY TRAVZO';
    $heading = $data['heading'] ?? 'Why Travel With Us';
    $tiles   = $data['tiles'] ?? [];

    wp_nonce_field( 'travzo_whyus_save', 'travzo_whyus_nonce' );
    echo '<input type="hidden" id="travzo-whyus-data" name="_homepage_whyus_v2" value="' . esc_attr( wp_json_encode( $data ) ) . '">';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION LABEL</label>';
    echo '<input type="text" id="whyus-label" class="widefat" value="' . esc_attr( $label ) . '" placeholder="WHY TRAVZO"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION HEADING</label>';
    echo '<input type="text" id="whyus-heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Why Travel With Us"></div>';
    echo '</div>';

    echo '<p style="color:#666;margin-bottom:16px">Add features/benefits. Each card gets an icon (short text like a symbol/emoji), title, and description.</p>';
    echo '<div id="travzo-whyus-container">';

    foreach ( $tiles as $i => $item ) {
        $num = $i + 1;
        echo '<div class="travzo-whyus-row" style="position:relative;padding:16px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;margin-bottom:10px">';
        echo '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong style="color:#1A2A5E">#' . $num . '</strong>';
        echo '<button type="button" class="button travzo-remove-whyus" style="color:#dc2626;font-size:12px">&#x2715; Remove</button></div>';
        echo '<div style="display:grid;grid-template-columns:100px 1fr;gap:10px;margin-bottom:10px">';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">ICON TEXT</label>';
        echo '<input type="text" class="whyus-icon widefat" value="' . esc_attr( $item['icon'] ?? '' ) . '" placeholder="🧭"></div>';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">TITLE</label>';
        echo '<input type="text" class="whyus-title widefat" value="' . esc_attr( $item['title'] ?? '' ) . '" placeholder="Handcrafted Itineraries"></div>';
        echo '</div>';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DESCRIPTION</label>';
        echo '<textarea class="whyus-desc widefat" rows="2" placeholder="Explain this benefit…">' . esc_textarea( $item['desc'] ?? '' ) . '</textarea></div>';
        echo '</div>';
    }

    echo '</div>';
    echo '<button type="button" id="travzo-add-whyus" class="button button-primary" style="margin-top:12px">+ Add Feature</button>';

    echo '<script>
    jQuery(function($) {
        function syncWhyUs() {
            var tiles = [];
            $(".travzo-whyus-row").each(function() {
                var title = $(this).find(".whyus-title").val() || "";
                if (!title) return;
                tiles.push({
                    icon:  $(this).find(".whyus-icon").val() || "",
                    title: title,
                    desc:  $(this).find(".whyus-desc").val() || ""
                });
            });
            var data = {
                label:   $("#whyus-label").val() || "",
                heading: $("#whyus-heading").val() || "",
                tiles:   tiles
            };
            $("#travzo-whyus-data").val(JSON.stringify(data));
        }
        function renumberWhyUs() {
            $(".travzo-whyus-row").each(function(i) {
                $(this).find("strong").first().text("#" + (i + 1));
            });
        }
        function makeWhyUsRow(item) {
            item = item || { icon: "", title: "", desc: "" };
            return \'<div class="travzo-whyus-row" style="position:relative;padding:16px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;margin-bottom:10px">\'
                + \'<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong style="color:#1A2A5E">#0</strong>\'
                + \'<button type="button" class="button travzo-remove-whyus" style="color:#dc2626;font-size:12px">&#x2715; Remove</button></div>\'
                + \'<div style="display:grid;grid-template-columns:100px 1fr;gap:10px;margin-bottom:10px">\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">ICON TEXT</label>\'
                + \'<input type="text" class="whyus-icon widefat" value="\' + (item.icon || "") + \'" placeholder="🧭"></div>\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">TITLE</label>\'
                + \'<input type="text" class="whyus-title widefat" value="\' + (item.title || "") + \'" placeholder="Handcrafted Itineraries"></div>\'
                + \'</div>\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DESCRIPTION</label>\'
                + \'<textarea class="whyus-desc widefat" rows="2" placeholder="Explain this benefit…">\' + (item.desc || "") + \'</textarea></div>\'
                + \'</div>\';
        }
        $(document).on("click", ".travzo-remove-whyus", function() {
            $(this).closest(".travzo-whyus-row").remove();
            renumberWhyUs();
            syncWhyUs();
        });
        $("#travzo-add-whyus").on("click", function() {
            $("#travzo-whyus-container").append(makeWhyUsRow());
            renumberWhyUs();
            syncWhyUs();
        });
        $(document).on("input change", ".whyus-icon, .whyus-title, .whyus-desc, #whyus-label, #whyus-heading", syncWhyUs);
    });
    </script>';
}

function travzo_homepage_newsletter_cb( $post ) {
    $heading = get_post_meta( $post->ID, '_homepage_newsletter_heading', true );
    $subtext = get_post_meta( $post->ID, '_homepage_newsletter_subtext', true );

    // Backward compat
    if ( '' === $heading && '' === $subtext ) {
        $heading = get_theme_mod( 'travzo_newsletter_heading', '' );
        $subtext = get_theme_mod( 'travzo_newsletter_subtext', '' );
    }
    if ( ! $heading ) $heading = 'Get Travel Deals in Your Inbox';
    if ( ! $subtext ) $subtext = 'Subscribe for exclusive offers.';

    wp_nonce_field( 'travzo_newsletter_section_save', 'travzo_newsletter_section_nonce' );

    echo '<p style="color:#666;margin-bottom:16px">Text content for the newsletter section. The form is rendered by the theme and submitted via AJAX.</p>';
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HEADING</label>';
    echo '<input type="text" name="_homepage_newsletter_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Get Travel Deals in Your Inbox"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SUBTEXT</label>';
    echo '<input type="text" name="_homepage_newsletter_subtext" class="widefat" value="' . esc_attr( $subtext ) . '" placeholder="Subscribe for exclusive offers."></div>';
    echo '</div>';
}

function travzo_homepage_contact_cb( $post ) {
    $label   = get_post_meta( $post->ID, '_homepage_contact_label', true );
    $heading = get_post_meta( $post->ID, '_homepage_contact_heading', true );
    $desc    = get_post_meta( $post->ID, '_homepage_contact_description', true );
    $hours   = get_post_meta( $post->ID, '_homepage_contact_hours', true );

    // Backward compat: pull old customizer values
    if ( '' === $label && '' === $heading && '' === $desc ) {
        $label   = get_theme_mod( 'travzo_contact_label', '' );
        $heading = get_theme_mod( 'travzo_contact_heading', '' );
        $desc    = get_theme_mod( 'travzo_contact_desc', '' );
    }

    // Defaults
    if ( ! $label )   $label   = 'GET IN TOUCH';
    if ( ! $heading ) $heading = 'Plan Your Dream Trip';
    if ( ! $desc )    $desc    = 'Talk to our travel experts and let us craft the perfect holiday for you. No obligation, just great ideas.';
    if ( ! $hours )   $hours   = 'Mon – Sat: 9:00 AM – 7:00 PM';

    wp_nonce_field( 'travzo_contact_home_save', 'travzo_contact_home_nonce' );

    echo '<p style="color:#666;margin-bottom:16px">Text content for the homepage enquiry/contact section. The form is rendered by the theme and submitted via AJAX.</p>';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION LABEL</label>';
    echo '<input type="text" name="_homepage_contact_label" class="widefat" value="' . esc_attr( $label ) . '" placeholder="GET IN TOUCH"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION HEADING</label>';
    echo '<input type="text" name="_homepage_contact_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Plan Your Dream Trip"></div>';
    echo '</div>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DESCRIPTION</label>';
    echo '<textarea name="_homepage_contact_description" class="widefat" rows="3" placeholder="Talk to our travel experts…">' . esc_textarea( $desc ) . '</textarea></div>';

    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">WORKING HOURS</label>';
    echo '<input type="text" name="_homepage_contact_hours" class="widefat" value="' . esc_attr( $hours ) . '" placeholder="Mon – Sat: 9:00 AM – 7:00 PM"></div>';
}

function travzo_homepage_testimonials_cb( $post ) {
    $raw = get_post_meta( $post->ID, '_testimonials', true );

    // Backward compat: convert old pipe-separated text to array
    $items = [];
    if ( is_array( $raw ) ) {
        $items = $raw;
    } elseif ( is_string( $raw ) && '' !== trim( $raw ) ) {
        foreach ( explode( "\n", $raw ) as $line ) {
            $parts = array_map( 'trim', explode( '|', $line ) );
            if ( ! empty( $parts[0] ) ) {
                $items[] = [
                    'name'   => $parts[0] ?? '',
                    'trip'   => $parts[1] ?? '',
                    'quote'  => $parts[2] ?? '',
                    'rating' => 5,
                ];
            }
        }
    }

    wp_nonce_field( 'travzo_testimonials_save', 'travzo_testimonials_nonce' );
    echo '<input type="hidden" id="travzo-testimonials-data" name="_testimonials_v2" value="' . esc_attr( wp_json_encode( $items ) ) . '">';
    echo '<p style="color:#666;margin-bottom:16px">Add customer testimonials. Each card has a name, trip, quote and star rating.</p>';
    echo '<div id="travzo-testimonials-container">';

    foreach ( $items as $i => $item ) {
        $num = $i + 1;
        echo '<div class="travzo-testimonial-row" style="position:relative;padding:16px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;margin-bottom:10px">';
        echo '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong style="color:#1A2A5E">#' . $num . '</strong>';
        echo '<button type="button" class="button travzo-remove-testimonial" style="color:#dc2626;font-size:12px">&#x2715; Remove</button></div>';
        echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px">';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">CUSTOMER NAME</label>';
        echo '<input type="text" class="testi-name widefat" value="' . esc_attr( $item['name'] ?? '' ) . '" placeholder="Priya & Arjun Nair"></div>';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">TRIP / PACKAGE NAME</label>';
        echo '<input type="text" class="testi-trip widefat" value="' . esc_attr( $item['trip'] ?? '' ) . '" placeholder="Kashmir Honeymoon – 7 Days"></div>';
        echo '</div>';
        echo '<div style="margin-bottom:10px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">QUOTE</label>';
        echo '<textarea class="testi-quote widefat" rows="3" placeholder="Their experience in their own words…">' . esc_textarea( $item['quote'] ?? '' ) . '</textarea></div>';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">STAR RATING (1-5)</label>';
        echo '<input type="number" class="testi-rating" min="1" max="5" value="' . esc_attr( $item['rating'] ?? 5 ) . '" style="width:70px"></div>';
        echo '</div>';
    }

    echo '</div>';
    echo '<button type="button" id="travzo-add-testimonial" class="button button-primary" style="margin-top:12px">+ Add Testimonial</button>';

    echo '<script>
    jQuery(function($) {
        function syncTestimonials() {
            var data = [];
            $(".travzo-testimonial-row").each(function() {
                var name = $(this).find(".testi-name").val() || "";
                if (!name) return;
                data.push({
                    name:   name,
                    trip:   $(this).find(".testi-trip").val() || "",
                    quote:  $(this).find(".testi-quote").val() || "",
                    rating: parseInt($(this).find(".testi-rating").val()) || 5
                });
            });
            $("#travzo-testimonials-data").val(JSON.stringify(data));
        }
        function renumber() {
            $(".travzo-testimonial-row").each(function(i) {
                $(this).find("strong").first().text("#" + (i + 1));
            });
        }
        function makeRow(item) {
            item = item || { name: "", trip: "", quote: "", rating: 5 };
            return \'<div class="travzo-testimonial-row" style="position:relative;padding:16px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;margin-bottom:10px">\'
                + \'<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong style="color:#1A2A5E">#0</strong>\'
                + \'<button type="button" class="button travzo-remove-testimonial" style="color:#dc2626;font-size:12px">&#x2715; Remove</button></div>\'
                + \'<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px">\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">CUSTOMER NAME</label>\'
                + \'<input type="text" class="testi-name widefat" value="\' + (item.name || "") + \'" placeholder="Priya &amp; Arjun Nair"></div>\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">TRIP / PACKAGE NAME</label>\'
                + \'<input type="text" class="testi-trip widefat" value="\' + (item.trip || "") + \'" placeholder="Kashmir Honeymoon – 7 Days"></div>\'
                + \'</div>\'
                + \'<div style="margin-bottom:10px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">QUOTE</label>\'
                + \'<textarea class="testi-quote widefat" rows="3" placeholder="Their experience in their own words…">\' + (item.quote || "") + \'</textarea></div>\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">STAR RATING (1-5)</label>\'
                + \'<input type="number" class="testi-rating" min="1" max="5" value="\' + (item.rating || 5) + \'" style="width:70px"></div>\'
                + \'</div>\';
        }
        $(document).on("click", ".travzo-remove-testimonial", function() {
            $(this).closest(".travzo-testimonial-row").remove();
            renumber();
            syncTestimonials();
        });
        $("#travzo-add-testimonial").on("click", function() {
            $("#travzo-testimonials-container").append(makeRow());
            renumber();
            syncTestimonials();
        });
        $(document).on("input change", ".testi-name, .testi-trip, .testi-quote, .testi-rating", syncTestimonials);
    });
    </script>';
}

function travzo_homepage_tiles_cb( $post ) {
    wp_enqueue_media();

    // Section label & heading
    $pkg_label   = get_post_meta( $post->ID, '_homepage_packages_label', true );
    $pkg_heading = get_post_meta( $post->ID, '_homepage_packages_heading', true );
    if ( ! $pkg_label )   $pkg_label   = get_theme_mod( 'travzo_packages_label', '' ) ?: 'WHAT WE OFFER';
    if ( ! $pkg_heading ) $pkg_heading = get_theme_mod( 'travzo_packages_heading', '' ) ?: 'Our Packages';

    $tiles = get_post_meta( $post->ID, '_package_tiles_v2', true );
    if ( ! is_array( $tiles ) ) {
        $tiles = [];
    }

    // ── Backward compatibility: migrate old format (name, type, image URL string) ──
    if ( ! empty( $tiles ) && ! isset( $tiles[0]['region'] ) ) {
        $migrated = [];
        foreach ( $tiles as $old ) {
            $img_id = 0;
            $img_url = $old['image'] ?? '';
            if ( $img_url ) {
                $img_id = attachment_url_to_postid( $img_url );
            }
            $migrated[] = [
                'name'        => $old['name'] ?? '',
                'type'        => $old['type'] ?? '',
                'region'      => '',
                'country'     => '',
                'subregion'   => '',
                'destination' => '',
                'duration'    => '',
                'budget'      => '',
                'url'         => '',
                'image'       => $img_id ? $img_id : 0,
                'image_url'   => $img_url, // keep URL fallback
            ];
        }
        $tiles = $migrated;
        update_post_meta( $post->ID, '_package_tiles_v2', $tiles );
    }

    if ( empty( $tiles ) ) {
        $tiles = [
            [ 'name' => 'Group Tours',          'type' => 'Group Tour',          'region' => '', 'country' => '', 'subregion' => '', 'destination' => '', 'duration' => '', 'budget' => '', 'url' => '', 'image' => 0 ],
            [ 'name' => 'Honeymoon Packages',   'type' => 'Honeymoon',           'region' => '', 'country' => '', 'subregion' => '', 'destination' => '', 'duration' => '', 'budget' => '', 'url' => '', 'image' => 0 ],
            [ 'name' => 'Solo Trips',           'type' => 'Solo Trip',           'region' => '', 'country' => '', 'subregion' => '', 'destination' => '', 'duration' => '', 'budget' => '', 'url' => '', 'image' => 0 ],
            [ 'name' => 'Devotional Tours',     'type' => 'Devotional',          'region' => '', 'country' => '', 'subregion' => '', 'destination' => '', 'duration' => '', 'budget' => '', 'url' => '', 'image' => 0 ],
            [ 'name' => 'Destination Weddings', 'type' => 'Destination Wedding', 'region' => '', 'country' => '', 'subregion' => '', 'destination' => '', 'duration' => '', 'budget' => '', 'url' => '', 'image' => 0 ],
            [ 'name' => 'International',        'type' => 'International',       'region' => '', 'country' => '', 'subregion' => '', 'destination' => '', 'duration' => '', 'budget' => '', 'url' => '', 'image' => 0 ],
        ];
    }

    wp_nonce_field( 'travzo_tiles_save', 'travzo_tiles_nonce' );

    // Shared option arrays
    $type_options     = [ '' => 'All Types', 'Group Tour' => 'Group Tour', 'Honeymoon' => 'Honeymoon', 'Solo Trip' => 'Solo Trip', 'Devotional' => 'Devotional', 'Destination Wedding' => 'Destination Wedding', 'International' => 'International' ];
    $region_options   = [ '' => 'All Regions', 'domestic' => 'Domestic - India', 'international' => 'International' ];
    $duration_options = [ '' => 'Any Duration', '3-5' => '3–5 Days', '6-8' => '6–8 Days', '9-12' => '9–12 Days', '13+' => '13+ Days' ];
    $budget_options   = [ '' => 'Any Budget', 'under-15000' => 'Under ₹15,000', '15000-30000' => '₹15,000 – ₹30,000', '30000-60000' => '₹30,000 – ₹60,000', 'above-60000' => '₹60,000+' ];
    $countries        = travzo_get_countries();

    // Sub-region options (India + International)
    $subregion_options = [ '' => 'All Sub-regions', 'North India' => 'North India', 'South India' => 'South India', 'East India' => 'East India', 'West India' => 'West India', 'Northeast India' => 'Northeast India', 'Himalayas' => 'Himalayas', 'Southeast Asia' => 'Southeast Asia', 'East Asia' => 'East Asia', 'Middle East' => 'Middle East', 'Europe' => 'Europe', 'Americas' => 'Americas', 'Africa' => 'Africa', 'Oceania' => 'Oceania' ];

    // ── Section header fields ──
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION LABEL</label>';
    echo '<input type="text" name="_homepage_packages_label" class="widefat" value="' . esc_attr( $pkg_label ) . '" placeholder="WHAT WE OFFER"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION HEADING</label>';
    echo '<input type="text" name="_homepage_packages_heading" class="widefat" value="' . esc_attr( $pkg_heading ) . '" placeholder="Our Packages"></div>';
    echo '</div>';
    echo '<hr style="border:none;border-top:1px solid #e0e0e0;margin:0 0 16px">';

    echo '<p style="color:#666;margin-bottom:16px">Each tile is a flexible filter combination. Package count auto-calculates from matching live packages. Drag to reorder, click header to collapse.</p>';
    echo '<div id="travzo-tiles-container">';

    foreach ( $tiles as $i => $tile ) {
        $t = wp_parse_args( $tile, [
            'name' => '', 'type' => '', 'region' => '', 'country' => '',
            'subregion' => '', 'destination' => '', 'duration' => '',
            'budget' => '', 'url' => '', 'image' => 0, 'image_url' => '',
        ] );
        $t_img_id  = absint( $t['image'] );
        $t_img_url = $t_img_id ? wp_get_attachment_image_url( $t_img_id, 'thumbnail' ) : '';
        if ( ! $t_img_url && ! empty( $t['image_url'] ) ) {
            $t_img_url = $t['image_url']; // fallback for migrated tiles
        }

        // Count for this tile
        $tile_count = travzo_tile_count_packages( $t );
        $tile_label = $t['name'] ?: 'Untitled Tile';

        echo '<div class="travzo-tile-card" style="border:1px solid #ddd;border-radius:6px;margin-bottom:10px;background:#fff">';

        // ── Card header (collapsible + drag handle) ──
        echo '<div class="travzo-tile-header" style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:#f5f5f5;border-bottom:1px solid #ddd;border-radius:6px 6px 0 0;cursor:grab">';
        echo '<span style="font-weight:600;font-size:13px" class="travzo-tile-label">' . esc_html( $tile_label ) . '</span>';
        echo '<span style="display:flex;align-items:center;gap:10px">';
        echo '<span style="font-size:11px;color:#666;background:#e8e8e8;padding:2px 8px;border-radius:10px">' . $tile_count . ' package' . ( $tile_count !== 1 ? 's' : '' ) . '</span>';
        echo '<button type="button" class="travzo-tile-toggle button button-small" style="font-size:11px">▼</button>';
        echo '<button type="button" class="button travzo-remove-tile" style="color:#dc2626;font-size:11px">✕ Remove</button>';
        echo '</span>';
        echo '</div>';

        // ── Card body (collapsible) ──
        echo '<div class="travzo-tile-body" style="padding:14px;display:grid;grid-template-columns:1fr 1fr;gap:12px">';

        // Row 1: Tile Name (full width)
        echo '<div style="grid-column:1/-1"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">TILE NAME</label>';
        echo '<input type="text" name="tiles_name[]" value="' . esc_attr( $t['name'] ) . '" placeholder="e.g. Thailand Honeymoon" style="width:100%" class="travzo-tile-name-input"></div>';

        // Row 2: Package Type | Region
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">PACKAGE TYPE</label>';
        echo '<select name="tiles_type[]" style="width:100%">';
        foreach ( $type_options as $val => $label ) {
            echo '<option value="' . esc_attr( $val ) . '"' . selected( $t['type'], $val, false ) . '>' . esc_html( $label ) . '</option>';
        }
        echo '</select></div>';

        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">REGION</label>';
        echo '<select name="tiles_region[]" style="width:100%">';
        foreach ( $region_options as $val => $label ) {
            echo '<option value="' . esc_attr( $val ) . '"' . selected( $t['region'], $val, false ) . '>' . esc_html( $label ) . '</option>';
        }
        echo '</select></div>';

        // Row 3: Country | Sub-region
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">COUNTRY</label>';
        echo '<select name="tiles_country[]" style="width:100%">';
        echo '<option value="">All Countries</option>';
        foreach ( $countries as $c ) {
            echo '<option value="' . esc_attr( $c ) . '"' . selected( $t['country'], $c, false ) . '>' . esc_html( $c ) . '</option>';
        }
        echo '</select></div>';

        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SUB-REGION</label>';
        echo '<select name="tiles_subregion[]" style="width:100%">';
        foreach ( $subregion_options as $val => $label ) {
            echo '<option value="' . esc_attr( $val ) . '"' . selected( $t['subregion'], $val, false ) . '>' . esc_html( $label ) . '</option>';
        }
        echo '</select></div>';

        // Row 4: Destination | Duration
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DESTINATION</label>';
        echo '<input type="text" name="tiles_destination[]" value="' . esc_attr( $t['destination'] ) . '" placeholder="e.g. Ooty, Kodaikanal" style="width:100%"></div>';

        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DURATION</label>';
        echo '<select name="tiles_duration[]" style="width:100%">';
        foreach ( $duration_options as $val => $label ) {
            echo '<option value="' . esc_attr( $val ) . '"' . selected( $t['duration'], $val, false ) . '>' . esc_html( $label ) . '</option>';
        }
        echo '</select></div>';

        // Row 5: Budget | Custom URL
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">BUDGET</label>';
        echo '<select name="tiles_budget[]" style="width:100%">';
        foreach ( $budget_options as $val => $label ) {
            echo '<option value="' . esc_attr( $val ) . '"' . selected( $t['budget'], $val, false ) . '>' . esc_html( $label ) . '</option>';
        }
        echo '</select></div>';

        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">CUSTOM URL <span style="font-weight:400;color:#999">(optional)</span></label>';
        echo '<input type="url" name="tiles_url[]" value="' . esc_attr( $t['url'] ) . '" placeholder="Leave blank to auto-build from filters" style="width:100%"></div>';

        // Row 6: Cover Image (full width)
        echo '<div style="grid-column:1/-1"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">COVER IMAGE</label>';
        echo '<div style="display:flex;align-items:center;gap:12px">';
        echo '<div class="travzo-tile-img-preview" style="width:120px;height:80px;border-radius:6px;overflow:hidden;border:1px solid #ddd;background:#f0f0f0;display:flex;align-items:center;justify-content:center">';
        if ( $t_img_url ) {
            echo '<img src="' . esc_url( $t_img_url ) . '" style="width:100%;height:100%;object-fit:cover">';
        } else {
            echo '<span style="font-size:11px;color:#999">No image</span>';
        }
        echo '</div>';
        echo '<input type="hidden" name="tiles_image[]" value="' . esc_attr( $t_img_id ) . '" class="travzo-tile-img-id">';
        echo '<button type="button" class="button travzo-tile-choose-img">Choose Image</button>';
        echo '<button type="button" class="button travzo-tile-remove-img" style="color:#dc2626;' . ( $t_img_id ? '' : 'display:none' ) . '">Remove</button>';
        echo '</div></div>';

        echo '</div><!-- /.travzo-tile-body -->';
        echo '</div><!-- /.travzo-tile-card -->';
    }

    echo '</div><!-- /#travzo-tiles-container -->';
    echo '<button type="button" id="travzo-add-tile" class="button button-secondary" style="margin-top:12px">+ Add Tile</button>';

    ?>
    <script>
    jQuery(function($) {
        var $container = $('#travzo-tiles-container');

        // ── Sortable ──
        $container.sortable({ handle: '.travzo-tile-header', tolerance: 'pointer', placeholder: 'sortable-placeholder' });

        // ── Collapse / Expand ──
        $(document).on('click', '.travzo-tile-toggle', function() {
            var $body = $(this).closest('.travzo-tile-card').find('.travzo-tile-body');
            $body.slideToggle(200);
            $(this).text($body.is(':visible') ? '▲' : '▼');
        });

        // ── Live tile label update ──
        $(document).on('input', '.travzo-tile-name-input', function() {
            var val = $(this).val() || 'Untitled Tile';
            $(this).closest('.travzo-tile-card').find('.travzo-tile-label').text(val);
        });

        // ── Remove tile ──
        $(document).on('click', '.travzo-remove-tile', function() {
            if ($('.travzo-tile-card').length > 1) {
                $(this).closest('.travzo-tile-card').remove();
            } else {
                alert('You need at least one tile.');
            }
        });

        // ── Cover image: Choose ──
        $(document).on('click', '.travzo-tile-choose-img', function() {
            var $card = $(this).closest('.travzo-tile-card');
            var frame = wp.media({ title: 'Select Cover Image', button: { text: 'Use Image' }, multiple: false });
            frame.on('select', function() {
                var att = frame.state().get('selection').first().toJSON();
                $card.find('.travzo-tile-img-id').val(att.id);
                var thumbUrl = (att.sizes && att.sizes.thumbnail) ? att.sizes.thumbnail.url : att.url;
                $card.find('.travzo-tile-img-preview').html('<img src="'+thumbUrl+'" style="width:100%;height:100%;object-fit:cover">');
                $card.find('.travzo-tile-remove-img').show();
            });
            frame.open();
        });

        // ── Cover image: Remove ──
        $(document).on('click', '.travzo-tile-remove-img', function() {
            var $card = $(this).closest('.travzo-tile-card');
            $card.find('.travzo-tile-img-id').val('0');
            $card.find('.travzo-tile-img-preview').html('<span style="font-size:11px;color:#999">No image</span>');
            $(this).hide();
        });

        // ── Add Tile ──
        var typeOpts = <?php echo wp_json_encode( $type_options ); ?>;
        var regionOpts = <?php echo wp_json_encode( $region_options ); ?>;
        var durationOpts = <?php echo wp_json_encode( $duration_options ); ?>;
        var budgetOpts = <?php echo wp_json_encode( $budget_options ); ?>;
        var subregionOpts = <?php echo wp_json_encode( $subregion_options ); ?>;
        var countryList = <?php echo wp_json_encode( $countries ); ?>;

        function buildSelect(name, opts, placeholder) {
            var html = '<select name="'+name+'" style="width:100%">';
            $.each(opts, function(val, label) { html += '<option value="'+val+'">'+label+'</option>'; });
            html += '</select>';
            return html;
        }
        function buildCountrySelect() {
            var html = '<select name="tiles_country[]" style="width:100%"><option value="">All Countries</option>';
            $.each(countryList, function(i, c) { html += '<option value="'+c+'">'+c+'</option>'; });
            html += '</select>';
            return html;
        }

        $('#travzo-add-tile').on('click', function() {
            var card = '<div class="travzo-tile-card" style="border:1px solid #ddd;border-radius:6px;margin-bottom:10px;background:#fff">';
            card += '<div class="travzo-tile-header" style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:#f5f5f5;border-bottom:1px solid #ddd;border-radius:6px 6px 0 0;cursor:grab">';
            card += '<span style="font-weight:600;font-size:13px" class="travzo-tile-label">New Tile</span>';
            card += '<span style="display:flex;align-items:center;gap:10px">';
            card += '<span style="font-size:11px;color:#666;background:#e8e8e8;padding:2px 8px;border-radius:10px">save to count</span>';
            card += '<button type="button" class="travzo-tile-toggle button button-small" style="font-size:11px">▼</button>';
            card += '<button type="button" class="button travzo-remove-tile" style="color:#dc2626;font-size:11px">✕ Remove</button>';
            card += '</span></div>';
            card += '<div class="travzo-tile-body" style="padding:14px;display:grid;grid-template-columns:1fr 1fr;gap:12px">';
            // Row 1: Name
            card += '<div style="grid-column:1/-1"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">TILE NAME</label><input type="text" name="tiles_name[]" placeholder="e.g. Thailand Honeymoon" style="width:100%" class="travzo-tile-name-input"></div>';
            // Row 2: Type | Region
            card += '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">PACKAGE TYPE</label>'+buildSelect('tiles_type[]', typeOpts)+'</div>';
            card += '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">REGION</label>'+buildSelect('tiles_region[]', regionOpts)+'</div>';
            // Row 3: Country | Sub-region
            card += '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">COUNTRY</label>'+buildCountrySelect()+'</div>';
            card += '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SUB-REGION</label>'+buildSelect('tiles_subregion[]', subregionOpts)+'</div>';
            // Row 4: Destination | Duration
            card += '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DESTINATION</label><input type="text" name="tiles_destination[]" placeholder="e.g. Ooty, Kodaikanal" style="width:100%"></div>';
            card += '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DURATION</label>'+buildSelect('tiles_duration[]', durationOpts)+'</div>';
            // Row 5: Budget | URL
            card += '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">BUDGET</label>'+buildSelect('tiles_budget[]', budgetOpts)+'</div>';
            card += '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">CUSTOM URL <span style="font-weight:400;color:#999">(optional)</span></label><input type="url" name="tiles_url[]" placeholder="Leave blank to auto-build" style="width:100%"></div>';
            // Row 6: Cover Image
            card += '<div style="grid-column:1/-1"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">COVER IMAGE</label>';
            card += '<div style="display:flex;align-items:center;gap:12px">';
            card += '<div class="travzo-tile-img-preview" style="width:120px;height:80px;border-radius:6px;overflow:hidden;border:1px solid #ddd;background:#f0f0f0;display:flex;align-items:center;justify-content:center"><span style="font-size:11px;color:#999">No image</span></div>';
            card += '<input type="hidden" name="tiles_image[]" value="0" class="travzo-tile-img-id">';
            card += '<button type="button" class="button travzo-tile-choose-img">Choose Image</button>';
            card += '<button type="button" class="button travzo-tile-remove-img" style="color:#dc2626;display:none">Remove</button>';
            card += '</div></div>';
            card += '</div></div>';
            $container.append(card);
        });
    });
    </script>
    <?php
}

// ── About Page – Our Story Section ──────────────────────────────────────────
function travzo_about_story_cb( $post ) {
    $label     = get_post_meta( $post->ID, '_about_story_label', true );
    $heading   = get_post_meta( $post->ID, '_about_story_heading', true );
    $text      = get_post_meta( $post->ID, '_about_story_text', true );
    $image     = get_post_meta( $post->ID, '_about_story_image', true );
    $keypoints = get_post_meta( $post->ID, '_about_story_keypoints', true );
    $btn_text  = get_post_meta( $post->ID, '_about_story_btn_text', true );
    $btn_url   = get_post_meta( $post->ID, '_about_story_btn_url', true );

    // Backward compat
    if ( '' === $label )   $label   = travzo_get( 'travzo_about_story_label', '' );
    if ( '' === $heading ) $heading = travzo_get( 'travzo_about_story_heading', '' );

    wp_nonce_field( 'travzo_about_story_save', 'travzo_about_story_nonce' );

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION LABEL</label>';
    echo '<input type="text" name="_about_story_label" class="widefat" value="' . esc_attr( $label ) . '" placeholder="OUR STORY"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION HEADING</label>';
    echo '<input type="text" name="_about_story_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Who We Are"></div>';
    echo '</div>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DESCRIPTION</label>';
    echo '<textarea name="_about_story_text" class="widefat" rows="6" placeholder="Write your story text here...">' . esc_textarea( $text ) . '</textarea></div>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">KEY POINTS <span style="font-weight:400;color:#999">(one per line — shown as gold checkmark list)</span></label>';
    echo '<textarea name="_about_story_keypoints" class="widefat" rows="4" placeholder="Handcrafted Itineraries&#10;Best Price Guarantee&#10;24/7 Support">' . esc_textarea( $keypoints ) . '</textarea></div>';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">BUTTON TEXT</label>';
    echo '<input type="text" name="_about_story_btn_text" class="widefat" value="' . esc_attr( $btn_text ) . '" placeholder="Explore Our Packages"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">BUTTON URL</label>';
    echo '<input type="text" name="_about_story_btn_url" class="widefat" value="' . esc_attr( $btn_url ) . '" placeholder="/packages"></div>';
    echo '</div>';

    // Image upload
    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">STORY IMAGE</label>';
    echo '<div style="display:flex;gap:8px;align-items:flex-start">';
    echo '<input type="url" name="_about_story_image" id="about-story-image-input" class="widefat" value="' . esc_attr( $image ) . '" placeholder="https://..." style="flex:1">';
    echo '<button type="button" class="button" id="about-story-upload-btn">Choose Image</button>';
    echo '<button type="button" class="button" id="about-story-remove-btn" style="color:#dc2626">Remove</button>';
    echo '</div>';
    echo '<div id="about-story-preview" style="margin-top:8px">';
    if ( $image ) echo '<img src="' . esc_url( $image ) . '" style="max-width:300px;max-height:150px;border-radius:8px;border:1px solid #e0e0e0">';
    echo '</div></div>';

    echo '<script>
    jQuery(function($) {
        $("#about-story-upload-btn").on("click", function() {
            var frame = wp.media({ title: "Select Story Image", button: { text: "Use Image" }, multiple: false });
            frame.on("select", function() {
                var url = frame.state().get("selection").first().toJSON().url;
                $("#about-story-image-input").val(url);
                $("#about-story-preview").html(\'<img src="\' + url + \'" style="max-width:300px;max-height:150px;border-radius:8px;border:1px solid #e0e0e0">\');
            });
            frame.open();
        });
        $("#about-story-remove-btn").on("click", function() {
            $("#about-story-image-input").val("");
            $("#about-story-preview").html("");
        });
    });
    </script>';
}

// ── About Page – Stats Bar ──────────────────────────────────────────────────
function travzo_about_stats_cb( $post ) {
    $visible = get_post_meta( $post->ID, '_about_stats_visible', true );
    $stats   = get_post_meta( $post->ID, '_about_stats', true );

    if ( '' === $visible ) $visible = '1';
    if ( ! is_array( $stats ) || empty( $stats ) ) {
        $stats = [
            [ 'number' => travzo_get( 'travzo_about_stat1_number', '500+' ), 'label' => travzo_get( 'travzo_about_stat1_label', 'Happy Travellers' ),        'sublabel' => '' ],
            [ 'number' => travzo_get( 'travzo_about_stat2_number', '50+' ),  'label' => travzo_get( 'travzo_about_stat2_label', 'Destinations' ),             'sublabel' => '' ],
            [ 'number' => travzo_get( 'travzo_about_stat3_number', '10+' ),  'label' => travzo_get( 'travzo_about_stat3_label', 'Years Experience' ),          'sublabel' => '' ],
            [ 'number' => travzo_get( 'travzo_about_stat4_number', '100%' ), 'label' => travzo_get( 'travzo_about_stat4_label', 'Customised Itineraries' ),    'sublabel' => '' ],
        ];
    }

    wp_nonce_field( 'travzo_about_stats_save', 'travzo_about_stats_nonce' );

    $checked = ( '1' === $visible ) ? ' checked' : '';
    echo '<div style="margin-bottom:12px"><label><input type="checkbox" name="_about_stats_visible" value="1"' . $checked . '> Show Stats Bar section</label></div>';
    echo '<input type="hidden" name="_about_stats_data" id="about-stats-data" value="' . esc_attr( wp_json_encode( $stats ) ) . '">';
    echo '<div id="about-stats-list">';
    foreach ( $stats as $stat ) {
        echo '<div class="about-stat-row" style="display:flex;gap:8px;margin-bottom:8px;align-items:center">';
        echo '<input type="text" class="abst-number widefat" value="' . esc_attr( $stat['number'] ?? '' ) . '" placeholder="500+" style="flex:1">';
        echo '<input type="text" class="abst-label widefat" value="' . esc_attr( $stat['label'] ?? '' ) . '" placeholder="Happy Travellers" style="flex:2">';
        echo '<input type="text" class="abst-sublabel widefat" value="' . esc_attr( $stat['sublabel'] ?? '' ) . '" placeholder="Sublabel (optional)" style="flex:2">';
        echo '<button type="button" class="button abst-remove" style="color:#dc2626">✕</button>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="about-stats-add" style="margin-top:4px">+ Add Stat</button>';

    echo '<script>
    jQuery(function($) {
        function syncAboutStats() {
            var items = [];
            $("#about-stats-list .about-stat-row").each(function() {
                items.push({ number: $(this).find(".abst-number").val(), label: $(this).find(".abst-label").val(), sublabel: $(this).find(".abst-sublabel").val() });
            });
            $("#about-stats-data").val(JSON.stringify(items));
        }
        $("#about-stats-list").on("input change", "input", syncAboutStats);
        $("#about-stats-list").on("click", ".abst-remove", function() { $(this).closest(".about-stat-row").remove(); syncAboutStats(); });
        $("#about-stats-add").on("click", function() {
            $("#about-stats-list").append(\'<div class="about-stat-row" style="display:flex;gap:8px;margin-bottom:8px;align-items:center"><input type="text" class="abst-number widefat" placeholder="500+" style="flex:1"><input type="text" class="abst-label widefat" placeholder="Label" style="flex:2"><input type="text" class="abst-sublabel widefat" placeholder="Sublabel (optional)" style="flex:2"><button type="button" class="button abst-remove" style="color:#dc2626">✕</button></div>\');
        });
    });
    </script>';
}

// ── About Page – Why Travel With Us ─────────────────────────────────────────
function travzo_about_whyus_cb( $post ) {
    $label   = get_post_meta( $post->ID, '_about_whyus_label', true );
    $heading = get_post_meta( $post->ID, '_about_whyus_heading', true );
    $tiles   = get_post_meta( $post->ID, '_about_whyus_tiles', true );

    if ( '' === $label )   $label   = travzo_get( 'travzo_about_whyus_label', '' );
    if ( '' === $heading ) $heading = travzo_get( 'travzo_about_whyus_heading', '' );
    if ( ! is_array( $tiles ) || empty( $tiles ) ) $tiles = [];

    wp_nonce_field( 'travzo_about_whyus_save', 'travzo_about_whyus_nonce' );

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION LABEL</label>';
    echo '<input type="text" name="_about_whyus_label" class="widefat" value="' . esc_attr( $label ) . '" placeholder="WHY TRAVZO"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION HEADING</label>';
    echo '<input type="text" name="_about_whyus_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Why Travel With Us"></div>';
    echo '</div>';

    echo '<hr style="border:none;border-top:2px solid #e0e0e0;margin:0 0 16px">';
    echo '<label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:8px">FEATURE TILES</label>';
    echo '<input type="hidden" name="_about_whyus_tiles_data" id="about-whyus-tiles-data" value="' . esc_attr( wp_json_encode( $tiles ) ) . '">';
    echo '<div id="about-whyus-list">';
    foreach ( $tiles as $tile ) {
        echo '<div class="abwu-row" style="border:1px solid #e0e0e0;border-radius:6px;padding:10px;margin-bottom:8px">';
        echo '<div style="display:grid;grid-template-columns:1fr 2fr;gap:8px;margin-bottom:6px">';
        echo '<input type="text" class="abwu-icon widefat" value="' . esc_attr( $tile['icon'] ?? '' ) . '" placeholder="Icon class (optional)">';
        echo '<input type="text" class="abwu-title widefat" value="' . esc_attr( $tile['title'] ?? '' ) . '" placeholder="Feature Title">';
        echo '</div>';
        echo '<div style="display:flex;gap:8px;align-items:flex-start">';
        echo '<textarea class="abwu-desc widefat" rows="2" placeholder="Feature description" style="flex:1">' . esc_textarea( $tile['desc'] ?? '' ) . '</textarea>';
        echo '<button type="button" class="button abwu-remove" style="color:#dc2626;align-self:center">✕</button>';
        echo '</div></div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="about-whyus-add" style="margin-top:4px">+ Add Feature Tile</button>';

    echo '<script>
    jQuery(function($) {
        function syncAboutWhyus() {
            var items = [];
            $("#about-whyus-list .abwu-row").each(function() {
                items.push({ icon: $(this).find(".abwu-icon").val(), title: $(this).find(".abwu-title").val(), desc: $(this).find(".abwu-desc").val() });
            });
            $("#about-whyus-tiles-data").val(JSON.stringify(items));
        }
        $("#about-whyus-list").on("input change", "input, textarea", syncAboutWhyus);
        $("#about-whyus-list").on("click", ".abwu-remove", function() { $(this).closest(".abwu-row").remove(); syncAboutWhyus(); });
        $("#about-whyus-add").on("click", function() {
            $("#about-whyus-list").append(\'<div class="abwu-row" style="border:1px solid #e0e0e0;border-radius:6px;padding:10px;margin-bottom:8px"><div style="display:grid;grid-template-columns:1fr 2fr;gap:8px;margin-bottom:6px"><input type="text" class="abwu-icon widefat" placeholder="Icon class (optional)"><input type="text" class="abwu-title widefat" placeholder="Feature Title"></div><div style="display:flex;gap:8px;align-items:flex-start"><textarea class="abwu-desc widefat" rows="2" placeholder="Feature description" style="flex:1"></textarea><button type="button" class="button abwu-remove" style="color:#dc2626;align-self:center">✕</button></div></div>\');
        });
    });
    </script>';
}

// ── About Page – Accreditation Partners ─────────────────────────────────────
function travzo_about_accreditation_cb( $post ) {
    $visible  = get_post_meta( $post->ID, '_about_accreditation_visible', true );
    $label    = get_post_meta( $post->ID, '_about_accreditation_label', true );
    $heading  = get_post_meta( $post->ID, '_about_accreditation_heading', true );
    $partners = get_post_meta( $post->ID, '_about_accreditation_partners', true );

    if ( '' === $visible ) $visible = '1';
    if ( '' === $label )   $label   = travzo_get( 'travzo_about_accreditation_label', '' );
    if ( '' === $heading ) $heading = travzo_get( 'travzo_about_accreditation_heading', '' );
    if ( ! is_array( $partners ) || empty( $partners ) ) $partners = [];

    wp_nonce_field( 'travzo_about_accreditation_save', 'travzo_about_accreditation_nonce' );

    $checked = ( '1' === $visible ) ? ' checked' : '';
    echo '<div style="margin-bottom:12px"><label><input type="checkbox" name="_about_accreditation_visible" value="1"' . $checked . '> Show Accreditation Partners section</label></div>';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION LABEL</label>';
    echo '<input type="text" name="_about_accreditation_label" class="widefat" value="' . esc_attr( $label ) . '" placeholder="TRUSTED BY"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION HEADING</label>';
    echo '<input type="text" name="_about_accreditation_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Our Accreditation Partners"></div>';
    echo '</div>';

    echo '<hr style="border:none;border-top:2px solid #e0e0e0;margin:0 0 16px">';
    echo '<label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:8px">PARTNERS</label>';
    echo '<input type="hidden" name="_about_accreditation_partners_data" id="about-accreditation-data" value="' . esc_attr( wp_json_encode( $partners ) ) . '">';
    echo '<div id="about-accreditation-list">';
    foreach ( $partners as $idx => $p ) {
        $p_name = $p['name'] ?? '';
        $p_logo = $p['logo'] ?? '';
        $p_url  = $p['url'] ?? '';
        echo '<div class="abac-row" style="border:1px solid #e0e0e0;border-radius:6px;padding:10px;margin-bottom:8px">';
        echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:6px">';
        echo '<input type="text" class="abac-name widefat" value="' . esc_attr( $p_name ) . '" placeholder="Partner Name">';
        echo '<div style="display:flex;gap:4px"><input type="url" class="abac-logo widefat" value="' . esc_attr( $p_logo ) . '" placeholder="Logo URL" style="flex:1"><button type="button" class="button abac-logo-upload" style="white-space:nowrap">Choose</button></div>';
        echo '<div style="display:flex;gap:4px"><input type="url" class="abac-url widefat" value="' . esc_attr( $p_url ) . '" placeholder="Link URL (optional)" style="flex:1"><button type="button" class="button abac-remove" style="color:#dc2626">✕</button></div>';
        echo '</div>';
        echo '<div class="abac-logo-preview" style="margin-top:4px">';
        if ( $p_logo ) echo '<img src="' . esc_url( $p_logo ) . '" style="max-width:120px;max-height:60px;border-radius:4px;border:1px solid #e0e0e0">';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="about-accreditation-add" style="margin-top:4px">+ Add Partner</button>';

    echo '<script>
    jQuery(function($) {
        function syncAccreditation() {
            var items = [];
            $("#about-accreditation-list .abac-row").each(function() {
                items.push({ name: $(this).find(".abac-name").val(), logo: $(this).find(".abac-logo").val(), url: $(this).find(".abac-url").val() });
            });
            $("#about-accreditation-data").val(JSON.stringify(items));
        }
        $("#about-accreditation-list").on("input change", "input", syncAccreditation);
        $("#about-accreditation-list").on("click", ".abac-remove", function() { $(this).closest(".abac-row").remove(); syncAccreditation(); });
        $("#about-accreditation-list").on("click", ".abac-logo-upload", function() {
            var $row = $(this).closest(".abac-row");
            var frame = wp.media({ title: "Select Logo", button: { text: "Use Image" }, multiple: false });
            frame.on("select", function() {
                var url = frame.state().get("selection").first().toJSON().url;
                $row.find(".abac-logo").val(url);
                $row.find(".abac-logo-preview").html(\'<img src="\' + url + \'" style="max-width:120px;max-height:60px;border-radius:4px;border:1px solid #e0e0e0">\');
                syncAccreditation();
            });
            frame.open();
        });
        $("#about-accreditation-add").on("click", function() {
            $("#about-accreditation-list").append(\'<div class="abac-row" style="border:1px solid #e0e0e0;border-radius:6px;padding:10px;margin-bottom:8px"><div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:6px"><input type="text" class="abac-name widefat" placeholder="Partner Name"><div style="display:flex;gap:4px"><input type="url" class="abac-logo widefat" placeholder="Logo URL" style="flex:1"><button type="button" class="button abac-logo-upload" style="white-space:nowrap">Choose</button></div><div style="display:flex;gap:4px"><input type="url" class="abac-url widefat" placeholder="Link URL (optional)" style="flex:1"><button type="button" class="button abac-remove" style="color:#dc2626">✕</button></div></div><div class="abac-logo-preview" style="margin-top:4px"></div></div>\');
        });
    });
    </script>';
}

// ── About Page – Testimonials ───────────────────────────────────────────────
function travzo_about_testimonials_cb( $post ) {
    $label        = get_post_meta( $post->ID, '_about_testimonials_label', true );
    $heading      = get_post_meta( $post->ID, '_about_testimonials_heading', true );
    $testimonials = get_post_meta( $post->ID, '_about_testimonials', true );

    if ( '' === $label )   $label   = travzo_get( 'travzo_about_testimonials_label', '' );
    if ( '' === $heading ) $heading = travzo_get( 'travzo_about_testimonials_heading', '' );
    if ( ! is_array( $testimonials ) || empty( $testimonials ) ) $testimonials = [];

    wp_nonce_field( 'travzo_about_testimonials_save', 'travzo_about_testimonials_nonce' );

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION LABEL</label>';
    echo '<input type="text" name="_about_testimonials_label" class="widefat" value="' . esc_attr( $label ) . '" placeholder="HAPPY TRAVELLERS"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION HEADING</label>';
    echo '<input type="text" name="_about_testimonials_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="What Our Travellers Say"></div>';
    echo '</div>';

    echo '<hr style="border:none;border-top:2px solid #e0e0e0;margin:0 0 16px">';
    echo '<input type="hidden" name="_about_testimonials_data" id="about-testimonials-data" value="' . esc_attr( wp_json_encode( $testimonials ) ) . '">';
    echo '<div id="about-testimonials-list">';
    foreach ( $testimonials as $t ) {
        echo '<div class="abt-row" style="border:1px solid #e0e0e0;border-radius:6px;padding:10px;margin-bottom:8px">';
        echo '<div style="display:grid;grid-template-columns:1fr 1fr 80px;gap:8px;margin-bottom:6px">';
        echo '<input type="text" class="abt-name widefat" value="' . esc_attr( $t['name'] ?? '' ) . '" placeholder="Customer Name">';
        echo '<input type="text" class="abt-trip widefat" value="' . esc_attr( $t['trip'] ?? '' ) . '" placeholder="Trip/Package Name">';
        echo '<input type="number" class="abt-rating widefat" value="' . esc_attr( $t['rating'] ?? 5 ) . '" placeholder="5" min="1" max="5">';
        echo '</div>';
        echo '<div style="display:flex;gap:8px;align-items:flex-start">';
        echo '<textarea class="abt-quote widefat" rows="2" placeholder="Testimonial quote" style="flex:1">' . esc_textarea( $t['quote'] ?? '' ) . '</textarea>';
        echo '<button type="button" class="button abt-remove" style="color:#dc2626;align-self:center">✕</button>';
        echo '</div></div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="about-testimonials-add" style="margin-top:4px">+ Add Testimonial</button>';

    echo '<script>
    jQuery(function($) {
        function syncAboutTestimonials() {
            var items = [];
            $("#about-testimonials-list .abt-row").each(function() {
                items.push({ name: $(this).find(".abt-name").val(), trip: $(this).find(".abt-trip").val(), quote: $(this).find(".abt-quote").val(), rating: parseInt($(this).find(".abt-rating").val()) || 5 });
            });
            $("#about-testimonials-data").val(JSON.stringify(items));
        }
        $("#about-testimonials-list").on("input change", "input, textarea", syncAboutTestimonials);
        $("#about-testimonials-list").on("click", ".abt-remove", function() { $(this).closest(".abt-row").remove(); syncAboutTestimonials(); });
        $("#about-testimonials-add").on("click", function() {
            $("#about-testimonials-list").append(\'<div class="abt-row" style="border:1px solid #e0e0e0;border-radius:6px;padding:10px;margin-bottom:8px"><div style="display:grid;grid-template-columns:1fr 1fr 80px;gap:8px;margin-bottom:6px"><input type="text" class="abt-name widefat" placeholder="Customer Name"><input type="text" class="abt-trip widefat" placeholder="Trip/Package Name"><input type="number" class="abt-rating widefat" placeholder="5" min="1" max="5" value="5"></div><div style="display:flex;gap:8px;align-items:flex-start"><textarea class="abt-quote widefat" rows="2" placeholder="Testimonial quote" style="flex:1"></textarea><button type="button" class="button abt-remove" style="color:#dc2626;align-self:center">✕</button></div></div>\');
        });
    });
    </script>';
}

// ── About Page – CTA Section ────────────────────────────────────────────────
function travzo_about_cta_cb( $post ) {
    $visible  = get_post_meta( $post->ID, '_about_cta_visible', true );
    $heading  = get_post_meta( $post->ID, '_about_cta_heading', true );
    $desc     = get_post_meta( $post->ID, '_about_cta_description', true );
    $btn1_text = get_post_meta( $post->ID, '_about_cta_btn1_text', true );
    $btn1_url  = get_post_meta( $post->ID, '_about_cta_btn1_url', true );
    $btn2_text = get_post_meta( $post->ID, '_about_cta_btn2_text', true );
    $btn2_url  = get_post_meta( $post->ID, '_about_cta_btn2_url', true );

    if ( '' === $visible )   $visible   = '1';
    if ( '' === $heading )   $heading   = travzo_get( 'travzo_about_cta_heading', '' );
    if ( '' === $desc )      $desc      = travzo_get( 'travzo_about_cta_description', '' );
    if ( '' === $btn1_text ) $btn1_text = travzo_get( 'travzo_about_cta_btn1_text', '' );
    if ( '' === $btn1_url )  $btn1_url  = travzo_get( 'travzo_about_cta_btn1_url', '' );
    if ( '' === $btn2_text ) $btn2_text = travzo_get( 'travzo_about_cta_btn2_text', '' );
    if ( '' === $btn2_url )  $btn2_url  = travzo_get( 'travzo_about_cta_btn2_url', '' );

    wp_nonce_field( 'travzo_about_cta_save', 'travzo_about_cta_nonce' );

    $checked = ( '1' === $visible ) ? ' checked' : '';
    echo '<div style="margin-bottom:12px"><label><input type="checkbox" name="_about_cta_visible" value="1"' . $checked . '> Show CTA section</label></div>';

    echo '<div style="display:grid;grid-template-columns:1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HEADING</label>';
    echo '<input type="text" name="_about_cta_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Ready to Start Your Journey?"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">DESCRIPTION</label>';
    echo '<textarea name="_about_cta_description" class="widefat" rows="2" placeholder="Let us help you create memories that last a lifetime">' . esc_textarea( $desc ) . '</textarea></div>';
    echo '</div>';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">PRIMARY BUTTON TEXT</label>';
    echo '<input type="text" name="_about_cta_btn1_text" class="widefat" value="' . esc_attr( $btn1_text ) . '" placeholder="Explore Packages"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">PRIMARY BUTTON URL</label>';
    echo '<input type="text" name="_about_cta_btn1_url" class="widefat" value="' . esc_attr( $btn1_url ) . '" placeholder="/packages"></div>';
    echo '</div>';
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECONDARY BUTTON TEXT</label>';
    echo '<input type="text" name="_about_cta_btn2_text" class="widefat" value="' . esc_attr( $btn2_text ) . '" placeholder="Contact Us"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECONDARY BUTTON URL</label>';
    echo '<input type="text" name="_about_cta_btn2_url" class="widefat" value="' . esc_attr( $btn2_url ) . '" placeholder="/contact"></div>';
    echo '</div>';
}

// ── Contact Page – Contact Information Card ─────────────────────────────────
function travzo_contact_info_cb( $post ) {
    $fields = [
        '_contact_info_heading'       => [ 'label' => 'HEADING',        'default' => 'Contact Information',                               'type' => 'text' ],
        '_contact_info_subtext'       => [ 'label' => 'SUBTEXT',        'default' => "We're here to help you plan the perfect trip.",      'type' => 'text' ],
        '_contact_info_address_label' => [ 'label' => 'ADDRESS LABEL',  'default' => 'Address',                                           'type' => 'text' ],
        '_contact_info_address'       => [ 'label' => 'ADDRESS',        'default' => '123 Travel Street, Chennai, Tamil Nadu 600001',      'type' => 'textarea' ],
        '_contact_info_phone_label'   => [ 'label' => 'PHONE LABEL',   'default' => 'Phone',                                              'type' => 'text' ],
        '_contact_info_phone'         => [ 'label' => 'PHONE',          'default' => '+91 99900 88888',                                    'type' => 'text' ],
        '_contact_info_email_label'   => [ 'label' => 'EMAIL LABEL',   'default' => 'Email',                                              'type' => 'text' ],
        '_contact_info_email'         => [ 'label' => 'EMAIL',          'default' => 'hello1@travzo.com',                                  'type' => 'text' ],
        '_contact_info_hours_label'   => [ 'label' => 'HOURS LABEL',   'default' => 'Working Hours',                                      'type' => 'text' ],
        '_contact_info_hours'         => [ 'label' => 'WORKING HOURS', 'default' => "Mon \u2013 Sat: 9:00 AM \u2013 7:00 PM",             'type' => 'text' ],
        '_contact_info_follow_label'  => [ 'label' => 'FOLLOW US LABEL', 'default' => 'Follow Us',                                        'type' => 'text' ],
    ];

    wp_nonce_field( 'travzo_contact_info_save', 'travzo_contact_info_nonce' );

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    foreach ( $fields as $key => $f ) {
        $val = get_post_meta( $post->ID, $key, true );
        // Backward compat: for phone/email/address/hours, fall back to global customizer
        if ( '' === $val ) {
            $compat_map = [
                '_contact_info_address' => [ 'travzo_address', $f['default'] ],
                '_contact_info_phone'   => [ 'travzo_phone',   $f['default'] ],
                '_contact_info_email'   => [ 'travzo_email',   $f['default'] ],
                '_contact_info_hours'   => [ 'travzo_hours',   $f['default'] ],
            ];
            if ( isset( $compat_map[ $key ] ) ) {
                $val = travzo_get( $compat_map[ $key ][0], $compat_map[ $key ][1] );
            }
        }
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">' . esc_html( $f['label'] ) . '</label>';
        if ( 'textarea' === $f['type'] ) {
            echo '<textarea name="' . esc_attr( $key ) . '" class="widefat" rows="2" placeholder="' . esc_attr( $f['default'] ) . '">' . esc_textarea( $val ) . '</textarea>';
        } else {
            echo '<input type="text" name="' . esc_attr( $key ) . '" class="widefat" value="' . esc_attr( $val ) . '" placeholder="' . esc_attr( $f['default'] ) . '">';
        }
        echo '</div>';
    }
    echo '</div>';

    $show_follow = get_post_meta( $post->ID, '_contact_info_show_follow', true );
    if ( '' === $show_follow ) $show_follow = '1';
    $checked = ( '1' === $show_follow ) ? ' checked' : '';
    echo '<label><input type="checkbox" name="_contact_info_show_follow" value="1"' . $checked . '> Show "Follow Us" social links section</label>';
    echo '<p style="color:#999;font-size:12px;margin-top:4px">Social media URLs are configured globally in Customizer → Social Media Links.</p>';
}

// ── Contact Page – Message Form Section ─────────────────────────────────────
function travzo_contact_form_section_cb( $post ) {
    $heading = get_post_meta( $post->ID, '_contact_form_heading', true );
    $subtext = get_post_meta( $post->ID, '_contact_form_subtext', true );

    wp_nonce_field( 'travzo_contact_form_section_save', 'travzo_contact_form_section_nonce' );

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HEADING</label>';
    echo '<input type="text" name="_contact_form_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Send Us a Message"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SUBTEXT</label>';
    echo '<input type="text" name="_contact_form_subtext" class="widefat" value="' . esc_attr( $subtext ) . '" placeholder="Fill in the form below and we\'ll get back to you shortly."></div>';
    echo '</div>';
    echo '<p style="color:#999;font-size:12px;margin-top:8px">The contact form is rendered by the theme and submitted via AJAX. Submissions are emailed to the admin and stored under Form Submissions.</p>';
}

// ── Contact Page – Branch Offices Section ───────────────────────────────────
function travzo_contact_branches_cb( $post ) {
    $visible  = get_post_meta( $post->ID, '_contact_branches_visible', true );
    $label    = get_post_meta( $post->ID, '_contact_branches_label', true );
    $heading  = get_post_meta( $post->ID, '_contact_branches_heading', true );
    $subtext  = get_post_meta( $post->ID, '_contact_branches_subtext', true );
    $branches = get_post_meta( $post->ID, '_contact_branches', true );

    if ( '' === $visible ) $visible = '1';

    // Backward compat: parse old pipe-separated _branches
    if ( ! is_array( $branches ) || empty( $branches ) ) {
        $old = get_post_meta( $post->ID, '_branches', true );
        if ( is_string( $old ) && '' !== trim( $old ) ) {
            $parsed = travzo_parse_lines( $old, 3 );
            $branches = [];
            foreach ( $parsed as $row ) {
                $branches[] = [ 'city' => $row[0] ?? '', 'address' => $row[1] ?? '', 'phone' => $row[2] ?? '', 'email' => '', 'map_url' => '' ];
            }
        }
    }
    if ( ! is_array( $branches ) ) $branches = [];

    wp_nonce_field( 'travzo_contact_branches_save', 'travzo_contact_branches_nonce' );

    $checked = ( '1' === $visible ) ? ' checked' : '';
    echo '<div style="margin-bottom:12px"><label><input type="checkbox" name="_contact_branches_visible" value="1"' . $checked . '> Show Branch Offices section</label></div>';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION LABEL</label>';
    echo '<input type="text" name="_contact_branches_label" class="widefat" value="' . esc_attr( $label ) . '" placeholder="OUR PRESENCE"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION HEADING</label>';
    echo '<input type="text" name="_contact_branches_heading" class="widefat" value="' . esc_attr( $heading ) . '" placeholder="Find Us Near You"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">SECTION SUBTEXT</label>';
    echo '<input type="text" name="_contact_branches_subtext" class="widefat" value="' . esc_attr( $subtext ) . '" placeholder="Visit any of our offices..."></div>';
    echo '</div>';

    echo '<hr style="border:none;border-top:2px solid #e0e0e0;margin:0 0 16px">';
    echo '<label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:8px">BRANCHES</label>';
    echo '<input type="hidden" name="_contact_branches_data" id="contact-branches-data" value="' . esc_attr( wp_json_encode( $branches ) ) . '">';
    echo '<div id="contact-branches-list">';
    foreach ( $branches as $idx => $b ) {
        $num = $idx + 1;
        echo '<div class="cbr-row" style="border:1px solid #e0e0e0;border-radius:6px;padding:10px;margin-bottom:8px">';
        echo '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px"><strong style="color:#1A2A5E">Branch #' . $num . '</strong><button type="button" class="button cbr-remove" style="color:#dc2626">✕ Remove</button></div>';
        echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:6px">';
        echo '<input type="text" class="cbr-city widefat" value="' . esc_attr( $b['city'] ?? '' ) . '" placeholder="City Name">';
        echo '<input type="text" class="cbr-phone widefat" value="' . esc_attr( $b['phone'] ?? '' ) . '" placeholder="Phone Number">';
        echo '</div>';
        echo '<textarea class="cbr-address widefat" rows="2" placeholder="Full Address" style="margin-bottom:6px">' . esc_textarea( $b['address'] ?? '' ) . '</textarea>';
        echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">';
        echo '<input type="text" class="cbr-email widefat" value="' . esc_attr( $b['email'] ?? '' ) . '" placeholder="Email (optional)">';
        echo '<input type="url" class="cbr-map widefat" value="' . esc_attr( $b['map_url'] ?? '' ) . '" placeholder="Map/Directions URL (optional)">';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="button" id="contact-branches-add" style="margin-top:4px">+ Add Branch</button>';

    echo '<script>
    jQuery(function($) {
        function syncBranches() {
            var items = [];
            $("#contact-branches-list .cbr-row").each(function() {
                items.push({ city: $(this).find(".cbr-city").val(), address: $(this).find(".cbr-address").val(), phone: $(this).find(".cbr-phone").val(), email: $(this).find(".cbr-email").val(), map_url: $(this).find(".cbr-map").val() });
            });
            $("#contact-branches-data").val(JSON.stringify(items));
            // renumber
            $("#contact-branches-list .cbr-row").each(function(i) { $(this).find("strong").text("Branch #" + (i+1)); });
        }
        $("#contact-branches-list").on("input change", "input, textarea", syncBranches);
        $("#contact-branches-list").on("click", ".cbr-remove", function() { $(this).closest(".cbr-row").remove(); syncBranches(); });
        $("#contact-branches-add").on("click", function() {
            var n = $("#contact-branches-list .cbr-row").length + 1;
            $("#contact-branches-list").append(\'<div class="cbr-row" style="border:1px solid #e0e0e0;border-radius:6px;padding:10px;margin-bottom:8px"><div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px"><strong style="color:#1A2A5E">Branch #\' + n + \'</strong><button type="button" class="button cbr-remove" style="color:#dc2626">✕ Remove</button></div><div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:6px"><input type="text" class="cbr-city widefat" placeholder="City Name"><input type="text" class="cbr-phone widefat" placeholder="Phone Number"></div><textarea class="cbr-address widefat" rows="2" placeholder="Full Address" style="margin-bottom:6px"></textarea><div style="display:grid;grid-template-columns:1fr 1fr;gap:8px"><input type="text" class="cbr-email widefat" placeholder="Email (optional)"><input type="url" class="cbr-map widefat" placeholder="Map/Directions URL (optional)"></div></div>\');
        });
    });
    </script>';
}

function travzo_faq_content_cb( $post ) {
    // ── Categories ──────────────────────────────────────────────────────────
    $cats_raw = get_post_meta( $post->ID, '_faq_categories', true );
    $cats = is_array( $cats_raw ) && ! empty( $cats_raw ) ? $cats_raw : [];

    // ── FAQ items ───────────────────────────────────────────────────────────
    $items_raw = get_post_meta( $post->ID, '_faq_items_v2', true );
    $items = is_array( $items_raw ) && ! empty( $items_raw ) ? $items_raw : [];

    // Backward compat: convert old pipe-separated _faqs → _faq_items_v2
    if ( empty( $items ) ) {
        $old_faqs = get_post_meta( $post->ID, '_faqs', true );
        if ( is_string( $old_faqs ) && '' !== trim( $old_faqs ) ) {
            foreach ( explode( "\n", $old_faqs ) as $line ) {
                $parts = array_map( 'trim', explode( '|', $line ) );
                if ( ! empty( $parts[0] ) ) {
                    $items[] = [
                        'category' => 'General',
                        'question' => $parts[0],
                        'answer'   => $parts[1] ?? '',
                    ];
                }
            }
        }
    }

    // Default categories
    if ( empty( $cats ) ) {
        $cats = [ 'General', 'Booking & Payment', 'Visas & Documents', 'Group Tours', 'Honeymoon', 'Cancellation' ];
    }

    wp_nonce_field( 'travzo_faq_cats_save', 'travzo_faq_categories_nonce' );
    wp_nonce_field( 'travzo_faq_items_save', 'travzo_faq_items_nonce' );
    echo '<input type="hidden" id="travzo-faq-cats-data" name="_faq_categories_v2" value="' . esc_attr( wp_json_encode( $cats ) ) . '">';
    echo '<input type="hidden" id="travzo-faq-items-data" name="_faq_items_v2_data" value="' . esc_attr( wp_json_encode( $items ) ) . '">';

    // ── Section A: Categories ───────────────────────────────────────────────
    echo '<h3 style="margin:0 0 8px;color:#1A2A5E">Categories</h3>';
    echo '<p style="color:#666;margin:0 0 12px;font-size:13px">Define FAQ categories. Changes here update the dropdown in each FAQ item below.</p>';
    echo '<div id="travzo-faq-cats-container">';
    foreach ( $cats as $i => $cat ) {
        $num = $i + 1;
        echo '<div class="travzo-faq-cat-row" style="display:flex;gap:8px;align-items:center;margin-bottom:6px">';
        echo '<strong style="color:#1A2A5E;width:24px;flex-shrink:0">#' . $num . '</strong>';
        echo '<input type="text" class="faq-cat-name widefat" value="' . esc_attr( $cat ) . '" placeholder="Category name" style="flex:1">';
        echo '<button type="button" class="button travzo-remove-faq-cat" style="color:#dc2626;font-size:12px">&#x2715;</button>';
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" id="travzo-add-faq-cat" class="button" style="margin:8px 0 24px">+ Add Category</button>';

    // ── Section B: FAQ Items ────────────────────────────────────────────────
    echo '<hr style="border:none;border-top:2px solid #e0e0e0;margin:0 0 16px">';
    echo '<h3 style="margin:0 0 8px;color:#1A2A5E">FAQ Items</h3>';
    echo '<p style="color:#666;margin:0 0 12px;font-size:13px">Each item has a category, question, and answer.</p>';
    echo '<div id="travzo-faq-items-container">';

    $cats_options = '';
    foreach ( $cats as $c ) {
        $cats_options .= '<option value="' . esc_attr( $c ) . '">' . esc_html( $c ) . '</option>';
    }

    foreach ( $items as $i => $item ) {
        $num = $i + 1;
        $sel_cat = $item['category'] ?? 'General';
        echo '<div class="travzo-faq-item-row" style="padding:16px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;margin-bottom:10px">';
        echo '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong style="color:#1A2A5E">#' . $num . '</strong>';
        echo '<button type="button" class="button travzo-remove-faq-item" style="color:#dc2626;font-size:12px">&#x2715; Remove</button></div>';
        echo '<div style="display:grid;grid-template-columns:200px 1fr;gap:10px;margin-bottom:10px">';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">CATEGORY</label>';
        echo '<select class="faq-item-cat widefat">';
        foreach ( $cats as $c ) {
            $selected = ( $c === $sel_cat ) ? ' selected' : '';
            echo '<option value="' . esc_attr( $c ) . '"' . $selected . '>' . esc_html( $c ) . '</option>';
        }
        echo '</select></div>';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">QUESTION</label>';
        echo '<input type="text" class="faq-item-q widefat" value="' . esc_attr( $item['question'] ?? '' ) . '" placeholder="How do I book a package?"></div>';
        echo '</div>';
        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">ANSWER</label>';
        echo '<textarea class="faq-item-a widefat" rows="3" placeholder="Detailed answer…">' . esc_textarea( $item['answer'] ?? '' ) . '</textarea></div>';
        echo '</div>';
    }

    echo '</div>';
    echo '<button type="button" id="travzo-add-faq-item" class="button button-primary" style="margin-top:12px">+ Add FAQ</button>';

    echo '<script>
    jQuery(function($) {
        // ── Sync functions ──────────────────────────────────────────────────
        function getCats() {
            var cats = [];
            $(".travzo-faq-cat-row .faq-cat-name").each(function() {
                var v = $.trim($(this).val());
                if (v) cats.push(v);
            });
            return cats;
        }
        function syncCats() {
            $("#travzo-faq-cats-data").val(JSON.stringify(getCats()));
            rebuildCatDropdowns();
        }
        function syncItems() {
            var data = [];
            $(".travzo-faq-item-row").each(function() {
                var q = $.trim($(this).find(".faq-item-q").val());
                if (!q) return;
                data.push({
                    category: $(this).find(".faq-item-cat").val() || "General",
                    question: q,
                    answer:   $(this).find(".faq-item-a").val() || ""
                });
            });
            $("#travzo-faq-items-data").val(JSON.stringify(data));
        }
        function rebuildCatDropdowns() {
            var cats = getCats();
            $(".faq-item-cat").each(function() {
                var cur = $(this).val();
                var html = "";
                $.each(cats, function(_, c) {
                    var sel = (c === cur) ? " selected" : "";
                    html += \'<option value="\' + c + \'"\' + sel + \'>\' + c + \'</option>\';
                });
                $(this).html(html);
            });
        }
        function renumberCats() {
            $(".travzo-faq-cat-row").each(function(i) {
                $(this).find("strong").first().text("#" + (i + 1));
            });
        }
        function renumberItems() {
            $(".travzo-faq-item-row").each(function(i) {
                $(this).find("strong").first().text("#" + (i + 1));
            });
        }

        // ── Category events ─────────────────────────────────────────────────
        $(document).on("click", ".travzo-remove-faq-cat", function() {
            $(this).closest(".travzo-faq-cat-row").remove();
            renumberCats(); syncCats(); syncItems();
        });
        $("#travzo-add-faq-cat").on("click", function() {
            var n = $(".travzo-faq-cat-row").length + 1;
            $("#travzo-faq-cats-container").append(
                \'<div class="travzo-faq-cat-row" style="display:flex;gap:8px;align-items:center;margin-bottom:6px">\'
                + \'<strong style="color:#1A2A5E;width:24px;flex-shrink:0">#\' + n + \'</strong>\'
                + \'<input type="text" class="faq-cat-name widefat" value="" placeholder="Category name" style="flex:1">\'
                + \'<button type="button" class="button travzo-remove-faq-cat" style="color:#dc2626;font-size:12px">&#x2715;</button>\'
                + \'</div>\'
            );
            syncCats();
        });
        $(document).on("input change", ".faq-cat-name", function() { syncCats(); });

        // ── Item events ─────────────────────────────────────────────────────
        $(document).on("click", ".travzo-remove-faq-item", function() {
            $(this).closest(".travzo-faq-item-row").remove();
            renumberItems(); syncItems();
        });
        $("#travzo-add-faq-item").on("click", function() {
            var cats = getCats();
            var opts = "";
            $.each(cats, function(_, c) {
                opts += \'<option value="\' + c + \'">\' + c + \'</option>\';
            });
            var n = $(".travzo-faq-item-row").length + 1;
            $("#travzo-faq-items-container").append(
                \'<div class="travzo-faq-item-row" style="padding:16px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;margin-bottom:10px">\'
                + \'<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px"><strong style="color:#1A2A5E">#\' + n + \'</strong>\'
                + \'<button type="button" class="button travzo-remove-faq-item" style="color:#dc2626;font-size:12px">&#x2715; Remove</button></div>\'
                + \'<div style="display:grid;grid-template-columns:200px 1fr;gap:10px;margin-bottom:10px">\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">CATEGORY</label>\'
                + \'<select class="faq-item-cat widefat">\' + opts + \'</select></div>\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">QUESTION</label>\'
                + \'<input type="text" class="faq-item-q widefat" value="" placeholder="How do I book a package?"></div>\'
                + \'</div>\'
                + \'<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">ANSWER</label>\'
                + \'<textarea class="faq-item-a widefat" rows="3" placeholder="Detailed answer…"></textarea></div>\'
                + \'</div>\'
            );
            syncItems();
        });
        $(document).on("input change", ".faq-item-cat, .faq-item-q, .faq-item-a", syncItems);
    });
    </script>';
}

function travzo_media_content_cb( $post ) {
    $videos_val = get_post_meta( $post->ID, '_media_videos', true );
    $press_val  = get_post_meta( $post->ID, '_media_press',  true );
    $awards_val = get_post_meta( $post->ID, '_media_awards', true );

    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Videos</label>';
    echo '<small style="color:#666;display:block;margin-bottom:8px">One per line. Format: <strong>Title | YouTube URL | Thumbnail URL (optional)</strong></small>';
    echo '<textarea name="_media_videos" rows="6" style="width:100%">' . esc_textarea( $videos_val ) . '</textarea></p>';

    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Press Coverage</label>';
    echo '<small style="color:#666;display:block;margin-bottom:8px">One per line. Format: <strong>Publication | Headline | Date | Article URL</strong></small>';
    echo '<textarea name="_media_press" rows="6" style="width:100%">' . esc_textarea( $press_val ) . '</textarea></p>';

    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Awards</label>';
    echo '<small style="color:#666;display:block;margin-bottom:8px">One per line. Format: <strong>Award Title | Year | Awarding Body | Image URL</strong></small>';
    echo '<textarea name="_media_awards" rows="6" style="width:100%">' . esc_textarea( $awards_val ) . '</textarea></p>';
}

// ── Page Hero meta box callback ──────────────────────────────────────────────
function travzo_page_hero_cb( $post ) {
    $hero_title = get_post_meta( $post->ID, '_page_hero_title', true );
    $hero_sub   = get_post_meta( $post->ID, '_page_hero_subtitle', true );
    $hero_image = get_post_meta( $post->ID, '_page_hero_image', true );

    wp_nonce_field( 'travzo_page_hero_save', 'travzo_page_hero_nonce' );

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HERO TITLE</label>';
    echo '<input type="text" name="_page_hero_title" class="widefat" value="' . esc_attr( $hero_title ) . '" placeholder="Leave empty to use page title"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HERO SUBTITLE / DESCRIPTION</label>';
    echo '<textarea name="_page_hero_subtitle" class="widefat" rows="2" placeholder="Brief description shown below the title">' . esc_textarea( $hero_sub ) . '</textarea></div>';
    echo '</div>';

    echo '<div style="margin-bottom:8px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HERO BACKGROUND IMAGE</label>';
    echo '<div style="display:flex;gap:8px;align-items:flex-start">';
    echo '<input type="url" name="_page_hero_image" id="page-hero-image-input" class="widefat" value="' . esc_attr( $hero_image ) . '" placeholder="https://... background image URL" style="flex:1">';
    echo '<button type="button" class="button" id="page-hero-upload-btn">Choose Image</button>';
    echo '<button type="button" class="button" id="page-hero-remove-btn" style="color:#dc2626">Remove</button>';
    echo '</div>';
    if ( $hero_image ) {
        echo '<div id="page-hero-preview" style="margin-top:8px"><img src="' . esc_url( $hero_image ) . '" style="max-width:300px;max-height:150px;border-radius:8px;border:1px solid #e0e0e0"></div>';
    } else {
        echo '<div id="page-hero-preview" style="margin-top:8px"></div>';
    }
    echo '</div>';

    echo '<script>
    jQuery(function($) {
        $("#page-hero-upload-btn").on("click", function() {
            var frame = wp.media({ title: "Select Hero Image", button: { text: "Use Image" }, multiple: false });
            frame.on("select", function() {
                var url = frame.state().get("selection").first().toJSON().url;
                $("#page-hero-image-input").val(url);
                $("#page-hero-preview").html(\'<img src="\' + url + \'" style="max-width:300px;max-height:150px;border-radius:8px;border:1px solid #e0e0e0">\');
            });
            frame.open();
        });
        $("#page-hero-remove-btn").on("click", function() {
            $("#page-hero-image-input").val("");
            $("#page-hero-preview").html("");
        });
    });
    </script>';
}

function travzo_legal_content_cb( $post ) {
    $hero_title = get_post_meta( $post->ID, '_legal_hero_title', true );
    $hero_sub   = get_post_meta( $post->ID, '_legal_hero_subtitle', true );
    $hero_image = get_post_meta( $post->ID, '_legal_hero_image', true );
    $show_date  = get_post_meta( $post->ID, '_legal_show_date', true );
    $content    = get_post_meta( $post->ID, '_legal_content', true );

    // Default show_date to checked for new pages
    if ( '' === $show_date ) $show_date = '1';

    wp_nonce_field( 'travzo_legal_save', 'travzo_legal_nonce' );

    // ── Hero Section ────────────────────────────────────────────────────────
    echo '<h3 style="margin:0 0 12px;color:#1A2A5E">Hero Section</h3>';

    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HERO TITLE</label>';
    echo '<input type="text" name="_legal_hero_title" class="widefat" value="' . esc_attr( $hero_title ) . '" placeholder="Leave empty to use page title"></div>';
    echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HERO SUBTITLE / DESCRIPTION</label>';
    echo '<textarea name="_legal_hero_subtitle" class="widefat" rows="2" placeholder="Brief description shown below the title">' . esc_textarea( $hero_sub ) . '</textarea></div>';
    echo '</div>';

    echo '<div style="margin-bottom:16px"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">HERO BACKGROUND IMAGE</label>';
    echo '<div style="display:flex;gap:8px;align-items:flex-start">';
    echo '<input type="url" name="_legal_hero_image" id="legal-hero-image-input" class="widefat" value="' . esc_attr( $hero_image ) . '" placeholder="https://... background image URL" style="flex:1">';
    echo '<button type="button" class="button" id="legal-hero-upload-btn">Choose Image</button>';
    echo '<button type="button" class="button" id="legal-hero-remove-btn" style="color:#dc2626">Remove</button>';
    echo '</div>';
    if ( $hero_image ) {
        echo '<div id="legal-hero-preview" style="margin-top:8px"><img src="' . esc_url( $hero_image ) . '" style="max-width:300px;max-height:150px;border-radius:8px;border:1px solid #e0e0e0"></div>';
    } else {
        echo '<div id="legal-hero-preview" style="margin-top:8px"></div>';
    }
    echo '</div>';

    $checked = ( '1' === $show_date ) ? ' checked' : '';
    echo '<div style="margin-bottom:20px"><label><input type="checkbox" name="_legal_show_date" value="1"' . $checked . '> Show "Last updated" date in the hero</label></div>';

    // ── Main Content ────────────────────────────────────────────────────────
    echo '<hr style="border:none;border-top:2px solid #e0e0e0;margin:0 0 16px">';
    echo '<h3 style="margin:0 0 12px;color:#1A2A5E">Page Content</h3>';
    echo '<textarea name="_legal_content" class="widefat" rows="20" style="font-family:monospace;font-size:13px">' . esc_textarea( $content ) . '</textarea>';
    echo '<p style="color:#999;font-size:12px;margin-top:6px">Use HTML for formatting. Headings: <code>&lt;h2&gt;</code>, <code>&lt;h3&gt;</code>. Lists: <code>&lt;ul&gt;&lt;li&gt;</code>. Bold: <code>&lt;strong&gt;</code>. Links: <code>&lt;a href=&quot;&quot;&gt;</code>. Paragraphs: <code>&lt;p&gt;</code></p>';

    echo '<script>
    jQuery(function($) {
        $("#legal-hero-upload-btn").on("click", function() {
            var frame = wp.media({ title: "Select Hero Image", button: { text: "Use Image" }, multiple: false });
            frame.on("select", function() {
                var url = frame.state().get("selection").first().toJSON().url;
                $("#legal-hero-image-input").val(url);
                $("#legal-hero-preview").html(\'<img src="\' + url + \'" style="max-width:300px;max-height:150px;border-radius:8px;border:1px solid #e0e0e0">\');
            });
            frame.open();
        });
        $("#legal-hero-remove-btn").on("click", function() {
            $("#legal-hero-image-input").val("");
            $("#legal-hero-preview").html("");
        });
    });
    </script>';
}

add_action( 'save_post_page', function ( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // Save generic page fields (About, Contact, FAQ, Media) — guarded by their own nonce
    if ( isset( $_POST['travzo_page_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_page_nonce'] ) ), 'travzo_page_save' ) ) {
        $page_fields = [
            '_media_videos', '_media_press', '_media_awards',
        ];
        foreach ( $page_fields as $field ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
            }
        }
    }

    // Save package tiles repeater (_package_tiles_v2)
    if ( isset( $_POST['travzo_tiles_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_tiles_nonce'] ) ), 'travzo_tiles_save' ) ) {

        $names        = isset( $_POST['tiles_name'] )        ? (array) $_POST['tiles_name']        : [];
        $types        = isset( $_POST['tiles_type'] )        ? (array) $_POST['tiles_type']        : [];
        $regions      = isset( $_POST['tiles_region'] )      ? (array) $_POST['tiles_region']      : [];
        $countries    = isset( $_POST['tiles_country'] )     ? (array) $_POST['tiles_country']     : [];
        $subregions   = isset( $_POST['tiles_subregion'] )   ? (array) $_POST['tiles_subregion']   : [];
        $destinations = isset( $_POST['tiles_destination'] ) ? (array) $_POST['tiles_destination'] : [];
        $durations    = isset( $_POST['tiles_duration'] )    ? (array) $_POST['tiles_duration']    : [];
        $budgets      = isset( $_POST['tiles_budget'] )      ? (array) $_POST['tiles_budget']      : [];
        $urls         = isset( $_POST['tiles_url'] )         ? (array) $_POST['tiles_url']         : [];
        $images       = isset( $_POST['tiles_image'] )       ? (array) $_POST['tiles_image']       : [];

        $tiles_v2 = [];
        foreach ( $names as $i => $name ) {
            $name = sanitize_text_field( wp_unslash( $name ) );
            if ( '' === trim( $name ) ) {
                continue;
            }
            $tiles_v2[] = [
                'name'        => $name,
                'type'        => sanitize_text_field( wp_unslash( $types[ $i ] ?? '' ) ),
                'region'      => sanitize_text_field( wp_unslash( $regions[ $i ] ?? '' ) ),
                'country'     => sanitize_text_field( wp_unslash( $countries[ $i ] ?? '' ) ),
                'subregion'   => sanitize_text_field( wp_unslash( $subregions[ $i ] ?? '' ) ),
                'destination' => sanitize_text_field( wp_unslash( $destinations[ $i ] ?? '' ) ),
                'duration'    => sanitize_text_field( wp_unslash( $durations[ $i ] ?? '' ) ),
                'budget'      => sanitize_text_field( wp_unslash( $budgets[ $i ] ?? '' ) ),
                'url'         => esc_url_raw( wp_unslash( $urls[ $i ] ?? '' ) ),
                'image'       => absint( $images[ $i ] ?? 0 ),
            ];
        }
        update_post_meta( $post_id, '_package_tiles_v2', $tiles_v2 );

        // Flush tile count transients when tiles are saved
        global $wpdb;
        $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_travzo_tile_cnt_%' OR option_name LIKE '_transient_timeout_travzo_tile_cnt_%'" );

        // Section label & heading (same nonce)
        if ( isset( $_POST['_homepage_packages_label'] ) ) {
            update_post_meta( $post_id, '_homepage_packages_label', sanitize_text_field( wp_unslash( $_POST['_homepage_packages_label'] ) ) );
        }
        if ( isset( $_POST['_homepage_packages_heading'] ) ) {
            update_post_meta( $post_id, '_homepage_packages_heading', sanitize_text_field( wp_unslash( $_POST['_homepage_packages_heading'] ) ) );
        }
    }

    // Save testimonials repeater (_testimonials as serialized array)
    if ( isset( $_POST['travzo_testimonials_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_testimonials_nonce'] ) ), 'travzo_testimonials_save' ) ) {
        $json_raw = isset( $_POST['_testimonials_v2'] ) ? wp_unslash( $_POST['_testimonials_v2'] ) : '[]';
        $decoded  = json_decode( $json_raw, true );
        $clean    = [];
        if ( is_array( $decoded ) ) {
            foreach ( $decoded as $item ) {
                $name = sanitize_text_field( $item['name'] ?? '' );
                if ( '' === trim( $name ) ) {
                    continue;
                }
                $clean[] = [
                    'name'   => $name,
                    'trip'   => sanitize_text_field( $item['trip'] ?? '' ),
                    'quote'  => sanitize_textarea_field( $item['quote'] ?? '' ),
                    'rating' => max( 1, min( 5, intval( $item['rating'] ?? 5 ) ) ),
                ];
            }
        }
        update_post_meta( $post_id, '_testimonials', $clean );
    }

    // Save Why Choose Us repeater (_homepage_whyus as serialized array)
    if ( isset( $_POST['travzo_whyus_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_whyus_nonce'] ) ), 'travzo_whyus_save' ) ) {
        $json_raw = isset( $_POST['_homepage_whyus_v2'] ) ? wp_unslash( $_POST['_homepage_whyus_v2'] ) : '{}';
        $decoded  = json_decode( $json_raw, true );
        $clean_wu = [
            'label'   => sanitize_text_field( $decoded['label'] ?? '' ),
            'heading' => sanitize_text_field( $decoded['heading'] ?? '' ),
            'tiles'   => [],
        ];
        if ( ! empty( $decoded['tiles'] ) && is_array( $decoded['tiles'] ) ) {
            foreach ( $decoded['tiles'] as $tile ) {
                $title = sanitize_text_field( $tile['title'] ?? '' );
                if ( '' === trim( $title ) ) {
                    continue;
                }
                $clean_wu['tiles'][] = [
                    'icon'  => sanitize_text_field( $tile['icon'] ?? '' ),
                    'title' => $title,
                    'desc'  => sanitize_textarea_field( $tile['desc'] ?? '' ),
                ];
            }
        }
        update_post_meta( $post_id, '_homepage_whyus', $clean_wu );
    }

    // Save Stats Bar repeater (_homepage_stats as serialized array)
    if ( isset( $_POST['travzo_stats_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_stats_nonce'] ) ), 'travzo_stats_save' ) ) {
        $json_raw = isset( $_POST['_homepage_stats_v2'] ) ? wp_unslash( $_POST['_homepage_stats_v2'] ) : '[]';
        $decoded  = json_decode( $json_raw, true );
        $clean_stats = [];
        if ( is_array( $decoded ) ) {
            foreach ( $decoded as $item ) {
                $number = sanitize_text_field( $item['number'] ?? '' );
                if ( '' === trim( $number ) ) {
                    continue;
                }
                $clean_stats[] = [
                    'number'   => $number,
                    'label'    => sanitize_text_field( $item['label'] ?? '' ),
                    'sublabel' => sanitize_text_field( $item['sublabel'] ?? '' ),
                ];
            }
        }
        update_post_meta( $post_id, '_homepage_stats', $clean_stats );
    }

    // Save Homepage About Us fields
    if ( isset( $_POST['travzo_about_home_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_about_home_nonce'] ) ), 'travzo_about_home_save' ) ) {
        $about_fields = [
            '_homepage_about_label'       => 'sanitize_text_field',
            '_homepage_about_heading'     => 'sanitize_text_field',
            '_homepage_about_description' => 'sanitize_textarea_field',
            '_homepage_about_keypoints'   => 'sanitize_textarea_field',
            '_homepage_about_btn_text'    => 'sanitize_text_field',
            '_homepage_about_btn_url'     => 'esc_url_raw',
        ];
        foreach ( $about_fields as $key => $sanitizer ) {
            if ( isset( $_POST[ $key ] ) ) {
                update_post_meta( $post_id, $key, $sanitizer( wp_unslash( $_POST[ $key ] ) ) );
            }
        }
        // Image URL
        $img = isset( $_POST['_homepage_about_image'] ) ? esc_url_raw( wp_unslash( $_POST['_homepage_about_image'] ) ) : '';
        update_post_meta( $post_id, '_homepage_about_image', $img );
    }

    // Save Hero Section fields
    if ( isset( $_POST['travzo_hero_home_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_hero_home_nonce'] ) ), 'travzo_hero_home_save' ) ) {
        $hero_text_fields = [
            '_homepage_hero_badge'     => 'sanitize_text_field',
            '_homepage_hero_heading'   => 'sanitize_textarea_field',
            '_homepage_hero_subtext'   => 'sanitize_text_field',
            '_homepage_hero_btn1_text' => 'sanitize_text_field',
            '_homepage_hero_btn1_url'  => 'esc_url_raw',
            '_homepage_hero_btn2_text' => 'sanitize_text_field',
            '_homepage_hero_btn2_url'  => 'esc_url_raw',
        ];
        foreach ( $hero_text_fields as $key => $sanitizer ) {
            if ( isset( $_POST[ $key ] ) ) {
                update_post_meta( $post_id, $key, $sanitizer( wp_unslash( $_POST[ $key ] ) ) );
            }
        }
        $hero_img = isset( $_POST['_homepage_hero_image'] ) ? esc_url_raw( wp_unslash( $_POST['_homepage_hero_image'] ) ) : '';
        update_post_meta( $post_id, '_homepage_hero_image', $hero_img );

        // Hero mode
        $mode = isset( $_POST['_homepage_hero_mode'] ) ? sanitize_text_field( wp_unslash( $_POST['_homepage_hero_mode'] ) ) : 'single';
        if ( ! in_array( $mode, [ 'single', 'slideshow' ], true ) ) $mode = 'single';
        update_post_meta( $post_id, '_homepage_hero_mode', $mode );

        // Slideshow images (JSON array of attachment IDs)
        $slides_raw = isset( $_POST['_homepage_hero_slides'] ) ? wp_unslash( $_POST['_homepage_hero_slides'] ) : '[]';
        $slides     = json_decode( $slides_raw, true );
        if ( ! is_array( $slides ) ) {
            $slides = array_filter( array_map( 'absint', explode( ',', $slides_raw ) ) );
        } else {
            $slides = array_filter( array_map( 'absint', $slides ) );
        }
        update_post_meta( $post_id, '_homepage_hero_slides', $slides );

        // Slideshow interval
        $interval = isset( $_POST['_homepage_hero_interval'] ) ? absint( $_POST['_homepage_hero_interval'] ) : 5;
        if ( $interval < 2 )  $interval = 2;
        if ( $interval > 30 ) $interval = 30;
        update_post_meta( $post_id, '_homepage_hero_interval', $interval );

        // Search bar
        update_post_meta( $post_id, '_homepage_hero_search_enabled', isset( $_POST['_homepage_hero_search_enabled'] ) ? '1' : '0' );
        if ( isset( $_POST['_homepage_hero_search_placeholder'] ) ) {
            update_post_meta( $post_id, '_homepage_hero_search_placeholder', sanitize_text_field( wp_unslash( $_POST['_homepage_hero_search_placeholder'] ) ) );
        }
        $filters = isset( $_POST['_homepage_hero_filters_enabled'] ) ? array_map( 'sanitize_text_field', (array) $_POST['_homepage_hero_filters_enabled'] ) : [];
        update_post_meta( $post_id, '_homepage_hero_filters_enabled', $filters );
    }

    // Save Homepage Contact Section text fields
    if ( isset( $_POST['travzo_contact_home_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_contact_home_nonce'] ) ), 'travzo_contact_home_save' ) ) {
        $contact_fields = [
            '_homepage_contact_label'       => 'sanitize_text_field',
            '_homepage_contact_heading'     => 'sanitize_text_field',
            '_homepage_contact_description' => 'sanitize_textarea_field',
            '_homepage_contact_hours'       => 'sanitize_text_field',
        ];
        foreach ( $contact_fields as $key => $sanitizer ) {
            if ( isset( $_POST[ $key ] ) ) {
                update_post_meta( $post_id, $key, $sanitizer( wp_unslash( $_POST[ $key ] ) ) );
            }
        }
    }

    // Save FAQ Categories
    if ( isset( $_POST['travzo_faq_categories_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_faq_categories_nonce'] ) ), 'travzo_faq_cats_save' ) ) {
        $json_raw = isset( $_POST['_faq_categories_v2'] ) ? wp_unslash( $_POST['_faq_categories_v2'] ) : '[]';
        $decoded  = json_decode( $json_raw, true );
        $clean_cats = [];
        if ( is_array( $decoded ) ) {
            foreach ( $decoded as $cat ) {
                $cat = sanitize_text_field( $cat );
                if ( '' !== trim( $cat ) ) {
                    $clean_cats[] = $cat;
                }
            }
        }
        update_post_meta( $post_id, '_faq_categories', $clean_cats );
    }

    // Save FAQ Items
    if ( isset( $_POST['travzo_faq_items_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_faq_items_nonce'] ) ), 'travzo_faq_items_save' ) ) {
        $json_raw = isset( $_POST['_faq_items_v2_data'] ) ? wp_unslash( $_POST['_faq_items_v2_data'] ) : '[]';
        $decoded  = json_decode( $json_raw, true );
        $clean_items = [];
        if ( is_array( $decoded ) ) {
            foreach ( $decoded as $item ) {
                $question = sanitize_text_field( $item['question'] ?? '' );
                if ( '' === trim( $question ) ) {
                    continue;
                }
                $clean_items[] = [
                    'category' => sanitize_text_field( $item['category'] ?? 'General' ),
                    'question' => $question,
                    'answer'   => sanitize_textarea_field( $item['answer'] ?? '' ),
                ];
            }
        }
        update_post_meta( $post_id, '_faq_items_v2', $clean_items );
    }

    // Save Newsletter Section fields
    if ( isset( $_POST['travzo_newsletter_section_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_newsletter_section_nonce'] ) ), 'travzo_newsletter_section_save' ) ) {
        if ( isset( $_POST['_homepage_newsletter_heading'] ) ) {
            update_post_meta( $post_id, '_homepage_newsletter_heading', sanitize_text_field( wp_unslash( $_POST['_homepage_newsletter_heading'] ) ) );
        }
        if ( isset( $_POST['_homepage_newsletter_subtext'] ) ) {
            update_post_meta( $post_id, '_homepage_newsletter_subtext', sanitize_text_field( wp_unslash( $_POST['_homepage_newsletter_subtext'] ) ) );
        }
    }

    // Save Legal Page Content fields
    if ( isset( $_POST['travzo_legal_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_legal_nonce'] ) ), 'travzo_legal_save' ) ) {
        if ( isset( $_POST['_legal_hero_title'] ) ) {
            update_post_meta( $post_id, '_legal_hero_title', sanitize_text_field( wp_unslash( $_POST['_legal_hero_title'] ) ) );
        }
        if ( isset( $_POST['_legal_hero_subtitle'] ) ) {
            update_post_meta( $post_id, '_legal_hero_subtitle', sanitize_text_field( wp_unslash( $_POST['_legal_hero_subtitle'] ) ) );
        }
        $legal_img = isset( $_POST['_legal_hero_image'] ) ? esc_url_raw( wp_unslash( $_POST['_legal_hero_image'] ) ) : '';
        update_post_meta( $post_id, '_legal_hero_image', $legal_img );
        update_post_meta( $post_id, '_legal_show_date', isset( $_POST['_legal_show_date'] ) ? '1' : '0' );
        if ( isset( $_POST['_legal_content'] ) ) {
            update_post_meta( $post_id, '_legal_content', wp_kses_post( wp_unslash( $_POST['_legal_content'] ) ) );
        }
    }

    // Save Page Hero fields
    if ( isset( $_POST['travzo_page_hero_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_page_hero_nonce'] ) ), 'travzo_page_hero_save' ) ) {
        if ( isset( $_POST['_page_hero_title'] ) ) {
            update_post_meta( $post_id, '_page_hero_title', sanitize_text_field( wp_unslash( $_POST['_page_hero_title'] ) ) );
        }
        if ( isset( $_POST['_page_hero_subtitle'] ) ) {
            update_post_meta( $post_id, '_page_hero_subtitle', sanitize_text_field( wp_unslash( $_POST['_page_hero_subtitle'] ) ) );
        }
        $page_hero_img = isset( $_POST['_page_hero_image'] ) ? esc_url_raw( wp_unslash( $_POST['_page_hero_image'] ) ) : '';
        update_post_meta( $post_id, '_page_hero_image', $page_hero_img );
    }

    // Save About – Our Story Section
    if ( isset( $_POST['travzo_about_story_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_about_story_nonce'] ) ), 'travzo_about_story_save' ) ) {
        $story_text_fields = [
            '_about_story_label'     => 'sanitize_text_field',
            '_about_story_heading'   => 'sanitize_text_field',
            '_about_story_text'      => 'sanitize_textarea_field',
            '_about_story_keypoints' => 'sanitize_textarea_field',
            '_about_story_btn_text'  => 'sanitize_text_field',
            '_about_story_btn_url'   => 'sanitize_text_field',
        ];
        foreach ( $story_text_fields as $key => $sanitizer ) {
            if ( isset( $_POST[ $key ] ) ) {
                update_post_meta( $post_id, $key, $sanitizer( wp_unslash( $_POST[ $key ] ) ) );
            }
        }
        $story_img = isset( $_POST['_about_story_image'] ) ? esc_url_raw( wp_unslash( $_POST['_about_story_image'] ) ) : '';
        update_post_meta( $post_id, '_about_story_image', $story_img );
    }

    // Save About – Stats Bar
    if ( isset( $_POST['travzo_about_stats_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_about_stats_nonce'] ) ), 'travzo_about_stats_save' ) ) {
        update_post_meta( $post_id, '_about_stats_visible', isset( $_POST['_about_stats_visible'] ) ? '1' : '0' );
        $as_raw = isset( $_POST['_about_stats_data'] ) ? wp_unslash( $_POST['_about_stats_data'] ) : '[]';
        $as_decoded = json_decode( $as_raw, true );
        $as_clean = [];
        if ( is_array( $as_decoded ) ) {
            foreach ( $as_decoded as $s ) {
                $num = sanitize_text_field( $s['number'] ?? '' );
                if ( '' !== trim( $num ) ) {
                    $as_clean[] = [ 'number' => $num, 'label' => sanitize_text_field( $s['label'] ?? '' ), 'sublabel' => sanitize_text_field( $s['sublabel'] ?? '' ) ];
                }
            }
        }
        update_post_meta( $post_id, '_about_stats', $as_clean );
    }

    // Save About – Why Travel With Us
    if ( isset( $_POST['travzo_about_whyus_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_about_whyus_nonce'] ) ), 'travzo_about_whyus_save' ) ) {
        if ( isset( $_POST['_about_whyus_label'] ) ) {
            update_post_meta( $post_id, '_about_whyus_label', sanitize_text_field( wp_unslash( $_POST['_about_whyus_label'] ) ) );
        }
        if ( isset( $_POST['_about_whyus_heading'] ) ) {
            update_post_meta( $post_id, '_about_whyus_heading', sanitize_text_field( wp_unslash( $_POST['_about_whyus_heading'] ) ) );
        }
        $wt_raw = isset( $_POST['_about_whyus_tiles_data'] ) ? wp_unslash( $_POST['_about_whyus_tiles_data'] ) : '[]';
        $wt_decoded = json_decode( $wt_raw, true );
        $wt_clean = [];
        if ( is_array( $wt_decoded ) ) {
            foreach ( $wt_decoded as $tile ) {
                $title = sanitize_text_field( $tile['title'] ?? '' );
                if ( '' !== trim( $title ) ) {
                    $wt_clean[] = [ 'icon' => sanitize_text_field( $tile['icon'] ?? '' ), 'title' => $title, 'desc' => sanitize_textarea_field( $tile['desc'] ?? '' ) ];
                }
            }
        }
        update_post_meta( $post_id, '_about_whyus_tiles', $wt_clean );
    }

    // Save About – Accreditation Partners
    if ( isset( $_POST['travzo_about_accreditation_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_about_accreditation_nonce'] ) ), 'travzo_about_accreditation_save' ) ) {
        update_post_meta( $post_id, '_about_accreditation_visible', isset( $_POST['_about_accreditation_visible'] ) ? '1' : '0' );
        if ( isset( $_POST['_about_accreditation_label'] ) ) {
            update_post_meta( $post_id, '_about_accreditation_label', sanitize_text_field( wp_unslash( $_POST['_about_accreditation_label'] ) ) );
        }
        if ( isset( $_POST['_about_accreditation_heading'] ) ) {
            update_post_meta( $post_id, '_about_accreditation_heading', sanitize_text_field( wp_unslash( $_POST['_about_accreditation_heading'] ) ) );
        }
        $ap_raw = isset( $_POST['_about_accreditation_partners_data'] ) ? wp_unslash( $_POST['_about_accreditation_partners_data'] ) : '[]';
        $ap_decoded = json_decode( $ap_raw, true );
        $ap_clean = [];
        if ( is_array( $ap_decoded ) ) {
            foreach ( $ap_decoded as $p ) {
                $name = sanitize_text_field( $p['name'] ?? '' );
                if ( '' !== trim( $name ) ) {
                    $ap_clean[] = [ 'name' => $name, 'logo' => esc_url_raw( $p['logo'] ?? '' ), 'url' => esc_url_raw( $p['url'] ?? '' ) ];
                }
            }
        }
        update_post_meta( $post_id, '_about_accreditation_partners', $ap_clean );
    }

    // Save About – Testimonials
    if ( isset( $_POST['travzo_about_testimonials_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_about_testimonials_nonce'] ) ), 'travzo_about_testimonials_save' ) ) {
        if ( isset( $_POST['_about_testimonials_label'] ) ) {
            update_post_meta( $post_id, '_about_testimonials_label', sanitize_text_field( wp_unslash( $_POST['_about_testimonials_label'] ) ) );
        }
        if ( isset( $_POST['_about_testimonials_heading'] ) ) {
            update_post_meta( $post_id, '_about_testimonials_heading', sanitize_text_field( wp_unslash( $_POST['_about_testimonials_heading'] ) ) );
        }
        $at_raw = isset( $_POST['_about_testimonials_data'] ) ? wp_unslash( $_POST['_about_testimonials_data'] ) : '[]';
        $at_decoded = json_decode( $at_raw, true );
        $at_clean = [];
        if ( is_array( $at_decoded ) ) {
            foreach ( $at_decoded as $t ) {
                $name = sanitize_text_field( $t['name'] ?? '' );
                if ( '' !== trim( $name ) ) {
                    $at_clean[] = [
                        'name'   => $name,
                        'trip'   => sanitize_text_field( $t['trip'] ?? '' ),
                        'quote'  => sanitize_textarea_field( $t['quote'] ?? '' ),
                        'rating' => max( 1, min( 5, intval( $t['rating'] ?? 5 ) ) ),
                    ];
                }
            }
        }
        update_post_meta( $post_id, '_about_testimonials', $at_clean );
    }

    // Save About – CTA Section
    if ( isset( $_POST['travzo_about_cta_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_about_cta_nonce'] ) ), 'travzo_about_cta_save' ) ) {
        update_post_meta( $post_id, '_about_cta_visible', isset( $_POST['_about_cta_visible'] ) ? '1' : '0' );
        $cta_fields = [
            '_about_cta_heading'     => 'sanitize_text_field',
            '_about_cta_description' => 'sanitize_textarea_field',
            '_about_cta_btn1_text'   => 'sanitize_text_field',
            '_about_cta_btn1_url'    => 'esc_url_raw',
            '_about_cta_btn2_text'   => 'sanitize_text_field',
            '_about_cta_btn2_url'    => 'esc_url_raw',
        ];
        foreach ( $cta_fields as $key => $sanitizer ) {
            if ( isset( $_POST[ $key ] ) ) {
                update_post_meta( $post_id, $key, $sanitizer( wp_unslash( $_POST[ $key ] ) ) );
            }
        }
    }

    // Save Contact – Contact Information Card
    if ( isset( $_POST['travzo_contact_info_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_contact_info_nonce'] ) ), 'travzo_contact_info_save' ) ) {
        $ci_fields = [
            '_contact_info_heading', '_contact_info_subtext',
            '_contact_info_address_label', '_contact_info_phone_label',
            '_contact_info_email_label', '_contact_info_hours_label',
            '_contact_info_phone', '_contact_info_email',
            '_contact_info_hours', '_contact_info_follow_label',
        ];
        foreach ( $ci_fields as $key ) {
            if ( isset( $_POST[ $key ] ) ) {
                update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
            }
        }
        if ( isset( $_POST['_contact_info_address'] ) ) {
            update_post_meta( $post_id, '_contact_info_address', sanitize_textarea_field( wp_unslash( $_POST['_contact_info_address'] ) ) );
        }
        update_post_meta( $post_id, '_contact_info_show_follow', isset( $_POST['_contact_info_show_follow'] ) ? '1' : '0' );
    }

    // Save Contact – Message Form Section
    if ( isset( $_POST['travzo_contact_form_section_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_contact_form_section_nonce'] ) ), 'travzo_contact_form_section_save' ) ) {
        if ( isset( $_POST['_contact_form_heading'] ) ) {
            update_post_meta( $post_id, '_contact_form_heading', sanitize_text_field( wp_unslash( $_POST['_contact_form_heading'] ) ) );
        }
        if ( isset( $_POST['_contact_form_subtext'] ) ) {
            update_post_meta( $post_id, '_contact_form_subtext', sanitize_text_field( wp_unslash( $_POST['_contact_form_subtext'] ) ) );
        }
    }

    // Save Contact – Branch Offices Section
    if ( isset( $_POST['travzo_contact_branches_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_contact_branches_nonce'] ) ), 'travzo_contact_branches_save' ) ) {
        update_post_meta( $post_id, '_contact_branches_visible', isset( $_POST['_contact_branches_visible'] ) ? '1' : '0' );
        if ( isset( $_POST['_contact_branches_label'] ) ) {
            update_post_meta( $post_id, '_contact_branches_label', sanitize_text_field( wp_unslash( $_POST['_contact_branches_label'] ) ) );
        }
        if ( isset( $_POST['_contact_branches_heading'] ) ) {
            update_post_meta( $post_id, '_contact_branches_heading', sanitize_text_field( wp_unslash( $_POST['_contact_branches_heading'] ) ) );
        }
        if ( isset( $_POST['_contact_branches_subtext'] ) ) {
            update_post_meta( $post_id, '_contact_branches_subtext', sanitize_text_field( wp_unslash( $_POST['_contact_branches_subtext'] ) ) );
        }
        $br_raw = isset( $_POST['_contact_branches_data'] ) ? wp_unslash( $_POST['_contact_branches_data'] ) : '[]';
        $br_decoded = json_decode( $br_raw, true );
        $br_clean = [];
        if ( is_array( $br_decoded ) ) {
            foreach ( $br_decoded as $b ) {
                $city = sanitize_text_field( $b['city'] ?? '' );
                if ( '' !== trim( $city ) ) {
                    $br_clean[] = [
                        'city'    => $city,
                        'address' => sanitize_textarea_field( $b['address'] ?? '' ),
                        'phone'   => sanitize_text_field( $b['phone'] ?? '' ),
                        'email'   => sanitize_text_field( $b['email'] ?? '' ),
                        'map_url' => esc_url_raw( $b['map_url'] ?? '' ),
                    ];
                }
            }
        }
        update_post_meta( $post_id, '_contact_branches', $br_clean );
    }
} );

// ── Blog Flags (Featured) ─────────────────────────────────────────────────────
add_action( 'add_meta_boxes', function () {
    add_meta_box( 'travzo_blog_flags', 'Blog Settings', 'travzo_blog_flags_cb', 'post', 'side', 'high' );
} );

function travzo_blog_flags_cb( $post ) {
    wp_nonce_field( 'travzo_blog_flags_save', 'travzo_blog_flags_nonce' );
    $featured = get_post_meta( $post->ID, '_is_featured_blog', true );
    echo '<label style="display:flex;align-items:center;gap:8px;font-weight:600;cursor:pointer">';
    echo '<input type="checkbox" name="_is_featured_blog" value="1"' . checked( $featured, '1', false ) . '>';
    echo 'Feature this blog on Homepage</label>';
    echo '<p style="color:#666;font-size:12px;margin-top:8px">When checked this blog appears in the Latest Blog section on the homepage.</p>';
}

add_action( 'save_post_post', function ( $post_id ) {
    if ( ! isset( $_POST['travzo_blog_flags_nonce'] ) ) return;
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_blog_flags_nonce'] ) ), 'travzo_blog_flags_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    update_post_meta( $post_id, '_is_featured_blog', isset( $_POST['_is_featured_blog'] ) ? '1' : '0' );
}, 20 );

// ══════════════════════════════════════════════════════════════════════════════
// FORM SYSTEM — Native AJAX forms with wp_mail()
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Get form settings with defaults.
 */
function travzo_get_forms_settings() {
    $defaults = [
        'captcha_enabled'    => false,
        'captcha_type'       => 'math',
        'recaptcha_site_key' => '',
        'recaptcha_secret_key' => '',
        'recipients'         => [
            'contact'         => get_option( 'admin_email' ),
            'enquiry'         => get_option( 'admin_email' ),
            'package_enquiry' => get_option( 'admin_email' ),
            'newsletter'      => get_option( 'admin_email' ),
        ],
        'cc'                     => '',
        'bcc'                    => '',
        'from_email'             => get_option( 'admin_email' ),
        'from_name'              => get_bloginfo( 'name' ),
        'send_user_confirmation' => false,
        'email_templates'        => [
            'admin_subject' => '[New {form_type}] from {full_name}',
            'admin_body'    => '<h2 style="color:#1A2A5E;">New {form_type} Submission</h2><p>You have received a new submission from {site_name}.</p>{all_fields}<p style="color:#666;font-size:12px;">Submitted on {submitted_at}</p>',
            'user_subject'  => 'Thank you for contacting {site_name}',
            'user_body'     => '<h2 style="color:#1A2A5E;">Hi {full_name},</h2><p>Thank you for reaching out to us! We will get back to you within 24 hours.</p><p><strong>Your submission details:</strong></p>{all_fields}<p>Best regards,<br>Team {site_name}</p>',
        ],
    ];
    $saved = get_option( 'travzo_forms_settings', [] );
    return wp_parse_args( $saved, $defaults );
}

/**
 * Register Form Submissions CPT (private, admin-only).
 */
add_action( 'init', function () {
    register_post_type( 'form_submission', [
        'labels'       => [
            'name'               => 'Form Submissions',
            'singular_name'      => 'Submission',
            'menu_name'          => 'Form Submissions',
            'all_items'          => 'All Submissions',
            'view_item'          => 'View Submission',
            'search_items'       => 'Search Submissions',
            'not_found'          => 'No submissions found',
            'not_found_in_trash' => 'No submissions found in Trash',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-email-alt',
        'menu_position' => 26,
        'supports'     => [ 'title' ],
        'capability_type' => 'post',
    ] );
} );

// ── Form Submissions admin list: columns ─────────────────────────────────────
add_filter( 'manage_form_submission_posts_columns', function ( $columns ) {
    return [
        'cb'        => $columns['cb'],
        'title'     => 'Submission',
        'form_type' => 'Form Type',
        'form_name' => 'Name',
        'form_email' => 'Email',
        'form_phone' => 'Phone',
        'date'      => $columns['date'],
    ];
} );

add_action( 'manage_form_submission_posts_custom_column', function ( $column, $post_id ) {
    $data = get_post_meta( $post_id, '_submitted_data', true );
    if ( ! is_array( $data ) ) $data = [];
    switch ( $column ) {
        case 'form_type':
            echo esc_html( ucwords( str_replace( '_', ' ', get_post_meta( $post_id, '_form_type', true ) ?: '—' ) ) );
            break;
        case 'form_name':
            echo esc_html( $data['full_name'] ?? $data['name'] ?? '—' );
            break;
        case 'form_email':
            echo esc_html( $data['email'] ?? '—' );
            break;
        case 'form_phone':
            echo esc_html( $data['phone'] ?? '—' );
            break;
    }
}, 10, 2 );

// ── Form Submissions admin list: filters + export button ─────────────────────
add_action( 'restrict_manage_posts', function () {
    global $typenow;
    if ( 'form_submission' !== $typenow ) return;

    $export_url = wp_nonce_url( admin_url( 'admin-post.php?action=travzo_export_submissions' ), 'travzo_export' );
    // Pass current filters to export
    if ( ! empty( $_GET['form_type_filter'] ) ) {
        $export_url = add_query_arg( 'form_type_filter', sanitize_text_field( $_GET['form_type_filter'] ), $export_url );
    }
    if ( ! empty( $_GET['from_date'] ) ) {
        $export_url = add_query_arg( 'from_date', sanitize_text_field( $_GET['from_date'] ), $export_url );
    }
    if ( ! empty( $_GET['to_date'] ) ) {
        $export_url = add_query_arg( 'to_date', sanitize_text_field( $_GET['to_date'] ), $export_url );
    }

    echo '<a href="' . esc_url( $export_url ) . '" class="button button-primary" style="margin-left:8px">Export to CSV</a> ';

    $current = sanitize_text_field( $_GET['form_type_filter'] ?? '' );
    echo '<select name="form_type_filter">';
    echo '<option value="">All Form Types</option>';
    foreach ( [ 'contact', 'enquiry', 'package_enquiry', 'newsletter' ] as $ft ) {
        printf( '<option value="%s"%s>%s</option>', esc_attr( $ft ), selected( $current, $ft, false ), esc_html( ucwords( str_replace( '_', ' ', $ft ) ) ) );
    }
    echo '</select> ';

    echo '<input type="date" name="from_date" value="' . esc_attr( $_GET['from_date'] ?? '' ) . '" placeholder="From" style="width:auto"> ';
    echo '<input type="date" name="to_date" value="' . esc_attr( $_GET['to_date'] ?? '' ) . '" placeholder="To" style="width:auto">';
} );

add_action( 'parse_query', function ( $query ) {
    global $pagenow;
    if ( 'edit.php' !== $pagenow || ( $_GET['post_type'] ?? '' ) !== 'form_submission' || ! $query->is_main_query() ) return;

    if ( ! empty( $_GET['form_type_filter'] ) ) {
        $query->set( 'meta_query', [ [ 'key' => '_form_type', 'value' => sanitize_text_field( $_GET['form_type_filter'] ) ] ] );
    }
    if ( ! empty( $_GET['from_date'] ) || ! empty( $_GET['to_date'] ) ) {
        $dq = [ 'inclusive' => true ];
        if ( ! empty( $_GET['from_date'] ) ) $dq['after']  = sanitize_text_field( $_GET['from_date'] );
        if ( ! empty( $_GET['to_date'] ) )   $dq['before'] = sanitize_text_field( $_GET['to_date'] );
        $query->set( 'date_query', [ $dq ] );
    }
} );

// ── Form Submissions: meta box for viewing data ──────────────────────────────
add_action( 'add_meta_boxes', function () {
    add_meta_box( 'travzo_submission_data', 'Submission Data', function ( $post ) {
        $data = get_post_meta( $post->ID, '_submitted_data', true );
        if ( ! is_array( $data ) || empty( $data ) ) {
            echo '<p>No data.</p>';
            return;
        }
        echo '<table class="widefat striped"><tbody>';
        foreach ( $data as $key => $value ) {
            if ( str_starts_with( $key, '_' ) ) continue;
            $label = ucwords( str_replace( '_', ' ', $key ) );
            echo '<tr><td><strong>' . esc_html( $label ) . '</strong></td>';
            echo '<td>' . esc_html( $value ) . '</td></tr>';
        }
        echo '</tbody></table>';
    }, 'form_submission', 'normal', 'high' );
} );

// ── CSV Export handler ───────────────────────────────────────────────────────
add_action( 'admin_post_travzo_export_submissions', function () {
    if ( ! current_user_can( 'manage_options' ) || ! wp_verify_nonce( $_GET['_wpnonce'] ?? '', 'travzo_export' ) ) {
        wp_die( 'Unauthorized' );
    }

    $args = [
        'post_type'      => 'form_submission',
        'posts_per_page' => -1,
        'post_status'    => 'private',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    if ( ! empty( $_GET['form_type_filter'] ) ) {
        $args['meta_query'] = [ [ 'key' => '_form_type', 'value' => sanitize_text_field( $_GET['form_type_filter'] ) ] ];
    }
    if ( ! empty( $_GET['from_date'] ) || ! empty( $_GET['to_date'] ) ) {
        $dq = [ 'inclusive' => true ];
        if ( ! empty( $_GET['from_date'] ) ) $dq['after']  = sanitize_text_field( $_GET['from_date'] );
        if ( ! empty( $_GET['to_date'] ) )   $dq['before'] = sanitize_text_field( $_GET['to_date'] );
        $args['date_query'] = [ $dq ];
    }

    $submissions = get_posts( $args );

    // Collect all unique field keys
    $all_keys = [ 'form_type', 'submitted_at' ];
    $captcha_keys = [ 'math_captcha', 'math_captcha_token', 'math_captcha_expected', 'recaptcha_token', 'g-recaptcha-response' ];
    foreach ( $submissions as $sub ) {
        $data = get_post_meta( $sub->ID, '_submitted_data', true ) ?: [];
        foreach ( array_keys( $data ) as $key ) {
            if ( ! in_array( $key, $all_keys, true ) && ! in_array( $key, $captcha_keys, true ) && ! str_starts_with( $key, '_' ) ) {
                $all_keys[] = $key;
            }
        }
    }

    $filename = 'travzo-submissions-' . gmdate( 'Y-m-d-His' ) . '.csv';
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

    $output = fopen( 'php://output', 'w' );
    fputs( $output, "\xEF\xBB\xBF" ); // BOM for Excel

    fputcsv( $output, array_map( function ( $k ) {
        return ucwords( str_replace( '_', ' ', $k ) );
    }, $all_keys ) );

    foreach ( $submissions as $sub ) {
        $data = get_post_meta( $sub->ID, '_submitted_data', true ) ?: [];
        $data['form_type']    = get_post_meta( $sub->ID, '_form_type', true );
        $data['submitted_at'] = get_the_date( 'Y-m-d H:i:s', $sub );
        $row = [];
        foreach ( $all_keys as $key ) {
            $row[] = $data[ $key ] ?? '';
        }
        fputcsv( $output, $row );
    }

    fclose( $output );
    exit;
} );

// ══════════════════════════════════════════════════════════════════════════════
// TRAVZO FORMS — Admin settings page (tabs: General, Recipients, Templates)
// ══════════════════════════════════════════════════════════════════════════════

add_action( 'admin_menu', function () {
    add_menu_page(
        'Travzo Forms',
        'Travzo Forms',
        'manage_options',
        'travzo-forms',
        'travzo_forms_admin_page',
        'dashicons-feedback',
        27
    );
} );

// Save handler
add_action( 'admin_post_travzo_save_forms_settings', function () {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
    check_admin_referer( 'travzo_forms_settings_save', 'travzo_forms_nonce' );

    $old = travzo_get_forms_settings();

    $settings = [
        'captcha_enabled'      => ! empty( $_POST['captcha_enabled'] ),
        'captcha_type'         => sanitize_text_field( $_POST['captcha_type'] ?? 'math' ),
        'recaptcha_site_key'   => sanitize_text_field( $_POST['recaptcha_site_key'] ?? '' ),
        'recaptcha_secret_key' => sanitize_text_field( $_POST['recaptcha_secret_key'] ?? '' ),
        'recipients'           => [
            'contact'         => sanitize_text_field( $_POST['recipients_contact'] ?? '' ),
            'enquiry'         => sanitize_text_field( $_POST['recipients_enquiry'] ?? '' ),
            'package_enquiry' => sanitize_text_field( $_POST['recipients_package_enquiry'] ?? '' ),
            'newsletter'      => sanitize_text_field( $_POST['recipients_newsletter'] ?? '' ),
        ],
        'cc'                     => sanitize_text_field( $_POST['cc'] ?? '' ),
        'bcc'                    => sanitize_text_field( $_POST['bcc'] ?? '' ),
        'from_email'             => sanitize_email( $_POST['from_email'] ?? '' ),
        'from_name'              => sanitize_text_field( $_POST['from_name'] ?? '' ),
        'send_user_confirmation' => ! empty( $_POST['send_user_confirmation'] ),
        'email_templates'        => [
            'admin_subject' => sanitize_text_field( $_POST['tpl_admin_subject'] ?? '' ),
            'admin_body'    => wp_kses_post( $_POST['tpl_admin_body'] ?? '' ),
            'user_subject'  => sanitize_text_field( $_POST['tpl_user_subject'] ?? '' ),
            'user_body'     => wp_kses_post( $_POST['tpl_user_body'] ?? '' ),
        ],
    ];

    update_option( 'travzo_forms_settings', $settings );
    wp_safe_redirect( admin_url( 'admin.php?page=travzo-forms&saved=1&tab=' . sanitize_text_field( $_POST['active_tab'] ?? 'general' ) ) );
    exit;
} );

/**
 * Render the Travzo Forms admin page with tabs.
 */
function travzo_forms_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $s       = travzo_get_forms_settings();
    $tab     = sanitize_text_field( $_GET['tab'] ?? 'general' );
    $success = isset( $_GET['saved'] ) && '1' === $_GET['saved'];
    $tpl     = $s['email_templates'] ?? [];
    $recip   = $s['recipients'] ?? [];

    $tabs = [
        'general'    => 'General Settings',
        'recipients' => 'Email Recipients',
        'templates'  => 'Email Templates',
    ];
    ?>
    <div class="wrap">
        <h1>Travzo Forms Settings</h1>
        <?php if ( $success ) : ?>
            <div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>
        <?php endif; ?>

        <h2 class="nav-tab-wrapper">
            <?php foreach ( $tabs as $slug => $label ) : ?>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=travzo-forms&tab=' . $slug ) ); ?>"
                   class="nav-tab <?php echo $tab === $slug ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
            <?php endforeach; ?>
        </h2>

        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="max-width:800px">
            <input type="hidden" name="action" value="travzo_save_forms_settings">
            <input type="hidden" name="active_tab" value="<?php echo esc_attr( $tab ); ?>">
            <?php wp_nonce_field( 'travzo_forms_settings_save', 'travzo_forms_nonce' ); ?>

            <?php // ── TAB: General ─────────────────────────────────────────── ?>
            <div style="<?php echo 'general' !== $tab ? 'display:none' : ''; ?>">
                <table class="form-table">
                    <tr>
                        <th>Enable CAPTCHA</th>
                        <td><label><input type="checkbox" name="captcha_enabled" value="1" <?php checked( $s['captcha_enabled'] ); ?>> Add CAPTCHA to all forms</label></td>
                    </tr>
                    <tr>
                        <th>CAPTCHA Type</th>
                        <td>
                            <select name="captcha_type" id="travzo-captcha-type">
                                <option value="math" <?php selected( $s['captcha_type'], 'math' ); ?>>Math CAPTCHA (no third-party dependency)</option>
                                <option value="recaptcha_v2" <?php selected( $s['captcha_type'], 'recaptcha_v2' ); ?>>Google reCAPTCHA v2 (checkbox)</option>
                                <option value="recaptcha_v3" <?php selected( $s['captcha_type'], 'recaptcha_v3' ); ?>>Google reCAPTCHA v3 (invisible)</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="travzo-recaptcha-row" style="<?php echo ! in_array( $s['captcha_type'], [ 'recaptcha_v2', 'recaptcha_v3' ], true ) ? 'display:none' : ''; ?>">
                        <th>reCAPTCHA Site Key</th>
                        <td><input type="text" name="recaptcha_site_key" value="<?php echo esc_attr( $s['recaptcha_site_key'] ); ?>" class="regular-text"></td>
                    </tr>
                    <tr class="travzo-recaptcha-row" style="<?php echo ! in_array( $s['captcha_type'], [ 'recaptcha_v2', 'recaptcha_v3' ], true ) ? 'display:none' : ''; ?>">
                        <th>reCAPTCHA Secret Key</th>
                        <td>
                            <input type="text" name="recaptcha_secret_key" value="<?php echo esc_attr( $s['recaptcha_secret_key'] ); ?>" class="regular-text">
                            <p class="description">Get your keys at <a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="noopener">google.com/recaptcha/admin</a></p>
                        </td>
                    </tr>
                </table>
            </div>

            <?php // ── TAB: Recipients ──────────────────────────────────────── ?>
            <div style="<?php echo 'recipients' !== $tab ? 'display:none' : ''; ?>">
                <h3>Per-Form Recipients</h3>
                <p class="description">Comma-separated email addresses. Leave blank to use the site admin email.</p>
                <table class="form-table">
                    <tr>
                        <th>Contact Form</th>
                        <td><input type="text" name="recipients_contact" value="<?php echo esc_attr( $recip['contact'] ?? '' ); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>Homepage Enquiry</th>
                        <td><input type="text" name="recipients_enquiry" value="<?php echo esc_attr( $recip['enquiry'] ?? '' ); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>Package Enquiry</th>
                        <td><input type="text" name="recipients_package_enquiry" value="<?php echo esc_attr( $recip['package_enquiry'] ?? '' ); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>Newsletter</th>
                        <td><input type="text" name="recipients_newsletter" value="<?php echo esc_attr( $recip['newsletter'] ?? '' ); ?>" class="regular-text"></td>
                    </tr>
                </table>

                <h3>Global Email Settings</h3>
                <table class="form-table">
                    <tr>
                        <th>CC (all forms)</th>
                        <td><input type="text" name="cc" value="<?php echo esc_attr( $s['cc'] ); ?>" class="regular-text" placeholder="cc@example.com"></td>
                    </tr>
                    <tr>
                        <th>BCC (all forms)</th>
                        <td><input type="text" name="bcc" value="<?php echo esc_attr( $s['bcc'] ); ?>" class="regular-text" placeholder="bcc@example.com"></td>
                    </tr>
                    <tr>
                        <th>From Email</th>
                        <td><input type="email" name="from_email" value="<?php echo esc_attr( $s['from_email'] ); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>From Name</th>
                        <td><input type="text" name="from_name" value="<?php echo esc_attr( $s['from_name'] ); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>Auto-Reply to User</th>
                        <td><label><input type="checkbox" name="send_user_confirmation" value="1" <?php checked( $s['send_user_confirmation'] ); ?>> Send confirmation email to the form submitter</label></td>
                    </tr>
                </table>
            </div>

            <?php // ── TAB: Templates ───────────────────────────────────────── ?>
            <div style="<?php echo 'templates' !== $tab ? 'display:none' : ''; ?>">
                <p class="description" style="margin-bottom:16px">
                    <strong>Available placeholders:</strong>
                    <?php
                    $placeholders = [ '{full_name}', '{email}', '{phone}', '{trip_type}', '{destination}', '{travel_date}', '{guests}', '{message}', '{form_type}', '{site_name}', '{site_url}', '{submitted_at}', '{all_fields}' ];
                    foreach ( $placeholders as $ph ) {
                        echo '<code style="cursor:pointer;margin:2px;padding:2px 6px;background:#e8f0ff;border-radius:3px" class="travzo-ph-badge">' . esc_html( $ph ) . '</code> ';
                    }
                    ?>
                </p>

                <h3>Admin Notification Email</h3>
                <table class="form-table">
                    <tr>
                        <th>Subject</th>
                        <td><input type="text" name="tpl_admin_subject" value="<?php echo esc_attr( $tpl['admin_subject'] ?? '' ); ?>" class="large-text"></td>
                    </tr>
                    <tr>
                        <th>Body</th>
                        <td>
                            <?php wp_editor( $tpl['admin_body'] ?? '', 'tpl_admin_body', [
                                'textarea_name' => 'tpl_admin_body',
                                'textarea_rows' => 12,
                                'media_buttons' => false,
                                'teeny'         => true,
                            ] ); ?>
                        </td>
                    </tr>
                </table>

                <h3>User Confirmation Email</h3>
                <table class="form-table">
                    <tr>
                        <th>Subject</th>
                        <td><input type="text" name="tpl_user_subject" value="<?php echo esc_attr( $tpl['user_subject'] ?? '' ); ?>" class="large-text"></td>
                    </tr>
                    <tr>
                        <th>Body</th>
                        <td>
                            <?php wp_editor( $tpl['user_body'] ?? '', 'tpl_user_body', [
                                'textarea_name' => 'tpl_user_body',
                                'textarea_rows' => 12,
                                'media_buttons' => false,
                                'teeny'         => true,
                            ] ); ?>
                        </td>
                    </tr>
                </table>
            </div>

            <?php // Hidden fields to preserve values from other tabs ?>
            <?php if ( 'general' !== $tab ) : ?>
                <input type="hidden" name="captcha_enabled" value="<?php echo $s['captcha_enabled'] ? '1' : ''; ?>">
                <input type="hidden" name="captcha_type" value="<?php echo esc_attr( $s['captcha_type'] ); ?>">
                <input type="hidden" name="recaptcha_site_key" value="<?php echo esc_attr( $s['recaptcha_site_key'] ); ?>">
                <input type="hidden" name="recaptcha_secret_key" value="<?php echo esc_attr( $s['recaptcha_secret_key'] ); ?>">
            <?php endif; ?>
            <?php if ( 'recipients' !== $tab ) : ?>
                <input type="hidden" name="recipients_contact" value="<?php echo esc_attr( $recip['contact'] ?? '' ); ?>">
                <input type="hidden" name="recipients_enquiry" value="<?php echo esc_attr( $recip['enquiry'] ?? '' ); ?>">
                <input type="hidden" name="recipients_package_enquiry" value="<?php echo esc_attr( $recip['package_enquiry'] ?? '' ); ?>">
                <input type="hidden" name="recipients_newsletter" value="<?php echo esc_attr( $recip['newsletter'] ?? '' ); ?>">
                <input type="hidden" name="cc" value="<?php echo esc_attr( $s['cc'] ); ?>">
                <input type="hidden" name="bcc" value="<?php echo esc_attr( $s['bcc'] ); ?>">
                <input type="hidden" name="from_email" value="<?php echo esc_attr( $s['from_email'] ); ?>">
                <input type="hidden" name="from_name" value="<?php echo esc_attr( $s['from_name'] ); ?>">
                <input type="hidden" name="send_user_confirmation" value="<?php echo $s['send_user_confirmation'] ? '1' : ''; ?>">
            <?php endif; ?>
            <?php if ( 'templates' !== $tab ) : ?>
                <input type="hidden" name="tpl_admin_subject" value="<?php echo esc_attr( $tpl['admin_subject'] ?? '' ); ?>">
                <input type="hidden" name="tpl_admin_body" value="<?php echo esc_attr( $tpl['admin_body'] ?? '' ); ?>">
                <input type="hidden" name="tpl_user_subject" value="<?php echo esc_attr( $tpl['user_subject'] ?? '' ); ?>">
                <input type="hidden" name="tpl_user_body" value="<?php echo esc_attr( $tpl['user_body'] ?? '' ); ?>">
            <?php endif; ?>

            <p class="submit"><input type="submit" class="button-primary" value="Save Settings"></p>
        </form>
    </div>

    <script>
    jQuery(function($) {
        // Toggle reCAPTCHA key fields
        $('#travzo-captcha-type').on('change', function() {
            var isRecaptcha = this.value === 'recaptcha_v2' || this.value === 'recaptcha_v3';
            $('.travzo-recaptcha-row').toggle(isRecaptcha);
        });
        // Click placeholder badge to copy
        $(document).on('click', '.travzo-ph-badge', function() {
            var text = $(this).text();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text);
                var $el = $(this);
                $el.css('background', '#c6f6d5');
                setTimeout(function() { $el.css('background', '#e8f0ff'); }, 600);
            }
        });
    });
    </script>
    <?php
}

// ══════════════════════════════════════════════════════════════════════════════
// CAPTCHA — Frontend rendering
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Output CAPTCHA widget HTML for a form. Call inside the form before the submit button.
 */
function travzo_render_captcha() {
    $s = travzo_get_forms_settings();
    if ( empty( $s['captcha_enabled'] ) ) return;

    $type = $s['captcha_type'] ?? 'math';
    echo '<div class="cform-group form-captcha">';
    if ( 'recaptcha_v2' === $type && ! empty( $s['recaptcha_site_key'] ) ) {
        echo '<div class="g-recaptcha" data-sitekey="' . esc_attr( $s['recaptcha_site_key'] ) . '"></div>';
    } elseif ( 'recaptcha_v3' === $type && ! empty( $s['recaptcha_site_key'] ) ) {
        echo '<input type="hidden" name="recaptcha_token" class="recaptcha-v3-token">';
    } else {
        // Math CAPTCHA
        $a     = wp_rand( 1, 9 );
        $b     = wp_rand( 1, 9 );
        $hash  = wp_hash( (string) ( $a + $b ) );
        echo '<label>What is ' . $a . ' + ' . $b . '? <span aria-hidden="true">*</span></label>';
        echo '<input type="number" name="math_captcha" required style="max-width:120px">';
        echo '<input type="hidden" name="math_captcha_expected" value="' . esc_attr( $hash ) . '">';
    }
    echo '</div>';
}

/**
 * Enqueue reCAPTCHA scripts in the footer when needed.
 */
add_action( 'wp_footer', function () {
    $s = travzo_get_forms_settings();
    if ( empty( $s['captcha_enabled'] ) ) return;

    $type = $s['captcha_type'] ?? 'math';
    $key  = esc_attr( $s['recaptcha_site_key'] ?? '' );

    if ( 'recaptcha_v2' === $type && $key ) {
        echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>' . "\n";
    } elseif ( 'recaptcha_v3' === $type && $key ) {
        echo "<script src=\"https://www.google.com/recaptcha/api.js?render={$key}\"></script>\n";
        echo "<script>
document.querySelectorAll('.travzo-form').forEach(function(form){
    form.addEventListener('submit',function(e){
        var tokenInput=form.querySelector('.recaptcha-v3-token');
        if(!tokenInput||tokenInput.value) return;
        e.preventDefault();e.stopImmediatePropagation();
        grecaptcha.ready(function(){
            grecaptcha.execute('{$key}',{action:'submit'}).then(function(token){
                tokenInput.value=token;
                form.dispatchEvent(new Event('submit',{bubbles:true}));
            });
        });
    },true);
});
</script>\n";
    }
}, 99 );

// ══════════════════════════════════════════════════════════════════════════════
// Email template renderer
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Render an email template by replacing placeholders.
 *
 * @param string $template_key  'admin' or 'user'
 * @param array  $data          Submitted form data.
 * @param string $form_type     Form type slug.
 * @return array ['subject' => ..., 'body' => ...]
 */
function travzo_render_email_template( $template_key, $data, $form_type ) {
    $s   = travzo_get_forms_settings();
    $tpl = $s['email_templates'] ?? [];

    $subject_tpl = $tpl[ $template_key . '_subject' ] ?? '';
    $body_tpl    = $tpl[ $template_key . '_body' ] ?? '';

    if ( empty( $subject_tpl ) && empty( $body_tpl ) ) {
        return [ 'subject' => '', 'body' => '' ];
    }

    // Build {all_fields} table
    $captcha_keys = [ 'math_captcha', 'math_captcha_token', 'math_captcha_expected', 'recaptcha_token', 'g-recaptcha-response' ];
    $all_fields   = '<table style="border-collapse:collapse;width:100%;max-width:600px;margin:16px 0">';
    foreach ( $data as $key => $value ) {
        if ( empty( $value ) || str_starts_with( $key, '_' ) || in_array( $key, $captcha_keys, true ) ) continue;
        $label       = ucwords( str_replace( '_', ' ', $key ) );
        $all_fields .= '<tr>';
        $all_fields .= '<td style="padding:10px 12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:600;width:35%">' . esc_html( $label ) . '</td>';
        $all_fields .= '<td style="padding:10px 12px;border:1px solid #e5e7eb">' . nl2br( esc_html( $value ) ) . '</td>';
        $all_fields .= '</tr>';
    }
    $all_fields .= '</table>';

    $replacements = [
        '{form_type}'    => ucwords( str_replace( '_', ' ', $form_type ) ),
        '{site_name}'    => get_bloginfo( 'name' ),
        '{site_url}'     => home_url(),
        '{submitted_at}' => wp_date( 'F j, Y \a\t g:i A' ),
        '{all_fields}'   => $all_fields,
    ];

    // Map form data keys to placeholders
    foreach ( $data as $key => $value ) {
        if ( str_starts_with( $key, '_' ) ) continue;
        $replacements[ '{' . $key . '}' ] = esc_html( $value );
    }

    return [
        'subject' => strtr( $subject_tpl, $replacements ),
        'body'    => '<html><body style="font-family:Arial,sans-serif;color:#333">' . strtr( $body_tpl, $replacements ) . '</body></html>',
    ];
}

// ══════════════════════════════════════════════════════════════════════════════
// AJAX form submission handler
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Localize AJAX URL for the frontend script.
 */
add_action( 'wp_enqueue_scripts', function () {
    wp_localize_script( 'travzo-main-script', 'travzoAjax', [
        'url'   => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'travzo_form_submit' ),
    ] );
}, 20 );

add_action( 'wp_ajax_travzo_form_submit', 'travzo_handle_form_submit' );
add_action( 'wp_ajax_nopriv_travzo_form_submit', 'travzo_handle_form_submit' );

function travzo_handle_form_submit() {
    // Nonce check
    if ( ! isset( $_POST['travzo_form_nonce'] ) ||
         ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_form_nonce'] ) ), 'travzo_form_submit' ) ) {
        wp_send_json_error( [ 'message' => 'Security check failed.' ] );
    }

    $form_type = sanitize_text_field( $_POST['form_type'] ?? 'contact' );
    $skip_keys = [ 'action', 'travzo_form_nonce', '_wp_http_referer', 'form_type',
                   'math_captcha', 'math_captcha_token', 'math_captcha_expected',
                   'recaptcha_token', 'g-recaptcha-response' ];
    $data      = [];

    foreach ( $_POST as $key => $value ) {
        if ( in_array( $key, $skip_keys, true ) ) continue;
        $data[ sanitize_key( $key ) ] = is_array( $value )
            ? array_map( 'sanitize_text_field', $value )
            : sanitize_textarea_field( wp_unslash( $value ) );
    }

    // ── CAPTCHA verification ──────────────────────────────────────────────────
    $settings = travzo_get_forms_settings();
    if ( ! empty( $settings['captcha_enabled'] ) ) {
        $ctype = $settings['captcha_type'] ?? 'math';

        if ( 'math' === $ctype ) {
            $expected = sanitize_text_field( $_POST['math_captcha_expected'] ?? '' );
            $given    = absint( $_POST['math_captcha'] ?? 0 );
            if ( wp_hash( (string) $given ) !== $expected ) {
                wp_send_json_error( [ 'message' => 'Incorrect answer. Please solve the math problem.' ] );
            }
        } elseif ( 'recaptcha_v2' === $ctype || 'recaptcha_v3' === $ctype ) {
            $token = sanitize_text_field( $_POST['g-recaptcha-response'] ?? $_POST['recaptcha_token'] ?? '' );
            if ( empty( $token ) ) {
                wp_send_json_error( [ 'message' => 'Please complete the CAPTCHA.' ] );
            }
            $resp = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', [
                'body' => [
                    'secret'   => $settings['recaptcha_secret_key'],
                    'response' => $token,
                    'remoteip' => sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' ),
                ],
            ] );
            if ( is_wp_error( $resp ) ) {
                wp_send_json_error( [ 'message' => 'CAPTCHA verification error. Please try again.' ] );
            }
            $result = json_decode( wp_remote_retrieve_body( $resp ), true );
            if ( empty( $result['success'] ) ) {
                wp_send_json_error( [ 'message' => 'CAPTCHA verification failed.' ] );
            }
            if ( 'recaptcha_v3' === $ctype && ( $result['score'] ?? 0 ) < 0.5 ) {
                wp_send_json_error( [ 'message' => 'Suspicious activity detected. Please try again.' ] );
            }
        }
    }

    // ── Validate required fields ──────────────────────────────────────────────
    $name  = $data['full_name'] ?? $data['name'] ?? '';
    $email = $data['email'] ?? '';

    if ( 'newsletter' !== $form_type && empty( $name ) ) {
        wp_send_json_error( [ 'message' => 'Please enter your name.' ] );
    }
    if ( ! empty( $email ) && ! is_email( $email ) ) {
        wp_send_json_error( [ 'message' => 'Please enter a valid email address.' ] );
    }
    if ( 'newsletter' === $form_type && ( empty( $email ) || ! is_email( $email ) ) ) {
        wp_send_json_error( [ 'message' => 'Please enter a valid email address.' ] );
    }

    // ── Build email using templates ───────────────────────────────────────────
    $admin_email_data = travzo_render_email_template( 'admin', $data, $form_type );

    // Subject: use template if available, else built-in defaults
    if ( ! empty( $admin_email_data['subject'] ) ) {
        $subject = $admin_email_data['subject'];
    } else {
        $defaults = [
            'contact'         => '[Contact Form] New enquiry from ' . $name,
            'enquiry'         => '[Plan Your Trip] Enquiry from ' . $name,
            'package_enquiry' => '[Package Enquiry] ' . ( $data['package_name'] ?? '' ) . ' — ' . $name,
            'newsletter'      => '[Newsletter] New subscriber: ' . $email,
        ];
        $subject = $defaults[ $form_type ] ?? '[Website Form] New Submission';
    }

    // Body: use template if available, else generate default
    if ( ! empty( $admin_email_data['body'] ) ) {
        $body = $admin_email_data['body'];
    } else {
        $site_name = get_bloginfo( 'name' );
        $body  = '<html><body style="font-family:Arial,sans-serif;color:#333">';
        $body .= '<h2 style="color:#1A2A5E">New Form Submission — ' . esc_html( $site_name ) . '</h2>';
        $body .= '<p><strong>Form:</strong> ' . esc_html( ucwords( str_replace( '_', ' ', $form_type ) ) ) . '</p>';
        $body .= '<table style="border-collapse:collapse;width:100%;max-width:600px">';
        foreach ( $data as $key => $value ) {
            if ( empty( $value ) || str_starts_with( $key, '_' ) ) continue;
            $label = ucwords( str_replace( '_', ' ', $key ) );
            $body .= '<tr>';
            $body .= '<td style="padding:10px 12px;border:1px solid #e5e7eb;background:#f9fafb;font-weight:600;width:35%">' . esc_html( $label ) . '</td>';
            $body .= '<td style="padding:10px 12px;border:1px solid #e5e7eb">' . nl2br( esc_html( $value ) ) . '</td>';
            $body .= '</tr>';
        }
        $body .= '</table>';
        $body .= '<p style="color:#999;font-size:12px;margin-top:20px">Submitted on ' . wp_date( 'F j, Y \a\t g:i A' ) . '</p>';
        $body .= '</body></html>';
    }

    // ── Recipients from settings ──────────────────────────────────────────────
    $recip_map  = $settings['recipients'] ?? [];
    $to_string  = $recip_map[ $form_type ] ?? get_option( 'admin_email' );
    $to         = array_filter( array_map( 'trim', explode( ',', $to_string ) ) );
    if ( empty( $to ) ) $to = [ get_option( 'admin_email' ) ];

    $headers = [ 'Content-Type: text/html; charset=UTF-8' ];

    if ( ! empty( $settings['from_email'] ) && ! empty( $settings['from_name'] ) ) {
        $headers[] = 'From: ' . $settings['from_name'] . ' <' . sanitize_email( $settings['from_email'] ) . '>';
    }
    if ( ! empty( $settings['cc'] ) ) {
        foreach ( array_filter( array_map( 'trim', explode( ',', $settings['cc'] ) ) ) as $cc ) {
            $headers[] = 'Cc: ' . sanitize_email( $cc );
        }
    }
    if ( ! empty( $settings['bcc'] ) ) {
        foreach ( array_filter( array_map( 'trim', explode( ',', $settings['bcc'] ) ) ) as $bcc ) {
            $headers[] = 'Bcc: ' . sanitize_email( $bcc );
        }
    }
    if ( ! empty( $email ) && is_email( $email ) ) {
        $reply_name = $name ?: $email;
        $headers[]  = 'Reply-To: ' . $reply_name . ' <' . sanitize_email( $email ) . '>';
    }

    $sent = wp_mail( $to, $subject, $body, $headers );

    // ── User confirmation email ───────────────────────────────────────────────
    if ( ! empty( $settings['send_user_confirmation'] ) && ! empty( $email ) && is_email( $email ) ) {
        $user_email_data = travzo_render_email_template( 'user', $data, $form_type );
        if ( ! empty( $user_email_data['subject'] ) && ! empty( $user_email_data['body'] ) ) {
            $user_headers = [ 'Content-Type: text/html; charset=UTF-8' ];
            if ( ! empty( $settings['from_email'] ) && ! empty( $settings['from_name'] ) ) {
                $user_headers[] = 'From: ' . $settings['from_name'] . ' <' . sanitize_email( $settings['from_email'] ) . '>';
            }
            wp_mail( sanitize_email( $email ), $user_email_data['subject'], $user_email_data['body'], $user_headers );
        }
    }

    // ── Store submission in database ──────────────────────────────────────────
    $post_id = wp_insert_post( [
        'post_type'    => 'form_submission',
        'post_title'   => $subject,
        'post_content' => wp_json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ),
        'post_status'  => 'private',
    ] );
    if ( $post_id && ! is_wp_error( $post_id ) ) {
        update_post_meta( $post_id, '_form_type', $form_type );
        update_post_meta( $post_id, '_submitted_data', $data );
    }

    if ( $sent ) {
        wp_send_json_success( [ 'message' => 'Form submitted successfully!' ] );
    } else {
        wp_send_json_error( [ 'message' => 'Your submission was saved but the confirmation email could not be sent. We will still get back to you.' ] );
    }
}

// ══════════════════════════════════════════════════════════════════════════════
// Form rendering helpers
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Render a theme form. Always outputs the theme HTML — no plugin dependency.
 *
 * @param string $form_html  The form HTML to output.
 */
function travzo_render_form( $form_html ) {
    echo $form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Homepage "Plan Your Dream Trip" enquiry form.
 */
function travzo_default_enquiry_form() {
    ob_start(); ?>
    <form class="travzo-form contact-form enquiry-form" data-form-type="enquiry" novalidate>
        <?php wp_nonce_field( 'travzo_form_submit', 'travzo_form_nonce' ); ?>
        <input type="hidden" name="action" value="travzo_form_submit">
        <input type="hidden" name="form_type" value="enquiry">

        <div class="cform-row">
            <div class="cform-group">
                <label for="eq_name">Your Name <span aria-hidden="true">*</span></label>
                <input type="text" id="eq_name" name="full_name" required placeholder="Ramesh Kumar">
            </div>
            <div class="cform-group">
                <label for="eq_city">City <span aria-hidden="true">*</span></label>
                <input type="text" id="eq_city" name="city" required placeholder="Coimbatore">
            </div>
        </div>

        <div class="cform-row">
            <div class="cform-group">
                <label for="eq_email">Email <span aria-hidden="true">*</span></label>
                <input type="email" id="eq_email" name="email" required placeholder="your@email.com">
            </div>
            <div class="cform-group">
                <label for="eq_phone">Phone <span aria-hidden="true">*</span></label>
                <input type="text" id="eq_phone" name="phone" required placeholder="+91 XXXXX XXXXX">
            </div>
        </div>

        <div class="cform-row">
            <div class="cform-group">
                <label for="eq_dest">Destination</label>
                <input type="text" id="eq_dest" name="destination" placeholder="Bali, Kerala, Europe">
            </div>
            <div class="cform-row__half">
                <div class="cform-group">
                    <label for="eq_date">Travel Date</label>
                    <input type="text" id="eq_date" name="travel_date" placeholder="DD-MM-YYYY">
                </div>
                <div class="cform-group">
                    <label for="eq_people">No. of People</label>
                    <select id="eq_people" name="guests">
                        <option value="">Select</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3-5">3-5</option>
                        <option value="6-10">6-10</option>
                        <option value="10+">10+</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="cform-group">
            <label for="eq_trip">Trip Type</label>
            <select id="eq_trip" name="trip_type">
                <option value="">Select trip type</option>
                <option value="Group Tour">Group Tour</option>
                <option value="Honeymoon">Honeymoon</option>
                <option value="Solo Trip">Solo Trip</option>
                <option value="Devotional">Devotional</option>
                <option value="Destination Wedding">Destination Wedding</option>
            </select>
        </div>

        <?php travzo_render_captcha(); ?>

        <button type="submit" class="btn btn--gold btn--full form-submit-btn">
            Send Enquiry
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        </button>
        <div class="form-success" style="display:none">Thank you! We'll get back to you within 24 hours.</div>
        <div class="form-error" style="display:none">Something went wrong. Please try again.</div>
    </form>
    <?php return ob_get_clean();
}

/**
 * Package sidebar quick enquiry form.
 *
 * @param int $pkg_id  Package post ID.
 */
function travzo_default_package_form( $pkg_id = 0 ) {
    $pkg_name = $pkg_id ? get_the_title( $pkg_id ) : '';
    ob_start(); ?>
    <form class="travzo-form sidebar-enquiry-form" data-form-type="package_enquiry" novalidate>
        <?php wp_nonce_field( 'travzo_form_submit', 'travzo_form_nonce' ); ?>
        <input type="hidden" name="action" value="travzo_form_submit">
        <input type="hidden" name="form_type" value="package_enquiry">
        <input type="hidden" name="package_name" value="<?php echo esc_attr( $pkg_name ); ?>">
        <div class="sidebar-form-field"><input type="text" name="name" placeholder="Your Name *" required></div>
        <div class="sidebar-form-field"><input type="text" name="phone" placeholder="Phone Number *" required></div>
        <div class="sidebar-form-field"><input type="text" name="travel_date" placeholder="Travel Date (DD-MM-YYYY)"></div>
        <div class="sidebar-form-field"><input type="text" name="guests" placeholder="No. of People"></div>
        <?php travzo_render_captcha(); ?>
        <button type="submit" class="btn btn--gold btn--full form-submit-btn">Enquire Now</button>
        <div class="form-success" style="display:none">Thank you! We'll get back to you shortly.</div>
        <div class="form-error" style="display:none">Something went wrong. Please try again.</div>
    </form>
    <?php return ob_get_clean();
}

// ══════════════════════════════════════════════════════════════════════════════
// DUPLICATE PACKAGE
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Clone a package post with all meta and taxonomy terms.
 *
 * @param int $post_id Original package post ID.
 * @return int|WP_Error New post ID on success, WP_Error on failure.
 */
function travzo_duplicate_package( $post_id ) {
    $post = get_post( $post_id );
    if ( ! $post || 'package' !== $post->post_type ) {
        return new WP_Error( 'invalid_post', 'Not a valid package post.' );
    }

    $new_post = [
        'post_title'     => $post->post_title . ' (Copy)',
        'post_content'   => $post->post_content,
        'post_excerpt'   => $post->post_excerpt,
        'post_status'    => 'draft',
        'post_type'      => 'package',
        'post_author'    => $post->post_author,
        'post_parent'    => $post->post_parent,
        'post_password'  => $post->post_password,
        'menu_order'     => $post->menu_order,
        'comment_status' => $post->comment_status,
        'ping_status'    => $post->ping_status,
        'post_name'      => sanitize_title( $post->post_name . '-copy' ),
    ];

    $new_id = wp_insert_post( $new_post, true );
    if ( is_wp_error( $new_id ) ) {
        return $new_id;
    }

    // ── Copy all post meta ──
    $skip_keys = [ '_edit_lock', '_edit_last' ];
    $all_meta  = get_post_meta( $post_id );

    foreach ( $all_meta as $key => $values ) {
        if ( in_array( $key, $skip_keys, true ) ) {
            continue;
        }
        foreach ( $values as $value ) {
            // $value is already unserialized by WP; add_post_meta will re-serialize
            add_post_meta( $new_id, $key, $value );
        }
    }

    // ── Copy all taxonomy terms ──
    $taxonomies = get_object_taxonomies( 'package' );
    foreach ( $taxonomies as $taxonomy ) {
        $terms = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'ids' ] );
        if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
            wp_set_object_terms( $new_id, $terms, $taxonomy );
        }
    }

    return $new_id;
}

// ── Admin-post action handler ──
add_action( 'admin_post_travzo_duplicate_package', function () {
    $post_id = absint( $_GET['post'] ?? 0 );
    if ( ! $post_id ) {
        wp_die( 'Missing post ID.', 'Error', [ 'back_link' => true ] );
    }

    if ( ! isset( $_GET['_wpnonce'] ) ||
         ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'travzo_duplicate_package_' . $post_id ) ) {
        wp_die( 'Security check failed.', 'Error', [ 'back_link' => true ] );
    }

    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_die( 'You do not have permission to duplicate packages.', 'Error', [ 'back_link' => true ] );
    }

    $new_id = travzo_duplicate_package( $post_id );
    if ( is_wp_error( $new_id ) ) {
        wp_die( $new_id->get_error_message(), 'Error', [ 'back_link' => true ] );
    }

    wp_safe_redirect( add_query_arg( [ 'action' => 'edit', 'post' => $new_id, 'duplicated' => '1' ], admin_url( 'post.php' ) ) );
    exit;
} );

// ── Row action link on Packages list ──
add_filter( 'post_row_actions', function ( $actions, $post ) {
    if ( 'package' !== $post->post_type || ! current_user_can( 'edit_posts' ) ) {
        return $actions;
    }

    $nonce = wp_create_nonce( 'travzo_duplicate_package_' . $post->ID );
    $url   = admin_url( 'admin-post.php?action=travzo_duplicate_package&post=' . $post->ID . '&_wpnonce=' . $nonce );

    // Insert after "Edit" (first key)
    $new_actions = [];
    foreach ( $actions as $key => $action ) {
        $new_actions[ $key ] = $action;
        if ( 'edit' === $key ) {
            $new_actions['duplicate'] = '<a href="' . esc_url( $url ) . '" aria-label="Duplicate &ldquo;' . esc_attr( $post->post_title ) . '&rdquo;">Duplicate</a>';
        }
    }

    return $new_actions;
}, 10, 2 );

// ── Duplicate button on package edit screen ──
add_action( 'post_submitbox_misc_actions', function ( $post ) {
    if ( 'package' !== $post->post_type || ! current_user_can( 'edit_posts' ) ) {
        return;
    }

    $nonce = wp_create_nonce( 'travzo_duplicate_package_' . $post->ID );
    $url   = admin_url( 'admin-post.php?action=travzo_duplicate_package&post=' . $post->ID . '&_wpnonce=' . $nonce );

    echo '<div class="misc-pub-section" style="border-top:1px solid #ddd;padding-top:8px;margin-top:4px">';
    echo '<a href="' . esc_url( $url ) . '" class="button" style="width:100%;text-align:center">Duplicate this Package</a>';
    echo '</div>';
} );

// ── Admin notice after successful duplication ──
add_action( 'admin_notices', function () {
    $screen = get_current_screen();
    if ( ! $screen || 'package' !== $screen->post_type || 'post' !== $screen->base ) {
        return;
    }
    if ( ! isset( $_GET['duplicated'] ) || '1' !== $_GET['duplicated'] ) {
        return;
    }
    echo '<div class="notice notice-success is-dismissible"><p>Package duplicated successfully. This is a draft copy — edit and publish when ready.</p></div>';
} );
