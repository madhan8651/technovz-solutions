<?php

namespace TechNovz\PMT\Database;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ProjectViews {

    /**
     * Initialize project view tracking.
     */
    public function init() {
        add_action(
            'template_redirect',
            array( $this, 'record_view' )
        );
    }

    /**
     * Record a visit to a published project.
     */
    public function record_view() {

        // Only track individual project pages.
        if ( ! is_singular( 'pmt_project' ) ) {
            return;
        }

        // Validate the queried project ID.
        $project_id = absint( get_queried_object_id() );

        if ( $project_id < 1 ) {
            return;
        }

        // Confirm the project exists and is published.
        if (
            'pmt_project' !== get_post_type( $project_id )
            || 'publish' !== get_post_status( $project_id )
        ) {
            return;
        }

        global $wpdb;

        $table_name = $wpdb->prefix . 'pmt_project_views';

        // Insert using WordPress database API and explicit formats.
        $result = $wpdb->insert(
            $table_name,
            array(
                'project_id' => $project_id,
                'viewed_at'  => current_time( 'mysql' ),
            ),
            array(
                '%d',
                '%s',
            )
        );

        // Clear the cached counts only after a successful insert.
        if ( false !== $result ) {
            delete_transient( 'pmt_project_view_counts' );
        }
    }

    /**
     * Retrieve the view count for one project.
     */
    public function get_view_count( $project_id ) {

        $project_id = absint( $project_id );

        if ( $project_id < 1 ) {
            return 0;
        }

        global $wpdb;

        $table_name = $wpdb->prefix . 'pmt_project_views';

        $count = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*)
                 FROM {$table_name}
                 WHERE project_id = %d",
                $project_id
            )
        );

        return (int) $count;
    }

    /**
     * Retrieve and cache all project view counts for one hour.
     */
    public function get_cached_view_counts() {

        $cached = get_transient(
            'pmt_project_view_counts'
        );

        if ( false !== $cached && is_array( $cached ) ) {
            return $cached;
        }

        global $wpdb;

        $table_name = $wpdb->prefix . 'pmt_project_views';

        // No user-supplied values are included in this query.
        $counts = $wpdb->get_results(
            "SELECT project_id, COUNT(*) AS view_count
             FROM {$table_name}
             GROUP BY project_id",
            ARRAY_A
        );

        $counts = is_array( $counts )
            ? $counts
            : array();

        set_transient(
            'pmt_project_view_counts',
            $counts,
            HOUR_IN_SECONDS
        );

        return $counts;
    }
}
