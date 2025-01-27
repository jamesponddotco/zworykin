<?php
/**
 * Zworykin theme customizer functionality for the WordPress Customizer.
 *
 * @package Zworykin
 */

declare ( strict_types = 1 );

if ( ! class_exists( 'Zworykin_Customize' ) ) :
	/**
	 * Zworykin_Customize Class
	 *
	 * This class handles the customization options for the Zworykin theme.
	 */
	class Zworykin_Customize {

		/**
		 * Registers customization settings and controls for the Zworykin theme.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public static function register( $wp_customize ): void {

			// Add our Customizer section.
			$wp_customize->add_section(
				'zworykin_options',
				array(
					'title'       => __( 'Theme Options', 'zworykin' ),
					'priority'    => 35,
					'capability'  => 'edit_theme_options',
					'description' => __( 'Customize the theme settings for Zworykin.', 'zworykin' ),
				)
			);

			// Always show preview titles.
			$wp_customize->add_setting(
				'zworykin_alt_nav',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'zworykin_sanitize_checkbox',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'zworykin_alt_nav',
				array(
					'type'        => 'checkbox',
					'section'     => 'zworykin_options', // Add a default or your own section.
					'label'       => __( 'Show Primary Menu in the Header', 'zworykin' ),
					'description' => __( 'Replace the navigation toggle in the header with the Primary Menu on desktop.', 'zworykin' ),
				)
			);

			// Set the home page title.
			$wp_customize->add_setting(
				'zworykin_home_title',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_textarea_field',
				)
			);

			$wp_customize->add_control(
				'zworykin_home_title',
				array(
					'type'        => 'textarea',
					'section'     => 'zworykin_options', // Add a default or your own section.
					'label'       => __( 'Front Page Title', 'zworykin' ),
					'description' => __( 'The title you want shown on the front page when the "Front page displays" setting is set to "Your latest posts" in Settings > Reading.', 'zworykin' ),
				)
			);

			// Set the home page excerpt.
			$wp_customize->add_setting(
				'zworykin_home_excerpt',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_textarea_field',
				)
			);

			$wp_customize->add_control(
				'zworykin_home_excerpt',
				array(
					'type'        => 'textarea',
					'section'     => 'zworykin_options', // Add a default or your own section.
					'label'       => __( 'Front Page Excerpt', 'zworykin' ),
					'description' => __( 'The excerpt you want shown on the front page when the "Front page displays" setting is set to "Your latest posts" in Settings > Reading.', 'zworykin' ),
				)
			);

			// Make built-in controls use live JS preview.
			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';

			/**
			 * Sanitize boolean for checkbox.
			 *
			 * @param bool $checked Whether the checkbox is checked.
			 */
			function zworykin_sanitize_checkbox( $checked ): bool {
				return ( ( isset( $checked ) && true == $checked ) ? true : false );
			}
		}

		/**
		 * Initiate the live preview JS.
		 */
		public static function live_preview(): void {
			wp_enqueue_script(
				'zworykin-themecustomizer',
				get_template_directory_uri() . '/assets/js/theme-customizer.js',
				array(
					'jquery',
					'customize-preview',
					'masonry',
				),
				wp_get_theme( 'zworykin' )->get( 'Version' ),
				true
			);
		}
	}

	// Setup the Theme Customizer settings and controls.
	add_action( 'customize_register', array( 'Zworykin_Customize', 'register' ) );

	// Enqueue live preview javascript in Theme Customizer admin screen.
	add_action( 'customize_preview_init', array( 'Zworykin_Customize', 'live_preview' ) );

endif;
