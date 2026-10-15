<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Remove plugin settings when the plugin is deleted.
delete_option( 'pmt_admin_message' );
delete_option( 'pmt_message_enabled' );
