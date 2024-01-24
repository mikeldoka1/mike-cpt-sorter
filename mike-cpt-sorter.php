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

use Mike\Src\Base;
use Mike\Src\Admin;
use Mike\Src\ApiResponse;
use Mike\Src\Shortcode;

defined( 'ABSPATH' ) || exit;

const MIKE_CPT_SORTER_PLUGIN_PATH = __FILE__;
const MIKE_CPT_SORTER_PLUGIN_DIR = __DIR__;
const MIKE_PLUGIN_PREFIX = 'mike_cpt_sorter';

if ( file_exists( __DIR__ . '/autoload.php' ) ) {
	require_once __DIR__ . '/autoload.php';
}

register_activation_hook(MIKE_CPT_SORTER_PLUGIN_PATH, [ Base::class, 'activate' ] );
register_uninstall_hook(MIKE_CPT_SORTER_PLUGIN_PATH, [ Base::class, 'uninstall' ] );



add_action( 'wp_enqueue_scripts', [Base::class, 'registerAssets'] );

if (is_admin()) {
	add_action('admin_menu', [Admin::class, 'registerOptionsPage']);
	add_action('admin_init', [Admin::class, 'registerSettings']);
}

add_shortcode('custom_search', [ Shortcode::class, 'registerShortcode' ]);


// rest api endpoint for pagination
add_action( 'rest_api_init', static function () {
	register_rest_route( 'mike_cpt/v1', '/paginate/', array(
		'methods' => 'POST',
		'callback' => [ ApiResponse::class, 'getPosts' ],
	) );
} );