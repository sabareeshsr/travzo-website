<?php
/**
 * Template Name: About Page
 * Template Post Type: page
 *
 * @package Travzo
 */

// ── Native post meta reads ─────────────────────────────────────────────────────
$post_id = get_the_ID();

$hero_image   = travzo_get( 'travzo_about_hero_image', '' );
$hero_heading = travzo_get( 'travzo_about_hero_title', 'About Travzo Holidays' );
$hero_subtext = travzo_get( 'travzo_about_hero_desc',  'Your trusted travel partner crafting unforgettable journeys across India and the world' );
$hero_style   = $hero_image ? 'background-image:url(' . esc_url( $hero_image ) . ');background-size:cover;background-position:center' : '';

$story_heading = get_post_meta( $post_id, '_about_story_heading', true ) ?: __( 'Who We Are', 'travzo' );
$story_text    = get_post_meta( $post_id, '_about_story_text',    true );
$story_image   = get_post_meta( $post_id, '_about_story_image',   true );

// cols: [0]=name, [1]=role, [2]=bio, [3]=photo
$team = travzo_parse_lines( get_post_meta( $post_id, '_about_team', true ), 4 );

// cols: [0]=name, [1]=year, [2]=image
$awards = travzo_parse_lines( get_post_meta( $post_id, '_about_awards', true ), 3 );

// cols: [0]=name, [1]=image
$accreditations = travzo_parse_lines( get_post_meta( $post_id, '_about_accreditations', true ), 2 );

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
<section class="about-story-section">
    <div class="section-container">
        <div class="about-story-grid">

            <div class="about-story-image">
                <?php if ( $story_image ) : ?>
                    <img src="<?php echo esc_url( $story_image ); ?>" alt="<?php esc_attr_e( 'About Travzo Holidays', 'travzo' ); ?>">
                <?php else : ?>
                    <div class="about-img-placeholder"></div>
                <?php endif; ?>
                <?php
                $badge_raw   = travzo_get( 'travzo_about_badge_text', '10+ Years of Excellence' );
                $badge_parts = explode( ' ', $badge_raw, 2 );
                ?>
                <div class="about-experience-badge">
                    <span class="badge-number"><?php echo esc_html( $badge_parts[0] ); ?></span>
                    <span class="badge-text"><?php echo esc_html( $badge_parts[1] ?? '' ); ?></span>
                </div>
            </div>

            <div class="about-story-content">
                <div class="section-label"><?php esc_html_e( 'OUR STORY', 'travzo' ); ?></div>
                <h2 class="section-heading section-heading--left"><?php echo esc_html( $story_heading ); ?></h2>

                <?php if ( $story_text ) : ?>
                    <div class="about-story-text"><?php echo wp_kses_post( $story_text ); ?></div>
                <?php else : ?>
                    <div class="about-story-text">
                        <p><?php esc_html_e( 'Travzo Holidays was founded with a simple yet powerful vision — to make exceptional travel accessible to every Indian family, couple, and group. Based in Tamil Nadu, we have spent over a decade crafting journeys that go beyond sightseeing to create genuinely life-changing experiences.', 'travzo' ); ?></p>
                        <p><?php esc_html_e( 'From the backwaters of Kerala to the streets of Bangkok, from the ghats of Varanasi to the beaches of Maldives — every itinerary we create is designed with care, precision, and deep knowledge of the destination.', 'travzo' ); ?></p>
                        <p><?php esc_html_e( 'Our team of travel experts brings firsthand experience from hundreds of destinations, ensuring that every detail of your trip — from airport transfers to hotel selection to day-by-day activities — is planned to perfection.', 'travzo' ); ?></p>
                    </div>
                <?php endif; ?>

                <div class="about-inline-stats">
                    <div class="inline-stat">
                        <span class="inline-stat-number"><?php echo esc_html( travzo_get( 'travzo_about_stat1_number', '500+' ) ); ?></span>
                        <span class="inline-stat-label"><?php echo esc_html( travzo_get( 'travzo_about_stat1_label', 'Happy Travellers' ) ); ?></span>
                    </div>
                    <div class="inline-stat">
                        <span class="inline-stat-number"><?php echo esc_html( travzo_get( 'travzo_about_stat2_number', '50+' ) ); ?></span>
                        <span class="inline-stat-label"><?php echo esc_html( travzo_get( 'travzo_about_stat2_label', 'Destinations' ) ); ?></span>
                    </div>
                    <div class="inline-stat">
                        <span class="inline-stat-number"><?php echo esc_html( travzo_get( 'travzo_about_stat3_number', '10+' ) ); ?></span>
                        <span class="inline-stat-label"><?php echo esc_html( travzo_get( 'travzo_about_stat3_label', 'Years Experience' ) ); ?></span>
                    </div>
                </div>

            </div><!-- /.about-story-content -->
        </div><!-- /.about-story-grid -->
    </div><!-- /.section-container -->
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 3 – STATS BAR
════════════════════════════════════════════════════════════ -->
<section class="stats-section">
    <div class="stats-inner">
        <div class="stat-block">
            <div class="stat-number"><?php echo esc_html( travzo_get( 'travzo_about_stat1_number', '500+' ) ); ?></div>
            <div class="stat-label"><?php echo esc_html( travzo_get( 'travzo_about_stat1_label', 'Happy Travellers' ) ); ?></div>
        </div>
        <div class="stat-divider" aria-hidden="true"></div>
        <div class="stat-block">
            <div class="stat-number"><?php echo esc_html( travzo_get( 'travzo_about_stat2_number', '50+' ) ); ?></div>
            <div class="stat-label"><?php echo esc_html( travzo_get( 'travzo_about_stat2_label', 'Destinations' ) ); ?></div>
        </div>
        <div class="stat-divider" aria-hidden="true"></div>
        <div class="stat-block">
            <div class="stat-number"><?php echo esc_html( travzo_get( 'travzo_about_stat3_number', '10+' ) ); ?></div>
            <div class="stat-label"><?php echo esc_html( travzo_get( 'travzo_about_stat3_label', 'Years Experience' ) ); ?></div>
        </div>
        <div class="stat-divider" aria-hidden="true"></div>
        <div class="stat-block">
            <div class="stat-number"><?php echo esc_html( travzo_get( 'travzo_about_stat4_number', '100%' ) ); ?></div>
            <div class="stat-label"><?php echo esc_html( travzo_get( 'travzo_about_stat4_label', 'Customised Itineraries' ) ); ?></div>
        </div>
    </div>
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 4 – WHY CHOOSE US
════════════════════════════════════════════════════════════ -->
<section class="why-us-section about-why-us">
    <div class="section-container">

        <div class="section-label"><?php esc_html_e( 'WHY TRAVZO', 'travzo' ); ?></div>
        <h2 class="section-heading"><?php esc_html_e( 'Why Travel With Us', 'travzo' ); ?></h2>

        <div class="features-grid features-grid-6">

            <div class="feature-block">
                <div class="feature-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                </div>
                <h3><?php esc_html_e( 'Handcrafted Itineraries', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Every trip designed around your preferences, budget and travel style.', 'travzo' ); ?></p>
            </div>

            <div class="feature-block">
                <div class="feature-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3><?php esc_html_e( 'Best Price Guarantee', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Direct partnerships with hotels and operators for the best rates.', 'travzo' ); ?></p>
            </div>

            <div class="feature-block">
                <div class="feature-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.06 6.06l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <h3><?php esc_html_e( '24/7 Dedicated Support', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Our experts are available round the clock before, during and after your trip.', 'travzo' ); ?></p>
            </div>

            <div class="feature-block">
                <div class="feature-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <h3><?php esc_html_e( 'Visa Assistance', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Complete visa guidance and documentation support for all international destinations.', 'travzo' ); ?></p>
            </div>

            <div class="feature-block">
                <div class="feature-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3><?php esc_html_e( 'Group Expertise', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Specialists in group tours with dedicated managers and seamless coordination.', 'travzo' ); ?></p>
            </div>

            <div class="feature-block">
                <div class="feature-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3><?php esc_html_e( 'Devotional Specialists', 'travzo' ); ?></h3>
                <p><?php esc_html_e( 'Deep expertise in pilgrimage and devotional tours across India and internationally.', 'travzo' ); ?></p>
            </div>

        </div><!-- /.features-grid -->
    </div><!-- /.section-container -->
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 5 – TEAM MEMBERS
════════════════════════════════════════════════════════════ -->
<?php if ( $team ) : ?>
<section class="team-section">
    <div class="section-container">

        <div class="section-label"><?php esc_html_e( 'OUR PEOPLE', 'travzo' ); ?></div>
        <h2 class="section-heading"><?php esc_html_e( 'Meet the Team', 'travzo' ); ?></h2>

        <div class="team-grid">
            <?php foreach ( $team as $member ) :
                $m_name  = $member[0] ?? '';
                $m_role  = $member[1] ?? '';
                $m_bio   = $member[2] ?? '';
                $m_photo = $member[3] ?? '';
                $initial = strtoupper( mb_substr( $m_name, 0, 1 ) );
            ?>
            <div class="team-card">
                <?php if ( $m_photo ) : ?>
                    <img src="<?php echo esc_url( $m_photo ); ?>"
                         alt="<?php echo esc_attr( $m_name ); ?>"
                         class="team-photo" loading="lazy">
                <?php else : ?>
                    <div class="team-photo-placeholder" aria-hidden="true"><?php echo esc_html( $initial ); ?></div>
                <?php endif; ?>
                <h3 class="team-name"><?php echo esc_html( $m_name ); ?></h3>
                <p class="team-role"><?php echo esc_html( $m_role ); ?></p>
                <?php if ( $m_bio ) : ?>
                    <p class="team-bio"><?php echo esc_html( $m_bio ); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div><!-- /.team-grid -->

    </div>
</section>
<?php endif; ?>


<!-- ════════════════════════════════════════════════════════════
     SECTION 6 – AWARDS & ACHIEVEMENTS
════════════════════════════════════════════════════════════ -->
<?php if ( $awards ) : ?>
<section class="awards-section">
    <div class="section-container">

        <div class="section-label"><?php esc_html_e( 'RECOGNITION', 'travzo' ); ?></div>
        <h2 class="section-heading"><?php esc_html_e( 'Awards & Achievements', 'travzo' ); ?></h2>

        <div class="awards-grid">
            <?php foreach ( $awards as $award ) :
                $aw_name  = $award[0] ?? '';
                $aw_year  = $award[1] ?? '';
                $aw_image = $award[2] ?? '';
            ?>
            <div class="award-card">
                <?php if ( $aw_image ) : ?>
                    <img src="<?php echo esc_url( $aw_image ); ?>"
                         alt="<?php echo esc_attr( $aw_name ); ?>"
                         class="award-image" loading="lazy">
                <?php else : ?>
                    <div class="award-image-placeholder">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                    </div>
                <?php endif; ?>
                <h4 class="award-name"><?php echo esc_html( $aw_name ); ?></h4>
                <span class="award-year"><?php echo esc_html( $aw_year ); ?></span>
            </div>
            <?php endforeach; ?>
        </div><!-- /.awards-grid -->

    </div>
</section>
<?php endif; ?>


<!-- ════════════════════════════════════════════════════════════
     SECTION 7 – ACCREDITATIONS
════════════════════════════════════════════════════════════ -->
<section class="accreditations-section">
    <div class="section-container">

        <div class="section-label"><?php esc_html_e( 'TRUSTED BY', 'travzo' ); ?></div>
        <h2 class="section-heading"><?php esc_html_e( 'Our Accreditation Partners', 'travzo' ); ?></h2>

        <div class="accreditation-logos-grid">
            <?php if ( $accreditations ) :
                foreach ( $accreditations as $acc ) :
                    $acc_name = $acc[0] ?? '';
                    $acc_img  = $acc[1] ?? '';
            ?>
            <div class="accreditation-logo-card">
                <?php if ( $acc_img ) : ?>
                    <img src="<?php echo esc_url( $acc_img ); ?>" alt="<?php echo esc_attr( $acc_name ); ?>" loading="lazy">
                <?php else : ?>
                    <span class="accreditation-badge"><?php echo esc_html( $acc_name ); ?></span>
                <?php endif; ?>
            </div>
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


<!-- ════════════════════════════════════════════════════════════
     SECTION 8 – TESTIMONIALS
════════════════════════════════════════════════════════════ -->
<section class="testimonials-section">
    <div class="section-inner">

        <div class="section-label section-label--white"><?php esc_html_e( 'HAPPY TRAVELLERS', 'travzo' ); ?></div>
        <h2 class="section-heading section-heading--white"><?php esc_html_e( 'What Our Travellers Say', 'travzo' ); ?></h2>

        <?php
        $default_testimonials = [
            [
                'quote' => __( 'Travzo made our Maldives honeymoon absolutely magical. Every detail was perfect — from the transfers to the overwater villa. Truly a trip we will remember forever.', 'travzo' ),
                'name'  => 'Priya &amp; Arjun',
                'trip'  => __( 'Maldives Honeymoon Package', 'travzo' ),
            ],
            [
                'quote' => __( 'The Kerala group tour was beyond our expectations. The team handled everything seamlessly and the itinerary was perfectly planned with the right balance of sightseeing and leisure.', 'travzo' ),
                'name'  => 'Ramesh Kumar',
                'trip'  => __( 'Kerala Group Tour', 'travzo' ),
            ],
            [
                'quote' => __( 'Our Char Dham pilgrimage was a deeply spiritual experience. Travzo took care of every arrangement with so much respect and care. Highly recommend for devotional tours.', 'travzo' ),
                'name'  => 'Meenakshi Sundaram',
                'trip'  => __( 'Char Dham Devotional Tour', 'travzo' ),
            ],
        ];
        ?>
        <div class="testimonials-row">
            <?php foreach ( $default_testimonials as $t ) :
                $initial = strtoupper( substr( wp_strip_all_tags( $t['name'] ), 0, 1 ) );
            ?>
            <div class="testimonial-card">
                <div class="testimonial-card__stars" aria-label="5 stars">
                    <?php for ( $i = 0; $i < 5; $i++ ) : ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <?php endfor; ?>
                </div>
                <p class="testimonial-card__quote">&ldquo;<?php echo wp_kses_post( $t['quote'] ); ?>&rdquo;</p>
                <hr class="testimonial-card__divider">
                <div class="testimonial-card__footer">
                    <div class="testimonial-card__avatar">
                        <span class="testimonial-card__avatar-initial" aria-hidden="true"><?php echo esc_html( $initial ); ?></span>
                    </div>
                    <div>
                        <span class="testimonial-card__name"><?php echo wp_kses_post( $t['name'] ); ?></span>
                        <span class="testimonial-card__trip"><?php echo wp_kses_post( $t['trip'] ); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div><!-- /.testimonials-row -->

    </div>
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 9 – CTA
════════════════════════════════════════════════════════════ -->
<section class="about-cta-section">
    <div class="section-container">
        <div class="about-cta-inner">
            <h2><?php esc_html_e( 'Ready to Start Your Journey?', 'travzo' ); ?></h2>
            <p><?php esc_html_e( 'Talk to our travel experts and get a personalised itinerary crafted just for you.', 'travzo' ); ?></p>
            <div class="about-cta-buttons">
                <a href="<?php echo esc_url( home_url( '/packages' ) ); ?>" class="btn-primary">
                    <?php esc_html_e( 'Explore Packages', 'travzo' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn-ghost-white">
                    <?php esc_html_e( 'Contact Us', 'travzo' ); ?>
                </a>
            </div>
        </div>
    </div>
</section>


</main><!-- /#main-content -->

<?php get_footer(); ?>
