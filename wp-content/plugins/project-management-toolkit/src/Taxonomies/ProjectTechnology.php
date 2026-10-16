<?php

namespace TechNovz\PMT\Taxonomies;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ProjectTechnology {

    public function init() {
        add_action( 'init', array( $this, 'register_taxonomy' ) );
    }

    public function register_taxonomy() {

        $labels = array(
            'name'                       => __( 'Project Technologies', 'project-management-toolkit' ),
            'singular_name'              => __( 'Project Technology', 'project-management-toolkit' ),
            'search_items'               => __( 'Search Project Technologies', 'project-management-toolkit' ),
            'all_items'                  => __( 'All Project Technologies', 'project-management-toolkit' ),
            'edit_item'                  => __( 'Edit Project Technology', 'project-management-toolkit' ),
            'update_item'                => __( 'Update Project Technology', 'project-management-toolkit' ),
            'add_new_item'               => __( 'Add New Project Technology', 'project-management-toolkit' ),
            'new_item_name'              => __( 'New Project Technology Name', 'project-management-toolkit' ),
            'menu_name'                  => __( 'Project Technologies', 'project-management-toolkit' ),
        );

        register_taxonomy(
            'pmt_project_technology',
            array( 'pmt_project' ),
            array(
                'labels'            => $labels,
                'public'            => true,
                'hierarchical'      => false,
                'show_admin_column' => true,
                'show_in_rest'      => true,
                'rewrite'           => array(
                    'slug' => 'project-technology',
                ),
            )
        );
    }
}