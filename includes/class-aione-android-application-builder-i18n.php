<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://sgssandhu.com/
 * @since      1.0.0
 *
 * @package    Aione_Android_Application_Builder
 * @subpackage Aione_Android_Application_Builder/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Aione_Android_Application_Builder
 * @subpackage Aione_Android_Application_Builder/includes
 * @author     SGS Sandhu <sgs.sandhu@gmail.com>
 */
class Aione_Android_Application_Builder_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'aione-android-application-builder',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
