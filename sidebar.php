<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Malik
 */

if ( ! is_active_sidebar( 'primary-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area primary-sidebar">
	<?php dynamic_sidebar( 'primary-sidebar' ); ?>
</aside><!-- #secondary -->
