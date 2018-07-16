<?php

/**
 * @link              http://sgssandhu.com/
 * @since             1.0.0.0
 * @package           Aione_Android_Application_Builder
 *
 * @wordpress-plugin
 * Plugin Name:       Aione Android Application Builder
 * Plugin URI:        http://oxosolutions.com/products/wordpress-plugins/aione-android-application-builder/
 * Description:       Aione Android Application Builder
 * Version:           1.5.1.0
 * Author:            OXO Solutions®
 * Author URI:        https://oxosolutions.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       aione-android-application-builder
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/oxosolutions/aione-android-application-builder
 * GitHub Branch: master
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-aione-android-application-builder-activator.php
 */
function activate_aione_android_application_builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aione-android-application-builder-activator.php';
	Aione_Android_Application_Builder_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-aione-android-application-builder-deactivator.php
 */
function deactivate_aione_android_application_builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aione-android-application-builder-deactivator.php';
	Aione_Android_Application_Builder_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_aione_android_application_builder' );
register_deactivation_hook( __FILE__, 'deactivate_aione_android_application_builder' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-aione-android-application-builder.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_aione_android_application_builder() {

	$plugin = new Aione_Android_Application_Builder();
	$plugin->run();

}
run_aione_android_application_builder();
