<?php
/**
 * Template part for displaying post content.
 *
 * @package TechNovz_Solutions
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php
		the_title(
			'<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">',
			'</a></h2>'
		);
		?>

	</header>


	<?php if ( has_post_thumbnail() ) : ?>

		<div class="post-thumbnail">

			<a href="<?php echo esc_url( get_permalink() ); ?>">

				<?php
				the_post_thumbnail(
					'medium',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>

			</a>

		</div>

	<?php endif; ?>


	<div class="entry-content">

		<?php the_excerpt(); ?>

	</div>


	<footer class="entry-footer">

		<a href="<?php echo esc_url( get_permalink() ); ?>">
			Read More
		</a>

	</footer>

</article>