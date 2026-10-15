<?php
/**
 * Main template file.
 *
 * @package TechNovz_Solutions
 */

get_header();
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php single_post_title(); ?>
					</h1>
				</header>

			<?php endif; ?>

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part(
					'template-parts/content',
					get_post_type()
				);

			endwhile;
			?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<section class="no-results">

				<h1>
					<?php esc_html_e( 'Nothing Found', 'technovz-solutions' ); ?>
				</h1>

				<p>
					<?php esc_html_e( 'No content was found.', 'technovz-solutions' ); ?>
				</p>

			</section>

		<?php endif; ?>

	</main>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>