<?php

namespace Mike\Src;
use WP_REST_Request;

class ApiResponse {
	public static function getPosts( WP_REST_Request $request): void {

		$postTypes = $request['post_types'] ?? 'post';
		$postsPerPage = (int) ( $request['posts_per_page'] ?? get_option( 'mike_cpt_sorter_per_page', 9 ) );
		$paged = (int) ($request['paged'] ?? 1);

		$the_query = Queries::buildQuery($postTypes, $postsPerPage, $paged);

		if (! $the_query->have_posts()) {
			wp_send_json_error(status_code: 204);
		}

		$postList = [];

		foreach ($the_query->posts as $post) {

			$featuredImageUrl = get_the_post_thumbnail_url($post->ID, 'medium');

			// if empty set a placeholder image
			if (empty($featuredImageUrl)) {
				$featuredImageUrl = 'https://placehold.co/600x400?text=' . $post->post_title;
			}

			$postList[] = [
				'title'             => esc_attr( $post->post_title ),
				'url'               => esc_url( get_permalink($post->ID) ),
				'featured_image'    => esc_url( $featuredImageUrl ),
			];
		}

		wp_send_json_success($postList);
	}
}