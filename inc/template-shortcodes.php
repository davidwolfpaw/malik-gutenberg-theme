<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Malik
 */

if ( ! function_exists( 'malik_post_date_shortcode' ) ) :
	add_shortcode( 'post_date', 'malik_post_date_shortcode' );
	/**
	 * Produces the date of post publication.
	 *
	 * Supported shortcode attributes are:
	 *   after (output after link, default is empty string),
	 *   before (output before link, default is empty string),
	 *   format (date format, default is value in date_format option field),
	 *   label (text following 'before' output, but before date),
	 *   modified (whether getting original or modified post date, defaults to false).
	 *
	 * Output passes through `malik_post_date_shortcode` filter before returning.
	 *
	 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
	 * @return string Output for `post_date` shortcode.
	 */
	function malik_post_date_shortcode( $atts ) {

		$defaults = array(
			'after'          => '',
			'before'         => '',
			'format'         => get_option( 'date_format' ),
			'label'          => '',
			'modified'       => 'false',
			'relative_depth' => 2,
		);

		$atts = shortcode_atts( $defaults, $atts, 'post_date' );

		// If we're getting the modified date or the original post date.
		if ( 'true' === $atts['modified'] ) {

			if ( 'relative' === $atts['format'] ) {
				$display  = malik_human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ), $atts['relative_depth'] );
				$display .= ' ' . __( 'ago', 'malik' );
			} else {
				$display = get_the_modified_time( $atts['format'] );
			}

			$output = sprintf( '<time itemprop="dateModified" datetime="%s">', get_the_modified_time( 'c' ) ) . $atts['before'] . $atts['label'] . $display . $atts['after'] . '</time>';

		} else {

			if ( 'relative' === $atts['format'] ) {
				$display  = malik_human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ), $atts['relative_depth'] );
				$display .= ' ' . __( 'ago', 'malik' );
			} else {
				$display = get_the_time( $atts['format'] );
			}

			$output = sprintf( '<time itemprop="datePublished" datetime="%s">', get_the_time( 'c' ) ) . $atts['before'] . $atts['label'] . $display . $atts['after'] . '</time>';

		}

		return apply_filters( 'malik_post_date_shortcode', $output, $atts );

	}
endif;


if ( ! function_exists( 'malik_post_time_shortcode' ) ) :
	add_shortcode( 'post_time', 'malik_post_time_shortcode' );
	/**
	 * Produces the time of post publication.
	 *
	 * Supported shortcode attributes are:
	 *   after (output after link, default is empty string),
	 *   before (output before link, default is empty string),
	 *   format (date format, default is value in date_format option field),
	 *   label (text following 'before' output, but before date),
	 *   modified (whether getting original or modified post time, defaults to false).
	 *
	 * Output passes through `malik_post_time_shortcode` filter before returning.
	 *
	 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
	 * @return string Output for `post_time` shortcode`.
	 */
	function malik_post_time_shortcode( $atts ) {

		$defaults = array(
			'after'    => '',
			'before'   => '',
			'format'   => get_option( 'time_format' ),
			'label'    => '',
			'modified' => false,
		);

		$atts = shortcode_atts( $defaults, $atts, 'post_time' );

		if ( true === $atts['modified'] ) {

			$output = sprintf( '<time itemprop="dateModified" datetime="%s">', get_the_modified_time( 'c' ) ) . $atts['before'] . $atts['label'] . get_the_modified_time( $atts['format'] ) . $atts['after'] . '</time>';

		} else {

			$output = sprintf( '<time itemprop="datePublished" datetime="%s">', get_the_time( 'c' ) ) . $atts['before'] . $atts['label'] . get_the_time( $atts['format'] ) . $atts['after'] . '</time>';

		}

		return apply_filters( 'malik_post_time_shortcode', $output, $atts );

	}
endif;


if ( ! function_exists( 'malik_post_modified_date_shortcode' ) ) :
	add_shortcode( 'post_author', 'malik_post_author_shortcode' );
	/**
	 * Produces the author of the post.
	 *
	 * Supported shortcode attributes are:
	 *   after (output after link, default is empty string),
	 *   before (output before link, default is empty string),
	 *   link (none, author page, author archives).
	 *
	 * Output passes through `malik_post_author_shortcode` filter before returning.
	 *
	 * @since 1.1.0
	 *
	 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
	 * @return string Return empty string if post type does not support `author` or post has no author assigned.
	 *                Return `malik_post_author_shortcode()` if author has no URL.
	 *                Otherwise, output for `post_author_link` shortcode.
	 */
	function malik_post_author_shortcode( $atts ) {

		if ( ! post_type_supports( get_post_type(), 'author' ) ) {
			return '';
		}

		$defaults = array(
			'after'  => '',
			'before' => '',
			'url'    => 'author',
		);

		$atts = shortcode_atts( $defaults, $atts, 'post_author_link' );

		$author         = get_the_author();
		$author_url     = get_the_author_meta( 'user_url', get_the_author_meta( 'ID' ) );
		$author_archive = get_author_posts_url( get_the_author_meta( 'ID' ) );

		if ( ! $author ) {
			return '';
		}

		$output  = '<span itemprop="author" itemscope="true" itemtype="https://schema.org/Person">';
		$output .= $atts['before'];
		if ( 'author' === $atts['url'] && ! empty( $author_url ) ) {
			$output .= sprintf( '<a href="%s" itemprop="url" rel="author"><span itemprop="name">%s</span></a>', $author_url, esc_html( $author ) );
		} elseif ( 'archive' === $atts['url'] && ! empty( $author_archive ) ) {
			$output .= sprintf( '<a href="%s" itemprop="url" rel="author"><span itemprop="name">%s</span></a>', $author_archive, esc_html( $author ) );
		} elseif ( 'none' === $atts['url'] ) {
			$output .= sprintf( '<span itemprop="name">%s</span>', esc_html( $author ) );
		} else {
			$output .= sprintf( '<span itemprop="name">%s</span>', esc_html( $author ) );
		}
		$output .= $atts['after'];

		return apply_filters( 'malik_post_author_shortcode', $output, $atts );

	}
endif;


if ( ! function_exists( 'malik_post_comments_shortcode' ) ) :
	add_shortcode( 'post_comments', 'malik_post_comments_shortcode' );
	/**
	 * Produces the link to the current post comments.
	 *
	 * Supported shortcode attributes are:
	 *   after (output after link, default is empty string),
	 *   before (output before link, default is empty string),
	 *   hide_if_off (hide link if comments are off, default is true),
	 *   more (text when there is more than 1 comment, use % character as placeholder
	 *     for actual number, default is '% Comments')
	 *   one (text when there is exactly one comment, default is '1 Comment'),
	 *   zero (text when there are no comments, default is 'Leave a Comment').
	 *
	 * Output passes through `malik_post_comments_shortcode` filter before returning.
	 *
	 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
	 * @return string Return empty string if post does not support `comments`, or `hide_if_off` is enabled and
	 *                comments are closed or disabled in Genesis theme settings.
	 *                Otherwise, output for `post_comments` shortcode.
	 */
	function malik_post_comments_shortcode( $atts ) {

		if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
			return '';
		}

		$defaults = array(
			'after'       => '',
			'before'      => '',
			'hide_if_off' => true,
			'more'        => __( '% Comments', 'malik' ),
			'one'         => __( '1 Comment', 'malik' ),
			'zero'        => __( 'Leave a Comment', 'malik' ),
		);

		$atts = shortcode_atts( $defaults, $atts, 'post_comments' );

		if ( true === $atts['hide_if_off'] && ! comments_open() ) {
			return '';
		}

		// Darn you, WordPress!
		ob_start();
		comments_number( $atts['zero'], $atts['one'], $atts['more'] );
		$comments = ob_get_clean();

		$comments = sprintf( '<a href="%s">%s</a>', get_comments_link(), $comments );

		$output = sprintf( '%s<span class="entry-comments-link">%s</span>%s', $atts['before'], $comments, $atts['after'] );

		return apply_filters( 'malik_post_comments_shortcode', $output, $atts );

	}
endif;


if ( ! function_exists( 'malik_post_tags_shortcode' ) ) :
	add_shortcode( 'post_tags', 'malik_post_tags_shortcode' );
	/**
	 * Produces the tag links list.
	 *
	 * Supported shortcode attributes are:
	 *   after (output after link, default is empty string),
	 *   before (output before link, default is 'Tagged With: '),
	 *   sep (separator string between tags, default is ', ').
	 *
	 * Output passes through `malik_post_tags_shortcode` filter before returning.
	 *
	 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
	 * @return string Return empty string if the `post_tag` taxonomy is not associated with the current post type
	 *                or if the post has no tags. Otherwise, output for `post_tags` shortcode.
	 */
	function malik_post_tags_shortcode( $atts ) {

		if ( ! is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) {
			return '';
		}

		$defaults = array(
			'after'  => '',
			'before' => __( 'Tagged: ', 'malik' ),
			'sep'    => ', ',
		);

		$atts = shortcode_atts( $defaults, $atts, 'post_tags' );

		$tags = get_the_tag_list( $atts['before'], trim( $atts['sep'] ) . ' ', $atts['after'] );

		// Do nothing if no tags.
		if ( ! $tags ) {
			return '';
		}

		$output = '<span class="post-tags">' . $tags . '</span>';

		return apply_filters( 'malik_post_tags_shortcode', $output, $atts );

	}
endif;


if ( ! function_exists( 'malik_post_categories_shortcode' ) ) :
	add_shortcode( 'post_categories', 'malik_post_categories_shortcode' );
	/**
	 * Produces the category links list.
	 *
	 * Supported shortcode attributes are:
	 *   after (output after link, default is empty string),
	 *   before (output before link, default is 'Tagged With: '),
	 *   sep (separator string between tags, default is ', ').
	 *
	 * Output passes through 'malik_post_categories_shortcode' filter before returning.
	 *
	 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
	 * @return string Return empty string if the `category` taxonomy is not associated with the current post type
	 *                or if the post has no categories. Otherwise, output for `post_categories` shortcode.
	 */
	function malik_post_categories_shortcode( $atts ) {

		if ( ! is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			return '';
		}

		$defaults = array(
			'sep'    => ', ',
			'before' => __( 'Filed: ', 'malik' ),
			'after'  => '',
		);

		$atts = shortcode_atts( $defaults, $atts, 'post_categories' );

		$cats = get_the_category_list( trim( $atts['sep'] ) . ' ' );

		// Do nothing if there are no categories.
		if ( ! $cats ) {
			return '';
		}

		$output = $atts['before'] . '<span class="post-categories">' . $cats . '</span>' . $atts['after'];

		return apply_filters( 'malik_post_categories_shortcode', $output, $atts );

	}
endif;

