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
 * Requires PHP: 7.4
 */

use Mike\Src\Activator;
use Mike\Src\Shortcode;
use Mike\Src\Uninstaller;

defined( 'ABSPATH' ) || exit;

if ( file_exists( __DIR__ . '/autoload.php' ) ) {
	require_once __DIR__ . '/autoload.php';
}

register_activation_hook(__FILE__, [ Activator::class, 'activate' ] );
register_uninstall_hook(__FILE__, [ Uninstaller::class, 'uninstall' ] );
add_shortcode('custom_search', [ Shortcode::class, 'registerShortcode' ]);
