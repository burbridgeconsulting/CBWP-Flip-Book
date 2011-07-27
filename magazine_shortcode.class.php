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
                    'orderby' => 'menu_order',
                );
                $spreads = get_posts($args); 
                
                $content = "<div id='cbqc_magazine'>";  
                
                // Iterate through spreads
                $first = true;  
                $i = count($spreads) + 2; // (Add 1 for good measure, 1 for the TOC, and 1 for the cover)
                foreach ($spreads as $spread) { 
                    $id = $spread->ID;
                    if ($first == true) {
                        $hidden = '';
                    } else {
                        $hidden = ' hidden';
                        $first = false;
                    }          
                    --$i;
                    $content .= "<div class='spread {$hidden} spread-id-{$id} spread-n-{$i}'>";    
                    
                    
                    // **************************************** //
                    
                    // Left page
                    $left_image = cbqc_get_field('cbqc_image-left', $id);  
                    $pnum = $i * 2 - 3; // (Subtract 1 for good measure, 1 for the TOC, and 1 for the cover)                
                    if (strlen($left_image) > 0) {
                        $style = " style='background-image: url(\"$left_image\")'";
                    }                                                     
                    if ($pnum == 1) {
                        $class = ' first';
                    } else {
                        $class = '';
                    }
                    $content .= "<div class='page page-{$pnum} left{$class}'{$style} ><div class='page-num'>{$pnum}</div>";  
                    
                    $left_copy = cbqc_get_field('cbqc_main-text-left', $id);                  
                    if (strlen($left_copy) > 0) {
                        $content .= "<div class='copy'>";
                        $content .= $left_copy;
                        $content .= "</div>";
                    }
                    
                    $left_popup = cbqc_get_field('cbqc_popup-text-left', $id);                  
                    if (strlen($left_popup) > 0) {
                        $content .= "<div class='popup'>";
                        $content .= "<p class='msg'>&#x2767; Read About</p>";
                        $content .= "<div class='content'>{$left_popup}</div>";
                        $content .= "</div>";
                    }

                    $content .= "</div> <!-- .page .left -->";  
                    
                    // **************************************** //        
                    
                    
                    // Right page
                    $right_image = cbqc_get_field('cbqc_image-right', $id);                  
                    $pnum = $i * 2;                
                    if (strlen($right_image) > 0) {
                        $style = " style='background-image: url(\"$right_image\")'";
                    }                  
                    if ($i == count($spreads)) {
                        $class = ' last';
                    } else {
                        $class = '';
                    }
                    $content .= "<div class='page page-{$pnum} right{$class}'{$style}>";  
                    
                    $right_copy = cbqc_get_field('cbqc_main-text-right', $id);                  
                    $content .= "<div class='copy'><div class='page-num'>{$pnum}</div>";
                    $content .= $right_copy;
                    $content .= "</div>";
                                                        
                    $right_popup = cbqc_get_field('cbqc_popup-text-right', $id);                  
                    if (strlen($right_popup) > 0) {
                        $content .= "<div class='popup'>";
                        $content .= "<p class='msg'>&#x2767; Read About</p>";
                        $content .= "<div class='content'>{$right_popup}</div>";
                        $content .= "</div>";
                    }
                
                    $content .= "</div> <!-- .page .right -->";

                    // **************************************** //


                    $content .= "</div>";
                }                                 
                
                // Output TOC spread
                    
                // Output Cover 
                $content .= "<div class='spread cover {$hidden} spread-n-1'>";    
                $content .= "<div class='page right'></div>";  
                $content .= "</div>";
                
                $content .= "</div>";
                
                $content .= "<div style='clear: both;>&nbsp;</div>";

                return $content;
            }
            add_shortcode( 'magazine', 'magazine_func' );
        }               
        
    }
}    
