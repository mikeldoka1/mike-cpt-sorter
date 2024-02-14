<?php

namespace Mike\Src;
use WP_REST_Request;

class ApiResponse {

	/**
	 * Return api response based on request conditions
	 * Both json and html are returned
	 * To offload work for frontend we prepare the html based on display preferences.
	 * @param WP_REST_Request $request
	 *
	 * @return void
	 */
	public static function getPosts( WP_REST_Request $request): void {

		$postTypes = $request['post_types'] ?? 'post';
		$postsPerPage = (int) ( $request['posts_per_page'] ?? get_option( option: 'mike_cpt_sorter_per_page', default_value: 9 ) );
		$paged = (int) ($request['paged'] ?? 1);
		$searchQuery = $request['s'];

		$displayPreferences = get_option('mike_cpt_sorter_display_type');

		$query = Queries::buildQuery($postTypes, $postsPerPage, $paged, $searchQuery);

		if (! $query->have_posts()) {
			wp_send_json_error(status_code: 400);
		}

		$postList = [];

		foreach ($query->posts as $post) {

			$featuredImageUrl = get_the_post_thumbnail_url($post->ID, 'medium');

			// if empty set a placeholder image
			if (empty($featuredImageUrl)) {
				$featuredImageUrl = 'https://placehold.co/600x400?text=' . $post->post_title;
			}

			if ($displayPreferences === 'grid') {
				$postList[] = [
					'html' => '<div class="mike-grid-item"><h3><a href="' . esc_url( get_permalink($post->ID) ) . '">' . esc_attr( $post->post_title ) .'</a></h3><img src="' . $featuredImageUrl . '" alt="' . get_the_title() . '"></div>',
					'json' => [
						'title'             => esc_attr( $post->post_title ),
						'url'               => esc_url( get_permalink($post->ID) ),
						'featured_image'    => esc_url( $featuredImageUrl ),
					],
				];
			} else {
				$postList[] = [
					'html' => '<li><a href="' . esc_url( get_permalink($post->ID) ) . '">' . esc_attr( $post->post_title ) . '</a></li>',
					'json' => [
						'title'             => esc_attr( $post->post_title ),
						'url'               => esc_url( get_permalink($post->ID) ),
					],
				];
			}
		}

		wp_send_json_success($postList);
	}
}