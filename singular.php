<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Zworykin
 */

declare ( strict_types = 1 );

get_header();

if ( have_posts() ) :

	while ( have_posts() ) :
		the_post();
		?>

		<article <?php post_class( 'entry section-inner' ); ?>>

			<?php
				$zworykin_fade_class = '';

			if ( has_post_thumbnail() ) {
				$zworykin_fade_class = ' fade-block';
			}
			?>

			<header class="page-header section-inner thin<?php echo esc_attr( $zworykin_fade_class ); ?>">

				<div>

					<?php

					the_title( '<h1 class="title entry-title">', '</h1>' );

					// Make sure we have a custom excerpt.
					if ( has_excerpt() ) {
						the_excerpt();
					}

					// Only output post meta data on single.
					if ( is_single() ) :
						?>

						<div class="meta">

							<?php
							echo esc_html__( 'In', 'zworykin' ) . ' ';
								the_category( ', ' );
							?>

						</div><!-- .meta -->

					<?php endif; ?>

				</div>

			</header><!-- .page-header -->

			<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>

				<figure class="entry-image featured-image">
					<?php the_post_thumbnail(); ?>
				</figure>

			<?php endif; ?>

			<div class="entry-content section-inner thin">

				<?php
				the_content();
				edit_post_link();
				?>

			</div><!-- .content -->

			<?php

			wp_link_pages(
				array(
					'before' => '<p class="section-inner thin linked-pages">' . __( 'Pages:', 'zworykin' ),
				)
			);

			if ( get_post_type() == 'post' ) :
				?>

				<div class="meta bottom section-inner thin">

					<?php if ( get_the_tags() ) : ?>

						<p class="tags"><?php the_tags( '<span>#', '</span><span>#', '</span> ' ); ?></p>

					<?php endif; ?>

					<p class="post-date"><a href="<?php the_permalink(); ?>"><?php zworykin_entry_date(); ?></a>

				</div><!-- .meta -->

			<?php endif; ?>

		</article><!-- .entry -->

		<?php

	endwhile;

endif;

get_footer(); ?>
