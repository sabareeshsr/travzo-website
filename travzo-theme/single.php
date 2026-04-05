<?php
/**
 * Single Blog Post
 *
 * @package Travzo
 */

get_header();
the_post();

$thumb      = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$cats       = get_the_category();
$cat_name   = $cats ? $cats[0]->name : 'Travel';
$tags       = get_the_tags();
$categories = get_categories( [ 'hide_empty' => true ] );

/* Read-time estimate */
$word_count = str_word_count( strip_tags( get_the_content() ) );
$read_time  = max( 1, (int) ceil( $word_count / 200 ) );

/* Sidebar phone */
$sidebar_phone = '';
if ( function_exists( 'get_field' ) ) {
    $sidebar_phone = get_field( 'site_phone', 'option' ) ?: '';
}
$sidebar_phone_url = $sidebar_phone
    ? 'tel:' . preg_replace( '/[^+0-9]/', '', $sidebar_phone )
    : '#';
?>

<main id="main-content">

    <!-- ══ 1. POST HERO ═════════════════════════════════════════════════════ -->
    <section class="post-hero<?php echo $thumb ? '' : ' post-hero--default'; ?>"
        <?php if ( $thumb ) : ?>style="background-image:url(<?php echo esc_url( $thumb ); ?>);"<?php endif; ?>>
        <div class="post-hero-overlay"></div>
        <div class="post-hero-content">
            <nav class="page-hero__breadcrumb post-hero__breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                <span aria-hidden="true"> / </span>
                <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Blog</a>
                <span aria-hidden="true"> / </span>
                <span><?php echo esc_html( $cat_name ); ?></span>
            </nav>
            <span class="blog-category-tag post-hero-cat"><?php echo esc_html( $cat_name ); ?></span>
            <h1 class="post-title"><?php the_title(); ?></h1>
            <div class="post-hero-meta">
                <div class="post-author">
                    <?php echo get_avatar( get_the_author_meta( 'email' ), 40, '', '', [ 'class' => 'author-avatar author-avatar--lg' ] ); ?>
                    <div>
                        <span class="author-name"><?php the_author(); ?></span>
                        <span class="post-date-small"><?php echo get_the_date( 'M j, Y' ); ?></span>
                    </div>
                </div>
                <div class="post-read-time">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo $read_time; ?> min read
                </div>
            </div>
        </div>
    </section>

    <!-- ══ 2. POST CONTENT + SIDEBAR ════════════════════════════════════════ -->
    <section class="post-layout-section">
        <div class="section-inner">
            <div class="post-layout">

                <!-- Article -->
                <article class="post-content-area">
                    <div class="post-body">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags -->
                    <?php if ( $tags ) : ?>
                    <div class="post-tags">
                        <span class="post-tags-label">Tags:</span>
                        <?php foreach ( $tags as $tag ) : ?>
                        <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="post-tag">
                            #<?php echo esc_html( $tag->name ); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Author bio -->
                    <div class="post-author-bio">
                        <?php echo get_avatar( get_the_author_meta( 'email' ), 72, '', '', [ 'class' => 'author-bio-avatar' ] ); ?>
                        <div class="author-bio-content">
                            <span class="author-bio-label">Written by</span>
                            <h4 class="author-bio-name"><?php the_author(); ?></h4>
                            <p class="author-bio-text">
                                <?php echo esc_html( get_the_author_meta( 'description' ) ?: 'A passionate travel writer and explorer sharing stories from journeys across India and the world.' ); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Share buttons -->
                    <div class="post-share">
                        <span class="post-share-label">Share this article:</span>
                        <div class="post-share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>"
                               target="_blank" rel="noopener noreferrer"
                               class="share-btn share-facebook" aria-label="Share on Facebook">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Facebook
                            </a>
                            <a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>"
                               target="_blank" rel="noopener noreferrer"
                               class="share-btn share-whatsapp" aria-label="Share on WhatsApp">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                WhatsApp
                            </a>
                            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( get_the_title() ); ?>&url=<?php echo urlencode( get_permalink() ); ?>"
                               target="_blank" rel="noopener noreferrer"
                               class="share-btn share-twitter" aria-label="Share on X (Twitter)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.736-8.85L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                Twitter
                            </a>
                        </div>
                    </div>

                    <!-- Post navigation -->
                    <nav class="post-navigation" aria-label="Post navigation">
                        <div class="post-nav-prev">
                            <?php $prev = get_previous_post(); if ( $prev ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $prev->ID ) ); ?>">
                                <span class="post-nav-label">&larr; Previous</span>
                                <span class="post-nav-title"><?php echo esc_html( get_the_title( $prev->ID ) ); ?></span>
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="post-nav-next">
                            <?php $next = get_next_post(); if ( $next ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $next->ID ) ); ?>">
                                <span class="post-nav-label">Next &rarr;</span>
                                <span class="post-nav-title"><?php echo esc_html( get_the_title( $next->ID ) ); ?></span>
                            </a>
                            <?php endif; ?>
                        </div>
                    </nav>
                </article>

                <!-- Sidebar -->
                <aside class="post-sidebar">

                    <!-- Search -->
                    <div class="sidebar-widget">
                        <h4 class="widget-heading">Search</h4>
                        <form class="sidebar-search" method="GET" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <input type="search" name="s"
                                   placeholder="Search articles&hellip;"
                                   class="sidebar-search-input"
                                   aria-label="Search articles">
                            <button type="submit" aria-label="Submit search">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-widget">
                        <h4 class="widget-heading">Categories</h4>
                        <ul class="sidebar-categories">
                            <?php foreach ( $categories as $cat ) : ?>
                            <li>
                                <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
                                    <?php echo esc_html( $cat->name ); ?>
                                    <span><?php echo absint( $cat->count ); ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Recent Posts -->
                    <div class="sidebar-widget">
                        <h4 class="widget-heading">Recent Posts</h4>
                        <?php
                        $recent_query = new WP_Query( [
                            'post_type'      => 'post',
                            'posts_per_page' => 4,
                            'post_status'    => 'publish',
                            'post__not_in'   => [ get_the_ID() ],
                        ] );
                        if ( $recent_query->have_posts() ) : ?>
                        <ul class="sidebar-recent-posts">
                            <?php while ( $recent_query->have_posts() ) : $recent_query->the_post();
                                $r_thumb = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
                            ?>
                            <li class="recent-post-item">
                                <?php if ( $r_thumb ) : ?>
                                <img src="<?php echo esc_url( $r_thumb ); ?>"
                                     alt="<?php the_title_attribute(); ?>"
                                     class="recent-post-thumb" loading="lazy">
                                <?php else : ?>
                                <div class="recent-post-thumb-placeholder" aria-hidden="true"></div>
                                <?php endif; ?>
                                <div class="recent-post-info">
                                    <a href="<?php the_permalink(); ?>" class="recent-post-title"><?php the_title(); ?></a>
                                    <span class="recent-post-date"><?php echo get_the_date( 'M j, Y' ); ?></span>
                                </div>
                            </li>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Enquiry CTA -->
                    <div class="sidebar-widget sidebar-enquiry-widget">
                        <h4>Plan Your Trip</h4>
                        <p>Ready to explore? Let our travel experts craft the perfect itinerary for you.</p>
                        <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"
                           class="btn btn--gold btn--full">
                            Enquire Now
                        </a>
                        <?php if ( $sidebar_phone && $sidebar_phone_url !== '#' ) : ?>
                        <a href="<?php echo esc_url( $sidebar_phone_url ); ?>"
                           class="sidebar-enquiry-call-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.06 6.06l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            Call Us Now
                        </a>
                        <?php endif; ?>
                    </div>

                </aside><!-- /.post-sidebar -->

            </div><!-- /.post-layout -->
        </div>
    </section>

    <!-- ══ 3. RELATED POSTS ═════════════════════════════════════════════════ -->
    <?php
    $related_args = [
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'post__not_in'   => [ get_the_ID() ],
        'orderby'        => 'rand',
    ];
    if ( $cats ) {
        $related_args['category__in'] = [ $cats[0]->term_id ];
    }
    $related_query = new WP_Query( $related_args );
    if ( $related_query->have_posts() ) : ?>

    <section class="related-posts-section">
        <div class="section-inner">
            <span class="section-label">Keep Reading</span>
            <h2 class="section-heading section-heading--left">Related Articles</h2>
            <div class="blog-list-grid related-posts-grid">
                <?php while ( $related_query->have_posts() ) : $related_query->the_post();
                    $r_thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
                    $r_cats  = get_the_category();
                    $r_cat   = $r_cats ? $r_cats[0]->name : 'Travel';
                ?>
                <article class="blog-card">
                    <div class="blog-image-wrap">
                        <?php if ( $r_thumb ) : ?>
                        <img src="<?php echo esc_url( $r_thumb ); ?>"
                             alt="<?php the_title_attribute(); ?>"
                             class="blog-image" loading="lazy">
                        <?php else : ?>
                        <div class="blog-image-placeholder" aria-hidden="true"></div>
                        <?php endif; ?>
                        <span class="blog-category"><?php echo esc_html( $r_cat ); ?></span>
                    </div>
                    <div class="blog-body">
                        <h3 class="blog-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="blog-excerpt">
                            <?php echo wp_trim_words( get_the_excerpt(), 18, '&hellip;' ); ?>
                        </p>
                        <div class="blog-footer-row">
                            <div class="blog-meta">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <?php echo get_the_date( 'M j, Y' ); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="blog-read-more">
                                Read More
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
