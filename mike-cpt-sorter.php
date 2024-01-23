<?php

/**
 * The plugin bootstrap file
 *
 * Plugin Name: Mike Custom Post Type Sorter
 * Description: Sort custom post types based on predefined conditions
 * Version: 1.0.0
 * Author: Mikel Doka
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: mike-cpt-sorter
 * Requires PHP: 8.1
 */

use Mike\Src\Activator;
use Mike\Src\ApiResponse;
use Mike\Src\Shortcode;
use Mike\Src\Uninstaller;

defined( 'ABSPATH' ) || exit;

define('MIKE_CPT_SORTER_PLUGIN_PATH', __FILE__);

if ( file_exists( __DIR__ . '/autoload.php' ) ) {
	require_once __DIR__ . '/autoload.php';
}

register_activation_hook(__FILE__, [ Activator::class, 'activate' ] );
register_uninstall_hook(__FILE__, [ Uninstaller::class, 'uninstall' ] );



add_action( 'wp_enqueue_scripts', 'registerAssets' );

add_shortcode('custom_search', [ Shortcode::class, 'registerShortcode' ]);

/**
 * Register assets to be used as needed
 * @return void
 */
function registerAssets(): void {
	wp_register_style('mike-stylesheet', plugins_url('/assets/style.css', __FILE__));
}

add_action( 'rest_api_init', static function () {
	register_rest_route( 'mike_cpt/v1', '/paginate/', array(
		'methods' => 'POST',
		'callback' => [ ApiResponse::class, 'getPosts' ],
	) );
} );