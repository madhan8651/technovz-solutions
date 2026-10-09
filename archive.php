<?php
/**
 * The template for displaying archive pages.
 *
 * @package TechNovz_Solutions
 */

get_header();
?>

<main id="main" class="site-main">

	<header class="page-header">

		<?php
		the_archive_title(
			'<h1 class="page-title">',
			'</h1>'
		);
		?>

		<?php
		the_archive_description(
			'<div class="archive-description">',
			'</div>'
		);
		?>

	</header>


	<?php if ( have_posts() ) : ?>

		<?php
while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content', get_post_type() );

endwhile;
?>


		<?php the_posts_navigation(); ?>


	<?php else : ?>

		<section class="no-results">

			<h2>
				<?php esc_html_e( 'No posts found.', 'technovz-solutions' ); ?>
			</h2>

		</section>

	<?php endif; ?>

</main>

<?php
get_sidebar();
get_footer();