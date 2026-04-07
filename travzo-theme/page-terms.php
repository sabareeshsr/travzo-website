<?php
/**
 * Template Name: Terms & Conditions
 * Template Post Type: page
 *
 * @package Travzo
 */

$post_id    = get_the_ID();
$hero_title = get_post_meta( $post_id, '_legal_hero_title', true ) ?: get_the_title();
$hero_sub   = get_post_meta( $post_id, '_legal_hero_subtitle', true );
$hero_image = get_post_meta( $post_id, '_legal_hero_image', true );
$show_date  = get_post_meta( $post_id, '_legal_show_date', true );
$content    = get_post_meta( $post_id, '_legal_content', true );

$hero_style = $hero_image
    ? 'background-image:url(' . esc_url( $hero_image ) . ');background-size:cover;background-position:center'
    : '';

get_header();
?>

<main id="main-content">

    <section class="legal-page-hero<?php echo $hero_image ? ' legal-page-hero--has-image' : ''; ?>"<?php if ( $hero_style ) : ?> style="<?php echo $hero_style; ?>"<?php endif; ?>>
        <div class="legal-page-hero__overlay"></div>
        <div class="legal-page-hero__content">
            <nav class="legal-page-hero__breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                <span aria-hidden="true"> / </span>
                <span><?php echo esc_html( get_the_title() ); ?></span>
            </nav>
            <h1><?php echo esc_html( $hero_title ); ?></h1>
            <?php if ( $hero_sub ) : ?>
                <p class="legal-page-hero__subtitle"><?php echo esc_html( $hero_sub ); ?></p>
            <?php endif; ?>
            <?php if ( '0' !== $show_date && '' !== $show_date ) : ?>
                <p class="legal-page-hero__date">Last updated: <?php echo esc_html( get_the_modified_date( 'F j, Y' ) ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="legal-content-section">
        <div class="legal-content-wrap">
            <div class="legal-content">
                <?php
                if ( $content ) {
                    echo wp_kses_post( $content );
                } else {
                    the_content();
                }
                ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
