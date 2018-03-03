<?php
/**
 * Malik functions and definitions
 *
 * @package Malik
 */

if ( ! function_exists( 'malik_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function malik_setup() {
		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'malik', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'   => esc_html__( 'Primary', 'malik' ),
			'secondary' => esc_html__( 'Secondary', 'malik' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'malik_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		 * Add support for Gutenberg.
		 *
		 * @link https://wordpress.org/gutenberg/
		 */
		add_theme_support( 'gutenberg', array(
		   'wide-images' => true,
		   'colors' => array(
		        '#EF5656',
		        '#FF9090',
		        '#9C98FF',
		        '#444',
		    )
		) );
	}
endif;
add_action( 'after_setup_theme', 'malik_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function malik_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'malik_content_width', 640 );
}
add_action( 'after_setup_theme', 'malik_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function malik_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'malik' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'malik' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'malik_widgets_init' );

/**
 * Google Fonts
 */
function malik_fonts_url() {
	$fonts_url = '';
	/* Translators: If there are characters in your language that are not
	* supported by Playfair Display, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$font = _x( 'on', 'Playfair Display font: on or off', 'malik' );
	if ( 'off' !== $font ) {
		$font_families = array();
		if ( 'off' !== $font ) {
			// $font_families[] = 'Lora:400,400italic,700,700italic';
			$font_families[] = 'Playfair Display:400,400i,700,700i';
		}
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	return esc_url_raw( $fonts_url );
}

/**
 * Gutenberg Editor Styles
 */
function malik_editor_styles() {
	wp_enqueue_style( 'malik-fonts', malik_fonts_url(), array(), null );
	wp_enqueue_style( 'malik-editor-style', get_template_directory_uri() . '/css/editor-style.css');
}
add_action( 'enqueue_block_editor_assets', 'malik_editor_styles' );

/**
 * Enqueue scripts and styles.
 */
function malik_scripts() {
	wp_enqueue_style( 'malik-fonts', malik_fonts_url(), array(), null );

	// Primary Styles
	wp_enqueue_style( 'malik-style', get_stylesheet_uri(), array( 'malik-fonts' ) );
	// Gutenberg Styles
	wp_enqueue_style( 'malik-gutenberg-style', get_template_directory_uri() . '/css/blocks.css', array( 'malik-style' ) );

	wp_enqueue_script( 'malik-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20180219', true );

	wp_enqueue_script( 'malik-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20180219', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'malik_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

