<?php

/**
 *
 * Custom function for applying common classes to the body tag, depending on the current view
 *
 * @since 1.0.0
 * @author Calvin Koepke
 *
 */

add_filter( 'body_class', 'bk_body_classes' );
function bk_body_classes( $classes ) {

	if ( is_home() )
		$classes[] = 'bk-page-blog';

	if ( is_front_page() )
		$classes[] = 'bk-page-front';

	if ( is_archive() )
		$classes[1] = 'bk-page-archive';

	if ( is_category() )
		$classes[] = 'bk-page-category';

	if ( is_tag() )
		$classes[] = 'bk-page-tag';

	if ( is_search() )
		$classes[] = 'bk-page-search';

	if ( is_page_template() && get_page_template_slug() != false ) {

		$template = basename( get_page_template_slug() );		
		$template_class = str_replace( '.php', '', $template );

		$classes[] = $template_class;
	}

	return $classes;

}