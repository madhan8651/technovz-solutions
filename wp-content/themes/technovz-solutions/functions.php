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

/* Dynamic Projects Portfolio */
function technovz_dynamic_projects_shortcode() {

    $projects = new WP_Query(array(
        'post_type'      => 'pmt_project',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    ob_start();

    if ($projects->have_posts()) :
        echo '<div class="technovz-project-grid">';

        while ($projects->have_posts()) :
            $projects->the_post();

            $description = get_the_excerpt();

            if (empty($description)) {
                $description = wp_strip_all_tags(
                    get_the_content()
                );
            }
            ?>

            <article class="technovz-project-card">

                <a class="technovz-project-image"
                   href="<?php the_permalink(); ?>">

                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large'); ?>
                    <?php else : ?>
                        <div class="technovz-project-no-image">
                            Project Image
                        </div>
                    <?php endif; ?>

                </a>

                <div class="technovz-project-content">

                    <h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <p>
                        <?php echo esc_html(
                            wp_trim_words($description, 25)
                        ); ?>
                    </p>

                    <a class="technovz-project-button"
                       href="<?php the_permalink(); ?>">
                        View Project →
                    </a>

                </div>

            </article>

            <?php
        endwhile;

        echo '</div>';

    else :
        echo '<p>No projects have been published yet.</p>';
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode(
    'technovz_projects',
    'technovz_dynamic_projects_shortcode'
);

/**
 * Projects listing with search and filters.
 * Shortcode: [technovz_projects]
 */
function technovz_filtered_projects_shortcode() {
    $search     = isset( $_GET['project_search'] )
        ? sanitize_text_field( wp_unslash( $_GET['project_search'] ) )
        : '';
    $category   = isset( $_GET['project_category'] )
        ? absint( $_GET['project_category'] )
        : 0;
    $technology = isset( $_GET['project_technology'] )
        ? absint( $_GET['project_technology'] )
        : 0;
    $status     = isset( $_GET['project_status'] )
        ? sanitize_text_field( wp_unslash( $_GET['project_status'] ) )
        : '';

    $tax_query = array( 'relation' => 'AND' );

    if ( $category ) {
        $tax_query[] = array(
            'taxonomy' => 'pmt_project_category',
            'field'    => 'term_id',
            'terms'    => $category,
        );
    }

    if ( $technology ) {
        $tax_query[] = array(
            'taxonomy' => 'pmt_project_technology',
            'field'    => 'term_id',
            'terms'    => $technology,
        );
    }

    $args = array(
        'post_type'      => 'pmt_project',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        's'              => $search,
    );

    if ( count( $tax_query ) > 1 ) {
        $args['tax_query'] = $tax_query;
    }

    if ( in_array( $status, array( 'Planned', 'In Progress', 'Completed' ), true ) ) {
        $args['meta_query'] = array(
            array(
                'key'     => '_pmt_project_status',
                'value'   => $status,
                'compare' => '=',
            ),
        );
    }

    $projects = new WP_Query( $args );

    $categories = get_terms( array(
        'taxonomy'   => 'pmt_project_category',
        'hide_empty' => false,
    ) );

    $technologies = get_terms( array(
        'taxonomy'   => 'pmt_project_technology',
        'hide_empty' => false,
    ) );

    ob_start();
    ?>
    <form method="get" class="project-filter-form">
        <input
            type="search"
            name="project_search"
            placeholder="Search projects..."
            value="<?php echo esc_attr( $search ); ?>"
        >

        <select name="project_category">
            <option value="">All Categories</option>
            <?php if ( ! is_wp_error( $categories ) ) : ?>
                <?php foreach ( $categories as $term ) : ?>
                    <option
                        value="<?php echo esc_attr( $term->term_id ); ?>"
                        <?php selected( $category, $term->term_id ); ?>
                    >
                        <?php echo esc_html( $term->name ); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <select name="project_technology">
            <option value="">All Technologies</option>
            <?php if ( ! is_wp_error( $technologies ) ) : ?>
                <?php foreach ( $technologies as $term ) : ?>
                    <option
                        value="<?php echo esc_attr( $term->term_id ); ?>"
                        <?php selected( $technology, $term->term_id ); ?>
                    >
                        <?php echo esc_html( $term->name ); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <select name="project_status">
            <option value="">All Statuses</option>
            <?php foreach ( array( 'Planned', 'In Progress', 'Completed' ) as $option ) : ?>
                <option
                    value="<?php echo esc_attr( $option ); ?>"
                    <?php selected( $status, $option ); ?>
                >
                    <?php echo esc_html( $option ); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Filter Projects</button>
        <a href="<?php echo esc_url( get_permalink() ); ?>">Clear</a>
    </form>

    <div class="technovz-project-grid">
        <?php if ( $projects->have_posts() ) : ?>
            <?php while ( $projects->have_posts() ) : $projects->the_post(); ?>
                <article class="technovz-project-card">
                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium_large' ); ?>
                        <?php endif; ?>
                        <h3><?php echo esc_html( get_the_title() ); ?></h3>
                    </a>

                    <div class="project-excerpt">
                        <?php echo esc_html( get_the_excerpt() ); ?>
                    </div>

                    <?php
                    $project_status = get_post_meta(
                        get_the_ID(),
                        '_pmt_project_status',
                        true
                    );
                    ?>
                    <?php if ( $project_status ) : ?>
                        <p>
                            <strong>Status:</strong>
                            <?php echo esc_html( $project_status ); ?>
                        </p>
                    <?php endif; ?>

                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                        View Project
                    </a>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No projects match your filters.</p>
        <?php endif; ?>
    </div>
    <?php

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode( 'technovz_projects', 'technovz_filtered_projects_shortcode' );
