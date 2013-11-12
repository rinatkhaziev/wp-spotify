<?php
/**
 * Plugin Name: WP Spotify
 * Plugin URI:  http://digitallyconscious.com
 * Description: WordPress plugin for querying Spotify Metadata API
 * Version:     0.1.0
 * Author:      Rinat Khaziev
 * Author URI:  
 * License:     GPLv2+
 * Text Domain: sptfy
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2013 Rinat Khaziev (email : rinat.khaziev@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using grunt-wp-plugin-oo
 * Copyright (c) 2013 Rinat Khaziev
 *
 * grunt-wp-plugin-oo is based on
 * grunt-wp-plugin
 * Copyright (c) 2013 10up, LLC
 * https://github.com/10up/grunt-wp-plugin
 */

// Useful global constants
define( 'SPTFY_VERSION', '0.1.0' );
define( 'SPTFY_URL',     plugin_dir_url( __FILE__ ) );
define( 'SPTFY_PATH',    dirname( __FILE__ ) . '/' );




class WP_Spotify {

	// Plugin properties
	public $sp;

	function __construct() {
		// Hook the init
		add_action( 'init', array( $this, 'action_init' ) );
		// Lets get dirty
		spl_autoload_register(function($className) { 
			$file = SPTFY_PATH . '/includes/metatune/lib/' . str_replace('\\', '/', ltrim($className, '\\')) . '.class.php';
			if ( file_exists( $file ) )
    			require_once( SPTFY_PATH . '/includes/metatune/lib/' . str_replace('\\', '/', ltrim($className, '\\')) . '.class.php'); 
		}); 
		$this->sp = MetaTune\MetaTune::getInstance();
	}

	function action_init() {

		// i18nize
		$locale = apply_filters( 'plugin_locale', get_locale(), 'wp-spotify' );
		load_textdomain( 'wp-spotify', WP_LANG_DIR . '/wp-spotify/wp-spotify-' . $locale . '.mo' );
		load_plugin_textdomain( 'wp-spotify', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Wire actions
		add_action( 'wp_enqueue_scripts', array( $this, 'action_enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'action_admin_scripts' ) );
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
	}

	function action_admin_init() {

	}

	function action_admin_scripts() {

	}

	function action_enqueue_scripts() {

	}

	// Setup
	function action_activate() {

		flush_rewrite_rules();
	}

	// Cleanup
	function action_deactivate() {

		flush_rewrite_rules();
	}
}

global $wp_spotify;
$wp_spotify = new WP_Spotify;

register_activation_hook( __FILE__, array( $wp_spotify, 'action_activate' ) );
register_deactivation_hook( __FILE__, array( $wp_spotify, 'action_deactivate' ) );