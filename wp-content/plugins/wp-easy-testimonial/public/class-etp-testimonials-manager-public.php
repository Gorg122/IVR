<?php

/**
	* Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Testimonials_Manager_Public {

	/**
	 * A reference to the version of the plugin
	 *
	 * @access private
	 * @var    string    $version
	 */
	private $version;

	/**
	 * Initializes this class and stores the current version of this plugin.
	 *
	 * @param    string    $version
	 */
	public function __construct( $version ) {
		$this->version = $version;
		
		// Enable shortcodes in text widgets
		add_filter('widget_text','do_shortcode');

	}
	
	/**
	 * Custom css callback function 
	 */
	public function etp_customcss(){
		global $etp_options;
		echo '<style>';
		if( $etp_options['wtcss'] != '' ){
			echo esc_html( $etp_options['wtcss'] );
		}
		echo '</style>';
	}
	
	/**
	 * RETURN A "Continue Reading" LINK FOR EXCERPT
	 */
	 public function etp_continue_reading( $more ) {	
		global $post,$etp_options;
		
		$wbrcontentmore = isset( $etp_options['wtreadmoretext'] ) ? $etp_options['wtreadmoretext'] : '';
		if( is_admin() && 'testimonial' == get_post_type() ){
			return '...';
		}
		
		if( isset( $wbrcontentmore ) && 'testimonial' == get_post_type() ){
			$more = ' <a class="more-link" href="'.get_the_permalink().'" title="'.get_the_title().'">'.$wbrcontentmore.'</a>';
			return $more;
		}
	}
	
	/**
	 * Set excerpt content
	 */
	 public function etp_excerpt_content( $output ){
		return str_replace('Read More','',strip_tags($output));
	}
	
	/**
	 * Set excerpt length
	 */
	 public function etp_excerpt_length( $length ){
		global $etp_options;
		
		$wbrcontentlength = isset( $etp_options['wtexcerptlength'] ) ? $etp_options['wtexcerptlength'] : 45 ;		
		if( is_admin() && 'testimonial' == get_post_type() ){
			return 20;
		}
		
		if( isset( $wbrcontentlength ) && 'testimonial' == get_post_type() ){
			$length = $wbrcontentlength;
		}
		return $length;
	}
	
	/**
	 * POST CLASS FILTER FOR TESTIMONIAL POST
	 */
	 public function etp_addpostclass( $classes ) {
		global $post, $etp_options;
		
		if( 'testimonial' == get_post_type() && ! is_search() && ! is_single() ){
			global $wtshortcodeatts;
			$wtshortcodeatts['column'] = isset( $wtshortcodeatts['column'] ) ? $wtshortcodeatts['column'] : 1 ;
			
			$classes = '';
			$classes[] = 'wtpost';
			$classes[] = 'grid-column-'. $wtshortcodeatts['column'];
			$classes[] = 'margin-50';
			
			if( isset( $etp_options['wtcustomclass'] ) && $etp_options['wtcustomclass'] != null ){
				$classes[] = $etp_options['wtcustomclass'];
			}
		}
		return $classes;
	}
	
	/**
	 * BLOGINFO FUNCTION TO GET INFORMATION
	 */
	public function etp_bloginfo_callback ( $key ) { 
		return get_bloginfo( $key ); 
	}
	
	/**
	 * Register scripts and styles
	 */
	public function etp_registerscripts(){
		wp_register_style(
			'wt-style', 
			etp_testimonialurl . 'assets/css/wtstyle.css',
			false,
			$this->version,
			'all'
		);
	}
	
	/**
	 * Enqueue frontend scripts and styles
	 */
	public function etp_enqueuescripts(){

		wp_enqueue_style('wt-style');
			
		wp_enqueue_style( 
			'wt-fonts', 
			etp_fonts_url(), 
			false,
			$this->version,
			false
		);
		
		wp_enqueue_style(
			'fontawesome', 
			etp_testimonialurl . 'assets/css/font-awesome-4.7.0/css/font-awesome.min.css',
			false,
			$this->version,
			false
		);
	
		wp_enqueue_style(
			'oul-carousel', 
			etp_testimonialurl . 'assets/css/owl.carousel.css',
			false, 
			$this->version,
			false
			);
	    wp_enqueue_style(
			'oul-theme-default', 
			etp_testimonialurl . 'assets/css/owl.theme.default.min.css',
			false,
			$this->version,
			false
			);
	    wp_enqueue_script(
			'oul-carousel', 
			etp_testimonialurl . 'assets/js/owl.carousel.min.js', 
			array('jquery'),
			$this->version,
			true
			);
		wp_enqueue_script(
			'wt-custom', 
			etp_testimonialurl . 'assets/js/custom.js', 
			array(),
			$this->version,
			true
			);
	}
}