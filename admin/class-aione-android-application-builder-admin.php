<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://sgssandhu.com/
 * @since      1.0.0
 *
 * @package    Aione_Android_Application_Builder
 * @subpackage Aione_Android_Application_Builder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Aione_Android_Application_Builder
 * @subpackage Aione_Android_Application_Builder/admin
 * @author     SGS Sandhu <sgs.sandhu@gmail.com>
 */
class Aione_Android_Application_Builder_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		add_action( 'admin_menu', array( $this, 'aione_android_application_builder_admin_menu_hook' ) );
		
		add_action( 'init', array( $this, 'register_app_pages_post_type' ) );
		
		// Add function on admin initalization.
		add_action('admin_init', array($this, 'ink_options_setup'));

		// Call Function to store value into database.
		add_action('init', array($this, 'store_in_database'));

		// Call Function to delete image.
		add_action('init', array($this, 'delete_image'));
		
		// Add meta box to App Pages(app_pages) Post type 
		add_action('add_meta_boxes',  array($this, 'aione_android_application_builder_meta_box'));
		
		// Save meta box values into database.
		add_action('save_post', 'save_aione_android_application_builder_meta_box');


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Aione_Android_Application_Builder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aione_Android_Application_Builder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/aione-android-application-builder-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name .'_ion_icons' , 'http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Aione_Android_Application_Builder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aione_Android_Application_Builder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/aione-android-application-builder-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('media-upload'); //Provides all the functions needed to upload, validate and give format to files.
		wp_enqueue_script('thickbox'); //Responsible for managing the modal window.
		wp_enqueue_style('thickbox'); //Provides the styles needed for this window.

	}
	
	function aione_android_application_builder_admin_menu_hook(){  
		 add_menu_page( 
			__('Android Builder', 'aione_android_app_builder'),
			__('Android Builder', 'aione_android_app_builder'),
			__('manage_options', 'aione_android_app_builder'),
			'aione_android_app_builder', 
			false,
			'dashicons-smartphone',
			29 
		); 
		
		$page = 'add_submenu_page';
		 // Settings
            $page(
				__('aione_android_app_builder', 'aione_android_app_builder'),
				__('Settings', 'aione_android_app_builder'),
				__('Settings', 'aione_android_app_builder'),
				__('manage_options', 'aione_android_app_builder'),
				__('aione_android_app_builder_settings', 'aione_android_app_builder'),
				array($this,'aione_android_app_builder_settings')
			);
		 // Preview
            $page(
				__('aione_android_app_builder', 'aione_android_app_builder'),
				__('Preview', 'aione_android_app_builder'),
				__('Preview', 'aione_android_app_builder'),
				__('manage_options', 'aione_android_app_builder'),
				__('aione_android_app_builder_preview', 'aione_android_app_builder'),
				array($this,'aione_android_app_builder_preview')
			);	
		
	}
	
	// Register Custom Post Type
	function register_app_pages_post_type() {
		
		register_post_type( 'app_pages',
			array(
					'labels' => array(
							'name' => __( 'App Pages' ),
							'singular_name' => __( 'App Page' ),
							'menu_name'             => __( 'App Pages', 'text_domain' ),
							'name_admin_bar'        => __( 'App Pages', 'text_domain' ),
							'archives'              => __( 'Item Archives', 'text_domain' ),
							'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
							'all_items'             => __( 'App Pages', 'text_domain' ),
							'add_new_item'          => __( 'Add New Page', 'text_domain' ),
							'add_new'               => __( 'Add New Page', 'text_domain' ),
							'new_item'              => __( 'New Page', 'text_domain' ),
							'edit_item'             => __( 'Edit Page', 'text_domain' ),
							'update_item'           => __( 'Update Page', 'text_domain' ),
							'view_item'             => __( 'View Page', 'text_domain' ),
							'search_items'          => __( 'Search Page', 'text_domain' ),
							'not_found'             => __( 'Not found', 'text_domain' ),
							'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
							'featured_image'        => __( 'Featured Image', 'text_domain' ),
							'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
							'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
							'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
							'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
							'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
							'items_list'            => __( 'App Pages list', 'text_domain' ),
							'items_list_navigation' => __( 'App Pages list navigation', 'text_domain' ),
							'filter_items_list'     => __( 'Filter App Pages', 'text_domain' ),
					),
			'public' => true,
			'has_archive' => true,
			'show_in_menu' => 'aione_android_app_builder'
			)
		); 

	} //register_app_pages_post_type
	
	
	//Function for creating the metabox for App pages
	function aione_android_application_builder_meta_box() {
	   add_meta_box(
		   'aione_android_application_builder_meta_box',		// $id
		   'Page Settings',                  					// $title
		   array($this,'aione_android_application_builder_meta_box_content'),		// $callback
		   'app_pages',											// $page
		   'normal',                  // $context
		   'high'                     // $priority
	   );
	}
	
	//Function for Content in the metabox for App pages
	function aione_android_application_builder_meta_box_content() {
		
		$icons = array("ion-ionic","ion-arrow-up-a","ion-arrow-right-a","ion-arrow-down-a","ion-arrow-left-a","ion-arrow-up-b","ion-arrow-right-b","ion-arrow-down-b","ion-arrow-left-b","ion-arrow-up-c","ion-arrow-right-c","ion-arrow-down-c","ion-arrow-left-c","ion-arrow-return-right","ion-arrow-return-left","ion-arrow-swap","ion-arrow-shrink","ion-arrow-expand","ion-arrow-move","ion-arrow-resize","ion-chevron-up","ion-chevron-right","ion-chevron-down","ion-chevron-left","ion-navicon-round","ion-navicon","ion-drag","ion-log-in","ion-log-out","ion-checkmark-round","ion-checkmark","ion-checkmark-circled","ion-close-round","ion-close","ion-close-circled","ion-plus-round","ion-plus","ion-plus-circled","ion-minus-round","ion-minus","ion-minus-circled","ion-information","ion-information-circled","ion-help","ion-help-circled","ion-backspace-outline","ion-backspace","ion-help-buoy","ion-asterisk","ion-alert","ion-alert-circled","ion-refresh","ion-loop","ion-shuffle","ion-home","ion-search","ion-flag","ion-star","ion-heart","ion-heart-broken","ion-gear-a","ion-gear-b","ion-toggle-filled","ion-toggle","ion-settings","ion-wrench","ion-hammer","ion-edit","ion-trash-a","ion-trash-b","ion-document","ion-document-text","ion-clipboard","ion-scissors","ion-funnel","ion-bookmark","ion-email","ion-email-unread","ion-folder","ion-filing","ion-archive","ion-reply","ion-reply-all","ion-forward","ion-share","ion-paper-airplane","ion-link","ion-paperclip","ion-compose","ion-briefcase","ion-medkit","ion-at","ion-pound","ion-quote","ion-cloud","ion-upload","ion-more","ion-grid","ion-calendar","ion-clock","ion-compass","ion-pinpoint","ion-pin","ion-navigate","ion-location","ion-map","ion-lock-combination","ion-locked","ion-unlocked","ion-key","ion-arrow-graph-up-right","ion-arrow-graph-down-right","ion-arrow-graph-up-left","ion-arrow-graph-down-left","ion-stats-bars","ion-connection-bars","ion-pie-graph","ion-chatbubble","ion-chatbubble-working","ion-chatbubbles","ion-chatbox","ion-chatbox-working","ion-chatboxes","ion-person","ion-person-add","ion-person-stalker","ion-woman","ion-man","ion-female","ion-male","ion-transgender","ion-fork","ion-knife","ion-spoon","ion-soup-can-outline","ion-soup-can","ion-beer","ion-wineglass","ion-coffee","ion-icecream","ion-pizza","ion-power","ion-mouse","ion-battery-full","ion-battery-half","ion-battery-low","ion-battery-empty","ion-battery-charging","ion-wifi","ion-bluetooth","ion-calculator","ion-camera","ion-eye","ion-eye-disabled","ion-flash","ion-flash-off","ion-qr-scanner","ion-image","ion-images","ion-wand","ion-contrast","ion-aperture","ion-crop","ion-easel","ion-paintbrush","ion-paintbucket","ion-monitor","ion-laptop","ion-ipad","ion-iphone","ion-ipod","ion-printer","ion-usb","ion-outlet","ion-bug","ion-code","ion-code-working","ion-code-download","ion-fork-repo","ion-network","ion-pull-request","ion-merge","ion-xbox","ion-playstation","ion-steam","ion-closed-captioning","ion-videocamera","ion-film-marker","ion-disc","ion-headphone","ion-music-note","ion-radio-waves","ion-speakerphone","ion-mic-a","ion-mic-b","ion-mic-c","ion-volume-high","ion-volume-medium","ion-volume-low","ion-volume-mute","ion-levels","ion-play","ion-pause","ion-stop","ion-record","ion-skip-forward","ion-skip-backward","ion-eject","ion-bag","ion-card","ion-cash","ion-pricetag","ion-pricetags","ion-thumbsup","ion-thumbsdown","ion-happy-outline","ion-happy","ion-sad-outline","ion-sad","ion-bowtie","ion-tshirt-outline","ion-tshirt","ion-trophy","ion-podium","ion-ribbon-a","ion-ribbon-b","ion-university","ion-magnet","ion-beaker","ion-erlenmeyer-flask","ion-egg","ion-earth","ion-planet","ion-lightbulb","ion-cube","ion-leaf","ion-waterdrop","ion-flame","ion-fireball","ion-bonfire","ion-umbrella","ion-nuclear","ion-no-smoking","ion-thermometer","ion-speedometer","ion-model-s","ion-plane","ion-jet","ion-load-a","ion-load-b","ion-load-c","ion-load-d","ion-ios-ionic-outline","ion-ios-arrow-back","ion-ios-arrow-forward","ion-ios-arrow-up","ion-ios-arrow-right","ion-ios-arrow-down","ion-ios-arrow-left","ion-ios-arrow-thin-up","ion-ios-arrow-thin-right","ion-ios-arrow-thin-down","ion-ios-arrow-thin-left","ion-ios-circle-filled","ion-ios-circle-outline","ion-ios-checkmark-empty","ion-ios-checkmark-outline","ion-ios-checkmark","ion-ios-plus-empty","ion-ios-plus-outline","ion-ios-plus","ion-ios-close-empty","ion-ios-close-outline","ion-ios-close","ion-ios-minus-empty","ion-ios-minus-outline","ion-ios-minus","ion-ios-information-empty","ion-ios-information-outline","ion-ios-information","ion-ios-help-empty","ion-ios-help-outline","ion-ios-help","ion-ios-search","ion-ios-search-strong","ion-ios-star","ion-ios-star-half","ion-ios-star-outline","ion-ios-heart","ion-ios-heart-outline","ion-ios-more","ion-ios-more-outline","ion-ios-home","ion-ios-home-outline","ion-ios-cloud","ion-ios-cloud-outline","ion-ios-cloud-upload","ion-ios-cloud-upload-outline","ion-ios-cloud-download","ion-ios-cloud-download-outline","ion-ios-upload","ion-ios-upload-outline","ion-ios-download","ion-ios-download-outline","ion-ios-refresh","ion-ios-refresh-outline","ion-ios-refresh-empty","ion-ios-reload","ion-ios-loop-strong","ion-ios-loop","ion-ios-bookmarks","ion-ios-bookmarks-outline","ion-ios-book","ion-ios-book-outline","ion-ios-flag","ion-ios-flag-outline","ion-ios-glasses","ion-ios-glasses-outline","ion-ios-browsers","ion-ios-browsers-outline","ion-ios-at","ion-ios-at-outline","ion-ios-pricetag","ion-ios-pricetag-outline","ion-ios-pricetags","ion-ios-pricetags-outline","ion-ios-cart","ion-ios-cart-outline","ion-ios-chatboxes","ion-ios-chatboxes-outline","ion-ios-chatbubble","ion-ios-chatbubble-outline","ion-ios-cog","ion-ios-cog-outline","ion-ios-gear","ion-ios-gear-outline","ion-ios-settings","ion-ios-settings-strong","ion-ios-toggle","ion-ios-toggle-outline","ion-ios-analytics","ion-ios-analytics-outline","ion-ios-pie","ion-ios-pie-outline","ion-ios-pulse","ion-ios-pulse-strong","ion-ios-filing","ion-ios-filing-outline","ion-ios-box","ion-ios-box-outline","ion-ios-compose","ion-ios-compose-outline","ion-ios-trash","ion-ios-trash-outline","ion-ios-copy","ion-ios-copy-outline","ion-ios-email","ion-ios-email-outline","ion-ios-undo","ion-ios-undo-outline","ion-ios-redo","ion-ios-redo-outline","ion-ios-paperplane","ion-ios-paperplane-outline","ion-ios-folder","ion-ios-folder-outline","ion-ios-paper","ion-ios-paper-outline","ion-ios-list","ion-ios-list-outline","ion-ios-world","ion-ios-world-outline","ion-ios-alarm","ion-ios-alarm-outline","ion-ios-speedometer","ion-ios-speedometer-outline","ion-ios-stopwatch","ion-ios-stopwatch-outline","ion-ios-timer","ion-ios-timer-outline","ion-ios-clock","ion-ios-clock-outline","ion-ios-time","ion-ios-time-outline","ion-ios-calendar","ion-ios-calendar-outline","ion-ios-photos","ion-ios-photos-outline","ion-ios-albums","ion-ios-albums-outline","ion-ios-camera","ion-ios-camera-outline","ion-ios-reverse-camera","ion-ios-reverse-camera-outline","ion-ios-eye","ion-ios-eye-outline","ion-ios-bolt","ion-ios-bolt-outline","ion-ios-color-wand","ion-ios-color-wand-outline","ion-ios-color-filter","ion-ios-color-filter-outline","ion-ios-grid-view","ion-ios-grid-view-outline","ion-ios-crop-strong","ion-ios-crop","ion-ios-barcode","ion-ios-barcode-outline","ion-ios-briefcase","ion-ios-briefcase-outline","ion-ios-medkit","ion-ios-medkit-outline","ion-ios-medical","ion-ios-medical-outline","ion-ios-infinite","ion-ios-infinite-outline","ion-ios-calculator","ion-ios-calculator-outline","ion-ios-keypad","ion-ios-keypad-outline","ion-ios-telephone","ion-ios-telephone-outline","ion-ios-drag","ion-ios-location","ion-ios-location-outline","ion-ios-navigate","ion-ios-navigate-outline","ion-ios-locked","ion-ios-locked-outline","ion-ios-unlocked","ion-ios-unlocked-outline","ion-ios-monitor","ion-ios-monitor-outline","ion-ios-printer","ion-ios-printer-outline","ion-ios-game-controller-a","ion-ios-game-controller-a-outline","ion-ios-game-controller-b","ion-ios-game-controller-b-outline","ion-ios-americanfootball","ion-ios-americanfootball-outline","ion-ios-baseball","ion-ios-baseball-outline","ion-ios-basketball","ion-ios-basketball-outline","ion-ios-tennisball","ion-ios-tennisball-outline","ion-ios-football","ion-ios-football-outline","ion-ios-body","ion-ios-body-outline","ion-ios-person","ion-ios-person-outline","ion-ios-personadd","ion-ios-personadd-outline","ion-ios-people","ion-ios-people-outline","ion-ios-musical-notes","ion-ios-musical-note","ion-ios-bell","ion-ios-bell-outline","ion-ios-mic","ion-ios-mic-outline","ion-ios-mic-off","ion-ios-volume-high","ion-ios-volume-low","ion-ios-play","ion-ios-play-outline","ion-ios-pause","ion-ios-pause-outline","ion-ios-recording","ion-ios-recording-outline","ion-ios-fastforward","ion-ios-fastforward-outline","ion-ios-rewind","ion-ios-rewind-outline","ion-ios-skipbackward","ion-ios-skipbackward-outline","ion-ios-skipforward","ion-ios-skipforward-outline","ion-ios-shuffle-strong","ion-ios-shuffle","ion-ios-videocam","ion-ios-videocam-outline","ion-ios-film","ion-ios-film-outline","ion-ios-flask","ion-ios-flask-outline","ion-ios-lightbulb","ion-ios-lightbulb-outline","ion-ios-wineglass","ion-ios-wineglass-outline","ion-ios-pint","ion-ios-pint-outline","ion-ios-nutrition","ion-ios-nutrition-outline","ion-ios-flower","ion-ios-flower-outline","ion-ios-rose","ion-ios-rose-outline","ion-ios-paw","ion-ios-paw-outline","ion-ios-flame","ion-ios-flame-outline","ion-ios-sunny","ion-ios-sunny-outline","ion-ios-partlysunny","ion-ios-partlysunny-outline","ion-ios-cloudy","ion-ios-cloudy-outline","ion-ios-rainy","ion-ios-rainy-outline","ion-ios-thunderstorm","ion-ios-thunderstorm-outline","ion-ios-snowy","ion-ios-moon","ion-ios-moon-outline","ion-ios-cloudy-night","ion-ios-cloudy-night-outline","ion-android-arrow-up","ion-android-arrow-forward","ion-android-arrow-down","ion-android-arrow-back","ion-android-arrow-dropup","ion-android-arrow-dropup-circle","ion-android-arrow-dropright","ion-android-arrow-dropright-circle","ion-android-arrow-dropdown","ion-android-arrow-dropdown-circle","ion-android-arrow-dropleft","ion-android-arrow-dropleft-circle","ion-android-add","ion-android-add-circle","ion-android-remove","ion-android-remove-circle","ion-android-close","ion-android-cancel","ion-android-radio-button-off","ion-android-radio-button-on","ion-android-checkmark-circle","ion-android-checkbox-outline-blank","ion-android-checkbox-outline","ion-android-checkbox-blank","ion-android-checkbox","ion-android-done","ion-android-done-all","ion-android-menu","ion-android-more-horizontal","ion-android-more-vertical","ion-android-refresh","ion-android-sync","ion-android-wifi","ion-android-call","ion-android-apps","ion-android-settings","ion-android-options","ion-android-funnel","ion-android-search","ion-android-home","ion-android-cloud-outline","ion-android-cloud","ion-android-download","ion-android-upload","ion-android-cloud-done","ion-android-cloud-circle","ion-android-favorite-outline","ion-android-favorite","ion-android-star-outline","ion-android-star-half","ion-android-star","ion-android-calendar","ion-android-alarm-clock","ion-android-time","ion-android-stopwatch","ion-android-watch","ion-android-locate","ion-android-navigate","ion-android-pin","ion-android-compass","ion-android-map","ion-android-walk","ion-android-bicycle","ion-android-car","ion-android-bus","ion-android-subway","ion-android-train","ion-android-boat","ion-android-plane","ion-android-restaurant","ion-android-bar","ion-android-cart","ion-android-camera","ion-android-image","ion-android-film","ion-android-color-palette","ion-android-create","ion-android-mail","ion-android-drafts","ion-android-send","ion-android-archive","ion-android-delete","ion-android-attach","ion-android-share","ion-android-share-alt","ion-android-bookmark","ion-android-document","ion-android-clipboard","ion-android-list","ion-android-folder-open","ion-android-folder","ion-android-print","ion-android-open","ion-android-exit","ion-android-contract","ion-android-expand","ion-android-globe","ion-android-chat","ion-android-textsms","ion-android-hangout","ion-android-happy","ion-android-sad","ion-android-person","ion-android-people","ion-android-person-add","ion-android-contact","ion-android-contacts","ion-android-playstore","ion-android-lock","ion-android-unlock","ion-android-microphone","ion-android-microphone-off","ion-android-notifications-none","ion-android-notifications","ion-android-notifications-off","ion-android-volume-mute","ion-android-volume-down","ion-android-volume-up","ion-android-volume-off","ion-android-hand","ion-android-desktop","ion-android-laptop","ion-android-phone-portrait","ion-android-phone-landscape","ion-android-bulb","ion-android-sunny","ion-android-alert","ion-android-warning","ion-social-twitter","ion-social-twitter-outline","ion-social-facebook","ion-social-facebook-outline","ion-social-googleplus","ion-social-googleplus-outline","ion-social-google","ion-social-google-outline","ion-social-dribbble","ion-social-dribbble-outline","ion-social-octocat","ion-social-github","ion-social-github-outline","ion-social-instagram","ion-social-instagram-outline","ion-social-whatsapp","ion-social-whatsapp-outline","ion-social-snapchat","ion-social-snapchat-outline","ion-social-foursquare","ion-social-foursquare-outline","ion-social-pinterest","ion-social-pinterest-outline","ion-social-rss","ion-social-rss-outline","ion-social-tumblr","ion-social-tumblr-outline","ion-social-wordpress","ion-social-wordpress-outline","ion-social-reddit","ion-social-reddit-outline","ion-social-hackernews","ion-social-hackernews-outline","ion-social-designernews","ion-social-designernews-outline","ion-social-yahoo","ion-social-yahoo-outline","ion-social-buffer","ion-social-buffer-outline","ion-social-skype","ion-social-skype-outline","ion-social-linkedin","ion-social-linkedin-outline","ion-social-vimeo","ion-social-vimeo-outline","ion-social-twitch","ion-social-twitch-outline","ion-social-youtube","ion-social-youtube-outline","ion-social-dropbox","ion-social-dropbox-outline","ion-social-apple","ion-social-apple-outline","ion-social-android","ion-social-android-outline","ion-social-windows","ion-social-windows-outline","ion-social-html5","ion-social-html5-outline","ion-social-css3","ion-social-css3-outline","ion-social-javascript","ion-social-javascript-outline","ion-social-angular","ion-social-angular-outline","ion-social-nodejs","ion-social-sass","ion-social-python","ion-social-chrome","ion-social-chrome-outline","ion-social-codepen","ion-social-codepen-outline","ion-social-markdown","ion-social-tux","ion-social-freebsd-devil","ion-social-usd","ion-social-usd-outline","ion-social-bitcoin","ion-social-bitcoin-outline","ion-social-yen","ion-social-yen-outline","ion-social-euro","ion-social-euro-outline");
		
		$output .= '<table class="form-table">
				<tbody>
				<tr>
				<th scope="row"><label for="android_page_icon">Page Icon</label></th>
				<td>
				<select name="android_page_icon" id="android_page_icon">';
				foreach($icons as $icon){
					$output .= '<option value="'.$icon.'">'.$icon.'</option>';
				}
		$output .= '</select>
				</td>
				</tr>
				<tr>
				<th scope="row"><label for="android_show_in_menu">Show Page in Menu</label></th>
				<td>
				<select name="android_show_in_menu" id="android_show_in_menu">
				<option value="1">Yes</option>
				<option value="0">No</option>
				</select>
				</td>
				</tr>
				<tr>
			
				</tbody></table>';
		
		echo $output;
	   
	}
	
	//Function fto save metabox values in custom fields
	function save_aione_android_application_builder_meta_box($post_id){
		
		if ( get_post_type( $post_id) == 'app_pages'){
		
		return 1;
		
		} else {
		return 1;
		}	
	}
	
	
	 
	
	
	
	

	// Andriod App Settings
	function aione_android_app_builder_settings(){
		global $wpdb;
		$andriod_app_name = get_option('andriod_app_name');
		$andriod_app_domain = get_option('andriod_app_domain');
		$andriod_app_theme = get_option('andriod_app_theme');
		$andriod_app_icon = get_option('andriod_app_icon');
		$andriod_app_footer_content = stripslashes(get_option('andriod_app_footer_content'));

		?>
		<div class="wrap"> 
			<h2>Andriod App Settings</h2>
			<div class="">
				<form name="" class="" id="" method="post" action="" enctype="multipart/form-data">
				<table class="form-table">
				<tbody>
				<tr>
				<th scope="row"><label for="andriod_app_name">App Name</label></th>
				<td><input name="andriod_app_name" type="text" id="andriod_app_name" value="<?php echo $andriod_app_name; ?>" class="regular-text"></td>
				</tr>
				<tr>
				<th scope="row"><label for="andriod_app_domain">App Domain</label></th>
				<td><input name="andriod_app_domain" type="text" id="andriod_app_domain" value="<?php echo $andriod_app_domain; ?>" class="regular-text"></td>
				</tr>
				<th scope="row"><label for="andriod_app_domain">App Theme</label></th>
				<td><select name="andriod_app_theme">
				<option value="royal" <?php if($andriod_app_theme == "royal"){echo 'selected="selected"';} ?> >Royal</option>
				<option value="clean" <?php if($andriod_app_theme == "clean"){echo 'selected="selected"';} ?>>Clean</option>
				</select></td>
				</tr>
				

				<tr>
				<th scope="row"><label for="andriod_app_icon">App Icon</label></th>
				<td>
				<input type="text" name="path" class="image_path" id="image_path" value="<?php echo $andriod_app_icon; ?>" >
				<input type="button" value="Upload Image" class="button-primary" id="upload_image"/> Upload your Image from here.
				<div id="show_upload_preview">

				<?php if(! empty($andriod_app_icon)){
				?>
				<img src="<?php echo $andriod_app_icon ; ?>">
				<input type="submit" name="remove" value="Remove Image" class="button-secondary" id="remove_image"/>
				<?php } ?>
				</div>
				</td>
				</tr>
				<tr>
				<th scope="row"><label for="andriod_app_footer_content">App Footer Content</label></th>
				<td>
				<textarea name="andriod_app_footer_content" id="andriod_app_footer_content" class="regular-text textarea"><?php echo $andriod_app_footer_content; ?></textarea>
				</td>
				</tr>

				</tbody></table>

				
				<p class="submit"><input type="submit" id="submit_button" name="app_setting_save" class="button button-primary" value="Save Settings"></p>
				</form>
			</div>
		</div>


		<?php
	} //aione_android_app_builder_settings

	

	public function ink_options_setup() {
		global $pagenow;
		if ('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) {
		// Now we will replace the 'Insert into Post Button inside Thickbox'
		add_filter('gettext', array($this, 'replace_window_text'), 1, 2);
		// gettext filter and every sentence.
		}
	}

	function replace_window_text($translated_text, $text) {
		if ('Insert into Post' == $text) {
		$referer = strpos(wp_get_referer(), 'media_page');
		if ($referer != '') {
		return __('Upload Image', 'ink');
		}
		}
		return $translated_text;
	}

	public function store_in_database(){
		if(isset($_POST['app_setting_save'])){
			$andriod_app_name=$_POST['andriod_app_name'];
			$andriod_app_domain=$_POST['andriod_app_domain'];
			$andriod_app_theme=$_POST['andriod_app_theme'];
			$andriod_app_icon = $_POST['path'];
			$andriod_app_footer_content = $_POST['andriod_app_footer_content'];
			update_option('andriod_app_name', $andriod_app_name);
			update_option('andriod_app_domain', $andriod_app_domain);
			update_option('andriod_app_theme', $andriod_app_theme);
			update_option('andriod_app_icon', $andriod_app_icon);
			update_option('andriod_app_footer_content', $andriod_app_footer_content);
			//update_option('ink_image', $image_path);
		}
	}

	function delete_image() {
		if(isset($_POST['remove'])){
		global $wpdb;
		$img_path = $_POST['path'];

		// We need to get the images meta ID.
		$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($img_path) . "' AND post_type = 'attachment'";
		$results = $wpdb->get_results($query);

		// And delete it
		foreach ( $results as $row ) {
		wp_delete_attachment( $row->ID ); //delete the image and also delete the attachment from the Media Library.
		}
		delete_option('andriod_app_icon'); //delete image path from database.
		}
	}
	
	function aione_android_app_builder_preview(){
		
		$output = "<h1> Preview </h1>";
		$output .= '<div class="preview-outer-div">
					<div class="image-panel-right">
					<div class="mobile-frame">
					<div class="mobile-screen">
					<img src="https://socialcops.com/images/old/spec/platform/collect/feature-img-monitoring-386.gif"></div>
					</div>
					</div>
					</div>';
		$output .= '<style>
			.preview-outer-div {
				width:40%;
				margin:0 auto;
			}
			.image-panel-right {
				-webkit-box-ordinal-group: 3;
				-webkit-order: 2;
				-ms-flex-order: 2;
				order: 2;
				-webkit-flex-shrink: 1;
				-ms-flex-negative: 1;
				flex-shrink: 1;
				position: relative;
				-webkit-flex-basis: 40%;
				-ms-flex-preferred-size: 40%;
				flex-basis: 40%;
				-webkit-box-flex: 1;
				-webkit-flex-grow: 1;
				-ms-flex-positive: 1;
				flex-grow: 1;
			}
			.mobile-frame {
				position: relative;
				display: inline-block;
				background: #4f4c4b;
				padding: 7rem 1rem;
				-webkit-border-radius: 18rem/3rem;
				border-radius: 18rem/3rem;
				bottom: -13rem;
				margin-top: -13rem;
				-webkit-box-shadow: 0 0 8rem rgba(36,33,32,.1);
				box-shadow: 0 0 8rem rgba(36,33,32,.1);
				z-index: 1;
			}
			
			.mobile-frame:before {
				-webkit-border-radius: 1rem 0 0 1rem;
				border-radius: 1rem 0 0 1rem;
				left: -.5rem;
				height: 10rem;
				top: 20rem;
				position: absolute;
				width: .5rem;
				background: #242120;
				content: "";
			}
			.mobile-frame .mobile-screen {
				position: relative;
			}
			.mobile-frame .mobile-screen:before {
				content: "";
				position: absolute;
				top: -3rem;
				left: 50%;
				z-index: 10;
				background: #242120;
				height: .2rem;
				width: .2rem;
				-webkit-box-shadow: 0 0 0 10px #393736;
				box-shadow: 0 0 0 10px #393736;
				-webkit-border-radius: 1rem;
				border-radius: 1rem;
			}
			.mobile-frame .mobile-screen img {
				width: auto;
				-webkit-border-radius: .5rem;
				border-radius: .5rem;
				position: relative;
				max-width: 300px;
				max-height: 67vh;
				min-height: 40rem;
			}
			.mobile-frame:after {
				-webkit-border-radius: 0 1rem 1rem 0;
				border-radius: 0 1rem 1rem 0;
				right: -.5rem;
				height: 6rem;
				top: 12rem;
				position: absolute;
				width: .5rem;
				background: #242120;
				content: "";
			}
			
		
		</style>';
		echo $output;
		//return $output;
	}

}
