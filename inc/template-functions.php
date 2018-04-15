<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Malik
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function malik_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	// Adds a class of header-side if that option is active.
	if ( 'side' === get_theme_mod( 'header_location' ) ) {
		$classes[] = 'header-side';
	}

	return $classes;
}
add_filter( 'body_class', 'malik_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function malik_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'malik_pingback_header' );

/**
 * Calculate the time difference - a replacement for `human_time_diff()` until it is improved.
 *
 * Taken from the Genesis Framework
 * Based on BuddyPress function `bp_core_time_since()`, which in turn is based on functions created by
 * Dunstan Orchard - http://1976design.com
 *
 * This function will return an text representation of the time elapsed since a
 * given date, giving the two largest units e.g.:
 *
 *  - 2 hours and 50 minutes
 *  - 4 days
 *  - 4 weeks and 6 days
 *
 * @since 1.7.0
 *
 * @param int      $older_date     Unix timestamp of date you want to calculate the time since for`.
 * @param int|bool $newer_date     Optional. Unix timestamp of date to compare older date to. Default false (current time).
 * @param int      $relative_depth Optional, how many units to include in relative date. Default 2.
 * @return string The time difference between two dates.
 */
function malik_human_time_diff( $older_date, $newer_date = false, $relative_depth = 2 ) {

	// If no newer date is given, assume now.
	$newer_date = $newer_date ? $newer_date : time();

	// Difference in seconds.
	$since = absint( $newer_date - $older_date );

	if ( ! $since ) {
		return '0 ' . _x( 'seconds', 'time difference', 'malik' );
	}

	// Hold units of time in seconds, and their pluralised strings (not translated yet).
	$units = array(
		/* translators: %s: Number of year(s). */
		array( 31536000, _nx_noop( '%s year', '%s years', 'time difference', 'malik' ) ),  // 60 * 60 * 24 * 365
		/* translators: %s: Number of month(s). */
		array( 2592000, _nx_noop( '%s month', '%s months', 'time difference', 'malik' ) ), // 60 * 60 * 24 * 30
		/* translators: %s: Number of week(s). */
		array( 604800, _nx_noop( '%s week', '%s weeks', 'time difference', 'malik' ) ),    // 60 * 60 * 24 * 7
		/* translators: %s: Number of day(s). */
		array( 86400, _nx_noop( '%s day', '%s days', 'time difference', 'malik' ) ),       // 60 * 60 * 24
		/* translators: %s: Number of hour(s). */
		array( 3600, _nx_noop( '%s hour', '%s hours', 'time difference', 'malik' ) ),      // 60 * 60
		/* translators: %s: Number of minute(s). */
		array( 60, _nx_noop( '%s minute', '%s minutes', 'time difference', 'malik' ) ),
		/* translators: %s: Number of second(s). */
		array( 1, _nx_noop( '%s second', '%s seconds', 'time difference', 'malik' ) ),
	);

	// Build output with as many units as specified in $relative_depth.
	$relative_depth = (int) $relative_depth ? (int) $relative_depth : 2;

	$i = 0;

	$counted_seconds = 0;

	$date_partials = array();

	while ( count( $date_partials ) < $relative_depth && $i < count( $units ) ) {
		$seconds = $units[ $i ][0];
		if ( ( $count = floor( ( $since - $counted_seconds ) / $seconds ) ) != 0 ) {
			$date_partials[]  = sprintf( translate_nooped_plural( $units[ $i ][1], $count, 'malik' ), $count );
			$counted_seconds += $count * $seconds;
		}
		$i++;
	}

	if ( empty( $date_partials ) ) {
		$output = '';
	} elseif ( 1 === count( $date_partials ) ) {
		$output = $date_partials[0];
	} else {

		// Combine all but last partial using commas.
		$output = implode( ', ', array_slice( $date_partials, 0, -1 ) );

		// Add 'and' separator.
		$output .= ' ' . _x( 'and', 'separator in time difference', 'malik' ) . ' ';

		// Add last partial.
		$output .= end( $date_partials );
	}

	return $output;

}
