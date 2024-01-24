<?php

namespace Mike\Src;

class Admin {

    // page name or menu name
    protected const PAGE_NAME = 'mike-cpt-sorter';

	public static function registerOptionsPage(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		add_options_page('CPT Sorter Settings', 'CPT Sorter', 'manage_options', self::PAGE_NAME, [ __CLASS__, 'showOptionsPage']);
	}

	public static function showOptionsPage(): void {
		require_once MIKE_CPT_SORTER_PLUGIN_DIR . '/templates/admin-display.php';
	}

	public static function registerSettings(): void {
		register_setting(MIKE_PLUGIN_PREFIX . '_options', MIKE_PLUGIN_PREFIX . '_per_page', array(__CLASS__, 'sanitizeIntegerField'));
		register_setting(MIKE_PLUGIN_PREFIX . '_options', MIKE_PLUGIN_PREFIX . '_display_type', array(__CLASS__, 'sanitizeSelectField'));

		add_settings_section(MIKE_PLUGIN_PREFIX . '_general', 'General Settings', array(__CLASS__, 'showSectionInfo'), self::PAGE_NAME);
		add_settings_field(MIKE_PLUGIN_PREFIX . '_per_page', 'Posts Per Page', array(__CLASS__, 'displayIntegerField'), self::PAGE_NAME, MIKE_PLUGIN_PREFIX . '_general');
		add_settings_field(MIKE_PLUGIN_PREFIX . '_display_type', 'Display Type', array(__CLASS__, 'displaySelectField'), self::PAGE_NAME, MIKE_PLUGIN_PREFIX . '_general');
	}

	public static function showSectionInfo(): void {
		echo '<p>Posts per page may be overridden by shortcode parameters. If not provided within the shortcode this following will take precedence.</p>';
	}

	public static function displayIntegerField(): void {
		// Field callback for Posts Per Page
		$per_page = get_option(MIKE_PLUGIN_PREFIX . '_per_page');
		?>
        <input type="number" name="mike_cpt_sorter_per_page" value="<?php echo esc_attr($per_page); ?>" />
		<?php
	}

	public static function displaySelectField(): void {
		$display_type = get_option(MIKE_PLUGIN_PREFIX . '_display_type');
		?>
        <select name="mike_cpt_sorter_display_type">
            <option value="list" <?php selected($display_type, 'list'); ?>>List</option>
            <option value="grid" <?php selected($display_type, 'grid'); ?>>Grid</option>
        </select>
		<?php
	}

	public static function sanitizeIntegerField($input): int {
		return (int) $input;
	}

	public static function sanitizeSelectField($input) {
		return in_array($input, array('list', 'grid')) ? $input : 'list';
	}

}