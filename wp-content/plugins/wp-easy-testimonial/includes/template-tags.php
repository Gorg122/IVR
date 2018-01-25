<?php 

/**
 * Exit if accessed directly.
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;


/*=========================================================*/
/*	INCLUDE TEMPLATE FILE FUNCTION
/*=========================================================*/
function etp_get_template_part( $template = '' , $name = '' ){
	if( $name != null ){
		load_template( etp_testimonialdir . "includes/template/{$template}-{$name}.php" );
	}else{
		load_template( etp_testimonialdir . "includes/template/{$template}.php" );
	}
}

/*=========================================================*/
/*	GOOGLE FONTS
/*=========================================================*/
function etp_fonts_url(){
	global $etp_options;
	
	$fonts_url = '';
    $font_families = array();
	$font_families['Open Sans'] = 'Open Sans:300,400,500,600,700,700,800';
	$font_families['Montserrat'] = 'Montserrat:300,400,500,600,700,700,800';
	$font_families['italic'] = 'italic';
	
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    return $fonts_url;
}

/*=========================================================*/
/*	Get the loop
/*=========================================================*/
function etp_get_loop ( $atts = array() ){
	$loop = new WP_Query( $atts );
	return $loop;
}

/*=========================================================*/
/*	Adding more testimonial button
/*=========================================================*/
function etp_more_btn( $show_button ){
	global $etp_options;
	
	$link = isset( $etp_options['wttestimonialbuttonlink'] ) ? $etp_options['wttestimonialbuttonlink'] : '';
	if( empty( $link ) ){
		$link = '';
	}
	
	if( $show_button == true ):
		if( isset( $etp_options['wttestimonialbuttontext'] ) ):
		?>
		<div class="grid margin-top-bottom text-center">
			<a href="<?php echo esc_url( $link ); ?>" class="wt-btn" target="_blank"><?php esc_html_e( $etp_options['wttestimonialbuttontext'] ); ?></a>
		</div>
		<?php
		endif;
	endif;
}