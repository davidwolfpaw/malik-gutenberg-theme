<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Malik
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php
		if ( is_active_sidebar( 'footer' ) ) :
		?>
			<aside id="secondary" class="widget-area footer-sidebar">
				<?php dynamic_sidebar( 'footer' ); ?>
			</aside><!-- #secondary -->
		<?php
		endif;
		?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'malik' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'malik' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
			<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( '%1$s Theme by %2$s.', 'malik' ), 'Malik', '<a href="https://davidlaietta.com">David Laietta</a>' );
			?>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php
// Get the fonts that the site uses from theme settings.
$font_selection = get_theme_mod( 'font_pairing', 'playfair_lato' );
if ( 'playfair_lato' === $font_selection ) {
	$heading_font = 'Playfair Display';
	$body_font = 'Lato';
} elseif ( 'opensans_gentiumbasic' === $font_selection ) {
	$heading_font = 'Open Sans';
	$body_font = 'Gentium Basic';
} elseif ( 'archivoblack_tenorsans' === $font_selection ) {
	$heading_font = 'Archivo Black';
	$body_font = 'Tenor Sans';
} elseif ( 'rubik_robotomono' === $font_selection ) {
	$heading_font = 'Rubik';
	$body_font = 'Roboto Mono';
} elseif ( 'ovo_muli' === $font_selection ) {
	$heading_font = 'Ovo';
	$body_font = 'Muli';
} elseif ( 'opensanscondensed_lora' === $font_selection ) {
	$heading_font = 'Open Sans Condensed';
	$body_font = 'Lora';
} elseif ( 'nixieone_librebaskerville' === $font_selection ) {
	$heading_font = 'Nixie One';
	$body_font = 'Libre Baskerville';
} else {
	$heading_font = 'Playfair Display';
	$body_font = 'Lato';
}
?>
<style type="text/css">
	body, button, input, select, optgroup, textarea {
		font-family: '<?php echo $body_font; ?>', Arial, Verdana, sans-serif;
	}
	h1, h2, h3, h4, h5, h6 {
		font-family: '<?php echo $heading_font; ?>', Cambria, 'Hoefler Text', Utopia, 'Liberation Serif', 'Nimbus Roman No9 L Regular', Times, 'Times New Roman', serif;
	}
</style>

<?php wp_footer(); ?>
</body>
</html>
