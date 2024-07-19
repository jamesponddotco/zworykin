<?php
/**
 * The main template file.
 *
 * @package Hamilton
 */

declare ( strict_types = 1 );

get_header();
?>

<div class="section-inner">

	<?php

	$hamilton_archive_title_elem  = is_front_page() || ( is_home() && get_option( 'show_on_front' ) == 'posts' ) ? 'h2' : 'h1';
	$hamilton_archive_title       = get_the_archive_title();
	$hamilton_archive_description = get_the_archive_description();

	if ( $hamilton_archive_title || $hamilton_archive_description ) :
		?>

		<header class="page-header fade-block">
			<div>

				<?php if ( $hamilton_archive_title ) : ?>
					<<?php echo esc_html( $hamilton_archive_title_elem ); ?> class="title"><?php echo wp_kses_post( $hamilton_archive_title ); ?></<?php echo esc_html( $hamilton_archive_title_elem ); ?>>
				<?php endif; ?>

				<?php if ( $hamilton_archive_description ) : ?>
					<div class="archive-description"><?php echo wp_kses_post( wpautop( $hamilton_archive_description ) ); ?></div>
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
