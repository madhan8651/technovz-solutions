<?php
/**
 * The template for displaying 404 pages.
 *
 * @package TechNovz_Solutions
 */

get_header();
?>

<main id="main" class="site-main">

	<section class="error-404 not-found techNovz-404">

		<div class="page-content">

			<h1 class="page-title">
				<?php
				esc_html_e(
					'Oops! Page Not Found',
					'technovz-solutions'
				);
				?>
			</h1>


			<p class="error-message">
				<?php
				esc_html_e(
					'The page you are looking for may have been moved, deleted, or the URL may be incorrect.',
					'technovz-solutions'
				);
				?>
			</p>


			<h2>
				<?php
				esc_html_e(
					'Let’s Get You Back on Track',
					'technovz-solutions'
				);
				?>
			</h2>


			<p>
				<?php
				esc_html_e(
					'You can return to our homepage or explore our services and projects to find what you are looking for.',
					'technovz-solutions'
				);
				?>
			</p>


			<div class="error-buttons">

				<a
					class="error-button"
					href="<?php echo esc_url( home_url( '/' ) ); ?>"
				>
					<?php
					esc_html_e(
						'Back to Home',
						'technovz-solutions'
					);
					?>
				</a>


				<a
					class="error-button secondary-button"
					href="<?php echo esc_url( home_url( '/services/' ) ); ?>"
				>
					<?php
					esc_html_e(
						'View Our Services',
						'technovz-solutions'
					);
					?>
				</a>

			</div>

		</div>

	</section>

</main>

<?php
get_footer();