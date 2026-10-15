<?php

namespace TechNovz\PMT\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ProjectShortcode {

	public function init() {
		add_shortcode(
			'pmt_project',
			array( $this, 'render' )
		);

		add_action(
			'wp_enqueue_scripts',
			array( $this, 'enqueue_styles' )
		);
	}

	public function enqueue_styles() {
		wp_register_style(
			'pmt-project-cards',
			false,
			array(),
			PMT_VERSION
		);

		wp_enqueue_style( 'pmt-project-cards' );

		$css = '
        .pmt-project-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            margin: 24px 0;
        }

        .pmt-project-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #d9e4f2;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(20, 55, 95, 0.07);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .pmt-project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(20, 55, 95, 0.13);
        }

        .pmt-project-card-image {
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
            display: block;
        }

        .pmt-project-card-body {
            padding: 24px;
        }

        .pmt-project-card h3 {
            margin: 0 0 12px;
            color: #183b63;
            font-size: 22px;
            line-height: 1.4;
        }

        .pmt-project-card-description {
            color: #52657a;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .pmt-project-card-description p:last-child {
            margin-bottom: 0;
        }

        .pmt-project-card-link {
            display: inline-block;
            padding: 10px 18px;
            background: #2563eb;
            color: #ffffff !important;
            border-radius: 8px;
            text-decoration: none !important;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .pmt-project-card-link:hover,
        .pmt-project-card-link:focus {
            background: #183b63;
            color: #ffffff !important;
        }

        .pmt-project-card-link:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 3px;
        }

        .pmt-project-empty {
            padding: 24px;
            background: #f5f8fc;
            border-radius: 12px;
            color: #52657a;
        }

        @media (max-width: 600px) {
            .pmt-project-list {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .pmt-project-card-body {
                padding: 18px;
            }
        }';

		wp_add_inline_style(
			'pmt-project-cards',
			$css
		);
	}

	/**
	 * Render project cards.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function render( $atts ) {

		$atts = shortcode_atts(
			array(
				'id' => 0,
			),
			$atts,
			'pmt_project'
		);

		$project_id = absint( $atts['id'] );

		$args = array(
			'post_type'           => 'pmt_project',
			'post_status'         => 'publish',
			'posts_per_page'      => 10,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'ignore_sticky_posts' => true,
		);

		if ( $project_id > 0 ) {

			// Only display an ID belonging to a published project.
			$project = get_post( $project_id );

			if (
				! $project instanceof \WP_Post
				|| 'pmt_project' !== $project->post_type
				|| 'publish' !== $project->post_status
			) {
				return '<p class="pmt-project-empty">' .
					esc_html__(
						'No projects found.',
						'project-management-toolkit'
					) .
				'</p>';
			}

			$args['p']              = $project_id;
			$args['posts_per_page'] = 1;
		}

		$projects = new \WP_Query( $args );

		if ( ! $projects->have_posts() ) {
			return '<p class="pmt-project-empty">' .
				esc_html__(
					'No projects found.',
					'project-management-toolkit'
				) .
			'</p>';
		}

		ob_start();

		echo '<div class="pmt-project-list">';

		while ( $projects->have_posts() ) {
			$projects->the_post();

			echo '<article class="pmt-project-card">';

			if ( has_post_thumbnail() ) {
				echo '<a href="' .
					esc_url( get_permalink() ) .
					'" tabindex="-1" aria-hidden="true">';

				echo get_the_post_thumbnail(
					get_the_ID(),
					'large',
					array(
						'class' => 'pmt-project-card-image',
						'alt'   => '',
					)
				);

				echo '</a>';
			}

			echo '<div class="pmt-project-card-body">';

			echo '<h3>' .
				esc_html( get_the_title() ) .
			'</h3>';

			echo '<div class="pmt-project-card-description">';

			// Display the excerpt as plain text.
			echo esc_html(
				wp_strip_all_tags(
					get_the_excerpt()
				)
			);

			echo '</div>';

			echo '<a class="pmt-project-card-link" href="' .
				esc_url( get_permalink() ) .
				'">' .
				esc_html__(
					'View Project',
					'project-management-toolkit'
				) .
			'</a>';

			echo '</div>';
			echo '</article>';
		}

		echo '</div>';

		wp_reset_postdata();

		return ob_get_clean();
	}
}
