<?php

namespace TechNovz\PMT\Taxonomies;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ProjectCategory {

    public function init() {
        add_action( 'init', array( $this, 'register_taxonomy' ) );
    }

    public function register_taxonomy() {

        $labels = array(
            'name'              => __( 'Project Categories', 'project-management-toolkit' ),
            'singular_name'     => __( 'Project Category', 'project-management-toolkit' ),
            'search_items'      => __( 'Search Project Categories', 'project-management-toolkit' ),
            'all_items'         => __( 'All Project Categories', 'project-management-toolkit' ),
            'parent_item'       => __( 'Parent Project Category', 'project-management-toolkit' ),
            'parent_item_colon' => __( 'Parent Project Category:', 'project-management-toolkit' ),
            'edit_item'         => __( 'Edit Project Category', 'project-management-toolkit' ),
            'update_item'       => __( 'Update Project Category', 'project-management-toolkit' ),
            'add_new_item'      => __( 'Add New Project Category', 'project-management-toolkit' ),
            'new_item_name'     => __( 'New Project Category Name', 'project-management-toolkit' ),
            'menu_name'         => __( 'Project Categories', 'project-management-toolkit' ),
        );

        register_taxonomy(
            'pmt_project_category',
            array( 'pmt_project' ),
            array(
                'labels'            => $labels,
                'public'            => true,
                'hierarchical'      => true,
                'show_admin_column' => true,
                'show_in_rest'      => true,
                'rewrite'           => array( 'slug' => 'project-category' ),
            )
        );
    }
}