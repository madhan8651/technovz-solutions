<?php
/**
 * The template for displaying search results.
 *
 * @package TechNovz_Solutions
 */

get_header();
?>

<main id="main" class="site-main">

	<header class="page-header">

		<h1 class="page-title">
			<?php
			printf(
				esc_html__( 'Search Results for: %s', 'technovz-solutions' ),
				'<span>' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>

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
				<?php esc_html_e( 'Nothing Found', 'technovz-solutions' ); ?>
			</h2>

			<p>
				<?php
				esc_html_e(
					'Sorry, we could not find any content matching your search.',
					'technovz-solutions'
				);
				?>
			</p>

		</section>

	<?php endif; ?>

</main>

<?php
get_sidebar();
get_footer();