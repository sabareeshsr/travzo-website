<?php
/**
 * Template Name: Contact Page
 * Template Post Type: page
 *
 * @package Travzo
 *
 * Forms are submitted via AJAX to the travzo_handle_form_submit() handler
 * in functions.php. No server-side form processing needed in this template.
 */

/* ── Native meta / Customizer fields ────────────────────────────────────── */
$post_id      = get_the_ID();

// Hero (from Page Hero meta box)
$hero_heading = get_post_meta( $post_id, '_page_hero_title', true );
$hero_desc    = get_post_meta( $post_id, '_page_hero_subtitle', true );
$hero_img     = get_post_meta( $post_id, '_page_hero_image', true );
if ( '' === $hero_heading ) $hero_heading = travzo_get( 'travzo_contact_hero_title', 'Get In Touch' );
if ( '' === $hero_desc )    $hero_desc    = travzo_get( 'travzo_contact_hero_desc',  "We\u2019d love to hear from you. Reach out to plan your next adventure." );
if ( '' === $hero_img )     $hero_img     = travzo_get( 'travzo_contact_hero_image', '' );

// Contact Information Card
$ci_heading       = get_post_meta( $post_id, '_contact_info_heading', true );
$ci_subtext       = get_post_meta( $post_id, '_contact_info_subtext', true );
$ci_address_label = get_post_meta( $post_id, '_contact_info_address_label', true );
$ci_address       = get_post_meta( $post_id, '_contact_info_address', true );
$ci_phone_label   = get_post_meta( $post_id, '_contact_info_phone_label', true );
$ci_phone         = get_post_meta( $post_id, '_contact_info_phone', true );
$ci_email_label   = get_post_meta( $post_id, '_contact_info_email_label', true );
$ci_email         = get_post_meta( $post_id, '_contact_info_email', true );
$ci_hours_label   = get_post_meta( $post_id, '_contact_info_hours_label', true );
$ci_hours         = get_post_meta( $post_id, '_contact_info_hours', true );
$ci_follow_label  = get_post_meta( $post_id, '_contact_info_follow_label', true );
$ci_show_follow   = get_post_meta( $post_id, '_contact_info_show_follow', true );
// Defaults / backward compat
if ( '' === $ci_heading )       $ci_heading       = 'Contact Information';
if ( '' === $ci_subtext )       $ci_subtext       = "We\u2019re here to help you plan the perfect trip.";
if ( '' === $ci_address_label ) $ci_address_label = 'Address';
if ( '' === $ci_address )       $ci_address       = travzo_get( 'travzo_address', '123 Travel Street, Chennai, Tamil Nadu 600001' );
if ( '' === $ci_phone_label )   $ci_phone_label   = 'Phone';
if ( '' === $ci_phone )         $ci_phone         = travzo_get( 'travzo_phone', '+91 99900 88888' );
if ( '' === $ci_email_label )   $ci_email_label   = 'Email';
if ( '' === $ci_email )         $ci_email         = travzo_get( 'travzo_email', 'hello1@travzo.com' );
if ( '' === $ci_hours_label )   $ci_hours_label   = 'Working Hours';
if ( '' === $ci_hours )         $ci_hours         = travzo_get( 'travzo_hours', "Mon \u2013 Sat: 9:00 AM \u2013 7:00 PM" );
if ( '' === $ci_follow_label )  $ci_follow_label  = 'Follow Us';
if ( '' === $ci_show_follow )   $ci_show_follow   = '1';

$c_whatsapp  = travzo_get( 'travzo_whatsapp', '' );
$s_instagram = travzo_get( 'travzo_instagram', '#' );
$s_facebook  = travzo_get( 'travzo_facebook',  '#' );
$s_youtube   = travzo_get( 'travzo_youtube',   '#' );

$c_phone_url    = 'tel:' . preg_replace( '/[^+0-9]/', '', $ci_phone );
$c_email_url    = 'mailto:' . sanitize_email( $ci_email );
$c_whatsapp_url = $c_whatsapp ? 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $c_whatsapp ) : '#';

// Message form section
$cf_heading = get_post_meta( $post_id, '_contact_form_heading', true );
$cf_subtext = get_post_meta( $post_id, '_contact_form_subtext', true );
if ( '' === $cf_heading ) $cf_heading = 'Send Us a Message';
if ( '' === $cf_subtext ) $cf_subtext = "Fill in the form below and we\u2019ll get back to you shortly.";

// Branches section
$br_visible  = get_post_meta( $post_id, '_contact_branches_visible', true );
$br_label    = get_post_meta( $post_id, '_contact_branches_label', true );
$br_heading  = get_post_meta( $post_id, '_contact_branches_heading', true );
$br_subtext  = get_post_meta( $post_id, '_contact_branches_subtext', true );
$branches    = get_post_meta( $post_id, '_contact_branches', true );
if ( '' === $br_visible ) $br_visible = '1';
if ( '' === $br_label )   $br_label   = 'Our Presence';
if ( '' === $br_heading ) $br_heading = 'Find Us Near You';
if ( '' === $br_subtext ) $br_subtext = 'Visit any of our offices across Tamil Nadu for in-person consultations.';
// Backward compat: parse old pipe-separated _branches
if ( ! is_array( $branches ) || empty( $branches ) ) {
    $old = get_post_meta( $post_id, '_branches', true );
    if ( is_string( $old ) && '' !== trim( $old ) ) {
        $parsed = travzo_parse_lines( $old, 3 );
        $branches = [];
        foreach ( $parsed as $row ) {
            $branches[] = [ 'city' => $row[0] ?? '', 'address' => $row[1] ?? '', 'phone' => $row[2] ?? '', 'email' => '', 'map_url' => '' ];
        }
    }
}
if ( ! is_array( $branches ) || empty( $branches ) ) {
    $branches = [
        [ 'city' => 'Chennai',     'address' => '123 Anna Salai, Chennai 600002',                 'phone' => '+91 44 2345 6789',  'email' => '', 'map_url' => '' ],
        [ 'city' => 'Coimbatore',  'address' => '45 Avinashi Road, Coimbatore 641018',            'phone' => '+91 422 234 5678',  'email' => '', 'map_url' => '' ],
        [ 'city' => 'Madurai',     'address' => '78 Bypass Road, Madurai 625010',                 'phone' => '+91 452 234 5678',  'email' => '', 'map_url' => '' ],
        [ 'city' => 'Trichy',      'address' => '12 Rockfort Road, Trichy 620001',                'phone' => '+91 431 234 5678',  'email' => '', 'map_url' => '' ],
        [ 'city' => 'Salem',       'address' => '56 Omalur Main Road, Salem 636004',              'phone' => '+91 427 234 5678',  'email' => '', 'map_url' => '' ],
        [ 'city' => 'Tirunelveli', 'address' => '34 Palayamkottai Road, Tirunelveli 627002',      'phone' => '+91 462 234 5678',  'email' => '', 'map_url' => '' ],
        [ 'city' => 'Vellore',     'address' => '89 Katpadi Road, Vellore 632001',                'phone' => '+91 416 234 5678',  'email' => '', 'map_url' => '' ],
        [ 'city' => 'Pondicherry', 'address' => '22 Jawaharlal Nehru Street, Pondicherry 605001', 'phone' => '+91 413 234 5678',  'email' => '', 'map_url' => '' ],
    ];
}

get_header(); ?>

<main id="main-content">

    <!-- ══ 1. HERO ══════════════════════════════════════════════════════════ -->
    <?php $_c_hero_style = $hero_img ? 'background-image:url(' . esc_url( $hero_img ) . ');background-size:cover;background-position:center' : ''; ?>
    <section class="page-hero"<?php if ( $_c_hero_style ) : ?> style="<?php echo $_c_hero_style; ?>"<?php endif; ?>>
        <div class="page-hero-overlay"></div>
        <div class="section-inner">
            <div class="page-hero__content">
                <nav class="page-hero__breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                    <span aria-hidden="true"> / </span>
                    <span>Contact</span>
                </nav>
                <h1 class="page-hero__heading"><?php echo esc_html( $hero_heading ); ?></h1>
                <p class="page-hero__subtext"><?php echo esc_html( $hero_desc ); ?></p>
            </div>
        </div>
    </section>

    <!-- ══ 2. CONTACT GRID ══════════════════════════════════════════════════ -->
    <section class="contact-section">
        <div class="section-inner">
            <div class="contact-grid">

                <!-- Left: Info card -->
                <div class="contact-info-card">
                    <div class="contact-info-card__header">
                        <h2><?php echo esc_html( $ci_heading ); ?></h2>
                        <p><?php echo esc_html( $ci_subtext ); ?></p>
                    </div>

                    <ul class="contact-info-list">
                        <li class="contact-info-item">
                            <span class="contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            <div class="contact-info-text">
                                <strong><?php echo esc_html( $ci_address_label ); ?></strong>
                                <?php echo wp_kses( nl2br( esc_html( $ci_address ) ), [ 'br' => [] ] ); ?>
                            </div>
                        </li>
                        <li class="contact-info-item">
                            <span class="contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div class="contact-info-text">
                                <strong><?php echo esc_html( $ci_phone_label ); ?></strong>
                                <a href="<?php echo esc_url( $c_phone_url ); ?>"><?php echo esc_html( $ci_phone ); ?></a>
                            </div>
                        </li>
                        <li class="contact-info-item">
                            <span class="contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <div class="contact-info-text">
                                <strong><?php echo esc_html( $ci_email_label ); ?></strong>
                                <a href="<?php echo esc_url( $c_email_url ); ?>"><?php echo esc_html( $ci_email ); ?></a>
                            </div>
                        </li>
                        <li class="contact-info-item">
                            <span class="contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </span>
                            <div class="contact-info-text">
                                <strong><?php echo esc_html( $ci_hours_label ); ?></strong>
                                <?php echo esc_html( $ci_hours ); ?>
                            </div>
                        </li>
                        <?php if ( $c_whatsapp ) : ?>
                        <li class="contact-info-item">
                            <span class="contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </span>
                            <div class="contact-info-text">
                                <strong>WhatsApp</strong>
                                <a href="<?php echo esc_url( $c_whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $c_whatsapp ); ?></a>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <?php if ( '1' === $ci_show_follow ) : ?>
                    <div class="contact-social">
                        <p class="contact-social__label"><?php echo esc_html( $ci_follow_label ); ?></p>
                        <div class="contact-social__links">
                            <?php if ( $s_facebook !== '#' ) : ?>
                            <a href="<?php echo esc_url( $s_facebook ); ?>" class="contact-social-icon" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <?php endif; ?>
                            <?php if ( $s_instagram !== '#' ) : ?>
                            <a href="<?php echo esc_url( $s_instagram ); ?>" class="contact-social-icon" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                            <?php endif; ?>
                            <?php if ( $s_youtube !== '#' ) : ?>
                            <a href="<?php echo esc_url( $s_youtube ); ?>" class="contact-social-icon" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div><!-- /.contact-info-card -->

                <!-- Right: Form card -->
                <div class="contact-form-card">

                    <div class="contact-form-card__header">
                        <h2><?php echo esc_html( $cf_heading ); ?></h2>
                        <p><?php echo esc_html( $cf_subtext ); ?></p>
                    </div>

                    <form class="travzo-form contact-form" data-form-type="contact" novalidate>
                        <?php wp_nonce_field( 'travzo_form_submit', 'travzo_form_nonce' ); ?>
                        <input type="hidden" name="action" value="travzo_form_submit">
                        <input type="hidden" name="form_type" value="contact">

                        <div class="cform-row">
                            <div class="cform-group">
                                <label for="cf_name">Full Name <span aria-hidden="true">*</span></label>
                                <input type="text" id="cf_name" name="full_name" placeholder="John Doe" required>
                            </div>
                            <div class="cform-group">
                                <label for="cf_email">Email Address <span aria-hidden="true">*</span></label>
                                <input type="email" id="cf_email" name="email" placeholder="john@example.com" required>
                            </div>
                        </div>

                        <div class="cform-row">
                            <div class="cform-group">
                                <label for="cf_phone">Phone Number</label>
                                <input type="text" id="cf_phone" name="phone" placeholder="+91 98765 43210">
                            </div>
                            <div class="cform-group">
                                <label for="cf_trip">Trip Type</label>
                                <select id="cf_trip" name="trip_type">
                                    <option value="">Select trip type</option>
                                    <option value="Group Tour">Group Tour</option>
                                    <option value="Honeymoon">Honeymoon</option>
                                    <option value="Solo Trip">Solo Trip</option>
                                    <option value="Devotional">Devotional</option>
                                    <option value="Destination Wedding">Destination Wedding</option>
                                </select>
                            </div>
                        </div>

                        <div class="cform-row">
                            <div class="cform-group">
                                <label for="cf_dest">Preferred Destination</label>
                                <input type="text" id="cf_dest" name="destination" placeholder="e.g. Kerala, Manali, Thailand">
                            </div>
                            <div class="cform-row__half">
                                <div class="cform-group">
                                    <label for="cf_travel">Travel Date</label>
                                    <input type="text" id="cf_travel" name="travel_date" placeholder="DD-MM-YYYY">
                                </div>
                                <div class="cform-group">
                                    <label for="cf_guests">No. of Guests</label>
                                    <select id="cf_guests" name="guests">
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
                            <label for="cf_message">Message</label>
                            <textarea id="cf_message" name="message" rows="4" placeholder="Tell us about your dream trip..."></textarea>
                        </div>

                        <?php travzo_render_captcha(); ?>

                        <button type="submit" class="btn btn--gold btn--full form-submit-btn">
                            Send Message
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </button>
                        <div class="form-success" style="display:none">Thank you! We'll get back to you within 24 hours.</div>
                        <div class="form-error" style="display:none">Something went wrong. Please try again.</div>
                    </form>

                </div><!-- /.contact-form-card -->

            </div><!-- /.contact-grid -->
        </div>
    </section>

    <!-- ══ 3. BRANCHES ══════════════════════════════════════════════════════ -->
    <?php if ( '1' === $br_visible ) : ?>
    <section class="branches-section">
        <div class="section-inner">
            <div class="section-heading">
                <span class="section-label"><?php echo esc_html( $br_label ); ?></span>
                <h2><?php echo esc_html( $br_heading ); ?></h2>
                <p><?php echo esc_html( $br_subtext ); ?></p>
            </div>

            <div class="branches-grid">
                <?php foreach ( $branches as $branch ) :
                    $b_city    = $branch['city'] ?? '';
                    $b_address = $branch['address'] ?? '';
                    $b_phone   = $branch['phone'] ?? '';
                    $b_email   = $branch['email'] ?? '';
                    $b_map_url = $branch['map_url'] ?? '';
                    $b_tel_url = $b_phone ? 'tel:' . preg_replace( '/[^+0-9]/', '', $b_phone ) : '';
                ?>
                <div class="branch-card">
                    <div class="branch-card__icon" aria-hidden="true">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                    </div>
                    <h3 class="branch-card__city"><?php echo esc_html( $b_city ); ?></h3>
                    <?php if ( $b_address ) : ?>
                    <p class="branch-card__address"><?php echo esc_html( $b_address ); ?></p>
                    <?php endif; ?>
                    <div class="branch-card__contacts">
                        <?php if ( $b_phone ) : ?>
                        <a href="<?php echo esc_url( $b_tel_url ); ?>" class="branch-card__contact-link">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <?php echo esc_html( $b_phone ); ?>
                        </a>
                        <?php endif; ?>
                        <?php if ( $b_email ) : ?>
                        <a href="mailto:<?php echo esc_attr( sanitize_email( $b_email ) ); ?>" class="branch-card__contact-link">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <?php echo esc_html( $b_email ); ?>
                        </a>
                        <?php endif; ?>
                        <?php if ( $b_map_url ) : ?>
                        <a href="<?php echo esc_url( $b_map_url ); ?>" class="branch-card__contact-link" target="_blank" rel="noopener noreferrer">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            Get Directions
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
