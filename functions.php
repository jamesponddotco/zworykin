<?php
/**
 * Hamilton.
 *
 * This file adds functions to the Hamilton theme.
 *
 * @package Hamilton
 */

declare ( strict_types = 1 );

add_action( 'after_setup_theme', 'hamilton_setup' );
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @return void
 */
function hamilton_setup(): void {
	// Automatic feed.
	add_theme_support( 'automatic-feed-links' );

	// Set content-width.
	global $content_width;
	if ( null === $content_width ) {
		$content_width = 560;
	}

	// Post thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes.
	add_image_size( 'hamilton_preview-image', 1200, 9999 );
	set_post_thumbnail_size( 1860, 9999 );

	// Background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'ffffff',
		)
	);

	// Custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 400,
			'width'       => 600,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Title tag.
	add_theme_support( 'title-tag' );

	// Add nav menu.
	register_nav_menu( 'primary-menu', __( 'Primary Menu', 'hamilton' ) );
	register_nav_menu( 'secondary-menu', __( 'Secondary Menu', 'hamilton' ) );

	// Add excerpts to pages.
	add_post_type_support( 'page', array( 'excerpt' ) );

	// HTML5 semantic markup.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	// Add Jetpack infinite scroll support.
	add_theme_support(
		'infinite-scroll',
		array(
			'type'           => 'click',
			'footer'         => false,
			'footer_widgets' => false,
			'container'      => 'posts',
		)
	);

	// Make the theme translation ready.
	load_theme_textdomain( 'hamilton', get_template_directory() . '/languages' );
}


// Include the Hamilton Customizer class.
require get_template_directory() . '/inc/classes/class-hamilton-customize.php';

add_action( 'wp_enqueue_scripts', 'hamilton_load_style' );
/**
 * Enqueues theme stylesheets.
 *
 * @return void
 */
function hamilton_load_style(): void {

	$theme_version = wp_get_theme( 'hamilton' )->get( 'Version' );

	wp_register_style( 'hamilton-reset', get_theme_file_uri( '/assets/css/reset.css' ), array(), $theme_version );
	wp_enqueue_style( 'hamilton-reset', get_stylesheet_uri(), array( 'hamilton-reset' ), $theme_version );

	wp_register_style( 'hamilton-fonts', get_theme_file_uri( '/assets/css/fonts.css' ), array(), $theme_version );
	wp_enqueue_style( 'hamilton-style', get_stylesheet_uri(), array( 'hamilton-fonts' ), $theme_version );
}

add_action( 'init', 'hamilton_add_editor_styles' );
/**
 * Enqueues theme style sheets for the classic editor.
 *
 * @return void
 */
function hamilton_add_editor_styles(): void {
	add_editor_style( array( 'assets/css/hamilton-classic-editor-styles.css', 'assets/css/fonts.css' ) );
}

// Deactivate default WordPress gallery styles.
add_filter( 'use_default_gallery_style', '__return_false' );

add_action( 'wp_enqueue_scripts', 'hamilton_enqueue_scripts' );
/**
 * Enqueues theme scripts.
 *
 * @return void
 */
function hamilton_enqueue_scripts(): void {
	$theme_version = wp_get_theme( 'hamilton' )->get( 'Version' );

	wp_enqueue_script(
		'hamilton_global',
		get_template_directory_uri() . '/assets/js/global.js',
		array(
			'jquery',
			'imagesloaded',
			'masonry',
		),
		$theme_version,
		true
	);

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'post_class', 'hamilton_post_classes' );
/**
 * Adds custom classes to the array of post classes.
 *
 * @param  array $classes An array of post class names.
 * @return array
 */
function hamilton_post_classes( $classes ): array {
	// Class indicating presence/lack of post thumbnail.
	$classes[] = ( has_post_thumbnail() ? 'has-thumbnail' : 'missing-thumbnail' );

	return $classes;
}

add_action( 'body_class', 'hamilton_body_classes' );
/**
 * Adds custom classes to the array of body classes.
 *
 * @param  array $classes An array of body class names.
 * @return array
 */
function hamilton_body_classes( $classes ): array {
	// Check whether we're in the customizer preview.
	if ( is_customize_preview() ) {
		$classes[] = 'customizer-preview';
	}

	// Check whether we want it darker.
	if ( get_theme_mod( 'hamilton_dark_mode' ) ) {
		$classes[] = 'dark-mode';
	}

	// Check whether we want the alt nav.
	if ( get_theme_mod( 'hamilton_alt_nav' ) ) {
		$classes[] = 'show-alt-nav';
	}

	// Check whether we're doing three preview columns.
	if ( get_theme_mod( 'hamilton_max_columns' ) ) {
		$classes[] = 'three-columns-grid';
	}

	// Check whether we're doing three preview columns.
	if ( get_theme_mod( 'hamilton_show_titles' ) ) {
		$classes[] = 'show-preview-titles';
	}

	// Add short class to body if resumé page template.
	if ( is_page_template( 'resume-page-template.php' ) ) {
		$classes[] = 'resume-template';
	}

	return $classes;
}

add_action( 'wp_head', 'hamilton_has_js' );
/**
 * Remove the no-js class from the HTML element and add the js class if JavaScript is enabled.
 *
 * @return void
 */
function hamilton_has_js(): void {
	?>
	<script>jQuery( 'html' ).removeClass( 'no-js' ).addClass( 'js' );</script>
	<?php
}

add_filter( 'get_the_archive_title', 'hamilton_filter_archive_title' );
/**
 * Filters the archive titles.
 *
 * @param  string $title The archive title.
 * @return string
 */
function hamilton_filter_archive_title( $title ): string {
	global $paged;

	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '#', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_year() ) {
		$title = get_the_date( 'Y' );
	} elseif ( is_month() ) {
		$title = get_the_date( 'F Y' );
	} elseif ( is_day() ) {
		$title = get_the_date( get_option( 'date_format' ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'hamilton' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'hamilton' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'hamilton' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'hamilton' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'hamilton' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'hamilton' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'hamilton' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'hamilton' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'hamilton' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_search() ) {
		// Translators: %s is the search query.
		$title = sprintf( __( 'Search: %s', 'hamilton' ), '&ldquo;' . get_search_query() . '&rdquo;' );
	} elseif ( is_home() ) {
		if ( 0 === $paged && get_theme_mod( 'hamilton_home_title' ) === true ) {
			$title = get_theme_mod( 'hamilton_home_title' );
		} else {
			$title = '';
		}
	}

	return $title;
}

add_filter( 'get_the_archive_description', 'hamilton_filter_archive_description' );
/**
 * Filters the archive descriptions.
 *
 * @param  string $description The archive description.
 * @return string
 */
function hamilton_filter_archive_description( $description ): string {

	if ( is_search() && have_posts() ) {
		global $wp_query;

		// Translators: %s is the number of search results.
		$description = sprintf( __( 'We found %s results matching your search.', 'hamilton' ), $wp_query->found_posts );
	} elseif ( is_search() && ! have_posts() ) {
		$description = sprintf( __( 'We could not find any results for your search.', 'hamilton' ), get_search_query() );
	}

	return $description;
}

add_action( 'after_setup_theme', 'hamilton_add_block_editor_features' );
/**
 * Declare support for the block editor and some of its features.
 *
 * @return void
 */
function hamilton_add_block_editor_features(): void {
	/* Block Editor Features ------------- */
	add_theme_support( 'align-wide' );

	/* Block Editor Palette -------------- */
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => _x( 'Black', 'Name of the black color in the Gutenberg palette', 'hamilton' ),
				'slug'  => 'black',
				'color' => '#000',
			),
			array(
				'name'  => _x( 'Dark Gray', 'Name of the dark gray color in the Gutenberg palette', 'hamilton' ),
				'slug'  => 'dark-gray',
				'color' => '#333',
			),
			array(
				'name'  => _x( 'Medium Gray', 'Name of the medium gray color in the Gutenberg palette', 'hamilton' ),
				'slug'  => 'medium-gray',
				'color' => '#555',
			),
			array(
				'name'  => _x( 'Light Gray', 'Name of the light gray color in the Gutenberg palette', 'hamilton' ),
				'slug'  => 'light-gray',
				'color' => '#777',
			),
			array(
				'name'  => _x( 'White', 'Name of the white color in the Gutenberg palette', 'hamilton' ),
				'slug'  => 'white',
				'color' => '#fff',
			),
		)
	);

	/* Block Editor Font Sizes ----------- */
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => _x( 'Small', 'Name of the small font size in Gutenberg', 'hamilton' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the Gutenberg editor.', 'hamilton' ),
				'size'      => 17,
				'slug'      => 'small',
			),
			array(
				'name'      => _x( 'Regular', 'Name of the regular font size in Gutenberg', 'hamilton' ),
				'shortName' => _x( 'M', 'Short name of the regular font size in the Gutenberg editor.', 'hamilton' ),
				'size'      => 20,
				'slug'      => 'regular',
			),
			array(
				'name'      => _x( 'Large', 'Name of the large font size in Gutenberg', 'hamilton' ),
				'shortName' => _x( 'L', 'Short name of the large font size in the Gutenberg editor.', 'hamilton' ),
				'size'      => 24,
				'slug'      => 'large',
			),
			array(
				'name'      => _x( 'Larger', 'Name of the larger font size in Gutenberg', 'hamilton' ),
				'shortName' => _x( 'XL', 'Short name of the larger font size in the Gutenberg editor.', 'hamilton' ),
				'size'      => 28,
				'slug'      => 'larger',
			),
		)
	);
}

add_action( 'enqueue_block_editor_assets', 'hamilton_block_editor_styles', 1 );
/**
 * Enqueues Gutenberg admin editor fonts and styles.
 *
 * @return void
 */
function hamilton_block_editor_styles(): void {
	$theme_version = wp_get_theme( 'hamilton' )->get( 'Version' );

	wp_register_style(
		'hamilton-block-editor-styles-font',
		get_theme_file_uri( '/assets/css/fonts.css' ),
		array(),
		$theme_version,
	);

	wp_enqueue_style(
		'hamilton-block-editor-styles',
		get_theme_file_uri( '/assets/css/hamilton-block-editor-styles.css' ),
		array( 'hamilton-block-editor-styles-font' ),
		$theme_version,
		'all',
	);
}
