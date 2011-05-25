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
            	'id' => $prefix . 'home-page-r1b1',  
            	'title' => 'Home Page, Row 1, Box 1',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'tinymce-r1b1',
            			'type' => 'ckedit',
            			'std' => '',
            			'img' => 'r1b1.jpg',
            		)
            	)
            );

            $meta_boxes[] = array(
            	'id' => $prefix . 'home-page-r1b2',
            	'title' => 'Home Page, Row 1, Box 2',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'tinymce-r1b2',
            			'type' => 'ckedit',
            			'img' => 'r1b2.jpg',
            			'std' => ''
            		)
            	)
            );

            $meta_boxes[] = array(
            	'id' => $prefix . 'home-page-r2b1',
            	'title' => 'Home Page, Row 2, Box 1',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'image-r2b1',
            			'type' => 'image',
            			'img' => 'r2b1.jpg',
            			'std' => ''
            		)
            	)
            );

            $meta_boxes[] = array(
            	'id' => $prefix . 'home-page-r2b2',
            	'title' => 'Home Page, Row 2, Box 2',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'tinymce-r2b2',
            			'type' => 'ckedit',
            			'img' => 'r2b2.jpg',
            			'std' => ''
            		),
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'image-r2b2',
            			'type' => 'image',
            			'std' => ''
            		),
            		array(
            			'name' => 'URL',
            			'desc' => '',
            			'id' => $prefix . 'text-r2b2-url',
            			'type' => 'text',
            			'std' => 'http://'
            		)
            	)
            );

            $meta_boxes[] = array(
            	'id' => $prefix . 'home-page-r2b3',
            	'title' => 'Home Page, Row 2, Box 3',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'image-r2b3',
            			'type' => 'image',
            			'img' => 'r2b3.jpg',
            			'std' => ''
            		)
            	)
            );

            $meta_boxes[] = array(
            	'id' => $prefix . 'home-page-r3b1',
            	'title' => 'Home Page, Row 3, Box 1',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'tinymce-r3b1',
            			'type' => 'ckedit',
            			'img' => 'r3b1.jpg',
            			'std' => ''
            		),
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'image-r3b1',
            			'type' => 'image',
            			'img' => '',
            			'std' => ''
            		),
            		array(
            			'name' => 'URL',
            			'desc' => '',
            			'id' => $prefix . 'text-r3b1-url',
            			'type' => 'text',
            			'std' => 'http://'
            		)
            	)
            );

            $meta_boxes[] = array(
            	'id' => $prefix . 'home-page-r3b2',
            	'title' => 'Home Page, Row 3, Box 2',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'image-r3b2',
            			'type' => 'image',
            			'img' => 'r3b2.jpg',
            			'std' => ''
            		)
            	)
            );

            $meta_boxes[] = array(
            	'id' => $prefix . 'home-page-r3b3',
            	'title' => 'Home Page, Row 3, Box 3',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'tinymce-r3b3',
            			'type' => 'ckedit',
            			'img' => 'r3b3.jpg',
            			'std' => ''
            		),
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'image-r3b3',
            			'type' => 'image',
            			'img' => '',
            			'std' => ''
            		),
            		array(
            			'name' => 'URL',
            			'desc' => '',
            			'id' => $prefix . 'text-r3b3-url',
            			'type' => 'text',
            			'std' => 'http://'
            		)
            	)
            );

            $meta_boxes[] = array(
            	'id' => $prefix . 'home-page-happenings',  
            	'title' => 'Home Page Happenings',
            	'pages' => array('magazine'),
            	'context' => 'normal',
            	'priority' => 'high',
            	'fields' => array(
            		array(
            			'name' => '',
            			'desc' => '',
            			'id' => $prefix . 'tinymce-happenings',
            			'type' => 'ckedit',
            			'std' => '',
            			'img' => 'happenings.jpg',
            		)
            	)
            );
            
            require_once('lib/meta_box.class.php');
            foreach ($meta_boxes as $meta_box) {
            	$my_box = new CBQC_MetaBox($meta_box);
            }

        }
    }
}    
