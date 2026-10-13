<?php
/**
 * The template for displaying all single posts.
 *
 * @package TechNovz_Solutions
 */

get_header();
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
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

						<span>
							<?php echo esc_html( get_the_date() ); ?>
						</span>

						<span>
							<?php
							esc_html_e(
								' by ',
								'technovz-solutions'
							);
							the_author();
							?>
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
									array(
										'echo' => false,
									)
								),
							)
						);
						?>

					</div>

				<?php endif; ?>

				<div class="entry-content">

					<?php the_content(); ?>

				</div>

				<footer class="entry-footer">

					<?php the_category( ', ' ); ?>

				</footer>

			</article>

			<?php
			the_post_navigation(
				array(
					'prev_text' => '← %title',
					'next_text' => '%title →',
				)
			);
			?>

			<?php
		endwhile;
		?>

	</main>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>