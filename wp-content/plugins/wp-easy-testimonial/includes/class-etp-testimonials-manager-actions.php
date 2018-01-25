<?php 

/**
 * The WordPress Testimonial Manager Actions is the core plugin responsible for creating custom hooks
 *
 * @package wp-easy-testimonial
 * @since    0.1
 */
 
/**
 * Exit if accessed directly.
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Testimonials_Manager_Actions {
	
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
	}
	
	/**
	 * Adding parent wrapper <div> before testimonial posts
	 *
	 */
	public function etp_before_testimonial_callback( $width = '' ){
		
		$width_attribute = '';
		
		if( !empty( $width ) ){
			$width_attribute = ' style="width: ' . $width . ';" ';
		}
		
		echo '<div class="wt-wrapper clearfix grid" '. $width_attribute .' >';
	}
	
	/**
	 * Adding end parent wrapper </div> after testimonial posts
	 *
	 */
	public function etp_after_testimonial_callback(){
		echo '</div>';
	}
}