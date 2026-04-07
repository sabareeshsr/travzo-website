<?php
/**
 * Template Name: Media Page
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
if ( '' === $hero_heading ) $hero_heading = travzo_get( 'travzo_media_hero_title', 'Media & Press' );
if ( '' === $hero_desc )    $hero_desc    = travzo_get( 'travzo_media_hero_desc',  'Our journey in photos, videos, press coverage and awards.' );
if ( '' === $hero_image )   $hero_image   = travzo_get( 'travzo_media_hero_image', '' );
$hero_style   = $hero_image ? 'background-image:url(' . esc_url( $hero_image ) . ');background-size:cover;background-position:center' : '';

// Photo gallery: native WordPress attached images
$photo_gallery = get_attached_media( 'image', $post_id );

// Videos: cols [0]=title, [1]=url, [2]=thumbnail
$videos = travzo_parse_lines( get_post_meta( $post_id, '_media_videos', true ), 3 );

// Press: cols [0]=publication, [1]=headline, [2]=date, [3]=url
$press_items = travzo_parse_lines( get_post_meta( $post_id, '_media_press', true ), 4 );

// Awards: cols [0]=title, [1]=year, [2]=body, [3]=image
$awards = travzo_parse_lines( get_post_meta( $post_id, '_media_awards', true ), 4 );

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
                    <span>Media</span>
                </nav>
                <h1 class="page-hero__heading"><?php echo esc_html( $hero_heading ); ?></h1>
                <p class="page-hero__subtext"><?php echo esc_html( $hero_desc ); ?></p>
            </div>
        </div>
    </section>

    <!-- ══ 2. TAB NAVIGATION ════════════════════════════════════════════════ -->
    <div class="media-tabs-bar" role="tablist" aria-label="Media sections">
        <div class="section-inner">
            <div class="media-tabs">
                <button class="media-tab-btn active" data-tab="photos" role="tab" aria-selected="true" aria-controls="media-photos">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Photos
                </button>
                <button class="media-tab-btn" data-tab="videos" role="tab" aria-selected="false" aria-controls="media-videos">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                    Videos
                </button>
                <button class="media-tab-btn" data-tab="press" role="tab" aria-selected="false" aria-controls="media-press">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 0-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6z"/></svg>
                    Press Coverage
                </button>
                <button class="media-tab-btn" data-tab="awards" role="tab" aria-selected="false" aria-controls="media-awards">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                    Awards
                </button>
            </div>
        </div>
    </div>

    <!-- ══ 3. TAB PANELS ════════════════════════════════════════════════════ -->
    <section class="media-content-section">
        <div class="section-inner">

            <!-- PANEL 1: Photos -->
            <div class="media-panel active" id="media-photos" role="tabpanel">
                <div class="media-panel-header">
                    <span class="section-label">Gallery</span>
                    <h2 class="section-heading section-heading--left">Photo Gallery</h2>
                    <p class="media-panel-subtext">Moments captured from our journeys across the world.</p>
                </div>

                <div class="photo-masonry-grid">
                    <?php if ( ! empty( $photo_gallery ) ) :
                        foreach ( $photo_gallery as $photo ) :
                            $img_url  = esc_url( wp_get_attachment_image_url( $photo->ID, 'large' ) ?: wp_get_attachment_url( $photo->ID ) );
                            $full_url = esc_url( wp_get_attachment_url( $photo->ID ) );
                            $img_alt  = esc_attr( get_post_meta( $photo->ID, '_wp_attachment_image_alt', true ) );
                    ?>
                    <div class="photo-item">
                        <img src="<?php echo $img_url; ?>"
                             alt="<?php echo $img_alt; ?>"
                             loading="lazy">
                        <div class="photo-overlay" data-full="<?php echo $full_url; ?>" role="button" tabindex="0" aria-label="View full size">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                        </div>
                    </div>
                    <?php endforeach;
                    else :
                        for ( $i = 1; $i <= 12; $i++ ) : ?>
                    <div class="photo-item photo-item--placeholder">
                        <div class="photo-placeholder-inner">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.35)" stroke-width="1.5" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span>Travel Photo <?php echo $i; ?></span>
                        </div>
                    </div>
                    <?php endfor;
                    endif; ?>
                </div>
            </div><!-- /#media-photos -->

            <!-- PANEL 2: Videos -->
            <div class="media-panel" id="media-videos" role="tabpanel" hidden>
                <div class="media-panel-header">
                    <span class="section-label">Watch</span>
                    <h2 class="section-heading section-heading--left">Videos</h2>
                    <p class="media-panel-subtext">Watch our travel stories and destination highlights.</p>
                </div>

                <?php
                if ( empty( $videos ) ) {
                    $videos = [
                        [ 'Kerala Backwaters – A Journey Through Paradise', '#', '' ],
                        [ 'Maldives Honeymoon Experience',                  '#', '' ],
                        [ 'Bali Group Tour Highlights',                     '#', '' ],
                        [ 'Char Dham Yatra 2024',                           '#', '' ],
                        [ 'Europe Summer Tour',                             '#', '' ],
                        [ 'Kashmir – Heaven on Earth',                      '#', '' ],
                    ];
                }
                ?>
                <div class="videos-grid">
                    <?php foreach ( $videos as $video ) :
                        $v_title = esc_html( $video[0] ?? '' );
                        $v_url   = esc_url( $video[1] ?? '#' );
                        $v_thumb = esc_url( $video[2] ?? '' );
                    ?>
                    <div class="video-card">
                        <div class="video-thumb-wrap" data-video="<?php echo $v_url; ?>" role="button" tabindex="0" aria-label="Play <?php echo $v_title; ?>">
                            <?php if ( $v_thumb ) : ?>
                            <img src="<?php echo $v_thumb; ?>" alt="<?php echo $v_title; ?>" class="video-thumb">
                            <?php else : ?>
                            <div class="video-thumb-placeholder" aria-hidden="true"></div>
                            <?php endif; ?>
                            <div class="video-play-btn" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </div>
                        </div>
                        <h3 class="video-title"><?php echo $v_title; ?></h3>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div><!-- /#media-videos -->

            <!-- PANEL 3: Press Coverage -->
            <div class="media-panel" id="media-press" role="tabpanel" hidden>
                <div class="media-panel-header">
                    <span class="section-label">In The News</span>
                    <h2 class="section-heading section-heading--left">Press Coverage</h2>
                    <p class="media-panel-subtext">What the media says about Travzo Holidays.</p>
                </div>

                <?php
                if ( empty( $press_items ) ) {
                    $press_items = [
                        [ 'The Hindu',            'Travzo Holidays redefines luxury travel for South Indian families',       'March 2024',    '#' ],
                        [ 'Times of India',       'How Travzo is making devotional tourism accessible and comfortable',       'February 2024', '#' ],
                        [ 'Deccan Chronicle',     'Coimbatore travel agency wins hearts with personalised honeymoon packages', 'January 2024',  '#' ],
                        [ 'Economic Times',       'Travel startups from Tamil Nadu making waves in group tourism',             'December 2023', '#' ],
                        [ 'Outlook Traveller',    'Best travel agencies in South India for 2024',                             'November 2023', '#' ],
                        [ 'Travel+Leisure India', 'Travzo Holidays among top picks for curated Indian experiences',           'October 2023',  '#' ],
                    ];
                }
                ?>
                <div class="press-grid">
                    <?php foreach ( $press_items as $press ) :
                        $p_pub  = esc_html( $press[0] ?? '' );
                        $p_hl   = esc_html( $press[1] ?? '' );
                        $p_date = esc_html( $press[2] ?? '' );
                        $p_url  = esc_url( $press[3] ?? '' );
                    ?>
                    <div class="press-card">
                        <div class="press-publication-name"><?php echo $p_pub; ?></div>
                        <h3 class="press-headline"><?php echo $p_hl; ?></h3>
                        <?php if ( $p_date ) : ?>
                        <p class="press-date">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <?php echo $p_date; ?>
                        </p>
                        <?php endif; ?>
                        <?php if ( $p_url && $p_url !== '#' ) : ?>
                        <a href="<?php echo $p_url; ?>" class="press-read-more" target="_blank" rel="noopener noreferrer">Read Article &rarr;</a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div><!-- /#media-press -->

            <!-- PANEL 4: Awards -->
            <div class="media-panel" id="media-awards" role="tabpanel" hidden>
                <div class="media-panel-header">
                    <span class="section-label">Recognition</span>
                    <h2 class="section-heading section-heading--left">Awards &amp; Recognition</h2>
                    <p class="media-panel-subtext">Our commitment to excellence recognised by the industry.</p>
                </div>

                <?php
                if ( empty( $awards ) ) {
                    $awards = [
                        [ 'Best Travel Agency – South India',  '2024', 'Tamil Nadu Tourism Awards',   '' ],
                        [ 'Excellence in Honeymoon Tourism',   '2023', 'India Travel Awards',          '' ],
                        [ 'Top Emerging Travel Brand',         '2023', 'Outlook Traveller Awards',     '' ],
                        [ 'Best Devotional Tour Operator',     '2022', 'South India Tourism Summit',   '' ],
                        [ 'Customer Choice Award',             '2022', 'Travel+Leisure India',         '' ],
                        [ 'Best Group Tour Operator',          '2021', 'Indian Travel Congress',       '' ],
                    ];
                }
                ?>
                <div class="awards-showcase-grid">
                    <?php foreach ( $awards as $award ) :
                        $a_title = esc_html( $award[0] ?? '' );
                        $a_year  = esc_html( $award[1] ?? '' );
                        $a_body  = esc_html( $award[2] ?? '' );
                        $a_img   = esc_url( $award[3] ?? '' );
                    ?>
                    <div class="award-showcase-card">
                        <?php if ( $a_img ) : ?>
                        <img src="<?php echo $a_img; ?>" alt="<?php echo $a_title; ?>" class="award-showcase-image">
                        <?php else : ?>
                        <div class="award-showcase-placeholder" aria-hidden="true">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#C9A227" stroke-width="1.5"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                        </div>
                        <?php endif; ?>
                        <div class="award-showcase-content">
                            <?php if ( $a_year ) : ?>
                            <span class="award-showcase-year"><?php echo $a_year; ?></span>
                            <?php endif; ?>
                            <h3 class="award-showcase-title"><?php echo $a_title; ?></h3>
                            <?php if ( $a_body ) : ?>
                            <p class="award-showcase-body"><?php echo $a_body; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div><!-- /#media-awards -->

        </div>
    </section>

    <!-- ══ LIGHTBOX ═════════════════════════════════════════════════════════ -->
    <div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Photo viewer" hidden>
        <button class="lightbox-close" id="lightbox-close" aria-label="Close lightbox">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <img src="" alt="" id="lightbox-img">
    </div>

    <!-- ══ VIDEO MODAL ══════════════════════════════════════════════════════ -->
    <div class="video-modal" id="video-modal" role="dialog" aria-modal="true" aria-label="Video player" hidden>
        <div class="video-modal-inner">
            <button class="lightbox-close" id="video-modal-close" aria-label="Close video">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <iframe id="video-frame" src="" frameborder="0" allow="autoplay; fullscreen" allowfullscreen title="Video"></iframe>
        </div>
    </div>

</main>

<?php get_footer(); ?>
