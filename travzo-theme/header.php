<?php
/* ── Customizer: Header / Utility-bar settings ──────────────────────────── */
$hdr_tagline   = travzo_get( 'travzo_utility_text', "Tamil Nadu's Most Trusted Travel Partner" );
$hdr_email     = travzo_get( 'travzo_email',     'hello@travzoholidays.com' );
$hdr_phone     = travzo_get( 'travzo_phone',     '+91 XXXXX XXXXX' );
$hdr_instagram = travzo_get( 'travzo_instagram', '#' );
$hdr_facebook  = travzo_get( 'travzo_facebook',  '#' );
$hdr_youtube   = travzo_get( 'travzo_youtube',   '#' );
$hdr_whatsapp  = travzo_get( 'travzo_whatsapp',  '' );

// Derived URLs
$hdr_phone_url    = 'tel:' . preg_replace( '/[^+0-9]/', '', $hdr_phone );
$hdr_email_url    = 'mailto:' . sanitize_email( $hdr_email );
$hdr_whatsapp_url = $hdr_whatsapp
    ? 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $hdr_whatsapp )
    : '#';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&family=Raleway:wght@500;600&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header">

    <!-- ══════════════════════════════════════════════════
         UTILITY BAR
    ══════════════════════════════════════════════════ -->
    <div class="utility-bar">
        <div class="utility-bar__inner">

            <span class="utility-bar__tagline"><?php echo esc_html( $hdr_tagline ); ?></span>

            <div class="utility-bar__right">

                <a href="<?php echo esc_url( $hdr_email_url ); ?>" class="utility-bar__link">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <?php echo esc_html( $hdr_email ); ?>
                </a>

                <a href="<?php echo esc_url( $hdr_phone_url ); ?>" class="utility-bar__link">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 011 2.18 2 2 0 013 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/>
                    </svg>
                    <?php echo esc_html( $hdr_phone ); ?>
                </a>

                <div class="utility-bar__social">

                    <a href="<?php echo esc_url( $hdr_instagram ); ?>" class="utility-bar__social-link" aria-label="<?php esc_attr_e( 'Follow us on Instagram', 'travzo' ); ?>"<?php echo ( $hdr_instagram !== '#' ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                    </a>

                    <a href="<?php echo esc_url( $hdr_facebook ); ?>" class="utility-bar__social-link" aria-label="<?php esc_attr_e( 'Follow us on Facebook', 'travzo' ); ?>"<?php echo ( $hdr_facebook !== '#' ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                        </svg>
                    </a>

                    <a href="<?php echo esc_url( $hdr_youtube ); ?>" class="utility-bar__social-link" aria-label="<?php esc_attr_e( 'Subscribe on YouTube', 'travzo' ); ?>"<?php echo ( $hdr_youtube !== '#' ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/>
                            <polygon fill="currentColor" stroke="none" points="9.75,15.02 15.5,12 9.75,8.98"/>
                        </svg>
                    </a>

                </div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════
         MAIN NAV
    ══════════════════════════════════════════════════ -->
    <div class="main-nav" id="main-nav">
        <div class="main-nav__inner">

            <!-- Logo -->
            <div class="main-nav__logo">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-text">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation -->
            <nav class="primary-nav" id="primary-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'travzo' ); ?>">
                <ul class="nav-menu" role="menubar">

                    <li class="nav-item" role="none">
                        <a href="<?php echo esc_url( home_url( travzo_get( 'travzo_nav_home_url', '/' ) ) ); ?>" class="nav-link" role="menuitem"><?php echo esc_html( travzo_get( 'travzo_nav_home', 'Home' ) ); ?></a>
                    </li>

                    <!-- ── Group Tours Mega Menu ───────────────────── -->
                    <li class="nav-item has-mega" role="none">
                        <a href="<?php echo esc_url( home_url( '/packages' ) ); ?>" class="nav-link" role="menuitem" aria-haspopup="true" aria-expanded="false">
                            <?php echo esc_html( travzo_get( 'travzo_nav_group', 'Group Tours' ) ); ?>
                            <svg class="chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="mega-panel mega-panel--4col" role="region" aria-label="Group Tours destinations">
                            <div class="mega-panel__inner">
                                <div class="mega-col">
                                    <h4 class="mega-col__heading"><?php echo esc_html( travzo_get( 'travzo_mega_group_col1_heading', 'Group Tours' ) ); ?></h4>
                                    <ul>
                                        <?php
                                        $mega_group = new WP_Query( [
                                            'post_type'      => 'package',
                                            'posts_per_page' => 6,
                                            'post_status'    => 'publish',
                                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Group Tour', 'compare' => '=' ] ],
                                        ] );
                                        if ( $mega_group->have_posts() ) :
                                            while ( $mega_group->have_posts() ) : $mega_group->the_post(); ?>
                                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                        <?php endwhile; wp_reset_postdata();
                                        else : ?>
                                        <li><a href="#">Kerala Group Tour</a></li>
                                        <li><a href="#">Kashmir Group Tour</a></li>
                                        <li><a href="#">Rajasthan Group Tour</a></li>
                                        <li><a href="#">Northeast India Tour</a></li>
                                        <li><a href="#">Andaman Islands Tour</a></li>
                                        <li><a href="#">Thailand Group Tour</a></li>
                                        <?php endif; ?>
                                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_group_all', home_url( '/packages?type=Group+Tour' ) ) ); ?>">View More &rarr;</a></li>
                                    </ul>
                                </div>
                                <?php travzo_render_mega_col( 'travzo_mega_group_col2_heading', 'travzo_mega_group_col2_items' ); ?>
                                <?php travzo_render_mega_col( 'travzo_mega_group_col3_heading', 'travzo_mega_group_col3_items' ); ?>
                                <?php travzo_render_mega_col( 'travzo_mega_group_col4_heading', 'travzo_mega_group_col4_items' ); ?>
                            </div>
                        </div>
                    </li>

                    <!-- ── Honeymoon Mega Menu ────────────────────── -->
                    <li class="nav-item has-mega" role="none">
                        <a href="<?php echo esc_url( home_url( '/packages/?category=honeymoon' ) ); ?>" class="nav-link" role="menuitem" aria-haspopup="true" aria-expanded="false">
                            <?php echo esc_html( travzo_get( 'travzo_nav_honeymoon', 'Honeymoon' ) ); ?>
                            <svg class="chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="mega-panel mega-panel--4col" role="region" aria-label="Honeymoon destinations">
                            <div class="mega-panel__inner">
                                <div class="mega-col">
                                    <h4 class="mega-col__heading"><?php echo esc_html( travzo_get( 'travzo_mega_honey_col1_heading', 'Honeymoon Packages' ) ); ?></h4>
                                    <ul>
                                        <?php
                                        $mega_honey = new WP_Query( [
                                            'post_type'      => 'package',
                                            'posts_per_page' => 6,
                                            'post_status'    => 'publish',
                                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Honeymoon', 'compare' => '=' ] ],
                                        ] );
                                        if ( $mega_honey->have_posts() ) :
                                            while ( $mega_honey->have_posts() ) : $mega_honey->the_post(); ?>
                                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                        <?php endwhile; wp_reset_postdata();
                                        else : ?>
                                        <li><a href="#">Maldives Honeymoon</a></li>
                                        <li><a href="#">Kerala Backwaters</a></li>
                                        <li><a href="#">Kashmir Honeymoon</a></li>
                                        <li><a href="#">Bali Honeymoon</a></li>
                                        <li><a href="#">Andaman Honeymoon</a></li>
                                        <li><a href="#">Coorg Honeymoon</a></li>
                                        <?php endif; ?>
                                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_honeymoon_all', home_url( '/packages?type=Honeymoon' ) ) ); ?>">View More &rarr;</a></li>
                                    </ul>
                                </div>
                                <?php travzo_render_mega_col( 'travzo_mega_honeymoon_col2_heading', 'travzo_mega_honeymoon_col2_items' ); ?>
                                <?php travzo_render_mega_col( 'travzo_mega_honeymoon_col3_heading', 'travzo_mega_honeymoon_col3_items' ); ?>
                                <?php travzo_render_mega_col( 'travzo_mega_honeymoon_col4_heading', 'travzo_mega_honeymoon_col4_items', travzo_get( 'travzo_menu_honeymoon_all', home_url( '/packages?type=Honeymoon' ) ), 'View All Honeymoon →' ); ?>
                            </div>
                        </div>
                    </li>

                    <!-- ── Devotional Mega Menu ───────────────────── -->
                    <li class="nav-item has-mega" role="none">
                        <a href="<?php echo esc_url( home_url( '/packages/?category=devotional' ) ); ?>" class="nav-link" role="menuitem" aria-haspopup="true" aria-expanded="false">
                            <?php echo esc_html( travzo_get( 'travzo_nav_devotional', 'Devotional' ) ); ?>
                            <svg class="chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="mega-panel mega-panel--3col" role="region" aria-label="Devotional tour destinations">
                            <div class="mega-panel__inner">
                                <div class="mega-col">
                                    <h4 class="mega-col__heading"><?php echo esc_html( travzo_get( 'travzo_mega_devot_col1_heading', 'Devotional Tours' ) ); ?></h4>
                                    <ul>
                                        <?php
                                        $mega_devot = new WP_Query( [
                                            'post_type'      => 'package',
                                            'posts_per_page' => 6,
                                            'post_status'    => 'publish',
                                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Devotional', 'compare' => '=' ] ],
                                        ] );
                                        if ( $mega_devot->have_posts() ) :
                                            while ( $mega_devot->have_posts() ) : $mega_devot->the_post(); ?>
                                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                        <?php endwhile; wp_reset_postdata();
                                        else : ?>
                                        <li><a href="#">Char Dham Yatra</a></li>
                                        <li><a href="#">Tirupati Tour</a></li>
                                        <li><a href="#">Vaishno Devi</a></li>
                                        <li><a href="#">Rameswaram</a></li>
                                        <li><a href="#">Shirdi Tour</a></li>
                                        <li><a href="#">Murugan Temples Circuit</a></li>
                                        <?php endif; ?>
                                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_devotional_all', home_url( '/packages?type=Devotional' ) ) ); ?>">View More &rarr;</a></li>
                                    </ul>
                                </div>
                                <?php travzo_render_mega_col( 'travzo_mega_devotional_col2_heading', 'travzo_mega_devotional_col2_items' ); ?>
                                <?php travzo_render_mega_col( 'travzo_mega_devotional_col3_heading', 'travzo_mega_devotional_col3_items', travzo_get( 'travzo_menu_devotional_all', home_url( '/packages?type=Devotional' ) ), 'View All Devotional →' ); ?>
                            </div>
                        </div>
                    </li>

                    <!-- ── Destination Wedding Mega Menu ─────────── -->
                    <li class="nav-item has-mega" role="none">
                        <a href="<?php echo esc_url( home_url( '/packages/?category=destination-wedding' ) ); ?>" class="nav-link" role="menuitem" aria-haspopup="true" aria-expanded="false">
                            <?php echo esc_html( travzo_get( 'travzo_nav_wedding', 'Dest. Wedding' ) ); ?>
                            <svg class="chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="mega-panel mega-panel--3col" role="region" aria-label="Destination wedding locations">
                            <div class="mega-panel__inner">
                                <div class="mega-col">
                                    <h4 class="mega-col__heading"><?php echo esc_html( travzo_get( 'travzo_mega_wed_col1_heading', 'Destination Weddings' ) ); ?></h4>
                                    <ul>
                                        <?php
                                        $mega_wed = new WP_Query( [
                                            'post_type'      => 'package',
                                            'posts_per_page' => 6,
                                            'post_status'    => 'publish',
                                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Destination Wedding', 'compare' => '=' ] ],
                                        ] );
                                        if ( $mega_wed->have_posts() ) :
                                            while ( $mega_wed->have_posts() ) : $mega_wed->the_post(); ?>
                                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                        <?php endwhile; wp_reset_postdata();
                                        else : ?>
                                        <li><a href="#">Udaipur Wedding</a></li>
                                        <li><a href="#">Jaipur Wedding</a></li>
                                        <li><a href="#">Goa Beach Wedding</a></li>
                                        <li><a href="#">Kerala Wedding</a></li>
                                        <li><a href="#">Ooty Wedding</a></li>
                                        <li><a href="#">Maldives Wedding</a></li>
                                        <?php endif; ?>
                                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_wedding_all', home_url( '/packages?type=Destination+Wedding' ) ) ); ?>">View More &rarr;</a></li>
                                    </ul>
                                </div>
                                <?php travzo_render_mega_col( 'travzo_mega_wedding_col2_heading', 'travzo_mega_wedding_col2_items' ); ?>
                                <?php travzo_render_mega_col( 'travzo_mega_wedding_col3_heading', 'travzo_mega_wedding_col3_items', travzo_get( 'travzo_menu_wedding_all', home_url( '/packages?type=Destination+Wedding' ) ), 'View All Weddings →' ); ?>
                            </div>
                        </div>
                    </li>

                    <!-- ── Solo Trips Mega Menu ───────────────────── -->
                    <li class="nav-item has-mega" role="none">
                        <a href="<?php echo esc_url( home_url( '/packages/?category=solo-trips' ) ); ?>" class="nav-link" role="menuitem" aria-haspopup="true" aria-expanded="false">
                            <?php echo esc_html( travzo_get( 'travzo_nav_solo', 'Solo Trips' ) ); ?>
                            <svg class="chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="mega-panel mega-panel--3col" role="region" aria-label="Solo trip destinations">
                            <div class="mega-panel__inner">
                                <div class="mega-col">
                                    <h4 class="mega-col__heading"><?php echo esc_html( travzo_get( 'travzo_mega_solo_col1_heading', 'Solo Trips' ) ); ?></h4>
                                    <ul>
                                        <?php
                                        $mega_solo = new WP_Query( [
                                            'post_type'      => 'package',
                                            'posts_per_page' => 6,
                                            'post_status'    => 'publish',
                                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Solo Trip', 'compare' => '=' ] ],
                                        ] );
                                        if ( $mega_solo->have_posts() ) :
                                            while ( $mega_solo->have_posts() ) : $mega_solo->the_post(); ?>
                                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                        <?php endwhile; wp_reset_postdata();
                                        else : ?>
                                        <li><a href="#">Ladakh Solo Trip</a></li>
                                        <li><a href="#">Spiti Valley</a></li>
                                        <li><a href="#">Rishikesh</a></li>
                                        <li><a href="#">Rajasthan Solo</a></li>
                                        <li><a href="#">Andaman Solo</a></li>
                                        <li><a href="#">Northeast India</a></li>
                                        <?php endif; ?>
                                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_solo_all', home_url( '/packages?type=Solo+Trip' ) ) ); ?>">View More &rarr;</a></li>
                                    </ul>
                                </div>
                                <?php travzo_render_mega_col( 'travzo_mega_solo_col2_heading', 'travzo_mega_solo_col2_items', travzo_get( 'travzo_menu_solo_all', home_url( '/packages?type=Solo+Trip' ) ), 'View All Solo Trips →' ); ?>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item" role="none">
                        <a href="<?php echo esc_url( home_url( travzo_get( 'travzo_nav_blog_url', '/blog' ) ) ); ?>" class="nav-link" role="menuitem"><?php echo esc_html( travzo_get( 'travzo_nav_blog', 'Blog' ) ); ?></a>
                    </li>

                    <li class="nav-item" role="none">
                        <a href="<?php echo esc_url( home_url( travzo_get( 'travzo_nav_about_url', '/about' ) ) ); ?>" class="nav-link" role="menuitem"><?php echo esc_html( travzo_get( 'travzo_nav_about', 'About' ) ); ?></a>
                    </li>

                    <li class="nav-item" role="none">
                        <a href="<?php echo esc_url( home_url( travzo_get( 'travzo_nav_contact_url', '/contact' ) ) ); ?>" class="nav-link" role="menuitem"><?php echo esc_html( travzo_get( 'travzo_nav_contact', 'Contact' ) ); ?></a>
                    </li>

                </ul>
            </nav>

            <!-- CTA Button -->
            <a href="<?php echo esc_url( $hdr_phone_url ); ?>" class="main-nav__cta">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 011 2.18 2 2 0 013 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/>
                </svg>
                <?php echo esc_html( travzo_get( 'travzo_nav_cta_text', 'Call Us Now' ) ); ?>
            </a>

            <!-- Hamburger -->
            <button class="hamburger" id="hamburger"
                    aria-label="<?php esc_attr_e( 'Toggle navigation', 'travzo' ); ?>"
                    aria-expanded="false"
                    aria-controls="mobile-drawer">
                <span class="hamburger__bar"></span>
                <span class="hamburger__bar"></span>
                <span class="hamburger__bar"></span>
            </button>

        </div><!-- /.main-nav__inner -->
    </div><!-- /.main-nav -->

    <!-- ══════════════════════════════════════════════════
         MOBILE DRAWER
    ══════════════════════════════════════════════════ -->
    <div class="mobile-drawer" id="mobile-drawer"
         role="dialog"
         aria-modal="true"
         aria-label="<?php esc_attr_e( 'Mobile Navigation', 'travzo' ); ?>"
         aria-hidden="true">

        <div class="mobile-drawer__header">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-text">
                    <?php bloginfo( 'name' ); ?>
                </a>
            <?php endif; ?>
            <button class="mobile-drawer__close" id="drawer-close"
                    aria-label="<?php esc_attr_e( 'Close navigation', 'travzo' ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <nav class="mobile-drawer__nav" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'travzo' ); ?>">
            <ul class="mobile-nav">

                <li><a href="<?php echo esc_url( home_url( travzo_get( 'travzo_nav_home_url', '/' ) ) ); ?>"><?php echo esc_html( travzo_get( 'travzo_nav_home', 'Home' ) ); ?></a></li>

                <!-- Group Tours -->
                <li class="mobile-accordion">
                    <button class="mobile-accordion__trigger" aria-expanded="false">
                        <?php echo esc_html( travzo_get( 'travzo_nav_group', 'Group Tours' ) ); ?>
                        <svg class="chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <ul class="mobile-accordion__panel">
                        <?php
                        $mob_group = new WP_Query( [
                            'post_type'      => 'package',
                            'posts_per_page' => 6,
                            'post_status'    => 'publish',
                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Group Tour', 'compare' => '=' ] ],
                        ] );
                        if ( $mob_group->have_posts() ) :
                            while ( $mob_group->have_posts() ) : $mob_group->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata();
                        else : ?>
                        <li><a href="#">Kerala Group Tour</a></li>
                        <li><a href="#">Kashmir Group Tour</a></li>
                        <li><a href="#">Rajasthan Group Tour</a></li>
                        <li><a href="#">Northeast India Tour</a></li>
                        <li><a href="#">Andaman Islands Tour</a></li>
                        <li><a href="#">Thailand Group Tour</a></li>
                        <?php endif; ?>
                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_group_all', home_url( '/packages?type=Group+Tour' ) ) ); ?>">View All &rarr;</a></li>
                    </ul>
                </li>

                <!-- Honeymoon -->
                <li class="mobile-accordion">
                    <button class="mobile-accordion__trigger" aria-expanded="false">
                        <?php echo esc_html( travzo_get( 'travzo_nav_honeymoon', 'Honeymoon' ) ); ?>
                        <svg class="chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <ul class="mobile-accordion__panel">
                        <?php
                        $mob_honey = new WP_Query( [
                            'post_type'      => 'package',
                            'posts_per_page' => 6,
                            'post_status'    => 'publish',
                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Honeymoon', 'compare' => '=' ] ],
                        ] );
                        if ( $mob_honey->have_posts() ) :
                            while ( $mob_honey->have_posts() ) : $mob_honey->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata();
                        else : ?>
                        <li><a href="#">Maldives Honeymoon</a></li>
                        <li><a href="#">Kerala Backwaters</a></li>
                        <li><a href="#">Kashmir Honeymoon</a></li>
                        <li><a href="#">Bali Honeymoon</a></li>
                        <li><a href="#">Andaman Honeymoon</a></li>
                        <li><a href="#">Coorg Honeymoon</a></li>
                        <?php endif; ?>
                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_honeymoon_all', home_url( '/packages?type=Honeymoon' ) ) ); ?>">View All &rarr;</a></li>
                    </ul>
                </li>

                <!-- Devotional -->
                <li class="mobile-accordion">
                    <button class="mobile-accordion__trigger" aria-expanded="false">
                        <?php echo esc_html( travzo_get( 'travzo_nav_devotional', 'Devotional' ) ); ?>
                        <svg class="chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <ul class="mobile-accordion__panel">
                        <?php
                        $mob_devot = new WP_Query( [
                            'post_type'      => 'package',
                            'posts_per_page' => 6,
                            'post_status'    => 'publish',
                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Devotional', 'compare' => '=' ] ],
                        ] );
                        if ( $mob_devot->have_posts() ) :
                            while ( $mob_devot->have_posts() ) : $mob_devot->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata();
                        else : ?>
                        <li><a href="#">Char Dham Yatra</a></li>
                        <li><a href="#">Tirupati Tour</a></li>
                        <li><a href="#">Vaishno Devi</a></li>
                        <li><a href="#">Rameswaram</a></li>
                        <li><a href="#">Shirdi Tour</a></li>
                        <li><a href="#">Murugan Temples Circuit</a></li>
                        <?php endif; ?>
                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_devotional_all', home_url( '/packages?type=Devotional' ) ) ); ?>">View All &rarr;</a></li>
                    </ul>
                </li>

                <!-- Destination Wedding -->
                <li class="mobile-accordion">
                    <button class="mobile-accordion__trigger" aria-expanded="false">
                        <?php echo esc_html( travzo_get( 'travzo_nav_wedding', 'Dest. Wedding' ) ); ?>
                        <svg class="chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <ul class="mobile-accordion__panel">
                        <?php
                        $mob_wed = new WP_Query( [
                            'post_type'      => 'package',
                            'posts_per_page' => 6,
                            'post_status'    => 'publish',
                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Destination Wedding', 'compare' => '=' ] ],
                        ] );
                        if ( $mob_wed->have_posts() ) :
                            while ( $mob_wed->have_posts() ) : $mob_wed->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata();
                        else : ?>
                        <li><a href="#">Udaipur Wedding</a></li>
                        <li><a href="#">Jaipur Wedding</a></li>
                        <li><a href="#">Goa Beach Wedding</a></li>
                        <li><a href="#">Kerala Wedding</a></li>
                        <li><a href="#">Ooty Wedding</a></li>
                        <li><a href="#">Maldives Wedding</a></li>
                        <?php endif; ?>
                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_wedding_all', home_url( '/packages?type=Destination+Wedding' ) ) ); ?>">View All &rarr;</a></li>
                    </ul>
                </li>

                <!-- Solo Trips -->
                <li class="mobile-accordion">
                    <button class="mobile-accordion__trigger" aria-expanded="false">
                        <?php echo esc_html( travzo_get( 'travzo_nav_solo', 'Solo Trips' ) ); ?>
                        <svg class="chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <ul class="mobile-accordion__panel">
                        <?php
                        $mob_solo = new WP_Query( [
                            'post_type'      => 'package',
                            'posts_per_page' => 6,
                            'post_status'    => 'publish',
                            'meta_query'     => [ [ 'key' => '_package_type', 'value' => 'Solo Trip', 'compare' => '=' ] ],
                        ] );
                        if ( $mob_solo->have_posts() ) :
                            while ( $mob_solo->have_posts() ) : $mob_solo->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata();
                        else : ?>
                        <li><a href="#">Ladakh Solo Trip</a></li>
                        <li><a href="#">Spiti Valley</a></li>
                        <li><a href="#">Rishikesh</a></li>
                        <li><a href="#">Rajasthan Solo</a></li>
                        <li><a href="#">Andaman Solo</a></li>
                        <li><a href="#">Northeast India</a></li>
                        <?php endif; ?>
                        <li class="mega-viewmore"><a href="<?php echo esc_url( travzo_get( 'travzo_menu_solo_all', home_url( '/packages?type=Solo+Trip' ) ) ); ?>">View All &rarr;</a></li>
                    </ul>
                </li>

                <li><a href="<?php echo esc_url( home_url( travzo_get( 'travzo_nav_blog_url', '/blog' ) ) ); ?>"><?php echo esc_html( travzo_get( 'travzo_nav_blog', 'Blog' ) ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( travzo_get( 'travzo_nav_about_url', '/about' ) ) ); ?>"><?php echo esc_html( travzo_get( 'travzo_nav_about', 'About' ) ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( travzo_get( 'travzo_nav_contact_url', '/contact' ) ) ); ?>"><?php echo esc_html( travzo_get( 'travzo_nav_contact', 'Contact' ) ); ?></a></li>

            </ul>
        </nav>

        <div class="mobile-drawer__footer">
            <a href="<?php echo esc_url( $hdr_phone_url ); ?>" class="mobile-cta-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 011 2.18 2 2 0 013 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/>
                </svg>
                <?php esc_html_e( 'Call Us Now', 'travzo' ); ?>
            </a>
        </div>

    </div><!-- /.mobile-drawer -->

    <div class="mobile-overlay" id="mobile-overlay" aria-hidden="true"></div>

</header><!-- /#site-header -->
