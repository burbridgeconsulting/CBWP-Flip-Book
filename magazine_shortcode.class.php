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
                foreach ($spreads as $spread) {
                    $id = $spread->ID;
                    $content .= "<div class='spread'>";
                    
                    // Left page
                    $left_image = cbqc_get_field('cbqc_image-left', $id);                  
                    if (strlen($left_image) > 0) {
                        $content .= "<p><strong>Left image: {$left_image}</strong> </p>";
                    }
                    echo "<div class='page left'{$style}>";
                    
                    echo "</div> <!-- .page .left -->";
                    
                    // Right page
                    echo "<div class='page right'{$style}>";
                
                    echo "</div> <!-- .page .right -->";

                    $content .= "</div>";
                }                  
                
                $content .= "</div>";

                return $content;
            }
            add_shortcode( 'magazine', 'magazine_func' );
        }               
        
    }
}    
