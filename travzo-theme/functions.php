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
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
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
    $footer_fields = [
        'travzo_footer_tagline'   => 'Footer Tagline',
        'travzo_footer_address'   => 'Footer Address',
        'travzo_footer_hours'     => 'Footer Hours',
        'travzo_footer_copyright' => 'Copyright Text',
    ];
    foreach ( $footer_fields as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_footer', 'type' => 'text' ] );
    }

    // ── SECTION: Homepage Hero ────────────────────────────────────────────────
    $wp_customize->add_section( 'travzo_hero', [
        'title' => 'Homepage - Hero Section',
        'panel' => 'travzo_panel',
    ] );
    $hero_text_fields = [
        'travzo_hero_badge'     => 'Badge Text',
        'travzo_hero_heading'   => 'Main Heading',
        'travzo_hero_subtext'   => 'Sub Text',
        'travzo_hero_btn1_text' => 'Primary Button Text',
        'travzo_hero_btn1_url'  => 'Primary Button URL',
        'travzo_hero_btn2_text' => 'Secondary Button Text',
        'travzo_hero_btn2_url'  => 'Secondary Button URL',
    ];
    foreach ( $hero_text_fields as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_hero', 'type' => 'text' ] );
    }
    $wp_customize->add_setting( 'travzo_hero_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travzo_hero_image', [
        'label'   => 'Hero Background Image',
        'section' => 'travzo_hero',
    ] ) );

    // ── SECTION: Homepage Stats ───────────────────────────────────────────────
    $wp_customize->add_section( 'travzo_stats', [
        'title' => 'Homepage - Stats Bar',
        'panel' => 'travzo_panel',
    ] );
    for ( $i = 1; $i <= 4; $i++ ) {
        $wp_customize->add_setting( "travzo_stat_{$i}_number", [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( "travzo_stat_{$i}_number", [ 'label' => "Stat {$i} Number (e.g. 500+)", 'section' => 'travzo_stats', 'type' => 'text' ] );
        $wp_customize->add_setting( "travzo_stat_{$i}_label", [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( "travzo_stat_{$i}_label", [ 'label' => "Stat {$i} Label (e.g. Happy Travellers)", 'section' => 'travzo_stats', 'type' => 'text' ] );
    }

    // ── SECTION: Homepage About Snippet ──────────────────────────────────────
    $wp_customize->add_section( 'travzo_about_snippet', [
        'title' => 'Homepage - About Snippet',
        'panel' => 'travzo_panel',
    ] );
    $about_text_fields = [
        'travzo_about_label'   => 'Section Label',
        'travzo_about_heading' => 'Heading',
        'travzo_about_text'    => 'Body Text',
        'travzo_about_feat1'   => 'Feature 1',
        'travzo_about_feat2'   => 'Feature 2',
        'travzo_about_feat3'   => 'Feature 3',
    ];
    foreach ( $about_text_fields as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_about_snippet', 'type' => 'text' ] );
    }
    $wp_customize->add_setting( 'travzo_about_image', [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travzo_about_image', [
        'label'   => 'About Section Image',
        'section' => 'travzo_about_snippet',
    ] ) );

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

// ── Homepage – Why Choose Us ──────────────────────────────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'travzo_why_us', [
        'title' => 'Homepage – Why Choose Us',
        'panel' => 'travzo_panel',
    ] );
    $wp_customize->add_setting( 'travzo_why_us_label',   [ 'default' => 'WHY TRAVZO',          'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_why_us_label',   [ 'label' => 'Section Label',   'section' => 'travzo_why_us', 'type' => 'text' ] );
    $wp_customize->add_setting( 'travzo_why_us_heading', [ 'default' => 'Why Travel With Us', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'travzo_why_us_heading', [ 'label' => 'Section Heading', 'section' => 'travzo_why_us', 'type' => 'text' ] );
    $wp_customize->add_setting( 'travzo_why_us_tiles', [ 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ] );
    $wp_customize->add_control( 'travzo_why_us_tiles', [
        'label'       => 'Feature Tiles',
        'description' => 'One tile per line. Format: Heading | Description (icon auto-assigned by order)',
        'section'     => 'travzo_why_us',
        'type'        => 'textarea',
    ] );
}, 30 );

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
} );

// ── Homepage – Contact Section ────────────────────────────────────────────────
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'travzo_contact_section', [
        'title' => 'Homepage – Contact Section',
        'panel' => 'travzo_panel',
    ] );
    foreach ( [
        'travzo_contact_label'   => 'Section Label',
        'travzo_contact_heading' => 'Section Heading',
        'travzo_contact_desc'    => 'Description',
    ] as $key => $label ) {
        $wp_customize->add_setting( $key, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $key, [ 'label' => $label, 'section' => 'travzo_contact_section', 'type' => 'text' ] );
    }
}, 40 );

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
 * Get hero data for inner page templates.
 *
 * @param int $post_id
 * @return array { image, heading, subtext }
 */
function travzo_get_hero( $post_id ) {
    return [
        'image'   => get_post_meta( $post_id, '_hero_image',   true ),
        'heading' => get_post_meta( $post_id, '_hero_heading', true ),
        'subtext' => get_post_meta( $post_id, '_hero_subtext', true ),
    ];
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
    add_meta_box( 'travzo_page_hero',             'Page Hero Section',                      'travzo_page_hero_cb',             'page', 'normal', 'high' );
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
    $is_inner  = in_array( $template, [ 'page-about.php', 'page-contact.php', 'page-faq.php', 'page-media.php' ], true );

    if ( ! $is_front ) {
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
    if ( $is_front || ! $is_inner ) {
        remove_meta_box( 'travzo_page_hero', 'page', 'normal' );
    }
} );

function travzo_page_hero_cb( $post ) {
    wp_nonce_field( 'travzo_page_save', 'travzo_page_nonce' );
    $hero_image   = get_post_meta( $post->ID, '_hero_image',   true );
    $hero_heading = get_post_meta( $post->ID, '_hero_heading', true );
    $hero_subtext = get_post_meta( $post->ID, '_hero_subtext', true );
    ?>
    <p>
        <label style="font-weight:600;display:block;margin-bottom:4px">Hero Background Image URL</label>
        <input type="url" name="_hero_image" value="<?php echo esc_attr( $hero_image ); ?>"
               placeholder="https://… paste image URL or use Upload" style="width:calc(100% - 110px);margin-right:8px">
        <a href="#" onclick="travzoMediaUpload('_hero_image');return false;" class="button">Upload Image</a>
    </p>
    <p>
        <label style="font-weight:600;display:block;margin-bottom:4px">Page Heading</label>
        <input type="text" name="_hero_heading" value="<?php echo esc_attr( $hero_heading ); ?>" style="width:100%">
    </p>
    <p>
        <label style="font-weight:600;display:block;margin-bottom:4px">Page Subtext</label>
        <input type="text" name="_hero_subtext" value="<?php echo esc_attr( $hero_subtext ); ?>" style="width:100%">
    </p>
    <script>
    function travzoMediaUpload(fieldName) {
        var frame = wp.media({ title: 'Select Image', button: { text: 'Use Image' }, multiple: false });
        frame.on('select', function () {
            var att = frame.state().get('selection').first().toJSON();
            document.querySelector('input[name="' + fieldName + '"]').value = att.url;
        });
        frame.open();
    }
    </script>
    <?php
}

function travzo_homepage_testimonials_cb( $post ) {
    $val = get_post_meta( $post->ID, '_testimonials', true );
    echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">Testimonials</label>';
    echo '<small style="color:#666;display:block;margin-bottom:8px">One testimonial per line. Format: <strong>Customer Name | Trip Taken | Quote text</strong><br>';
    echo 'Example: Priya &amp; Arjun | Maldives Honeymoon | Travzo made our trip magical!</small>';
    echo '<textarea name="_testimonials" rows="8" style="width:100%">' . esc_textarea( $val ) . '</textarea></p>';
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
    if ( ! isset( $_POST['travzo_page_nonce'] ) ) return;
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_page_nonce'] ) ), 'travzo_page_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    $page_fields = [
        '_hero_image', '_hero_heading', '_hero_subtext',
        '_testimonials',
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
    <form method="POST" class="enquiry-form">
        <?php wp_nonce_field( 'travzo_enquiry_form', 'travzo_nonce' ); ?>
        <input type="hidden" name="travzo_enquiry" value="1">
        <div class="form-row">
            <div class="form-group"><label>Your Name *</label><input type="text" name="enquiry_name" required placeholder="Ramesh Kumar"></div>
            <div class="form-group"><label>City *</label><input type="text" name="enquiry_city" required placeholder="Coimbatore"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Email *</label><input type="email" name="enquiry_email" required placeholder="your@email.com"></div>
            <div class="form-group"><label>Phone *</label><input type="tel" name="enquiry_phone" required placeholder="+91 XXXXX XXXXX"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Destination</label><input type="text" name="enquiry_destination" placeholder="Bali, Kerala, Europe"></div>
            <div class="form-group"><label>Travel Date</label><input type="date" name="enquiry_date"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>No. of People</label><input type="number" name="enquiry_people" min="1" placeholder="4"></div>
            <div class="form-group"><label>Trip Type</label>
                <select name="enquiry_trip_type">
                    <option value="">Select Type</option>
                    <option>Honeymoon</option><option>Group Tour</option><option>Solo Trip</option>
                    <option>Devotional</option><option>Destination Wedding</option>
                    <option>Family Trip</option><option>Corporate Trip</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn--gold btn--full">Send Enquiry</button>
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
