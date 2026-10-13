<?php
/**
 * The footer for TechNovz Solutions.
 *
 * @package TechNovz_Solutions
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<div class="techNovz-footer">

			<div class="footer-column footer-about">

				<h3>TechNovz Solutions</h3>

				<p class="footer-tagline">
					Web Development &amp; Digital Solutions
				</p>

				<p>
					We create practical and reliable digital solutions
					for modern businesses.
				</p>

			</div>

			<div class="footer-column footer-links">

				<h3>Quick Links</h3>

				<ul>

					<li>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							Home
						</a>
					</li>

					<li>
						<a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">
							About Us
						</a>
					</li>

					<li>
						<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">
							Services
						</a>
					</li>

					<li>
						<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
							Projects &amp; Portfolio
						</a>
					</li>

					<li>
						<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">
							Blog
						</a>
					</li>

					<li>
						<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">
							Contact Us
						</a>
					</li>

				</ul>

			</div>

			<div class="footer-column footer-contact">

				<h3>Contact Us</h3>

				<p>
					<strong>Email:</strong><br>
					<a href="mailto:contact@technovzsolutions.com">
						contact@technovzsolutions.com
					</a>
				</p>

				<p>
					<strong>Phone:</strong><br>
					<a href="tel:7896321458">
						7896321458
					</a>
				</p>

				<p>
					<strong>Location:</strong><br>
					India
				</p>

			</div>

		</div>

		<div class="footer-bottom">

			<p>
				&copy; <?php echo esc_html( date( 'Y' ) ); ?>
				TechNovz Solutions. All rights reserved.
			</p>

			<p>
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">
					Privacy Policy
				</a>
			</p>

		</div>

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>