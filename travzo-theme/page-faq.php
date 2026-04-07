<?php
/**
 * Template Name: FAQ Page
 * Template Post Type: page
 *
 * @package Travzo
 */

/* ── Native post meta ────────────────────────────────────────────────────── */
$post_id = get_the_ID();

$hero_heading = get_post_meta( $post_id, '_page_hero_title', true );
$hero_desc    = get_post_meta( $post_id, '_page_hero_subtitle', true );
$hero_image   = get_post_meta( $post_id, '_page_hero_image', true );
// Backward compat: fall back to old customizer values
if ( '' === $hero_heading ) $hero_heading = travzo_get( 'travzo_faq_hero_title', 'Frequently Asked Questions' );
if ( '' === $hero_desc )    $hero_desc    = travzo_get( 'travzo_faq_hero_desc',  'Find answers to the most common questions about travelling with Travzo Holidays.' );
if ( '' === $hero_image )   $hero_image   = travzo_get( 'travzo_faq_hero_image', '' );
$hero_style   = $hero_image ? 'background-image:url(' . esc_url( $hero_image ) . ');background-size:cover;background-position:center' : '';

// ── Debug ────────────────────────────────────────────────────────────────────
$dbg_cats  = get_post_meta( $post_id, '_faq_categories', true );
$dbg_items = get_post_meta( $post_id, '_faq_items_v2', true );
echo '<!-- DEBUG FAQ CATS: ' . esc_html( substr( print_r( $dbg_cats, true ), 0, 300 ) ) . ' -->';
echo '<!-- DEBUG FAQ ITEMS: ' . esc_html( substr( print_r( $dbg_items, true ), 0, 500 ) ) . ' -->';

// ── Categories ───────────────────────────────────────────────────────────────
$faq_cats_stored = get_post_meta( $post_id, '_faq_categories', true );
$categories = ( is_array( $faq_cats_stored ) && ! empty( $faq_cats_stored ) )
    ? $faq_cats_stored
    : [ 'General', 'Booking & Payment', 'Visas & Documents', 'Group Tours', 'Honeymoon', 'Cancellation' ];

// ── FAQ Items ────────────────────────────────────────────────────────────────
$faq_items_stored = get_post_meta( $post_id, '_faq_items_v2', true );
$faq_data = [];

if ( is_array( $faq_items_stored ) && ! empty( $faq_items_stored ) ) {
    $faq_data = $faq_items_stored;
}

// Backward compat: old pipe-separated _faqs
if ( empty( $faq_data ) ) {
    $old_faqs = get_post_meta( $post_id, '_faqs', true );
    if ( is_string( $old_faqs ) && '' !== trim( $old_faqs ) ) {
        $parsed = travzo_parse_lines( $old_faqs, 3 );
        foreach ( $parsed as $row ) {
            $faq_data[] = [
                'category' => $row[0] ?? 'General',
                'question' => $row[1] ?? '',
                'answer'   => $row[2] ?? '',
            ];
        }
    }
}

// Ultimate fallback
if ( empty( $faq_data ) ) {
    $faq_data = [
        [ 'category' => 'General',           'question' => 'What types of travel packages does Travzo offer?',      'answer' => 'Travzo Holidays offers a wide range of travel packages including Group Tours, Honeymoon Packages, Solo Trips, Devotional Tours, Destination Weddings, and International Packages. We cover both domestic Indian destinations and international destinations across Asia, Europe, Africa, and the Americas.' ],
        [ 'category' => 'General',           'question' => 'Can I customise a package to suit my preferences?',      'answer' => 'Absolutely. Every package we offer can be fully customised based on your travel dates, budget, accommodation preferences, and specific interests. Simply contact our travel experts and we will craft a personalised itinerary just for you.' ],
        [ 'category' => 'General',           'question' => 'How experienced is the Travzo team?',                    'answer' => 'The Travzo team has over 10 years of experience in the travel industry. Our travel experts have firsthand knowledge of hundreds of destinations and have successfully organised thousands of trips for families, couples, groups, and corporate clients.' ],
        [ 'category' => 'Booking & Payment', 'question' => 'How do I book a package with Travzo?',                   'answer' => 'You can book a package by filling in the enquiry form on our website, calling us directly, or visiting our nearest branch. Our travel expert will contact you within 24 hours to discuss your requirements and confirm your booking.' ],
        [ 'category' => 'Booking & Payment', 'question' => 'What payment methods do you accept?',                    'answer' => 'We accept payments via bank transfer, credit card, debit card, UPI, and net banking. EMI options are available on select packages through partner banks. A booking deposit of 25% is required to confirm your reservation with the balance due 30 days before departure.' ],
        [ 'category' => 'Booking & Payment', 'question' => 'Do you offer EMI options?',                              'answer' => 'Yes, we offer EMI options on select packages through our partner banks and credit card companies. Please enquire with our team for the latest EMI offers and eligibility criteria.' ],
        [ 'category' => 'Visas & Documents', 'question' => 'Do you help with visa applications?',                    'answer' => 'Yes, we provide complete visa assistance for all international destinations. Our team will guide you through the documentation process, help you prepare your application, and advise on the best time to apply. Please note that visa approval is at the sole discretion of the respective embassy.' ],
        [ 'category' => 'Visas & Documents', 'question' => 'What documents do I need for international travel?',     'answer' => 'For international travel you will need a valid passport with at least 6 months validity, the relevant visa, travel insurance, flight tickets, hotel booking confirmations, and sufficient funds. Specific requirements vary by destination and our team will provide a complete checklist for your trip.' ],
        [ 'category' => 'Visas & Documents', 'question' => 'How early should I apply for a visa?',                   'answer' => 'We recommend applying for your visa at least 4 to 6 weeks before your departure date. For some destinations like the USA, UK, and Schengen countries, you may need to apply even earlier. Our visa team will advise you on the exact timeline for your destination.' ],
        [ 'category' => 'Group Tours',       'question' => 'What is the minimum group size for a group tour?',       'answer' => 'Our group tours typically require a minimum of 10 participants. However, we also offer private group tours for smaller groups of 2 to 9 people at customised pricing. Contact us to discuss your group size and requirements.' ],
        [ 'category' => 'Group Tours',       'question' => 'Do you provide a tour manager for group tours?',         'answer' => 'Yes, all our group tours include a dedicated and experienced tour manager who accompanies the group throughout the trip. The tour manager handles all logistics, coordinates with hotels and transport, and ensures a smooth and enjoyable experience for every participant.' ],
        [ 'category' => 'Honeymoon',         'question' => 'What makes Travzo honeymoon packages special?',          'answer' => 'Our honeymoon packages are crafted with romance in mind. We include special touches like candlelit dinners, private transfers, flower decorated rooms, and surprise experiences. Every detail is personalised based on the couple\'s preferences to ensure an unforgettable honeymoon.' ],
        [ 'category' => 'Honeymoon',         'question' => 'Can I add special surprises to my honeymoon package?',   'answer' => 'Absolutely. We love creating magical moments for honeymooners. You can request flower arrangements, special dinners, spa treatments, photography sessions, or any other special additions. Simply let our team know what you have in mind and we will make it happen.' ],
        [ 'category' => 'Cancellation',      'question' => 'What is your cancellation policy?',                      'answer' => 'Cancellations made 30 or more days before departure receive a full refund minus processing fees. Cancellations 15 to 29 days before departure receive a 50% refund. Cancellations 7 to 14 days before receive a 25% refund. Cancellations within 7 days of departure are non-refundable. All cancellations must be submitted in writing.' ],
        [ 'category' => 'Cancellation',      'question' => 'What happens if Travzo cancels my trip?',                'answer' => 'In the unlikely event that Travzo needs to cancel a trip due to unforeseen circumstances, you will receive a full refund or the option to rebook for a future date at no additional cost. We will inform you as early as possible and work with you to find the best solution.' ],
    ];
}

// Build category list from actual items (ensures only used categories appear)
$used_cats = array_values( array_unique( array_column( $faq_data, 'category' ) ) );
// Merge: show stored categories order first, then any extras from items
$display_cats = [];
foreach ( $categories as $c ) {
    if ( in_array( $c, $used_cats, true ) ) {
        $display_cats[] = $c;
    }
}
foreach ( $used_cats as $c ) {
    if ( ! in_array( $c, $display_cats, true ) ) {
        $display_cats[] = $c;
    }
}

/* ── Contact details for CTA ─────────────────────────────────────────────── */
$cta_phone     = travzo_get( 'travzo_phone', '' );
$cta_phone_url = $cta_phone ? 'tel:' . preg_replace( '/[^+0-9]/', '', $cta_phone ) : '#';

get_header(); ?>

<main id="main-content">

    <!-- ══ 1. HERO ══════════════════════════════════════════════════════════ -->
    <section class="page-hero"<?php if ( $hero_style ) : ?> style="<?php echo $hero_style; ?>"<?php endif; ?>>
        <div class="page-hero-overlay"></div>
        <div class="section-inner">
            <div class="page-hero__content">
                <nav class="page-hero__breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                    <span aria-hidden="true"> / </span>
                    <span>FAQs</span>
                </nav>
                <h1 class="page-hero__heading"><?php echo esc_html( $hero_heading ); ?></h1>
                <p class="page-hero__subtext"><?php echo esc_html( $hero_desc ); ?></p>
            </div>
        </div>
    </section>

    <!-- ══ 2. FAQ CONTENT ═══════════════════════════════════════════════════ -->
    <section class="faq-section">
        <div class="section-inner">
            <div class="faq-layout">

                <!-- Sidebar: categories + CTA -->
                <aside class="faq-sidebar">
                    <h3 class="faq-sidebar__heading">Categories</h3>
                    <ul class="faq-category-list" role="list">
                        <li>
                            <button class="faq-cat-btn active" data-category="all" aria-pressed="true">
                                All Questions
                                <span class="faq-cat-count"><?php echo count( $faq_data ); ?></span>
                            </button>
                        </li>
                        <?php foreach ( $display_cats as $cat ) :
                            $count    = count( array_filter( $faq_data, fn( $f ) => $f['category'] === $cat ) );
                            $cat_slug = sanitize_title( $cat );
                        ?>
                        <li>
                            <button class="faq-cat-btn" data-category="<?php echo esc_attr( $cat_slug ); ?>" aria-pressed="false">
                                <?php echo esc_html( $cat ); ?>
                                <span class="faq-cat-count"><?php echo $count; ?></span>
                            </button>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="faq-sidebar__cta">
                        <p>Still have questions?</p>
                        <?php if ( $cta_phone && $cta_phone_url !== '#' ) : ?>
                        <a href="<?php echo esc_url( $cta_phone_url ); ?>" class="btn btn--gold faq-sidebar__btn">
                            Call Us Now
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn--navy faq-sidebar__btn">
                            Send a Message
                        </a>
                    </div>
                </aside>

                <!-- Main: search + accordion groups -->
                <div class="faq-content">

                    <div class="faq-search-wrap">
                        <svg class="faq-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <input type="search" id="faq-search" class="faq-search-input"
                            placeholder="Search questions..."
                            aria-label="Search frequently asked questions">
                    </div>

                    <?php foreach ( $display_cats as $cat ) :
                        $cat_slug = sanitize_title( $cat );
                        $cat_faqs = array_values( array_filter( $faq_data, fn( $f ) => $f['category'] === $cat ) );
                        if ( empty( $cat_faqs ) ) continue;
                    ?>
                    <div class="faq-category-group" data-category="<?php echo esc_attr( $cat_slug ); ?>">
                        <h2 class="faq-category-heading"><?php echo esc_html( $cat ); ?></h2>
                        <div class="faq-accordion">
                            <?php foreach ( $cat_faqs as $faq ) :
                                $q_attr = esc_attr( strtolower( $faq['question'] ) );
                            ?>
                            <div class="faq-item" data-question="<?php echo $q_attr; ?>">
                                <button class="faq-question-btn" aria-expanded="false">
                                    <span><?php echo esc_html( $faq['question'] ); ?></span>
                                    <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                                </button>
                                <div class="faq-answer" hidden>
                                    <p><?php echo esc_html( $faq['answer'] ); ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="faq-no-results" hidden aria-live="polite">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <h3>No results found</h3>
                        <p>Try a different search term or browse by category.</p>
                    </div>

                </div><!-- /.faq-content -->

            </div><!-- /.faq-layout -->
        </div>
    </section>

    <!-- ══ 3. BOTTOM CTA ════════════════════════════════════════════════════ -->
    <section class="faq-cta-section">
        <div class="section-inner">
            <div class="faq-cta-inner">
                <div class="faq-cta-icon" aria-hidden="true">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.06 6.06l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <h2>Still Have Questions?</h2>
                <p>Our travel experts are ready to help you plan your perfect trip.</p>
                <div class="faq-cta-buttons">
                    <?php if ( $cta_phone && $cta_phone_url !== '#' ) : ?>
                    <a href="<?php echo esc_url( $cta_phone_url ); ?>" class="btn btn--gold">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.06 6.06l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Call Us Now
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn--ghost-white">
                        Send a Message
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
