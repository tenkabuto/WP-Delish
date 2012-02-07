<?php
  /*
   Plugin Name: WP Delish
   Version: 0.1
   Plugin URI: http://www.prelovac.com/vladimir/wordpress-plugins/snazzy-archives
   Author: Brandon Hall
   Author URI: http://zombie.co.vu
   Description: WordPress Tags + Delicious Tags = High-Quality, Relevant Links
   */
  
  global $wp_version;
  
  $exit_msg = 'WP Delish requires WordPress 2.8 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';
  
  if (version_compare($wp_version, "2.8", "<")) {
      exit($exit_msg);
  }
  
  $wp_delish_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
  
  function WPDelish_WidgetControl() {
  	
  	echo '<p>Visit the <a href="options-general.php?page=fresh.php">WP Delish options</a> page to configure this widget.</p>';
  	
  }
  
  function WPDelish_Widget($args = array()) {
	//extract the parameters
	extract($args);
	
	// Get options
	$options = WPDelish_GetOptions();
	
	extract($options);

	if (is_tag()) {
      	
      	// Include widget
      	include('delish-widget.php');
      	
		}
	}
  
  function WPDelish_Init() {
  
  	// register widget
  	wp_register_sidebar_widget(
  	    'WPDelish_Widget',        // your unique widget id
  	    'WP Delish',          // widget name
  	    'WPDelish_Widget',  // callback function
  	    array(                  // options
  	        'description' => 'Display relevant Delicious bookmarks!'
  	    )
  	);
  	
  	// register widget control
  	register_widget_control('WP Delish', array(__FILE__, 'WPDelish_WidgetControl'));
  	
  	register_deactivation_hook( __FILE__, 'plugin_cleanup');
  
  }
  
  // Clear out everything
  function plugin_cleanup()
  {
      delete_option('wp_delish');
  }
  
  add_action('init', 'WPDelish_Init');
  
  function WPDelish_GetOptions()
  {
  	
   $options = array(
   	
   	'title' => 'Recently Saved Bookmarks Tagged "#activetag#"',
   	'taglink' => 'on',
   	'username' => '',
   	'quantity' => '5',
   	'notes' => ''
   	
   );
    
   $saved = get_option('wp_delish');
   
   
   if (!empty($saved)) {
  	 foreach ($saved as $key => $option)
   			$options[$key] = $option;
   }
  	
   if ($saved != $options)	
   	update_option('wp_delish', $options);
   	
   return $options;
  }
  
  add_action('admin_menu', 'WPDelish_AdminMenu');
  
  // Hook the options mage
  function WPDelish_AdminMenu() {
  	add_options_page('WP Delish Options', 'WP Delish', 8, basename(__FILE__),'WPDelish_Options');	
  } 
  
  function WPDelish_Options()
  {
  	$options = WPDelish_GetOptions();
  	
  	if ( isset($_POST['submitted']) ) {
  		check_admin_referer('delish-nonce');
  		
  		//print_r($_POST);
  			
  		$options['title'] = htmlspecialchars($_POST['title']);
  		$options['taglink'] = $_POST['taglink'];
  		$options['username'] = $_POST['username'];
  		$options['quantity'] = $_POST['quantity'];
  		$options['notes'] = $_POST['notes'];
  		
 		update_option('wp_delish', $options);
  		echo '<div class="updated fade"><p>Plugin settings saved.</p></div>';
  	}
  
  	
  	$action_url = $_SERVER['REQUEST_URI'];	
  
  	$title = stripslashes($options['title']);
  	$taglink = $options['taglink'] == 'on' ? 'checked' : '';
  	$username = $options['username'];
  	$quantity = $options['quantity'];
  	$notes = $options['notes'] == 'on' ? 'checked' : '';
  	
  	// URL for form submit, equals our current page
  	$action_url = $_SERVER['REQUEST_URI'];
  	
  	include('delish-options.php');

  }
?>