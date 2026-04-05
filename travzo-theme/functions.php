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

    wp_enqueue_style(
        'travzo-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        filemtime( get_template_directory() . '/assets/css/main.css' )
    );

    wp_enqueue_script(
        'travzo-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/main.js' ),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'travzo_enqueue_scripts' );

// ══════════════════════════════════════════════════════════════════════════════
// THEME SUPPORT
// ══════════════════════════════════════════════════════════════════════════════
function travzo_theme_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
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
// ACF OPTIONS PAGE
// ══════════════════════════════════════════════════════════════════════════════
function travzo_register_acf_options_page() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( [
        'page_title'  => __( 'Travzo Settings', 'travzo' ),
        'menu_title'  => __( 'Travzo Settings', 'travzo' ),
        'menu_slug'   => 'travzo-settings',
        'capability'  => 'manage_options',
        'redirect'    => false,
        'icon_url'    => 'dashicons-palmtree',
        'position'    => 2,
    ] );
}
add_action( 'acf/init', 'travzo_register_acf_options_page' );

// ══════════════════════════════════════════════════════════════════════════════
// ACF LOCAL FIELD GROUPS
// ══════════════════════════════════════════════════════════════════════════════
function travzo_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 1 – HOMEPAGE HERO
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'      => 'group_homepage_hero',
        'title'    => __( 'Homepage – Hero Section', 'travzo' ),
        'fields'   => [
            [
                'key'           => 'field_hero_image',
                'label'         => __( 'Hero Background Image', 'travzo' ),
                'name'          => 'hero_image',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ],
            [
                'key'           => 'field_hero_badge_text',
                'label'         => __( 'Badge Text', 'travzo' ),
                'name'          => 'hero_badge_text',
                'type'          => 'text',
                'default_value' => 'Trusted by 500+ Happy Travellers',
            ],
            [
                'key'           => 'field_hero_heading',
                'label'         => __( 'Hero Heading', 'travzo' ),
                'name'          => 'hero_heading',
                'type'          => 'text',
                'default_value' => 'Discover the World With Travzo Holidays',
            ],
            [
                'key'           => 'field_hero_subtext',
                'label'         => __( 'Hero Subtext', 'travzo' ),
                'name'          => 'hero_subtext',
                'type'          => 'text',
                'default_value' => 'Handcrafted itineraries for every kind of traveller.',
            ],
            [
                'key'           => 'field_hero_primary_button_text',
                'label'         => __( 'Primary Button Text', 'travzo' ),
                'name'          => 'hero_primary_button_text',
                'type'          => 'text',
                'default_value' => 'Explore Packages',
            ],
            [
                'key'           => 'field_hero_primary_button_url',
                'label'         => __( 'Primary Button URL', 'travzo' ),
                'name'          => 'hero_primary_button_url',
                'type'          => 'url',
                'default_value' => '/packages',
            ],
            [
                'key'           => 'field_hero_secondary_button_text',
                'label'         => __( 'Secondary Button Text', 'travzo' ),
                'name'          => 'hero_secondary_button_text',
                'type'          => 'text',
                'default_value' => 'Enquire Now',
            ],
            [
                'key'           => 'field_hero_secondary_button_url',
                'label'         => __( 'Secondary Button URL', 'travzo' ),
                'name'          => 'hero_secondary_button_url',
                'type'          => 'url',
                'default_value' => '/contact',
            ],
        ],
        'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 2 – HOMEPAGE PACKAGES SECTION
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_homepage_packages',
        'title'  => __( 'Homepage – Packages Section', 'travzo' ),
        'fields' => [
            [
                'key'           => 'field_packages_section_label',
                'label'         => __( 'Section Label', 'travzo' ),
                'name'          => 'packages_section_label',
                'type'          => 'text',
                'default_value' => 'WHAT WE OFFER',
            ],
            [
                'key'           => 'field_packages_section_heading',
                'label'         => __( 'Section Heading', 'travzo' ),
                'name'          => 'packages_section_heading',
                'type'          => 'text',
                'default_value' => 'Our Packages',
            ],
            [
                'key'          => 'field_package_tiles',
                'label'        => __( 'Package Tiles', 'travzo' ),
                'name'         => 'package_tiles',
                'type'         => 'repeater',
                'button_label' => __( 'Add Tile', 'travzo' ),
                'layout'       => 'table',
                'sub_fields'   => [
                    [
                        'key'   => 'field_tile_name',
                        'label' => __( 'Tile Name', 'travzo' ),
                        'name'  => 'tile_name',
                        'type'  => 'text',
                    ],
                    [
                        'key'           => 'field_tile_image',
                        'label'         => __( 'Tile Image', 'travzo' ),
                        'name'          => 'tile_image',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'thumbnail',
                    ],
                    [
                        'key'           => 'field_tile_count',
                        'label'         => __( 'Package Count', 'travzo' ),
                        'name'          => 'tile_count',
                        'type'          => 'text',
                        'default_value' => '12 Packages',
                    ],
                    [
                        'key'   => 'field_tile_url',
                        'label' => __( 'Tile URL', 'travzo' ),
                        'name'  => 'tile_url',
                        'type'  => 'url',
                    ],
                ],
            ],
        ],
        'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 3 – HOMEPAGE STATS
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_homepage_stats',
        'title'  => __( 'Homepage – Stats Bar', 'travzo' ),
        'fields' => [
            [ 'key' => 'field_stat_1_number',      'label' => __( 'Stat 1 Number', 'travzo' ),      'name' => 'stat_1_number',      'type' => 'text', 'default_value' => '500+' ],
            [ 'key' => 'field_stat_1_label',       'label' => __( 'Stat 1 Label', 'travzo' ),       'name' => 'stat_1_label',       'type' => 'text', 'default_value' => 'Happy Travellers' ],
            [ 'key' => 'field_stat_1_description', 'label' => __( 'Stat 1 Description', 'travzo' ), 'name' => 'stat_1_description', 'type' => 'text', 'default_value' => 'And counting every season' ],
            [ 'key' => 'field_stat_2_number',      'label' => __( 'Stat 2 Number', 'travzo' ),      'name' => 'stat_2_number',      'type' => 'text', 'default_value' => '50+' ],
            [ 'key' => 'field_stat_2_label',       'label' => __( 'Stat 2 Label', 'travzo' ),       'name' => 'stat_2_label',       'type' => 'text', 'default_value' => 'Destinations' ],
            [ 'key' => 'field_stat_2_description', 'label' => __( 'Stat 2 Description', 'travzo' ), 'name' => 'stat_2_description', 'type' => 'text', 'default_value' => 'Across India and the world' ],
            [ 'key' => 'field_stat_3_number',      'label' => __( 'Stat 3 Number', 'travzo' ),      'name' => 'stat_3_number',      'type' => 'text', 'default_value' => '10+' ],
            [ 'key' => 'field_stat_3_label',       'label' => __( 'Stat 3 Label', 'travzo' ),       'name' => 'stat_3_label',       'type' => 'text', 'default_value' => 'Years Experience' ],
            [ 'key' => 'field_stat_3_description', 'label' => __( 'Stat 3 Description', 'travzo' ), 'name' => 'stat_3_description', 'type' => 'text', 'default_value' => 'Trusted since day one' ],
            [ 'key' => 'field_stat_4_number',      'label' => __( 'Stat 4 Number', 'travzo' ),      'name' => 'stat_4_number',      'type' => 'text', 'default_value' => '100%' ],
            [ 'key' => 'field_stat_4_label',       'label' => __( 'Stat 4 Label', 'travzo' ),       'name' => 'stat_4_label',       'type' => 'text', 'default_value' => 'Customised Itineraries' ],
            [ 'key' => 'field_stat_4_description', 'label' => __( 'Stat 4 Description', 'travzo' ), 'name' => 'stat_4_description', 'type' => 'text', 'default_value' => 'Every trip tailored for you' ],
        ],
        'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 4 – HOMEPAGE ABOUT SNIPPET
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_homepage_about',
        'title'  => __( 'Homepage – About Snippet', 'travzo' ),
        'fields' => [
            [ 'key' => 'field_about_label',   'label' => __( 'Section Label', 'travzo' ),   'name' => 'about_label',   'type' => 'text', 'default_value' => 'WHO WE ARE' ],
            [ 'key' => 'field_about_heading', 'label' => __( 'Section Heading', 'travzo' ), 'name' => 'about_heading', 'type' => 'text', 'default_value' => 'Your Trusted Travel Partner' ],
            [
                'key'           => 'field_about_text',
                'label'         => __( 'About Text', 'travzo' ),
                'name'          => 'about_text',
                'type'          => 'textarea',
                'rows'          => 5,
                'default_value' => 'Travzo Holidays is a premium travel agency based in Tamil Nadu crafting unforgettable journeys across India and the world. From honeymoons to group tours, devotional trips to destination weddings, we handle every detail so you can simply enjoy the journey.',
            ],
            [
                'key'           => 'field_about_image',
                'label'         => __( 'About Image', 'travzo' ),
                'name'          => 'about_image',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ],
            [ 'key' => 'field_about_feature_1',      'label' => __( 'Feature 1', 'travzo' ),           'name' => 'about_feature_1',      'type' => 'text', 'default_value' => 'Handcrafted Itineraries' ],
            [ 'key' => 'field_about_feature_2',      'label' => __( 'Feature 2', 'travzo' ),           'name' => 'about_feature_2',      'type' => 'text', 'default_value' => 'Best Price Guarantee' ],
            [ 'key' => 'field_about_feature_3',      'label' => __( 'Feature 3', 'travzo' ),           'name' => 'about_feature_3',      'type' => 'text', 'default_value' => '24/7 Support' ],
            [ 'key' => 'field_about_button_text',    'label' => __( 'Button Text', 'travzo' ),         'name' => 'about_button_text',    'type' => 'text', 'default_value' => 'Learn More About Us' ],
            [ 'key' => 'field_about_button_url',     'label' => __( 'Button URL', 'travzo' ),          'name' => 'about_button_url',     'type' => 'url',  'default_value' => '/about' ],
        ],
        'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 5 – HOMEPAGE TESTIMONIALS
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_homepage_testimonials',
        'title'  => __( 'Homepage – Testimonials', 'travzo' ),
        'fields' => [
            [
                'key'           => 'field_testimonials_heading',
                'label'         => __( 'Section Heading', 'travzo' ),
                'name'          => 'testimonials_heading',
                'type'          => 'text',
                'default_value' => 'What Our Travellers Say',
            ],
            [
                'key'          => 'field_testimonials',
                'label'        => __( 'Testimonials', 'travzo' ),
                'name'         => 'testimonials',
                'type'         => 'repeater',
                'button_label' => __( 'Add Testimonial', 'travzo' ),
                'layout'       => 'row',
                'sub_fields'   => [
                    [
                        'key'   => 'field_testimonial_quote',
                        'label' => __( 'Quote', 'travzo' ),
                        'name'  => 'quote',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'key'   => 'field_testimonial_customer_name',
                        'label' => __( 'Customer Name', 'travzo' ),
                        'name'  => 'customer_name',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_testimonial_trip_taken',
                        'label' => __( 'Trip Taken', 'travzo' ),
                        'name'  => 'trip_taken',
                        'type'  => 'text',
                    ],
                    [
                        'key'           => 'field_testimonial_avatar',
                        'label'         => __( 'Customer Avatar', 'travzo' ),
                        'name'          => 'avatar',
                        'type'          => 'image',
                        'return_format' => 'url',
                        'preview_size'  => 'thumbnail',
                    ],
                ],
            ],
        ],
        'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 6 – HOMEPAGE NEWSLETTER
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_homepage_newsletter',
        'title'  => __( 'Homepage – Newsletter Section', 'travzo' ),
        'fields' => [
            [ 'key' => 'field_newsletter_heading',     'label' => __( 'Heading', 'travzo' ),     'name' => 'newsletter_heading',     'type' => 'text', 'default_value' => 'Get Travel Deals in Your Inbox' ],
            [ 'key' => 'field_newsletter_subtext',     'label' => __( 'Subtext', 'travzo' ),     'name' => 'newsletter_subtext',     'type' => 'text', 'default_value' => 'Subscribe and be the first to know about our exclusive offers.' ],
            [ 'key' => 'field_newsletter_button_text', 'label' => __( 'Button Text', 'travzo' ), 'name' => 'newsletter_button_text', 'type' => 'text', 'default_value' => 'Subscribe' ],
        ],
        'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 7 – ABOUT PAGE
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_about_page',
        'title'  => __( 'About Page', 'travzo' ),
        'fields' => [
            [
                'key'           => 'field_about_hero_image',
                'label'         => __( 'Hero Image', 'travzo' ),
                'name'          => 'about_hero_image',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ],
            [ 'key' => 'field_about_hero_heading', 'label' => __( 'Hero Heading', 'travzo' ), 'name' => 'about_hero_heading', 'type' => 'text',     'default_value' => 'About Travzo Holidays' ],
            [ 'key' => 'field_about_hero_subtext', 'label' => __( 'Hero Subtext', 'travzo' ), 'name' => 'about_hero_subtext', 'type' => 'text' ],
            [ 'key' => 'field_story_heading',      'label' => __( 'Story Heading', 'travzo' ),'name' => 'story_heading',      'type' => 'text',     'default_value' => 'Who We Are' ],
            [ 'key' => 'field_story_text',         'label' => __( 'Story Text', 'travzo' ),   'name' => 'story_text',         'type' => 'wysiwyg',  'tabs' => 'all', 'media_upload' => 0 ],
            [
                'key'           => 'field_story_image',
                'label'         => __( 'Story Image', 'travzo' ),
                'name'          => 'story_image',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ],
            [
                'key'          => 'field_team_members',
                'label'        => __( 'Team Members', 'travzo' ),
                'name'         => 'team_members',
                'type'         => 'repeater',
                'button_label' => __( 'Add Team Member', 'travzo' ),
                'layout'       => 'row',
                'sub_fields'   => [
                    [ 'key' => 'field_member_name',  'label' => __( 'Name', 'travzo' ),  'name' => 'member_name',  'type' => 'text' ],
                    [ 'key' => 'field_member_role',  'label' => __( 'Role', 'travzo' ),  'name' => 'member_role',  'type' => 'text' ],
                    [ 'key' => 'field_member_photo', 'label' => __( 'Photo', 'travzo' ), 'name' => 'member_photo', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail' ],
                    [ 'key' => 'field_member_bio',   'label' => __( 'Bio', 'travzo' ),   'name' => 'member_bio',   'type' => 'textarea', 'rows' => 3 ],
                ],
            ],
            [
                'key'          => 'field_awards',
                'label'        => __( 'Awards', 'travzo' ),
                'name'         => 'awards',
                'type'         => 'repeater',
                'button_label' => __( 'Add Award', 'travzo' ),
                'layout'       => 'table',
                'sub_fields'   => [
                    [ 'key' => 'field_award_name',  'label' => __( 'Award Name', 'travzo' ),  'name' => 'award_name',  'type' => 'text' ],
                    [ 'key' => 'field_award_year',  'label' => __( 'Year', 'travzo' ),         'name' => 'award_year',  'type' => 'text' ],
                    [ 'key' => 'field_award_image', 'label' => __( 'Award Image', 'travzo' ),  'name' => 'award_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail' ],
                    [ 'key' => 'field_award_body',  'label' => __( 'Description', 'travzo' ),  'name' => 'award_body',  'type' => 'text' ],
                ],
            ],
            [
                'key'          => 'field_accreditation_logos',
                'label'        => __( 'Accreditation Logos', 'travzo' ),
                'name'         => 'accreditation_logos',
                'type'         => 'repeater',
                'button_label' => __( 'Add Logo', 'travzo' ),
                'layout'       => 'table',
                'sub_fields'   => [
                    [ 'key' => 'field_logo_name',  'label' => __( 'Partner Name', 'travzo' ), 'name' => 'logo_name',  'type' => 'text' ],
                    [ 'key' => 'field_logo_image', 'label' => __( 'Logo Image', 'travzo' ),   'name' => 'logo_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail' ],
                ],
            ],
        ],
        'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 8 – CONTACT PAGE
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_contact_page',
        'title'  => __( 'Contact Page', 'travzo' ),
        'fields' => [
            [
                'key'           => 'field_contact_hero_image',
                'label'         => __( 'Hero Image', 'travzo' ),
                'name'          => 'contact_hero_image',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ],
            [ 'key' => 'field_contact_hero_heading', 'label' => __( 'Hero Heading', 'travzo' ), 'name' => 'contact_hero_heading', 'type' => 'text',     'default_value' => 'Get In Touch' ],
            [ 'key' => 'field_contact_address',      'label' => __( 'Address', 'travzo' ),      'name' => 'contact_address',      'type' => 'textarea', 'rows' => 3, 'default_value' => "123 Travel Street, Coimbatore, Tamil Nadu 641001" ],
            [ 'key' => 'field_contact_phone',        'label' => __( 'Phone', 'travzo' ),        'name' => 'contact_phone',        'type' => 'text',     'default_value' => '+91 XXXXX XXXXX' ],
            [ 'key' => 'field_contact_email',        'label' => __( 'Email', 'travzo' ),        'name' => 'contact_email',        'type' => 'email',    'default_value' => 'hello@travzoholidays.com' ],
            [ 'key' => 'field_contact_whatsapp',     'label' => __( 'WhatsApp Number', 'travzo' ), 'name' => 'contact_whatsapp', 'type' => 'text',     'default_value' => '91XXXXXXXXXX', 'instructions' => __( 'Enter number only, e.g. 919876543210', 'travzo' ) ],
            [ 'key' => 'field_contact_hours',        'label' => __( 'Working Hours', 'travzo' ), 'name' => 'contact_hours',       'type' => 'text',     'default_value' => 'Mon - Sat: 9:00 AM - 7:00 PM' ],
            [
                'key'          => 'field_branches',
                'label'        => __( 'Branch Offices', 'travzo' ),
                'name'         => 'branches',
                'type'         => 'repeater',
                'button_label' => __( 'Add Branch', 'travzo' ),
                'layout'       => 'row',
                'sub_fields'   => [
                    [ 'key' => 'field_branch_city',    'label' => __( 'City', 'travzo' ),    'name' => 'branch_city',    'type' => 'text' ],
                    [ 'key' => 'field_branch_address', 'label' => __( 'Address', 'travzo' ), 'name' => 'branch_address', 'type' => 'textarea', 'rows' => 2 ],
                    [ 'key' => 'field_branch_phone',   'label' => __( 'Phone', 'travzo' ),   'name' => 'branch_phone',   'type' => 'text' ],
                    [ 'key' => 'field_branch_email',   'label' => __( 'Email', 'travzo' ),   'name' => 'branch_email',   'type' => 'email' ],
                ],
            ],
        ],
        'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 9 – FAQ PAGE
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_faq_page',
        'title'  => __( 'FAQ Page', 'travzo' ),
        'fields' => [
            [
                'key'           => 'field_faq_hero_image',
                'label'         => __( 'Hero Image', 'travzo' ),
                'name'          => 'faq_hero_image',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ],
            [ 'key' => 'field_faq_hero_heading', 'label' => __( 'Hero Heading', 'travzo' ), 'name' => 'faq_hero_heading', 'type' => 'text', 'default_value' => 'Frequently Asked Questions' ],
            [
                'key'          => 'field_faqs',
                'label'        => __( 'FAQs', 'travzo' ),
                'name'         => 'faqs',
                'type'         => 'repeater',
                'button_label' => __( 'Add FAQ', 'travzo' ),
                'layout'       => 'row',
                'sub_fields'   => [
                    [
                        'key'     => 'field_faq_category',
                        'label'   => __( 'Category', 'travzo' ),
                        'name'    => 'faq_category',
                        'type'    => 'select',
                        'choices' => [
                            'General'           => 'General',
                            'Booking & Payment' => 'Booking & Payment',
                            'Visas & Documents' => 'Visas & Documents',
                            'Group Tours'       => 'Group Tours',
                            'Honeymoon'         => 'Honeymoon',
                            'Cancellation'      => 'Cancellation',
                        ],
                        'default_value' => 'General',
                        'allow_null'    => 0,
                        'ui'            => 1,
                    ],
                    [ 'key' => 'field_faq_question', 'label' => __( 'Question', 'travzo' ), 'name' => 'faq_question', 'type' => 'text' ],
                    [ 'key' => 'field_faq_answer',   'label' => __( 'Answer', 'travzo' ),   'name' => 'faq_answer',   'type' => 'textarea', 'rows' => 4 ],
                ],
            ],
        ],
        'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-faq.php' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 10 – MEDIA PAGE
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_media_page',
        'title'  => __( 'Media Page', 'travzo' ),
        'fields' => [
            [
                'key'           => 'field_media_hero_image',
                'label'         => __( 'Hero Image', 'travzo' ),
                'name'          => 'media_hero_image',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ],
            [ 'key' => 'field_media_hero_heading', 'label' => __( 'Hero Heading', 'travzo' ), 'name' => 'media_hero_heading', 'type' => 'text', 'default_value' => 'Media & Press' ],
            [
                'key'           => 'field_photo_gallery',
                'label'         => __( 'Photo Gallery', 'travzo' ),
                'name'          => 'photo_gallery',
                'type'          => 'gallery',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'insert'        => 'append',
            ],
            [
                'key'          => 'field_videos',
                'label'        => __( 'Videos', 'travzo' ),
                'name'         => 'videos',
                'type'         => 'repeater',
                'button_label' => __( 'Add Video', 'travzo' ),
                'layout'       => 'row',
                'sub_fields'   => [
                    [ 'key' => 'field_video_title',     'label' => __( 'Video Title', 'travzo' ),     'name' => 'video_title',     'type' => 'text' ],
                    [ 'key' => 'field_video_url',       'label' => __( 'Video URL', 'travzo' ),       'name' => 'video_url',       'type' => 'url' ],
                    [ 'key' => 'field_video_thumbnail', 'label' => __( 'Video Thumbnail', 'travzo' ), 'name' => 'video_thumbnail', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail' ],
                ],
            ],
            [
                'key'          => 'field_press_coverage',
                'label'        => __( 'Press Coverage', 'travzo' ),
                'name'         => 'press_coverage',
                'type'         => 'repeater',
                'button_label' => __( 'Add Press Item', 'travzo' ),
                'layout'       => 'row',
                'sub_fields'   => [
                    [ 'key' => 'field_press_publication', 'label' => __( 'Publication', 'travzo' ),  'name' => 'press_publication', 'type' => 'text' ],
                    [ 'key' => 'field_press_headline',    'label' => __( 'Headline', 'travzo' ),     'name' => 'press_headline',    'type' => 'text' ],
                    [ 'key' => 'field_press_date',        'label' => __( 'Date', 'travzo' ),         'name' => 'press_date',        'type' => 'date_picker', 'return_format' => 'd/m/Y', 'display_format' => 'd/m/Y' ],
                    [ 'key' => 'field_press_url',         'label' => __( 'Article URL', 'travzo' ),  'name' => 'press_url',         'type' => 'url' ],
                    [ 'key' => 'field_press_logo',        'label' => __( 'Publication Logo', 'travzo' ), 'name' => 'press_logo',   'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail' ],
                ],
            ],
            [
                'key'          => 'field_awards_media',
                'label'        => __( 'Awards', 'travzo' ),
                'name'         => 'awards_media',
                'type'         => 'repeater',
                'button_label' => __( 'Add Award', 'travzo' ),
                'layout'       => 'table',
                'sub_fields'   => [
                    [ 'key' => 'field_award_title_media', 'label' => __( 'Award Title', 'travzo' ), 'name' => 'award_title', 'type' => 'text' ],
                    [ 'key' => 'field_award_year_media',  'label' => __( 'Year', 'travzo' ),        'name' => 'award_year',  'type' => 'text' ],
                    [ 'key' => 'field_award_image_media', 'label' => __( 'Award Image', 'travzo' ), 'name' => 'award_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail' ],
                    [ 'key' => 'field_award_body_media',  'label' => __( 'Description', 'travzo' ), 'name' => 'award_body',  'type' => 'text' ],
                ],
            ],
        ],
        'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-media.php' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 11 – PACKAGE POST TYPE (replaces original group_travzo_package)
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_package_fields',
        'title'  => __( 'Package Details', 'travzo' ),
        'fields' => [
            // Core Details
            [
                'key'     => 'field_pkg_package_type',
                'label'   => __( 'Package Type', 'travzo' ),
                'name'    => 'package_type',
                'type'    => 'select',
                'choices' => [
                    'Group Tour'          => 'Group Tour',
                    'Honeymoon'           => 'Honeymoon',
                    'Solo Trip'           => 'Solo Trip',
                    'Devotional'          => 'Devotional',
                    'Destination Wedding' => 'Destination Wedding',
                    'International'       => 'International',
                ],
                'default_value' => 'Group Tour',
                'allow_null'    => 0,
                'ui'            => 1,
            ],
            [ 'key' => 'field_pkg_price',        'label' => __( 'Starting Price (e.g. 15000)', 'travzo' ), 'name' => 'price',        'type' => 'text', 'instructions' => __( 'Enter number only, e.g. 24999', 'travzo' ) ],
            [ 'key' => 'field_pkg_duration',     'label' => __( 'Duration (e.g. 4 Nights / 5 Days)', 'travzo' ), 'name' => 'duration', 'type' => 'text' ],
            [ 'key' => 'field_pkg_destinations', 'label' => __( 'Destinations Covered', 'travzo' ),         'name' => 'destinations', 'type' => 'text' ],
            [ 'key' => 'field_pkg_group_size',   'label' => __( 'Group Size (e.g. 2-15 People)', 'travzo' ), 'name' => 'group_size',   'type' => 'text' ],

            // Description Fields
            [ 'key' => 'field_pkg_highlights', 'label' => __( 'Package Highlights', 'travzo' ), 'name' => 'highlights', 'type' => 'textarea', 'rows' => 5, 'instructions' => __( 'One highlight per line', 'travzo' ) ],
            [ 'key' => 'field_pkg_inclusions', 'label' => __( 'Inclusions', 'travzo' ),         'name' => 'inclusions', 'type' => 'textarea', 'rows' => 5, 'instructions' => __( 'One item per line', 'travzo' ) ],
            [ 'key' => 'field_pkg_exclusions', 'label' => __( 'Exclusions', 'travzo' ),         'name' => 'exclusions', 'type' => 'textarea', 'rows' => 5, 'instructions' => __( 'One item per line', 'travzo' ) ],

            // Itinerary
            [
                'key'          => 'field_pkg_itinerary',
                'label'        => __( 'Day by Day Itinerary', 'travzo' ),
                'name'         => 'itinerary',
                'type'         => 'repeater',
                'button_label' => __( 'Add Day', 'travzo' ),
                'layout'       => 'row',
                'sub_fields'   => [
                    [ 'key' => 'field_pkg_day_title',       'label' => __( 'Day Title (e.g. Arrival in Bali)', 'travzo' ), 'name' => 'day_title',       'type' => 'text' ],
                    [ 'key' => 'field_pkg_day_description', 'label' => __( 'Day Activities', 'travzo' ),                   'name' => 'day_description', 'type' => 'textarea', 'rows' => 4 ],
                ],
            ],

            // Gallery
            [
                'key'           => 'field_pkg_gallery',
                'label'         => __( 'Package Photo Gallery', 'travzo' ),
                'name'          => 'gallery',
                'type'          => 'gallery',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'insert'        => 'append',
            ],

            // Hotels
            [
                'key'          => 'field_pkg_hotels',
                'label'        => __( 'Hotel Details', 'travzo' ),
                'name'         => 'hotels',
                'type'         => 'repeater',
                'button_label' => __( 'Add Hotel', 'travzo' ),
                'layout'       => 'row',
                'sub_fields'   => [
                    [ 'key' => 'field_hotel_name',      'label' => __( 'Hotel Name', 'travzo' ),    'name' => 'hotel_name',      'type' => 'text' ],
                    [
                        'key'     => 'field_hotel_stars',
                        'label'   => __( 'Star Rating', 'travzo' ),
                        'name'    => 'hotel_stars',
                        'type'    => 'select',
                        'choices' => [ '3' => '3 Star', '4' => '4 Star', '5' => '5 Star' ],
                        'default_value' => '3',
                        'ui'      => 1,
                    ],
                    [ 'key' => 'field_hotel_location',  'label' => __( 'Location', 'travzo' ),      'name' => 'hotel_location',  'type' => 'text' ],
                    [ 'key' => 'field_hotel_room_type', 'label' => __( 'Room Type', 'travzo' ),     'name' => 'hotel_room_type', 'type' => 'text' ],
                    [ 'key' => 'field_hotel_image',     'label' => __( 'Hotel Image', 'travzo' ),   'name' => 'hotel_image',     'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail' ],
                ],
            ],

            // Pricing Table
            [ 'key' => 'field_pricing_standard_twin',   'label' => __( 'Standard Room – Twin Sharing', 'travzo' ),    'name' => 'pricing_standard_twin',   'type' => 'text' ],
            [ 'key' => 'field_pricing_standard_triple', 'label' => __( 'Standard Room – Triple Sharing', 'travzo' ),  'name' => 'pricing_standard_triple', 'type' => 'text' ],
            [ 'key' => 'field_pricing_deluxe_twin',     'label' => __( 'Deluxe Room – Twin Sharing', 'travzo' ),      'name' => 'pricing_deluxe_twin',     'type' => 'text' ],
            [ 'key' => 'field_pricing_deluxe_triple',   'label' => __( 'Deluxe Room – Triple Sharing', 'travzo' ),    'name' => 'pricing_deluxe_triple',   'type' => 'text' ],
            [ 'key' => 'field_pricing_premium_twin',    'label' => __( 'Premium Room – Twin Sharing', 'travzo' ),     'name' => 'pricing_premium_twin',    'type' => 'text' ],
            [ 'key' => 'field_pricing_premium_triple',  'label' => __( 'Premium Room – Triple Sharing', 'travzo' ),   'name' => 'pricing_premium_triple',  'type' => 'text' ],
            [ 'key' => 'field_pricing_child_bed',       'label' => __( 'Child with Extra Bed', 'travzo' ),             'name' => 'pricing_child_bed',       'type' => 'text' ],
            [ 'key' => 'field_pricing_child_no_bed',    'label' => __( 'Child without Extra Bed', 'travzo' ),          'name' => 'pricing_child_no_bed',    'type' => 'text' ],
        ],
        'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'package' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 12 – HEADER SETTINGS (options page)
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_header_settings',
        'title'  => __( 'Header Settings', 'travzo' ),
        'fields' => [
            [ 'key' => 'field_site_phone',        'label' => __( 'Phone Number', 'travzo' ),      'name' => 'site_phone',        'type' => 'text',  'default_value' => '+91 XXXXX XXXXX' ],
            [ 'key' => 'field_site_email',        'label' => __( 'Email Address', 'travzo' ),     'name' => 'site_email',        'type' => 'email', 'default_value' => 'hello@travzoholidays.com' ],
            [ 'key' => 'field_site_whatsapp',     'label' => __( 'WhatsApp Number', 'travzo' ),   'name' => 'site_whatsapp',     'type' => 'text',  'instructions' => __( 'With country code, digits only. e.g. 919876543210', 'travzo' ) ],
            [ 'key' => 'field_site_instagram',    'label' => __( 'Instagram URL', 'travzo' ),     'name' => 'site_instagram',    'type' => 'url' ],
            [ 'key' => 'field_site_facebook',     'label' => __( 'Facebook URL', 'travzo' ),      'name' => 'site_facebook',     'type' => 'url' ],
            [ 'key' => 'field_site_youtube',      'label' => __( 'YouTube URL', 'travzo' ),       'name' => 'site_youtube',      'type' => 'url' ],
            [ 'key' => 'field_utility_bar_text',  'label' => __( 'Utility Bar Tagline', 'travzo' ), 'name' => 'utility_bar_text', 'type' => 'text', 'default_value' => "Tamil Nadu's Most Trusted Travel Partner" ],
        ],
        'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'travzo-settings' ] ] ],
    ] );

    // ─────────────────────────────────────────────────────────────────────────
    // GROUP 13 – FOOTER SETTINGS (options page)
    // ─────────────────────────────────────────────────────────────────────────
    acf_add_local_field_group( [
        'key'    => 'group_footer_settings',
        'title'  => __( 'Footer Settings', 'travzo' ),
        'fields' => [
            [ 'key' => 'field_footer_tagline',       'label' => __( 'Footer Tagline', 'travzo' ),     'name' => 'footer_tagline',       'type' => 'text',     'default_value' => 'Your trusted travel partner for unforgettable journeys' ],
            [ 'key' => 'field_footer_address',       'label' => __( 'Footer Address', 'travzo' ),     'name' => 'footer_address',       'type' => 'textarea', 'rows' => 3 ],
            [ 'key' => 'field_footer_working_hours', 'label' => __( 'Working Hours', 'travzo' ),      'name' => 'footer_working_hours', 'type' => 'text',     'default_value' => 'Mon - Sat: 9:00 AM - 7:00 PM' ],
            [ 'key' => 'field_footer_copyright',     'label' => __( 'Copyright Text', 'travzo' ),     'name' => 'footer_copyright',     'type' => 'text',     'default_value' => '© 2025 Travzo Holidays. All Rights Reserved.' ],
        ],
        'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'travzo-settings' ] ] ],
    ] );
}
add_action( 'acf/init', 'travzo_register_acf_fields' );
