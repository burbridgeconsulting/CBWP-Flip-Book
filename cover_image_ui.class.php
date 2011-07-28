<?php
if ( !class_exists( "CBQC_CoverImageUI" ) ) {
	class CBQC_CoverImageUI {
     
        function __construct() {        
            add_action('admin_menu', array(&$this, 'plugin_menu'));
        }               
        
        function plugin_menu() {
        	add_options_page('My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 
        	    array(&$this, 'plugin_options'));
        }                   
        
        function plugin_options() {
        	if (!current_user_can('manage_options'))  {
        		wp_die( __('You do not have sufficient permissions to access this page.') );
        	}
        	echo '<div class="wrap">';
        	echo '<p>Here is where the form would go if I actually had options.</p>';
        	echo '</div>';
        }            
        
        
    }
}    
