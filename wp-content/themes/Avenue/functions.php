<?php

include 'theme_options.php';
include 'guide.php';
include 'lib/post-types.php';
include 'lib/metabox.php';
include 'lib/drop-down-taxonomy.php'; 
include 'lib/radio-taxonomy.php'; 

/* SIDEBARS */
if ( function_exists('register_sidebar') )

	register_sidebar(array(
	'name' => 'Sidebar',
    'before_widget' => '<li class="sidebox %2$s">',
    'after_widget' => '</li>',
	'before_title' => '<h3 class="sidetitl">',
    'after_title' => '</h3>',
	
    ));
	register_sidebar(array(
	'name' => 'Footer',
    'before_widget' => '<li class="botwid">',
    'after_widget' => '</li>',
	'before_title' => '<h3 class="bothead">',
    'after_title' => '</h3>',
    ));		
	
	

/* CUSTOM MENUS */	

register_nav_menus( array(
		'primary' => __( 'Primary Navigation', '' ),
	) );

function fallbackmenu(){ ?>
			<div id="submenu">
				<ul><li> Go to Adminpanel > Appearance > Menus to create your menu. You should have WP 3.0+ version for custom menus to work.</li></ul>
			</div>
<?php }	


/* CUSTOM EXCERPTS */
	
function wpe_excerptlength_index($length) {
    return 70;
}	

function wpe_excerptlength_archive($length) {
    return 40;
}

function wpe_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}


/* FEATURED THUMBNAILS */

if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'property_poster', 100, 80, true );
}

/* GET THUMBNAIL URL */
function get_image_url(){
	$image_id = get_post_thumbnail_id();
	$image_url = wp_get_attachment_image_src($image_id,'large');
	$image_url = $image_url[0];
	echo $image_url;
	}	


/* PAGE NAVIGATION */
function getpagenavi(){
?>
<div id="navigation">
<?php if(function_exists('wp_pagenavi')) : ?>
<?php wp_pagenavi() ?>
<?php else : ?>
        <div class="alignleft"><?php next_posts_link(__('&laquo; Older Entries','web2feel')) ?></div>
        <div class="alignright"><?php previous_posts_link(__('Newer Entries &raquo;','web2feel')) ?></div>
        <div class="clear"></div>
<?php endif; ?>

</div>
<?php
}



// Add to admin_init function
add_filter('manage_edit-listings_columns', 'add_new_listings_columns');

	function add_new_listings_columns($listings_columns) {
		$new_columns['cb'] = '<input type="checkbox" />';
 		$new_columns['title'] = _x('Property name', 'column name');
		$new_columns['thumbnail'] = __('Thumbnail');
		$new_columns['price'] = __('Price');
		$new_columns['type'] = __('Property type');
		$new_columns['location'] = __('Location');		
 		$new_columns['date'] = _x('Date', 'column name');
 		return $new_columns;
	
	}
	
add_action('manage_listings_posts_custom_column', 'manage_movies_columns', 10, 2);
 
function manage_movies_columns($column_name, $id) {
		global $post;
		switch ($column_name) {
		case 'id':
			echo $id;
		break;
 
		case 'thumbnail':
			echo get_the_post_thumbnail( $post->ID, 'property_poster' ); 
		break;
			
		case 'price':
			$price = get_post_meta( $post->ID, 'wtf_price', true );
			echo $price;
		break;
		
		case 'location':
			$post_type = get_post_type($post_id);
			$terms = get_the_terms($post_id, 'location');
			if ( !empty($terms) ) {
				foreach ( $terms as $term )
            $post_terms[] = "<a href='edit.php?post_type=listings&location={$term->slug}'> " . esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
				echo join( ', ', $post_terms );
			}
			else echo '<i>No terms.</i>'; 
		break;
		
		case 'type':
			//echo get_the_term_list( $post->ID, 'property', '', ' ', '' );
			$post_type = get_post_type($post_id);
			$terms = get_the_terms($post_id, 'property');
			if ( !empty($terms) ) {
				foreach ( $terms as $term )
            $post_terms[] = "<a href='edit.php?post_type=listings&property={$term->slug}'> " . esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
				echo join( ', ', $post_terms );
			}
			else echo '<i>No terms.</i>'; 
		break;
		
		default:
		
		break;
		} // end switch
	}	

/* Flush your rewrite rules */
function avenue_flush_rewrite_rules() {
	global $pagenow, $wp_rewrite;
	if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
		$wp_rewrite->flush_rules();
}
	
add_action( 'load-themes.php', 'avenue_flush_rewrite_rules' );
	
/* WP 3.4 custom query pagination fix */

function my_query_for_homepage( $query ) {
if( $query->is_main_query() && $query->is_home() ) {
$query->set( 'post_type', array( 'listings' ) );
}
}
add_action( 'pre_get_posts', 'my_query_for_homepage' ); 	
	
?>