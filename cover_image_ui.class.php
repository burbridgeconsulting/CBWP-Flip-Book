<?php
if ( !class_exists( "cbwp_Options" ) ) {
	class cbwp_Options {
     
        function __construct() {        
            add_action('admin_menu', array(&$this, 'plugin_menu'));
        }               
        
        function plugin_menu() {
        	add_submenu_page(
        	    'edit.php?post_type=magazine', 
        	    'Magazine Options', 
        	    'Magazine Options', 
        	    'manage_options',
        	    'magazine_options', 
        	    array(&$this, 'plugin_options')
            );
        }                   
        
        function plugin_options() {
                //must check that the user has the required capability 
                if (!current_user_can('manage_options'))
                {
                  wp_die( __('You do not have sufficient permissions to access this page.') );
                }

                // variables for the field and option names 
                $hidden_field_name = 'cbwp_submit_hidden';

                // Read in existing option value from database
                $cbwp_cover_img_url = get_option( 'cbwp_cover_img_url' );
                $cbwp_back_img_url = get_option( 'cbwp_back_img_url' );

                // See if the user has posted us some information
                // If they did, this hidden field will be set to 'Y'
                if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
                    // Read their posted value
                    $cbwp_cover_img_url = $_POST[ 'cbwp_cover_img_url' ];
                    $cbwp_back_img_url = $_POST[ 'cbwp_back_img_url' ];

                    // Save the posted value in the database
                    update_option( 'cbwp_cover_img_url', $cbwp_cover_img_url );
                    update_option( 'cbwp_back_img_url', $cbwp_back_img_url );

                    // Put an settings updated message on the screen
		            ?>
		            <div class="updated"><p><strong><?php _e('Settings saved.', 'menu-test' ); ?></strong></p></div>
		            <?php
                }

                // Now display the settings editing screen
                echo '<div class="wrap">';

                // header
                echo "<h2>" . __( 'Magazine Plugin Settings', 'magazine' ) . "</h2>";

                // settings form
                ?>

	            <form name="form1" method="post" action="">
	            <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

	            <p><?php _e("Front Cover Image URL:", 'menu-label' ); ?> 
	            <input type="text" name="cbwp_cover_img_url" value="<?php echo $cbwp_cover_img_url; ?>" size="20">
	            </p>

	            <p><?php _e("Back Cover Image URL:", 'menu-label' ); ?> 
	            <input type="text" name="cbwp_back_img_url" value="<?php echo $cbwp_back_img_url; ?>" size="20">
	            </p>

	            <p class="submit">
	            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
	            </p>

	            </form>
            </div>

            <?php
        }
    }
}    
