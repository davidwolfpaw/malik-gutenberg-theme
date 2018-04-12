/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text Color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	// Background Color.
	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-header-top, #secondary.primary-sidebar' ).css( {
				'background-color': to
			} );
		} );
	} );

	// Text Color.
	wp.customize( 'text_color', function( value ) {
		value.bind( function( to ) {
			$( 'body, button, input, select, optgroup, textarea, h1, h2, h3, h4, h5, h6, .wp-block-pullquote' ).css( {
				'color': to
			} );
		} );
	} );

	// Accent Text Color.
	wp.customize( 'accent_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.entry-footer, .wp-block-image figcaption, .wp-block-pullquote > cite, .wp-block-latest-posts__post-date' ).css( {
				'color': to
			} );
		} );
	} );

	// Accent Color.
	wp.customize( 'accent_color', function( value ) {
		value.bind( function( to ) {
			$( 'hr,	hr.wp-block-separator, .wp-block-button .wp-block-button__link' ).css( {
				'background-color': to
			} );
			$( '.comment-navigation, .posts-navigation, .post-navigation, .entry-footer, .author-info, hr, .wp-block-separator' ).css( {
				'border-bottom-color': to
			} );
			$( '.wp-block-pullquote' ).css( {
				'border-top-color': to,
				'border-bottom-color': to
			} );
		} );
	} );

	// Header & Footer Color.
	wp.customize( 'header_footer_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-navigation, .site-footer' ).css( {
				'background-color': to
			} );
		} );
	} );

	// Link Color.
	wp.customize( 'link_color', function( value ) {
		value.bind( function( to ) {
			$( 'a, a:visited' ).css( {
				'color': to
			} );
			$( '#main-navigation a' ).css( {
				'color': '#FFFFFF'
			} );
			$( '.site-title a' ).css( {
				'color': 'initial'
			} );
			$( '.bar, .wp-block-button .wp-block-button__link' ).css( {
				'background-color': to
			} );
			$( '.bar' ).css( {
				'color': to
			} );
			$( '.wp-block-button .wp-block-button__link' ).css( {
				'color': '#FFFFFF'
			} );
			$( '.wp-block-quote:not(.is-large)' ).css( {
				'border-left-color': to
			} );
		} );
	} );

	// Link Active/Hover/Focus Color.
	wp.customize( 'link_active_color', function( value ) {
		value.bind( function( to ) {
			$( 'a:hover, a:focus, a:active' ).css( {
				'color': to
			} );
			$( '.wp-block-button .wp-block-button__link:hover, .wp-block-button .wp-block-button__link:active, .wp-block-button .wp-block-button__link:focus' ).css( {
				'background-color': to
			} );
			$( '.wp-block-button .wp-block-button__link:hover, .wp-block-button .wp-block-button__link:active, .wp-block-button .wp-block-button__link:focus' ).css( {
				'color': '#FFFFFF'
			} );
		} );
	} );

} )( jQuery );
