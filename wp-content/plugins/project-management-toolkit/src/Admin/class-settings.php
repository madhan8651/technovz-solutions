<?php

namespace TechNovz\PMT\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings {

	/**
	 * Initialize plugin settings and dashboard widget.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
	}

	/**
	 * Add the plugin settings page.
	 */
	public function add_menu() {
		add_options_page(
			__( 'Project Management Toolkit', 'project-management-toolkit' ),
			__( 'Project Management Toolkit', 'project-management-toolkit' ),
			'manage_options',
			'project-management-toolkit',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Register plugin settings.
	 */
	public function register_settings() {

		register_setting(
			'pmt_settings_group',
			'pmt_admin_message',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_textarea_field',
				'default'           => 'Welcome to Project Management Toolkit!',
			)
		);

		register_setting(
			'pmt_settings_group',
			'pmt_message_enabled',
			array(
				'type'              => 'integer',
				'sanitize_callback' => array( $this, 'sanitize_enabled' ),
				'default'           => 1,
			)
		);
	}

	/**
	 * Validate the dashboard message enabled setting.
	 *
	 * @param mixed $value Submitted setting value.
	 * @return int
	 */
	public function sanitize_enabled( $value ) {
		return in_array( (string) $value, array( '1', '0' ), true )
			? (int) $value
			: 0;
	}

	/**
	 * Display the plugin settings page.
	 */
	public function render_page() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die(
				esc_html__(
					'You are not allowed to access this page.',
					'project-management-toolkit'
				)
			);
		}

		$message = get_option(
			'pmt_admin_message',
			'Welcome to Project Management Toolkit!'
		);

		$enabled = (int) get_option( 'pmt_message_enabled', 1 );
		?>

		<div class="wrap">

			<h1>
				<?php
				esc_html_e(
					'Project Management Toolkit',
					'project-management-toolkit'
				);
				?>
			</h1>

			<p>
				<?php
				esc_html_e(
					'Configure the message displayed on your WordPress dashboard.',
					'project-management-toolkit'
				);
				?>
			</p>

			<form method="post" action="options.php">

				<?php settings_fields( 'pmt_settings_group' ); ?>

				<table class="form-table">

					<tr>
						<th scope="row">
							<label for="pmt_admin_message">
								<?php
								esc_html_e(
									'Dashboard message',
									'project-management-toolkit'
								);
								?>
							</label>
						</th>

						<td>
							<textarea
								id="pmt_admin_message"
								name="pmt_admin_message"
								rows="4"
								class="large-text"
							><?php echo esc_textarea( $message ); ?></textarea>

							<p class="description">
								<?php
								esc_html_e(
									'Enter the message you want to display on the dashboard.',
									'project-management-toolkit'
								);
								?>
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<?php
							esc_html_e(
								'Enable dashboard message',
								'project-management-toolkit'
							);
							?>
						</th>

						<td>
							<input
								type="hidden"
								name="pmt_message_enabled"
								value="0"
							/>

							<label for="pmt_message_enabled">
								<input
									type="checkbox"
									id="pmt_message_enabled"
									name="pmt_message_enabled"
									value="1"
									<?php checked( $enabled, 1 ); ?>
								/>

								<?php
								esc_html_e(
									'Display the message on the dashboard',
									'project-management-toolkit'
								);
								?>
							</label>
						</td>
					</tr>

				</table>

				<?php submit_button( __( 'Save Changes', 'project-management-toolkit' ) ); ?>

			</form>

		</div>

		<?php
	}

	/**
	 * Register the dashboard widget when enabled.
	 */
	public function add_dashboard_widget() {

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if ( ! get_option( 'pmt_message_enabled', 1 ) ) {
			return;
		}

		wp_add_dashboard_widget(
			'pmt_dashboard_message',
			__( 'Project Management Toolkit', 'project-management-toolkit' ),
			array( $this, 'render_dashboard_widget' )
		);
	}

	/**
	 * Display the configured dashboard message.
	 */
	public function render_dashboard_widget() {

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if ( ! get_option( 'pmt_message_enabled', 1 ) ) {
			return;
		}

		$message = get_option( 'pmt_admin_message', '' );

		if ( '' !== $message ) {
			echo '<p>' . nl2br( esc_html( $message ) ) . '</p>';
		}
	}
}
