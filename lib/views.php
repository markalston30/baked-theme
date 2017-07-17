<?php

/**
 * Display Featured Image on top of the post.
 *
 * @since  1.0.0
 * @access public https://benweiser.com/how-to-add-a-full-width-image-above-page-content-in-genesis/
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