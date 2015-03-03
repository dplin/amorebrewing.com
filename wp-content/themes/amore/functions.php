<?php
	// Useful constants
	define('HOME_URI', home_url());
	define('THEME_URI', get_stylesheet_directory_uri());
	define('THEME_IMAGES', THEME_URI . '/images');
	define('THEME_CSS', THEME_URI . '/css');
	define('THEME_JS', THEME_URI . '/js');
	
	add_action('after_setup_theme', 'amore_theme_setup');
	
	function amore_theme_setup() {
		/********************************************************** Front End Config **************************************************/
		
		// Add scripts & styles
		add_action('wp_enqueue_scripts', 'wc_jquery_enqueue', 11);		
		add_action('wp_enqueue_scripts', 'wc_stylesheet_enqueue');  			
		add_action('wp_head', 'wc_favicon');
		
		// Remove junk from <head>
		remove_action('wp_head', 'rsd_link');							// Disable link to Really Simple Discovery service
		remove_action('wp_head', 'wp_generator');						// Remove version number
		remove_action('wp_head', 'feed_links', 2);						// Remove Post and Comment Feeds
		remove_action('wp_head', 'index_rel_link');						// Canonic link
		remove_action('wp_head', 'wlwmanifest_link');					// Remove link to the Windows Live Writer manifest file.
		remove_action('wp_head', 'feed_links_extra', 3);				// Remove category feeds
		remove_action('wp_head', 'start_post_rel_link', 10, 0);			// start link
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);		// prev link
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);		// Remove relation links for the posts adjacent to the current post.	

		// Remove junks from navigation menu
		add_filter('nav_menu_css_class', 'wc_css_attributes_filter', 100, 1);
		add_filter('nav_menu_item_id', 'wc_css_attributes_filter', 100, 1);
		add_filter('page_css_class', 'wc_css_attributes_filter', 100, 1);		

		// Remove WP version
		add_filter('the_generator', 'wc_remove_wp_version');		
		
		/******************************************************* Back End Config (Admin) *********************************************/
	
		// Remove the Admin bar on top.
		show_admin_bar(false);

		// Set Permalink		
		add_action('init', 'wc_set_permalink');
		
		// Hide WP Upgrade Message
		add_action('admin_menu', 'wc_hidenag');
		
		// Enable "Home" in menu
		add_filter('wp_page_menu_args', 'wc_home_page_menu_args');
		
		// Enable "Menu" in Admin->Appearance
		add_theme_support('menus');
		register_nav_menus(array(
			'primary' => __( 'Primary Menu'),
			'secondary' => __( 'Secondary Menu')
		));	 
		
		// Enable Post-Thumbnail in post ONLY and add additional sizes.  Note: 'true' enables hard cropping so each image is exactly those dimensions and automatically cropped
		add_theme_support('post-thumbnaamore');
		add_image_size('310 x 180', 310, 180, true); // 310 pixels wide by 140 pixels high
		add_image_size('636 x 297', 636, 297, true); // 636 pixels wide by 297 pixels high
		add_image_size('260 x 222', 260, 222, true); //260 pixels wide by 222 pixels high				

		// Change WYSIWYG editor font style
		add_editor_style('css/custom-editor.css');
		
		// Change the home page to front-page.php instead of the default Blog
		wc_set_front_page();
		
		// Restrict upload file type
		//add_filter('wp_handle_upload_prefilter', 'wc_wp_handle_upload_prefilter');
		
		/****************************************************** Admin Branding *******************************************************/
		
		// Hide unwanted menu items - Disable Pre-built post type (Post, Comments)
		add_action('admin_menu', 'wc_remove_menu_pages', 999);
		
		// Hide theme editor submenu (Not needed if Theme menu is removed in "wc_remove_menu_pages()")
		//add_action('admin_init', 'wc_remove_theme_editor_menu', 102);	
		
		// Remove Dashboard widgets
		add_action('admin_menu', 'disable_default_dashboard_widgets');	
		
		// Remove default "Welcome to Wordpress" from Dashboard
		remove_action('welcome_panel', 'wp_welcome_panel');
		
		// Custom welcome message in Dashboard
		add_action('welcome_panel', 'wc_custom_welcome_panel');			
		
		// Custom css style for Dashboard
		add_action('admin_head', 'wc_custom_dashboard_css');

		// Set "screen option" to single column layout
		add_filter('get_user_option_screen_layout_dashboard', 'force_single_column_layout_dashboard' );	
	
		// Remove columns from POSTS list (Not needed if Posts menu page is removed in "wc_remove_menu_pages()")
		//add_filter('manage_edit-post_columns', 'wc_post_columns_filter', 10, 1 );
			
		// Remove columns from Pages list
		add_filter('manage_pages_columns', 'wc_pages_columns_filter');	
		
		// Remove "deactivation" link from Plugins page
		add_filter('plugin_action_links', 'disable_plugin_deactivation', 10, 4);	
		
		// Remove items from Admin Toolbar
		add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');
		
		// Hide Help tab
		add_action('admin_head', 'hide_help_tab');
		
		// Add custom admin Footer
		add_filter('admin_footer_text', 'wc_custom_admin_footer');	
		
		// Remove WP version in Admin footer.
		add_filter('update_footer', 'wc_custom_admin_footer_version', 9999);
		
		// Custom login page stylesheet
		add_action('login_head', 'wc_custom_login_css');
		
		// Custom login logo URL
		add_filter('login_headerurl', 'custom_loginlogo_url');
	}
 	
	function wc_jquery_enqueue() {
		// Load at Top
		wp_register_script('modernizr-js', THEME_JS . "/vendor/modernizr-2.6.2.min.js", false, null);	
		wp_enqueue_script('modernizr-js');		
		// Load at Bottom
		wp_deregister_script('jquery');
		wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://code.jquery.com/jquery-1.11.0.min.js", false, null);
		wp_enqueue_script('jquery');
		wp_register_script('superfish-js', THEME_JS . "/plugins/superfish.min.js", false, null);	
		wp_enqueue_script('superfish-js');		
		wp_register_script('main-js', THEME_JS . "/main.min.js", false, null);	
		wp_enqueue_script('main-js');				
		
		// Enqueue Page Specific Script
		if (is_page_template('page-faq.php')) { 
			wp_register_script('page-faq-js', THEME_JS . '/page/page-faq.min.js', array('jquery'), null, true); 
			wp_enqueue_script('page-faq-js');
		}elseif (is_page_template('page-systems.php')) { 
			wp_register_script('page-systems-js', THEME_JS . '/page/page-systems.min.js', array('jquery'), null, true); 
			wp_enqueue_script('page-systems-js');		
		}
	}		
			
	function wc_stylesheet_enqueue(){
		// Default Stylesheet
		wp_register_style('css-base', THEME_CSS. '/base.css', false, null);
		wp_register_style('css-skeleton', THEME_CSS. '/skeleton.css', false, null);		
		wp_register_style('css-layout', THEME_CSS. '/layout.css', false, null);		
		wp_register_style('css-normalize', THEME_CSS. '/normalize.min.css', false, null);		
		wp_register_style('css-font-awesome', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css", false, null);
		wp_register_style('css-superfish', THEME_CSS. '/superfish.css', false, null);				
		wp_register_style('css-google-font', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://fonts.googleapis.com/css?family=Kameron:400,700", false, null);
		wp_register_style('css-fancybox', THEME_CSS. '/jquery.fancybox.css', false, null);
		wp_register_style('css-main', THEME_CSS. '/main.css', false, null);
		wp_enqueue_style('css-base');		
		wp_enqueue_style('css-skeleton');		
		wp_enqueue_style('css-layout');		
		wp_enqueue_style('css-normalize');							
		wp_enqueue_style('css-font-awesome');
		wp_enqueue_style('css-superfish');		
		wp_enqueue_style('css-google-font');			
		wp_enqueue_style('css-fancybox');
		
		// Register Page Specific Stylesheet 
		wp_register_style('page-home-css', THEME_CSS. '/page-home.css', false, null);
		wp_register_style('page-who-we-are-css', THEME_CSS. '/page-who-we-are.css', false, null);
		wp_register_style('page-systems-css', THEME_CSS. '/page-systems.css', false, null);
		wp_register_style('page-beverages-css', THEME_CSS. '/page-beverages.css', false, null);
		wp_register_style('page-faq-css', THEME_CSS. '/page-faq.css', false, null);
		wp_register_style('page-contact-us-css', THEME_CSS. '/page-contact-us.css', false, null);
		
		// Enqueue Main Stylesheet		
		wp_enqueue_style('css-main');
		
		// Enqueue Page Specific Stylesheet
		if (is_front_page( )) { 		
			wp_enqueue_style('page-home-css');			
		}elseif (is_page_template('page-who-we-are.php')) { 
			wp_enqueue_style('page-who-we-are-css');			
		}elseif (is_page_template('page-systems.php')) { 
			wp_enqueue_style('page-systems-css');			
		}elseif (is_page_template('page-beverages.php')) { 
			wp_enqueue_style('page-beverages-css');			
		}elseif (is_page_template('page-faq.php')) { 
			wp_enqueue_style('page-faq-css');			
		}elseif (is_page_template('page-contact-us.php')) {  					
			wp_enqueue_style('page-contact-us-css');		
		}		
		
	}	
		
	function wc_css_attributes_filter($var) {
		return is_array($var) ? array() : '';
	}	
		
	function wc_favicon() {
		echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.THEME_URI.'/favicon.ico" />';
	}
		
	function wc_set_permalink(){
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure('/%postname%/');
	}	
	
	function wc_hidenag() {
		remove_action('admin_notices', 'update_nag', 3);
	}	
	
	function wc_home_page_menu_args($args) {
		$args['show_home'] = true;
		return $args;
	}	
	
	function wc_set_front_page() {
		// Create "Home" page if it doesn't exisit
		if (!get_page_by_title('Home')){
			// Create a Home page
			$home_page  = array(
				'post_title'     		=> 'Home',
				'post_type'      		=> 'page',
				'post_name'      		=> '',
				'post_content'   		=> '',
				'post_status'    		=> 'publish',
				'comment_status' 	=> 'closed',
				'ping_status'    		=> 'closed',
				'post_author'    		=> 1,
				'menu_order'     	=> 0,
				'guid'           			=> site_url()
			);			
			wp_insert_post($home_page, false);
		}
		
		// Set static front page
		$home_page = get_page_by_title('Home');
		update_option( 'page_on_front', $home_page->ID );					// Make sure a page called "Home" exist
		update_option( 'show_on_front', 'page' );
		//$blog_page   = get_page_by_title( 'Blog' );						// Make sure a page called "Blog" exist.  NOTE: Not needed since this theme doesn't support Blog.
		//update_option( 'page_for_posts', $blog_page->ID );			
	}

	function wc_wp_handle_upload_prefilter($file) {
	  // This bit is for the flash uploader
	  if ($file['type']=='application/octet-stream' && isset($file['tmp_name'])) {
		$file_size = getimagesize($file['tmp_name']);
		if (isset($file_size['error']) && $file_size['error']!=0) {
		  $file['error'] = "Unexpected Error: {$file_size['error']}";
		  return $file;
		} else {
		  $file['type'] = $file_size['mime'];
		}
	  }
	  list($category,$type) = explode('/',$file['type']);
	  if ('image'!=$category || !in_array($type,array('jpg','jpeg','gif','png'))) {
		$file['error'] = "Sorry, you can only upload a .GIF, a .JPG, or a .PNG image file.";
	  } else if ($post_id = (isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : false)) {
		if (count(get_posts("post_type=attachment&post_parent={$post_id}"))>0)
		  $file['error'] = "Sorry, you cannot upload more than one (1) image.";
	  }
	  return $file;
	}
	
	/******************* Admin Branding ******************/

	function wc_remove_menu_pages() {
		// Top level
		remove_menu_page('edit.php'); 												// Posts
		remove_menu_page('edit-comments.php'); 										// Comments
		remove_menu_page('themes.php');												// Appearance
		remove_menu_page('tools.php');												// Tools		
		remove_menu_page('edit.php?post_type=acf');									// Custom Fields (ACF)		
		
		// Sub-menus
		//remove_submenu_page('themes.php', 'customize.php');							// Appearance -> Customize
		//remove_submenu_page('themes.php', 'themes.php');							// Appearance -> Theme
		remove_submenu_page('plugins.php', 'plugin-editor.php');					// Plugins -> Editor
		remove_submenu_page('users.php', 'users.php');								// Users -> All Users
		remove_submenu_page('users.php', 'user-new.php');							// Users -> New				
		remove_submenu_page('options-general.php', 'options-writing.php');			// Settings -> Writing
		remove_submenu_page('options-general.php', 'options-reading.php');			// Settings -> Reading		
		remove_submenu_page('options-general.php', 'options-discussion.php');		// Settings -> Discussion		
		remove_submenu_page('options-general.php', 'options-media.php');			// Settings -> Media		
		remove_submenu_page('options-general.php', 'options-permalink.php');		// Settings -> Permalink		
	}	
	
	function wc_remove_theme_editor_menu() {
		remove_submenu_page('themes.php', 'theme-editor.php');			// Appearance -> Editor
	}	
		
	function disable_default_dashboard_widgets() {    
		remove_meta_box('dashboard_right_now', 'dashboard', 'core');  
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');  
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  
		remove_meta_box('dashboard_plugins', 'dashboard', 'core');  
		remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');  
		remove_meta_box('dashboard_primary', 'dashboard', 'core');  
		remove_meta_box('dashboard_secondary', 'dashboard', 'core');  
		remove_meta_box('dashboard_activity', 'dashboard', 'normal');
	}  	
		
	function wc_custom_welcome_panel() {
		echo
		'<div class="welcome-panel-content" style="padding-bottom:23px;">'
		.'<h3>Welcome to Amore Brewing Co.!</h3>'		
		.'</div>';
	}
	
	function wc_custom_dashboard_css() {
		echo '<style>
				#dashboard-widgets div.empty-container {
					border:none !important;
				}
			</style>'
		;
	}
		
	function force_single_column_layout_dashboard() {
		return 1;
	}
		
	function wc_post_columns_filter( $columns ) {
		unset($columns['author']);
		unset($columns['tags']);
		unset($columns['categories']);
		unset($columns['tags']);
		return $columns;
	} 		
 	
	function wc_pages_columns_filter($columns) {
		unset($columns['author']);
		unset($columns['comments']);		
		return $columns;
	}	
		
	function disable_plugin_deactivation( $actions, $plugin_file, $plugin_data, $context ) {
		// Remove edit link for all plugins
		if ( array_key_exists( 'edit', $actions ) )
			unset( $actions['edit'] );
		// Remove deactivate link for important plugins (ACF)
		if ( array_key_exists( 'deactivate', $actions ) && in_array( $plugin_file, array(
			'advanced-custom-fields/acf.php',
			'advanced-custom-fields-contact-form-7-field/acf-cf7.php',
			'acf-repeater/acf-repeater.php'
		)))
			unset( $actions['deactivate'] );
		return $actions;
	}
	
	function custom_loginlogo_url($url) {
		return 'http://www.amorebrewing.com';
	}	
	
	function remove_admin_bar_links() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('updates');
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('new-content');		
		$wp_admin_bar->remove_menu('search');		
		$wp_admin_bar->remove_menu('site-name');		
		$wp_admin_bar->remove_menu('wpseo-menu');		// WP SEO plugin link
	}
		
	function hide_help_tab() {
		echo '<style type="text/css">
				#contextual-help-link-wrap { display: none !important; }
		</style>';
	}
	
	function wc_custom_admin_footer() {
		echo '&copy; '.date("Y").' - <a href="http://www.amorebrewing.com">Amore Brewing Co.</a>';
	}
		
	function wc_custom_admin_footer_version() {return '';}
	
	function wc_remove_wp_version() {return '';}	
	
	function wc_custom_login_css() {
		  echo "<link href='".THEME_CSS."/wp-admin.css' rel='stylesheet' type='text/css'/>";
	}
?>