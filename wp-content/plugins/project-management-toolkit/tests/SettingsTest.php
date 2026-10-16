<?php

use PHPUnit\Framework\TestCase;
use TechNovz\PMT\Admin\Settings;

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once __DIR__ . '/../src/Admin/class-settings.php';

class SettingsTest extends TestCase {

    /**
     * @dataProvider enabledValueProvider
     */
    public function test_sanitize_enabled_returns_expected_value( $input, $expected ) {
        $settings = new Settings();

        $this->assertSame( $expected, $settings->sanitize_enabled( $input ) );
    }

    public static function enabledValueProvider() {
        return array(
            'integer one' => array( 1, 1 ),
            'string one'  => array( '1', 1 ),
            'integer zero' => array( 0, 0 ),
            'string zero' => array( '0', 0 ),
            'true converts to one' => array( true, 1 ),
            'invalid string is rejected' => array( 'invalid', 0 ),
        );
    }
}
