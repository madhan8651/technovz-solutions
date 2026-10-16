<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PMT_Activator {

	public static function activate() {

		// Existing plugin settings.
		add_option(
			'pmt_admin_message',
			'Welcome to Project Management Toolkit!'
		);

		add_option( 'pmt_message_enabled', 1 );

		// Create the custom project views database table.
		global $wpdb;

		$table_name = $wpdb->prefix . 'pmt_project_views';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            project_id bigint(20) unsigned NOT NULL,
            viewed_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY project_id (project_id),
            KEY viewed_at (viewed_at)
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( $sql );
	}
}
