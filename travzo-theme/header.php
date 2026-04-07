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
            <?php $nav_items = travzo_get_menu_items(); ?>
            <nav class="primary-nav" id="primary-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'travzo' ); ?>">
                <ul class="nav-menu" role="menubar">
                    <?php foreach ( $nav_items as $nav_item ) :
                        if ( empty( $nav_item['visible'] ) ) continue;
                        $item_url   = esc_url( home_url( $nav_item['url'] ) );
                        $item_label = esc_html( $nav_item['label'] );
                        $has_mega   = ! empty( $nav_item['has_mega'] );
                        $mega       = $nav_item['mega'] ?? [];
                        $show_auto  = $has_mega && ! empty( $mega['auto_fetch'] );
                        $show_custom = $has_mega && ! empty( $mega['custom_links'] ) && ! empty( $mega['links'] );
                        $col_count  = ( $show_auto ? 1 : 0 ) + ( $show_custom ? 1 : 0 );
                    ?>
                    <li class="nav-item<?php echo $has_mega ? ' has-mega' : ''; ?>" role="none">
                        <a href="<?php echo $item_url; ?>" class="nav-link" role="menuitem"<?php if ( $has_mega ) : ?> aria-haspopup="true" aria-expanded="false"<?php endif; ?>>
                            <?php echo $item_label; ?>
                            <?php if ( $has_mega ) : ?>
                            <svg class="chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                            <?php endif; ?>
                        </a>
                        <?php if ( $has_mega && $col_count > 0 ) : ?>
                        <div class="mega-panel mega-panel--<?php echo $col_count; ?>col" role="region" aria-label="<?php echo $item_label; ?> menu">
                            <div class="mega-panel__inner">
                                <?php if ( $show_auto ) :
                                    $packages = travzo_fetch_menu_packages( $mega );
                                ?>
                                <div class="mega-col">
                                    <?php if ( ! empty( $mega['auto_label'] ) ) : ?>
                                    <h4 class="mega-col__heading"><?php echo esc_html( $mega['auto_label'] ); ?></h4>
                                    <?php endif; ?>
                                    <ul>
                                        <?php if ( ! empty( $packages ) ) :
                                            foreach ( $packages as $pkg ) : ?>
                                        <li><a href="<?php echo esc_url( $pkg['url'] ); ?>"><?php echo esc_html( $pkg['title'] ); ?></a></li>
                                        <?php endforeach;
                                        endif; ?>
                                        <?php if ( ! empty( $mega['auto_viewmore'] ) && ! empty( $mega['auto_viewmore_label'] ) ) :
                                            $vm_url = ! empty( $mega['auto_viewmore_url'] ) ? home_url( $mega['auto_viewmore_url'] ) : travzo_mega_viewmore_url( $mega );
                                        ?>
                                        <li class="mega-viewmore"><a href="<?php echo esc_url( $vm_url ); ?>"><?php echo esc_html( $mega['auto_viewmore_label'] ); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>

                                <?php if ( $show_custom ) : ?>
                                <div class="mega-col">
                                    <?php if ( ! empty( $mega['custom_label'] ) ) : ?>
                                    <h4 class="mega-col__heading"><?php echo esc_html( $mega['custom_label'] ); ?></h4>
                                    <?php endif; ?>
                                    <ul>
                                        <?php foreach ( $mega['links'] as $lnk ) :
                                            $lnk_url = ! empty( $lnk['url'] ) ? home_url( $lnk['url'] ) : '#';
                                        ?>
                                        <li><a href="<?php echo esc_url( $lnk_url ); ?>"><?php echo esc_html( $lnk['text'] ); ?></a></li>
                                        <?php endforeach; ?>
                                        <?php if ( ! empty( $mega['custom_viewmore'] ) && ! empty( $mega['custom_viewmore_label'] ) ) : ?>
                                        <li class="mega-viewmore"><a href="<?php echo esc_url( ! empty( $mega['custom_viewmore_url'] ) ? home_url( $mega['custom_viewmore_url'] ) : '#' ); ?>"><?php echo esc_html( $mega['custom_viewmore_label'] ); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
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
                <?php foreach ( $nav_items as $mob_item ) :
                    if ( empty( $mob_item['visible'] ) ) continue;
                    $mob_url   = esc_url( home_url( $mob_item['url'] ) );
                    $mob_label = esc_html( $mob_item['label'] );
                    $mob_mega  = ! empty( $mob_item['has_mega'] );
                    $mm        = $mob_item['mega'] ?? [];
                    $mob_auto  = $mob_mega && ! empty( $mm['auto_fetch'] );
                    $mob_cust  = $mob_mega && ! empty( $mm['custom_links'] ) && ! empty( $mm['links'] );

                    if ( $mob_mega && ( $mob_auto || $mob_cust ) ) :
                ?>
                <li class="mobile-accordion">
                    <button class="mobile-accordion__trigger" aria-expanded="false">
                        <?php echo $mob_label; ?>
                        <svg class="chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <ul class="mobile-accordion__panel">
                        <?php if ( $mob_auto ) :
                            $mob_packages = travzo_fetch_menu_packages( $mm );
                            foreach ( $mob_packages as $mp ) : ?>
                        <li><a href="<?php echo esc_url( $mp['url'] ); ?>"><?php echo esc_html( $mp['title'] ); ?></a></li>
                        <?php endforeach;
                        endif; ?>
                        <?php if ( $mob_cust ) :
                            foreach ( $mm['links'] as $ml ) : ?>
                        <li><a href="<?php echo esc_url( ! empty( $ml['url'] ) ? home_url( $ml['url'] ) : '#' ); ?>"><?php echo esc_html( $ml['text'] ); ?></a></li>
                        <?php endforeach;
                        endif; ?>
                        <?php if ( $mob_auto && ! empty( $mm['auto_viewmore'] ) && ! empty( $mm['auto_viewmore_label'] ) ) :
                            $mob_vm = ! empty( $mm['auto_viewmore_url'] ) ? home_url( $mm['auto_viewmore_url'] ) : travzo_mega_viewmore_url( $mm );
                        ?>
                        <li class="mega-viewmore"><a href="<?php echo esc_url( $mob_vm ); ?>"><?php echo esc_html( $mm['auto_viewmore_label'] ); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php else : ?>
                <li><a href="<?php echo $mob_url; ?>"><?php echo $mob_label; ?></a></li>
                <?php endif; endforeach; ?>
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
