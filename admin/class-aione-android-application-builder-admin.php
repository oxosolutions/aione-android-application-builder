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

	// Andriod App Settings
	function aione_android_app_builder_settings(){
		global $wpdb;
		$andriod_app_name = get_option('andriod_app_name');
		$andriod_app_domain = get_option('andriod_app_domain');
		$andriod_app_theme = get_option('andriod_app_theme');
		$andriod_app_icon = get_option('andriod_app_icon');

		?>
		<div class="wrap">
			<h2>Andriod App Settings</h2>
			<div class="">
				<form name="" class="" id="" method="post" action="" enctype="multipart/form-data">
				<table class="form-table">
				<tbody>
				<tr>
				<th scope="row"><label for="andriod_app_name">App Name</label></th>
				<td><input name="andriod_app_name" type="text" id="andriod_app_name" value="<?php echo $andriod_app_name; ?> " class="regular-text" required></td>
				</tr>
				<tr>
				<th scope="row"><label for="andriod_app_domain">App Domain</label></th>
				<td><input name="andriod_app_domain" type="text" id="andriod_app_domain" value="<?php echo $andriod_app_domain; ?> " class="regular-text" required></td>
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
			update_option('andriod_app_name', $andriod_app_name);
			update_option('andriod_app_domain', $andriod_app_domain);
			update_option('andriod_app_theme', $andriod_app_theme);
			update_option('andriod_app_icon', $andriod_app_icon);
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
