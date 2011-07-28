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
                    $pnum = $i * 2 - 3; // (Subtract 1 for good measure, 1 for the TOC, and 1 for the cover)                
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
                    $pnum = $i * 2 - 2;                
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
                $content .= "   <div class='page left page-1'>";  

                $content .= "   </div>";  
                $content .= "   <div class='page right page-2'>"; 
                 
                $content .= "   </div>";  
                $content .= "</div>";

                    
                // Output Cover                                                        
                $cover_image = get_option('cbqc_cover_img_url');
                
                $first = true;  
                $content .= "<div class='spread cover {$hidden} spread-n-1'>";    
                $content .= "<div class='page right first'><img src='{$cover_image}' /></div>";  
                $content .= "</div>";
                
                $content .= "</div>";
                
                $content .= "<div style='clear: both;>&nbsp;</div>";
                           
$total = count($toc_data);  
$max_cycles = 4;
$num_cycles = ceil($total / 3);
if (($total % 3) > 0) {
    $num_cycles++;
}      
if ($num_cycles > $max_cycles) {
    $num_cycles = $max_cycles;
}

for ($n = $num_cycles; $n > 0; $n--) {
    $offset = $n - 1;
    $start_point = 0 + $offset;
    $end_point = 3 + $offset; 
    
    echo "<h5>OFFSET $offset</h5>";

    for ($i = $end_point; $i >= $start_point; $i--) { 
        $title = $toc_data[$i]['title'];
        $image = $toc_data[$i]['img'];
        $spread_num = $toc_data[$i]['spread_num'];
        echo "<p>$title = $image = $spread_num</p>";
    }                
}

                return $content;
            }
            add_shortcode( 'magazine', 'magazine_func' );
        }               
        
    }
}    
