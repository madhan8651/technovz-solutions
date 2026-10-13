<?php

namespace TechNovz\PMT\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ReactProjects {

    /**
     * Initialize the React projects frontend.
     */
    public function init() {
        add_shortcode(
            'pmt_react_projects',
            array( $this, 'render_shortcode' )
        );

        add_action(
            'wp_enqueue_scripts',
            array( $this, 'enqueue_assets' )
        );

        // AJAX for logged-in users.
        add_action(
            'wp_ajax_pmt_load_more_projects',
            array( $this, 'load_more_projects' )
        );

        // AJAX for public visitors.
        add_action(
            'wp_ajax_nopriv_pmt_load_more_projects',
            array( $this, 'load_more_projects' )
        );
    }

    /**
     * Render the React application container.
     */
    public function render_shortcode() {
        return '<div id="pmt-react-projects">
            <p>Loading projects...</p>
        </div>';
    }

    /**
     * Load frontend assets only when the shortcode is present.
     */
    public function enqueue_assets() {
        if ( ! is_singular() ) {
            return;
        }

        global $post;

        if (
            ! $post instanceof \WP_Post
            || ! has_shortcode(
                $post->post_content,
                'pmt_react_projects'
            )
        ) {
            return;
        }

        wp_enqueue_script( 'wp-element' );

        wp_enqueue_script(
            'pmt-react-projects',
            plugin_dir_url( dirname( __DIR__ ) )
                . 'assets/js/react-projects.js',
            array( 'wp-element' ),
            '1.1.1',
            true
        );

        wp_localize_script(
            'pmt-react-projects',
            'pmtReactProjects',
            array(
                'apiUrl' => esc_url_raw(
                    rest_url( 'pmt/v1/projects' )
                ),
                'ajaxUrl' => esc_url_raw(
                    admin_url( 'admin-ajax.php' )
                ),
                'nonce' => wp_create_nonce(
                    'pmt_load_more_projects'
                ),
            )
        );

        wp_enqueue_style(
            'pmt-react-projects',
            plugin_dir_url( dirname( __DIR__ ) )
                . 'assets/css/react-projects.css',
            array(),
            '1.1.3'
        );
    }

    /**
     * Load the next page of published projects through AJAX.
     */
    public function load_more_projects() {

        // Validate the nonce input before processing it.
        $nonce = '';

        if (
            isset( $_POST['nonce'] )
            && is_string( $_POST['nonce'] )
        ) {
            $nonce = sanitize_text_field(
                wp_unslash( $_POST['nonce'] )
            );
        }

        // Verify the request's security nonce.
        if (
            ! wp_verify_nonce(
                $nonce,
                'pmt_load_more_projects'
            )
        ) {
            wp_send_json_error(
                array(
                    'message' => 'Security verification failed. Refresh the page and try again.',
                ),
                403
            );
        }

        // Read and validate the page parameter.
        $raw_page = '';

        if (
            isset( $_POST['page'] )
            && is_string( $_POST['page'] )
        ) {
            $raw_page = wp_unslash( $_POST['page'] );
        }

        if (
            ! preg_match(
                '/^[1-9][0-9]{0,5}$/',
                $raw_page
            )
        ) {
            wp_send_json_error(
                array(
                    'message' => 'The page parameter must be a positive integer.',
                ),
                400
            );
        }

        $page = (int) $raw_page;
        if ( $page > 10000 ) {
    wp_send_json_error(
        array(
            'message' => 'The requested page is too large.',
        ),
        400
    );
}

        // Keep the number of projects returned per request fixed.
        $per_page = 2;

        // Retrieve published projects only.
        $query = new \WP_Query(
            array(
                'post_type'              => 'pmt_project',
                'post_status'            => 'publish',
                'posts_per_page'         => $per_page,
                'paged'                  => $page,
                'orderby'                => 'date',
                'order'                  => 'DESC',
                'ignore_sticky_posts'    => true,
                'no_found_rows'          => false,
            )
        );

        // Reject page numbers beyond the available results.
        if (
            $query->max_num_pages > 0
            && $page > $query->max_num_pages
        ) {
            wp_send_json_error(
                array(
                    'message' => 'The requested page does not exist.',
                ),
                400
            );
        }

        $projects = array();

        foreach ( $query->posts as $project_post ) {

            // Retrieve project categories.
            $categories = get_the_terms(
                $project_post->ID,
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

            // Retrieve the featured image.
            $image_url = get_the_post_thumbnail_url(
                $project_post->ID,
                'large'
            );

            // Prepare plain-text project content.
            $title = sanitize_text_field(
                get_the_title( $project_post )
            );

            $description = sanitize_text_field(
                wp_strip_all_tags(
                    get_the_excerpt( $project_post )
                )
            );

            // Validate URLs before returning them to the frontend.
            $safe_image_url = $image_url
                ? esc_url_raw( $image_url )
                : null;

            $safe_project_url = esc_url_raw(
                get_permalink( $project_post )
            );

            $projects[] = array(
                'id'          => (int) $project_post->ID,
                'title'       => $title,
                'description' => $description,
                'category'    => $category_names,
                'image_url'   => $safe_image_url,
                'project_url' => $safe_project_url,
            );
        }

        // Preserve the response format used by the React frontend.
        wp_send_json_success(
            array(
                'data'       => $projects,
                'pagination' => array(
                    'current_page' => $page,
                    'per_page'     => $per_page,
                    'total_items'  => (int) $query->found_posts,
                    'total_pages'  => (int) $query->max_num_pages,
                    'has_more'     => $page < (int) $query->max_num_pages,
                ),
            )
        );
    }
}
