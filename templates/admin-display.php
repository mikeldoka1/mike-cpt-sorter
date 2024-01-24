<?php

/**
 * Admin frontend
 */

defined( 'ABSPATH' ) || exit;
if (!is_admin()) exit;
?>

<div class="wrap">
    <h2>CPT Sorter Settings</h2>
    <form method="post" action="options.php">
		<?php settings_fields('mike_cpt_sorter_options'); ?>
		<?php do_settings_sections('mike-cpt-sorter'); ?>
		<?php submit_button(); ?>
    </form>
</div>