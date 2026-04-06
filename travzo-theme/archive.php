<?php
/**
 * Archive / Blog List
 *
 * @package Travzo
 */

$paged      = get_query_var( 'paged' ) ?: 1;
$filter_cat = isset( $_GET['category'] ) ? sanitize_text_field( wp_unslash( $_GET['category'] ) ) : '';
$categories = get_categories( [ 'hide_empty' => true ] );

get_header(); ?>

<main id="main-content">

    <!-- ══ 1. HERO ══════════════════════════════════════════════════════════ -->
    <?php
    $_blog_hero_img   = travzo_get( 'travzo_blog_hero_image', '' );
    $_blog_hero_style = $_blog_hero_img ? 'background-image:url(' . esc_url( $_blog_hero_img ) . ');background-size:cover;background-position:center' : '';
    ?>
    <section class="page-hero"<?php if ( $_blog_hero_style ) : ?> style="<?php echo $_blog_hero_style; ?>"<?php endif; ?>>
        <div class="page-hero-overlay"></div>
        <div class="section-inner">
            <div class="page-hero__content">
                <nav class="page-hero__breadcrumb" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                    <span aria-hidden="true"> / </span>
                    <span>Blog</span>
                </nav>
                <h1 class="page-hero__heading"><?php echo esc_html( travzo_get( 'travzo_blog_hero_title', 'Travel Stories & Tips' ) ); ?></h1>
                <p class="page-hero__subtext"><?php echo esc_html( travzo_get( 'travzo_blog_hero_desc', 'Inspiration, guides and stories from our journeys around the world.' ) ); ?></p>
            </div>
        </div>
    </section>

    <!-- ══ 2. CATEGORY FILTER ═══════════════════════════════════════════════ -->
    <div class="blog-filter-bar">
        <div class="section-inner">
            <div class="blog-filter-tabs" role="list">
                <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>"
                   class="blog-filter-tab<?php echo ! $filter_cat ? ' active' : ''; ?>"
                   role="listitem">
                    All Posts
                </a>
                <?php foreach ( $categories as $cat ) :
                    $is_active = $filter_cat === $cat->slug;
                ?>
                <a href="<?php echo esc_url( home_url( '/blog?category=' . $cat->slug ) ); ?>"
                   class="blog-filter-tab<?php echo $is_active ? ' active' : ''; ?>"
                   role="listitem"
                   <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
                    <?php echo esc_html( $cat->name ); ?>
                    <span class="blog-filter-count"><?php echo absint( $cat->count ); ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- ══ 3. FEATURED POST (page 1, no filter) ═════════════════════════════ -->
    <?php if ( $paged === 1 && ! $filter_cat ) :
        $featured_query = new WP_Query( [
            'post_type'      => 'post',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ] );
        if ( $featured_query->have_posts() ) :
            $featured_query->the_post();
            $featured_thumb = get_the_post_thumbnail_url( get_the_ID(), 'large' );
            $featured_cats  = get_the_category();
            $featured_cat   = $featured_cats ? $featured_cats[0]->name : 'Travel';
    ?>
    <section class="featured-post-section">
        <div class="section-inner">
            <div class="featured-post-card">
                <div class="featured-post-image">
                    <?php if ( $featured_thumb ) : ?>
                    <img src="<?php echo esc_url( $featured_thumb ); ?>"
                         alt="<?php the_title_attribute(); ?>">
                    <?php else : ?>
                    <div class="featured-post-image-placeholder" aria-hidden="true"></div>
                    <?php endif; ?>
                    <span class="blog-category-tag"><?php echo esc_html( $featured_cat ); ?></span>
                </div>
                <div class="featured-post-content">
                    <span class="section-label">Featured Post</span>
                    <h2 class="featured-post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p class="featured-post-excerpt">
                        <?php echo wp_trim_words( get_the_excerpt(), 30, '&hellip;' ); ?>
                    </p>
                    <div class="featured-post-meta">
                        <div class="post-author">
                            <?php echo get_avatar( get_the_author_meta( 'email' ), 32, '', '', [ 'class' => 'author-avatar' ] ); ?>
                            <span><?php the_author(); ?></span>
                        </div>
                        <span class="post-date">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <?php echo get_the_date( 'M j, Y' ); ?>
                        </span>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="btn btn--gold featured-post-btn">
                        Read Article
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata();
        endif;
    endif; ?>

    <!-- ══ 4. BLOG GRID ═════════════════════════════════════════════════════ -->
    <section class="blog-list-section">
        <div class="section-inner">

            <?php
            $blog_args = [
                'post_type'      => 'post',
                'posts_per_page' => 9,
                'paged'          => $paged,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ];

            if ( $filter_cat ) {
                $blog_args['category_name'] = $filter_cat;
            }

            // Skip the featured post on page 1 with no filter
            if ( $paged === 1 && ! $filter_cat ) {
                $blog_args['offset'] = 1;
            }

            $blog_query = new WP_Query( $blog_args );
            ?>

            <?php if ( $blog_query->have_posts() ) : ?>

            <div class="blog-list-grid">
                <?php while ( $blog_query->have_posts() ) : $blog_query->the_post();
                    $thumb    = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
                    $cats     = get_the_category();
                    $cat_name = $cats ? $cats[0]->name : 'Travel';
                ?>
                <article class="blog-card">
                    <div class="blog-image-wrap">
                        <?php if ( $thumb ) : ?>
                        <img src="<?php echo esc_url( $thumb ); ?>"
                             alt="<?php the_title_attribute(); ?>"
                             class="blog-image" loading="lazy">
                        <?php else : ?>
                        <div class="blog-image-placeholder" aria-hidden="true"></div>
                        <?php endif; ?>
                        <span class="blog-category"><?php echo esc_html( $cat_name ); ?></span>
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
            </div><!-- /.blog-list-grid -->

            <div class="packages-pagination">
                <?php echo paginate_links( [
                    'total'     => $blog_query->max_num_pages,
                    'current'   => $paged,
                    'prev_text' => '&larr; Previous',
                    'next_text' => 'Next &rarr;',
                    'type'      => 'list',
                ] ); ?>
            </div>

            <?php else : ?>

            <div class="no-posts-message">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                <h3>No Posts Yet</h3>
                <p>Check back soon for travel stories and tips.</p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--gold">Back to Home</a>
            </div>

            <?php endif; ?>

        </div>
    </section>

    <!-- ══ 5. NEWSLETTER ════════════════════════════════════════════════════ -->
    <section class="newsletter-section">
        <div class="newsletter-inner">
            <div class="newsletter-icon" aria-hidden="true">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--navy)" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <h2 class="newsletter-heading"><?php echo esc_html( travzo_get( 'travzo_newsletter_heading', 'Get Travel Stories in Your Inbox' ) ); ?></h2>
            <p class="newsletter-subtext"><?php echo esc_html( travzo_get( 'travzo_newsletter_subtext', 'Subscribe for travel tips, destination guides and exclusive offers.' ) ); ?></p>
            <?php
            travzo_render_form( 'travzo_form_newsletter', '<form class="newsletter-form" method="POST" action=""><div class="newsletter-form__pill"><input type="email" name="newsletter_email" placeholder="Enter your email address" required aria-label="Email address"><button type="submit">Subscribe</button></div></form>' );
            ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
