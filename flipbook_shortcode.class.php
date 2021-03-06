<?php
if ( !class_exists( "cbwp_FlipBookShortCode" ) ) {
	class cbwp_FlipBookShortCode {
     
        function __construct() { 
	
	      	function cbwp_plugin_url() {
				$pluginurl = plugins_url() . '/' . dirname(plugin_basename(__FILE__)).'/';
				return $pluginurl;
			}
	
            function cbwp_show_field($field, $id = NULL) {  
            	if ($id == NULL) {
            		global $post;
            		$id = $post->ID;
            	}
            	$is_single = true;
            	$value = get_post_meta($id, $field, $is_single);
            	echo $value;
            }  

            function cbwp_get_field($field, $id = NULL) {            
            	global $post;
            	if ($id == NULL) {
            		global $post;
            		$id = $post->ID;
            	}
            	$is_single = true;
            	$value = get_post_meta($id, $field, $is_single);
            	return $value;
            }  

            function cbwp_get_image_field($field, $id = NULL) {            
            	global $post;
            	if ($id == NULL) {
            		global $post;
            		$id = $post->ID;
            	}
            	$is_single = true;   

            	$value = get_post_meta($id, $field, $is_single); 
				if ($value == '') $value = cbwp_plugin_url() . "images/spacer.gif";
                return "<img src='{$value}' alt='{$value}' />";
            }                       
            
            function output_toc($toc_data) { 
                // We are doing all this fancy stuff to be able to break up the $toc_data
                // into two pages, each of which have two rows. 
                                             
                function do_row($slice) {  
                    $first = 1;    
					$output = '';
                    foreach ($slice as $toc_item) {
                        
                        $title = $toc_item['title'];
                        $image = $toc_item['img'];
						if ($image == '') $image = cbwp_plugin_url() . "images/spacer.gif";

                        $spread_num = $toc_item['spread_num']; 
                        
                        $extra_class = '';
                        if ($first == 1) {
                            $extra_class = ' first';
                            $first = 0;
                        } else {
                            $extra_class = '';
                        }
                                                                                                  
						$page_jump = ($spread_num * 2) + 3;
                        $output .=  "\t\t<div class='toc-item{$extra_class}'><a href='{$page_jump}'>\n";
                        $output .=  "\t\t\t<img src='{$image}' alt='{$image}'/></a>";
                        $output .=  "<p><a href='{$page_jump}'>{$title}</a></p>";
                        $output .=  "</div>";
                    }                                                      

                    return $output;
                }
                               
				// So, this is supposed to magically take the $toc_data array, and slice it into stuff that
				// will show up appropriately for one page. So through magic, if we pass $page a value of "left",
				// it should do something different than if we pass it a value of "right". And then, even within
				// this, we will have a function called do_row(), which will break it up even more.
                function output_toc_page($toc_data, $page) {  
                    $output = "\t\t<div class='toc-items'>\n"; 
                    
                    if ($page == 'left') {
                        $page_offset = 0;
                    } else {
                        $page_offset = 6;
                    }
                                                    
					// So we're taking a slice of the array, appropriate to both the
					// page we're on (see $page_offset above), and then whether it's 
					// the top row or bottom row.
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

				// So we are doing some annoying math to break things up so that they are in sections, because
				// we are taking an array of 1 to 16 items that go into the TOC, and we are breaking them up
				// into chunks, so they can be output on two separate pages, and two separate rows within those
				// pages, and that is inherently confusing. But when you figure it out, it is kind of elegant.
				// We are starting with $toc_data, which is the array of all the stuff for the TOC from the different
				// pages.

                // Output left page
                $output  = "\t\t<div class='page left page-toc'>\n";  
                // $output .= "\t\t\t<h2>Table of</h2>\n"; 
                $output .= output_toc_page($toc_data, 'left');
                $output .= "\t\t</div>\n";  
                                   
                // Output right page
                $output .= "\t\t<div class='page right page-toc'>\n";  
                // $output .= "\t\t\t<h2>Contents</h2>\n";  
                $output .= output_toc_page($toc_data, 'right');
                $output .= "\t\t</div>\n";  

                return $output;
            }
            
            function generate_page($side, $id, $title) {
                $image = cbwp_get_field("cbwp_image-{$side}", $id);   
				if ($image == '') $image = cbwp_plugin_url() . "images/spacer.gif";
						
				$style = '';
                // if (strlen($image) > 0) {
                //     $style  = " style='background-image: url(\"$image\");' ";
                // }                                                
     			$rel = NULL;
				if (($side == 'left') and (cbwp_get_field('cbwp_cb-show-in-toc', $id) == 'on')) {
					$rel = " rel='{$title}'";
				}
                $content = "\t\t<div class='page {$side}'{$style}{$rel}>\n";  
				$content .= "<h3 class='page-title'>$title</h3>\n";
				
                $copy = cbwp_get_field("cbwp_main-text-{$side}", $id);                  
                if (strlen($copy) > 0) {
                    $content .= "\t\t\t<div class='copy'>\n";
					$content .= "\t\t\t$copy";
                    $content .= "\t\t\t</div>\n";
                }
                
                $popup = cbwp_get_field("cbwp_popup-text-{$side}", $id);                  
                if (strlen($popup) > 0) {
                    $content .= "<div class='popup'>";
                    $content .= "<p class='msg'>Read About</p>";
                    $content .= "<div class='content'>{$popup}</div>";
                    $content .= "</div>";
                }

                if (strlen($image) > 0) {                                                       
					$spacer = cbwp_plugin_url() . "images/spacer.gif";
					$content .= "\t\t\t<div class='image'><span class='img-src'>{$image}</span><img data-img-loaded='0' data-img-url='{$image}' src='$spacer'  alt='{$value}'/></div>\n";
                }                                                
                
                $content .= "\t\t</div>\n";           
                
                return $content;
            }

            function flipbook_func( $atts ) {
                $args = array(           
                    'post_type' => 'flipbook',
                    'orderby' => 'menu_order',
                    'numberposts' => '-1', 
					'post_status' => 'publish',
                );
                $spreads = array_reverse( get_posts($args) );        

                // Cover                                                        
                $cover_image = get_option('cbwp_cover_img_url');  
				if ($cover_image == '') $cover_image = cbwp_plugin_url() . "images/spacer.gif";
						
                $first = true;  
                $cover = "<div class='page right first cover'><img src='{$cover_image}'  alt='{$value}'/></div>";  
                
                $toc_data = array();
				$spread_num = 0;
				$content = NULL;
                foreach ($spreads as $spread) {
                    $spread_num++; 
                    $id = $spread->ID;                     
                    
                    $spread_title  = $spread->post_title;                     
                    $section_title  = cbwp_get_field('cbwp_section-title', $id);   
                    if (cbwp_get_field('cbwp_cb-show-in-toc', $id) == 'on') {
                        $img    = cbwp_get_field('cbwp_image-toc', $id);                                            
                        
                        $data = array("img" => $img, "title" => $section_title, "spread_num" => "{$spread_num}");
                        
                        array_push($toc_data, $data);
                    }
                    $content .= generate_page('left', $id, $spread_title);
                    $content .= generate_page('right', $id, $spread_title);
                }            
                
                // Output TOC     
                $toc = output_toc($toc_data);
                
                // Cover                                                        
                // Cover                                                        
                $back_image = get_option('cbwp_back_img_url');    
				if ($back_image == '') $back_image = cbwp_plugin_url() . "images/spacer.gif";

                $first = true;  

				// Assemble parts  
				$book .= "<div id='cbwp_flipbook_outr'>\n"; 
				// $book .= "<div id='flipbook_status'>Loading slides...</div>\n";
				$book .= "<p class='book-menu'></p>\n"; 
				$book .= "\t<div id='cbwp_flipbook'>\n";
                $book .= "\t\t<div class='b-load'>\n";  
                $book .= $cover;
				$book .= $toc;
				$book .= $content;
                $book .= "\t\t<img id='final-image' src='{$back_image}'  alt='{$back_image}'/></div>\n";           
				$book .= "\t</div>\n";
                $book .= "</div>\n"; 

				return $book;
            }
            add_shortcode( 'flipbook', 'flipbook_func' );
        }               
    }
}    
