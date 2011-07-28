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
            
            function output_toc($toc_data) { 
                // We are doing all this fancy stuff to be able to break up the $toc_data
                // into two pages, each of which have two rows. 
                                             
                function do_row($slice) {
                    $first = 1;
                    foreach ($slice as $toc_item) {
                        $title = $toc_item['title'];
                        $image = $toc_item['img'];
                        $spread_num = $toc_item['spread_num']; 
                        
                        $extra_class = '';
                        if ($first == 1) {
                            $extra_class = ' first';
                            $first = 0;
                        } else {
                            $extra_class = '';
                        }

                        $output .=  "<div class='toc-item{$extra_class}'><a href='#{$spread_num}'>";
                        $output .=  "<img src='{$image}' />";
                        $output .=  "<p>{$title}</p>";
                        $output .=  "</a></div>";
                    }                                                      
                    
                    return $output;
                }

                function output_toc_page($toc_data, $num_cycles, $page) {  
                    
                    $output .= "<div class='toc-items'>"; 
                    
                    if ($page == 'left') {
                        $page_offset = 0;
                    } else {
                        $page_offset = 6;
                    }
                    
                    $page_slice_top     = array_slice($toc_data, $page_offset, 3);
                    $page_slice_bottom  = array_slice($toc_data, $page_offset + 3, 3);
                    
                    $output .= "<div class='row'>";
                    $output .=  do_row($page_slice_top);
                    $output .= "</div> <!-- row -->"; 
                    
                    $output .= "<div class='row'>";
                    $output .=  do_row($page_slice_bottom);
                    $output .= "</div> <!-- row -->"; 
                    
                    $output .= "</div> <!-- toc -->"; 
                                                 
                    return $output;
                }

                // Determine number of cycles
                $total = count($toc_data);  
                $max_cycles = 4;
                $num_cycles = ceil($total / 3);
                if (($total % 3) > 0) {
                    $num_cycles++;
                }      
                if ($num_cycles > $max_cycles) {
                    $num_cycles = $max_cycles;
                }     
                    
                // Output left page
                $output .= "<div class='page left page-toc'>";  
                $output .= "<h2>Table of</h2>";  
                if ($num_cycles >= 2) {
                    $output .= output_toc_page($toc_data, $num_cycles, 'left');
                }                   
                $output .= "</div> <!-- page (etc.) -->";  
                                   
                // Output right page
                $output .= "<div class='page right page-2'>";  
                $output .= "<h2>Contents</h2>";  
                if ($num_cycles >= 4) {
                    $output .= output_toc_page($toc_data, $num_cycles, 'right');
                }        
                $output .= "</div> <!-- page (etc.) -->";  
                      
                return $output;
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
                    'numberposts' => '-1',
                );
                $spreads = get_posts($args); 
                
                $content = "<div id='cbqc_magazine'>";  
                
                // Iterate through spreads
                $i = count($spreads) + 3; // (Add 1 for good measure, 1 for the TOC, and 1 for the cover)
                
                $toc_data = array();
                
                foreach ($spreads as $spread) { 
                    $id = $spread->ID; 
                    --$i;
                         
                    if (cbqc_get_field('cbqc_cb-show-in-toc', $id) == 'on') {
                        $img    = cbqc_get_field('cbqc_image-toc', $id);                                            
                        $title  = $spread->post_title;   
                        $spread_num = 
                        
                        $data = array("img" => $img, "title" => $title, "spread_num" => "spread-n-{$i}");
                        
                        array_push($toc_data, $data);
                    }
                    
                    $content .= "<div class='spread spread-id-{$id} spread-n-{$i}'>";    
                    
                    // **************************************** //
                    
                    // Left page
                    $left_image = cbqc_get_field('cbqc_image-left', $id);  
                    $pnum = $i * 2 - 5; // (Subtract 1 for good measure, 1 for the TOC, and 1 for the cover)                
                    if (strlen($left_image) > 0) {
                        $style = " style='background-image: url(\"$left_image\")'";
                    }                                                     
                    $content .= "<div class='page page-{$pnum} left'{$style} ><div class='page-num'>{$pnum}</div>";  
                    
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
                    $pnum = $i * 2 - 4;                
                    if (strlen($right_image) > 0) {
                        $style = " style='background-image: url(\"$right_image\")'";
                    }                  
                    if ($i == count($spreads) + 2) {
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
                $content .= "<div class='spread toc spread-n-2'>";    

                // We reverse the array, because it was gathered in reverse order, and this sets it right for what we want to do here
                $toc = output_toc(array_reverse($toc_data));
                $content .= $toc;

                $content .= "</div>";

                    
                // Output Cover                                                        
                $cover_image = get_option('cbqc_cover_img_url');
                
                $first = true;  
                $content .= "<div class='spread cover {$hidden} spread-n-1'>";    
                $content .= "<div class='page right first'><img src='{$cover_image}' /></div>";  
                $content .= "</div>";
                
                $content .= "</div>";
                
                $content .= "<div style='clear: both;>&nbsp;</div>";

                return $content;
            }
            add_shortcode( 'magazine', 'magazine_func' );
        }               
    }
}    
