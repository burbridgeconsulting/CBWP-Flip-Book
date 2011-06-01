<?php
if ( !class_exists( "CBQC_MetaBox" ) ) {
	class CBQC_MetaBox {
    	protected $_meta_box;

    	// create meta box based on given data
    	function __construct($meta_box) {
    		if (!is_admin()) return;

    		$this->_meta_box = $meta_box;

    		// fix upload bug: http://www.hashbangcode.com/blog/add-enctype-wordpress-post-and-page-forms-471.html
    		$current_page = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);
    		if ($current_page == 'page' || $current_page == 'page-new' || $current_page == 'post' || $current_page == 'post-new') {
    			add_action('admin_head', array(&$this, 'add_post_enctype'));
    		}

    		add_action('admin_menu', array(&$this, 'add'));

    		add_action('save_post', array(&$this, 'save'));
    	}

    	function add_post_enctype() {
    		echo '
    		<script type="text/javascript">
    		jQuery(document).ready(function(){
    			jQuery("#post").attr("enctype", "multipart/form-data");
    			jQuery("#post").attr("encoding", "multipart/form-data");
    		});
    		</script>';
    	}

    	/// Add meta box for multiple post types
    	function add() {
    		foreach ($this->_meta_box['pages'] as $page) {
    			add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
    		}
    	} 

    	// Callback function to show fields in meta box
    	function show() {
    		global $post; 

    		$mce_ids = array();

    		// Use nonce for verification
    		echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    		echo '<table class="form-table">';
    		
    		if ($this->_meta_box['html']) {
    		    echo $this->_meta_box['html'];
    		}

    		foreach ($this->_meta_box['fields'] as $field) {
    			// get current post meta data
    			$meta = get_post_meta($post->ID, $field['id'], true);  
                $label_area = '';    			

                if ($field['side_note']) {
                    $label_area .= "<p><span class='description'>{$field['side_note']}</span></p>";
                }

                if ($field['img']) {
                    $label_area .= '<img src="' . WP_PLUGIN_URL . "/cbqc_post_extra_fields/img/" . $field['img'] . '" /';
                }

    			echo '<tr>',
    					'<th style="width:20%">
    						<label for="', $field['id'], '">', "<strong>", $field['name'], "</strong>", '</label>',

    					$label_area,

    					'</th>',
    					'<td>';

    			switch ($field['type']) {
    				case 'text':
    					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
    						'<br />', $field['bottom_note'], ' &nbsp;<span style="color: #eee">', $field['id'], '</span>';
    					break;
    				case 'textarea':
    					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
    						'<br />', $field['bottom_note'], ' &nbsp;<span style="color: #eee">', $field['id'], '</span>';
    					break;
    				case 'tinymce':                                                                             
    					echo '<div style="border: 1px solid #dfdfdf;">';                               
    				   array_push($mce_ids, $field['id']);                                           
    					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
    						'<br />'; 
    					echo '</div>';
    					echo $field['bottom_note'], ' &nbsp;<span style="color: #eee">', $field['id'], '</span>';
    					break;
                    case 'ckedit':
                        $ckedit = true;
                        echo '<textarea class="ckedit" name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
                            '<br />'; 
                        echo $field['bottom_note'], ' &nbsp;<span style="color: #eee">', $field['id'], '</span>';
                        break;
    				case 'select':
    					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
    					foreach ($field['options'] as $option) {
    						echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
    					}
    					echo '</select>', ' &nbsp;<span style="color: #eee">', $field['id'], '</span>';
    					break;
    				case 'radio':
    					foreach ($field['options'] as $option) {
    						echo ' <input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' /> ', $option['name'];
    					}      
    					echo ' &nbsp;<span style="color: #eee">', $field['id'], '</span>';
    					break;
    				case 'checkbox':
    					echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />', ' &nbsp;<span style="color: #eee">', $field['id'], '</span>';
    					break;
    				case 'file':
    					echo $meta ? "$meta<br />" : '', '<input type="file" name="', $field['id'], '" id="', $field['id'], '" />',
    						'<br />', $field['bottom_note'], ' &nbsp;<span style="color: #eee">', $field['id'], '</span>';
    					break;
    				case 'image':
    					echo $meta ? "<img src=\"$meta\" width=\"150\" height=\"150\" /><br />$meta<br />" : '', '<input type="file" name="', $field['id'], '" id="', $field['id'], '" />',
    						'<br />', $field['bottom_note'], ' &nbsp;<span style="color: #eee">', $field['id'], '</span>';
    					break;    
    			}
    			echo 	'<td>',
    				'</tr>';
    		}

    		echo '</table>'; 

    		// If we have accumulated any TinyMCE type items, then active TinyMCE on them
    		if (count($mce_ids) > 0) {
    			?>
    				<script type="text/javascript">
    				/* <![CDATA[ */

    				jQuery(document).ready( function () { 
    					if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
    			 			<?php foreach ($mce_ids as $id) : ?>
    						tinyMCE.execCommand("mceAddControl", false, "<?php echo $id; ?>");    
    						<?php endforeach; ?>
    					}
    				});

    				/* ]]> */
    				</script>
    			<?php	   
    		} 

    	}

    	// Save data from meta box
    	function save($post_id) {
    		// verify nonce
    		if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
    			return $post_id;
    		}

    		// check autosave
    		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    			return $post_id;
    		}

    		// check permissions
    		if ('page' == $_POST['post_type']) {
    			if (!current_user_can('edit_page', $post_id)) {
    				return $post_id;
    			}
    		} elseif (!current_user_can('edit_post', $post_id)) {
    			return $post_id;
    		}

    		foreach ($this->_meta_box['fields'] as $field) {
    			$name = $field['id'];

    			$old = get_post_meta($post_id, $name, true);
    			$new = $_POST[$field['id']];

    			if ($field['type'] == 'file' || $field['type'] == 'image') {
    				$file = wp_handle_upload($_FILES[$name], array('test_form' => false));
    				$new = $file['url'];
    			}

    			if ($new && $new != $old) {
    				update_post_meta($post_id, $name, $new); 
    			} elseif ('' == $new && $old && $field['type'] != 'file' && $field['type'] != 'image') {
    				delete_post_meta($post_id, $name, $old);
    			}
    		}
    	}                        
    }
}    