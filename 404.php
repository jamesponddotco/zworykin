<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Zworykin
 */

declare ( strict_types = 1 );

get_header();
?>

<div class="section-inner">

	<header class="page-header section-inner thin">

		<div>

			<h1 class="title"><?php _e( 'Error 404', 'zworykin' ); ?></h1>

			<p><?php _e( "The page you're looking for could not be found. It may have been removed, renamed, or maybe it didn't exist in the first place.", 'zworykin' ); ?></p>

			<div class="meta">

				<a href="<?php echo esc_url( home_url() ); ?>"><?php _e( 'To the front page', 'zworykin' ); ?></a>

			</div>

		</div>

	</header><!-- .page-header -->

</div><!-- .post -->

<?php get_footer(); ?>
