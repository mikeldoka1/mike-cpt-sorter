<?php

namespace Mike\Src;

use WP_Query;

class Queries {

	/**
	 * @param int $postsPerPage Total posts to display per page
	 * @param string|array $postTypes Post types
	 * @param int $paged Paginated page
	 *
	 * @return WP_Query
	 */
	public static function buildQuery(string|array $postTypes, int $postsPerPage, int $paged = 1, ?string $searchQuery = null): WP_Query {

		$postTypes = sanitize_text_field($postTypes);
		$postTypes = self::preparePostTypes($postTypes);

		$searchQuery = $searchQuery ? sanitize_text_field($searchQuery) : null;

		return new WP_Query( query: [
			's' => $searchQuery,
			'post_type' => $postTypes,
			'posts_per_page' => $postsPerPage,
			'paged' => $paged,
		]);
	}

	/**
	 * Convert post-types string into an array if multiple post types are present
	 * in order to use it with wp_query
	 * @param $postTypes
	 *
	 * @return array|string
	 * @see https://developer.wordpress.org/reference/classes/wp_query/#post-type-parameters
	 */
	protected static function preparePostTypes($postTypes): array|string {

		$postTypes = explode(',', $postTypes);

		if (count($postTypes) === 1) {
			$postTypes = array_map('trim', $postTypes);
		}

		return $postTypes;
	}

}