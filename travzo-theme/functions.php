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

    // ── SECTION: Newsletter ───────────────────────────────────────────────────
    $wp_customize->add_section( 'travzo_newsletter', [
        'title' => 'Homepage - Newsletter',
        'panel' => 'travzo_panel',
    ] );
    $wp_customize->add_setting( 'travzo_newsletter_heading', [
        'default'           => 'Get Travel Deals in Your Inbox',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'travzo_newsletter_heading', [
        'label'   => 'Heading',
        'section' => 'travzo_newsletter',
        'type'    => 'text',
    ] );
    $wp_customize->add_setting( 'travzo_newsletter_subtext', [
        'default'           => 'Subscribe for exclusive offers.',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'travzo_newsletter_subtext', [
        'label'   => 'Subtext',
        'section' => 'travzo_newsletter',
        'type'    => 'text',
    ] );
} );

// ── WPForms Integration ───────────────────────────────────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'travzo_wpforms', [
        'title'    => 'WPForms Integration',
        'panel'    => 'travzo_panel',
        'priority' => 50,
    ] );
    $form_fields = [
        'travzo_form_contact'    => 'Contact Page Form ID',
        'travzo_form_enquiry'    => 'Homepage Enquiry Form ID',
        'travzo_form_newsletter' => 'Newsletter Form ID',
        'travzo_form_package'    => 'Package Page Enquiry Form ID',
    ];
    foreach ( $form_fields as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'absint' ] );
        $wp_customize->add_control( $key, [
            'label'       => $label,
            'description' => 'Enter the WPForms form ID. Leave blank to use the default form.',
            'section'     => 'travzo_wpforms',
            'type'        => 'number',
        ] );
    }
}, 20 );

// ── Homepage – Why Choose Us (MOVED TO META BOX — see travzo_homepage_whyus_cb) ──

// ── Header – Navigation Labels & URLs ────────────────────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'travzo_nav_labels', [
        'title'    => 'Header – Navigation Labels',
        'panel'    => 'travzo_panel',
        'priority' => 25,
    ] );

    $nav_label_fields = [
        'travzo_nav_home'      => [ 'label' => 'Home Label',                'default' => 'Home' ],
        'travzo_nav_group'     => [ 'label' => 'Group Tours Label',         'default' => 'Group Tours' ],
        'travzo_nav_honeymoon' => [ 'label' => 'Honeymoon Label',           'default' => 'Honeymoon' ],
        'travzo_nav_devotional'=> [ 'label' => 'Devotional Label',          'default' => 'Devotional' ],
        'travzo_nav_wedding'   => [ 'label' => 'Destination Wedding Label', 'default' => 'Dest. Wedding' ],
        'travzo_nav_solo'      => [ 'label' => 'Solo Trips Label',          'default' => 'Solo Trips' ],
        'travzo_nav_blog'      => [ 'label' => 'Blog Label',                'default' => 'Blog' ],
        'travzo_nav_about'     => [ 'label' => 'About Label',               'default' => 'About' ],
        'travzo_nav_contact'   => [ 'label' => 'Contact Label',             'default' => 'Contact' ],
        'travzo_nav_cta_text'  => [ 'label' => 'CTA Button Text',           'default' => 'Call Us Now' ],
    ];
    foreach ( $nav_label_fields as $key => $field ) {
        $wp_customize->add_setting( $key, [
            'default'           => $field['default'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $key, [
            'label'   => $field['label'],
            'section' => 'travzo_nav_labels',
            'type'    => 'text',
        ] );
    }

    $nav_url_fields = [
        'travzo_nav_home_url'    => [ 'label' => 'Home URL',    'default' => '/' ],
        'travzo_nav_blog_url'    => [ 'label' => 'Blog URL',    'default' => '/blog' ],
        'travzo_nav_about_url'   => [ 'label' => 'About URL',   'default' => '/about' ],
        'travzo_nav_contact_url' => [ 'label' => 'Contact URL', 'default' => '/contact' ],
    ];
    foreach ( $nav_url_fields as $key => $field ) {
        $wp_customize->add_setting( $key, [
            'default'           => $field['default'],
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $key, [
            'label'   => $field['label'],
            'section' => 'travzo_nav_labels',
            'type'    => 'url',
        ] );
    }
} );

// ── Homepage – Our Packages Section Labels (FIX 10) ──────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'travzo_packages_section', [
        'title' => 'Homepage – Our Packages Section',
        'panel' => 'travzo_panel',
    ] );
    $wp_customize->add_setting( 'travzo_packages_label',   [ 'default' => 'WHAT WE OFFER', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_packages_label',   [ 'label' => 'Section Label',   'section' => 'travzo_packages_section', 'type' => 'text' ] );
    $wp_customize->add_setting( 'travzo_packages_heading', [ 'default' => 'Our Packages',  'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_packages_heading', [ 'label' => 'Section Heading', 'section' => 'travzo_packages_section', 'type' => 'text' ] );
} );

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

// ── Header – Mega Menu View-All URLs + Nav note (FIX 5) ──────────────────────
add_action( 'customize_register', function ( $wp_customize ) {
    // Note in Header Settings pointing to Appearance → Menus
    $wp_customize->add_setting( 'travzo_nav_note', [ 'default' => '' ] );
    $wp_customize->add_control( 'travzo_nav_note', [
        'label'       => 'Navigation Menu',
        'description' => 'To edit nav labels go to Appearance → Menus and assign a menu to "Primary Navigation".',
        'section'     => 'travzo_header',
        'type'        => 'hidden',
    ] );

    // Mega menu view-all URLs
    $wp_customize->add_section( 'travzo_mega_menu', [
        'title' => 'Header – Mega Menu URLs',
        'panel' => 'travzo_panel',
    ] );
    $mega_url_fields = [
        'travzo_menu_group_all'      => 'Group Tours – View All URL',
        'travzo_menu_honeymoon_all'  => 'Honeymoon – View All URL',
        'travzo_menu_devotional_all' => 'Devotional – View All URL',
        'travzo_menu_wedding_all'    => 'Destination Wedding – View All URL',
        'travzo_menu_solo_all'       => 'Solo Trips – View All URL',
    ];
    foreach ( $mega_url_fields as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_mega_menu', 'type' => 'url' ] );
    }
    // Column 1 heading labels (packages column) for each mega menu
    $mega_heading_fields = [
        'travzo_mega_group_col1_heading' => 'Group Tours – Packages Column Heading',
        'travzo_mega_honey_col1_heading' => 'Honeymoon – Packages Column Heading',
        'travzo_mega_devot_col1_heading' => 'Devotional – Packages Column Heading',
        'travzo_mega_wed_col1_heading'   => 'Dest. Wedding – Packages Column Heading',
        'travzo_mega_solo_col1_heading'  => 'Solo Trips – Packages Column Heading',
    ];
    $mega_heading_defaults = [
        'travzo_mega_group_col1_heading' => 'Group Tours',
        'travzo_mega_honey_col1_heading' => 'Honeymoon Packages',
        'travzo_mega_devot_col1_heading' => 'Devotional Tours',
        'travzo_mega_wed_col1_heading'   => 'Destination Weddings',
        'travzo_mega_solo_col1_heading'  => 'Solo Trips',
    ];
    foreach ( $mega_heading_fields as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => $mega_heading_defaults[ $key ], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_mega_menu', 'type' => 'text' ] );
    }
} );

// ── Header – Mega Menu Destination Content ────────────────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'travzo_mega_content', [
        'title'       => 'Header – Mega Menu Destinations',
        'panel'       => 'travzo_panel',
        'priority'    => 31,
        'description' => 'Edit destination lists in header dropdowns. One item per line. Optional URL: Destination Name | https://yoursite.com/page',
    ] );

    $mega_fields = [
        'travzo_mega_group_col1_heading'     => [ 'label' => 'Group Tours – Col 1 Heading',       'default' => 'Featured Packages',    'type' => 'text' ],
        'travzo_mega_group_col2_heading'     => [ 'label' => 'Group Tours – Col 2 Heading',       'default' => 'South India',          'type' => 'text' ],
        'travzo_mega_group_col2_items'       => [ 'label' => 'Group Tours – Col 2 Items',         'default' => "Kerala Backwaters\nCoorg, Karnataka\nAndaman Islands\nOoty & Kodaikanal\nPondicherry\nGoa", 'type' => 'textarea' ],
        'travzo_mega_group_col3_heading'     => [ 'label' => 'Group Tours – Col 3 Heading',       'default' => 'North India',          'type' => 'text' ],
        'travzo_mega_group_col3_items'       => [ 'label' => 'Group Tours – Col 3 Items',         'default' => "Kashmir\nHimachal Pradesh\nUttarakhand\nRajasthan\nDelhi Agra Jaipur\nLadakh", 'type' => 'textarea' ],
        'travzo_mega_group_col4_heading'     => [ 'label' => 'Group Tours – Col 4 Heading',       'default' => 'International',        'type' => 'text' ],
        'travzo_mega_group_col4_items'       => [ 'label' => 'Group Tours – Col 4 Items',         'default' => "Thailand\nSingapore & Malaysia\nDubai & UAE\nSri Lanka\nEurope\nAustralia", 'type' => 'textarea' ],

        'travzo_mega_honeymoon_col2_heading' => [ 'label' => 'Honeymoon – Col 2 Heading',         'default' => 'India',                'type' => 'text' ],
        'travzo_mega_honeymoon_col2_items'   => [ 'label' => 'Honeymoon – Col 2 Items',           'default' => "Kerala\nGoa\nAndaman\nKashmir\nOoty & Kodaikanal\nManali", 'type' => 'textarea' ],
        'travzo_mega_honeymoon_col3_heading' => [ 'label' => 'Honeymoon – Col 3 Heading',         'default' => 'Asia & Islands',       'type' => 'text' ],
        'travzo_mega_honeymoon_col3_items'   => [ 'label' => 'Honeymoon – Col 3 Items',           'default' => "Maldives\nBali\nThailand\nSri Lanka\nMauritius\nSeychelles", 'type' => 'textarea' ],
        'travzo_mega_honeymoon_col4_heading' => [ 'label' => 'Honeymoon – Col 4 Heading',         'default' => 'Europe & Others',      'type' => 'text' ],
        'travzo_mega_honeymoon_col4_items'   => [ 'label' => 'Honeymoon – Col 4 Items',           'default' => "Paris\nSwitzerland\nItaly\nGreece\nDubai\nSpain", 'type' => 'textarea' ],

        'travzo_mega_devotional_col2_heading'=> [ 'label' => 'Devotional – Col 2 Heading',        'default' => 'South India',          'type' => 'text' ],
        'travzo_mega_devotional_col2_items'  => [ 'label' => 'Devotional – Col 2 Items',          'default' => "Tirupati\nRameshwaram\nMadurai\nSabarimala\nKanchipuram\nKashi Yatra", 'type' => 'textarea' ],
        'travzo_mega_devotional_col3_heading'=> [ 'label' => 'Devotional – Col 3 Heading',        'default' => 'North India',          'type' => 'text' ],
        'travzo_mega_devotional_col3_items'  => [ 'label' => 'Devotional – Col 3 Items',          'default' => "Varanasi\nHaridwar\nRishikesh\nChar Dham\nAyodhya\nShirdi", 'type' => 'textarea' ],

        'travzo_mega_wedding_col2_heading'   => [ 'label' => 'Dest. Wedding – Col 2 Heading',     'default' => 'India',                'type' => 'text' ],
        'travzo_mega_wedding_col2_items'     => [ 'label' => 'Dest. Wedding – Col 2 Items',       'default' => "Rajasthan\nGoa\nKerala\nUdaipur\nJaipur\nAndaman", 'type' => 'textarea' ],
        'travzo_mega_wedding_col3_heading'   => [ 'label' => 'Dest. Wedding – Col 3 Heading',     'default' => 'International',        'type' => 'text' ],
        'travzo_mega_wedding_col3_items'     => [ 'label' => 'Dest. Wedding – Col 3 Items',       'default' => "Bali\nThailand\nMaldives\nSri Lanka\nMalaysia\nDubai", 'type' => 'textarea' ],

        'travzo_mega_solo_col2_heading'      => [ 'label' => 'Solo Trips – Col 2 Heading',        'default' => 'Popular Destinations', 'type' => 'text' ],
        'travzo_mega_solo_col2_items'        => [ 'label' => 'Solo Trips – Col 2 Items',          'default' => "Solo Kerala\nSolo Himachal\nSolo Northeast\nSolo Bali\nSolo Thailand\nSolo Europe", 'type' => 'textarea' ],
    ];

    foreach ( $mega_fields as $key => $field ) {
        $wp_customize->add_setting( $key, [
            'default'           => $field['default'],
            'sanitize_callback' => $field['type'] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $key, [
            'label'   => $field['label'],
            'section' => 'travzo_mega_content',
            'type'    => $field['type'],
        ] );
    }
} );

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

    // About Page Hero
    $wp_customize->add_section( 'travzo_about_hero', [
        'title' => 'About Page – Hero',
        'panel' => 'travzo_panel',
    ] );
    $wp_customize->add_setting( 'travzo_about_hero_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travzo_about_hero_image', [
        'label' => 'Hero Background Image', 'section' => 'travzo_about_hero',
    ] ) );
    $wp_customize->add_setting( 'travzo_about_hero_title', [ 'default' => 'About Travzo Holidays', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_about_hero_title', [ 'label' => 'Page Title', 'section' => 'travzo_about_hero', 'type' => 'text' ] );
    $wp_customize->add_setting( 'travzo_about_hero_desc', [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_about_hero_desc', [ 'label' => 'Description', 'section' => 'travzo_about_hero', 'type' => 'text' ] );

    // Contact Page Hero
    $wp_customize->add_section( 'travzo_contact_hero', [
        'title' => 'Contact Page – Hero',
        'panel' => 'travzo_panel',
    ] );
    $wp_customize->add_setting( 'travzo_contact_hero_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travzo_contact_hero_image', [
        'label' => 'Hero Background Image', 'section' => 'travzo_contact_hero',
    ] ) );
    $wp_customize->add_setting( 'travzo_contact_hero_title', [ 'default' => 'Get In Touch', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_contact_hero_title', [ 'label' => 'Page Title', 'section' => 'travzo_contact_hero', 'type' => 'text' ] );
    $wp_customize->add_setting( 'travzo_contact_hero_desc', [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_contact_hero_desc', [ 'label' => 'Description', 'section' => 'travzo_contact_hero', 'type' => 'text' ] );

    // FAQ Page Hero
    $wp_customize->add_section( 'travzo_faq_hero', [
        'title' => 'FAQ Page – Hero',
        'panel' => 'travzo_panel',
    ] );
    $wp_customize->add_setting( 'travzo_faq_hero_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travzo_faq_hero_image', [
        'label' => 'Hero Background Image', 'section' => 'travzo_faq_hero',
    ] ) );
    $wp_customize->add_setting( 'travzo_faq_hero_title', [ 'default' => 'Frequently Asked Questions', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_faq_hero_title', [ 'label' => 'Page Title', 'section' => 'travzo_faq_hero', 'type' => 'text' ] );
    $wp_customize->add_setting( 'travzo_faq_hero_desc', [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_faq_hero_desc', [ 'label' => 'Description', 'section' => 'travzo_faq_hero', 'type' => 'text' ] );

    // Media Page Hero
    $wp_customize->add_section( 'travzo_media_hero', [
        'title' => 'Media Page – Hero',
        'panel' => 'travzo_panel',
    ] );
    $wp_customize->add_setting( 'travzo_media_hero_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travzo_media_hero_image', [
        'label' => 'Hero Background Image', 'section' => 'travzo_media_hero',
    ] ) );
    $wp_customize->add_setting( 'travzo_media_hero_title', [ 'default' => 'Media & Press', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_media_hero_title', [ 'label' => 'Page Title', 'section' => 'travzo_media_hero', 'type' => 'text' ] );
    $wp_customize->add_setting( 'travzo_media_hero_desc', [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_media_hero_desc', [ 'label' => 'Description', 'section' => 'travzo_media_hero', 'type' => 'text' ] );

    // Blog List Page Hero
    $wp_customize->add_section( 'travzo_blog_hero', [
        'title' => 'Blog Page – Hero',
        'panel' => 'travzo_panel',
    ] );
    $wp_customize->add_setting( 'travzo_blog_hero_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travzo_blog_hero_image', [
        'label' => 'Hero Background Image', 'section' => 'travzo_blog_hero',
    ] ) );
    $wp_customize->add_setting( 'travzo_blog_hero_title', [ 'default' => 'Travel Stories & Tips', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_blog_hero_title', [ 'label' => 'Page Title', 'section' => 'travzo_blog_hero', 'type' => 'text' ] );
    $wp_customize->add_setting( 'travzo_blog_hero_desc', [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_blog_hero_desc', [ 'label' => 'Description', 'section' => 'travzo_blog_hero', 'type' => 'text' ] );

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
// META BOXES – PACKAGE POST TYPE
// ══════════════════════════════════════════════════════════════════════════════
add_action( 'add_meta_boxes', function () {
    add_meta_box( 'travzo_package_details', 'Package Details',
        'travzo_package_details_cb', 'package', 'normal', 'high' );
    add_meta_box( 'travzo_package_content', 'Package Content (Itinerary, Inclusions, Hotels)',
        'travzo_package_content_cb', 'package', 'normal', 'default' );
    add_meta_box( 'travzo_package_pricing', 'Package Pricing',
        'travzo_package_pricing_cb', 'package', 'normal', 'default' );
} );

function travzo_package_details_cb( $post ) {
    wp_nonce_field( 'travzo_package_save', 'travzo_package_nonce' );
    $fields = [
        '_package_type'         => [ 'label' => 'Package Type', 'type' => 'select', 'options' => [ 'Group Tour', 'Honeymoon', 'Solo Trip', 'Devotional', 'Destination Wedding', 'International' ] ],
        '_package_price'        => [ 'label' => 'Starting Price (numbers only, e.g. 15000)', 'type' => 'text' ],
        '_package_duration'     => [ 'label' => 'Duration (e.g. 4 Nights / 5 Days)', 'type' => 'text' ],
        '_package_destinations' => [ 'label' => 'Destinations Covered', 'type' => 'text' ],
        '_package_group_size'   => [ 'label' => 'Group Size (e.g. 2-15 People)', 'type' => 'text' ],
    ];
    foreach ( $fields as $key => $field ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">' . esc_html( $field['label'] ) . '</label>';
        if ( $field['type'] === 'select' ) {
            echo '<select name="' . esc_attr( $key ) . '" style="width:100%">';
            foreach ( $field['options'] as $opt ) {
                echo '<option value="' . esc_attr( $opt ) . '"' . selected( $val, $opt, false ) . '>' . esc_html( $opt ) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<input type="text" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" style="width:100%">';
        }
        echo '</p>';
    }
}

function travzo_package_content_cb( $post ) {
    $fields = [
        '_package_highlights' => [
            'label' => 'Package Highlights',
            'help'  => 'One highlight per line. Example:<br>Expert local guides<br>All meals included<br>Airport transfers',
            'rows'  => 6,
        ],
        '_package_inclusions' => [
            'label' => "Inclusions (What's Included)",
            'help'  => 'One item per line.',
            'rows'  => 6,
        ],
        '_package_exclusions' => [
            'label' => "Exclusions (What's Not Included)",
            'help'  => 'One item per line.',
            'rows'  => 6,
        ],
        '_package_itinerary' => [
            'label' => 'Day by Day Itinerary',
            'help'  => 'One day per line in this format:<br><strong>Day 1: Arrival | Arrive at airport, transfer to hotel, welcome dinner</strong>',
            'rows'  => 10,
        ],
        '_package_hotels' => [
            'label' => 'Hotel Details',
            'help'  => 'One hotel per line: <strong>Hotel Name | Stars (3/4/5) | Location | Room Type</strong>',
            'rows'  => 5,
        ],
    ];
    // Download URL (separate text input)
    $dl_url = get_post_meta( $post->ID, '_package_download_url', true );
    echo '<p>';
    echo '<label style="font-weight:600;display:block;margin-bottom:4px">Download Itinerary PDF URL</label>';
    echo '<small style="color:#666;display:block;margin-bottom:6px">Paste the full URL of the PDF file to download.</small>';
    echo '<input type="url" name="_package_download_url" value="' . esc_attr( $dl_url ) . '" style="width:100%" placeholder="https://example.com/itinerary.pdf">';
    echo '</p>';
    foreach ( $fields as $key => $field ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<p>';
        echo '<label style="font-weight:600;display:block;margin-bottom:4px">' . esc_html( $field['label'] ) . '</label>';
        echo '<small style="color:#666;display:block;margin-bottom:6px">' . $field['help'] . '</small>';
        echo '<textarea name="' . esc_attr( $key ) . '" rows="' . intval( $field['rows'] ) . '" style="width:100%">' . esc_textarea( $val ) . '</textarea>';
        echo '</p>';
    }
}

function travzo_package_pricing_cb( $post ) {
    $pricing_fields = [
        '_price_standard_twin'   => 'Standard Room - Twin Sharing (₹)',
        '_price_standard_triple' => 'Standard Room - Triple Sharing (₹)',
        '_price_deluxe_twin'     => 'Deluxe Room - Twin Sharing (₹)',
        '_price_deluxe_triple'   => 'Deluxe Room - Triple Sharing (₹)',
        '_price_premium_twin'    => 'Premium Room - Twin Sharing (₹)',
        '_price_premium_triple'  => 'Premium Room - Triple Sharing (₹)',
        '_price_child_bed'       => 'Child with Extra Bed (₹)',
        '_price_child_no_bed'    => 'Child without Extra Bed (₹)',
    ];
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">';
    foreach ( $pricing_fields as $key => $label ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">' . esc_html( $label ) . '</label>';
        echo '<input type="text" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" placeholder="e.g. 25000" style="width:100%"></p>';
    }
    echo '</div>';
}

add_action( 'save_post_package', function ( $post_id ) {
    if ( ! isset( $_POST['travzo_package_nonce'] ) ) return;
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_package_nonce'] ) ), 'travzo_package_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    $all_fields = [
        '_package_type', '_package_price', '_package_duration',
        '_package_destinations', '_package_group_size',
        '_package_highlights', '_package_inclusions', '_package_exclusions',
        '_package_itinerary', '_package_hotels', '_package_download_url',
        '_price_standard_twin', '_price_standard_triple',
        '_price_deluxe_twin', '_price_deluxe_triple',
        '_price_premium_twin', '_price_premium_triple',
        '_price_child_bed', '_price_child_no_bed',
    ];
    foreach ( $all_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
        }
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

// ══════════════════════════════════════════════════════════════════════════════
// META BOXES – PAGE TEMPLATES
// ══════════════════════════════════════════════════════════════════════════════
add_action( 'add_meta_boxes', function () {
    add_meta_box( 'travzo_homepage_hero',          'Homepage – Hero Section',                 'travzo_homepage_hero_cb',         'page', 'normal', 'high' );
    add_meta_box( 'travzo_homepage_about',         'Homepage – About Us',                     'travzo_homepage_about_cb',        'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_stats',         'Homepage – Stats Bar',                    'travzo_homepage_stats_cb',        'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_whyus',         'Homepage – Why Choose Us',                'travzo_homepage_whyus_cb',        'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_contact',       'Homepage – Contact Section',              'travzo_homepage_contact_cb',      'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_testimonials', 'Homepage – Testimonials',                 'travzo_homepage_testimonials_cb', 'page', 'normal', 'default' );
    add_meta_box( 'travzo_homepage_tiles',        'Homepage – Package Tiles',                'travzo_homepage_tiles_cb',        'page', 'normal', 'default' );
    add_meta_box( 'travzo_about_content',         'About Page Content',                      'travzo_about_content_cb',         'page', 'normal', 'high' );
    add_meta_box( 'travzo_contact_content',       'Contact Page – Branch Offices',           'travzo_contact_content_cb',       'page', 'normal', 'default' );
    add_meta_box( 'travzo_faq_content',           'FAQ Content',                             'travzo_faq_content_cb',           'page', 'normal', 'high' );
    add_meta_box( 'travzo_media_content',         'Media Page – Videos & Press',             'travzo_media_content_cb',         'page', 'normal', 'default' );
} );

// Show only relevant meta boxes per page/template
add_action( 'do_meta_boxes', function () {
    global $post;
    if ( ! $post ) return;

    $template  = get_page_template_slug( $post->ID );
    $is_front  = ( (int) $post->ID === (int) get_option( 'page_on_front' ) );
    if ( ! $is_front ) {
        remove_meta_box( 'travzo_homepage_hero',         'page', 'normal' );
        remove_meta_box( 'travzo_homepage_about',        'page', 'normal' );
        remove_meta_box( 'travzo_homepage_stats',        'page', 'normal' );
        remove_meta_box( 'travzo_homepage_whyus',        'page', 'normal' );
        remove_meta_box( 'travzo_homepage_contact',      'page', 'normal' );
        remove_meta_box( 'travzo_homepage_testimonials', 'page', 'normal' );
        remove_meta_box( 'travzo_homepage_tiles',        'page', 'normal' );
    }
    if ( $template !== 'page-about.php' ) {
        remove_meta_box( 'travzo_about_content', 'page', 'normal' );
    }
    if ( $template !== 'page-contact.php' ) {
        remove_meta_box( 'travzo_contact_content', 'page', 'normal' );
    }
    if ( $template !== 'page-faq.php' ) {
        remove_meta_box( 'travzo_faq_content', 'page', 'normal' );
    }
    if ( $template !== 'page-media.php' ) {
        remove_meta_box( 'travzo_media_content', 'page', 'normal' );
    }
} );

function travzo_homepage_hero_cb( $post ) {
    $badge     = get_post_meta( $post->ID, '_homepage_hero_badge', true );
    $heading   = get_post_meta( $post->ID, '_homepage_hero_heading', true );
    $subtext   = get_post_meta( $post->ID, '_homepage_hero_subtext', true );
    $btn1_text = get_post_meta( $post->ID, '_homepage_hero_btn1_text', true );
    $btn1_url  = get_post_meta( $post->ID, '_homepage_hero_btn1_url', true );
    $btn2_text = get_post_meta( $post->ID, '_homepage_hero_btn2_text', true );
    $btn2_url  = get_post_meta( $post->ID, '_homepage_hero_btn2_url', true );
    $image     = get_post_meta( $post->ID, '_homepage_hero_image', true );

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

    echo '<script>
    jQuery(function($) {
        $("#hero-home-upload-btn").on("click", function() {
            var frame = wp.media({ title: "Select Hero Image", button: { text: "Use Image" }, multiple: false });
            frame.on("select", function() {
                var url = frame.state().get("selection").first().toJSON().url;
                $("#hero-home-image-input").val(url);
                $("#hero-home-preview").html(\'<img src="\' + url + \'" style="max-width:300px;max-height:150px;border-radius:8px;border:1px solid #e0e0e0">\');
            });
            frame.open();
        });
        $("#hero-home-remove-btn").on("click", function() {
            $("#hero-home-image-input").val("");
            $("#hero-home-preview").html("");
        });
    });
    </script>';
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

    echo '<p style="color:#666;margin-bottom:16px">Text content for the homepage enquiry/contact section. The form itself is configured in Customizer → WPForms Integration.</p>';

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
    $tiles = get_post_meta( $post->ID, '_package_tiles_v2', true );
    if ( ! is_array( $tiles ) ) {
        $tiles = [];
    }
    if ( empty( $tiles ) ) {
        $tiles = [
            [ 'name' => 'Group Tours',          'type' => 'Group Tour',         'image' => '' ],
            [ 'name' => 'Honeymoon Packages',   'type' => 'Honeymoon',          'image' => '' ],
            [ 'name' => 'Solo Trips',           'type' => 'Solo Trip',          'image' => '' ],
            [ 'name' => 'Devotional Tours',     'type' => 'Devotional',         'image' => '' ],
            [ 'name' => 'Destination Weddings', 'type' => 'Destination Wedding', 'image' => '' ],
            [ 'name' => 'International',        'type' => 'International',      'image' => '' ],
        ];
    }

    wp_nonce_field( 'travzo_tiles_save', 'travzo_tiles_nonce' );

    echo '<p style="color:#666;margin-bottom:16px">Each tile links to its package type. Package count is auto-calculated from live packages. Add, remove or reorder tiles.</p>';
    echo '<div id="travzo-tiles-container">';

    foreach ( $tiles as $i => $tile ) {
        $t_name  = esc_attr( $tile['name']  ?? '' );
        $t_type  = $tile['type']  ?? '';
        $t_image = esc_attr( $tile['image'] ?? '' );

        echo '<div class="travzo-tile-row" style="display:grid;grid-template-columns:2fr 2fr 3fr auto;gap:12px;align-items:center;padding:12px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:6px;margin-bottom:8px">';

        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">TILE NAME</label>';
        echo '<input type="text" name="tiles_name[]" value="' . $t_name . '" placeholder="e.g. Group Tours" style="width:100%"></div>';

        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">PACKAGE TYPE</label>';
        echo '<select name="tiles_type[]" style="width:100%">';
        $type_options = [ 'Group Tour', 'Honeymoon', 'Solo Trip', 'Devotional', 'Destination Wedding', 'International' ];
        foreach ( $type_options as $opt ) {
            echo '<option value="' . esc_attr( $opt ) . '"' . selected( $t_type, $opt, false ) . '>' . esc_html( $opt ) . '</option>';
        }
        echo '</select></div>';

        echo '<div><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">BACKGROUND IMAGE URL</label>';
        echo '<div style="display:flex;gap:6px">';
        echo '<input type="url" name="tiles_image[]" value="' . $t_image . '" placeholder="https://... or leave blank for colour" style="flex:1" class="travzo-tile-image-input">';
        echo '<button type="button" class="button travzo-upload-btn">Upload</button>';
        echo '</div></div>';

        echo '<div style="text-align:center"><label style="display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px">REMOVE</label>';
        echo '<button type="button" class="button travzo-remove-tile" style="color:#dc2626">&#x2715;</button></div>';

        echo '</div>';
    }

    echo '</div>';
    echo '<button type="button" id="travzo-add-tile" class="button button-secondary" style="margin-top:12px">+ Add Tile</button>';

    echo '<script>
    jQuery(function($) {
        $(document).on("click", ".travzo-upload-btn", function() {
            var input = $(this).prev("input");
            var frame = wp.media({ title: "Select Image", button: { text: "Use Image" }, multiple: false });
            frame.on("select", function() {
                input.val(frame.state().get("selection").first().toJSON().url);
            });
            frame.open();
        });
        $(document).on("click", ".travzo-remove-tile", function() {
            if ($(".travzo-tile-row").length > 1) {
                $(this).closest(".travzo-tile-row").remove();
            } else {
                alert("You need at least one tile.");
            }
        });
        var typeOptions = ["Group Tour","Honeymoon","Solo Trip","Devotional","Destination Wedding","International"];
        $("#travzo-add-tile").on("click", function() {
            var opts = typeOptions.map(function(t){ return "<option value=\'"+t+"\'>"+t+"</option>"; }).join("");
            var row = "<div class=\'travzo-tile-row\' style=\'display:grid;grid-template-columns:2fr 2fr 3fr auto;gap:12px;align-items:center;padding:12px;background:#f9f9f9;border:1px solid #e0e0e0;border-radius:6px;margin-bottom:8px\'>"
                + "<div><label style=\'display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px\'>TILE NAME</label><input type=\'text\' name=\'tiles_name[]\' placeholder=\'e.g. Group Tours\' style=\'width:100%\'></div>"
                + "<div><label style=\'display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px\'>PACKAGE TYPE</label><select name=\'tiles_type[]\' style=\'width:100%\'>"+opts+"</select></div>"
                + "<div><label style=\'display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px\'>BACKGROUND IMAGE URL</label><div style=\'display:flex;gap:6px\'><input type=\'url\' name=\'tiles_image[]\' placeholder=\'https://...\' style=\'flex:1\' class=\'travzo-tile-image-input\'><button type=\'button\' class=\'button travzo-upload-btn\'>Upload</button></div></div>"
                + "<div style=\'text-align:center\'><label style=\'display:block;font-size:11px;font-weight:600;color:#555;margin-bottom:4px\'>REMOVE</label><button type=\'button\' class=\'button travzo-remove-tile\' style=\'color:#dc2626\'>&#x2715;</button></div>"
                + "</div>";
            $("#travzo-tiles-container").append(row);
        });
    });
    </script>';
}

function travzo_about_content_cb( $post ) {
    wp_nonce_field( 'travzo_page_save', 'travzo_page_nonce' );
    $fields = [
        '_about_story_heading'  => [ 'label' => 'Our Story Heading', 'type' => 'text' ],
        '_about_story_text'     => [ 'label' => 'Our Story Text',    'type' => 'textarea', 'rows' => 8 ],
        '_about_story_image'    => [ 'label' => 'Story Image URL',   'type' => 'url' ],
        '_about_team'           => [
            'label' => 'Team Members',
            'type'  => 'textarea',
            'rows'  => 6,
            'help'  => 'One member per line. Format: <strong>Name | Role | Photo URL | Bio</strong>',
        ],
        '_about_awards'         => [
            'label' => 'Awards & Achievements',
            'type'  => 'textarea',
            'rows'  => 6,
            'help'  => 'One award per line. Format: <strong>Award Name | Year | Image URL</strong>',
        ],
        '_about_accreditations' => [
            'label' => 'Accreditation Partners',
            'type'  => 'textarea',
            'rows'  => 4,
            'help'  => 'One per line. Format: <strong>Name | Logo URL</strong>',
        ],
    ];
    foreach ( $fields as $key => $field ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">' . esc_html( $field['label'] ) . '</label>';
        if ( ! empty( $field['help'] ) ) {
            echo '<small style="color:#666;display:block;margin-bottom:6px">' . $field['help'] . '</small>';
        }
        if ( $field['type'] === 'textarea' ) {
            echo '<textarea name="' . esc_attr( $key ) . '" rows="' . intval( $field['rows'] ?? 4 ) . '" style="width:100%">' . esc_textarea( $val ) . '</textarea>';
        } else {
            echo '<input type="' . esc_attr( $field['type'] ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" style="width:100%">';
        }
        echo '</p>';
    }
}

function travzo_contact_content_cb( $post ) {
    $val = get_post_meta( $post->ID, '_branches', true );
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Branch Offices</label>';
    echo '<small style="color:#666;display:block;margin-bottom:8px">One branch per line. Format: <strong>City | Address | Phone</strong><br>';
    echo 'Example: Coimbatore | 123 Avinashi Road, Peelamedu 641004 | +91 98765 43210</small>';
    echo '<textarea name="_branches" rows="10" style="width:100%">' . esc_textarea( $val ) . '</textarea></p>';
}

function travzo_faq_content_cb( $post ) {
    $val = get_post_meta( $post->ID, '_faqs', true );
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">FAQs</label>';
    echo '<small style="color:#666;display:block;margin-bottom:8px">One FAQ per line. Format: <strong>Question | Answer</strong><br>';
    echo 'Example: How do I book a package? | Fill the enquiry form and we will contact you within 24 hours.</small>';
    echo '<textarea name="_faqs" rows="15" style="width:100%">' . esc_textarea( $val ) . '</textarea></p>';
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

// Save all page meta
add_action( 'save_post_page', function ( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // Save generic page fields (About, Contact, FAQ, Media) — guarded by their own nonce
    if ( isset( $_POST['travzo_page_nonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_page_nonce'] ) ), 'travzo_page_save' ) ) {
        $page_fields = [
            '_about_story_heading', '_about_story_text', '_about_story_image',
            '_about_team', '_about_awards', '_about_accreditations',
            '_branches', '_faqs',
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
        $names  = isset( $_POST['tiles_name'] )  ? (array) $_POST['tiles_name']  : [];
        $types  = isset( $_POST['tiles_type'] )  ? (array) $_POST['tiles_type']  : [];
        $images = isset( $_POST['tiles_image'] ) ? (array) $_POST['tiles_image'] : [];
        $tiles_v2 = [];
        foreach ( $names as $i => $name ) {
            $name = sanitize_text_field( wp_unslash( $name ) );
            if ( '' === trim( $name ) ) {
                continue;
            }
            $tiles_v2[] = [
                'name'  => $name,
                'type'  => sanitize_text_field( wp_unslash( $types[ $i ] ?? '' ) ),
                'image' => esc_url_raw( wp_unslash( $images[ $i ] ?? '' ) ),
            ];
        }
        update_post_meta( $post_id, '_package_tiles_v2', $tiles_v2 );
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
// WPFORMS HELPER
// ══════════════════════════════════════════════════════════════════════════════
/**
 * Render a WPForms form by Customizer form key, or fall back to custom HTML.
 * If $form_key_or_id is a string key (e.g. 'travzo_form_enquiry'), the form ID
 * is read from the Customizer. Pass an integer to use a form ID directly.
 *
 * @param string|int $form_key_or_id  Customizer key or direct WPForms form ID.
 * @param string     $fallback_html   Raw HTML fallback if WPForms unavailable.
 */
function travzo_render_form( $form_key_or_id, $fallback_html = '' ) {
    if ( is_string( $form_key_or_id ) ) {
        $form_id = intval( get_theme_mod( $form_key_or_id, 0 ) );
    } else {
        $form_id = intval( $form_key_or_id );
    }

    if ( $form_id && function_exists( 'wpforms' ) ) {
        echo do_shortcode( '[wpforms id="' . $form_id . '"]' );
    } elseif ( $fallback_html ) {
        echo $fallback_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
        echo '<p style="padding:20px;background:#f5f5f5;border-radius:8px;color:#666">';
        echo 'Configure the form: Go to <strong>Appearance → Customize → WPForms Integration</strong> and enter the form ID, or install the WPForms plugin.';
        echo '</p>';
    }
}

/**
 * Default HTML enquiry form for the homepage (used as fallback until WPForms is set up).
 */
function travzo_default_enquiry_form() {
    ob_start(); ?>
    <form method="POST" class="contact-form enquiry-form" novalidate>
        <?php wp_nonce_field( 'travzo_enquiry_form', 'travzo_nonce' ); ?>
        <input type="hidden" name="travzo_enquiry" value="1">

        <div class="cform-row">
            <div class="cform-group">
                <label for="eq_name">Your Name <span aria-hidden="true">*</span></label>
                <input type="text" id="eq_name" name="enquiry_name" required placeholder="Ramesh Kumar">
            </div>
            <div class="cform-group">
                <label for="eq_city">City <span aria-hidden="true">*</span></label>
                <input type="text" id="eq_city" name="enquiry_city" required placeholder="Coimbatore">
            </div>
        </div>

        <div class="cform-row">
            <div class="cform-group">
                <label for="eq_email">Email <span aria-hidden="true">*</span></label>
                <input type="email" id="eq_email" name="enquiry_email" required placeholder="your@email.com">
            </div>
            <div class="cform-group">
                <label for="eq_phone">Phone <span aria-hidden="true">*</span></label>
                <input type="tel" id="eq_phone" name="enquiry_phone" required placeholder="+91 XXXXX XXXXX">
            </div>
        </div>

        <div class="cform-row">
            <div class="cform-group">
                <label for="eq_dest">Destination</label>
                <input type="text" id="eq_dest" name="enquiry_destination" placeholder="Bali, Kerala, Europe">
            </div>
            <div class="cform-row__half">
                <div class="cform-group">
                    <label for="eq_date">Travel Date</label>
                    <input type="date" id="eq_date" name="enquiry_date">
                </div>
                <div class="cform-group">
                    <label for="eq_people">No. of People</label>
                    <select id="eq_people" name="enquiry_people">
                        <option value="">Select</option>
                        <?php for ( $i = 1; $i <= 15; $i++ ) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                        <option value="15+">15+</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="cform-group">
            <label for="eq_trip">Trip Type</label>
            <select id="eq_trip" name="enquiry_trip_type">
                <option value="">Select trip type</option>
                <option value="Honeymoon">Honeymoon</option>
                <option value="Group Tour">Group Tour</option>
                <option value="Solo Trip">Solo Trip</option>
                <option value="Devotional">Devotional</option>
                <option value="Destination Wedding">Destination Wedding</option>
                <option value="Family Trip">Family Trip</option>
                <option value="Corporate Trip">Corporate Trip</option>
            </select>
        </div>

        <button type="submit" class="btn btn--gold btn--full">
            Send Enquiry
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        </button>
    </form>
    <?php return ob_get_clean();
}

/**
 * Default HTML quick enquiry form for the package sidebar.
 *
 * @param int $pkg_id  Package post ID.
 */
function travzo_default_package_form( $pkg_id = 0 ) {
    $pkg_name = $pkg_id ? get_the_title( $pkg_id ) : '';
    ob_start(); ?>
    <form method="POST" class="sidebar-enquiry-form">
        <?php wp_nonce_field( 'travzo_package_enquiry_form', 'travzo_package_nonce' ); ?>
        <input type="hidden" name="travzo_package_enquiry" value="1">
        <input type="hidden" name="pkg_package_name" value="<?php echo esc_attr( $pkg_name ); ?>">
        <div class="sidebar-form-field"><input type="text" name="pkg_name" placeholder="Your Name *" required></div>
        <div class="sidebar-form-field"><input type="tel" name="pkg_phone" placeholder="Phone Number *" required></div>
        <div class="sidebar-form-field"><input type="date" name="pkg_date"></div>
        <div class="sidebar-form-field"><input type="number" name="pkg_people" placeholder="No. of People" min="1"></div>
        <button type="submit" class="btn btn--gold btn--full">Enquire Now</button>
    </form>
    <?php return ob_get_clean();
}
