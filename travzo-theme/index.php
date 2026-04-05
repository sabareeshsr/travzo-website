<?php get_header(); ?>

<main id="main-content">
    <?php if ( have_posts() ) : ?>
        <div class="post-loop">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-excerpt"><?php the_excerpt(); ?></div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e( 'No content found.', 'travzo' ); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
