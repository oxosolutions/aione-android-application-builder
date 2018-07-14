<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://sgssandhu.com/
 * @since      1.0.0
 *
 * @package    Aione_Android_Application_Builder
 * @subpackage Aione_Android_Application_Builder/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Aione_Android_Application_Builder
 * @subpackage Aione_Android_Application_Builder/includes
 * @author     SGS Sandhu <sgs.sandhu@gmail.com>
 */
class Aione_Android_Application_Builder {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Aione_Android_Application_Builder_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'aione-android-application-builder';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_shortcode( 'aione-andriod-api', array($this, 'aione_andriod_api_shortcode') );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Aione_Android_Application_Builder_Loader. Orchestrates the hooks of the plugin.
	 * - Aione_Android_Application_Builder_i18n. Defines internationalization functionality.
	 * - Aione_Android_Application_Builder_Admin. Defines all hooks for the admin area.
	 * - Aione_Android_Application_Builder_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aione-android-application-builder-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-aione-android-application-builder-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-aione-android-application-builder-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-aione-android-application-builder-public.php';

		$this->loader = new Aione_Android_Application_Builder_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Aione_Android_Application_Builder_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Aione_Android_Application_Builder_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Aione_Android_Application_Builder_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Aione_Android_Application_Builder_Public( $this->get_plugin_name(), $this->get_version() );

		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Aione_Android_Application_Builder_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function aione_andriod_api_shortcode( $atts ) {
		extract( shortcode_atts(
				array(
					
				), $atts )
		);
		
		$app_id = $_REQUEST['app_id'];
		
		$app_secret = $_REQUEST['app_secret'];
		if(isset($app_id) && $app_id !='' ){
			
		} else {
			$app_id = 1;
		}
		
		$app_id = 7;
		//echo "=============".$app_id;
		global $switched;
		switch_to_blog($app_id);

		
		$api_array = array();
		$api_data_array = array();

		/*********************Pages************************/
		$args = array(
			'post_type' => 'app_pages',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			
		);
		$query = new WP_Query( $args );
		
		$total_pages = $query->post_count;
		$app_pages = $query->posts;
		$app_pages_array = array();
		$app_pages_settings_array = array();
		$app_pages_data_array = array();

		foreach($app_pages as $app_page){
			$page_array = array();
			
			$app_page_icon = 'ion-earth';
			$show_in_menu = 1;

			if(get_post_meta( $app_page->ID, 'android_page_icon', true )){
				$app_page_icon = get_post_meta( $app_page->ID, 'android_page_icon', true );
			}
			if(get_post_meta( $app_page->ID, 'android_show_in_menu', true )){
				$show_in_menu = get_post_meta( $app_page->ID, 'android_show_in_menu', true );
			}
			
			$page_array['id']			= $app_page->ID;
			$page_array['slug']			= $app_page->post_name;
			$page_array['title']		= $app_page->post_title;
			$page_array['content']		= $app_page->post_content;
			$page_array['icon']			= $app_page_icon;
			$page_array['show_in_menu']			= $show_in_menu;
			$page_array['created_by']	= $app_page->post_author;
			$page_array['created_at']	= $app_page->post_date;
			$page_array['modified_at']	= $app_page->post_modified;

			array_push($app_pages_data_array, $page_array); 
		}
		/****************** Settings ***************/
		$app_pages_settings_array['single'] = get_option('andriod_app_page_single_template');
		$app_pages_settings_array['archive'] = get_option('andriod_app_page_archive_template');
		$app_pages_settings_array['css'] = get_option('andriod_app_page_template_custom_css');
		$app_pages_settings_array['js'] = get_option('andriod_app_page_template_custom_js');
		/****************** END Settings ***************/
		$app_pages_array['template_settings'] = $app_pages_settings_array;
		$app_pages_array['data'] = $app_pages_data_array;
		/*********************Posts****************************/
		$post_args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			
		);
		$post_query = new WP_Query( $post_args );
		
		$post_total_pages = $post_query->post_count;
		$app_posts = $post_query->posts;
		$app_posts_array = array();
		$app_posts_settings_array = array();
		$app_posts_data_array = array();

		foreach($app_posts as $app_post){
			$post_array = array();
			
			$app_post_icon = 'ion-earth';
			$show_in_menu = 1;
			$featured_image_url = get_the_post_thumbnail_url($app_post->ID,'full');
			$post_array['id']			= $app_post->ID;
			$post_array['slug']			= $app_post->post_name;
			$post_array['title']		= $app_post->post_title;
			$post_array['content']		= $app_post->post_content;
			$post_array['icon']			= $app_post_icon;
			$post_array['show_in_menu']			= $show_in_menu;
			$post_array['created_by']	= $app_post->post_author;
			$post_array['created_at']	= $app_post->post_date;
			$post_array['modified_at']	= $app_post->post_modified;
			$post_array['featured_image_url']	= $featured_image_url;


			array_push($app_posts_data_array, $post_array); 
		}

		/****************** Settings ***************/
		$app_posts_settings_array['single'] = get_option('andriod_app_post_single_template');
		$app_posts_settings_array['archive'] = get_option('andriod_app_post_archive_template');
		$app_posts_settings_array['css'] = get_option('andriod_app_post_template_custom_css');
		$app_posts_settings_array['js'] = get_option('andriod_app_post_template_custom_js');
		/****************** END Settings ***************/

		$app_posts_array['template_settings'] = $app_posts_settings_array;
		$app_posts_array['data'] = $app_posts_data_array;


		/********************Products*****************************/
		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			
		);
		$query = new WP_Query( $args );
		
		$total_pages = $query->post_count;
		$app_products = $query->posts;
		$app_products_array = array();
		$app_products_settings_array = array();
		$app_products_data_array = array();

		foreach($app_products as $app_product){
			$product_array = array();
			
			$app_product_icon = 'ion-earth';
			$show_in_menu = 1;

			if(get_post_meta( $app_product->ID, '_regular_price', true )){
				$regular_price = get_post_meta( $app_product->ID, '_regular_price', true );
			}
			if(get_post_meta( $app_product->ID, '_sale_price', true )){
				$sale_price = get_post_meta( $app_product->ID, '_sale_price', true );
			}
			if(get_post_meta( $app_product->ID, '_product_attributes', true )){
				$product_attributes = get_post_meta( $app_product->ID, '_product_attributes', true );
			}
			if(get_post_meta( $app_product->ID, '_stock_status', true )){
				$stock_status = get_post_meta( $app_product->ID, '_stock_status', true );
			}

			$featured_image_url = get_the_post_thumbnail_url($app_product->ID,'full');
			$currency = get_option( 'woocommerce_currency' );
			
			$product_array['id']			= $app_product->ID;
			$product_array['slug']			= $app_product->post_name;
			$product_array['title']		= $app_product->post_title;
			$product_array['content']		= $app_product->post_content;
			$product_array['excerpt']		= $app_product->post_excerpt;
			$product_array['icon']			= $app_product_icon;
			$product_array['show_in_menu']			= $show_in_menu;
			$product_array['created_by']	= $app_product->post_author;
			$product_array['created_at']	= $app_product->post_date;
			$product_array['modified_at']	= $app_product->post_modified;
			$product_array['regular_price']	= $regular_price;
			$product_array['sale_price']	= $sale_price;
			$product_array['product_attributes']	= $product_attributes;
			$product_array['stock_status']	= $stock_status;
			$product_array['featured_image_url']	= $featured_image_url;
			$product_array['currency']	= $currency;

			array_push($app_products_data_array, $product_array); 
		}

		/****************** Settings ***************/
		$app_products_settings_array['single'] = get_option("andriod_app_product_single_template");
		$app_products_settings_array['archive'] = get_option("andriod_app_product_archive_template");
		$app_products_settings_array['css'] = get_option("andriod_app_product_custom_css");
		$app_products_settings_array['js'] = get_option("andriod_app_product_custom_js");
		/****************** END Settings ***************/

		$app_products_array['template_settings'] = $app_products_settings_array;
		$app_products_array['data'] = $app_products_data_array;


		/********************Common Settings*****************************/
		$app_setting_array = array();
		$andriod_app_name = stripslashes(trim(get_option('andriod_app_name')));
		$andriod_app_menu_title = stripslashes(trim(get_option('andriod_app_menu_title')));
		$andriod_app_domain = stripslashes(trim(get_option('andriod_app_domain')));
		$andriod_app_theme = stripslashes(trim(get_option('andriod_app_theme')));
		$andriod_app_front_page = stripslashes(trim(get_option('andriod_app_front_page')));
		$andriod_app_icon = stripslashes(trim(get_option('andriod_app_icon')));
		$andriod_app_custom_css = stripslashes(trim(get_option('andriod_app_custom_css')));
		$andriod_app_custom_js = stripslashes(trim(get_option('andriod_app_custom_js')));
		$andriod_enable_custom_posts = get_option('andriod_enable_custom_posts');
		$andriod_enable_custom_posts_replaced = array();
		foreach ($andriod_enable_custom_posts as $key => $value) {
			$new_key = str_replace('-','_',$key);
			$andriod_enable_custom_posts_replaced[$new_key] = $value;
		}
		$andriod_app_footer_content = stripslashes(trim(get_option('andriod_app_footer_content')));
		$andriod_app_directory= preg_replace("/[^a-z]+/", "", strtolower(stripslashes(trim(get_option('andriod_app_name')))));
		if($andriod_app_directory == ''){
			$andriod_app_directory = 'mmf_data';
		}
		$app_setting_array['andriod_app_front_page'] = $andriod_app_front_page;
		//$app_setting_array['app_footer_content'] = $andriod_app_footer_content;
		$app_setting_array['andriod_app_custom_css'] = $andriod_app_custom_css;
		$app_setting_array['andriod_app_custom_js'] = $andriod_app_custom_js;
		$app_setting_array['andriod_enable_custom_posts'] = $andriod_enable_custom_posts_replaced;
		$app_setting_array['andriod_app_menu_title'] = $andriod_app_menu_title;

		/*************************************************/
		$api_data_array['app_name'] = $andriod_app_name;
		$api_data_array['app_domain'] = $andriod_app_domain;
		$api_data_array['app_icon'] = $andriod_app_icon;
		$api_data_array['app_footer_content'] = $andriod_app_footer_content;
		$api_data_array['settings'] = $app_setting_array;
		$api_data_array['pages'] = $app_pages_array;
		$api_data_array['products'] = $app_products_array;
		$api_data_array['posts'] = $app_posts_array;


		/*******************Custom Post Types************************/
		
		if($andriod_enable_custom_posts){
			foreach ($andriod_enable_custom_posts as $slug => $name) {
				/******************************/
				$args = array(
					'post_type' => $slug,
					'post_status' => 'publish',
					'posts_per_page' => -1,
					
				);
				$query = new WP_Query( $args );
				
				$total_pages = $query->post_count;
				$app_custom_posts = $query->posts;
				$app_custom_posts_array = array();
				$app_custom_posts_settings_array = array();
				$app_custom_posts_data_array = array();

				foreach($app_custom_posts as $app_custom_post){
					$custom_post_array = array();
					
					$app_custom_post_icon = 'ion-earth';
					$show_in_menu = 1;

					$featured_image_url = get_the_post_thumbnail_url($app_custom_post->ID,'full');
					$custom_post_array['id']			= $app_custom_post->ID;
					$custom_post_array['slug']			= $app_custom_post->post_name;
					$custom_post_array['title']		= $app_custom_post->post_title;
					$custom_post_array['content']		= $app_custom_post->post_content;
					$custom_post_array['icon']			= $app_custom_post;
					$custom_post_array['show_in_menu']			= $show_in_menu;
					$custom_post_array['created_by']	= $app_custom_post->post_author;
					$custom_post_array['created_at']	= $app_custom_post->post_date;
					$custom_post_array['modified_at']	= $app_custom_post->post_modified;
					$custom_post_array['featured_image_url']	= $featured_image_url;


					array_push($app_custom_posts_data_array, $custom_post_array); 
				}

				/****************** Settings ***************/
				$app_custom_posts_settings_array['single'] = get_option('andriod_app_'.$slug.'_single_template');
				$app_custom_posts_settings_array['archive'] = get_option('andriod_app_'.$slug.'_archive_template');
				$app_custom_posts_settings_array['css'] = get_option('andriod_app_'.$slug.'_template_custom_css');
				$app_custom_posts_settings_array['js'] = get_option('andriod_app_'.$slug.'_template_custom_js');
				/****************** END Settings ***************/

				$app_custom_posts_array['template_settings'] = $app_custom_posts_settings_array;
				$app_custom_posts_array['data'] = $app_custom_posts_data_array;
				/******************************/
				$new_slug = str_replace('-','_',$slug);
				$api_data_array[$new_slug] = $app_custom_posts_array;
			}
			
		}
		/********************************************************/

		$api_array['status'] = "success";
		$api_array['data'] = $api_data_array;

//echo "<pre>";print_r($api_data_array['posts']);echo "</pre>";		
		$json_api = json_encode($api_array);
		//$json_api = htmlspecialchars($json_api, ENT_QUOTES, 'UTF-8');
		
		restore_current_blog();
//echo  "<pre>";print_r($api_array);echo  "</pre>";
		return trim($json_api); 
	} // End aione_andriod_api_shortcode()

}
