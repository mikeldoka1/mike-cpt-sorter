<?php

namespace Mike\Src;

class Activator {

	protected const DATABASE_PREFIX = 'mike_cpt_sorter';

	public static function activate(): void
	{
		update_option(self::DATABASE_PREFIX . '_per_page', 9);
		update_option(self::DATABASE_PREFIX . '_display_type', 'grid');
	}

}