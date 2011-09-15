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
                    $output .= "</div>"; 
                    
                    $output .= "<div class='row'>";
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
                $output .= "<div class='page left page-toc'>";  
                $output .= "<h2>Table of</h2>";  
                if ($num_cycles >= 2) {
                    $output .= output_toc_page($toc_data, $num_cycles, 'left');
                }                   
                $output .= "</div>";  
                                   
                // Output right page
                $output .= "<div class='page right page-toc'>";  
                $output .= "<h2>Contents</h2>";  
                if ($num_cycles >= 4) {
                    $output .= output_toc_page($toc_data, $num_cycles, 'right');
                }        
                $output .= "</div>";  
                      
                return $output;
            }
            
            function generate_page($side, $id) {
                $image = cbqc_get_field("cbqc_image-{$side}", $id);  
                if (strlen($image) > 0) {
                    $style = " style='background-image: url(\"$image\")'";
                }                                                     
                $content .= "<div class='page {$side}'{$style} >";  
                
                $copy = cbqc_get_field("cbqc_main-text-{$side}", $id);                  
                if (strlen($copy) > 0) {
                    $content .= "<div class='copy'>";
                    $content .= $copy;
                    $content .= "</div>";
                }
                
                $popup = cbqc_get_field("cbqc_popup-text-{$side}", $id);                  
                if (strlen($popup) > 0) {
                    $content .= "<div class='popup'>";
                    $content .= "<p class='msg'>&#x2767; Read About</p>";
                    $content .= "<div class='content'>{$popup}</div>";
                    $content .= "</div>";
                }

                $content .= "</div>";           
                
                // return $content;
            }

            function magazine_func( $atts ) {
                $args = array(           
                    'post_type' => 'magazine',
                    'orderby' => 'menu_order',
                    'numberposts' => '-1',
                );
                $spreads = get_posts($args); 
                
                $content .= "<div id='cbqc_magazine'>";  
                $content .= "    <div class='b-load'>";  
                
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
                
                $content .= "   </div>";
                $content .= "</div>";
                
                $content .= "<div style='clear: both;>&nbsp;</div>";

                return $content;
            }
            add_shortcode( 'magazine', 'magazine_func' );
        }               
    }
}    
