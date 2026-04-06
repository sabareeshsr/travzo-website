<?php
/* ── Customizer: Footer settings ────────────────────────────────────────── */
$ftr_tagline       = travzo_get( 'travzo_footer_tagline', 'Your trusted travel partner for unforgettable journeys across India and the world.' );
$ftr_address       = travzo_get( 'travzo_footer_address', '123 Travel Street, Coimbatore,<br>Tamil Nadu 641001' );
$ftr_working_hours = travzo_get( 'travzo_footer_hours',   'Mon – Sat: 9:00 AM – 7:00 PM' );
$ftr_copyright     = travzo_get( 'travzo_footer_copyright', '' );

// Shared contact / social (same keys as header)
$ftr_phone     = travzo_get( 'travzo_phone',     '+91 XXXXX XXXXX' );
$ftr_email     = travzo_get( 'travzo_email',     'hello@travzoholidays.com' );
$ftr_instagram = travzo_get( 'travzo_instagram', '#' );
$ftr_facebook  = travzo_get( 'travzo_facebook',  '#' );
$ftr_youtube   = travzo_get( 'travzo_youtube',   '#' );
$ftr_whatsapp  = travzo_get( 'travzo_whatsapp',  '' );

// Derived URLs
$ftr_phone_url    = 'tel:' . preg_replace( '/[^+0-9]/', '', $ftr_phone );
$ftr_email_url    = 'mailto:' . sanitize_email( $ftr_email );
$ftr_whatsapp_url = $ftr_whatsapp
    ? 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $ftr_whatsapp )
    : '#';

// Copyright line: use Customizer value if set, otherwise build default
$ftr_copy_line = $ftr_copyright
    ? $ftr_copyright
    : sprintf(
        /* translators: %s = current year */
        __( '&copy; %s Travzo Holidays. All Rights Reserved.', 'travzo' ),
        esc_html( gmdate( 'Y' ) )
    );
?>
<footer id="site-footer">

    <!-- ══════════════════════════════════════════════════
         FOOTER MAIN
    ══════════════════════════════════════════════════ -->
    <div class="footer-main">
        <div class="footer-main__inner">

            <!-- ── Column 1: Logo & About ─────────────────────── -->
            <div class="footer-col footer-col--about">

                <div class="footer-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo__link">
                        <?php if ( has_custom_logo() ) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <span class="footer-logo__text"><?php bloginfo( 'name' ); ?></span>
                        <?php endif; ?>
                    </a>
                </div>

                <p class="footer-tagline">
                    <?php echo esc_html( $ftr_tagline ); ?>
                </p>

                <div class="footer-social">
                    <a href="<?php echo esc_url( $ftr_instagram ); ?>" class="footer-social__btn" aria-label="<?php esc_attr_e( 'Follow us on Instagram', 'travzo' ); ?>"<?php echo ( $ftr_instagram !== '#' ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url( $ftr_facebook ); ?>" class="footer-social__btn" aria-label="<?php esc_attr_e( 'Follow us on Facebook', 'travzo' ); ?>"<?php echo ( $ftr_facebook !== '#' ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url( $ftr_youtube ); ?>" class="footer-social__btn" aria-label="<?php esc_attr_e( 'Subscribe on YouTube', 'travzo' ); ?>"<?php echo ( $ftr_youtube !== '#' ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/>
                            <polygon fill="currentColor" stroke="none" points="9.75,15.02 15.5,12 9.75,8.98"/>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url( $ftr_whatsapp_url ); ?>" class="footer-social__btn" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'travzo' ); ?>" target="_blank" rel="noopener noreferrer">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>
                </div>

            </div><!-- /.footer-col--about -->

            <!-- ── Column 2: Quick Links ──────────────────────── -->
            <div class="footer-col footer-col--links">
                <h4 class="footer-col__heading">Quick Links</h4>
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer-menu',
                    'container'      => false,
                    'menu_class'     => 'footer-link-list',
                    'fallback_cb'    => function() {
                        // Fallback list if no menu is assigned
                        $links = [
                            home_url( '/' )                    => __( 'Home', 'travzo' ),
                            home_url( '/about' )               => __( 'About Us', 'travzo' ),
                            home_url( '/blog' )                => __( 'Blog', 'travzo' ),
                            home_url( '/faq' )                 => __( 'FAQs', 'travzo' ),
                            home_url( '/media' )               => __( 'Media', 'travzo' ),
                            home_url( '/contact' )             => __( 'Contact Us', 'travzo' ),
                            home_url( '/privacy-policy' )      => __( 'Privacy Policy', 'travzo' ),
                            home_url( '/terms-conditions' )    => __( 'Terms &amp; Conditions', 'travzo' ),
                            home_url( '/cancellation-policy' ) => __( 'Cancellation Policy', 'travzo' ),
                        ];
                        echo '<ul class="footer-link-list">';
                        foreach ( $links as $url => $label ) {
                            printf(
                                '<li><a href="%s">%s</a></li>',
                                esc_url( $url ),
                                $label
                            );
                        }
                        echo '</ul>';
                    },
                ] );
                ?>
            </div><!-- /.footer-col--links -->

            <!-- ── Column 3: Our Packages ────────────────────── -->
            <div class="footer-col footer-col--packages">
                <h4 class="footer-col__heading">Our Packages</h4>
                <ul class="footer-link-list">
                    <?php
                    $footer_pkg_types = [
                        'Group Tours'          => 'Group Tour',
                        'Honeymoon Packages'   => 'Honeymoon',
                        'Solo Trips'           => 'Solo Trip',
                        'Devotional Tours'     => 'Devotional',
                        'Destination Weddings' => 'Destination Wedding',
                        'International'        => 'International',
                    ];
                    foreach ( $footer_pkg_types as $display => $meta_val ) :
                    ?>
                    <li><a href="<?php echo esc_url( home_url( '/packages?type=' . urlencode( $meta_val ) ) ); ?>"><?php echo esc_html( $display ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div><!-- /.footer-col--packages -->

            <!-- ── Column 4: Contact Us ───────────────────────── -->
            <div class="footer-col footer-col--contact">
                <h4 class="footer-col__heading">Contact Us</h4>

                <!-- Address -->
                <div class="footer-contact-item">
                    <svg class="footer-contact-item__icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span class="footer-contact-item__text">
                        <?php echo wp_kses( $ftr_address, [ 'br' => [] ] ); ?>
                    </span>
                </div>

                <!-- Phone -->
                <div class="footer-contact-item">
                    <svg class="footer-contact-item__icon footer-contact-item__icon--gold" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 011 2.18 2 2 0 013 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/>
                    </svg>
                    <a href="<?php echo esc_url( $ftr_phone_url ); ?>" class="footer-contact-item__link footer-contact-item__link--gold">
                        <?php echo esc_html( $ftr_phone ); ?>
                    </a>
                </div>

                <!-- Email -->
                <div class="footer-contact-item">
                    <svg class="footer-contact-item__icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <a href="<?php echo esc_url( $ftr_email_url ); ?>" class="footer-contact-item__link">
                        <?php echo esc_html( $ftr_email ); ?>
                    </a>
                </div>

                <!-- WhatsApp button -->
                <a href="<?php echo esc_url( $ftr_whatsapp_url ); ?>"
                   class="footer-whatsapp-btn"
                   target="_blank"
                   rel="noopener noreferrer">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <?php esc_html_e( 'Chat on WhatsApp', 'travzo' ); ?>
                </a>

                <!-- Working hours -->
                <div class="footer-contact-item footer-contact-item--muted">
                    <svg class="footer-contact-item__icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span class="footer-contact-item__text"><?php echo esc_html( $ftr_working_hours ); ?></span>
                </div>

            </div><!-- /.footer-col--contact -->

        </div><!-- /.footer-main__inner -->
    </div><!-- /.footer-main -->

    <!-- ══════════════════════════════════════════════════
         GOLD DIVIDER
    ══════════════════════════════════════════════════ -->
    <div class="footer-divider"></div>

    <!-- ══════════════════════════════════════════════════
         FOOTER BOTTOM BAR
    ══════════════════════════════════════════════════ -->
    <div class="footer-bottom">
        <div class="footer-bottom__inner">
            <p class="footer-bottom__copy">
                <?php echo wp_kses_post( $ftr_copy_line ); ?>
            </p>
            <nav class="footer-bottom__nav" aria-label="<?php esc_attr_e( 'Legal Navigation', 'travzo' ); ?>">
                <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'travzo' ); ?></a>
                <span class="footer-bottom__sep" aria-hidden="true">|</span>
                <a href="<?php echo esc_url( home_url( '/terms-conditions' ) ); ?>"><?php esc_html_e( 'Terms &amp; Conditions', 'travzo' ); ?></a>
                <span class="footer-bottom__sep" aria-hidden="true">|</span>
                <a href="<?php echo esc_url( home_url( '/cancellation-policy' ) ); ?>"><?php esc_html_e( 'Cancellation Policy', 'travzo' ); ?></a>
            </nav>
        </div>
    </div><!-- /.footer-bottom -->

</footer><!-- /#site-footer -->

<?php wp_footer(); ?>
</body>
</html>
