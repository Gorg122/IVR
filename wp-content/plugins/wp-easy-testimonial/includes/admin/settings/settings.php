<?php 
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// get option
function etp_get_option( $key = '', $default = false ) {
	global $etp_options;
	$value = ! empty( $etp_options[ $key ] ) ? $etp_options[ $key ] : $default;
	$value = apply_filters( 'etp_get_option', $value, $key, $default );
	return apply_filters( 'etp_get_option_' . $key, $value, $key, $default );
}

// update option
function etp_update_option( $key = '', $value = false ) {

	// If no key, exit
	if ( empty( $key ) ){
		return false;
	}

	if ( empty( $value ) ) {
		$remove_option = etp_delete_option( $key );
		return $remove_option;
	}

	// First let's grab the current settings
	$options = get_option( 'etp_settings' );

	// Let's let devs alter that value coming in
	$value = apply_filters( 'etp_update_option', $value, $key );

	// Next let's try to update the value
	$options[ $key ] = $value;
	$did_update = update_option( 'etp_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ){
		global $etp_options;
		$edd_options[ $key ] = $value;

	}

	return $did_update;
}

// delete option 
function etp_delete_option( $key = '' ) {

	// If no key, exit
	if ( empty( $key ) ){
		return false;
	}

	// First let's grab the current settings
	$options = get_option( 'etp_settings' );

	// Next let's try to update the value
	if( isset( $options[ $key ] ) ) {

		unset( $options[ $key ] );

	}

	$did_update = update_option( 'etp_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ){
		global $etp_options;
		$etp_options = $options;
	}

	return $did_update;
}



function etp_settings_sanitize( $input = array() ){
	global $etp_options;

	$doing_section = false;
	if ( ! empty( $_POST['_wp_http_referer'] ) ) {
		$doing_section = true;
	}

	$setting_types = etp_get_registered_settings_types();
	$input         = $input ? $input : array();

	if ( $doing_section ) {

		parse_str( $_POST['_wp_http_referer'], $referrer ); // Pull out the tab and section
		$tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';
		$section  = isset( $referrer['section'] ) ? $referrer['section'] : 'main';

		// Run a general sanitization for the tab for special fields (like taxes)
		$input = apply_filters( 'etp_settings_' . $tab . '_sanitize', $input );

		// Run a general sanitization for the section so custom tabs with sub-sections can save special data
		$input = apply_filters( 'etp_settings_' . $tab . '-' . $section . '_sanitize', $input );

	}

	// Merge our new settings with the existing
	$output = array_merge( $etp_options, $input );

	foreach ( $setting_types as $key => $type ) {

		if ( empty( $type ) ) {
			continue;
		}

		// Some setting types are not actually settings, just keep moving along here
		$non_setting_types = apply_filters( 'etp_non_setting_types', array(
			'header', 'descriptive_text', 'hook',
		) );

		if ( in_array( $type, $non_setting_types ) ) {
			continue;
		}

		if ( array_key_exists( $key, $output ) ) {
			$output[ $key ] = apply_filters( 'etp_settings_sanitize_' . $type, $output[ $key ], $key );
			$output[ $key ] = apply_filters( 'etp_settings_sanitize', $output[ $key ], $key );
		}

		if ( $doing_section ) {
			switch( $type ) {
				case 'checkbox':
				case 'gateways':
				case 'multicheck':
				case 'payment_icons':
					if ( array_key_exists( $key, $input ) && $output[ $key ] === '-1' ) {
						unset( $output[ $key ] );
					}
					break;
				default:
					if ( array_key_exists( $key, $input ) && empty( $input[ $key ] ) ) {
						unset( $output[ $key ] );
					}
					break;
			}
		} else {
			if ( empty( $input[ $key ] ) ) {
				unset( $output[ $key ] );
			}
		}

	}

	if ( $doing_section ) {
		//add_settings_error( 'wt-notices', '', __( 'Settings updated.', 'wp-easy-testimonial' ), 'updated' );
	}

	return $output;
}

function etp_get_registered_settings_types() {
	$settings      = etp_get_registered_settings();
	$setting_types = array();

	foreach ( $settings as $tab ) {

		foreach ( $tab as $section_or_setting ) {

			// See if we have a setting registered at the tab level for backwards compatibility
			if ( is_array( $section_or_setting ) && array_key_exists( 'type', $section_or_setting ) ) {
				$setting_types[ $section_or_setting['id'] ] = $section_or_setting['type'];
				continue;
			}

			foreach ( $section_or_setting as $section => $section_settings ) {
				$setting_types[ $section_settings['id'] ] = $section_settings['type'];
			}
		}

	}

	return $setting_types;
}


function etp_get_settings() {

	$settings = get_option( 'etp_settings' );

	if( empty( $settings ) ) {

		$general_settings = is_array( get_option( 'etp_settings_general' ) )    ? get_option( 'etp_settings_general' )    : array();
		$slider_settings = is_array( get_option( 'etp_settings_slider' ) )    ? get_option( 'etp_settings_slider' )    : array();
		$typography_settings = is_array( get_option( 'etp_settings_typography' ) )    ? get_option( 'etp_settings_typography' )    : array();
		$theme_settings = is_array( get_option( 'etp_settings_theme' ) )    ? get_option( 'etp_settings_theme' )    : array();
		$form_settings = is_array( get_option( 'etp_settings_theme' ) )    ? get_option( 'etp_settings_form' )    : array();
		

		$settings = array_merge( $general_settings, $slider_settings, $typography_settings, $theme_settings, $form_settings );

		update_option( 'etp_settings', $settings );

	}
	return apply_filters( 'etp_get_settings', $settings );
}


function etp_get_registered_settings(){
	
	$wtsettings = array(
		'general' => apply_filters( 'etp_settings_general', array(
			'main' => array(
				'general_header' => array(
					'id'   => 'general_header',
					'name' => '<h3>' . __( 'General Settings', 'wp-easy-testimonial' ) . '</h3>',
					'desc' => '',
					'type' => 'header',
				),
				'wtshow_search' => array(
					'id'   => 'wtshow_search',
					'name' => __( 'Exclude testimonials from search results', 'wp-easy-testimonial' ),
					'desc' => __( 'Check this setting to exclude testimonials type content from search results.', 'wp-easy-testimonial' ),
					'type' => 'checkbox',
					'checkbox_text' => __('Yes / No', 'wp-easy-testimonial'),
				),
				'wtexcerptlength' => array(
					'id'   => 'wtexcerptlength',
					'name' => __( 'Excerpt Length', 'wp-easy-testimonial' ),
					'desc' => __( 'Enter excerpt length. Default length is 45 words.', 'wp-easy-testimonial' ),
					'type' => 'text',
				),
				'wtreadmoretext' => array(
					'id'   => 'wtreadmoretext',
					'name' => __( 'Excerpt "Read More" Text', 'wp-easy-testimonial' ),
					'desc' => __( 'Change your readmore text from this setting.', 'wp-easy-testimonial' ),
					'type' => 'text',
					'std'  => 45,
				),
				'wtwidth' => array(
					'id'   => 'wtwidth',
					'name' => __( 'Width', 'wp-easy-testimonial' ),
					'desc' => __( 'Enter testimonial box width in pixel. For e.g. 400px or leave it blank to full width.', 'wp-easy-testimonial' ),
					'type' => 'text',
					'size' => 'small',
				),
				'wtcustomclass' => array(
					'id'   => 'wtcustomclass',
					'name' => __( 'Custom Class', 'wp-easy-testimonial' ),
					'desc' => __( 'Add custom css class to testimonial content wrapper. You may use this feature for custom styling.', 'wp-easy-testimonial' ),
					'type' => 'text',
				),
				'wtdateformat' => array(
					'id'   => 'wtdateformat',
					'name' => __( 'Date Format', 'wp-easy-testimonial' ),
					'desc' => __( 'Select date format.', 'wp-easy-testimonial' ),
					'type' => 'select',
					'options' => array(
						''       => '-- Select --',
						'F j, Y' => 'F j, Y',
						'Y-m-d'  => 'Y-m-d',
						'm/d/Y'  => 'm/d/Y',
						'd/m/Y'  => 'd/m/Y',
					),
					'std'  => 'F j, Y',
				),
				'wttestimonialinfotop' => array(
					'id'   => 'wttestimonialinfotop',
					'name' => __( 'Show testimonial author details before testimonial content.', 'wp-easy-testimonial' ),
					'desc' => __( 'Check this option to show testimonial author details above testimonial content.', 'wp-easy-testimonial' ),
					'type' => 'checkbox',
					'checkbox_text' => __('Yes / No', 'wp-easy-testimonial'),
				),
			),
			'image' => array(
				'image_header' => array(
					'id'   => 'image_header',
					'name' => '<h3>' . __( 'Featured Image Settings', 'wp-easy-testimonial' ) . '</h3>',
					'desc' => '',
					'type' => 'header',
				),
				'wtfeaturedimage' => array(
					'id'   => 'wtfeaturedimage',
					'name' => __( 'Hide author image.', 'wp-easy-testimonial' ),
					'desc' => __( 'Check this option for hiding testimonial author image.', 'wp-easy-testimonial' ),
					'type' => 'checkbox',
					'std'  => false,
					'checkbox_text' => __('Yes / No', 'wp-easy-testimonial'),
				),
				'wtimagealign' => array(
					'id'   => 'wtimagealign',
					'name' => __( 'Align', 'wp-easy-testimonial' ),
					'desc' => __( 'Align author image. Default alignment is left', 'wp-easy-testimonial' ),
					'type' => 'select',
					'options' => array('left'=>'left','center'=>'center','right'=>'right'),
					'std'    => 'left',
				),
				'wtimagesize' => array(
					'id'   => 'wtimagesize',
					'name' => __( 'Size of author image', 'wp-easy-testimonial' ),
					'desc' => '',
					'type' => 'select',
					'options' => etp_getfeaturedimagesize(),
					'std'  => 'default',
				),
				'wtimagetype' => array(
					'id'   => 'wtimagetype',
					'name' => __( 'Image Effect', 'wp-easy-testimonial' ),
					'desc' => __( 'You can also manage featured image style which you display image style.', 'wp-easy-testimonial' ),
					'type' => 'select',
					'options' => array('circle'=>'circle','rounded'=>'rounded','thumbnail'=>'thumbnail'),
					'std'    => 'rounded',
				),
				'wtgravatars' => array(
					'id'   => 'wtgravatars',
					'name' => __( 'Gravatar image', 'wp-easy-testimonial' ),
					'desc' => __( "If you want to show author's gravatar image? Please check this setting.", "wp-easy-testimonial" ),
					'type' => 'checkbox',
					'checkbox_text' => __('Yes / No', 'wp-easy-testimonial'),
				),
				
			),
			'button' => array(
				'button_header' => array(
					'id'   => 'button_header',
					'name' => '<h3>' . __( 'Configure all testimonials button', 'wp-easy-testimonial' ) . '</h3>',
					'desc' => '',
					'type' => 'header',
				),
				'wttestimonialbutton' => array(
					'id'   => 'wttestimonialbutton',
					'name' => __( 'Show all testimonials button', 'wp-easy-testimonial' ),
					'desc' => '',
					'type' => 'checkbox',
					'checkbox_text' => '',
				),
				'wttestimonialbuttontext' => array(
					'id'   => 'wttestimonialbuttontext',
					'name' => __( 'Button label', 'wp-easy-testimonial' ),
					'desc' => __( 'Specify button label in this setting', 'wp-easy-testimonial' ),
					'type' => 'text',
				),
				'wttestimonialbuttonlink' => array(
					'id'   => 'wttestimonialbuttonlink',
					'name' => __( 'Button link', 'wp-easy-testimonial' ),
					'desc' => __( 'Specify URL of page showing all your testimonials.', 'wp-easy-testimonial' ),
					'type' => 'text',
				),
				
			),
			'customcss' => array(
				'wtcss' => array(
					'id'   => 'wtcss',
					'name' => __( 'Custom CSS', 'wp-easy-testimonial' ),
					'desc' => __( 'Please enter your custom CSS code here. Without using <style> tag.', 'wp-easy-testimonial' ),
					'type' => 'textarea',
				),
			),
			
		) ),
		'slider' => apply_filters( 'etp_settings_slider', array(
			'main' => array(
				'slider_header' => array(
					'id'   => 'slider_header',
					'name' => '<h3>' . __( 'Slider Settings', 'wp-easy-testimonial' ) . '</h3>',
					'desc' => '',
					'type' => 'header',
				),
				'wtslidercolumn' => array(
					'id'   => 'wtslidercolumn',
					'name' => __( 'Columns', 'wp-easy-testimonial' ),
					'desc' => __( 'Please select this settings to set columns.', 'wp-easy-testimonial' ),
					'type' => 'select',
					'options' => array(
						1 => 1,
						2 => 2,
						3 => 3,
						4 => 4,
					),
				),
				'wtslidertype' => array(
					'id'   => 'wtslidertype',
					'name' => __( 'Slide Effect', 'wp-easy-testimonial' ),
					'desc' => __( 'Select among scroll and fade effects', 'wp-easy-testimonial' ),
					'type' => 'select',
					'options' => array(
						'slide' => 'Slide',
						'fade'  => 'Fade',
					),
				),
				'wtslidernav' => array(
					'id'   => 'wtslidernav',
					'name' => __( 'Hide Slider Navigation', 'wp-easy-testimonial' ),
					'desc' => __( 'Hide Prev and Next links from slider', 'wp-easy-testimonial' ),
					'type' => 'checkbox',
					'std'  => false,
					'checkbox_text' => __('Yes / No', 'wp-easy-testimonial'),
				),
				'wtslidernexttext' => array(
					'id'   => 'wtslidernexttext',
					'name' => __( 'Next Link Text', 'wp-easy-testimonial' ),
					'desc' => '',
					'type' => 'text',
					'std'  => 'Next',
				),
				'wtsliderprevtext' => array(
					'id'   => 'wtsliderprevtext',
					'name' => __( 'Previous Link Text', 'wp-easy-testimonial' ),
					'desc' => '',
					'type' => 'text',
					'std'  => 'Prev',
				),
				'wtsliderpagi' => array(
					'id'   => 'wtsliderpagi',
					'name' => __( 'Hide Slider Pagination', 'wp-easy-testimonial' ),
					'desc' => '',
					'type' => 'checkbox',
					'std'  => false,
					'checkbox_text' => '',
				),
				'wtslidermousedrag' => array(
					'id'   => 'wtslidermousedrag',
					'name' => __( 'Hide Slide Effect On dragging mouse or swiping fingure in mobile devices', 'wp-easy-testimonial' ),
					'desc' => '',
					'type' => 'checkbox',
					'std'  => false,
					'checkbox_text' => '',
				),
			),
			
		) ),
		'theme' => apply_filters( 'etp_settings_theme', array(
			'main' => array(
				'theme_header' => array(
					'id'   => 'theme_header',
					'name' => '<h3>' . __( 'Theme Settings', 'wp-easy-testimonial' ) . '</h3>',
					'desc' => '',
					'type' => 'header',
				),
				'wtthemes' => array(
					'id'   => 'wtthemes',
					'name' => __( 'Select theme', 'wp-easy-testimonial' ),
					'desc' => __( 'Please select your theme to show your testimonials in different styles.', 'wp-easy-testimonial' ),
					'type' => 'select',
					'options' => etp_getthemes(),
					'std'  => 'testimonial-default',
				),
			),
		) ),
		
	);
	
	return apply_filters( 'etp_registered_settings', $wtsettings );
}


function etp_register_settings(){
	foreach ( etp_get_registered_settings() as $tab => $sections ) {
		foreach ( $sections as $section => $settings) {
			
			$section_tabs = etp_get_settings_tab_sections( $tab );
			if ( ! is_array( $section_tabs ) || ! array_key_exists( $section, $section_tabs ) ) {
				$section = 'main';
				$settings = $sections;
			}
			
			add_settings_section(
				'etp_settings_' . $tab . '_' . $section,
				__return_null(),
				'__return_false',
				'etp_settings_' . $tab . '_' . $section
			);
			
			foreach ( $settings as $option ) {
				
				if ( empty( $option['id'] ) ) {
					continue;
				}

				$args = wp_parse_args( $option, array(
				    'section'       => $section,
				    'id'            => null,
				    'desc'          => '',
				    'name'          => '',
				    'size'          => null,
				    'options'       => '',
				    'std'           => '',
				    'min'           => null,
				    'max'           => null,
				    'step'          => null,
				    'chosen'        => null,
				    'placeholder'   => null,
				    'allow_blank'   => true,
				    'readonly'      => false,
				    'faux'          => false,
				    'tooltip_title' => false,
				    'tooltip_desc'  => false,
				    'field_class'   => '',
				) );
				
				add_settings_field(
					$args['id'],
					$args['name'],
					function_exists( 'etp_' . $args['type'] . '_callback' ) ? 'etp_' . $args['type'] . '_callback' : 'etp_missing_callback',
					'etp_settings_' . $tab . '_' . $section,
					'etp_settings_' . $tab . '_' . $section,
					$args
				);

			}
			
		}
	}
	
	register_setting( 'etp_settings', 'etp_settings', 'etp_settings_sanitize' );
	
}
add_action( 'admin_init', 'etp_register_settings' );


// header callback function
function etp_header_callback($args){
	?>
	<p class="description"><?php esc_html_e( $args['desc'] ); ?></p>
	<?php
}

// checkbox callback function
function etp_checkbox_callback($args){
	$wtsetting = etp_get_option( $args['id'] );
	
	if ( isset( $args['faux'] ) && true === $args['faux'] ) {
		$name = '';
	} else {
		$name = 'name="etp_settings[' . esc_attr( $args['id'] ) . ']"';
	}
	
	$checked  = isset($wtsetting) ? checked( 1, $wtsetting, false ) : '';
	?>
	<input type="hidden"<?php echo $name; ?> value="-1" />
	<input type="checkbox" name="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]" id="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]" value="1" <?php echo $checked; ?>>
	<label for="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( $args['checkbox_text'] ); ?></label>
	<p class="description"><?php esc_html_e( $args['desc'] ); ?></p>
	<?php
}

// multiple checkboxes
function etp_multicheck_callback( $args ) {
	$wtsetting = etp_get_option( $args['id'] );
	
	$class = $args['field_class'];
	
	if ( $wtsetting ) {
		$value = $wtsetting;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
	
	
	$html = '';
	if ( ! empty( $args['options'] ) ) {
		$html .= '<input type="hidden" name="etp_settings[' . esc_attr( $args['id'] ) . ']" value="-1" />';
		foreach( $args['options'] as $key => $option ):
			if( isset( $value[ $key ] ) ) { $enabled = $option; } else { $enabled = NULL; }
			$html .= '<input name="etp_settings[' . esc_attr( $args['id'] ) . '][' . esc_attr( $key ) . ']" id="etp_settings[' . esc_attr( $args['id'] ) . '][' . esc_attr( $key ) . ']" class="' . $class . '" type="checkbox" value="' . esc_attr( $option ) . '" ' . checked($option, $enabled, false) . '/>&nbsp;';
			$html .= '<label for="etp_settings[' . esc_attr( $args['id'] ) . '][' . esc_attr( $key ) . ']">' . wp_kses_post( $option ) . '</label><br/>';
		endforeach;
		$html .= '<p class="description">' . $args['desc'] . '</p>';
	}

	echo apply_filters( 'etp_after_setting_output', $html, $args );
}

// password callback function 
function etp_password_callback($args){
	$wtsetting = etp_get_option( $args['id'] );
	
	if ( $wtsetting ) {
		$value = $wtsetting;
	} elseif( ! empty( $args['allow_blank'] ) && empty( $wtsetting ) ) {
		$value = '';
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
	
	$size     = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	?>
	<input class="<?php esc_attr_e( $size );  ?>" type="password" name="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]" id="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]" value="<?php esc_html_e( stripslashes( $value ) ); ?>" />
	<p class="description"><?php esc_html_e( $args['desc'] ); ?></p>
	<?php
}

// text callback function 
function etp_text_callback($args){
	$wtsetting = etp_get_option( $args['id'] );
	
	if ( $wtsetting ) {
		$value = $wtsetting;
	} elseif( ! empty( $args['allow_blank'] ) && empty( $wtsetting ) ) {
		$value = '';
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
	
	$size     = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
	?>
	<input class="<?php esc_attr_e( $size );  ?>" type="text" name="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]" id="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]" value="<?php esc_html_e( stripslashes( $value ) ); ?>" />
	<p class="description"><?php esc_html_e( $args['desc'] ); ?></p>
	<?php
}

// textarea callback function 
function etp_textarea_callback($args){
	$wtsetting = etp_get_option( $args['id'] );
	if ( $wtsetting ) {
		$value = $wtsetting;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
	
	$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'medium';
	?>
	<textarea class="<?php esc_attr_e( $size );  ?>" rows="4" cols="80" name="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]" id="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]"><?php esc_html_e( stripslashes( $value ) ); ?></textarea>
	<p class="description"><?php esc_html_e( $args['desc'] ); ?></p>
	<?php
}

// select callback function
function etp_select_callback($args){
	$wtsetting = etp_get_option( $args['id'] );
	
	if ( $wtsetting ) {
		$value = $wtsetting;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}
	?>
	<select name="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]" id="etp_settings[<?php esc_attr_e( $args['id'] ); ?>]">
		<?php 
		foreach ( $args['options'] as $key => $option ) :
			$selected = isset( $value ) ? selected( $key, $value, false ) : '';
			echo '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $option ) . '</option>';
		endforeach;
		?>
	</select>
	<p class="description"><?php esc_html_e( $args['desc'] ); ?></p>
	<?php
}

// Color picker Callback
function etp_color_callback( $args ) {
	$wtsetting = etp_get_option( $args['id'] );

	if ( $wtsetting ) {
		$value = $wtsetting;
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	$default = isset( $args['std'] ) ? $args['std'] : '';

	$class = $args['field_class'];

	$html = '<input type="text" class="' . esc_attr( $class ) . ' wt-color-picker" id="etp_settings[' . esc_attr( $args['id'] ) . ']" name="etp_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( $value ) . '" data-default-color="' . esc_attr( $default ) . '" />';
	$html .= '<p class="description" for="etp_settings[' . esc_attr( $args['id'] ) . ']"> '  . wp_kses_post( $args['desc'] ) . '</p>';

	echo apply_filters( 'etp_after_setting_output', $html, $args );
}


// missing callback function
function etp_missing_callback($args) {
	printf(
		__( 'The callback function used for the %s setting is missing.', 'wp-easy-testimonial' ),
		'<strong>' . $args['id'] . '</strong>'
	);
}