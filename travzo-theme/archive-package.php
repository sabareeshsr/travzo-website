<?php
/**
 * Archive Template – Packages (archive-package.php)
 * Travzo Holidays WordPress Theme
 */

// ── Read & sanitise GET filter params ─────────────────────────────────────────
$f_destination = isset( $_GET['destination'] ) ? sanitize_text_field( wp_unslash( $_GET['destination'] ) ) : '';
$f_type        = isset( $_GET['type'] )        ? sanitize_text_field( wp_unslash( $_GET['type'] ) )        : '';
$f_duration    = isset( $_GET['duration'] )    ? sanitize_text_field( wp_unslash( $_GET['duration'] ) )    : '';
$f_budget      = isset( $_GET['budget'] )      ? sanitize_text_field( wp_unslash( $_GET['budget'] ) )      : '';
$f_sort        = isset( $_GET['sort'] )        ? sanitize_text_field( wp_unslash( $_GET['sort'] ) )        : 'latest';

// ── Build WP_Query args ────────────────────────────────────────────────────────
$paged    = max( 1, get_query_var( 'paged' ) );
$meta_query = [ 'relation' => 'AND' ];

// Filter: Package Type → ACF text field 'package_type'
if ( $f_type ) {
    $meta_query[] = [
        'key'     => 'package_type',
        'value'   => $f_type,
        'compare' => 'LIKE',
    ];
}

// Filter: Destination → ACF text field 'destinations'
if ( $f_destination ) {
    $meta_query[] = [
        'key'     => 'destinations',
        'value'   => $f_destination,
        'compare' => 'LIKE',
    ];
}

// Filter: Duration → ACF text field 'duration' (stored as e.g. "6 Days / 5 Nights")
if ( $f_duration ) {
    $duration_map = [
        '3-5'  => [ 3, 5 ],
        '6-8'  => [ 6, 8 ],
        '9-12' => [ 9, 12 ],
        '13+'  => [ 13, 99 ],
    ];
    // Simple LIKE match on the duration label string
    $dur_label_map = [
        '3-5'  => '3-5 Days',
        '6-8'  => '6-8 Days',
        '9-12' => '9-12 Days',
        '13+'  => '13+',
    ];
    if ( isset( $dur_label_map[ $f_duration ] ) ) {
        $meta_query[] = [
            'key'     => 'duration',
            'value'   => $dur_label_map[ $f_duration ],
            'compare' => 'LIKE',
        ];
    }
}

// Filter: Budget → ACF text field 'price' (stored as numeric string e.g. "24999")
if ( $f_budget ) {
    $budget_clauses = [
        'under-15000'    => [ 'key' => 'price', 'value' => 15000,        'compare' => '<',        'type' => 'NUMERIC' ],
        '15000-30000'    => [ 'key' => 'price', 'value' => [ 15000, 30000 ], 'compare' => 'BETWEEN', 'type' => 'NUMERIC' ],
        '30000-60000'    => [ 'key' => 'price', 'value' => [ 30000, 60000 ], 'compare' => 'BETWEEN', 'type' => 'NUMERIC' ],
        'above-60000'    => [ 'key' => 'price', 'value' => 60000,        'compare' => '>',        'type' => 'NUMERIC' ],
    ];
    if ( isset( $budget_clauses[ $f_budget ] ) ) {
        $meta_query[] = $budget_clauses[ $f_budget ];
    }
}

// Sort order
$orderby = 'date';
$order   = 'DESC';
$meta_key_sort = '';

switch ( $f_sort ) {
    case 'price-asc':
        $orderby       = 'meta_value_num';
        $order         = 'ASC';
        $meta_key_sort = 'price';
        break;
    case 'price-desc':
        $orderby       = 'meta_value_num';
        $order         = 'DESC';
        $meta_key_sort = 'price';
        break;
    case 'duration-asc':
        $orderby       = 'meta_value_num';
        $order         = 'ASC';
        $meta_key_sort = 'duration';
        break;
}

$query_args = [
    'post_type'      => 'package',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'orderby'        => $orderby,
    'order'          => $order,
];

if ( count( $meta_query ) > 1 ) {
    $query_args['meta_query'] = $meta_query;
}

if ( $meta_key_sort ) {
    $query_args['meta_key'] = $meta_key_sort;
}

$packages = new WP_Query( $query_args );

// ── Star SVG helper ────────────────────────────────────────────────────────────
$star_svg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true">'
          . '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>'
          . '</svg>';

get_header();
?>

<main id="main-content">

<!-- ════════════════════════════════════════════════════════════
     SECTION 1 – PAGE HERO
════════════════════════════════════════════════════════════ -->
<section class="page-hero">
    <div class="page-hero-overlay"></div>

    <div class="page-hero__content">

        <!-- Breadcrumb -->
        <nav class="page-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'travzo' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'travzo' ); ?></a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
            <span><?php esc_html_e( 'Packages', 'travzo' ); ?></span>
        </nav>

        <h1 class="page-hero__heading"><?php esc_html_e( 'Our Packages', 'travzo' ); ?></h1>

        <p class="page-hero__subtext">
            <?php esc_html_e( 'Explore our handcrafted travel experiences across India and the world', 'travzo' ); ?>
        </p>

        <!-- Stat pills -->
        <div class="page-hero__pills">
            <span class="hero-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                <?php esc_html_e( '100+ Packages Available', 'travzo' ); ?>
            </span>
            <span class="hero-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?php esc_html_e( '3 to 14 Days', 'travzo' ); ?>
            </span>
            <span class="hero-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                <?php esc_html_e( 'Starting ₹15,000', 'travzo' ); ?>
            </span>
        </div>

    </div><!-- /.page-hero__content -->
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 2 – FILTER BAR
════════════════════════════════════════════════════════════ -->
<div class="filter-bar" id="filter-bar">
    <form class="filter-bar__form" id="filter-form" method="GET"
          action="<?php echo esc_url( get_post_type_archive_link( 'package' ) ); ?>">

        <span class="filter-bar__label"><?php esc_html_e( 'Filter By:', 'travzo' ); ?></span>

        <!-- Destination -->
        <div class="filter-select-wrap">
            <select id="filter-destination" name="destination" class="filter-select" aria-label="<?php esc_attr_e( 'Filter by destination', 'travzo' ); ?>">
                <option value=""><?php esc_html_e( 'All Destinations', 'travzo' ); ?></option>
                <?php
                $destinations = [
                    'india'       => 'India',
                    'international' => 'International',
                    'Bali'        => 'Bali',
                    'Thailand'    => 'Thailand',
                    'Singapore'   => 'Singapore',
                    'Malaysia'    => 'Malaysia',
                    'Dubai'       => 'Dubai',
                    'Europe'      => 'Europe',
                    'Kashmir'     => 'Kashmir',
                    'Kerala'      => 'Kerala',
                    'Goa'         => 'Goa',
                    'Rajasthan'   => 'Rajasthan',
                    'Maldives'    => 'Maldives',
                    'Andaman'     => 'Andaman',
                ];
                foreach ( $destinations as $val => $label ) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr( $val ),
                        selected( $f_destination, $val, false ),
                        esc_html( $label )
                    );
                }
                ?>
            </select>
            <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </div>

        <!-- Package Type -->
        <div class="filter-select-wrap">
            <select id="filter-type" name="type" class="filter-select" aria-label="<?php esc_attr_e( 'Filter by package type', 'travzo' ); ?>">
                <option value=""><?php esc_html_e( 'All Types', 'travzo' ); ?></option>
                <?php
                $types = [
                    'Group Tours'         => 'Group Tours',
                    'Honeymoon'           => 'Honeymoon',
                    'Solo Trips'          => 'Solo Trips',
                    'Devotional'          => 'Devotional',
                    'Destination Wedding' => 'Destination Wedding',
                    'International'       => 'International',
                ];
                foreach ( $types as $val => $label ) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr( $val ),
                        selected( $f_type, $val, false ),
                        esc_html( $label )
                    );
                }
                ?>
            </select>
            <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </div>

        <!-- Duration -->
        <div class="filter-select-wrap">
            <select id="filter-duration" name="duration" class="filter-select" aria-label="<?php esc_attr_e( 'Filter by duration', 'travzo' ); ?>">
                <option value=""><?php esc_html_e( 'Any Duration', 'travzo' ); ?></option>
                <?php
                $durations = [
                    '3-5'  => '3–5 Days',
                    '6-8'  => '6–8 Days',
                    '9-12' => '9–12 Days',
                    '13+'  => '13+ Days',
                ];
                foreach ( $durations as $val => $label ) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr( $val ),
                        selected( $f_duration, $val, false ),
                        esc_html( $label )
                    );
                }
                ?>
            </select>
            <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </div>

        <!-- Budget -->
        <div class="filter-select-wrap">
            <select id="filter-budget" name="budget" class="filter-select" aria-label="<?php esc_attr_e( 'Filter by budget', 'travzo' ); ?>">
                <option value=""><?php esc_html_e( 'Any Budget', 'travzo' ); ?></option>
                <?php
                $budgets = [
                    'under-15000'  => 'Under ₹15,000',
                    '15000-30000'  => '₹15,000 – ₹30,000',
                    '30000-60000'  => '₹30,000 – ₹60,000',
                    'above-60000'  => '₹60,000+',
                ];
                foreach ( $budgets as $val => $label ) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr( $val ),
                        selected( $f_budget, $val, false ),
                        esc_html( $label )
                    );
                }
                ?>
            </select>
            <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </div>

        <!-- Spacer -->
        <div class="filter-bar__spacer"></div>

        <!-- Sort -->
        <div class="filter-select-wrap filter-select-wrap--sort">
            <select id="filter-sort" name="sort" class="filter-select" aria-label="<?php esc_attr_e( 'Sort packages', 'travzo' ); ?>">
                <?php
                $sorts = [
                    'latest'       => 'Sort By: Latest',
                    'price-asc'    => 'Price: Low to High',
                    'price-desc'   => 'Price: High to Low',
                    'duration-asc' => 'Duration: Short to Long',
                ];
                foreach ( $sorts as $val => $label ) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr( $val ),
                        selected( $f_sort, $val, false ),
                        esc_html( $label )
                    );
                }
                ?>
            </select>
            <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </div>

        <!-- Hidden submit for no-JS fallback -->
        <button type="submit" class="filter-bar__submit-btn" aria-label="<?php esc_attr_e( 'Apply filters', 'travzo' ); ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>

    </form>
</div><!-- /.filter-bar -->


<!-- ════════════════════════════════════════════════════════════
     SECTION 3 – PACKAGES GRID
════════════════════════════════════════════════════════════ -->
<section class="packages-grid-section">
    <div class="packages-grid-inner">

        <!-- Result count -->
        <div class="packages-result-bar">
            <p class="packages-result-count">
                <?php
                printf(
                    /* translators: %d = number of packages found */
                    esc_html( _n( 'Showing %d package', 'Showing %d packages', $packages->found_posts, 'travzo' ) ),
                    (int) $packages->found_posts
                );
                ?>
            </p>
            <?php if ( $f_destination || $f_type || $f_duration || $f_budget ) : ?>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'package' ) ); ?>" class="filter-clear-btn">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    <?php esc_html_e( 'Clear Filters', 'travzo' ); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if ( $packages->have_posts() ) : ?>

            <div class="packages-grid" id="packages-grid">
                <?php while ( $packages->have_posts() ) : $packages->the_post();
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
                <article id="package-<?php the_ID(); ?>" class="package-card" <?php post_class( 'package-card' ); ?>>

                    <!-- Thumbnail -->
                    <div class="package-card__image-wrap">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'package-card', [ 'class' => 'package-card__image', 'alt' => get_the_title(), 'loading' => 'lazy' ] ); ?>
                        <?php else : ?>
                            <div class="package-card__image-placeholder">
                                <?php if ( $destination ) : ?>
                                    <span><?php echo esc_html( $destination ); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $pkg_type ) : ?>
                            <span class="package-card__type-tag"><?php echo esc_html( $pkg_type ); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Card body -->
                    <div class="package-card__body">

                        <!-- Stars -->
                        <div class="package-card__stars" aria-label="<?php esc_attr_e( '5 stars', 'travzo' ); ?>">
                            <?php echo str_repeat( $star_svg, 5 ); ?>
                        </div>

                        <!-- Title -->
                        <h3 class="package-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <!-- Destination -->
                        <?php if ( $destination ) : ?>
                        <p class="package-card__destination">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php echo esc_html( $destination ); ?>
                        </p>
                        <?php endif; ?>

                        <!-- Duration + Pax row -->
                        <div class="package-card__meta-row">
                            <?php if ( $duration ) : ?>
                                <span class="package-card__duration"><?php echo esc_html( $duration ); ?></span>
                            <?php endif; ?>
                            <span class="package-card__pax">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                2–15 Pax
                            </span>
                        </div>

                        <!-- Price -->
                        <?php if ( $price ) : ?>
                        <div class="package-card__price">
                            <span class="package-card__price-from"><?php esc_html_e( 'Starting from', 'travzo' ); ?></span>
                            <span class="package-card__price-amount">
                                <?php echo esc_html( $price ); ?>
                            </span>
                        </div>
                        <?php endif; ?>

                        <!-- CTA -->
                        <a href="<?php the_permalink(); ?>" class="pkg-cta-btn">
                            <?php esc_html_e( 'View Package', 'travzo' ); ?>
                        </a>

                    </div><!-- /.package-card__body -->
                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div><!-- /.packages-grid -->

            <!-- Pagination -->
            <nav class="packages-pagination" aria-label="<?php esc_attr_e( 'Packages pagination', 'travzo' ); ?>">
                <?php
                the_posts_pagination( [
                    'mid_size'           => 2,
                    'prev_text'          => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>',
                    'next_text'          => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>',
                    'screen_reader_text' => __( 'Packages navigation', 'travzo' ),
                    'type'               => 'plain',
                    'before_page_number' => '<span class="page-num-inner">',
                    'after_page_number'  => '</span>',
                ] );
                ?>
            </nav>

        <?php else : ?>

            <!-- Empty state -->
            <div class="packages-empty">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="rgba(26,42,94,0.2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <h2 class="packages-empty__heading"><?php esc_html_e( 'No Packages Found', 'travzo' ); ?></h2>
                <p class="packages-empty__text">
                    <?php esc_html_e( 'Try adjusting your filters or', 'travzo' ); ?>
                </p>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'package' ) ); ?>" class="btn btn--gold">
                    <?php esc_html_e( 'View All Packages', 'travzo' ); ?>
                </a>
            </div>

        <?php endif; ?>

    </div><!-- /.packages-grid-inner -->
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 4 – QUICK ENQUIRY STRIP
════════════════════════════════════════════════════════════ -->
<section class="enquiry-strip">
    <div class="enquiry-strip__inner">

        <div class="enquiry-strip__left">
            <h2 class="enquiry-strip__heading">
                <?php esc_html_e( "Can't find the perfect package?", 'travzo' ); ?>
            </h2>
            <p class="enquiry-strip__subtext">
                <?php esc_html_e( 'Our travel experts will craft a custom itinerary just for you.', 'travzo' ); ?>
            </p>
        </div>

        <div class="enquiry-strip__right">
            <a href="tel:+91XXXXXXXXXX" class="btn btn--navy">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 011 2.18 2 2 0 013 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/></svg>
                <?php esc_html_e( 'Call Us Now', 'travzo' ); ?>
            </a>
            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn--ghost-white">
                <?php esc_html_e( 'Send Enquiry', 'travzo' ); ?>
            </a>
        </div>

    </div>
</section>

</main><!-- /#main-content -->

<?php get_footer(); ?>
