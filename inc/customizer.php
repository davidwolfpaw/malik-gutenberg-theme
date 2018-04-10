<?php
/**
 * Malik Theme Customizer
 *
 * @package Malik
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function malik_customize_register( $wp_customize ) {
	// Change some setting defaults.
	$wp_customize->get_setting( 'blogname' )->transport            = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport     = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport    = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->default      = '#1D2731';
	$wp_customize->get_setting( 'background_color' )->transport    = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->default      = '#FFFFFF';

	$wp_customize->remove_section( 'custom-header' );

    // Text color
    $wp_customize->add_setting( 'text_color', array(
      'default'   => '#1D2731',
      'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
      'section' => 'colors',
      'label'   => esc_html__( 'Text Color', 'malik' ),
    ) ) );

    // Accent Text color
    $wp_customize->add_setting( 'accent_text_color', array(
      'default'   => '#808182',
      'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_text_color', array(
      'section' => 'colors',
      'label'   => esc_html__( 'Accent Text Color', 'malik' ),
    ) ) );

    // Accent color
    $wp_customize->add_setting( 'accent_color', array(
      'default'   => '#EF5656',
      'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
      'section' => 'colors',
      'label'   => esc_html__( 'Accent Color', 'malik' ),
    ) ) );

    // Header & Footer color
    $wp_customize->add_setting( 'header_footer_color', array(
      'default'   => '#0B3C5D',
      'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_footer_color', array(
      'section' => 'colors',
      'label'   => esc_html__( 'Header Menu & Footer Color', 'malik' ),
    ) ) );

    // Link Color
    $wp_customize->add_setting( 'link_color', array(
      'default'   => '#328CC1',
      'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
      'section' => 'colors',
      'label'   => esc_html__( 'Link Color', 'malik' ),
    ) ) );

    // Link Active/Hover/Focus Color
    $wp_customize->add_setting( 'link_active_color', array(
      'default'   => '#0B3C5D',
      'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_active_color', array(
      'section' => 'colors',
      'label'   => esc_html__( 'Link Active/Hover/Focus Color', 'malik' ),
    ) ) );


	// Section: Malik Options.
	$wp_customize->add_section( 'malik_theme_settings', array(
		'priority'       => 40,
		'title'          => __( 'Malik Theme Settings', 'malik' ),
		'description'    => __( 'Settings specific to the Malik theme.', 'malik' ),
		'capability'     => 'edit_theme_options',
	) );

	// Setting: Header Location.
	$wp_customize->add_setting( 'header_location', array(
		'default'    => 'top',
		'transport'  => 'refresh',
		'capability' => 'edit_theme_options',
	) );

	// Control: Header Location.
	$wp_customize->add_control( 'header_location_control', array(
		'label'       => __( 'Header Location', 'malik' ),
		'description' => __( 'Choose whether to place the site header at the top or side of the page.<br /> <strong>Header will always display on top on mobile</strong>', 'malik' ),
		'section'     => 'malik_theme_settings',
		'type'        => 'radio',
		'choices'     => array(
			'top'  => 'Top of page',
			'side' => 'Side of page',
		),
		'settings'    => 'header_location',
	) );

	// Setting: Hide Header on Scroll.
	$wp_customize->add_setting( 'hide_header', array(
		'default'           => true,
		'sanitize_callback' => 'malik_sanitize_checkbox',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	) );

	// Control: Hide Header on Scroll.
	$wp_customize->add_control( 'hide_header_control', array(
		'label'       => __( 'Hide Header on Scroll', 'malik' ),
		'description' => __( 'Hide the header (logo, site title, header sidebar) on scroll.', 'malik' ),
		'section'     => 'malik_theme_settings',
		'type'        => 'checkbox',
		'settings'    => 'hide_header',
	) );

	// Setting: Hide Header Menu on Scroll.
	$wp_customize->add_setting( 'hide_header_menu', array(
		'default'           => true,
		'sanitize_callback' => 'malik_sanitize_checkbox',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	) );

	// Control: Hide Header Menu on Scroll.
	$wp_customize->add_control( 'hide_header_menu_control', array(
		'label'       => __( 'Hide Header Menu on Scroll', 'malik' ),
		'description' => __( 'Hide the header menu on scroll.', 'malik' ),
		'section'     => 'malik_theme_settings',
		'type'        => 'checkbox',
		'settings'    => 'hide_header_menu',
	) );

	// Setting: Font Pairing.
	$wp_customize->add_setting( 'font_pairing', array(
		'default'    => 'playfair_lato',
		'transport'  => 'refresh',
		'capability' => 'edit_theme_options',
	) );

	// Control: Font Pairing.
	$wp_customize->add_control( 'font_pairing_control', array(
		'label'       => __( 'Font Pairing', 'malik' ),
		'description' => __( 'Pairings of fonts for headings and body content.', 'malik' ),
		'section'     => 'malik_theme_settings',
		'type'        => 'select',
		'choices'     => array(
			'playfair_lato'  => 'Playfair Display / Lato',
			'opensans_gentiumbasic' => 'Open Sans / Gentium Basic',
			'archivoblack_tenorsans' => 'Archivo Black / Tenor Sans',
			'rubik_robotomono' => 'Rubik / Roboto Mono',
			'ovo_muli' => 'Ovo / Muli',
			'opensanscondensed_lora' => 'Open Sans Condensed / Lora',
			'nixieone_librebaskerville' => 'Nixie One / Libre Baskerville',
		),
		'settings'    => 'font_pairing',
	) );

	// Setting: Night Mode.
	$wp_customize->add_setting( 'night_mode', array(
		'default'           => true,
		'sanitize_callback' => 'malik_sanitize_checkbox',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	) );

	// Control: Night Mode.
	$wp_customize->add_control( 'night_mode_control', array(
		'label'       => __( 'Night Mode', 'malik' ),
		'description' => __( 'Allow a night mode setting to be active for visitors to your site to change to a darker page style.', 'malik' ),
		'section'     => 'malik_theme_settings',
		'type'        => 'checkbox',
		'settings'    => 'night_mode',
	) );

	// Setting: Read Time.
	$wp_customize->add_setting( 'read_time', array(
		'default'           => true,
		'sanitize_callback' => 'malik_sanitize_checkbox',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	) );

	// Control: Read Time.
	$wp_customize->add_control( 'read_time_control', array(
		'label'       => __( 'Read Time', 'malik' ),
		'description' => __( 'Display an estimate of time to read posts.', 'malik' ),
		'section'     => 'malik_theme_settings',
		'type'        => 'checkbox',
		'settings'    => 'read_time',
	) );

	// Setting: Article Progression Bar.
	$wp_customize->add_setting( 'progression_bar', array(
		'default'           => true,
		'sanitize_callback' => 'malik_sanitize_checkbox',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	) );

	// Control: Article Progression Bar.
	$wp_customize->add_control( 'progression_bar_control', array(
		'label'       => __( 'Article Progression Bar', 'malik' ),
		'description' => __( 'Display a progression bar for post length.', 'malik' ),
		'section'     => 'malik_theme_settings',
		'type'        => 'checkbox',
		'settings'    => 'progression_bar',
	) );

	// Setting: Author Info.
	$wp_customize->add_setting( 'author_info', array(
		'default'           => true,
		'sanitize_callback' => 'malik_sanitize_checkbox',
		'transport'         => 'refresh',
		'capability'        => 'edit_theme_options',
	) );

	// Control: Author Info.
	$wp_customize->add_control( 'author_info_control', array(
		'label'       => __( 'Author Info', 'malik' ),
		'description' => __( 'Display author information on posts.', 'malik' ),
		'section'     => 'malik_theme_settings',
		'type'        => 'checkbox',
		'settings'    => 'author_info',
	) );


	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'malik_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'malik_customize_partial_blogdescription',
		) );
	}

}
add_action( 'customize_register', 'malik_customize_register' );

/**
 * Sanitize checkbox callbacks
 *
 * @return checked
 */
function malik_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function malik_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function malik_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function malik_customize_preview_js() {
	wp_enqueue_script( 'malik-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'customize-preview' ), '20180405', true );
}
add_action( 'customize_preview_init', 'malik_customize_preview_js' );

/**
 * Apply customizer colors
 */
function malik_customizer_css() {
    ?>
    <style type="text/css">
		.site-header-top, #secondary.primary-sidebar { background-color: #<?php echo get_theme_mod( 'background_color' ); ?>; }
        body, button, input, select, optgroup, textarea, h1, h2, h3, h4, h5, h6, .wp-block-pullquote { color: <?php echo get_theme_mod( 'text_color' ); ?>; }
		.entry-footer, .wp-block-image figcaption, .wp-block-pullquote > cite, .wp-block-latest-posts__post-date { color: <?php echo get_theme_mod( 'accent_text_color' ); ?>; }
		hr,	hr.wp-block-separator, .wp-block-button .wp-block-button__link {	background-color: <?php echo get_theme_mod( 'accent_color' ); ?>; }
		.comment-navigation, .posts-navigation, .post-navigation, .entry-footer, .author-info, .wp-block-separator { border-bottom-color: <?php echo get_theme_mod( 'accent_color' ); ?>; }
		.wp-block-pullquote { border-top-color: <?php echo get_theme_mod( 'accent_color' ); ?>; border-bottom-color: <?php echo get_theme_mod( 'accent_color' ); ?>; }
		.site-navigation, .site-footer { background-color: <?php echo get_theme_mod( 'header_footer_color' ); ?>; }
		a, a:visited { color: <?php echo get_theme_mod( 'link_color' ); ?>; }
		a:hover, a:focus, a:active { color: <?php echo get_theme_mod( 'link_active_color' ); ?>; }
    </style>
    <?php
}
add_action( 'wp_head', 'malik_customizer_css' );
