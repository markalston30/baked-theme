<?php

/*===========================================
=            Load Theme Defaults            =
===========================================*/

/**
 *
 * Set default author box gravatar size
 *
 * @since 1.0.0
 *
 */

add_filter( 'genesis_author_box_gravatar_size', 'bk_author_box_gravatar_size' );
function bk_author_box_gravatar_size( $size ) {

	return '150';

}

/**
 *
 * Limit the depth of primary and secondary navigations to 4 levels
 *
 * @since 1.0.0
 *
 */

add_filter( 'wp_nav_menu_args', 'bk_nav_menu_args' );
function bk_nav_menu_args( $args ) {

	if ( $args['theme_location'] == 'primary' || $args['theme_location'] == 'secondary' )
		$args['depth'] = 4;

	return $args;

}

/**
 *
 * Unregister parent page templates
 *
 * @since 1.0.0
 *
 */
add_filter( 'theme_page_templates', 'bk_remove_page_templates' );
function bk_remove_page_templates( $templates ) {

	unset( $templates['page_blog.php'] ); /* Default Blog Page Template */

	return $templates;

}

/**
 *
 * Reposition the default location of the secondary navigation to be at the top
 *
 * @since 1.0.0
 *
 */
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before', 'genesis_do_subnav' );
