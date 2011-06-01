<?php
if ( !class_exists( "CBQC_MagazineExtraFields" ) ) {
	class CBQC_MagazineExtraFields {
     
        function __construct() {

            /*** If you are using CKEDit boxes, please use the following lines to activate it ***/
            function ckedit_scripts() {     
                $plugin_url = plugins_url();  // Should really somehow use the version from the class, oh well
            	wp_enqueue_script('ckedit', $plugin_url . '/cbqc_magazine/ckedit/ckeditor.js', array('jquery'), null, false);
            	wp_enqueue_script('ckedit-jq-adapter', $plugin_url . '/cbqc_magazine/ckedit/adapters/jquery.js', array('ckedit'), null, false);
            	wp_enqueue_script('ckedit-loader', $plugin_url . '/cbqc_magazine/ckedit/load-ckedit.js', array('ckedit','ckedit-jq-adapter'), null, false);
            }
            add_action('init', 'ckedit_scripts'); 

            /* Declare a set of easy functions for outputting the values, once they have been stored */
            function  cbqc_show($field, $id = NULL) {  
            	if ($id == NULL) {
            		global $post;
            		$id = $post->ID;
            	}
            	$is_single = true;
            	$value = get_post_meta($id, $field, $is_single);
            	echo $value;
            }  

            function  cbqc_get($field, $id = NULL) {            
            	global $post;
            	if ($id == NULL) {
            		global $post;
            		$id = $post->ID;
            	}
            	$is_single = true;
            	$value = get_post_meta($id, $field, $is_single);
            	return $value;
            }  

            function  cbqc_get_image($field, $id = NULL) {            
            	global $post;
            	if ($id == NULL) {
            		global $post;
            		$id = $post->ID;
            	}
            	$is_single = true;
            	$value = get_post_meta($id, $field, $is_single);
            	return "<img src='$value' />";
            }  

            /******************************

            Edit meta box settings here

            ******************************/

            $prefix = 'cbqc_';

            $meta_boxes = array();

            // ***** Magazine Spread Boxes *****

            $meta_boxes[] = array(
            	'id' => $prefix . 'spread-left-page',
            	'title' => 'Left Page',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'side_note' => 'Leave blank if you don\'t want text on this page.',
            			'bottom_note' => '',
            			'id' => $prefix . 'main-text-left',
            			'type' => 'ckedit',
            			'name' => 'Main Text',
            			'std' => ''
            		),
                    array(
                        'name' => 'Image',
            			'side_note' => '',
                        'bottom_note' => 'asdf',
                        'id' => $prefix . 'image-left',
                        'type' => 'image',
                        'std' => ''
                    ),
        		array(
        			'name' => '',
        			'side_note' => '',
        			'bottom_note' => '',
        			'id' => $prefix . 'popup-text-left',
        			'type' => 'text',
        			'img' => 'r2b2.jpg',
        			'std' => ''
        		),
            	)
            );


            require_once('lib/meta_box.class.php');
            foreach ($meta_boxes as $meta_box) {
            	$my_box = new CBQC_MetaBox($meta_box);
            }

        }
    }
}    
