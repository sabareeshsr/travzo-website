<?php
/**
 * Front Page Template – Travzo Holidays Homepage
 */

// ── Section 8 form handling ────────────────────────────────────────────────────
$enquiry_sent  = false;
$enquiry_error = false;

if ( isset( $_POST['travzo_enquiry_nonce'] ) &&
     wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_enquiry_nonce'] ) ), 'travzo_enquiry' ) ) {

    $name        = sanitize_text_field( wp_unslash( $_POST['enquiry_name']        ?? '' ) );
    $city        = sanitize_text_field( wp_unslash( $_POST['enquiry_city']        ?? '' ) );
    $email       = sanitize_email(      wp_unslash( $_POST['enquiry_email']       ?? '' ) );
    $phone       = sanitize_text_field( wp_unslash( $_POST['enquiry_phone']       ?? '' ) );
    $destination = sanitize_text_field( wp_unslash( $_POST['enquiry_destination'] ?? '' ) );
    $travel_date = sanitize_text_field( wp_unslash( $_POST['enquiry_date']        ?? '' ) );
    $people      = absint(              wp_unslash( $_POST['enquiry_people']      ?? 1  ) );
    $trip_type   = sanitize_text_field( wp_unslash( $_POST['enquiry_trip_type']   ?? '' ) );

    if ( $name && $email && is_email( $email ) ) {
        $to      = 'hello@travzoholidays.com';
        $subject = sprintf( 'New Enquiry from %s – Travzo Holidays', $name );
        $body    = "New holiday enquiry received:\n\n"
                 . "Name:        {$name}\n"
                 . "City:        {$city}\n"
                 . "Email:       {$email}\n"
                 . "Phone:       {$phone}\n"
                 . "Destination: {$destination}\n"
                 . "Travel Date: {$travel_date}\n"
                 . "No. People:  {$people}\n"
                 . "Trip Type:   {$trip_type}\n";
        $headers = [ 'Content-Type: text/plain; charset=UTF-8', "Reply-To: {$name} <{$email}>" ];

        $enquiry_sent  = wp_mail( $to, $subject, $body, $headers );
        $enquiry_error = ! $enquiry_sent;
    } else {
        $enquiry_error = true;
    }
}

get_header();
?>

<main id="main-content">

<!-- ════════════════════════════════════════════════════════════════
     SECTION 1 – HERO
════════════════════════════════════════════════════════════════ -->
<?php
$hero_image   = '';
$hero_badge   = 'Trusted by 500+ Happy Travellers';
$hero_heading = 'Discover the World With Travzo Holidays';
$hero_subtext = 'Handcrafted itineraries for every kind of traveller.';

if ( function_exists( 'get_field' ) ) {
    $hero_img_arr = get_field( 'hero_image' );
    if ( $hero_img_arr ) {
        $hero_image = is_array( $hero_img_arr ) ? esc_url( $hero_img_arr['url'] ) : esc_url( $hero_img_arr );
    }
    $hero_badge   = get_field( 'hero_badge_text' )   ?: $hero_badge;
    $hero_heading = get_field( 'hero_heading' )       ?: $hero_heading;
    $hero_subtext = get_field( 'hero_subtext' )       ?: $hero_subtext;
}

$hero_bg_style = $hero_image
    ? 'background-image: url(' . $hero_image . ');'
    : 'background: linear-gradient(135deg, #1A2A5E 0%, #2D4080 100%);';
?>
<section class="hero-section" style="<?php echo $hero_bg_style; ?>">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <span class="hero-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19.5 2.5S18 2 17 3l-.5.5L17.8 7l-5 .8-2.7-2.7C9.5 4.5 8 4.5 8 5.5s0 1.5.5 2L10 9l-3.5 1L4.8 8.2C4.3 7.7 3 7.5 3 8.5s.5 1.5.5 1.5L6 12l-.5 4L8 14.5l2 2L12 20l-1.5 2.5c0 .5.5 1 1.5 1s1.5-.5 2-1l-.2-1.5 3-3.5 1.3 2.2c.5.5 1.5.8 2 .5s.8-1 .2-2z"/>
            </svg>
            <?php echo esc_html( $hero_badge ); ?>
        </span>

        <h1 class="hero-heading"><?php echo esc_html( $hero_heading ); ?></h1>

        <p class="hero-subtext"><?php echo esc_html( $hero_subtext ); ?></p>

        <div class="hero-buttons">
            <a href="<?php echo esc_url( home_url( '/packages' ) ); ?>" class="btn btn--gold">
                Explore Packages
            </a>
            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn--ghost-white">
                Enquire Now
            </a>
        </div>
    </div><!-- /.hero-content -->

    <!-- Floating search bar -->
    <div class="hero-search-bar">
        <div class="hero-search-bar__inner">
            <div class="hero-search-field">
                <label for="search-destination" class="hero-search-label">Destination</label>
                <input id="search-destination" type="text" class="hero-search-input" placeholder="Where do you want to go?" aria-label="<?php esc_attr_e( 'Enter destination', 'travzo' ); ?>">
            </div>
            <div class="hero-search-divider" aria-hidden="true"></div>
            <div class="hero-search-field">
                <label for="search-type" class="hero-search-label">Package Type</label>
                <select id="search-type" class="hero-search-input" aria-label="<?php esc_attr_e( 'Select package type', 'travzo' ); ?>">
                    <option value=""><?php esc_html_e( 'Select Type', 'travzo' ); ?></option>
                    <option value="group-tour"><?php esc_html_e( 'Group Tour', 'travzo' ); ?></option>
                    <option value="honeymoon"><?php esc_html_e( 'Honeymoon', 'travzo' ); ?></option>
                    <option value="solo"><?php esc_html_e( 'Solo', 'travzo' ); ?></option>
                    <option value="devotional"><?php esc_html_e( 'Devotional', 'travzo' ); ?></option>
                    <option value="destination-wedding"><?php esc_html_e( 'Destination Wedding', 'travzo' ); ?></option>
                </select>
            </div>
            <div class="hero-search-divider" aria-hidden="true"></div>
            <div class="hero-search-field">
                <label for="search-duration" class="hero-search-label">Duration</label>
                <select id="search-duration" class="hero-search-input" aria-label="<?php esc_attr_e( 'Select duration', 'travzo' ); ?>">
                    <option value=""><?php esc_html_e( 'Any Duration', 'travzo' ); ?></option>
                    <option value="3-5"><?php esc_html_e( '3–5 Days', 'travzo' ); ?></option>
                    <option value="6-8"><?php esc_html_e( '6–8 Days', 'travzo' ); ?></option>
                    <option value="9-12"><?php esc_html_e( '9–12 Days', 'travzo' ); ?></option>
                    <option value="13+"><?php esc_html_e( '13+ Days', 'travzo' ); ?></option>
                </select>
            </div>
            <button class="hero-search-btn" type="button">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <?php esc_html_e( 'Search', 'travzo' ); ?>
            </button>
        </div>
    </div><!-- /.hero-search-bar -->
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 2 – OUR PACKAGES
════════════════════════════════════════════════════════════════ -->
<section class="packages-section">
    <div class="section-inner">
        <div class="section-label">What We Offer</div>
        <h2 class="section-heading">Our Packages</h2>

        <div class="package-tiles-grid">

            <!-- Large tile: Group Tours -->
            <a href="<?php echo esc_url( home_url( '/packages' ) ); ?>"
               class="package-tile package-tile--large"
               style="background-color: #2D5016;">
                <div class="package-tile__overlay"></div>
                <div class="package-tile__content">
                    <span class="package-tile__name">Group Tours</span>
                    <span class="package-tile__count">24 Packages</span>
                </div>
            </a>

            <!-- Large tile: Honeymoon -->
            <a href="<?php echo esc_url( home_url( '/packages/?category=honeymoon' ) ); ?>"
               class="package-tile package-tile--large"
               style="background-color: #5C1A4A;">
                <div class="package-tile__overlay"></div>
                <div class="package-tile__content">
                    <span class="package-tile__name">Honeymoon Packages</span>
                    <span class="package-tile__count">18 Packages</span>
                </div>
            </a>

            <!-- Small tile: Solo Trips -->
            <a href="<?php echo esc_url( home_url( '/packages/?category=solo-trips' ) ); ?>"
               class="package-tile package-tile--small"
               style="background-color: #1A3A5C;">
                <div class="package-tile__overlay"></div>
                <div class="package-tile__content">
                    <span class="package-tile__name">Solo Trips</span>
                    <span class="package-tile__count">12 Packages</span>
                </div>
            </a>

            <!-- Small tile: Devotional Tours -->
            <a href="<?php echo esc_url( home_url( '/packages/?category=devotional' ) ); ?>"
               class="package-tile package-tile--small"
               style="background-color: #5C3A1A;">
                <div class="package-tile__overlay"></div>
                <div class="package-tile__content">
                    <span class="package-tile__name">Devotional Tours</span>
                    <span class="package-tile__count">15 Packages</span>
                </div>
            </a>

            <!-- Small tile: Destination Weddings -->
            <a href="<?php echo esc_url( home_url( '/packages/?category=destination-wedding' ) ); ?>"
               class="package-tile package-tile--small"
               style="background-color: #1A5C4A;">
                <div class="package-tile__overlay"></div>
                <div class="package-tile__content">
                    <span class="package-tile__name">Destination Weddings</span>
                    <span class="package-tile__count">8 Packages</span>
                </div>
            </a>

            <!-- Small tile: International -->
            <a href="<?php echo esc_url( home_url( '/packages/?category=international' ) ); ?>"
               class="package-tile package-tile--small"
               style="background-color: #2A1A5C;">
                <div class="package-tile__overlay"></div>
                <div class="package-tile__content">
                    <span class="package-tile__name">International Packages</span>
                    <span class="package-tile__count">20 Packages</span>
                </div>
            </a>

        </div><!-- /.package-tiles-grid -->
    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 3 – STATS BAR
════════════════════════════════════════════════════════════════ -->
<?php
$stats = [
    [
        'number'      => '500+',
        'label'       => 'Happy Travellers',
        'description' => 'Memorable journeys created',
        'acf_number'  => 'stat_1_number',
        'acf_label'   => 'stat_1_label',
    ],
    [
        'number'      => '50+',
        'label'       => 'Destinations',
        'description' => 'Across India and abroad',
        'acf_number'  => 'stat_2_number',
        'acf_label'   => 'stat_2_label',
    ],
    [
        'number'      => '10+',
        'label'       => 'Years Experience',
        'description' => 'Of trusted travel expertise',
        'acf_number'  => 'stat_3_number',
        'acf_label'   => 'stat_3_label',
    ],
    [
        'number'      => '100%',
        'label'       => 'Customised Itineraries',
        'description' => 'Tailored to your needs',
        'acf_number'  => 'stat_4_number',
        'acf_label'   => 'stat_4_label',
    ],
];
?>
<section class="stats-section">
    <div class="stats-inner">
        <?php foreach ( $stats as $index => $stat ) :
            $number = $stat['number'];
            $label  = $stat['label'];
            if ( function_exists( 'get_field' ) ) {
                $number = get_field( $stat['acf_number'] ) ?: $number;
                $label  = get_field( $stat['acf_label']  ) ?: $label;
            }
        ?>
        <div class="stat-block">
            <span class="stat-number"><?php echo esc_html( $number ); ?></span>
            <span class="stat-label"><?php echo esc_html( $label ); ?></span>
            <span class="stat-description"><?php echo esc_html( $stat['description'] ); ?></span>
        </div>
        <?php if ( $index < count( $stats ) - 1 ) : ?>
            <div class="stat-divider" aria-hidden="true"></div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 4 – ABOUT SNIPPET
════════════════════════════════════════════════════════════════ -->
<?php
$about_image_url = '';
$about_text      = 'Travzo Holidays is a Coimbatore-based travel agency with over a decade of experience crafting unforgettable journeys. From serene backwater cruises in Kerala to sacred Char Dham pilgrimages, we design every itinerary with care, passion, and deep local knowledge — so you can travel with complete peace of mind.';

if ( function_exists( 'get_field' ) ) {
    $about_img = get_field( 'about_image' );
    if ( $about_img ) {
        $about_image_url = is_array( $about_img ) ? esc_url( $about_img['url'] ) : esc_url( $about_img );
    }
    $about_text = get_field( 'about_text' ) ?: $about_text;
}
?>
<section class="about-snippet">
    <div class="section-inner about-snippet__inner">

        <!-- Left: image -->
        <div class="about-snippet__image-wrap">
            <?php if ( $about_image_url ) : ?>
                <img src="<?php echo $about_image_url; ?>"
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
            <div class="section-label">Who We Are</div>
            <h2 class="section-heading section-heading--left">Your Trusted Travel Partner</h2>
            <p class="about-snippet__text"><?php echo wp_kses_post( $about_text ); ?></p>

            <ul class="about-features">
                <li class="about-feature">
                    <svg class="about-feature__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <?php esc_html_e( 'Handcrafted Itineraries', 'travzo' ); ?>
                </li>
                <li class="about-feature">
                    <svg class="about-feature__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <?php esc_html_e( 'Best Price Guarantee', 'travzo' ); ?>
                </li>
                <li class="about-feature">
                    <svg class="about-feature__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <?php esc_html_e( '24/7 Support', 'travzo' ); ?>
                </li>
            </ul>

            <a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="btn btn--navy">
                Learn More About Us
            </a>
        </div>

    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 5 – TRENDING TOURS
════════════════════════════════════════════════════════════════ -->
<section class="trending-section">
    <div class="section-inner">
        <div class="section-label">Trending Now</div>
        <h2 class="section-heading">Popular Packages</h2>

        <div class="package-cards-row">
        <?php
        $pkg_query = new WP_Query( [
            'post_type'      => 'package',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ] );

        // Star SVG reused per card
        $star_svg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';

        if ( $pkg_query->have_posts() ) :
            while ( $pkg_query->have_posts() ) :
                $pkg_query->the_post();
                $pkg_type    = '';
                $destination = '';
                $duration    = '';
                $price       = '';
                if ( function_exists( 'get_field' ) ) {
                    $pkg_type    = get_field( 'package_type' )  ?: '';
                    $destination = get_field( 'destinations' )  ?: '';
                    $duration    = get_field( 'duration' )      ?: '';
                    $price       = get_field( 'price' )         ?: '';
                }
        ?>
            <div class="package-card">
                <div class="package-card__image-wrap">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'package-card', [ 'class' => 'package-card__image', 'alt' => get_the_title() ] ); ?>
                    <?php else : ?>
                        <div class="package-card__image-placeholder"></div>
                    <?php endif; ?>
                    <?php if ( $pkg_type ) : ?>
                        <span class="package-card__type-tag"><?php echo esc_html( $pkg_type ); ?></span>
                    <?php endif; ?>
                </div>
                <div class="package-card__body">
                    <div class="package-card__stars">
                        <?php echo str_repeat( $star_svg, 5 ); ?>
                    </div>
                    <h3 class="package-card__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <?php if ( $destination ) : ?>
                        <p class="package-card__destination">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php echo esc_html( $destination ); ?>
                        </p>
                    <?php endif; ?>
                    <?php if ( $duration ) : ?>
                        <span class="package-card__duration"><?php echo esc_html( $duration ); ?></span>
                    <?php endif; ?>
                    <?php if ( $price ) : ?>
                        <div class="package-card__price">
                            <span class="package-card__price-from"><?php esc_html_e( 'Starting from', 'travzo' ); ?></span>
                            <span class="package-card__price-amount"><?php echo esc_html( $price ); ?></span>
                        </div>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="btn btn--navy btn--full">
                        <?php esc_html_e( 'View Package', 'travzo' ); ?>
                    </a>
                </div>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            // Placeholder cards when no packages exist
            $placeholders = [
                [ 'title' => 'Kashmir Paradise Tour',         'dest' => 'Srinagar, Gulmarg, Pahalgam', 'duration' => '6 Days / 5 Nights', 'price' => '₹24,999', 'type' => 'Group Tour',  'color' => '#1A3A5C' ],
                [ 'title' => 'Kerala Honeymoon Special',      'dest' => 'Munnar, Alleppey, Kovalam',   'duration' => '7 Days / 6 Nights', 'price' => '₹32,999', 'type' => 'Honeymoon',   'color' => '#5C1A4A' ],
                [ 'title' => 'Char Dham Yatra Package',       'dest' => 'Kedarnath, Badrinath, Gangotri', 'duration' => '12 Days / 11 Nights', 'price' => '₹45,999', 'type' => 'Devotional', 'color' => '#5C3A1A' ],
                [ 'title' => 'Rajasthan Royal Group Tour',    'dest' => 'Jaipur, Udaipur, Jodhpur',    'duration' => '8 Days / 7 Nights', 'price' => '₹28,999', 'type' => 'Group Tour',  'color' => '#2D5016' ],
            ];
            foreach ( $placeholders as $ph ) : ?>
            <div class="package-card">
                <div class="package-card__image-wrap">
                    <div class="package-card__image-placeholder" style="background-color: <?php echo esc_attr( $ph['color'] ); ?>;"></div>
                    <span class="package-card__type-tag"><?php echo esc_html( $ph['type'] ); ?></span>
                </div>
                <div class="package-card__body">
                    <div class="package-card__stars"><?php echo str_repeat( $star_svg, 5 ); ?></div>
                    <h3 class="package-card__title"><a href="#"><?php echo esc_html( $ph['title'] ); ?></a></h3>
                    <p class="package-card__destination">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <?php echo esc_html( $ph['dest'] ); ?>
                    </p>
                    <span class="package-card__duration"><?php echo esc_html( $ph['duration'] ); ?></span>
                    <div class="package-card__price">
                        <span class="package-card__price-from"><?php esc_html_e( 'Starting from', 'travzo' ); ?></span>
                        <span class="package-card__price-amount"><?php echo esc_html( $ph['price'] ); ?></span>
                    </div>
                    <a href="#" class="btn btn--navy btn--full"><?php esc_html_e( 'View Package', 'travzo' ); ?></a>
                </div>
            </div>
            <?php endforeach;
        endif; ?>
        </div><!-- /.package-cards-row -->
    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 6 – WHY CHOOSE US
════════════════════════════════════════════════════════════════ -->
<section class="why-us-section">
    <div class="section-inner">
        <div class="section-label">Our Promise</div>
        <h2 class="section-heading">Why Travel With Travzo</h2>

        <div class="why-us-blocks">

            <div class="why-us-block">
                <div class="why-us-block__icon-wrap">
                    <!-- Compass icon -->
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                    </svg>
                </div>
                <h3 class="why-us-block__title"><?php esc_html_e( 'Handcrafted Itineraries', 'travzo' ); ?></h3>
                <p class="why-us-block__text"><?php esc_html_e( 'Every trip is built around your preferences, pace, and budget — no cookie-cutter packages, just journeys made for you.', 'travzo' ); ?></p>
            </div>

            <div class="why-us-block">
                <div class="why-us-block__icon-wrap">
                    <!-- Tag/price icon -->
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                </div>
                <h3 class="why-us-block__title"><?php esc_html_e( 'Best Price Guarantee', 'travzo' ); ?></h3>
                <p class="why-us-block__text"><?php esc_html_e( 'We negotiate directly with hotels, airlines, and local operators so you always get the most value for your money.', 'travzo' ); ?></p>
            </div>

            <div class="why-us-block">
                <div class="why-us-block__icon-wrap">
                    <!-- Headset icon -->
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 18v-6a9 9 0 0118 0v6"/>
                        <path d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"/>
                    </svg>
                </div>
                <h3 class="why-us-block__title"><?php esc_html_e( '24/7 Dedicated Support', 'travzo' ); ?></h3>
                <p class="why-us-block__text"><?php esc_html_e( 'Our travel experts are always just a call or WhatsApp message away — before, during, and after your trip.', 'travzo' ); ?></p>
            </div>

        </div><!-- /.why-us-blocks -->

        <!-- Accreditation strip -->
        <div class="accreditation-strip">
            <span class="accreditation-badge">Thailand Tourism</span>
            <span class="accreditation-badge">Dubai Tourism</span>
            <span class="accreditation-badge">Singapore Tourism</span>
            <span class="accreditation-badge">Maldives Tourism</span>
            <span class="accreditation-badge">Malaysia Tourism</span>
            <span class="accreditation-badge">Australia Tourism</span>
        </div>

    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 7 – TESTIMONIALS
════════════════════════════════════════════════════════════════ -->
<?php
$testimonials_fallback = [
    [
        'quote'         => '"Travzo made our Kashmir honeymoon absolutely magical. Every detail was taken care of — from the shikara ride to the houseboat stay. We didn\'t have to worry about a single thing."',
        'customer_name' => 'Priya & Arjun Nair',
        'trip_taken'    => 'Kashmir Honeymoon – 7 Days',
        'avatar_url'    => '',
    ],
    [
        'quote'         => '"We did the Char Dham Yatra with Travzo and it was a life-changing experience. The team\'s coordination was flawless, and our guide was knowledgeable and caring throughout."',
        'customer_name' => 'Rajesh Murugan',
        'trip_taken'    => 'Char Dham Yatra – 12 Days',
        'avatar_url'    => '',
    ],
    [
        'quote'         => '"Booked a group tour to Rajasthan for 18 people and everything went smoothly. Great hotels, punctual transfers, and the best price we found anywhere. Highly recommend Travzo!"',
        'customer_name' => 'Sunita Krishnamurthy',
        'trip_taken'    => 'Rajasthan Group Tour – 8 Days',
        'avatar_url'    => '',
    ],
];

$testimonials = $testimonials_fallback;
if ( function_exists( 'get_field' ) ) {
    $acf_testimonials = get_field( 'testimonials' );
    if ( ! empty( $acf_testimonials ) ) {
        $testimonials = $acf_testimonials;
    }
}

$star_svg_white = '<svg width="14" height="14" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';
?>
<section class="testimonials-section">
    <div class="section-inner">
        <div class="section-label section-label--white">What Our Travellers Say</div>
        <h2 class="section-heading section-heading--white">Real Stories, Real Journeys</h2>

        <div class="testimonials-row">
        <?php foreach ( $testimonials as $t ) :
            $quote    = is_array( $t ) ? ( $t['quote']         ?? '' ) : '';
            $name     = is_array( $t ) ? ( $t['customer_name'] ?? '' ) : '';
            $trip     = is_array( $t ) ? ( $t['trip_taken']    ?? '' ) : '';
            $avatar   = is_array( $t ) ? ( $t['avatar_url']    ?? '' ) : '';
            $initials = $name ? strtoupper( substr( $name, 0, 1 ) ) : 'T';
        ?>
            <div class="testimonial-card">
                <div class="testimonial-card__stars">
                    <?php echo str_repeat( $star_svg_white, 5 ); ?>
                </div>
                <blockquote class="testimonial-card__quote">
                    <?php echo wp_kses_post( $quote ); ?>
                </blockquote>
                <hr class="testimonial-card__divider">
                <div class="testimonial-card__footer">
                    <div class="testimonial-card__avatar">
                        <?php if ( $avatar ) : ?>
                            <img src="<?php echo esc_url( $avatar ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy">
                        <?php else : ?>
                            <span class="testimonial-card__avatar-initial"><?php echo esc_html( $initials ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="testimonial-card__info">
                        <strong class="testimonial-card__name"><?php echo esc_html( $name ); ?></strong>
                        <span class="testimonial-card__trip"><?php echo esc_html( $trip ); ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div><!-- /.testimonials-row -->
    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 8 – ENQUIRY FORM
════════════════════════════════════════════════════════════════ -->
<section class="enquiry-section">
    <div class="section-inner enquiry-section__inner">

        <!-- Left: contact info card -->
        <div class="enquiry-info">
            <div class="section-label">Get In Touch</div>
            <h2 class="section-heading section-heading--left section-heading--white">Plan Your Dream Trip</h2>
            <p class="enquiry-info__subtext">
                <?php esc_html_e( 'Talk to our travel experts and let us craft the perfect holiday for you. No obligation, just great ideas.', 'travzo' ); ?>
            </p>

            <div class="enquiry-contact-rows">
                <div class="enquiry-contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 011 2.18 2 2 0 013 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/></svg>
                    <a href="tel:+91XXXXXXXXXX" class="enquiry-contact-row__text">+91 XXXXX XXXXX</a>
                </div>
                <div class="enquiry-contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <a href="mailto:hello@travzoholidays.com" class="enquiry-contact-row__text">hello@travzoholidays.com</a>
                </div>
                <div class="enquiry-contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <a href="https://wa.me/91XXXXXXXXXX" target="_blank" rel="noopener noreferrer" class="enquiry-contact-row__text">WhatsApp Us</a>
                </div>
                <div class="enquiry-contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span class="enquiry-contact-row__text"><?php esc_html_e( 'Mon – Sat: 9:00 AM – 7:00 PM', 'travzo' ); ?></span>
                </div>
            </div>
        </div><!-- /.enquiry-info -->

        <!-- Right: form card -->
        <div class="enquiry-form-card">

            <?php if ( $enquiry_sent ) : ?>
                <div class="enquiry-success">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <h3><?php esc_html_e( 'Enquiry Sent!', 'travzo' ); ?></h3>
                    <p><?php esc_html_e( 'Thank you! Our team will get back to you within 24 hours.', 'travzo' ); ?></p>
                </div>
            <?php else : ?>
                <?php if ( $enquiry_error ) : ?>
                    <div class="enquiry-error">
                        <?php esc_html_e( 'Something went wrong. Please check your details and try again.', 'travzo' ); ?>
                    </div>
                <?php endif; ?>

                <h3 class="enquiry-form-card__title"><?php esc_html_e( 'Send Us an Enquiry', 'travzo' ); ?></h3>

                <form class="enquiry-form" method="POST" action="" novalidate>
                    <?php wp_nonce_field( 'travzo_enquiry', 'travzo_enquiry_nonce' ); ?>

                    <div class="form-row form-row--2col">
                        <div class="form-field">
                            <label for="enquiry_name"><?php esc_html_e( 'Your Name', 'travzo' ); ?> <span aria-hidden="true">*</span></label>
                            <input type="text" id="enquiry_name" name="enquiry_name" required
                                   placeholder="<?php esc_attr_e( 'e.g. Ramesh Kumar', 'travzo' ); ?>"
                                   value="<?php echo isset( $_POST['enquiry_name'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['enquiry_name'] ) ) ) : ''; ?>">
                        </div>
                        <div class="form-field">
                            <label for="enquiry_city"><?php esc_html_e( 'City', 'travzo' ); ?></label>
                            <input type="text" id="enquiry_city" name="enquiry_city"
                                   placeholder="<?php esc_attr_e( 'e.g. Coimbatore', 'travzo' ); ?>"
                                   value="<?php echo isset( $_POST['enquiry_city'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['enquiry_city'] ) ) ) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-row form-row--2col">
                        <div class="form-field">
                            <label for="enquiry_email"><?php esc_html_e( 'Email Address', 'travzo' ); ?> <span aria-hidden="true">*</span></label>
                            <input type="email" id="enquiry_email" name="enquiry_email" required
                                   placeholder="<?php esc_attr_e( 'you@example.com', 'travzo' ); ?>"
                                   value="<?php echo isset( $_POST['enquiry_email'] ) ? esc_attr( sanitize_email( wp_unslash( $_POST['enquiry_email'] ) ) ) : ''; ?>">
                        </div>
                        <div class="form-field">
                            <label for="enquiry_phone"><?php esc_html_e( 'Phone Number', 'travzo' ); ?></label>
                            <input type="tel" id="enquiry_phone" name="enquiry_phone"
                                   placeholder="<?php esc_attr_e( '+91 XXXXX XXXXX', 'travzo' ); ?>"
                                   value="<?php echo isset( $_POST['enquiry_phone'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['enquiry_phone'] ) ) ) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-row form-row--2col">
                        <div class="form-field">
                            <label for="enquiry_destination"><?php esc_html_e( 'Preferred Destination', 'travzo' ); ?></label>
                            <input type="text" id="enquiry_destination" name="enquiry_destination"
                                   placeholder="<?php esc_attr_e( 'e.g. Kashmir', 'travzo' ); ?>"
                                   value="<?php echo isset( $_POST['enquiry_destination'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['enquiry_destination'] ) ) ) : ''; ?>">
                        </div>
                        <div class="form-field">
                            <label for="enquiry_date"><?php esc_html_e( 'Travel Date', 'travzo' ); ?></label>
                            <input type="date" id="enquiry_date" name="enquiry_date"
                                   min="<?php echo esc_attr( gmdate( 'Y-m-d' ) ); ?>"
                                   value="<?php echo isset( $_POST['enquiry_date'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['enquiry_date'] ) ) ) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-row form-row--2col">
                        <div class="form-field">
                            <label for="enquiry_people"><?php esc_html_e( 'Number of People', 'travzo' ); ?></label>
                            <input type="number" id="enquiry_people" name="enquiry_people" min="1" max="100"
                                   placeholder="<?php esc_attr_e( '2', 'travzo' ); ?>"
                                   value="<?php echo isset( $_POST['enquiry_people'] ) ? esc_attr( absint( wp_unslash( $_POST['enquiry_people'] ) ) ) : ''; ?>">
                        </div>
                        <div class="form-field">
                            <label for="enquiry_trip_type"><?php esc_html_e( 'Trip Type', 'travzo' ); ?></label>
                            <select id="enquiry_trip_type" name="enquiry_trip_type">
                                <option value=""><?php esc_html_e( 'Select Type', 'travzo' ); ?></option>
                                <option value="Group Tour"          <?php selected( ( $_POST['enquiry_trip_type'] ?? '' ), 'Group Tour' ); ?>><?php esc_html_e( 'Group Tour', 'travzo' ); ?></option>
                                <option value="Honeymoon"           <?php selected( ( $_POST['enquiry_trip_type'] ?? '' ), 'Honeymoon' ); ?>><?php esc_html_e( 'Honeymoon', 'travzo' ); ?></option>
                                <option value="Solo Trip"           <?php selected( ( $_POST['enquiry_trip_type'] ?? '' ), 'Solo Trip' ); ?>><?php esc_html_e( 'Solo Trip', 'travzo' ); ?></option>
                                <option value="Devotional"          <?php selected( ( $_POST['enquiry_trip_type'] ?? '' ), 'Devotional' ); ?>><?php esc_html_e( 'Devotional', 'travzo' ); ?></option>
                                <option value="Destination Wedding" <?php selected( ( $_POST['enquiry_trip_type'] ?? '' ), 'Destination Wedding' ); ?>><?php esc_html_e( 'Destination Wedding', 'travzo' ); ?></option>
                                <option value="International"       <?php selected( ( $_POST['enquiry_trip_type'] ?? '' ), 'International' ); ?>><?php esc_html_e( 'International', 'travzo' ); ?></option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn--gold btn--full">
                        <?php esc_html_e( 'Send Enquiry', 'travzo' ); ?>
                    </button>
                </form>
            <?php endif; ?>
        </div><!-- /.enquiry-form-card -->

    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 9 – LATEST BLOG
════════════════════════════════════════════════════════════════ -->
<section class="blog-section">
    <div class="section-inner">
        <div class="section-label">From Our Journal</div>
        <h2 class="section-heading">Travel Stories &amp; Tips</h2>

        <div class="blog-cards-row">
        <?php
        $blog_query = new WP_Query( [
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ] );

        if ( $blog_query->have_posts() ) :
            while ( $blog_query->have_posts() ) :
                $blog_query->the_post();
                $categories = get_the_category();
                $cat_name   = ! empty( $categories ) ? $categories[0]->name : '';
        ?>
            <article class="blog-card">
                <div class="blog-card__image-wrap">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium', [ 'class' => 'blog-card__image', 'alt' => get_the_title() ] ); ?>
                    <?php else : ?>
                        <div class="blog-card__image-placeholder"></div>
                    <?php endif; ?>
                    <?php if ( $cat_name ) : ?>
                        <span class="blog-card__category"><?php echo esc_html( $cat_name ); ?></span>
                    <?php endif; ?>
                </div>
                <div class="blog-card__body">
                    <div class="blog-card__meta">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                    </div>
                    <h3 class="blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="blog-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 18, '…' ); ?></p>
                    <a href="<?php the_permalink(); ?>" class="blog-card__readmore"><?php esc_html_e( 'Read More →', 'travzo' ); ?></a>
                </div>
            </article>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            // Placeholder blog cards
            $blog_placeholders = [
                [ 'title' => '10 Reasons Why Kashmir Should Be on Your Bucket List', 'excerpt' => 'From the pristine Dal Lake to the snow-draped Gulmarg slopes, Kashmir offers experiences unlike anywhere else in the world.', 'date' => 'March 12, 2025', 'cat' => 'Destinations' ],
                [ 'title' => 'A Complete Guide to the Char Dham Yatra', 'excerpt' => 'Planning the sacred Char Dham Yatra? Here is everything you need to know — best time to visit, route, accommodation, and travel tips.', 'date' => 'February 28, 2025', 'cat' => 'Devotional' ],
                [ 'title' => 'Kerala on a Budget: How to See God\'s Own Country Without Overspending', 'excerpt' => 'Kerala doesn\'t have to be expensive. With the right planning, you can experience the best of this tropical paradise affordably.', 'date' => 'February 10, 2025', 'cat' => 'Travel Tips' ],
            ];
            foreach ( $blog_placeholders as $bp ) : ?>
            <article class="blog-card">
                <div class="blog-card__image-wrap">
                    <div class="blog-card__image-placeholder"></div>
                    <span class="blog-card__category"><?php echo esc_html( $bp['cat'] ); ?></span>
                </div>
                <div class="blog-card__body">
                    <div class="blog-card__meta">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <time><?php echo esc_html( $bp['date'] ); ?></time>
                    </div>
                    <h3 class="blog-card__title"><a href="#"><?php echo esc_html( $bp['title'] ); ?></a></h3>
                    <p class="blog-card__excerpt"><?php echo esc_html( $bp['excerpt'] ); ?></p>
                    <a href="#" class="blog-card__readmore"><?php esc_html_e( 'Read More →', 'travzo' ); ?></a>
                </div>
            </article>
            <?php endforeach;
        endif; ?>
        </div><!-- /.blog-cards-row -->

        <div class="section-cta-wrap">
            <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn--navy-ghost">
                <?php esc_html_e( 'View All Blogs', 'travzo' ); ?>
            </a>
        </div>

    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 10 – NEWSLETTER
════════════════════════════════════════════════════════════════ -->
<section class="newsletter-section">
    <div class="newsletter-inner">

        <div class="newsletter-icon" aria-hidden="true">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
            </svg>
        </div>

        <h2 class="newsletter-heading"><?php esc_html_e( 'Get Travel Deals in Your Inbox', 'travzo' ); ?></h2>
        <p class="newsletter-subtext"><?php esc_html_e( 'Subscribe and be the first to know about our exclusive offers.', 'travzo' ); ?></p>

        <form class="newsletter-form" action="#" method="POST">
            <?php wp_nonce_field( 'travzo_newsletter', 'travzo_newsletter_nonce' ); ?>
            <div class="newsletter-form__pill">
                <label for="newsletter-email" class="screen-reader-text"><?php esc_html_e( 'Your email address', 'travzo' ); ?></label>
                <input type="email" id="newsletter-email" name="newsletter_email" required
                       placeholder="<?php esc_attr_e( 'Enter your email address…', 'travzo' ); ?>">
                <button type="submit"><?php esc_html_e( 'Subscribe', 'travzo' ); ?></button>
            </div>
        </form>

    </div>
</section>

</main><!-- /#main-content -->

<?php get_footer(); ?>
