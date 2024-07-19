<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hamilton
 */

declare ( strict_types = 1 );
?>
		</main>

		<footer class="site-footer section-inner">

			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <a href="<?php echo esc_url( home_url() ); ?>" class="site-name"><?php bloginfo( 'name' ); ?></a></p>
			<p class="theme-by"><?php _e( 'Theme by', 'hamilton' ); ?> <a href="https://andersnoren.se">Anders Nor&eacute;n</a></p>

		</footer><!-- footer -->

		<?php wp_footer(); ?>

	</body>
</html>
