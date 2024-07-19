<?php
/**
 * The main template file.
 *
 * @package Zworykin
 */

declare ( strict_types = 1 );

get_header();
?>

<div class="section-inner">

	<?php

	$zworykin_archive_title_elem  = is_front_page() || ( is_home() && get_option( 'show_on_front' ) == 'posts' ) ? 'h2' : 'h1';
	$zworykin_archive_title       = get_the_archive_title();
	$zworykin_archive_description = get_the_archive_description();
	$zworykin_home_excerpt        = is_front_page() && get_theme_mod( 'zworykin_home_excerpt' );

	if ( $zworykin_archive_title || $zworykin_archive_description ) :
		?>

		<header class="page-header fade-block">
			<div>

				<?php if ( $zworykin_archive_title ) : ?>
					<<?php echo esc_html( $zworykin_archive_title_elem ); ?> class="title"><?php echo wp_kses_post( $zworykin_archive_title ); ?></<?php echo esc_html( $zworykin_archive_title_elem ); ?>>
				<?php endif; ?>

				<?php if ( $zworykin_archive_description ) : ?>
					<div class="archive-description"><?php echo wp_kses_post( wpautop( $zworykin_archive_description ) ); ?></div>
				<?php endif; ?>

				<?php if ( $zworykin_home_excerpt ) : ?>
					<p><?php echo wp_kses_post( get_theme_mod( 'zworykin_home_excerpt' ) ); ?></p>
				<?php endif; ?>

				<?php
				if ( is_search() && ! have_posts() ) {
					get_search_form();
				}
				?>

			</div>
		</header><!-- .page-header -->

	<?php endif; ?>

	<?php if ( have_posts() ) : ?>

		<div class="posts" id="posts">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'content' );

			endwhile;
			?>

		</div><!-- .posts -->

	<?php endif; ?>

</div><!-- .section-inner -->

<?php

get_template_part( 'pagination' );

get_footer(); ?>
