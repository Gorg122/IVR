<?php 

/**
 * The WT Shortcode Count class getting all testimonials from the plugin.
 *
 * @package wp-easy-testimonial
 * @since    0.1
 */
 
/**
 * The testimonials count shorcode to display number of testimonial posts in custom post type
 *
 */
 
/**
 * Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Shortcode_Count {
	
	/**
	 * A reference to the version of the plugin
	 *
	 * @access private
	 * @var    string    $version
	 */
	private $version;

	/**
	 * Initializes this class and stores the current version of this plugin.
	 * and adding wbr-testimonials-count shorcode
	 *
	 * @param    string    $version
	 */
	public function __construct( $version ) {
		$this->version = $version;
		add_shortcode( 'wbr-testimonials-count' , array( $this, 'etp_testimonials_count_callback' ) );
	}
	
	public function etp_testimonials_count_callback( $atts ){
		
		extract(
			shortcode_atts(
				array(
					'cat' => '',
					'status' => 'publish',
				),
				$atts
			)
		); // extract shortcodes
		
		$taxarg = array();
		if( strlen( $cat ) > 0 ){
			$taxarg = array(
				array(
					'taxonomy' => 'testimonial_categories',
					'field' => 'slug',
					'terms' => $cat
				)
			);
		} // check if category exist or not
		
		$args = array (
			'post_type' => 'testimonial',
			'tax_query' => $taxarg,
			'post_status' => 'publish',
			'nopaging' => true
		);
		
		$result = etp_get_loop( $args );
		return $result->post_count;
	}
	
}