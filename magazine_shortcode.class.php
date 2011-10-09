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

                        $output .=  "\t\t<div class='toc-item{$extra_class}'><a href='#{$spread_num}'>\n";
                        $output .=  "\t\t\t<img src='{$image}' />";
                        $output .=  "<p>{$title}</p>";
                        $output .=  "</a></div>";
                    }                                                      
                    
                    return $output;
                }

                function output_toc_page($toc_data, $num_cycles, $page) {  
                    
                    $output .= "\t\t<div class='toc-items'>\n"; 
                    
                    if ($page == 'left') {
                        $page_offset = 0;
                    } else {
                        $page_offset = 6;
                    }
                    
                    $page_slice_top     = array_slice($toc_data, $page_offset, 3);
                    $page_slice_bottom  = array_slice($toc_data, $page_offset + 3, 3);
                    
                    $output .= "\t\t<div class='row'>\n";
                    $output .=  do_row($page_slice_top);
                    $output .= "</div>"; 
                    
                    $output .= "\t\t<div class='row'>\n";
                    $output .=  do_row($page_slice_bottom);
                    $output .= "</div>"; 
                    
                    $output .= "</div>"; 
                                                 
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
                $output .= "\t\t<div class='page left page-toc'>\n";  
                $output .= "\t\t\t<h2>Table of</h2>\n";  
                if ($num_cycles >= 2) {
                    $output .= output_toc_page($toc_data, $num_cycles, 'left');
                }                   
                $output .= "\t\t</div>\n";  
                                   
                // Output right page
                $output .= "\t\t<div class='page right page-toc'>\n";  
                $output .= "\t\t\t<h2>Contents</h2>\n";  
                if ($num_cycles >= 4) {
                    $output .= output_toc_page($toc_data, $num_cycles, 'right');
                }        
                $output .= "\t\t</div>\n";  
                      
                return $output;
            }
            
            function generate_page($side, $id) {
                $image = cbqc_get_field("cbqc_image-{$side}", $id);  
                if (strlen($image) > 0) {
                    $style = " style='background-image: url(\"$image\")'";
                }                                                     
                $content .= "\t\t<div class={$side}'{$style}>\n";  
                
                $copy = cbqc_get_field("cbqc_main-text-{$side}", $id);                  
                if (strlen($copy) > 0) {
                    $content .= "\t\t\t<div class='copy'>\n";
					$content .= "\t\t\t$copy";
                    $content .= "\t\t\t</div>\n";
                }
                
                $popup = cbqc_get_field("cbqc_popup-text-{$side}", $id);                  
                if (strlen($popup) > 0) {
                    $content .= "<div class='popup'>";
                    $content .= "<p class='msg'>&#x2767; Read About</p>";
                    $content .= "<div class='content'>{$popup}</div>";
                    $content .= "</div>";
                }

                $content .= "\t\t</div>\n";           
                
                return $content;
            }

            function magazine_func( $atts ) {
                $args = array(           
                    'post_type' => 'magazine',
                    'orderby' => 'menu_order',
                    'numberposts' => '-1',
                );
                $spreads = get_posts($args); 
                
                $content .= "<div id='cbqc_magazine'>\n";  
                $content .= "\t<div class='b-load'>\n";  
                
                // Cover                                                        
                // $cover_image = get_option('cbqc_cover_img_url');
                // $first = true;  
                // $content .= "<div class='page right first cover'><img src='{$cover_image}' /></div>";  
                
                $toc_data = array();
                foreach ($spreads as $spread) {
                    $spread_num++; 
                    $id = $spread->ID;                     
                    
                    if (cbqc_get_field('cbqc_cb-show-in-toc', $id) == 'on') {
                        $img    = cbqc_get_field('cbqc_image-toc', $id);                                            
                        $title  = $spread->post_title;   
                        
                        $data = array("img" => $img, "title" => $title, "spread_num" => "spread-n-{$spread_num}");
                        
                        array_push($toc_data, $data);
                    }
                    
                    $content .= generate_page('left', $id);
                    $content .= generate_page('right', $id);
                }            
                
                // Output TOC
                $content .= output_toc($toc_data);
                
                $content .= "\t</div>\n";
                $content .= "</div>\n";
                
                $content .= "<div style='clear: both;'>&nbsp;</div>\n";

                return $content;
            }
            add_shortcode( 'magazine', 'magazine_func' );
        }               
    }
}    
