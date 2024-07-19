<?php
/**
 * The template for displaying the header section.
 *
 * @package Hamilton
 */

declare ( strict_types = 1 );
?>

<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >

		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		}
		?>

		<a class="skip-link button" href="#site-content"><?php _e( 'Skip to the content', 'hamilton' ); ?></a>

		<header class="section-inner site-header">

			<?php

			$hamilton_site_title_elem = is_front_page() || ( is_home() && get_option( 'show_on_front' ) == 'posts' ) ? 'h1' : 'div';
			$hamilton_custom_logo_id  = get_theme_mod( 'custom_logo' );
			$hamilton_custom_logo     = wp_get_attachment_image_src( $hamilton_custom_logo_id, 'full' );
			$hamilton_site_title      = get_bloginfo( 'name' );

			?>

			<<?php echo esc_attr( $hamilton_site_title_elem ); ?> class="site-title">

				<?php
				if ( $hamilton_custom_logo ) :

					$hamilton_logo_url = $hamilton_custom_logo[0];
					$hamilton_height   = $hamilton_custom_logo[2];

					// Determine which height logo we need the mobile nav to adjust for.
					$hamilton_adjusted_height = $hamilton_height < 100 ? $hamilton_height : 100;
					?>

					<style>
						.site-nav { padding-top: <?php echo esc_attr( $hamilton_adjusted_height + 160 ); ?>px; }
						@media ( max-width: 620px ) {
							.site-nav { padding-top: <?php echo esc_attr( $hamilton_adjusted_height + 100 ); ?>px; }
						}
					</style>

					<a href="<?php echo esc_url( home_url() ); ?>" class="custom-logo" style="background-image: url( <?php echo esc_url( $hamilton_logo_url ); ?> );">
						<img src="<?php echo esc_url( $hamilton_logo_url ); ?>" />
						<span class="screen-reader-text"><?php echo esc_html( $hamilton_site_title ); ?></span>
					</a>

				<?php else : ?>
					<a href="<?php echo esc_url( home_url() ); ?>" class="site-name"><?php echo esc_html( $hamilton_site_title ); ?></a>
				<?php endif; ?>

			</<?php echo esc_attr( $hamilton_site_title_elem ); ?>>

			<button class="nav-toggle">
				<span class="screen-reader-text"><?php _e( 'Toggle menu', 'hamilton' ); ?></span>
				<div class="bars">
					<div class="bar"></div>
					<div class="bar"></div>
					<div class="bar"></div>
				</div>
			</button><!-- .nav-toggle -->

			<div class="alt-nav-wrapper">

				<ul class="alt-nav">
					<?php
					if ( has_nav_menu( 'primary-menu' ) ) :
						wp_nav_menu(
							array(
								'container'      => '',
								'items_wrap'     => '%3$s',
								'theme_location' => 'primary-menu',
							)
						);
					else :
						wp_list_pages(
							array(
								'container' => '',
								'title_li'  => '',
							)
						);
					endif;
					?>
				</ul><!-- .alt-nav -->

			</div><!-- .alt-nav-wrapper -->

		</header><!-- header -->

		<?php
		$hamilton_bg_color         = get_background_color();
		$hamilton_bg_color_default = 'ffffff';
		$hamilton_bg_css           = $hamilton_bg_color && $hamilton_bg_color != $hamilton_bg_color_default ? ' style="background-color: #' . esc_attr( $hamilton_bg_color ) . ';"' : '';
		?>

		<nav class="site-nav"<?php echo esc_attr( $hamilton_bg_css ); ?>>

			<div class="section-inner menus group">

				<?php
				if ( has_nav_menu( 'primary-menu' ) ) :
					wp_nav_menu(
						array(
							'container'      => '',
							'theme_location' => 'primary-menu',
						)
					);
				else :
					?>
					<ul>
						<?php
						wp_list_pages(
							array(
								'container' => '',
								'title_li'  => '',
							)
						);
						?>
					</ul>
					<?php
				endif;

				if ( has_nav_menu( 'secondary-menu' ) ) {
					wp_nav_menu(
						array(
							'container'      => '',
							'theme_location' => 'secondary-menu',
						)
					);
				}
				?>

			</div>

			<footer<?php echo esc_attr( $hamilton_bg_css ); ?>>

				<div class="section-inner group">

					<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <a href="<?php echo esc_url( home_url() ); ?>" class="site-name"><?php bloginfo( 'name' ); ?></a></p>
					<p class="theme-by"><?php _e( 'Theme by', 'hamilton' ); ?> <a href="https://www.andersnoren.se">Anders Nor&eacute;n</a></p>

				</div>

			</footer>

		</nav><!-- .site-nav -->

		<main id="site-content">
