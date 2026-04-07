<?php
/**
 * Template Name: About Page
 * Template Post Type: page
 *
 * @package Travzo
 */

// ── Native post meta reads ─────────────────────────────────────────────────────
$post_id = get_the_ID();

// Hero (from Page Hero meta box)
$hero_heading = get_post_meta( $post_id, '_page_hero_title', true );
$hero_subtext = get_post_meta( $post_id, '_page_hero_subtitle', true );
$hero_image   = get_post_meta( $post_id, '_page_hero_image', true );
if ( '' === $hero_heading ) $hero_heading = travzo_get( 'travzo_about_hero_title', 'About Travzo Holidays' );
if ( '' === $hero_subtext ) $hero_subtext = travzo_get( 'travzo_about_hero_desc',  'Your trusted travel partner crafting unforgettable journeys across India and the world' );
if ( '' === $hero_image )   $hero_image   = travzo_get( 'travzo_about_hero_image', '' );
$hero_style   = $hero_image ? 'background-image:url(' . esc_url( $hero_image ) . ');background-size:cover;background-position:center' : '';

// Our Story section
$story_label     = get_post_meta( $post_id, '_about_story_label', true );
$story_heading   = get_post_meta( $post_id, '_about_story_heading', true );
$story_text      = get_post_meta( $post_id, '_about_story_text', true );
$story_image     = get_post_meta( $post_id, '_about_story_image', true );
$story_keypoints = get_post_meta( $post_id, '_about_story_keypoints', true );
$story_btn_text  = get_post_meta( $post_id, '_about_story_btn_text', true );
$story_btn_url   = get_post_meta( $post_id, '_about_story_btn_url', true );
// Backward compat
if ( '' === $story_label )   $story_label   = travzo_get( 'travzo_about_story_label', 'OUR STORY' );
if ( '' === $story_heading ) $story_heading = travzo_get( 'travzo_about_story_heading', 'Who We Are' );
// Defaults
if ( ! $story_label )      $story_label      = 'OUR STORY';
if ( ! $story_heading )    $story_heading    = 'Who We Are';
if ( ! $story_keypoints )  $story_keypoints  = "Handcrafted Itineraries\nBest Price Guarantee\n24/7 Support\nExpert Local Knowledge";
if ( ! $story_btn_text )   $story_btn_text   = 'Explore Our Packages';
if ( ! $story_btn_url )    $story_btn_url    = '/packages';
$story_features = array_filter( array_map( 'trim', explode( "\n", $story_keypoints ) ) );

// Stats Bar section
$stats_visible = get_post_meta( $post_id, '_about_stats_visible', true );
$about_stats   = get_post_meta( $post_id, '_about_stats', true );
if ( '' === $stats_visible ) $stats_visible = '1';
if ( ! is_array( $about_stats ) || empty( $about_stats ) ) {
    $about_stats = [
        [ 'number' => travzo_get( 'travzo_about_stat1_number', '500+' ), 'label' => travzo_get( 'travzo_about_stat1_label', 'Happy Travellers' ) ],
        [ 'number' => travzo_get( 'travzo_about_stat2_number', '50+' ),  'label' => travzo_get( 'travzo_about_stat2_label', 'Destinations' ) ],
        [ 'number' => travzo_get( 'travzo_about_stat3_number', '10+' ),  'label' => travzo_get( 'travzo_about_stat3_label', 'Years Experience' ) ],
        [ 'number' => travzo_get( 'travzo_about_stat4_number', '100%' ), 'label' => travzo_get( 'travzo_about_stat4_label', 'Customised Itineraries' ) ],
    ];
}

// Why Travel With Us section
$whyus_label   = get_post_meta( $post_id, '_about_whyus_label', true );
$whyus_heading = get_post_meta( $post_id, '_about_whyus_heading', true );
$whyus_tiles   = get_post_meta( $post_id, '_about_whyus_tiles', true );
if ( '' === $whyus_label )   $whyus_label   = travzo_get( 'travzo_about_whyus_label', 'WHY TRAVZO' );
if ( '' === $whyus_heading ) $whyus_heading = travzo_get( 'travzo_about_whyus_heading', 'Why Travel With Us' );
if ( ! is_array( $whyus_tiles ) || empty( $whyus_tiles ) ) $whyus_tiles = [];

// Accreditation Partners section
$accred_visible  = get_post_meta( $post_id, '_about_accreditation_visible', true );
$accred_label    = get_post_meta( $post_id, '_about_accreditation_label', true );
$accred_heading  = get_post_meta( $post_id, '_about_accreditation_heading', true );
$accred_partners = get_post_meta( $post_id, '_about_accreditation_partners', true );
if ( '' === $accred_visible ) $accred_visible = '1';
if ( '' === $accred_label )   $accred_label   = travzo_get( 'travzo_about_accreditation_label', 'TRUSTED BY' );
if ( '' === $accred_heading ) $accred_heading = travzo_get( 'travzo_about_accreditation_heading', 'Our Accreditation Partners' );
if ( ! is_array( $accred_partners ) || empty( $accred_partners ) ) {
    // Backward compat: old pipe-separated _about_accreditations
    $old_accred = travzo_parse_lines( get_post_meta( $post_id, '_about_accreditations', true ), 2 );
    if ( ! empty( $old_accred ) ) {
        $accred_partners = [];
        foreach ( $old_accred as $oa ) {
            $accred_partners[] = [ 'name' => $oa[0] ?? '', 'logo' => $oa[1] ?? '', 'url' => '' ];
        }
    }
}

// Testimonials section
$test_label   = get_post_meta( $post_id, '_about_testimonials_label', true );
$test_heading = get_post_meta( $post_id, '_about_testimonials_heading', true );
$test_items   = get_post_meta( $post_id, '_about_testimonials', true );
if ( '' === $test_label )   $test_label   = travzo_get( 'travzo_about_testimonials_label', 'HAPPY TRAVELLERS' );
if ( '' === $test_heading ) $test_heading = travzo_get( 'travzo_about_testimonials_heading', 'What Our Travellers Say' );
if ( ! is_array( $test_items ) || empty( $test_items ) ) {
    $test_items = [
        [ 'name' => 'Priya & Arjun',       'trip' => 'Maldives Honeymoon Package',  'quote' => 'Travzo made our Maldives honeymoon absolutely magical. Every detail was perfect — from the transfers to the overwater villa. Truly a trip we will remember forever.', 'rating' => 5 ],
        [ 'name' => 'Ramesh Kumar',         'trip' => 'Kerala Group Tour',           'quote' => 'The Kerala group tour was beyond our expectations. The team handled everything seamlessly and the itinerary was perfectly planned with the right balance of sightseeing and leisure.', 'rating' => 5 ],
        [ 'name' => 'Meenakshi Sundaram',   'trip' => 'Char Dham Devotional Tour',   'quote' => 'Our Char Dham pilgrimage was a deeply spiritual experience. Travzo took care of every arrangement with so much respect and care. Highly recommend for devotional tours.', 'rating' => 5 ],
    ];
}

// CTA section
$cta_visible   = get_post_meta( $post_id, '_about_cta_visible', true );
$cta_heading   = get_post_meta( $post_id, '_about_cta_heading', true );
$cta_desc      = get_post_meta( $post_id, '_about_cta_description', true );
$cta_btn1_text = get_post_meta( $post_id, '_about_cta_btn1_text', true );
$cta_btn1_url  = get_post_meta( $post_id, '_about_cta_btn1_url', true );
$cta_btn2_text = get_post_meta( $post_id, '_about_cta_btn2_text', true );
$cta_btn2_url  = get_post_meta( $post_id, '_about_cta_btn2_url', true );
if ( '' === $cta_visible )   $cta_visible   = '1';
if ( '' === $cta_heading )   $cta_heading   = travzo_get( 'travzo_about_cta_heading', 'Ready to Start Your Journey?' );
if ( '' === $cta_desc )      $cta_desc      = travzo_get( 'travzo_about_cta_description', 'Let us help you create memories that last a lifetime' );
if ( '' === $cta_btn1_text ) $cta_btn1_text = travzo_get( 'travzo_about_cta_btn1_text', 'Explore Packages' );
if ( '' === $cta_btn1_url )  $cta_btn1_url  = travzo_get( 'travzo_about_cta_btn1_url', '/packages' );
if ( '' === $cta_btn2_text ) $cta_btn2_text = travzo_get( 'travzo_about_cta_btn2_text', 'Contact Us' );
if ( '' === $cta_btn2_url )  $cta_btn2_url  = travzo_get( 'travzo_about_cta_btn2_url', '/contact' );

get_header();
?>

<main id="main-content">


<!-- ════════════════════════════════════════════════════════════
     SECTION 1 – PAGE HERO
════════════════════════════════════════════════════════════ -->
<section class="page-hero"<?php if ( $hero_style ) : ?> style="<?php echo $hero_style; ?>"<?php endif; ?>>
    <div class="page-hero-overlay"></div>
    <div class="page-hero__content">

        <nav class="page-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'travzo' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'travzo' ); ?></a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
            <span><?php esc_html_e( 'About Us', 'travzo' ); ?></span>
        </nav>

        <h1 class="page-hero__heading"><?php echo esc_html( $hero_heading ); ?></h1>
        <p class="page-hero__subtext"><?php echo esc_html( $hero_subtext ); ?></p>

    </div>
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 2 – OUR STORY
════════════════════════════════════════════════════════════ -->
<section class="about-snippet">
    <div class="section-inner about-snippet__inner">

        <!-- Left: image -->
        <div class="about-snippet__image-wrap">
            <?php if ( $story_image ) : ?>
                <img src="<?php echo esc_url( $story_image ); ?>"
                     alt="<?php esc_attr_e( 'About Travzo Holidays', 'travzo' ); ?>"
                     class="about-snippet__image" loading="lazy">
            <?php else : ?>
                <div class="about-snippet__image-placeholder">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" aria-hidden="true">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: content -->
        <div class="about-snippet__content">
            <div class="section-label"><?php echo esc_html( $story_label ); ?></div>
            <h2 class="section-heading section-heading--left"><?php echo esc_html( $story_heading ); ?></h2>

            <?php if ( $story_text ) : ?>
                <p class="about-snippet__text"><?php echo wp_kses_post( $story_text ); ?></p>
            <?php else : ?>
                <p class="about-snippet__text"><?php esc_html_e( 'Travzo Holidays was founded with a simple yet powerful vision — to make exceptional travel accessible to every Indian family, couple, and group. Based in Tamil Nadu, we have spent over a decade crafting journeys that go beyond sightseeing to create genuinely life-changing experiences.', 'travzo' ); ?></p>
            <?php endif; ?>

            <ul class="about-features">
                <?php foreach ( $story_features as $feature ) : ?>
                <li class="about-feature">
                    <svg class="about-feature__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <?php echo esc_html( $feature ); ?>
                </li>
                <?php endforeach; ?>
            </ul>

            <a href="<?php echo esc_url( home_url( $story_btn_url ) ); ?>" class="btn btn--navy">
                <?php echo esc_html( $story_btn_text ); ?>
            </a>
        </div>

    </div>
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 3 – STATS BAR
════════════════════════════════════════════════════════════ -->
<?php if ( '1' === $stats_visible && ! empty( $about_stats ) ) : ?>
<section class="stats-section">
    <div class="stats-inner">
        <?php foreach ( $about_stats as $si => $stat ) : ?>
            <?php if ( $si > 0 ) : ?><div class="stat-divider" aria-hidden="true"></div><?php endif; ?>
            <div class="stat-block">
                <div class="stat-number"><?php echo esc_html( $stat['number'] ?? '' ); ?></div>
                <div class="stat-label"><?php echo esc_html( $stat['label'] ?? '' ); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>


<!-- ════════════════════════════════════════════════════════════
     SECTION 4 – WHY TRAVEL WITH US
════════════════════════════════════════════════════════════ -->
<section class="why-us-section about-why-us">
    <div class="section-container">

        <div class="section-label"><?php echo esc_html( $whyus_label ); ?></div>
        <h2 class="section-heading"><?php echo esc_html( $whyus_heading ); ?></h2>

        <div class="features-grid features-grid-6">
            <?php if ( ! empty( $whyus_tiles ) ) :
                foreach ( $whyus_tiles as $tile ) : ?>
            <div class="feature-block">
                <div class="feature-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                </div>
                <h3><?php echo esc_html( $tile['title'] ?? '' ); ?></h3>
                <p><?php echo esc_html( $tile['desc'] ?? '' ); ?></p>
            </div>
            <?php endforeach;
            else : ?>
            <div class="feature-block">
                <div class="feature-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg></div>
                <h3><?php esc_html_e( 'Handcrafted Itineraries', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Every trip designed around your preferences, budget and travel style.', 'travzo' ); ?></p>
            </div>
            <div class="feature-block">
                <div class="feature-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                <h3><?php esc_html_e( 'Best Price Guarantee', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Direct partnerships with hotels and operators for the best rates.', 'travzo' ); ?></p>
            </div>
            <div class="feature-block">
                <div class="feature-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.06 6.06l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
                <h3><?php esc_html_e( '24/7 Dedicated Support', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Our experts are available round the clock before, during and after your trip.', 'travzo' ); ?></p>
            </div>
            <div class="feature-block">
                <div class="feature-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></div>
                <h3><?php esc_html_e( 'Visa Assistance', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Complete visa guidance and documentation support for all international destinations.', 'travzo' ); ?></p>
            </div>
            <div class="feature-block">
                <div class="feature-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <h3><?php esc_html_e( 'Group Expertise', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Specialists in group tours with dedicated managers and seamless coordination.', 'travzo' ); ?></p>
            </div>
            <div class="feature-block">
                <div class="feature-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <h3><?php esc_html_e( 'Devotional Specialists', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Deep expertise in pilgrimage and devotional tours across India and internationally.', 'travzo' ); ?></p>
            </div>
            <?php endif; ?>
        </div><!-- /.features-grid -->
    </div><!-- /.section-container -->
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 5 – ACCREDITATION PARTNERS
════════════════════════════════════════════════════════════ -->
<?php if ( '1' === $accred_visible ) : ?>
<section class="accreditations-section">
    <div class="section-container">

        <div class="section-label"><?php echo esc_html( $accred_label ); ?></div>
        <h2 class="section-heading"><?php echo esc_html( $accred_heading ); ?></h2>

        <div class="accreditation-logos-grid">
            <?php if ( ! empty( $accred_partners ) ) :
                foreach ( $accred_partners as $partner ) :
                    $p_name = $partner['name'] ?? '';
                    $p_logo = $partner['logo'] ?? '';
                    $p_url  = $partner['url'] ?? '';
                    $has_link = ( '' !== trim( $p_url ) );
            ?>
            <?php if ( $has_link ) : ?><a href="<?php echo esc_url( $p_url ); ?>" target="_blank" rel="noopener noreferrer" class="accreditation-logo-card accreditation-logo-card--link"><?php else : ?><div class="accreditation-logo-card"><?php endif; ?>
                <?php if ( $p_logo ) : ?>
                    <img src="<?php echo esc_url( $p_logo ); ?>" alt="<?php echo esc_attr( $p_name ); ?>" loading="lazy">
                <?php else : ?>
                    <span class="accreditation-badge"><?php echo esc_html( $p_name ); ?></span>
                <?php endif; ?>
            <?php if ( $has_link ) : ?></a><?php else : ?></div><?php endif; ?>
            <?php endforeach;
            else :
                $defaults = [
                    'Thailand Tourism', 'Dubai Tourism', 'Singapore Tourism', 'Malaysia Tourism',
                    'Maldives Tourism', 'Australia Tourism', 'Japan Tourism', 'Kenya Tourism',
                ];
                foreach ( $defaults as $acc_name ) : ?>
            <div class="accreditation-logo-card">
                <span class="accreditation-badge"><?php echo esc_html( $acc_name ); ?></span>
            </div>
            <?php endforeach; endif; ?>
        </div><!-- /.accreditation-logos-grid -->

    </div>
</section>
<?php endif; ?>


<!-- ════════════════════════════════════════════════════════════
     SECTION 6 – TESTIMONIALS
════════════════════════════════════════════════════════════ -->
<section class="testimonials-section">
    <div class="section-inner">

        <div class="section-label section-label--white"><?php echo esc_html( $test_label ); ?></div>
        <h2 class="section-heading section-heading--white"><?php echo esc_html( $test_heading ); ?></h2>

        <div class="testimonials-row">
            <?php foreach ( $test_items as $t ) :
                $t_name   = $t['name'] ?? '';
                $t_rating = max( 1, min( 5, intval( $t['rating'] ?? 5 ) ) );
                $initial  = strtoupper( mb_substr( wp_strip_all_tags( $t_name ), 0, 1 ) );
            ?>
            <div class="testimonial-card">
                <div class="testimonial-card__stars" aria-label="<?php echo $t_rating; ?> stars">
                    <?php for ( $i = 0; $i < $t_rating; $i++ ) : ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-card__quote">&ldquo;<?php echo esc_html( $t['quote'] ?? '' ); ?>&rdquo;</p>
                <hr class="testimonial-card__divider">
                <div class="testimonial-card__footer">
                    <div class="testimonial-card__avatar">
                        <span class="testimonial-card__avatar-initial" aria-hidden="true"><?php echo esc_html( $initial ); ?></span>
                    </div>
                    <div>
                        <span class="testimonial-card__name"><?php echo esc_html( $t_name ); ?></span>
                        <span class="testimonial-card__trip"><?php echo esc_html( $t['trip'] ?? '' ); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div><!-- /.testimonials-row -->

    </div>
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 7 – CTA
════════════════════════════════════════════════════════════ -->
<?php if ( '1' === $cta_visible ) : ?>
<section class="about-cta-section">
    <div class="section-container">
        <div class="about-cta-inner">
            <h2><?php echo esc_html( $cta_heading ); ?></h2>
            <p><?php echo esc_html( $cta_desc ); ?></p>
            <div class="about-cta-buttons">
                <a href="<?php echo esc_url( home_url( $cta_btn1_url ) ); ?>" class="btn-primary">
                    <?php echo esc_html( $cta_btn1_text ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( $cta_btn2_url ) ); ?>" class="btn-ghost-white">
                    <?php echo esc_html( $cta_btn2_text ); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


</main><!-- /#main-content -->

<?php get_footer(); ?>
