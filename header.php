<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Malik
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site site-wrap">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'malik' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-header-top">
			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
				?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );

				if ( $description || is_customize_preview() ) :
				?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif;
				?>
			</div><!-- .site-branding -->

			<?php
			if ( true === get_theme_mod( 'night_mode' ) ) :
			?>
			<div class="site-options">
				<div id="night-mode"><span class="fas fa-moon"></span></div>
			</div><!-- .site-options -->
			<?php
			endif;
			?>

			<?php
			if ( is_active_sidebar( 'header-right' ) ) :
			?>
				<aside id="secondary" class="widget-area header-right-sidebar">
					<?php dynamic_sidebar( 'header-right' ); ?>
				</aside><!-- #secondary -->
			<?php
			endif;
			?>
		</div>

		<nav id="main-navigation" class="site-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="menu-icon fas fa-bars"></span> <?php esc_html_e( 'Menu', 'malik' ); ?></button>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
				) );
			?>
		</nav><!-- #main-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
