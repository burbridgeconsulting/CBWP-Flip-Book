<?php        
if ( !class_exists( "cbwp_CustomPostTypes" ) ) {
	class cbwp_CustomPostTypes {
     
        function __construct() {

            function register_flipbook_type() {
            	/**
            	 * Register a custom post type
            	 * 
            	 */                    

                $labels = array(
                 'name' => _x('Flip Book', 'Flip Book Spreads'),
                 'singular_name' => _x('Spread', 'Spread'),
                 'add_new' => _x('Add Spread', 'spread'),
                 'add_new_item' => __('Add New Spread'),
                 'edit_item' => __('Edit Spread'),
                 'new_item' => __('New Spread'),
                 'view_item' => __('View Spreads'),
                 'search_items' => __('Search Spreads'),
                 'not_found' =>  __('No spreads found'),
                 'not_found_in_trash' => __('No spreads found in Trash'), 
                 'parent_item_colon' => ''  
                );         

            	// menu_position notes:
            	// 	5 - below Posts
            	// 	10 - below Media
            	// 	20 - below Pages
            	// 	60 - below first separator
            	// 	100 - below second separator	

            	register_post_type('flipbook', array( 
            		'labels' => $labels,
            		'description' => __('The flipbook.'),
            		'public' => false,
            		// 'rewrite'=> array('slug' => ''),	// *** Here, also note any prepending
            		'exclude_from_search' => false,
            		'publically_queryable' => false,
            		'show_ui' => true,
            		'menu_position' => 4,  // See menu position notes above
					'menu_icon' => plugins_url( basename( dirname( __FILE__ ) ) ) . "/images/book-open-text-image.png",
            		'show_in_nav_menus' => false,
            		'hierarchal' => false,
            		'supports' => array(
            			'title',
            			// 'editor',
            			// 'comments',
            			// 'revisions',
            			// 'trackbacks',
            			// 'author',
            			// 'excerpt',
                        'page-attributes',
            			// 'thumbnail',
            			// 'custom-fields'
            		),
            		// 'taxonomies' => array(
            		// 	'home_page-type'
            		// ),
            		'capability_type' => 'post',
            		// 'capabilities' => array(
            			// for fine grained control include valid capabilities here
            			// if left empty 'capability_type' will define editing capability requirements
            		// ),
            	));
            	
            	// ***** Add Option to Set Cover Image *****//
                include('cover_image_ui.class.php');
                $coverImg = new cbwp_Options(); 
            	
            	
            }
            add_action('init', 'register_flipbook_type');                    

        }
    }
}    
