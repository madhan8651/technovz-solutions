<?php
/**
 * The header for TechNovz Solutions.
 *
 * @package TechNovz_Solutions
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="site">

	<header id="masthead" class="site-header">

		<div class="site-branding">

			<?php
			/*
			 * Display custom logo if one is configured.
			 * Otherwise display the site title.
			 */
			if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) :

				the_custom_logo();

			else :
				?>

				<a
					class="site-title"
					href="<?php echo esc_url( home_url( '/' ) ); ?>"
					rel="home"
				>
					<?php bloginfo( 'name' ); ?>
				</a>

				<?php
			endif;
			?>

			<p class="site-description">
				<?php bloginfo( 'description' ); ?>
			</p>

		</div><!-- .site-branding -->


		<nav
			id="site-navigation"
			class="main-navigation"
			aria-label="<?php esc_attr_e( 'Primary Menu', 'technovz-solutions' ); ?>"
		>

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'fallback_cb'    => false,
				)
			);
			?>

		</nav><!-- #site-navigation -->

	</header><!-- #masthead -->


	<div id="content" class="site-content">