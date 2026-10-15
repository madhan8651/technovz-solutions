<?php

namespace TechNovz\PMT\Rest;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ProjectRestController {

    /**
     * Initialize the REST API controller.
     */
    public function init() {
        add_action(
            'rest_api_init',
            array( $this, 'register_routes' )
        );
    }

    /**
     * Register the projects REST API endpoint.
     */
    public function register_routes() {
        register_rest_route(
            'pmt/v1',
            '/projects',
            array(
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_projects' ),
                'permission_callback' => '__return_true',
                'args' => array(
    'page' => array(
        'default' => 1,
    ),
    'per_page' => array(
        'default' => 10,
    ),
),
            )
        );
    }

    /**
     * Return published projects with pagination.
     */
    public function get_projects( $request ) {

        // Read the original pagination values.
        $raw_page     = $request->get_param( 'page' );
        $raw_per_page = $request->get_param( 'per_page' );

        // Reject non-scalar or invalid page input.
        if (
            ! is_scalar( $raw_page )
            || filter_var(
                (string) $raw_page,
                FILTER_VALIDATE_INT
            ) === false
        ) {
            return new \WP_Error(
                'invalid_page',
                'The page parameter must be a positive integer.',
                array( 'status' => 400 )
            );
        }

        // Reject non-scalar or invalid per_page input.
        if (
            ! is_scalar( $raw_per_page )
            || filter_var(
                (string) $raw_per_page,
                FILTER_VALIDATE_INT
            ) === false
        ) {
            return new \WP_Error(
                'invalid_per_page',
                'The per_page parameter must be an integer between 1 and 50.',
                array( 'status' => 400 )
            );
        }

        // Convert validated values to integers.
        $page     = (int) $raw_page;
        $per_page = (int) $raw_per_page;

        // Validate pagination limits.
        if ( $page < 1 ) {
            return new \WP_Error(
                'invalid_page',
                'The page parameter must be at least 1.',
                array( 'status' => 400 )
            );
        }

        if ( $per_page < 1 || $per_page > 50 ) {
            return new \WP_Error(
                'invalid_per_page',
                'The per_page parameter must be between 1 and 50.',
                array( 'status' => 400 )
            );
        }

        // Retrieve published projects.
        $query = new \WP_Query(
            array(
                'post_type'      => 'pmt_project',
                'post_status'    => 'publish',
                'posts_per_page' => $per_page,
                'paged'          => $page,
                'orderby'        => 'date',
                'order'          => 'DESC',
            )
        );

        $projects = array();

        foreach ( $query->posts as $post ) {

            // Retrieve project categories.
            $categories = get_the_terms(
                $post->ID,
                'pmt_project_category'
            );

            $category_names = array();

            if (
                ! is_wp_error( $categories )
                && is_array( $categories )
            ) {
                foreach ( $categories as $category ) {
                    $category_names[] = sanitize_text_field(
                        $category->name
                    );
                }
            }

            // Retrieve and validate the featured image URL.
            $image_url = get_the_post_thumbnail_url(
                $post->ID,
                'large'
            );

            // Prepare plain-text project content.
            $title = sanitize_text_field(
                get_the_title( $post )
            );

            $description = sanitize_text_field(
                wp_strip_all_tags(
                    get_the_excerpt( $post )
                )
            );

            // Prepare the project permalink.
            $project_url = esc_url_raw(
                get_permalink( $post )
            );

            $projects[] = array(
                'id'          => (int) $post->ID,
                'title'       => $title,
                'description' => $description,
                'category'    => $category_names,
                'image_url'   => $image_url
                    ? esc_url_raw( $image_url )
                    : null,
                'project_url' => $project_url,
            );
        }

        // Return the existing JSON response structure.
        return rest_ensure_response(
            array(
                'success'    => true,
                'data'       => $projects,
                'pagination' => array(
                    'current_page' => $page,
                    'per_page'     => $per_page,
                    'total_items'  => (int) $query->found_posts,
                    'total_pages'  => (int) $query->max_num_pages,
                ),
            )
        );
    }
}
