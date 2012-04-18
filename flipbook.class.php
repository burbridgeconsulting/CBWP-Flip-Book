<?php

if (!class_exists('cbwp_flipbook')) {
    class cbwp_flipbook {
        //This is where the class variables go, don't forget to use @var to tell what they're for
        /**
        * @var string The options string name for this plugin
        */
        var $optionsName = 'cbwp_flipbook_options';
        
        /**
        * @var string $localizationDomain Domain used for localization
        */
        var $localizationDomain = "cbwp_flipbook";
        
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
        function cbwp_flipbook() {$this->__construct();}
        
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
            $this->pluginpath = plugin_basename(__FILE__);
            
            //Initialize the options
            //This is REQUIRED to initialize the options when the plugin is loaded!
            $this->getOptions();
            
            //Actions                         
            
            // Add custom post type and taxonomies  
            include('post_type.class.php');
            $postType = new cbwp_CustomPostTypes(); 
            
            // Add custom post type and taxonomies  
            include('flipbook_extra_fields.class.php');
            $postType = new cbwp_FlipBookExtraFields(); 
            
            // Define shortcode
            include('flipbook_shortcode.class.php');
            $shortCode = new cbwp_FlipBookShortCode(); 
            
            // add_action("admin_menu", array(&$this,"admin_menu_link"));
            
            //Widget Registration Actions
            // add_action('plugins_loaded', array(&$this,'register_widgets'));
            
            add_action('wp_print_styles', array(&$this,"add_css"));
            add_action('init', array(&$this, 'add_js'));
            
            //Filters
            /*
            add_filter('the_content', array(&$this, 'filter_content'), 0);
            */
        }
                                                 
        function add_js() {   
            wp_enqueue_script( 'cbwp_easing', $this->pluginurl . 'js/jquery.easing.1.3.js', array('jquery', 'jquery-ui-core'), NULL, true );
            wp_enqueue_script( 'cbwp_booklet', $this->pluginurl . 'js/jquery.booklet.1.2.0.min.js', array('jquery', 'jquery-ui-core'), NULL, true );
            wp_enqueue_script( 'cbwp_flipbook_js', $this->pluginurl . 'js/flipbook.js', array('jquery', 'jquery-ui-core','cbwp_booklet'), NULL, true );
        }
              
        function add_css() {                                                           
            wp_enqueue_style( 'cbwp_jquery_booklet', $this->pluginurl . 'jquery.booklet.1.2.0.css' );
            wp_enqueue_style( 'cbwp_flipbook_styles', $this->pluginurl . 'flipbook.css' );
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
            // add_options_page('Flip Book', 'Flip Book', 10, basename(__FILE__), array(&$this,'admin_options_page'));
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

        }
        
  } //End Class
} //End if class exists statement

