<?php

/*==================================================
=            Starter Theme Introduction            =
==================================================*/

/**
 *
 * About Starter
 * --------------
 * Starter is a project by Calvin Koepke to create a starter theme for Genesis Framework developers that doesn't over-bloat
 * their starting base. It includes commonly used templates, codes, and styles, along with optional SCSS and Gulp tasking.
 *
 * Credits and Licensing
 * --------------
 * Starter was created by Calvin Koepke, and is under GPL 2.0+.
 *
 * Find me on Twitter: @cjkoepke
 *
 */


/*============================================
=            Begin Functions File            =
============================================*/

/**
 *
 * Define Child Theme Constants
 *
 * @since 1.0.0
 *
 */
define( 'CHILD_THEME_NAME', 'Baked' );
define( 'CHILD_THEME_AUTHOR', 'Bakedpress' );
define( 'CHILD_THEME_AUTHOR_URL', 'http://bakedpress.com/' );
define( 'CHILD_THEME_URL', 'http://bakedpress.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );
define( 'TEXT_DOMAIN', 'baked' );

/** 
 *
Exit if accessed directly.
 *
 * @since 1.0.0
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * Start the engine
 *
 * @since 1.0.0
 *
 */
include_once( get_template_directory() . '/lib/init.php');

/**
 *
 * Load files in the /assets/ directory
 *
 * @since 1.0.0
 *
 */
add_action( 'wp_enqueue_scripts', 'bk_load_assets' );
function bk_load_assets() {

	// Load fonts.
	wp_enqueue_style( 'bk-fonts', '//fonts.googleapis.com/css?family=Poppins:400,700|Brawler', array(), CHILD_THEME_VERSION );

	// Load JS.
	wp_enqueue_script( 'bk-global', get_stylesheet_directory_uri() . '/assets/js/global.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	// Load default icons.
	wp_enqueue_style( 'dashicons' );

	// Load responsive menu.
	//$suffix = defined( SCRIPT_DEBUG ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'bk-responsive-menu', get_stylesheet_directory_uri() . '/assets/js/responsive-menus' . $suffix . '.js', array( 'jquery', 'bk-global' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'bk-responsive-menu',
		'genesis_responsive_menu',
	 	starter_get_responsive_menu_args()
	);

}

/**
 * Add the theme name class to the body element.
 *
 * @since  1.0.0
 *
 * @param  string $classes
 * @return string Modified body classes.
 */

add_filter( 'body_class', 'bk_add_body_class' );
function bk_add_body_class( $classes ) {
	$classes[0] = 'bk';
	return $classes;
}


/**
 * Set the responsive menu arguments.
 *
 * @return array Array of menu arguments.
 *
 * @since 1.1.0
 */
function starter_get_responsive_menu_args() {

	$args = array(
		'mainMenu'         => __( 'Menu', TEXT_DOMAIN ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Menu', TEXT_DOMAIN ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
				'.nav-secondary',
			),
			'others'  => array(
				'.nav-footer',
				'.nav-sidebar',
			),
		),
	);

	return $args;

}

/**
 *
 * Add theme supports
 *
 * @since 1.0.0
 *
 */
add_theme_support( 'genesis-responsive-viewport' ); /* Enable Viewport Meta Tag for Mobile Devices */
add_theme_support( 'html5',  array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) ); /* HTML5 */
add_theme_support( 'genesis-accessibility', array( 'skip-links', 'search-form', 'drop-down-menu', 'headings' ) ); /* Accessibility */
add_theme_support( 'genesis-after-entry-widget-area' ); /* After Entry Widget Area */
add_theme_support( 'genesis-footer-widgets', 3 ); /* Add Footer Widgets Markup for 3 */

/**
 *
 * Unregister layout defaults
 *
 * @since 1.0.0
 *
 */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

/**
 *
 * Load additional helpers and functions 'widgets, classes'
 *
 * @since 1.0.0
 * 
 *
 */
function bk_includes() {
	$includes_dir = trailingslashit( get_stylesheet_directory() ) . 'lib/';
	
// Load everything in the includes library.
	include_once $includes_dir . 'classes.php';
	include_once $includes_dir . 'defaults.php';
	include_once $includes_dir . 'attributes.php';
	include_once $includes_dir . 'widget-areas.php';	
}