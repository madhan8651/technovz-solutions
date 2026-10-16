
<?php

use PHPUnit\Framework\TestCase;
use TechNovz\PMT\Database\ProjectViews;

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

if ( ! function_exists( 'absint' ) ) {
    function absint( $value ) {
        return abs( (int) $value );
    }
}
require_once __DIR__ . '/../src/Database/ProjectViews.php';

class ProjectViewsTest extends TestCase {

    protected function setUp(): void {
        global $wpdb;

        $wpdb = new ProjectViewsTestDatabase();
    }

    public function test_invalid_project_id_returns_zero() {
        $project_views = new ProjectViews();

        $this->assertSame( 0, $project_views->get_view_count( 0 ) );
        $this->assertSame( 0, $project_views->get_view_count( -5 ) );
    }

    public function test_valid_project_id_returns_database_count() {
        global $wpdb;

        $wpdb->expected_count = '7';

        $project_views = new ProjectViews();

        $this->assertSame( 7, $project_views->get_view_count( 42 ) );
        $this->assertSame( 'SELECT COUNT(*) FROM wp_pmt_project_views WHERE project_id = 42', $wpdb->last_query );
    }
}

class ProjectViewsTestDatabase {

    public $prefix = 'wp_';
    public $expected_count = '0';
    public $last_query = '';

    public function prepare( $query, ...$arguments ) {
        foreach ( $arguments as $argument ) {
            $query = preg_replace(
                '/%d/',
                (string) (int) $argument,
                $query,
                1
            );
        }

        $this->last_query = trim( preg_replace( '/\s+/', ' ', $query ) );

        return $this->last_query;
    }

    public function get_var( $query ) {
        return $this->expected_count;
    }
}
