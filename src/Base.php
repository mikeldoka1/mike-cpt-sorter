<?php

namespace Mike\Src;

class Base {

	/**
	 * Set default plugin database setting
	 * @return void
	 */
	public static function activate(): void
	{
		update_option(MIKE_PLUGIN_PREFIX . '_per_page', 9);
		update_option(MIKE_PLUGIN_PREFIX . '_display_type', 'grid');
	}

	/**
	 * Perform database cleanups on uninstall
	 * @return void
	 */
	public static function uninstall(): void {
		delete_option(MIKE_PLUGIN_PREFIX . '_per_page');
		delete_option(MIKE_PLUGIN_PREFIX . '_display_type');
	}

	/**
	 * Register plugin assets
	 * These assets need to be manually called in code when needed
	 * @return void
	 * @see Shortcode::registerShortcode()
	 */
	public static function registerAssets(): void {
		wp_register_style('mike-stylesheet', plugins_url('/assets/style.css', MIKE_CPT_SORTER_PLUGIN_PATH));
		wp_register_script('mike-load-more', plugins_url('/assets/pagination.js', MIKE_CPT_SORTER_PLUGIN_PATH), array('jquery'));
	}

}