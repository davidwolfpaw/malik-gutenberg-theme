<?php
/**
 * Template Name: No Title
 *
 * @package Malik
 */

get_header();

add_filter( 'body_class', function( $classes ) {
    return array_merge( $classes, array( 'page-no-title' ) );
} );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) :

				the_post();

				get_template_part( 'template-parts/content', 'page-no-title' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
