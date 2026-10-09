<?php
/**
 * TechNovz Solutions functions and definitions
 *
 * @package TechNovz_Solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Theme setup.
 */
function technovz_solutions_setup() {

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'technovz-solutions' ),
		)
	);
}

add_action( 'after_setup_theme', 'technovz_solutions_setup' );


/**
 * Register widget areas.
 */
function technovz_solutions_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Main Sidebar', 'technovz-solutions' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets to the main sidebar.', 'technovz-solutions' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer Widget Area', 'technovz-solutions' ),
			'id'            => 'footer-1',
			'description'   => __( 'Add widgets to the footer area.', 'technovz-solutions' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'technovz_solutions_widgets_init' );


/**
 * Enqueue parent and child theme styles.
 */
function technovz_solutions_enqueue_styles() {

	/*
	 * Load the Semplicemente parent stylesheet first.
	 */
	wp_enqueue_style(
		'semplicemente-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		'2.1.8'
	);

	/*
	 * Load TechNovz child stylesheet after the parent.
	 */
	wp_enqueue_style(
		'technovz-solutions-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'semplicemente-parent-style' ),
		'1.0.1'
	);

	/*
	 * Load child theme JavaScript.
	 */
	wp_enqueue_script(
		'technovz-solutions-main',
		get_stylesheet_directory_uri() . '/js/main.js',
		array(),
		'1.0.0',
		true
	);
}

add_action( 'wp_enqueue_scripts', 'technovz_solutions_enqueue_styles' );