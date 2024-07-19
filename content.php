<?php
/**
 * Template part for displaying posts.
 *
 * @package Zworykin
 */

declare ( strict_types = 1 );
?>

<a <?php post_class( 'post-preview tracker' ); ?> id="post-<?php the_ID(); ?>" href="<?php the_permalink(); ?>">

	<header class="preview-header">

		<?php if ( is_sticky() ) : ?>
			<span class="sticky-post"><?php _e( 'Sticky', 'zworykin' ); ?></span>
		<?php endif; ?>

		<?php the_title( '<h2 class="title">', '</h2>' ); ?>

		<?php zworykin_entry_date(); ?>

	</header>

</a>
