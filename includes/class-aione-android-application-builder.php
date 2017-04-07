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

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
		
		global $wpdb;
		$andriod_app_name = get_option('andriod_app_name');
		$andriod_app_domain = get_option('andriod_app_domain');
		$andriod_app_theme = get_option('andriod_app_theme');
		$andriod_app_icon = get_option('andriod_app_icon');
		$api_array = array();
		$api_data_array = array();
		$api_data_pages_array = array();

		
		$args = array(
			'post_type' => 'app_pages',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			
		);
		$query = new WP_Query( $args );
		
		if ($query->have_posts()) {
			while ( $query->have_posts() ) {
				$raw_array= array();
				$query->the_post();
				$page_id = $query->post->ID;
				$page_title = $query->post->post_title;
				$page_content = $query->post->post_content;
				$raw_array['id']= $page_id;
				$raw_array['title']= $page_title;
				$raw_array['content']= $page_content;
				array_push($api_data_pages_array, $raw_array);
			}
		}

		$api_data_array['app_name'] = $andriod_app_name;
		$api_data_array['app_domain'] = $andriod_app_domain;
		$api_data_array['app_theme'] = $andriod_app_theme;
		$api_data_array['app_icon'] = $andriod_app_icon;
		$api_data_array['app_version'] = "";
		$api_data_array['app_last_update'] = "";
		$api_data_array['app_pages'] = $api_data_pages_array;

		$api_array['status'] = "success";
		$api_array['data'] = $api_data_array;
		
		$json_api = json_encode($api_array);

		return trim($json_api);
	} // End aione_andriod_api_shortcode()

}
