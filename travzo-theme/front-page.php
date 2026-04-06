<?php
/**
 * Front Page Template – Travzo Holidays Homepage
 *
 * TODO: Replace custom forms with WPForms shortcodes once WPForms is installed.
 * 1. Install WPForms plugin and create your forms.
 * 2. Go to Travzo Settings → WPForms Integration and enter the form IDs.
 * 3. The travzo_render_form() helper will automatically use WPForms when an ID is saved.
 *    Manual override: <?php echo do_shortcode('[wpforms id="YOUR_FORM_ID"]'); ?>
 */

// ── Section 8 form handling ────────────────────────────────────────────────────
$enquiry_sent  = false;
$enquiry_error = false;

if ( isset( $_POST['travzo_enquiry'], $_POST['travzo_nonce'] ) &&
     wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['travzo_nonce'] ) ), 'travzo_enquiry_form' ) ) {

    $name        = sanitize_text_field( wp_unslash( $_POST['enquiry_name']        ?? '' ) );
    $city        = sanitize_text_field( wp_unslash( $_POST['enquiry_city']        ?? '' ) );
    $email       = sanitize_email(      wp_unslash( $_POST['enquiry_email']       ?? '' ) );
    $phone       = sanitize_text_field( wp_unslash( $_POST['enquiry_phone']       ?? '' ) );
    $destination = sanitize_text_field( wp_unslash( $_POST['enquiry_destination'] ?? '' ) );
    $travel_date = sanitize_text_field( wp_unslash( $_POST['enquiry_date']        ?? '' ) );
    $people      = absint(              wp_unslash( $_POST['enquiry_people']      ?? 1  ) );
    $trip_type   = sanitize_text_field( wp_unslash( $_POST['enquiry_trip_type']   ?? '' ) );

    if ( $name && $email && is_email( $email ) ) {
        $to      = travzo_get( 'travzo_email', 'hello@travzoholidays.com' );
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
$hero_image              = travzo_get( 'travzo_hero_image', '' );
$hero_badge              = travzo_get( 'travzo_hero_badge',     'Trusted by 500+ Happy Travellers' );
$hero_heading            = travzo_get( 'travzo_hero_heading',   'Discover the World With Travzo Holidays' );
$hero_subtext            = travzo_get( 'travzo_hero_subtext',   'Handcrafted itineraries for every kind of traveller.' );
$hero_primary_btn_text   = travzo_get( 'travzo_hero_btn1_text', 'Explore Packages' );
$hero_primary_btn_url    = travzo_get( 'travzo_hero_btn1_url',  home_url( '/packages' ) );
$hero_secondary_btn_text = travzo_get( 'travzo_hero_btn2_text', 'Enquire Now' );
$hero_secondary_btn_url  = travzo_get( 'travzo_hero_btn2_url',  home_url( '/contact' ) );

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
            <a href="<?php echo esc_url( $hero_primary_btn_url ); ?>" class="btn btn--gold">
                <?php echo esc_html( $hero_primary_btn_text ); ?>
            </a>
            <a href="<?php echo esc_url( $hero_secondary_btn_url ); ?>" class="btn btn--ghost-white">
                <?php echo esc_html( $hero_secondary_btn_text ); ?>
            </a>
        </div>
    </div><!-- /.hero-content -->

</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 2 – OUR PACKAGES
════════════════════════════════════════════════════════════════ -->
<?php
$pkg_section_label   = travzo_get( 'travzo_packages_label',   'WHAT WE OFFER' );
$pkg_section_heading = travzo_get( 'travzo_packages_heading', 'Our Packages' );

// Build default tiles from canonical package types — values match _package_type meta exactly
$_pkg_types = [
    [ 'label' => 'Group Tours',          'meta' => 'Group Tour',          'color' => '#1A3A5C' ],
    [ 'label' => 'Honeymoon Packages',   'meta' => 'Honeymoon',           'color' => '#3D1A4A' ],
    [ 'label' => 'Solo Trips',           'meta' => 'Solo Trip',           'color' => '#1A4A3D' ],
    [ 'label' => 'Devotional Tours',     'meta' => 'Devotional',          'color' => '#4A3D1A' ],
    [ 'label' => 'Destination Weddings', 'meta' => 'Destination Wedding', 'color' => '#1A2A5E' ],
    [ 'label' => 'International',        'meta' => 'International',       'color' => '#2D1A4A' ],
];
$_default_tiles = [];
foreach ( $_pkg_types as $pt ) {
    $cq = new WP_Query( [
        'post_type'      => 'package',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => [ [ 'key' => '_package_type', 'value' => $pt['meta'], 'compare' => '=' ] ],
    ] );
    $cnt = $cq->found_posts;
    wp_reset_postdata();
    $_default_tiles[] = [
        $pt['label'],
        $cnt . ' Package' . ( $cnt !== 1 ? 's' : '' ),
        home_url( '/packages?type=' . urlencode( $pt['meta'] ) ),
        '',
        $pt['color'],
    ];
}

// Use admin-configured tiles (_package_tiles_v2 repeater) if set, otherwise auto-generate
$_custom_tiles = get_post_meta( get_the_ID(), '_package_tiles_v2', true );
if ( is_array( $_custom_tiles ) && ! empty( $_custom_tiles ) ) {
    $pkg_tiles_data = [];
    foreach ( $_custom_tiles as $ct ) {
        $cq = new WP_Query( [
            'post_type'      => 'package',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'meta_query'     => [ [ 'key' => '_package_type', 'value' => $ct['type'], 'compare' => '=' ] ],
        ] );
        $cnt = $cq->found_posts;
        wp_reset_postdata();
        $pkg_tiles_data[] = [
            $ct['name'],
            $cnt . ' Package' . ( $cnt !== 1 ? 's' : '' ),
            home_url( '/packages?type=' . urlencode( $ct['type'] ) ),
            $ct['image'],
            '#1A2A5E',
        ];
    }
} else {
    $pkg_tiles_data = $_default_tiles;
}

$pkg_tile_colors = [ '#2D5016', '#5C1A4A', '#1A3A5C', '#5C3A1A', '#1A5C4A', '#2A1A5C' ];
?>
<section class="packages-section">
    <div class="section-inner">
        <div class="section-label"><?php echo esc_html( $pkg_section_label ); ?></div>
        <h2 class="section-heading"><?php echo esc_html( $pkg_section_heading ); ?></h2>

        <div class="package-tiles-grid">
            <?php foreach ( $pkg_tiles_data as $idx => $tile ) :
                $t_name  = $tile[0] ?? '';
                $t_count = $tile[1] ?? '';
                $t_url   = $tile[2] ?? home_url( '/packages' );
                $t_image = $tile[3] ?? '';
                $t_color = $pkg_tile_colors[ $idx % count( $pkg_tile_colors ) ];
                $t_class = ( $idx < 2 ) ? 'package-tile package-tile--large' : 'package-tile package-tile--small';
                $t_style = $t_image
                    ? 'background-image: url(' . esc_url( $t_image ) . ');'
                    : 'background-color: ' . esc_attr( $t_color ) . ';';
            ?>
            <a href="<?php echo esc_url( $t_url ); ?>"
               class="<?php echo esc_attr( $t_class ); ?>"
               style="<?php echo $t_style; ?>">
                <div class="package-tile__overlay"></div>
                <div class="package-tile__content">
                    <span class="package-tile__name"><?php echo esc_html( $t_name ); ?></span>
                    <?php if ( $t_count ) : ?>
                    <span class="package-tile__count"><?php echo esc_html( $t_count ); ?></span>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div><!-- /.package-tiles-grid -->
    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 3 – STATS BAR
════════════════════════════════════════════════════════════════ -->
<?php
$stats = [
    [
        'number'      => travzo_get( 'travzo_stat_1_number', '500+' ),
        'label'       => travzo_get( 'travzo_stat_1_label',  'Happy Travellers' ),
        'description' => travzo_get( 'travzo_stat_1_description', 'Memorable journeys created' ),
    ],
    [
        'number'      => travzo_get( 'travzo_stat_2_number', '50+' ),
        'label'       => travzo_get( 'travzo_stat_2_label',  'Destinations' ),
        'description' => travzo_get( 'travzo_stat_2_description', 'Across India and abroad' ),
    ],
    [
        'number'      => travzo_get( 'travzo_stat_3_number', '10+' ),
        'label'       => travzo_get( 'travzo_stat_3_label',  'Years Experience' ),
        'description' => travzo_get( 'travzo_stat_3_description', 'Of trusted travel expertise' ),
    ],
    [
        'number'      => travzo_get( 'travzo_stat_4_number', '100%' ),
        'label'       => travzo_get( 'travzo_stat_4_label',  'Customised Itineraries' ),
        'description' => travzo_get( 'travzo_stat_4_description', 'Tailored to your needs' ),
    ],
];
?>
<section class="stats-section">
    <div class="stats-inner">
        <?php foreach ( $stats as $index => $stat ) :
            $number      = $stat['number'];
            $label       = $stat['label'];
            $description = $stat['description'];
        ?>
        <div class="stat-block">
            <span class="stat-number"><?php echo esc_html( $number ); ?></span>
            <span class="stat-label"><?php echo esc_html( $label ); ?></span>
            <span class="stat-description"><?php echo esc_html( $description ); ?></span>
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
$about_label     = travzo_get( 'travzo_about_label',   'WHO WE ARE' );
$about_heading   = travzo_get( 'travzo_about_heading', 'Your Trusted Travel Partner' );
$about_image_url = travzo_get( 'travzo_about_image',   '' );
$about_text      = travzo_get( 'travzo_about_text',    'Travzo Holidays is a Coimbatore-based travel agency with over a decade of experience crafting unforgettable journeys. From serene backwater cruises in Kerala to sacred Char Dham pilgrimages, we design every itinerary with care, passion, and deep local knowledge — so you can travel with complete peace of mind.' );
$about_feature_1 = travzo_get( 'travzo_about_feat1',   'Handcrafted Itineraries' );
$about_feature_2 = travzo_get( 'travzo_about_feat2',   'Best Price Guarantee' );
$about_feature_3 = travzo_get( 'travzo_about_feat3',   '24/7 Support' );
$about_btn_text  = 'Learn More About Us';
$about_btn_url   = home_url( '/about' );
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
            <div class="section-label"><?php echo esc_html( $about_label ); ?></div>
            <h2 class="section-heading section-heading--left"><?php echo esc_html( $about_heading ); ?></h2>
            <p class="about-snippet__text"><?php echo wp_kses_post( $about_text ); ?></p>

            <ul class="about-features">
                <?php foreach ( [ $about_feature_1, $about_feature_2, $about_feature_3 ] as $feature ) :
                    if ( ! $feature ) continue; ?>
                <li class="about-feature">
                    <svg class="about-feature__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <?php echo esc_html( $feature ); ?>
                </li>
                <?php endforeach; ?>
            </ul>

            <a href="<?php echo esc_url( $about_btn_url ); ?>" class="btn btn--navy">
                <?php echo esc_html( $about_btn_text ); ?>
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
        $trending_query = new WP_Query( [
            'post_type'      => 'package',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
            'meta_query'     => [ [ 'key' => '_is_trending', 'value' => '1', 'compare' => '=' ] ],
        ] );

        // Fallback: latest 4 packages if none are flagged trending
        if ( ! $trending_query->have_posts() ) {
            $trending_query = new WP_Query( [
                'post_type'      => 'package',
                'posts_per_page' => 4,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ] );
        }

        // Star SVG reused per card
        $star_svg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';

        if ( $trending_query->have_posts() ) :
            while ( $trending_query->have_posts() ) :
                $trending_query->the_post();
                $pkg_type    = get_post_meta( get_the_ID(), '_package_type',         true );
                $destination = get_post_meta( get_the_ID(), '_package_destinations', true );
                $duration    = get_post_meta( get_the_ID(), '_package_duration',     true );
                $price       = get_post_meta( get_the_ID(), '_package_price',        true );
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
            // Placeholder cards when no packages published yet
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
<?php
$why_label   = travzo_get( 'travzo_why_us_label',   'Our Promise' );
$why_heading = travzo_get( 'travzo_why_us_heading', 'Why Travel With Travzo' );
$why_tiles   = travzo_parse_lines( travzo_get( 'travzo_why_us_tiles', '' ), 2 );

if ( empty( $why_tiles ) ) {
    $why_tiles = [
        [ 'Handcrafted Itineraries', 'Every trip is built around your preferences, pace, and budget — no cookie-cutter packages, just journeys made for you.' ],
        [ 'Best Price Guarantee',    'We negotiate directly with hotels, airlines, and local operators so you always get the most value for your money.' ],
        [ '24/7 Dedicated Support',  'Our travel experts are always just a call or WhatsApp message away — before, during, and after your trip.' ],
        [ 'Expert Local Knowledge',  'Our team has firsthand experience of every destination we offer, giving you authentic insider recommendations.' ],
        [ 'Visa & Documentation',    'We handle all visa paperwork and travel documentation so you can focus on the excitement of your upcoming trip.' ],
        [ 'Safe & Reliable Travel',  'All our partners — hotels, transport, guides — are carefully vetted for safety, quality, and reliability.' ],
    ];
}

// 6 icons cycling per tile
$why_icons = [
    '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>',
    '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>',
    '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 18v-6a9 9 0 0118 0v6"/><path d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"/></svg>',
    '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>',
    '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
    '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
];
?>
<section class="why-us-section">
    <div class="section-inner">
        <div class="section-label"><?php echo esc_html( $why_label ); ?></div>
        <h2 class="section-heading"><?php echo esc_html( $why_heading ); ?></h2>

        <div class="why-us-blocks">
            <?php foreach ( $why_tiles as $i => $tile ) :
                $w_title = esc_html( $tile[0] ?? '' );
                $w_text  = esc_html( $tile[1] ?? '' );
                $w_icon  = $why_icons[ $i % count( $why_icons ) ];
            ?>
            <div class="why-us-block">
                <div class="why-us-block__icon-wrap">
                    <?php echo $w_icon; ?>
                </div>
                <h3 class="why-us-block__title"><?php echo $w_title; ?></h3>
                <p class="why-us-block__text"><?php echo $w_text; ?></p>
            </div>
            <?php endforeach; ?>
        </div><!-- /.why-us-blocks -->

    </div>
</section>


<!-- ════════════════════════════════════════════════════════════════
     SECTION 7 – TESTIMONIALS
════════════════════════════════════════════════════════════════ -->
<?php
// cols: [0]=name, [1]=trip, [2]=quote
$testimonials_raw = get_post_meta( get_the_ID(), '_testimonials', true );
$testimonials     = travzo_parse_lines( $testimonials_raw, 3 );

if ( empty( $testimonials ) ) {
    $testimonials = [
        [ 'Priya & Arjun Nair',    'Kashmir Honeymoon – 7 Days',       '"Travzo made our Kashmir honeymoon absolutely magical. Every detail was taken care of — from the shikara ride to the houseboat stay. We didn\'t have to worry about a single thing."' ],
        [ 'Rajesh Murugan',        'Char Dham Yatra – 12 Days',        '"We did the Char Dham Yatra with Travzo and it was a life-changing experience. The team\'s coordination was flawless, and our guide was knowledgeable and caring throughout."' ],
        [ 'Sunita Krishnamurthy',  'Rajasthan Group Tour – 8 Days',    '"Booked a group tour to Rajasthan for 18 people and everything went smoothly. Great hotels, punctual transfers, and the best price we found anywhere. Highly recommend Travzo!"' ],
    ];
}

$star_svg_white = '<svg width="14" height="14" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>';
?>
<section class="testimonials-section">
    <div class="section-inner">
        <div class="section-label section-label--white">What Our Travellers Say</div>
        <h2 class="section-heading section-heading--white">Real Stories, Real Journeys</h2>

        <div class="testimonials-row">
        <?php foreach ( $testimonials as $t ) :
            $name     = $t[0] ?? '';
            $trip     = $t[1] ?? '';
            $quote    = $t[2] ?? '';
            $avatar   = '';
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
<?php
$enq_phone     = travzo_get( 'travzo_phone', '' );
$enq_email     = travzo_get( 'travzo_email', '' );
$enq_whatsapp  = travzo_get( 'travzo_whatsapp', '' );
$enq_hours     = travzo_get( 'travzo_footer_hours', 'Mon – Sat: 9:00 AM – 7:00 PM' );
$enq_phone_url = $enq_phone ? 'tel:' . preg_replace( '/[^+0-9]/', '', $enq_phone ) : '';
$enq_wa_url    = $enq_whatsapp ? 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $enq_whatsapp ) : '';
?>
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
                <?php if ( $enq_phone ) : ?>
                <div class="enquiry-contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 011 2.18 2 2 0 013 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/></svg>
                    <a href="<?php echo esc_url( $enq_phone_url ); ?>" class="enquiry-contact-row__text"><?php echo esc_html( $enq_phone ); ?></a>
                </div>
                <?php endif; ?>
                <?php if ( $enq_email ) : ?>
                <div class="enquiry-contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <a href="mailto:<?php echo esc_attr( $enq_email ); ?>" class="enquiry-contact-row__text"><?php echo esc_html( $enq_email ); ?></a>
                </div>
                <?php endif; ?>
                <?php if ( $enq_whatsapp ) : ?>
                <div class="enquiry-contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <a href="<?php echo esc_url( $enq_wa_url ); ?>" target="_blank" rel="noopener noreferrer" class="enquiry-contact-row__text">WhatsApp Us</a>
                </div>
                <?php endif; ?>
                <?php if ( $enq_hours ) : ?>
                <div class="enquiry-contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span class="enquiry-contact-row__text"><?php echo esc_html( $enq_hours ); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div><!-- /.enquiry-info -->

        <!-- Right: form card -->
        <div class="enquiry-form-card">
            <?php travzo_render_form( 'travzo_form_enquiry', travzo_default_enquiry_form() ); ?>
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
            'meta_query'     => [ [ 'key' => '_is_featured_blog', 'value' => '1', 'compare' => '=' ] ],
        ] );

        // Fallback: latest 3 posts if none are flagged featured
        if ( ! $blog_query->have_posts() ) {
            $blog_query = new WP_Query( [
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ] );
        }

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
<?php
$nl_heading     = travzo_get( 'travzo_newsletter_heading', 'Get Travel Deals in Your Inbox' );
$nl_subtext     = travzo_get( 'travzo_newsletter_subtext', 'Subscribe and be the first to know about our exclusive offers.' );
$nl_button_text = 'Subscribe';
?>
<section class="newsletter-section">
    <div class="newsletter-inner">

        <div class="newsletter-icon" aria-hidden="true">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
            </svg>
        </div>

        <h2 class="newsletter-heading"><?php echo esc_html( $nl_heading ); ?></h2>
        <p class="newsletter-subtext"><?php echo esc_html( $nl_subtext ); ?></p>

        <?php
        $nl_fallback = '<form class="newsletter-form" action="#" method="POST">'
            . wp_nonce_field( 'travzo_newsletter', 'travzo_newsletter_nonce', true, false )
            . '<div class="newsletter-form__pill">'
            . '<label for="newsletter-email" class="screen-reader-text">Your email address</label>'
            . '<input type="email" id="newsletter-email" name="newsletter_email" required placeholder="Enter your email address…">'
            . '<button type="submit">Subscribe</button>'
            . '</div></form>';
        travzo_render_form( 'travzo_form_newsletter', $nl_fallback );
        ?>

    </div>
</section>

</main><!-- /#main-content -->

<?php get_footer(); ?>
