<?php
/**
 * Archive Template – Packages (archive-package.php)
 * Travzo Holidays WordPress Theme
 */

// ── Read & sanitise GET filter params ─────────────────────────────────────────
$f_sq          = isset( $_GET['sq'] )          ? sanitize_text_field( wp_unslash( $_GET['sq'] ) )          : '';
$f_destination = isset( $_GET['destination'] ) ? sanitize_text_field( wp_unslash( $_GET['destination'] ) ) : '';
$f_type        = isset( $_GET['type'] )        ? sanitize_text_field( wp_unslash( $_GET['type'] ) )        : '';
$f_region      = isset( $_GET['region'] )      ? sanitize_text_field( wp_unslash( $_GET['region'] ) )      : '';
$f_country     = isset( $_GET['country'] )     ? sanitize_text_field( wp_unslash( $_GET['country'] ) )     : '';
$f_subregion   = isset( $_GET['subregion'] )   ? sanitize_text_field( wp_unslash( $_GET['subregion'] ) )   : '';
$f_duration    = isset( $_GET['duration'] )    ? sanitize_text_field( wp_unslash( $_GET['duration'] ) )    : '';
$f_budget      = isset( $_GET['budget'] )      ? sanitize_text_field( wp_unslash( $_GET['budget'] ) )      : '';
$f_sort        = isset( $_GET['sort'] )        ? sanitize_text_field( wp_unslash( $_GET['sort'] ) )        : 'latest';

// ── Build WP_Query args ────────────────────────────────────────────────────────
$paged    = max( 1, get_query_var( 'paged' ) );
$meta_query = [ 'relation' => 'AND' ];

// Filter: Package Type → native meta key '_package_type'
if ( $f_type ) {
    $meta_query[] = [
        'key'     => '_package_type',
        'value'   => $f_type,
        'compare' => '=',
    ];
}

// Filter: Region → native meta key '_pkg_region'
if ( $f_region ) {
    $meta_query[] = [
        'key'     => '_pkg_region',
        'value'   => $f_region,
        'compare' => '=',
    ];
}

// Filter: Country → native meta key '_pkg_country'
if ( $f_country ) {
    $meta_query[] = [
        'key'     => '_pkg_country',
        'value'   => $f_country,
        'compare' => '=',
    ];
}

// Filter: Destination → native meta key '_package_destinations'
if ( $f_destination ) {
    $meta_query[] = [
        'key'     => '_package_destinations',
        'value'   => $f_destination,
        'compare' => 'LIKE',
    ];
}

// Filter: Sub-region → taxonomy query
$tax_query = [];
if ( $f_subregion ) {
    $tax_query[] = [
        'taxonomy' => 'package_destination',
        'field'    => 'name',
        'terms'    => $f_subregion,
    ];
}

// Filter: Duration → native meta key '_package_duration'
if ( $f_duration ) {
    $dur_label_map = [
        '3-5'  => '3-5 Days',
        '6-8'  => '6-8 Days',
        '9-12' => '9-12 Days',
        '13+'  => '13+',
    ];
    if ( isset( $dur_label_map[ $f_duration ] ) ) {
        $meta_query[] = [
            'key'     => '_package_duration',
            'value'   => $dur_label_map[ $f_duration ],
            'compare' => 'LIKE',
        ];
    }
}

// Filter: Budget → native meta key '_package_price' (stored as numeric string)
if ( $f_budget ) {
    $budget_clauses = [
        'under-15000'  => [ 'key' => '_package_price', 'value' => 15000,             'compare' => '<',        'type' => 'NUMERIC' ],
        '15000-30000'  => [ 'key' => '_package_price', 'value' => [ 15000, 30000 ],  'compare' => 'BETWEEN',  'type' => 'NUMERIC' ],
        '30000-60000'  => [ 'key' => '_package_price', 'value' => [ 30000, 60000 ],  'compare' => 'BETWEEN',  'type' => 'NUMERIC' ],
        'above-60000'  => [ 'key' => '_package_price', 'value' => 60000,             'compare' => '>',        'type' => 'NUMERIC' ],
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
        $meta_key_sort = '_package_price';
        break;
    case 'price-desc':
        $orderby       = 'meta_value_num';
        $order         = 'DESC';
        $meta_key_sort = '_package_price';
        break;
    case 'duration-asc':
        $orderby       = 'meta_value_num';
        $order         = 'ASC';
        $meta_key_sort = '_package_duration';
        break;
    case 'duration-desc':
        $orderby       = 'meta_value_num';
        $order         = 'DESC';
        $meta_key_sort = '_package_duration';
        break;
    case 'popular':
        $orderby       = 'meta_value_num';
        $order         = 'DESC';
        $meta_key_sort = '_is_trending';
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

// Search
if ( $f_sq ) {
    $query_args['s'] = $f_sq;
}

if ( count( $meta_query ) > 1 ) {
    $query_args['meta_query'] = $meta_query;
}

if ( ! empty( $tax_query ) ) {
    $query_args['tax_query'] = $tax_query;
}

if ( $meta_key_sort ) {
    $query_args['meta_key'] = $meta_key_sort;
}

$packages = new WP_Query( $query_args );

// Check if any filters are active
$has_active_filters = $f_sq || $f_destination || $f_type || $f_region || $f_country || $f_subregion || $f_duration || $f_budget;

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
<?php
$_pkg_hero_img   = travzo_get( 'travzo_packages_hero_image', '' );
$_pkg_hero_style = $_pkg_hero_img ? 'background-image:url(' . esc_url( $_pkg_hero_img ) . ');background-size:cover;background-position:center' : '';
?>
<section class="page-hero"<?php if ( $_pkg_hero_style ) : ?> style="<?php echo $_pkg_hero_style; ?>"<?php endif; ?>>
    <div class="page-hero-overlay"></div>

    <div class="page-hero__content">

        <nav class="page-hero__breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'travzo' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'travzo' ); ?></a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
            <span><?php esc_html_e( 'Packages', 'travzo' ); ?></span>
        </nav>

        <h1 class="page-hero__heading"><?php echo esc_html( travzo_get( 'travzo_packages_hero_title', 'Our Packages' ) ); ?></h1>

        <p class="page-hero__subtext">
            <?php echo esc_html( travzo_get( 'travzo_packages_hero_desc', 'Explore our handcrafted travel experiences across India and the world' ) ); ?>
        </p>

        <!-- Stat pills -->
        <div class="page-hero__pills">
            <span class="hero-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                <?php echo esc_html( travzo_get( 'travzo_packages_hero_pill1', '100+ Packages Available' ) ); ?>
            </span>
            <span class="hero-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?php echo esc_html( travzo_get( 'travzo_packages_hero_pill2', '3 to 14 Days' ) ); ?>
            </span>
            <span class="hero-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                <?php echo esc_html( travzo_get( 'travzo_packages_hero_pill3', 'Starting ₹15,000' ) ); ?>
            </span>
        </div>

    </div><!-- /.page-hero__content -->
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 2 – FILTER BAR
════════════════════════════════════════════════════════════ -->
<?php
// Pre-fetch unique destinations — split by comma AND pipe, clean junk
$dest_posts = get_posts( [
    'post_type'      => 'package',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
] );
$all_dests = [];
foreach ( $dest_posts as $pid ) {
    $raw = get_post_meta( $pid, '_package_destinations', true );
    if ( $raw ) {
        // Split by comma or pipe
        $pieces = preg_split( '/[,|]+/', $raw );
        foreach ( $pieces as $d ) {
            $d = trim( $d );
            // Filter: non-empty, not purely numeric, at least 2 chars
            if ( $d && ! ctype_digit( $d ) && mb_strlen( $d ) >= 2 ) {
                $all_dests[ $d ] = $d;
            }
        }
    }
}
ksort( $all_dests );

// Pre-fetch unique countries
$all_countries = [];
foreach ( $dest_posts as $pid ) {
    $c = get_post_meta( $pid, '_pkg_country', true );
    if ( $c ) $all_countries[ $c ] = $c;
}
ksort( $all_countries );

// Sub-region options
$india_subregions = [ 'North India', 'South India', 'East India', 'West India', 'Northeast India', 'Himalayas' ];
$intl_subregions  = [ 'Southeast Asia', 'East Asia', 'Middle East', 'Europe', 'Americas', 'Africa', 'Oceania' ];

// Duration + Budget label maps (used in chips)
$durations = [
    '3-5'  => '3–5 Days',
    '6-8'  => '6–8 Days',
    '9-12' => '9–12 Days',
    '13+'  => '13+ Days',
];
$budgets = [
    'under-15000'  => 'Under ₹15,000',
    '15000-30000'  => '₹15,000 – ₹30,000',
    '30000-60000'  => '₹30,000 – ₹60,000',
    'above-60000'  => '₹60,000+',
];
$sorts = [
    'latest'        => 'Sort By: Latest',
    'price-asc'     => 'Price: Low to High',
    'price-desc'    => 'Price: High to Low',
    'duration-asc'  => 'Duration: Short to Long',
    'duration-desc' => 'Duration: Long to Short',
    'popular'       => 'Most Popular',
];
?>
<div class="filter-bar" id="filter-bar">
    <form class="filter-bar__form" id="filter-form" method="GET"
          action="<?php echo esc_url( get_post_type_archive_link( 'package' ) ); ?>">

        <!-- ROW 1: Search -->
        <div class="filter-bar__row filter-bar__row--search">
            <div class="filter-search-wrap">
                <svg class="filter-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="sq" id="filter-search" class="filter-search-input"
                       value="<?php echo esc_attr( $f_sq ); ?>"
                       placeholder="<?php esc_attr_e( 'Search packages by name, destination...', 'travzo' ); ?>"
                       aria-label="<?php esc_attr_e( 'Search packages', 'travzo' ); ?>">
            </div>
        </div>

        <!-- ROW 2: Filter dropdowns (CSS grid) -->
        <div class="filter-bar__row filter-bar__row--filters">

            <!-- Package Type -->
            <div class="filter-select-wrap">
                <select id="filter-type" name="type" class="filter-select" aria-label="<?php esc_attr_e( 'Filter by package type', 'travzo' ); ?>">
                    <option value=""><?php esc_html_e( 'All Types', 'travzo' ); ?></option>
                    <?php
                    $types = [
                        'Group Tour'          => 'Group Tours',
                        'Honeymoon'           => 'Honeymoon',
                        'Solo Trip'           => 'Solo Trips',
                        'Devotional'          => 'Devotional',
                        'Destination Wedding' => 'Destination Wedding',
                        'International'       => 'International',
                    ];
                    foreach ( $types as $val => $label ) {
                        printf( '<option value="%s" %s>%s</option>', esc_attr( $val ), selected( $f_type, $val, false ), esc_html( $label ) );
                    }
                    ?>
                </select>
                <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </div>

            <!-- Region -->
            <div class="filter-select-wrap">
                <select id="filter-region" name="region" class="filter-select" aria-label="<?php esc_attr_e( 'Filter by region', 'travzo' ); ?>">
                    <option value=""><?php esc_html_e( 'All Regions', 'travzo' ); ?></option>
                    <option value="domestic"<?php selected( $f_region, 'domestic' ); ?>><?php esc_html_e( 'Domestic (India)', 'travzo' ); ?></option>
                    <option value="international"<?php selected( $f_region, 'international' ); ?>><?php esc_html_e( 'International', 'travzo' ); ?></option>
                </select>
                <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </div>

            <!-- Country (searchable) -->
            <div class="filter-searchable" data-name="country" data-placeholder="<?php esc_attr_e( 'All Countries', 'travzo' ); ?>" data-selected="<?php echo esc_attr( $f_country ); ?>">
                <input type="hidden" name="country" value="<?php echo esc_attr( $f_country ); ?>">
                <?php
                $country_options = [ '' => 'All Countries' ];
                foreach ( $all_countries as $c ) { $country_options[ $c ] = $c; }
                ?>
                <script type="application/json" class="filter-searchable-data"><?php echo wp_json_encode( $country_options ); ?></script>
            </div>

            <!-- Sub-region -->
            <div class="filter-select-wrap">
                <select id="filter-subregion" name="subregion" class="filter-select" aria-label="<?php esc_attr_e( 'Filter by sub-region', 'travzo' ); ?>">
                    <option value=""><?php esc_html_e( 'All Sub-regions', 'travzo' ); ?></option>
                    <optgroup label="India">
                        <?php foreach ( $india_subregions as $sr ) : ?>
                            <option value="<?php echo esc_attr( $sr ); ?>"<?php selected( $f_subregion, $sr ); ?>><?php echo esc_html( $sr ); ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="International">
                        <?php foreach ( $intl_subregions as $sr ) : ?>
                            <option value="<?php echo esc_attr( $sr ); ?>"<?php selected( $f_subregion, $sr ); ?>><?php echo esc_html( $sr ); ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
                <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </div>

            <!-- Destination (searchable) -->
            <div class="filter-searchable" data-name="destination" data-placeholder="<?php esc_attr_e( 'All Destinations', 'travzo' ); ?>" data-selected="<?php echo esc_attr( $f_destination ); ?>">
                <input type="hidden" name="destination" value="<?php echo esc_attr( $f_destination ); ?>">
                <?php
                $dest_options = [ '' => 'All Destinations' ];
                foreach ( $all_dests as $d ) { $dest_options[ $d ] = $d; }
                ?>
                <script type="application/json" class="filter-searchable-data"><?php echo wp_json_encode( $dest_options ); ?></script>
            </div>

            <!-- Duration -->
            <div class="filter-select-wrap">
                <select id="filter-duration" name="duration" class="filter-select" aria-label="<?php esc_attr_e( 'Filter by duration', 'travzo' ); ?>">
                    <option value=""><?php esc_html_e( 'Any Duration', 'travzo' ); ?></option>
                    <?php
                    foreach ( $durations as $val => $label ) {
                        printf( '<option value="%s" %s>%s</option>', esc_attr( $val ), selected( $f_duration, $val, false ), esc_html( $label ) );
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
                    foreach ( $budgets as $val => $label ) {
                        printf( '<option value="%s" %s>%s</option>', esc_attr( $val ), selected( $f_budget, $val, false ), esc_html( $label ) );
                    }
                    ?>
                </select>
                <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </div>

            <!-- Hidden submit for no-JS fallback -->
            <button type="submit" class="filter-bar__submit-btn" aria-label="<?php esc_attr_e( 'Apply filters', 'travzo' ); ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
        </div>

        <!-- ROW 3: Active filter chips -->
        <?php if ( $has_active_filters ) : ?>
        <div class="filter-bar__row filter-bar__row--chips" id="filter-chips">
            <?php
            $chip_data = [
                'sq'          => $f_sq          ? 'Search: ' . $f_sq         : '',
                'type'        => $f_type        ? $f_type                    : '',
                'region'      => $f_region      ? ucfirst( $f_region )       : '',
                'country'     => $f_country     ? $f_country                 : '',
                'subregion'   => $f_subregion   ? $f_subregion               : '',
                'destination' => $f_destination ? $f_destination             : '',
                'duration'    => $f_duration    ? ( $durations[ $f_duration ] ?? $f_duration ) : '',
                'budget'      => $f_budget      ? ( $budgets[ $f_budget ] ?? $f_budget )       : '',
            ];
            foreach ( $chip_data as $param => $label ) :
                if ( ! $label ) continue;
                $remove_params = $_GET;
                unset( $remove_params[ $param ] );
                unset( $remove_params['paged'] );
                $remove_url = add_query_arg( $remove_params, get_post_type_archive_link( 'package' ) );
            ?>
                <a href="<?php echo esc_url( $remove_url ); ?>" class="filter-chip" aria-label="<?php printf( esc_attr__( 'Remove filter: %s', 'travzo' ), $label ); ?>">
                    <?php echo esc_html( $label ); ?>
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </a>
            <?php endforeach; ?>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'package' ) ); ?>" class="filter-chip filter-chip--clear-all">
                <?php esc_html_e( 'Clear All', 'travzo' ); ?>
            </a>
        </div>
        <?php endif; ?>

    </form>
</div><!-- /.filter-bar -->


<!-- ════════════════════════════════════════════════════════════
     SECTION 3 – PACKAGES GRID
════════════════════════════════════════════════════════════ -->
<section class="packages-grid-section">
    <div class="packages-grid-inner">

        <!-- Result count + Sort -->
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
            <div class="packages-result-bar__right">
                <?php if ( $has_active_filters ) : ?>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'package' ) ); ?>" class="filter-clear-btn">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        <?php esc_html_e( 'Clear Filters', 'travzo' ); ?>
                    </a>
                <?php endif; ?>
                <div class="filter-select-wrap filter-select-wrap--sort">
                    <select id="filter-sort" name="sort" form="filter-form" class="filter-select" aria-label="<?php esc_attr_e( 'Sort packages', 'travzo' ); ?>">
                        <?php
                        foreach ( $sorts as $val => $label ) {
                            printf( '<option value="%s" %s>%s</option>', esc_attr( $val ), selected( $f_sort, $val, false ), esc_html( $label ) );
                        }
                        ?>
                    </select>
                    <svg class="filter-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </div>
        </div>

        <?php if ( $packages->have_posts() ) : ?>

            <div class="packages-grid" id="packages-grid">
                <?php while ( $packages->have_posts() ) : $packages->the_post();
                    $pkg_type    = get_post_meta( get_the_ID(), '_package_type',         true );
                    $destination = get_post_meta( get_the_ID(), '_package_destinations', true );
                    $duration    = get_post_meta( get_the_ID(), '_package_duration',     true );
                    $price       = get_post_meta( get_the_ID(), '_package_price',        true );
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
                        <?php if ( $price ) :
                            $price_display = is_numeric( $price ) ? '₹' . number_format( (int) $price ) : $price;
                        ?>
                        <div class="package-card__price">
                            <span class="package-card__price-from"><?php esc_html_e( 'Starting from', 'travzo' ); ?></span>
                            <span class="package-card__price-amount">
                                <?php echo esc_html( $price_display ); ?>
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
            <?php
            $strip_phone     = travzo_get( 'travzo_phone', '' );
            $strip_phone_url = $strip_phone ? 'tel:' . preg_replace( '/[^+0-9]/', '', $strip_phone ) : home_url( '/contact' );
            ?>
            <a href="<?php echo esc_url( $strip_phone_url ); ?>" class="btn btn--navy">
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
