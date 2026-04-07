<?php
/**
 * Single Package Template
 * Travzo Holidays WordPress Theme
 */

get_header();

// ── Star SVG helper ────────────────────────────────────────────────────────────
$star_svg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true">'
          . '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>'
          . '</svg>';
?>

<main id="main-content">

<?php while ( have_posts() ) : the_post();

// ── Native post meta reads ───────────────────────────────────────────────────
$pkg_id         = get_the_ID();
$pkg_type       = get_post_meta( $pkg_id, '_package_type',         true );
$pkg_price      = get_post_meta( $pkg_id, '_package_price',        true );
$pkg_duration   = get_post_meta( $pkg_id, '_package_duration',     true );
$pkg_dest       = get_post_meta( $pkg_id, '_package_destinations', true );
$pkg_group_size  = get_post_meta( $pkg_id, '_package_group_size',    true );
$pkg_inclusions  = get_post_meta( $pkg_id, '_package_inclusions',    true );
$pkg_exclusions  = get_post_meta( $pkg_id, '_package_exclusions',    true );
$pkg_download    = get_post_meta( $pkg_id, '_package_download_url',  true );

// Photo gallery: from _pkg_gallery meta (array of attachment IDs)
$pkg_gallery_raw = get_post_meta( $pkg_id, '_pkg_gallery', true );
if ( ! is_array( $pkg_gallery_raw ) ) {
    $pkg_gallery_raw = $pkg_gallery_raw ? array_filter( array_map( 'absint', explode( ',', $pkg_gallery_raw ) ) ) : [];
}
$pkg_gallery = array_filter( $pkg_gallery_raw );

// Highlights: textarea (one per line) → fallback to v2 JSON → fallback to old textarea
$pkg_highlights = get_post_meta( $pkg_id, '_pkg_highlights', true );
if ( ! $pkg_highlights ) {
    $pkg_highlights_v2 = get_post_meta( $pkg_id, '_pkg_highlights_v2', true );
    if ( is_array( $pkg_highlights_v2 ) && ! empty( $pkg_highlights_v2 ) ) {
        $pkg_highlights = implode( "\n", $pkg_highlights_v2 );
    } else {
        $pkg_highlights = get_post_meta( $pkg_id, '_package_highlights', true );
    }
}

// Itinerary: new v2 JSON array → fallback to old pipe-separated
$pkg_itinerary_v2 = get_post_meta( $pkg_id, '_pkg_itinerary_v2', true );
if ( is_array( $pkg_itinerary_v2 ) && ! empty( $pkg_itinerary_v2 ) ) {
    $pkg_itinerary = $pkg_itinerary_v2; // Array of {day_title, description}
} else {
    $pkg_itinerary = travzo_parse_lines( get_post_meta( $pkg_id, '_package_itinerary', true ), 2 );
    // Normalize old format to match new structure
    if ( $pkg_itinerary ) {
        $normalized = [];
        foreach ( $pkg_itinerary as $row ) {
            $normalized[] = [ 'day_title' => $row[0] ?? '', 'description' => $row[1] ?? '' ];
        }
        $pkg_itinerary = $normalized;
    }
}

// Hotels: new v2 JSON array → fallback to old pipe-separated
$pkg_hotels_v2 = get_post_meta( $pkg_id, '_pkg_hotels_v2', true );
if ( is_array( $pkg_hotels_v2 ) && ! empty( $pkg_hotels_v2 ) ) {
    $pkg_hotels = $pkg_hotels_v2; // Array of {name, stars, location, room_type, image}
} else {
    $old_hotels = travzo_parse_lines( get_post_meta( $pkg_id, '_package_hotels', true ), 4 );
    $pkg_hotels = [];
    if ( $old_hotels ) {
        foreach ( $old_hotels as $row ) {
            $pkg_hotels[] = [
                'name'      => $row[0] ?? '',
                'stars'     => $row[1] ?? '3',
                'location'  => $row[2] ?? '',
                'room_type' => $row[3] ?? '',
                'image'     => '',
            ];
        }
    }
}

$pricing = [
    'standard_twin'   => get_post_meta( $pkg_id, '_price_standard_twin',   true ),
    'standard_triple' => get_post_meta( $pkg_id, '_price_standard_triple', true ),
    'standard_single' => get_post_meta( $pkg_id, '_price_standard_single', true ),
    'deluxe_twin'     => get_post_meta( $pkg_id, '_price_deluxe_twin',     true ),
    'deluxe_triple'   => get_post_meta( $pkg_id, '_price_deluxe_triple',   true ),
    'deluxe_single'   => get_post_meta( $pkg_id, '_price_deluxe_single',   true ),
    'premium_twin'    => get_post_meta( $pkg_id, '_price_premium_twin',    true ),
    'premium_triple'  => get_post_meta( $pkg_id, '_price_premium_triple',  true ),
    'premium_single'  => get_post_meta( $pkg_id, '_price_premium_single',  true ),
    'child_bed'       => get_post_meta( $pkg_id, '_price_child_bed',       true ),
    'child_no_bed'    => get_post_meta( $pkg_id, '_price_child_no_bed',    true ),
];

// Pricing meta
$pricing_visible     = get_post_meta( $pkg_id, '_pkg_pricing_visible', true );
if ( $pricing_visible === '' ) $pricing_visible = '1';
$pricing_note        = get_post_meta( $pkg_id, '_pkg_pricing_note', true );
$pricing_recommended = get_post_meta( $pkg_id, '_pkg_pricing_recommended', true );
$has_single_prices   = $pricing['standard_single'] || $pricing['deluxe_single'] || $pricing['premium_single'];

// Important Information meta
$info_visible = get_post_meta( $pkg_id, '_pkg_important_info_visible', true );
if ( $info_visible === '' ) $info_visible = '1';
$info_heading = get_post_meta( $pkg_id, '_pkg_important_info_heading', true ) ?: 'Important Information';
$info_items   = get_post_meta( $pkg_id, '_pkg_important_info', true );

// Type-specific fields
$pkg_country = get_post_meta( $pkg_id, '_pkg_country', true );
$pkg_region  = get_post_meta( $pkg_id, '_pkg_region', true );

// Group Tour
$ts_group_size       = get_post_meta( $pkg_id, '_package_group_size', true );
$ts_departure_cities = get_post_meta( $pkg_id, '_pkg_departure_cities', true );
$ts_tour_manager     = get_post_meta( $pkg_id, '_pkg_tour_manager', true );
$ts_languages        = get_post_meta( $pkg_id, '_pkg_languages', true );

// Honeymoon
$ts_couple_inclusions  = get_post_meta( $pkg_id, '_pkg_couple_inclusions', true );
$ts_romantic_activities = get_post_meta( $pkg_id, '_pkg_romantic_activities', true );
$ts_privacy_level      = get_post_meta( $pkg_id, '_pkg_privacy_level', true );
$ts_suite_type         = get_post_meta( $pkg_id, '_pkg_suite_type', true );

// Solo Trip
$ts_age_group       = get_post_meta( $pkg_id, '_pkg_age_group', true );
$ts_safety_rating   = get_post_meta( $pkg_id, '_pkg_safety_rating', true );
$ts_female_friendly = get_post_meta( $pkg_id, '_pkg_female_friendly', true );
$ts_mixer_activities = get_post_meta( $pkg_id, '_pkg_mixer_activities', true );
$ts_single_room     = get_post_meta( $pkg_id, '_pkg_single_room', true );

// Devotional
$ts_religion   = get_post_meta( $pkg_id, '_pkg_religion', true );
$ts_temples    = get_post_meta( $pkg_id, '_pkg_temples', true );
$ts_pujas      = get_post_meta( $pkg_id, '_pkg_pujas', true );
$ts_dress_code = get_post_meta( $pkg_id, '_pkg_dress_code', true );
$ts_vegetarian = get_post_meta( $pkg_id, '_pkg_vegetarian', true );
$ts_priest     = get_post_meta( $pkg_id, '_pkg_priest', true );

// Info pill fallbacks
$pkg_duration   = $pkg_duration   ?: '5 Nights / 6 Days';
$pkg_dest       = $pkg_dest       ?: 'Multiple Destinations';
// Group size: only display if set (it's Group Tour specific now)
$pkg_price_raw  = $pkg_price      ?: '15000';
$pkg_price      = is_numeric( $pkg_price_raw ) ? number_format( (int) $pkg_price_raw ) : $pkg_price_raw;

// Hero background
$hero_img_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';

// Parse newline-delimited text into array
function travzo_split_list( $text ) {
    if ( ! $text ) return [];
    return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $text ) ) ) );
}

$inclusions_list = travzo_split_list( $pkg_inclusions );
if ( ! $inclusions_list ) {
    $inclusions_list = [
        __( 'Return airfare (economy class)', 'travzo' ),
        __( 'Hotel accommodation as per package', 'travzo' ),
        __( 'Daily breakfast included', 'travzo' ),
        __( 'Airport & railway station transfers', 'travzo' ),
        __( 'Sightseeing as per itinerary by AC vehicle', 'travzo' ),
        __( 'Travel insurance coverage', 'travzo' ),
        __( 'Dedicated tour manager throughout', 'travzo' ),
    ];
}

$exclusions_list = travzo_split_list( $pkg_exclusions );
if ( ! $exclusions_list ) {
    $exclusions_list = [
        __( 'Visa fees and documentation charges', 'travzo' ),
        __( 'Personal expenses and shopping', 'travzo' ),
        __( 'Optional tours and activities', 'travzo' ),
        __( 'Tips and gratuities', 'travzo' ),
        __( 'Lunch & dinner unless specified', 'travzo' ),
    ];
}

$highlights_list = travzo_split_list( $pkg_highlights );
if ( ! $highlights_list ) {
    $highlights_list = [
        __( 'Expertly curated itinerary by local specialists', 'travzo' ),
        __( 'Hand-picked well-rated accommodations throughout', 'travzo' ),
        __( 'Private & comfortable transportation', 'travzo' ),
        __( 'All entrance fees and permits covered', 'travzo' ),
        __( 'Flexible cancellation options available', 'travzo' ),
        __( '24/7 on-trip assistance from Travzo team', 'travzo' ),
    ];
}

$has_pricing = (bool) array_filter( $pricing );
?>


<!-- ════════════════════════════════════════════════════════════
     SECTION 1 – PACKAGE HERO
════════════════════════════════════════════════════════════ -->
<section class="package-hero"<?php if ( $hero_img_url ) : ?> style="background-image: url('<?php echo esc_url( $hero_img_url ); ?>');"<?php endif; ?>>
    <div class="package-hero__overlay"></div>
    <div class="package-hero__content">

        <?php if ( $pkg_type ) : ?>
            <span class="package-hero__badge"><?php echo esc_html( $pkg_type ); ?></span>
        <?php endif; ?>

        <h1 class="package-hero__title"><?php the_title(); ?></h1>

        <div class="package-hero__pills" role="list">

            <span class="package-hero__pill" role="listitem">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?php echo esc_html( $pkg_duration ); ?>
            </span>

            <span class="package-hero__pill" role="listitem">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <?php echo esc_html( $pkg_dest ); ?>
            </span>

            <?php if ( $pkg_group_size ) : ?>
            <span class="package-hero__pill" role="listitem">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                <?php echo esc_html( $pkg_group_size ); ?>
            </span>
            <?php endif; ?>

            <span class="package-hero__pill" role="listitem">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                <?php printf( esc_html__( 'From &#8377;%s per person', 'travzo' ), esc_html( $pkg_price ) ); ?>
            </span>

        </div>
    </div>
</section>


<!-- ════════════════════════════════════════════════════════════
     SECTION 2 – MAIN CONTENT + STICKY SIDEBAR
════════════════════════════════════════════════════════════ -->
<div class="package-layout">
    <div class="package-layout__inner">

        <!-- ── LEFT: Main Content with Tabs ───────────── -->
        <div class="package-content">

            <!-- Tab Navigation -->
            <div class="package-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Package details', 'travzo' ); ?>">
                <button class="pkg-tab active" data-target="panel-overview"    role="tab" aria-selected="true"  aria-controls="panel-overview"><?php   esc_html_e( 'Overview',   'travzo' ); ?></button>
                <button class="pkg-tab"        data-target="panel-itinerary"   role="tab" aria-selected="false" aria-controls="panel-itinerary"><?php  esc_html_e( 'Itinerary',  'travzo' ); ?></button>
                <button class="pkg-tab"        data-target="panel-inclusions"  role="tab" aria-selected="false" aria-controls="panel-inclusions"><?php esc_html_e( 'Inclusions', 'travzo' ); ?></button>
                <button class="pkg-tab"        data-target="panel-hotels"      role="tab" aria-selected="false" aria-controls="panel-hotels"><?php      esc_html_e( 'Hotels',     'travzo' ); ?></button>
            </div>

            <!-- ══ Overview ════════════════════════════════════ -->
            <div class="tab-panel active" id="panel-overview" role="tabpanel">

                <?php
                $overview_content = get_the_content();
                if ( trim( $overview_content ) ) :
                ?>
                <div class="pkg-description entry-content">
                    <?php the_content(); ?>
                </div>
                <?php endif; ?>

                <h3 class="pkg-section-heading"><?php esc_html_e( 'Package Highlights', 'travzo' ); ?></h3>
                <ul class="pkg-highlights-list">
                    <?php foreach ( $highlights_list as $hl ) : ?>
                    <li>
                        <svg class="pkg-check-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        <?php echo esc_html( $hl ); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <?php
                // ── Type-Specific Details Card ──
                $type_details = [];
                $type_heading = '';
                $type_badges  = [];
                $type_lists   = [];

                switch ( $pkg_type ) {
                    case 'Group Tour':
                        $type_heading = __( 'Group Tour Details', 'travzo' );
                        if ( $ts_group_size )       $type_details[ __( 'Group Size', 'travzo' ) ]       = $ts_group_size;
                        if ( $ts_departure_cities ) $type_details[ __( 'Departure Cities', 'travzo' ) ] = $ts_departure_cities;
                        if ( $ts_languages )        $type_details[ __( 'Languages', 'travzo' ) ]        = $ts_languages;
                        if ( $ts_tour_manager === '1' ) $type_badges[] = __( 'Tour Manager Included', 'travzo' );
                        break;

                    case 'Honeymoon':
                        $type_heading = __( 'Honeymoon Details', 'travzo' );
                        if ( $ts_privacy_level ) $type_details[ __( 'Privacy Level', 'travzo' ) ] = $ts_privacy_level;
                        if ( $ts_suite_type )    $type_details[ __( 'Suite Type', 'travzo' ) ]    = $ts_suite_type;
                        if ( $ts_couple_inclusions )  $type_lists[ __( 'Couple Inclusions', 'travzo' ) ]  = travzo_split_list( $ts_couple_inclusions );
                        if ( $ts_romantic_activities ) $type_lists[ __( 'Romantic Activities', 'travzo' ) ] = travzo_split_list( $ts_romantic_activities );
                        break;

                    case 'Solo Trip':
                        $type_heading = __( 'Solo Trip Details', 'travzo' );
                        if ( $ts_age_group )     $type_details[ __( 'Target Age Group', 'travzo' ) ] = $ts_age_group;
                        if ( $ts_safety_rating ) $type_details[ __( 'Safety Rating', 'travzo' ) ]    = $ts_safety_rating;
                        if ( $ts_female_friendly === '1' ) $type_badges[] = __( 'Female-Friendly', 'travzo' );
                        if ( $ts_single_room === '1' )     $type_badges[] = __( 'Single Room Guaranteed', 'travzo' );
                        if ( $ts_mixer_activities ) $type_lists[ __( 'Social Mixer Activities', 'travzo' ) ] = travzo_split_list( $ts_mixer_activities );
                        break;

                    case 'Devotional':
                        $type_heading = __( 'Devotional Tour Details', 'travzo' );
                        if ( $ts_religion )   $type_details[ __( 'Religion / Tradition', 'travzo' ) ] = $ts_religion;
                        if ( $ts_dress_code ) $type_details[ __( 'Dress Code', 'travzo' ) ]           = $ts_dress_code;
                        if ( $ts_priest )     $type_details[ __( 'Priest Coordination', 'travzo' ) ]  = $ts_priest;
                        if ( $ts_vegetarian === '1' ) $type_badges[] = __( 'Vegetarian Meals Only', 'travzo' );
                        if ( $ts_temples ) $type_lists[ __( 'Temples / Holy Sites', 'travzo' ) ] = travzo_split_list( $ts_temples );
                        if ( $ts_pujas )   $type_lists[ __( 'Special Pujas / Rituals', 'travzo' ) ] = travzo_split_list( $ts_pujas );
                        break;
                }

                if ( $type_heading && ( $type_details || $type_badges || $type_lists ) ) :
                ?>
                <h3 class="pkg-section-heading"><?php echo esc_html( $type_heading ); ?></h3>
                <div class="pkg-type-card">

                    <?php if ( $type_details ) : ?>
                    <div class="pkg-type-grid">
                        <?php foreach ( $type_details as $label => $value ) : ?>
                        <div class="pkg-type-field">
                            <span class="pkg-type-field__label"><?php echo esc_html( $label ); ?></span>
                            <span class="pkg-type-field__value"><?php echo esc_html( $value ); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ( $type_badges ) : ?>
                    <div class="pkg-type-badges">
                        <?php foreach ( $type_badges as $badge ) : ?>
                        <span class="pkg-type-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                            <?php echo esc_html( $badge ); ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php foreach ( $type_lists as $list_label => $list_items ) :
                        if ( empty( $list_items ) ) continue;
                    ?>
                    <div class="pkg-type-list-section">
                        <h4 class="pkg-type-list-heading"><?php echo esc_html( $list_label ); ?></h4>
                        <ul class="pkg-type-list">
                            <?php foreach ( $list_items as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>

                </div><!-- /.pkg-type-card -->
                <?php endif; ?>

                <?php if ( ! empty( $pkg_gallery ) ) : ?>
                <h3 class="pkg-section-heading"><?php esc_html_e( 'Photo Gallery', 'travzo' ); ?></h3>
                <div class="pkg-gallery" role="list">
                    <?php foreach ( $pkg_gallery as $img_id ) :
                        $img_url = wp_get_attachment_image_url( $img_id, 'large' );
                        $img_med = wp_get_attachment_image_url( $img_id, 'medium' ) ?: $img_url;
                        $img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
                        if ( ! $img_url ) continue;
                    ?>
                    <a class="pkg-gallery__item" href="<?php echo esc_url( $img_url ); ?>" role="listitem"
                       data-lightbox="gallery"
                       aria-label="<?php echo esc_attr( $img_alt ?: get_the_title() ); ?>">
                        <img src="<?php echo esc_url( $img_med ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" loading="lazy">
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div><!-- /#panel-overview -->


            <!-- ══ Itinerary ════════════════════════════════════ -->
            <div class="tab-panel" id="panel-itinerary" role="tabpanel" hidden>

                <h3 class="pkg-section-heading"><?php esc_html_e( 'Day by Day Itinerary', 'travzo' ); ?></h3>

                <?php if ( $pkg_itinerary ) :
                    foreach ( $pkg_itinerary as $day ) :
                        $day_label = $day['day_title'] ?? '';
                        $day_desc  = $day['description'] ?? '';
                ?>
                <div class="itinerary-day">
                    <span class="day-badge"><?php echo esc_html( $day_label ); ?></span>
                    <p class="itinerary-day__desc"><?php echo nl2br( esc_html( $day_desc ) ); ?></p>
                </div>
                <?php endforeach;
                else : ?>
                <div class="itinerary-day">
                    <span class="day-badge"><?php esc_html_e( 'Day 1', 'travzo' ); ?></span>
                    <h4 class="itinerary-day__title"><?php esc_html_e( 'Arrival & Welcome', 'travzo' ); ?></h4>
                    <p class="itinerary-day__desc"><?php esc_html_e( 'Arrive at the destination and be greeted by our Travzo representative. Transfer to hotel, check-in, freshen up. Evening free for leisure. Welcome dinner at a popular local restaurant.', 'travzo' ); ?></p>
                </div>
                <div class="itinerary-day">
                    <span class="day-badge"><?php esc_html_e( 'Day 2', 'travzo' ); ?></span>
                    <h4 class="itinerary-day__title"><?php esc_html_e( 'Full Day Sightseeing', 'travzo' ); ?></h4>
                    <p class="itinerary-day__desc"><?php esc_html_e( 'After breakfast, embark on a guided full-day tour covering all major attractions. Visit heritage sites, scenic viewpoints, and local markets. Lunch at a recommended restaurant. Return to hotel by evening.', 'travzo' ); ?></p>
                </div>
                <div class="itinerary-day">
                    <span class="day-badge"><?php esc_html_e( 'Day 3', 'travzo' ); ?></span>
                    <h4 class="itinerary-day__title"><?php esc_html_e( 'Adventure & Nature', 'travzo' ); ?></h4>
                    <p class="itinerary-day__desc"><?php esc_html_e( 'Morning excursion to nearby nature reserve or viewpoint. Optional adventure activities available. Afternoon at leisure for shopping. Special cultural dinner experience in the evening.', 'travzo' ); ?></p>
                </div>
                <div class="itinerary-day">
                    <span class="day-badge"><?php esc_html_e( 'Day 4', 'travzo' ); ?></span>
                    <h4 class="itinerary-day__title"><?php esc_html_e( 'Cultural Immersion', 'travzo' ); ?></h4>
                    <p class="itinerary-day__desc"><?php esc_html_e( 'Discover the region\'s rich culture and traditions. Visit artisan workshops, local temples, and spice markets. Enjoy a cooking demonstration. Evening river cruise or sunset viewpoint visit.', 'travzo' ); ?></p>
                </div>
                <div class="itinerary-day">
                    <span class="day-badge"><?php esc_html_e( 'Day 5', 'travzo' ); ?></span>
                    <h4 class="itinerary-day__title"><?php esc_html_e( 'Leisure & Departure', 'travzo' ); ?></h4>
                    <p class="itinerary-day__desc"><?php esc_html_e( 'Morning at leisure for last-minute shopping. Check-out and transfer to the airport for onward journey. Tour manager assists with departure. End of a memorable journey with Travzo Holidays.', 'travzo' ); ?></p>
                </div>
                <?php endif; ?>

            </div><!-- /#panel-itinerary -->


            <!-- ══ Inclusions ═══════════════════════════════════ -->
            <div class="tab-panel" id="panel-inclusions" role="tabpanel" hidden>

                <div class="inclusions-grid">

                    <div class="inclusions">
                        <h3 class="inclusions__heading inclusions__heading--green">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <?php esc_html_e( "What's Included", 'travzo' ); ?>
                        </h3>
                        <ul class="inclusion-list">
                            <?php foreach ( $inclusions_list as $item ) : ?>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                                <?php echo esc_html( $item ); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="exclusions">
                        <h3 class="inclusions__heading inclusions__heading--red">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <?php esc_html_e( "What's Not Included", 'travzo' ); ?>
                        </h3>
                        <ul class="inclusion-list">
                            <?php foreach ( $exclusions_list as $item ) : ?>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                <?php echo esc_html( $item ); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div><!-- /#panel-inclusions -->


            <!-- ══ Hotels ═══════════════════════════════════════ -->
            <div class="tab-panel" id="panel-hotels" role="tabpanel" hidden>

                <h3 class="pkg-section-heading"><?php esc_html_e( 'Your Accommodations', 'travzo' ); ?></h3>

                <?php if ( $pkg_hotels ) :
                    foreach ( $pkg_hotels as $hotel ) :
                        $h_name     = $hotel['name'] ?? '';
                        $h_stars    = (int) ( $hotel['stars'] ?? 3 );
                        $h_location = $hotel['location'] ?? '';
                        $h_room     = $hotel['room_type'] ?? '';
                        $h_img      = $hotel['image'] ?? '';
                ?>
                <div class="hotel-card">
                    <div class="hotel-card__image-wrap<?php echo $h_img ? '' : ' hotel-card__image-wrap--placeholder'; ?>">
                        <?php if ( $h_img ) : ?>
                            <img src="<?php echo esc_url( $h_img ); ?>" alt="<?php echo esc_attr( $h_name ); ?>" loading="lazy">
                        <?php else : ?>
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        <?php endif; ?>
                    </div>
                    <div class="hotel-card__info">
                        <p class="hotel-card__name"><?php echo esc_html( $h_name ); ?></p>
                        <div class="hotel-card__stars" aria-label="<?php echo esc_attr( $h_stars . ' star hotel' ); ?>">
                            <?php for ( $s = 0; $s < $h_stars; $s++ ) : ?>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <?php endfor; ?>
                        </div>
                        <?php if ( $h_location ) : ?>
                        <p class="hotel-card__location">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php echo esc_html( $h_location ); ?>
                        </p>
                        <?php endif; ?>
                        <?php if ( $h_room ) : ?>
                        <p class="hotel-card__room-type"><?php echo esc_html( $h_room ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach;
                else : // Fallback hotel cards ?>
                <div class="hotel-card">
                    <div class="hotel-card__image-wrap hotel-card__image-wrap--placeholder">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <div class="hotel-card__info">
                        <p class="hotel-card__name"><?php esc_html_e( 'The Grand Heritage Hotel', 'travzo' ); ?></p>
                        <div class="hotel-card__stars" aria-label="4 star hotel">
                            <?php echo str_repeat( '<svg width="13" height="13" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>', 4 ); ?>
                        </div>
                        <p class="hotel-card__location">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php esc_html_e( 'City Centre', 'travzo' ); ?>
                        </p>
                        <p class="hotel-card__room-type"><?php esc_html_e( 'Superior Deluxe Room', 'travzo' ); ?></p>
                    </div>
                </div>
                <div class="hotel-card">
                    <div class="hotel-card__image-wrap hotel-card__image-wrap--placeholder">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <div class="hotel-card__info">
                        <p class="hotel-card__name"><?php esc_html_e( 'Boutique Resort &amp; Spa', 'travzo' ); ?></p>
                        <div class="hotel-card__stars" aria-label="5 star hotel">
                            <?php echo str_repeat( '<svg width="13" height="13" viewBox="0 0 24 24" fill="#C9A227" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>', 5 ); ?>
                        </div>
                        <p class="hotel-card__location">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php esc_html_e( 'Beachfront Location', 'travzo' ); ?>
                        </p>
                        <p class="hotel-card__room-type"><?php esc_html_e( 'Premium Pool View Room', 'travzo' ); ?></p>
                    </div>
                </div>
                <?php endif; ?>

            </div><!-- /#panel-hotels -->

        </div><!-- /.package-content -->


        <!-- ── RIGHT: Sticky Sidebar ──────────────────── -->
        <aside class="package-sidebar" aria-label="<?php esc_attr_e( 'Booking and enquiry', 'travzo' ); ?>">
            <div class="sidebar-card">

                <!-- Top: Price display -->
                <div class="sidebar-card__top">
                    <p class="sidebar-card__label"><?php esc_html_e( 'Book This Package', 'travzo' ); ?></p>
                    <div class="sidebar-card__price-row">
                        <span class="sidebar-card__price">&#8377;<?php echo esc_html( $pkg_price ); ?></span>
                        <span class="sidebar-card__per-person"><?php esc_html_e( '/per person', 'travzo' ); ?></span>
                    </div>
                    <p class="sidebar-card__price-note"><?php esc_html_e( 'Prices may vary based on dates and group size', 'travzo' ); ?></p>
                </div>

                <!-- Bottom: Quick Enquiry form -->
                <div class="sidebar-card__body">

                    <h4 class="sidebar-card__form-heading"><?php esc_html_e( 'Quick Enquiry', 'travzo' ); ?></h4>

                    <?php travzo_render_form( travzo_default_package_form( $pkg_id ) ); ?>

                    <?php if ( $pkg_download ) : ?>
                    <!-- Download Itinerary -->
                    <a href="<?php echo esc_url( $pkg_download ); ?>" class="btn-download-pdf" target="_blank" rel="noopener noreferrer">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        <?php esc_html_e( 'Download Itinerary PDF', 'travzo' ); ?>
                    </a>
                    <?php endif; ?>

                    <!-- Trust badges -->
                    <div class="sidebar-trust-badges">
                        <div class="trust-badge">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            <span><?php esc_html_e( 'Secure', 'travzo' ); ?></span>
                        </div>
                        <div class="trust-badge">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            <span><?php esc_html_e( 'Best Price', 'travzo' ); ?></span>
                        </div>
                        <div class="trust-badge">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 011 2.18 2 2 0 013 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/></svg>
                            <span><?php esc_html_e( '24/7 Support', 'travzo' ); ?></span>
                        </div>
                    </div>

                </div><!-- /.sidebar-card__body -->
            </div><!-- /.sidebar-card -->
        </aside><!-- /.package-sidebar -->

    </div><!-- /.package-layout__inner -->
</div><!-- /.package-layout -->


<!-- ════════════════════════════════════════════════════════════
     SECTION 3 – PRICING TABLE
════════════════════════════════════════════════════════════ -->
<?php
// Price formatter: ₹ prefix + number_format
function travzo_fmt_price( $val ) {
    if ( ! $val && $val !== '0' && $val !== 0 ) return '<span class="pricing-na">—</span>';
    $val = trim( $val );
    if ( is_numeric( $val ) ) {
        return '₹' . esc_html( number_format( (int) $val ) );
    }
    return esc_html( strpos( $val, '₹' ) === false ? '₹' . $val : $val );
}
?>
<?php if ( $pricing_visible === '1' ) : ?>
<section class="pricing-section">
    <div class="pricing-section__inner">

        <h2 class="section-heading pkg-centered-heading"><?php esc_html_e( 'Package Pricing', 'travzo' ); ?></h2>
        <p class="pkg-centered-subtext"><?php echo esc_html( $pricing_note ?: __( 'All prices are per person. Contact us for group discounts.', 'travzo' ) ); ?></p>

        <?php if ( $has_pricing ) : ?>
        <div class="pricing-table-wrap">
            <table class="pricing-table" aria-label="<?php esc_attr_e( 'Package pricing table', 'travzo' ); ?>">
                <thead>
                    <tr>
                        <th scope="col"><?php esc_html_e( 'Room Type', 'travzo' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Twin Sharing', 'travzo' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Triple Sharing', 'travzo' ); ?></th>
                        <?php if ( $has_single_prices ) : ?>
                        <th scope="col"><?php esc_html_e( 'Single Room', 'travzo' ); ?></th>
                        <?php endif; ?>
                        <th scope="col"><?php esc_html_e( 'Child with Bed', 'travzo' ); ?></th>
                        <th scope="col"><?php esc_html_e( 'Child without Bed', 'travzo' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tiers = [
                        'Standard' => [ 'standard_twin', 'standard_triple', 'standard_single' ],
                        'Deluxe'   => [ 'deluxe_twin',   'deluxe_triple',   'deluxe_single'   ],
                        'Premium'  => [ 'premium_twin',  'premium_triple',  'premium_single'  ],
                    ];
                    foreach ( $tiers as $tier_name => $keys ) :
                        $is_recommended = ( $pricing_recommended === $tier_name );
                    ?>
                    <tr<?php echo $is_recommended ? ' class="pricing-table__recommended"' : ''; ?>>
                        <th scope="row">
                            <?php echo esc_html( $tier_name . ' Room' ); ?>
                            <?php if ( $is_recommended ) : ?>
                                <span class="recommended-badge"><?php esc_html_e( 'Recommended', 'travzo' ); ?></span>
                            <?php endif; ?>
                        </th>
                        <td><?php echo travzo_fmt_price( $pricing[ $keys[0] ] ); ?></td>
                        <td><?php echo travzo_fmt_price( $pricing[ $keys[1] ] ); ?></td>
                        <?php if ( $has_single_prices ) : ?>
                        <td><?php echo travzo_fmt_price( $pricing[ $keys[2] ] ); ?></td>
                        <?php endif; ?>
                        <td><?php echo travzo_fmt_price( $pricing['child_bed'] ); ?></td>
                        <td><?php echo travzo_fmt_price( $pricing['child_no_bed'] ); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div><!-- /.pricing-table-wrap -->
        <p class="pricing-table__note"><?php esc_html_e( '* Prices are subject to change. GST and other taxes extra.', 'travzo' ); ?></p>
        <?php else : ?>
        <p class="pricing-coming-soon"><?php esc_html_e( 'Pricing details coming soon. Contact us for a personalised quote.', 'travzo' ); ?></p>
        <?php endif; ?>

    </div>
</section>
<?php endif; ?>


<!-- ════════════════════════════════════════════════════════════
     SECTION 4 – TERMS ACCORDION
════════════════════════════════════════════════════════════ -->
<?php
// Build accordion items: use meta if available, else hardcoded defaults
$accordion_items = [];
if ( $info_visible === '1' ) {
    if ( is_array( $info_items ) && ! empty( $info_items ) ) {
        $accordion_items = $info_items;
    } else {
        // Hardcoded fallback
        $accordion_items = [
            [ 'title' => 'Cancellation Policy', 'content' => 'Cancellations 30+ days before departure: 10% cancellation charge. Cancellations 15–30 days before: 25% forfeited. Cancellations 7–14 days before: 50% forfeited. Within 7 days or no-show: 100% forfeited. All cancellation requests must be submitted in writing to hello@travzoholidays.com.' ],
            [ 'title' => 'Payment Terms', 'content' => 'A 25% deposit is required to confirm your booking. The remaining balance is due 21 days before departure. Bookings within 21 days require full payment upfront. We accept bank transfer, UPI, and credit/debit cards (2% processing fee applies).' ],
            [ 'title' => 'Visa Information', 'content' => 'Visa fees are not included unless stated. Our team provides visa assistance and guidance. Approval is subject to the respective embassy\'s discretion. Ensure your passport is valid for at least 6 months from travel date. Apply well in advance. Travzo is not responsible for rejections.' ],
            [ 'title' => 'Things to Carry', 'content' => 'Valid government-issued photo ID. Passport & visa for international travel. Travel insurance documents. Comfortable walking shoes and weather-appropriate clothing. Sunscreen, sunglasses, and personal medications. Power bank and travel adapters. Copies of important documents stored separately.' ],
            [ 'title' => 'Important Notes', 'content' => 'Itinerary is subject to change due to weather or circumstances beyond our control. Hotels may be substituted with equivalent category. All guests are expected to respect local customs and laws. The tour manager\'s decision is final for operational matters. Travel insurance is strongly recommended. Contact our 24/7 helpline in case of emergency.' ],
        ];
    }
}
if ( ! empty( $accordion_items ) ) :
?>
<section class="terms-section">
    <div class="terms-section__inner">

        <h2 class="section-heading pkg-centered-heading"><?php echo esc_html( $info_heading ); ?></h2>

        <div class="pkg-accordion">
            <?php foreach ( $accordion_items as $acc_item ) :
                $acc_title   = $acc_item['title'] ?? '';
                $acc_content = $acc_item['content'] ?? '';
                if ( ! $acc_title && ! $acc_content ) continue;
            ?>
            <div class="accordion-item">
                <button class="accordion-item__trigger" aria-expanded="false">
                    <?php echo esc_html( $acc_title ); ?>
                    <svg class="accordion-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="accordion-item__panel">
                    <div class="accordion-item__body">
                    <?php
                    // Strip leading H3 to avoid duplicate title (accordion header already shows it)
                    $acc_content = preg_replace( '/^\s*<h3[^>]*>.*?<\/h3>\s*/i', '', $acc_content, 1 );
                    echo wp_kses_post( $acc_content );
                    ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div><!-- /.pkg-accordion -->
    </div>
</section>
<?php endif; ?>


<!-- ════════════════════════════════════════════════════════════
     SECTION 5 – SIMILAR PACKAGES
════════════════════════════════════════════════════════════ -->
<?php
$similar_args = [
    'post_type'      => 'package',
    'posts_per_page' => 3,
    'post__not_in'   => [ get_the_ID() ],
    'orderby'        => 'rand',
];
if ( $pkg_type ) {
    $similar_args['meta_query'] = [
        [ 'key' => '_package_type', 'value' => $pkg_type, 'compare' => '=' ],
    ];
}
$similar_packages = new WP_Query( $similar_args );

// Fallback: any 3 packages if not enough of same type
if ( $similar_packages->post_count < 3 ) {
    wp_reset_postdata();
    $similar_packages = new WP_Query( [
        'post_type'      => 'package',
        'posts_per_page' => 3,
        'post__not_in'   => [ get_the_ID() ],
        'orderby'        => 'rand',
    ] );
}
?>
<?php if ( $similar_packages->have_posts() ) : ?>
<section class="similar-packages">
    <div class="similar-packages__inner">

        <h2 class="section-heading"><?php esc_html_e( 'You May Also Like', 'travzo' ); ?></h2>

        <div class="packages-grid similar-packages__grid">
            <?php while ( $similar_packages->have_posts() ) : $similar_packages->the_post();
                $sim_type  = get_post_meta( get_the_ID(), '_package_type',         true );
                $sim_dest  = get_post_meta( get_the_ID(), '_package_destinations', true );
                $sim_dur   = get_post_meta( get_the_ID(), '_package_duration',     true );
                $sim_price = get_post_meta( get_the_ID(), '_package_price',        true );
            ?>
            <article class="package-card" <?php post_class( 'package-card' ); ?>>
                <div class="package-card__image-wrap">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'package-card', [ 'class' => 'package-card__image', 'alt' => get_the_title(), 'loading' => 'lazy' ] ); ?>
                    <?php else : ?>
                        <div class="package-card__image-placeholder">
                            <?php if ( $sim_dest ) : ?><span><?php echo esc_html( $sim_dest ); ?></span><?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( $sim_type ) : ?>
                        <span class="package-card__type-tag"><?php echo esc_html( $sim_type ); ?></span>
                    <?php endif; ?>
                </div>
                <div class="package-card__body">
                    <div class="package-card__stars" aria-label="5 stars">
                        <?php echo str_repeat( $star_svg, 5 ); ?>
                    </div>
                    <h3 class="package-card__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <?php if ( $sim_dest ) : ?>
                    <p class="package-card__destination">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <?php echo esc_html( $sim_dest ); ?>
                    </p>
                    <?php endif; ?>
                    <div class="package-card__meta-row">
                        <?php if ( $sim_dur ) : ?>
                            <span class="package-card__duration"><?php echo esc_html( $sim_dur ); ?></span>
                        <?php endif; ?>
                        <span class="package-card__pax">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                            2–15 Pax
                        </span>
                    </div>
                    <?php if ( $sim_price ) :
                        $sim_price_fmt = is_numeric( $sim_price ) ? number_format( (int) $sim_price ) : $sim_price;
                    ?>
                    <div class="package-card__price">
                        <span class="package-card__price-from"><?php esc_html_e( 'Starting from', 'travzo' ); ?></span>
                        <span class="package-card__price-amount">&#8377;<?php echo esc_html( $sim_price_fmt ); ?></span>
                    </div>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="pkg-cta-btn"><?php esc_html_e( 'View Package', 'travzo' ); ?></a>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

</main>

<?php get_footer(); ?>
