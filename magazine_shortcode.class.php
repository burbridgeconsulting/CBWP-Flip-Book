<?php
if ( !class_exists( "CBQC_MagazineShortCode" ) ) {
	class CBQC_MagazineShortCode {
     
        function __construct() {        
            function cbqc_show_field($field, $id = NULL) {  
            	if ($id == NULL) {
            		global $post;
            		$id = $post->ID;
            	}
            	$is_single = true;
            	$value = get_post_meta($id, $field, $is_single);
            	echo $value;
            }  

            function cbqc_get_field($field, $id = NULL) {            
            	global $post;
            	if ($id == NULL) {
            		global $post;
            		$id = $post->ID;
            	}
            	$is_single = true;
            	$value = get_post_meta($id, $field, $is_single);
            	return $value;
            }  

            function cbqc_get_image_field($field, $id = NULL) {            
            	global $post;
            	if ($id == NULL) {
            		global $post;
            		$id = $post->ID;
            	}
            	$is_single = true;   

            	$value = get_post_meta($id, $field, $is_single);
                return "<img src='$value' />";
            }
                        
            // [bartag foo="foo-value"]
            function magazine_func( $atts ) {
                // extract( shortcode_atts( array(
                //  'foo' => 'something',
                //  'bar' => 'something else',
                // ), $atts ) );

                // return "foo = {$foo}";         
                                                            
                $args = array(
                    'post_type' => 'magazine',
                );
                $spreads = get_posts($args); 
                
                $content = "<div id='magazine'>";
                    
                // Iterate through spreads
                $first = true;
                foreach ($spreads as $spread) { 
                    $id = $spread->ID;
                    if ($first == true) {
                        $hidden = '';
                    } else {
                        $hidden = ' hidden';
                        $first = false;
                    }
                    $content .= "<div class='spread {$hidden}'>";    
                    
                    
                    // **************************************** //
                    
                    // Left page
                    $left_image = cbqc_get_field('cbqc_image-left', $id);                  
                    if (strlen($left_image) > 0) {
                        // $style = " style='background-image: url(\"$left_image\")'";
                    }
                    $content .= "<div class='page left'{$style}>";  
                    
                    $left_copy = cbqc_get_field('cbqc_main-text-left', $id);                  
                    if (strlen($left_copy) > 0) {
                        $content .= "<div class='copy'>";
                        $content .= $left_copy;
                        $content .= "</div>";
                    }
                    
                    $left_popup = cbqc_get_field('cbqc_popup-text-left', $id);                  
                    if (strlen($left_popup) > 0) {
                        $content .= "<div class='popup'>";
                        $content .= $left_popup;
                        $content .= "</div>";
                    }

                    $content .= "</div> <!-- .page .left -->";  
                    
                    // **************************************** //        
                    
                    
                    // Right page
                    $right_image = cbqc_get_field('cbqc_image-right', $id);                  
                    if (strlen($right_image) > 0) {
                        // $style = " style='background-image: url(\"$right_image\")'";
                    }
                    $content .= "<div class='page right'{$style}>";  
                    
                    $right_copy = cbqc_get_field('cbqc_main-text-right', $id);                  
                    if (strlen($right_copy) > 0) {
                        $content .= "<div class='copy'>";
                        $content .= $right_copy;
                        $content .= "</div>";
                    }
                                                        
                    $right_popup = cbqc_get_field('cbqc_popup-text-right', $id);                  
                    if (strlen($right_popup) > 0) {
                        $content .= "<div class='popup'>";
                        $content .= $right_popup;
                        $content .= "</div>";
                    }
                
                    $content .= "</div> <!-- .page .right -->";

                    // **************************************** //


                    $content .= "</div>";
                }                  
                
                $content .= "</div>";

                return $content;
            }
            add_shortcode( 'magazine', 'magazine_func' );
        }               
        
    }
}    
