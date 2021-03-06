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
 * Start the Genesis engine
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
 * Register custom image sizes for the theme.
 *
 * @since 1.0.0
 *
 */
add_image_size( 'bk-large',     1170, 617, true );
add_image_size( 'bk-medium',     768, 405, true );
add_image_size( 'bk-small',      320, 169, true );
add_image_size( 'bk-grid',       580, 460, true );
add_image_size( 'bk-gridlarge', 1170, 800, true );
add_image_size( 'bk-vertical',  1000, 1477, true );

/**
 *
 * Apply custom body classes
 *
 * @since 1.0.0
 * @uses /lib/classes.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/classes.php' );

/**
 *
 * Apply Theme defaults (overrides default Genesis settings)
 *
 * @since 1.0.0
 * @uses /lib/defaults.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/defaults.php' );

/**
 *
 * Apply Theme default attributes
 *
 * @since 1.0.0
 * @uses /lib/attributes.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/attributes.php' );
/**
 *
 * Apply Theme widgets
 *
 * @since 1.0.0
 * @uses /lib/attributes.php
 *
 */
include_once( get_stylesheet_directory() . '/lib/widget-areas.php' );

/**
 * Display Featured Image on top of the post.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
 
// Create new image size for our hero image
add_image_size( 'hero-image', 1400, 400, TRUE ); // creates a hero image size
 
// Hook after header area
add_action( 'genesis_after_header', 'bw_hero_image' );

function bw_hero_image() {
// If it is a page and has a featured thumbnail, but is not the front page do the following...
    if (has_post_thumbnail() && is_singular() ) {
    	// Get hero image and save in variable called $background
    	$image_desktop = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), 'hero-image' );
    	$image_tablet = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), 'large' );
    	$image_mobile = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), 'medium' );

    	$bgdesktop = $image_desktop[0];
        $bgtablet = $image_tablet[0];
        $bgmobile = $image_mobile[0];

// You can change above-post-hero to any class you want and adjust CSS styles
    	$featured_class = 'above-post-hero';

 ?> 
<div class='<?php echo $featured_class; ?>'></div>
<style>
	<?php echo ".$featured_class "; ?> {background-image:url( <?php echo $bgmobile; ?>);height:376px;}
		
		@media only screen and (min-width : 480px) {       
        <?php echo ".$featured_class "; ?> {background-image:url(<?php echo $bgtablet;?>);height:576px;}
		}

		@media only screen and (min-width : 992px) {       
        <?php echo ".$featured_class "; ?> {background-image:url(<?php echo $bgdesktop;?>);height:776px;}
		}
</style>
<?php

    } 
}

/**
 * Display related items to bottom of the post.
 *
 * @since  1.0.0
 * @access public@url https://designsbynickthegeek.com/tutorials/related-posts-genesis
 * @global object $post 
 */
add_image_size( 'related', 490, 490, true ); /* Display Featured Image on top of the post for related NOTE: move and change taxonomy source:https://designsbynickthegeek.com/tutorials/related-posts-genesis.*/
//for HTML5 themes
add_action( 'genesis_after_entry_content', 'child_related_posts' );
/**
 * Outputs related posts with thumbnail
 * 
 * @author Nick the Geek
 * @url https://designsbynickthegeek.com/tutorials/related-posts-genesis
 * @global object $post 
 */
function child_related_posts() {
     
    if ( is_single ( ) ) {
         
        global $post;
 
        $count = 2;
        $postIDs = array( $post->ID );
        $related = '';
        $tags = wp_get_post_tags( $post->ID );
        $cats = wp_get_post_categories( $post->ID );
         
        if ( $tags ) {
             
            foreach ( $tags as $tag ) {
                 
                $tagID[] = $tag->term_id;
                 
            }
             
            $args = array(
                'tag__in'               => $tagID,
                'post__not_in'          => $postIDs,
                'showposts'             => 5,
                'ignore_sticky_posts'   => 1,
                'tax_query'             => array(
                    array(
                                        'taxonomy'  => 'post_format',
                                        'field'     => 'slug',
                                        'terms'     => array( 
                                            'post-format-link', 
                                            'post-format-status', 
                                            'post-format-aside', 
                                            'post-format-quote'
                                            ),
                                        'operator'  => 'NOT IN'
                    )
                )
            );
 
            $tag_query = new WP_Query( $args );
             
            if ( $tag_query->have_posts() ) {
                 
                while ( $tag_query->have_posts() ) {
                     
                    $tag_query->the_post();
 
                    $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'related' ) ) : '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/related.png" alt="' . get_the_title() . '" />';
 
                    $related .= '<li><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . $img . get_the_title() . '</a></li>';
                     
                    $postIDs[] = $post->ID;
 
                    $count++;
                }
            }
        }
 
        if ( $count <= 4 ) {
             
            $catIDs = array( );
 
            foreach ( $cats as $cat ) {
                 
                if ( 3 == $cat )
                    continue;
                $catIDs[] = $cat;
                 
            }
             
            $showposts = 5 - $count;
 
            $args = array(
                'category__in'          => $catIDs,
                'post__not_in'          => $postIDs,
                'showposts'             => $showposts,
                'ignore_sticky_posts'   => 1,
                'orderby'               => 'rand',
                'tax_query'             => array(
                                    array(
                                        'taxonomy'  => 'post_format',
                                        'field'     => 'slug',
                                        'terms'     => array( 
                                            'post-format-link', 
                                            'post-format-status', 
                                            'post-format-aside', 
                                            'post-format-quote' ),
                                        'operator' => 'NOT IN'
                                    )
                )
            );
 
            $cat_query = new WP_Query( $args );
             
            if ( $cat_query->have_posts() ) {
                 
                while ( $cat_query->have_posts() ) {
                     
                    $cat_query->the_post();
 
                    $img = genesis_get_image() ? genesis_get_image( array( 'size' => 'related' ) ) : '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/related.png" alt="' . get_the_title() . '" />';
 
                    $related .= '<li><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . $img . get_the_title() . '</a></li>';
                }
            }
        }
 
        if ( $related ) {
             
            printf( '<div class="related-posts"><h3 class="related-title">Related Posts</h3><ul class="related-list">%s</ul></div>', $related );
         
        }
         
        wp_reset_query();
         
    }
}
