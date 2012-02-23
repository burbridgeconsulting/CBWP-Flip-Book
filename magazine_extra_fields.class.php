<?php
if ( !class_exists( "CBQC_MagazineExtraFields" ) ) {
	class CBQC_MagazineExtraFields {
     
        function __construct() {

            /******************************

            Edit meta box settings here

            ******************************/

            $prefix = 'cbqc_';

            $meta_boxes = array();

            // ***** Magazine Spread Boxes *****                             
            
            $meta_boxes[] = array(
                'id' => $prefix . 'instructions',
                'title' => 'Instructions',
                'pages' => array('magazine'),
                'context' => 'normal',
                'priority' => 'high',
                'html' => '<p>Just fill in the boxes you want to have things in.</p>',
                'fields' => array(
                )
            );            

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
            			'type' => 'tinymce',
            			'name' => 'Main Text',
            			'std' => ''
            		),
                    array(
                        'name' => 'Image',
            			'side_note' => 'Upload the image you want, or leave blank if you do not want one.',
                        'bottom_note' => '',
                        'id' => $prefix . 'image-left',
                        'type' => 'image',
                        'std' => ''
                    ),
        		array(
        			'name' => 'Popup Text',
        			'side_note' => 'If you want popup<br/>text, put it here.',
        			'bottom_note' => '',
        			'id' => $prefix . 'popup-text-left',
        			'type' => 'text',
        			'img' => '',
        			'std' => ''
        		),
            	)
            );                  
            
        $meta_boxes[] = array(
        	'id' => $prefix . 'spread-right-page',
        	'title' => 'Right Page',
        	'pages' => array('magazine'),
        	'context' => 'normal',
        	'priority' => 'high',
        	'fields' => array(
        		array(
        			'name' => '',
        			'side_note' => 'Leave blank if you don\'t want text on this page.',
        			'bottom_note' => '',
        			'id' => $prefix . 'main-text-right',
        			'type' => 'tinymce',
        			'name' => 'Main Text',
        			'std' => ''
        		),
                array(
                    'name' => 'Image',
        			'side_note' => 'Upload the image you want, or leave blank if you do not want one.',
                    'bottom_note' => '',
                    'id' => $prefix . 'image-right',
                    'type' => 'image',
                    'std' => ''
                ),
    		array(
    			'name' => 'Popup Text',
    			'side_note' => 'If you want popup<br/>text, put it here.',
    			'bottom_note' => '',
    			'id' => $prefix . 'popup-text-right',
    			'type' => 'text',
    			'img' => '',
    			'std' => ''
    		),
        	)
        );                  


        $meta_boxes[] = array(
            'id' => $prefix . 'toc',
            'title' => 'For Table of Contents',
            'pages' => array('magazine'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
        		array(
        			'name' => 'Section Title',
        			'side_note' => 'This is the title for the section, as will appear in the table of contents.',
        			'bottom_note' => '',
        			'id' => $prefix . 'section-title',
        			'type' => 'text',
        			'label' => 'Section Title',
        			'std' => ''
        		),  
        		array(
        			'name' => 'TOC',
        			'side_note' => 'Check this box if you want this spread to show up in the Table of Contents.',
        			'bottom_note' => '',
        			'id' => $prefix . 'cb-show-in-toc',
        			'type' => 'checkbox',
        			'label' => 'Show in TOC?',
        			'std' => ''
        		),  
                array(
                    'name' => 'Image',
        			'side_note' => '',
                    'bottom_note' => '',
                    'id' => $prefix . 'image-toc',
                    'type' => 'image',
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
