<?php
/**
 * Plugin Name: Project Management Toolkit
 * Description: Dashboard messages and project information tools for TechNovz Solutions.
 * Version: 1.0.0
 * Author: Madhan
 * Text Domain: project-management-toolkit
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'PMT_VERSION', '1.0.0' );
define( 'PMT_PATH', plugin_dir_path( __FILE__ ) );
define( 'PMT_URL', plugin_dir_url( __FILE__ ) );

require_once PMT_PATH . 'includes/activator.php';
require_once PMT_PATH . 'includes/deactivator.php';

register_activation_hook(
    __FILE__,
    array( 'PMT_Activator', 'activate' )
);

register_deactivation_hook(
    __FILE__,
    array( 'PMT_Deactivator', 'deactivate' )
);

/**
 * Simple PSR-4-style autoloader for the PMT namespace.
 */
spl_autoload_register(
    function ( $class ) {
        $prefix   = 'TechNovz\\PMT\\';
        $base_dir = PMT_PATH . 'src/';

        if ( strpos( $class, $prefix ) !== 0 ) {
            return;
        }

        $relative_class = substr( $class, strlen( $prefix ) );

        $file = $base_dir . str_replace(
            '\\',
            DIRECTORY_SEPARATOR,
            $relative_class
        ) . '.php';

        if ( file_exists( $file ) ) {
            require_once $file;
        }
    }
);

/**
 * Load the plugin's translations.
 */
add_action(
    'init',
    function () {
        load_plugin_textdomain(
            'project-management-toolkit',
            false,
            dirname( plugin_basename( __FILE__ ) ) . '/languages'
        );
    }
);

/**
 * Initialize the plugin.
 */
add_action(
    'plugins_loaded',
    function () {
        $plugin = new \TechNovz\PMT\Plugin();
        $plugin->init();
    }
);
