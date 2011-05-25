<?php

if (!class_exists('cbqc_magazine')) {
    class cbqc_magazine {
        //This is where the class variables go, don't forget to use @var to tell what they're for
        /**
        * @var string The options string name for this plugin
        */
        var $optionsName = 'cbqc_magazine_options';
        
        /**
        * @var string $localizationDomain Domain used for localization
        */
        var $localizationDomain = "cbqc_magazine";
        
        /**
        * @var string $pluginurl The path to this plugin
        */ 
        var $pluginurl;
        /**
        * @var string $pluginurlpath The path to this plugin
        */
        var $pluginpath = '';
            
        /**
        * @var array $options Stores the options for this plugin
        */
        var $options = array();
        
        //Class Functions
        /**
        * PHP 4 Compatible Constructor
        */
        function cbqc_magazine() {$this->__construct();}
        
        /**
        * PHP 5 Constructor
        */        
        function __construct() {
            //Language Setup
            $locale = get_locale();
            $mo = dirname(__FILE__) . "/languages/" . $this->localizationDomain . "-".$locale.".mo";
            load_textdomain($this->localizationDomain, $mo);

            //"Constants" setup
            $this->pluginurl = plugins_url() . '/' . dirname(plugin_basename(__FILE__)).'/';
            $this->pluginpath = PLUGIN_PATH . '/' . dirname(plugin_basename(__FILE__)).'/';
            
            //Initialize the options
            //This is REQUIRED to initialize the options when the plugin is loaded!
            $this->getOptions();
            
            //Actions                         
            
            // Add custom post type and taxonomies  
            include('post_type.class.php');
            $postType = new CBQC_CustomPostTypes(); 
            
            // Add custom post type and taxonomies  
            include('magazine_extra_fields.class.php');
            $postType = new CBQC_MagazineExtraFields(); 
            
            
            // add_action("admin_menu", array(&$this,"admin_menu_link"));
            
            //Widget Registration Actions
            // add_action('plugins_loaded', array(&$this,'register_widgets'));
            
            // add_action("wp_head", array(&$this,"add_css"));
            add_action('wp_print_scripts', array(&$this, 'add_js'));
            
            //Filters
            /*
            add_filter('the_content', array(&$this, 'filter_content'), 0);
            */
        }
        
        function add_js() {
            wp_enqueue_script( 'cbqc_magazine_js', $this->pluginurl . 'magazine.js', array('jquery') );
        }
        
        
        /**
        * Retrieves the plugin options from the database.
        * @return array
        */
        function getOptions() {
            //Don't forget to set up the default options
            if (!$theOptions = get_option($this->optionsName)) {
                $theOptions = array('default'=>'options');
                update_option($this->optionsName, $theOptions);
            }
            $this->options = $theOptions;
            
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            //There is no return here, because you should use the $this->options variable!!!
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        }
        /**
        * Saves the admin options to the database.
        */
        function saveAdminOptions(){
            return update_option($this->optionsName, $this->options);
        }
        
        /**
        * @desc Adds the options subpanel
        */
        function admin_menu_link() {
            //If you change this from add_options_page, MAKE SURE you change the filter_plugin_actions function (below) to
            //reflect the page filename (ie - options-general.php) of the page your plugin is under!
            add_options_page('Magazine', 'Magazine', 10, basename(__FILE__), array(&$this,'admin_options_page'));
            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_actions'), 10, 2 );
        }
        
        /**
        * @desc Adds the Settings link to the plugin activate/deactivate page
        */
        function filter_plugin_actions($links, $file) {
           //If your plugin is under a different top-level menu than Settiongs (IE - you changed the function above to something other than add_options_page)
           //Then you're going to want to change options-general.php below to the name of your top-level page
           $settings_link = '<a href="options-general.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
           array_unshift( $links, $settings_link ); // before other links

           return $links;
        }
        
        /**
        * Adds settings/options page
        */
        function admin_options_page() { 
            if($_POST['cbqc_magazine_save']){
                if (! wp_verify_nonce($_POST['_wpnonce'], 'cbqc_magazine-update-options') ) die('Whoops! There was a problem with the data you posted. Please go back and try again.'); 
                $this->options['cbqc_magazine_path'] = $_POST['cbqc_magazine_path'];                   
                $this->options['cbqc_magazine_allowed_groups'] = $_POST['cbqc_magazine_allowed_groups'];
                $this->options['cbqc_magazine_enabled'] = ($_POST['cbqc_magazine_enabled']=='on')?true:false;
                                        
                $this->saveAdminOptions();
                
                echo '<div class="updated"><p>Success! Your changes were sucessfully saved!</p></div>';
            }
?>                                   
                <div class="wrap">
                <h2>Magazine Settings</h2>
                <form method="post" id="cbqc_magazine_options">
                <?php wp_nonce_field('cbqc_magazine-update-options'); ?>
                    <table width="100%" cellspacing="2" cellpadding="5" class="form-table"> 
                        <tr valign="top"> 
                            <th width="33%" scope="row"><?php _e('Option 1:', $this->localizationDomain); ?></th> 
                            <td><input name="cbqc_magazine_path" type="text" id="cbqc_magazine_path" size="45" value="<?php echo $this->options['cbqc_magazine_path'] ;?>"/>
                        </td> 
                        </tr>
                        <tr valign="top"> 
                            <th width="33%" scope="row"><?php _e('Option 2:', $this->localizationDomain); ?></th> 
                            <td><input name="cbqc_magazine_allowed_groups" type="text" id="cbqc_magazine_allowed_groups" value="<?php echo $this->options['cbqc_magazine_allowed_groups'] ;?>"/>
                            </td> 
                        </tr>
                        <tr valign="top"> 
                            <th><label for="cbqc_magazine_enabled"><?php _e('CheckBox #1:', $this->localizationDomain); ?></label></th><td><input type="checkbox" id="cbqc_magazine_enabled" name="cbqc_magazine_enabled" <?=($this->options['cbqc_magazine_enabled']==true)?'checked="checked"':''?>></td>
                        </tr>
                        <tr>
                            <th colspan=2><input type="submit" name="cbqc_magazine_save" value="Save" /></th>
                        </tr>
                    </table>
                </form>
                <?php
        }
        
        /*
        * ============================
        * Plugin Widgets
        * ============================
        */                        
        function register_widgets() {
            //Make sure the widget functions exist
            if ( function_exists('wp_register_sidebar_widget') ) {
                //============================
                //Example Widget 1
                //============================
                function display_cbqc_magazine($args) {                    
                    extract($args);
                    echo $before_widget . $before_title . $this->options['title'] . $after_title;
                    echo '<ul>';
                    //!!! Widget 1 Display Code Goes Here!
                    echo '</ul>';
                    echo $after_widget;
                }                                                                             
                function cbqc_magazine_control() {            
                    if ( $_POST["cbqc_magazine_cbqc_magazine_submit"] ) {
                        $this->options['cbqc_magazine-comments-title'] = stripslashes($_POST["cbqc_magazine-comments-title"]);        
                        $this->options['cbqc_magazine-comments-template'] = stripslashes($_POST["cbqc_magazine-comments-template"]);
                        $this->options['cbqc_magazine-hide-admin-comments'] = ($_POST["cbqc_magazine-hide-admin-comments"]=='on'?'':'1');
                        $this->saveAdminOptions();
                    }                                                                  
                    $title = htmlspecialchars($options['cbqc_magazine-comments-title'], ENT_QUOTES);
                    $template = htmlspecialchars($options['cbqc_magazine-comments-template'], ENT_QUOTES);
                    $hide_admin_comments = $options['cbqc_magazine-hide-admin-comments'];      
                ?>
                    <p><label for="cbqc_magazine-comments-title"><?php _e('Title:', $this->localizationDomain); ?> <input style="width: 250px;" id="cbqc_magazine-comments-title" name="cbqc_magazine-comments-title" type="text" value="<?= $title; ?>" /></label></p>               
                    <p><label for="cbqc_magazine-comments-template"><?php _e('Template:', $this->localizationDomain); ?> <input style="width: 250px;" id="cbqc_magazine-comments-template" name="cbqc_magazine-comments-template" type="text" value="<?= $template; ?>" /></label></p>
                    <p><?php _e('The template is made up of HTML and tokens. You can get a list of available tokens at the', $this->localizationDomain); ?> <a href='http://pressography.com/plugins/wp-cbqc_magazine/#tokens-recent' target='_blank'><?php _e('plugin page', $this->localizationDomain); ?></a></p>
                    <p><input id="cbqc_magazine-hide-admin-comments" name="cbqc_magazine-hide-admin-comments" type="checkbox" <?= ($hide_admin_comments=='1')?'':'checked="CHECKED"'; ?> /> <label for="cbqc_magazine-hide-admin-comments"><?php _e('Show Admin Comments', $this->localizationDomain); ?></label></p>
                    <input type="hidden" id="cbqc_magazine_cbqc_magazine_submit" name="cbqc_magazine_cbqc_magazine_submit" value="1" />
                <?php
                }
                $widget_ops = array('classname' => 'cbqc_magazine', 'description' => __( 'Widget Description', $this->localizationDomain ) );
                wp_register_sidebar_widget('cbqc_magazine-cbqc_magazine', __('Widget Title', $this->localizationDomain), array($this, 'display_cbqc_magazine'), $widget_ops);
                wp_register_widget_control('cbqc_magazine-cbqc_magazine', __('Widget Title', $this->localizationDomain), array($this, 'cbqc_magazine_control'));
                
            }  
        }       
        
  } //End Class
} //End if class exists statement

