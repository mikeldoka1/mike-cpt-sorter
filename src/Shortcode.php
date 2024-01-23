<?php

namespace Mike\Src;

class Shortcode {

	public static function registerShortcode($atts): string {

		$postsPerPage = (int) ( $atts['element-count'] ?? get_option( 'mike_cpt_sorter_per_page', 9 ) );
		$postTypes = $atts['post-types'] ?? 'post';

		$the_query = Queries::buildQuery($postTypes, $postsPerPage);

		$displayPreferences = get_option('mike_cpt_sorter_display_type');

		if (! $the_query->have_posts()) {
			return '<p>Sorry, no posts matched your criteria.</p>';
		}

		if ($displayPreferences === 'list') {

			$html = '<ul class="mike-list">';

			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$html .= '<li><a href="' . get_permalink() . '">' . esc_html( get_the_title() ) . '</a></li>';
			}

			$html .= '</ul>';
		} else {

			$html = '<div class="mike-grid-container">';

			while ( $the_query->have_posts() ) {
				$the_query->the_post();


				$featuredImageUrl = get_the_post_thumbnail_url(get_the_ID(), 'medium');

				if (empty($featuredImageUrl)) {
					$featuredImageUrl = 'https://placehold.co/600x400?text=' . get_the_title();
				}

				$html .= '<div class="mike-grid-item"><h3><a href="' . get_permalink() . '">' . esc_html( get_the_title() ) . '</a></h3>';

				$html .= '<img src="' . $featuredImageUrl . '" alt="' . get_the_title() . '">';

				$html .= '</div>';
			}



			$html .= '</div>';

		}

		$html .= '<div class="mike-load-more">
				<button class="mike-load-more-button"
					data-post-types="' . $postTypes . '"
					data-per-page="' . $postsPerPage . '"
					>
					Load more
					</button>
					<p class="mike-load-more-error">No more posts found!</p>
				</div>';

		wp_reset_postdata();

		wp_enqueue_style('mike-stylesheet');
		wp_enqueue_script('mike-load-more', plugins_url('/assets/pagination.js', MIKE_CPT_SORTER_PLUGIN_PATH), array('jquery'));

		return $html;
	}

}