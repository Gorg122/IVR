<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

function etp_get_registered_settings_sections(){
	static $sections = false;

	if ( false !== $sections ) {
		return $sections;
	}

	$sections = array(
		'general'    => apply_filters( 'etp_settings_sections_general', array(
			'main'               => __( 'General Settings', 'wp-easy-testimonial' ),
			'image'              => __( 'Featured Image', 'wp-easy-testimonial' ),
			'button'             => __( 'All Testimonials Button', 'wp-easy-testimonial' ),
			'customcss'          => __( 'Custom CSS', 'wp-easy-testimonial' ),
		) ),
		'slider'    => apply_filters( 'etp_settings_sections_slider', array(
			'main'               => __( 'Slider Settings', 'wp-easy-testimonial' ),
		) ),
		'theme'     => apply_filters( 'etp_settings_sections_theme', array(
			'main'               => __( 'Theme Settings', 'wp-easy-testimonial' ),
		) ),
	);

	$sections = apply_filters( 'etp_settings_sections', $sections );

	return $sections;
}

function etp_get_settings_tab_sections( $tab = false ) {

	$tabs     = false;
	$sections = etp_get_registered_settings_sections();

	if( $tab && ! empty( $sections[ $tab ] ) ) {
		$tabs = $sections[ $tab ];
	} else if ( $tab ) {
		$tabs = false;
	}

	return $tabs;
}


function etp_setting_sections_callback(){
	$settings_tabs = etp_get_settings_tabs();
	$settings_tabs = empty($settings_tabs) ? array() : $settings_tabs;
	$active_tab    = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general';
	$active_tab    = array_key_exists( $active_tab, $settings_tabs ) ? $active_tab : 'general';
	
	$sections      = etp_get_settings_tab_sections( $active_tab );
	$key           = 'main';
	
	if ( is_array( $sections ) ) {
		$key = key( $sections );
	}
	
	$registered_sections = etp_get_settings_tab_sections( $active_tab );
	$section             = isset( $_GET['section'] ) && ! empty( $registered_sections ) && array_key_exists( $_GET['section'], $registered_sections ) ? sanitize_text_field( $_GET['section'] ) : $key;
	
	$all_settings = etp_get_registered_settings();

	$has_main_settings = true;
	if ( empty( $all_settings[ $active_tab ]['main'] ) ) {
		$has_main_settings = false;
	}

	if ( ! $has_main_settings ) {
		foreach( $all_settings[ $active_tab ] as $sid => $stitle ) {
			if ( is_string( $sid ) && is_array( $sections ) && array_key_exists( $sid, $sections ) ) {
				continue;
			} else {
				$has_main_settings = true;
				break;
			}
		}
	}

	$override = false;
	if ( false === $has_main_settings ) {
		unset( $sections['main'] );

		if ( 'main' === $section ) {
			foreach ( $sections as $section_key => $section_title ) {
				if ( ! empty( $all_settings[ $active_tab ][ $section_key ] ) ) {
					$section  = $section_key;
					$override = true;
					break;
				}
			}
		}
	}
	


	$number_of_sections = count( $sections );
	$number = 0;
	if ( $number_of_sections > 1 ) {
		echo '<div><ul class="subsubsub">';
		foreach( $sections as $section_id => $section_name ) {
			echo '<li>';
			$number++;
			$tab_url = add_query_arg( array(
				'settings-updated' => false,
				'tab' => $active_tab,
				'section' => $section_id
			) );
			$class = '';
			if ( $section == $section_id ) {
				$class = 'current';
			}
			echo '<a class="' . $class . '" href="' . esc_url( $tab_url ) . '">' . $section_name . '</a>';

			if ( $number != $number_of_sections ) {
				echo ' | ';
			}
			echo '</li>';
		}
		echo '</ul></div>';
	}
}
add_action('etp_settings_sections_filter','etp_setting_sections_callback');