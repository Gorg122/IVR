<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

function etp_get_settings_tabs(){
	$tabs             = array();
	$tabs['general']  = __( 'General Settings', 'wp-easy-testimonial' );
	$tabs['slider']   = __( 'Slider Settings', 'wp-easy-testimonial' );
	$tabs['theme']    = __( 'Themes', 'wp-easy-testimonial' );
	
	return apply_filters( 'etp_settings_tabs', $tabs );
}


function etp_setting_tabs_callback(){
	$settings_tabs = etp_get_settings_tabs();
	$settings_tabs = empty($settings_tabs) ? array() : $settings_tabs;
	$active_tab    = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general';
	$active_tab    = array_key_exists( $active_tab, $settings_tabs ) ? $active_tab : 'general';

	foreach ( etp_get_settings_tabs() as $tab_id => $tab_name ) {
		$tab_url = add_query_arg( array(
			'settings-updated' => false,
			'tab'              => $tab_id,
		) );

		$tab_url = remove_query_arg( 'section', $tab_url );

		$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

		echo '<a href="' . esc_url( $tab_url ) . '" class="nav-tab' . $active . '">';
			echo esc_html( $tab_name );
		echo '</a>';
	}

}
add_action('etp_setting_tabs_filter','etp_setting_tabs_callback');