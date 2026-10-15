<?php
/**
 * Template for displaying individual Projects.
 *
 * @package TechNovz_Solutions
 */

get_header();

/*
 * Change this URL if your Projects & Portfolio page
 * uses a different slug.
 */
$projects_page_url = home_url( '/projects-2/' );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			$project_id = get_the_ID();

			$project_url = get_post_meta(
				$project_id,
				'_pmt_project_url',
				true
			);

			$completion_date = get_post_meta(
				$project_id,
				'_pmt_completion_date',
				true
			);

			$project_status = get_post_meta(
				$project_id,
				'_pmt_project_status',
				true
			);
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<?php
					the_title(
						'<h1 class="entry-title">',
						'</h1>'
					);
					?>

					<div class="entry-meta">
						<span><?php echo esc_html( get_the_date() ); ?></span>
						<span>
							<?php esc_html_e( ' by ', 'technovz-solutions' ); ?>
							<?php the_author(); ?>
						</span>
					</div>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-thumbnail">
						<?php
						the_post_thumbnail(
							'large',
							array(
								'alt' => the_title_attribute(
									array( 'echo' => false )
								),
							)
						);
						?>
					</div>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<section class="project-details">
					<h2><?php esc_html_e( 'Project Details', 'technovz-solutions' ); ?></h2>

					<?php
					$taxonomies = array(
						'pmt_project_category'   => 'Project Category',
						'pmt_project_technology' => 'Project Technology',
					);

					foreach ( $taxonomies as $taxonomy => $label ) :
						if ( taxonomy_exists( $taxonomy ) ) :
							$terms = get_the_terms( $project_id, $taxonomy );

							if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) :
								?>
								<p>
									<strong><?php echo esc_html( $label ); ?>:</strong>
									<?php
									$term_names = wp_list_pluck( $terms, 'name' );
									echo esc_html( implode( ', ', $term_names ) );
									?>
								</p>
								<?php
							endif;
						endif;
					endforeach;
					?>

					<?php if ( $project_status ) : ?>
						<p>
							<strong><?php esc_html_e( 'Status:', 'technovz-solutions' ); ?></strong>
							<?php echo esc_html( $project_status ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $completion_date ) : ?>
						<p>
							<strong><?php esc_html_e( 'Completion Date:', 'technovz-solutions' ); ?></strong>
							<?php echo esc_html( $completion_date ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $project_url && wp_http_validate_url( $project_url ) ) : ?>
						<p>
							<strong><?php esc_html_e( 'Project URL:', 'technovz-solutions' ); ?></strong>
							<a href="<?php echo esc_url( $project_url ); ?>"
								target="_blank"
								rel="noopener noreferrer">
								<?php echo esc_html( $project_url ); ?>
							</a>
						</p>
					<?php endif; ?>
				</section>

				<footer class="entry-footer">
					<?php
					the_terms( $project_id, 'pmt_project_category', '', ', ' );
					?>
				</footer>

				<!-- Back to Projects at the bottom -->
				<nav class="project-back-navigation project-back-bottom"
					aria-label="<?php esc_attr_e( 'Return to project listing', 'technovz-solutions' ); ?>">
					<a href="<?php echo esc_url( $projects_page_url ); ?>"
						class="project-back-button">
						&larr; <?php esc_html_e( 'Back to Projects', 'technovz-solutions' ); ?>
					</a>
				</nav>

			</article>

			<?php
		endwhile;
		?>

	</main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
