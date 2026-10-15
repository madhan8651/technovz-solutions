<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PMT_Deactivator {

	public static function deactivate() {
		// Keep settings so they remain available if reactivated.
		// No cleanup is required at deactivation.
	}
}
