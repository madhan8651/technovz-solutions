<?php

namespace TechNovz\PMT\PostTypes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ProjectPostType {

	/**
	 * Register hooks.
	 */
	public function init() {
		add_action(
			'init',
			array( $this, 'register' )
		);
	}

	/**
	 * Register the Projects post type.
	 */
	public function register() {

		$labels = array(
			'name'               => __( 'Projects', 'project-management-toolkit' ),
			'singular_name'      => __( 'Project', 'project-management-toolkit' ),
			'menu_name'          => __( 'Projects', 'project-management-toolkit' ),
			'name_admin_bar'     => __( 'Project', 'project-management-toolkit' ),
			'add_new'            => __( 'Add New', 'project-management-toolkit' ),
			'add_new_item'       => __( 'Add New Project', 'project-management-toolkit' ),
			'edit_item'          => __( 'Edit Project', 'project-management-toolkit' ),
			'new_item'           => __( 'New Project', 'project-management-toolkit' ),
			'view_item'          => __( 'View Project', 'project-management-toolkit' ),
			'search_items'       => __( 'Search Projects', 'project-management-toolkit' ),
			'not_found'          => __( 'No projects found.', 'project-management-toolkit' ),
			'not_found_in_trash' => __( 'No projects found in Trash.', 'project-management-toolkit' ),
			'all_items'          => __( 'All Projects', 'project-management-toolkit' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => true,
			'show_in_rest'    => true,
			'has_archive'     => true,

			'rewrite'         => array(
				'slug' => 'projects',
			),

			'menu_icon'       => 'dashicons-portfolio',

			'supports'        => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
			),

			// Use WordPress's standard post capabilities.
			'capability_type' => 'post',
			'map_meta_cap'    => true,
		);

		register_post_type(
			'pmt_project',
			$args
		);
	}
}
