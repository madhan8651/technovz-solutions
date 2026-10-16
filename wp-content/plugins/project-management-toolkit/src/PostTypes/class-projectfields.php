<?php

namespace TechNovz\PMT\PostTypes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ProjectFields {

	public function init() {
		add_action(
			'add_meta_boxes_pmt_project',
			array( $this, 'add_meta_box' )
		);

		add_action(
			'save_post_pmt_project',
			array( $this, 'save_fields' )
		);
	}

	/**
	 * Register the project details meta box.
	 */
	public function add_meta_box() {
		add_meta_box(
			'pmt_project_details',
			__( 'Project Details', 'project-management-toolkit' ),
			array( $this, 'render_meta_box' ),
			'pmt_project',
			'normal',
			'high'
		);
	}

	/**
	 * Display custom project fields.
	 *
	 * @param \WP_Post $post Current project.
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field(
			'pmt_save_project_fields',
			'pmt_project_fields_nonce'
		);

		$project_url = get_post_meta(
			$post->ID,
			'_pmt_project_url',
			true
		);

		$completion_date = get_post_meta(
			$post->ID,
			'_pmt_completion_date',
			true
		);

		$project_status = get_post_meta(
			$post->ID,
			'_pmt_project_status',
			true
		);

		if ( empty( $project_status ) ) {
			$project_status = 'planned';
		}
		?>

		<p>
			<label for="pmt_project_url">
				<strong><?php esc_html_e( 'Project URL', 'project-management-toolkit' ); ?></strong>
			</label>
			<br>
			<input
				type="url"
				id="pmt_project_url"
				name="pmt_project_url"
				value="<?php echo esc_attr( $project_url ); ?>"
				class="widefat"
				placeholder="https://example.com"
			>
		</p>

		<p>
			<label for="pmt_completion_date">
				<strong><?php esc_html_e( 'Completion Date', 'project-management-toolkit' ); ?></strong>
			</label>
			<br>
			<input
				type="date"
				id="pmt_completion_date"
				name="pmt_completion_date"
				value="<?php echo esc_attr( $completion_date ); ?>"
			>
		</p>

		<p>
			<label for="pmt_project_status">
				<strong><?php esc_html_e( 'Project Status', 'project-management-toolkit' ); ?></strong>
			</label>
			<br>
			<select
				id="pmt_project_status"
				name="pmt_project_status"
			>
				<option value="planned" <?php selected( $project_status, 'planned' ); ?>>
					<?php esc_html_e( 'Planned', 'project-management-toolkit' ); ?>
				</option>

				<option value="in_progress" <?php selected( $project_status, 'in_progress' ); ?>>
					<?php esc_html_e( 'In Progress', 'project-management-toolkit' ); ?>
				</option>

				<option value="completed" <?php selected( $project_status, 'completed' ); ?>>
					<?php esc_html_e( 'Completed', 'project-management-toolkit' ); ?>
				</option>
			</select>
		</p>

		<?php
	}

	/**
	 * Validate and save project fields.
	 *
	 * @param int $post_id Project post ID.
	 */
	public function save_fields( $post_id ) {

		// Verify the post type.
		if ( 'pmt_project' !== get_post_type( $post_id ) ) {
			return;
		}

		// Verify the nonce exists and is a string.
		if (
			! isset( $_POST['pmt_project_fields_nonce'] )
			|| ! is_string( $_POST['pmt_project_fields_nonce'] )
		) {
			return;
		}

		$nonce = sanitize_text_field(
			wp_unslash( $_POST['pmt_project_fields_nonce'] )
		);

		if (
			! wp_verify_nonce(
				$nonce,
				'pmt_save_project_fields'
			)
		) {
			return;
		}

		// Do not process autosaves or revisions.
		if (
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			|| wp_is_post_revision( $post_id )
		) {
			return;
		}

		// Confirm that the current user can edit this project.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Validate and save the project URL.
		if (
			isset( $_POST['pmt_project_url'] )
			&& is_string( $_POST['pmt_project_url'] )
		) {
			$project_url = esc_url_raw(
				trim(
					wp_unslash( $_POST['pmt_project_url'] )
				),
				array( 'http', 'https' )
			);

			if ( '' === $project_url ) {
				update_post_meta(
					$post_id,
					'_pmt_project_url',
					''
				);
			} elseif ( wp_http_validate_url( $project_url ) ) {
				update_post_meta(
					$post_id,
					'_pmt_project_url',
					$project_url
				);
			}
		}

		// Validate and save the completion date.
		if (
			isset( $_POST['pmt_completion_date'] )
			&& is_string( $_POST['pmt_completion_date'] )
		) {
			$date = sanitize_text_field(
				wp_unslash( $_POST['pmt_completion_date'] )
			);

			if ( '' === $date ) {
				update_post_meta(
					$post_id,
					'_pmt_completion_date',
					''
				);
			} else {
				$parsed_date = \DateTime::createFromFormat(
					'!Y-m-d',
					$date
				);

				if (
					$parsed_date
					&& $parsed_date->format( 'Y-m-d' ) === $date
				) {
					update_post_meta(
						$post_id,
						'_pmt_completion_date',
						$date
					);
				}
			}
		}

		// Validate and save the project status.
		if (
			isset( $_POST['pmt_project_status'] )
			&& is_string( $_POST['pmt_project_status'] )
		) {
			$status = sanitize_key(
				wp_unslash( $_POST['pmt_project_status'] )
			);

			$allowed_statuses = array(
				'planned',
				'in_progress',
				'completed',
			);

			if ( in_array( $status, $allowed_statuses, true ) ) {
				update_post_meta(
					$post_id,
					'_pmt_project_status',
					$status
				);
			}
		}
	}
}
