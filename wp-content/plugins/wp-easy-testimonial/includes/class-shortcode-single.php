<?php 

/**
 * The WT Shortcode Single class getting single testimonial from the plugin.
 *
 * @package wp-easy-testimonial
 * @since    0.1
 */
 
/**
 * The Single Testimonial shorcode to display single testimonial post from this function
 *
 */
 
/**
 * Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Shortcode_Single {
	
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
		add_shortcode( 'wbr-single-testimonial' , array( $this, 'etp_testimonials_single_callback' ) );
	}
	
	public function etp_testimonials_single_callback( $atts ){
		global $etp_options;

		$atts =	shortcode_atts(	array(
			 'id' => '',
			 'show_thumbnail' => (  isset( $etp_options['wtfeaturedimage'] ) ? 1 : 0 ),
			 'thumbnail_align' => ( isset( $etp_options['wtimagealign'] ) ? $etp_options['wtimagealign'] : 'left' ),
			 'thumbnail_size' => ( isset( $etp_options['wtimagesize'] ) ? $etp_options['wtimagesize'] : 'default' ),
			 'thumbnail_type' => ( isset( $etp_options['wtimagetype'] ) ? $etp_options['wtimagetype'] : 'circle' ),
			 'gravatar' => (  isset( $etp_options['wtgravatars'] ) ? 1 : 0 ),
			 'width' => ( isset( $etp_options['wtwidth'] ) ? $etp_options['wtwidth'] : '' ),
			 'class' => ( isset( $etp_options['wtcustomclass'] ) ? $etp_options['wtcustomclass'] : '' ),
			 'theme' => ( isset( $etp_options['wtthemes'] ) ? $etp_options['wtthemes'] : 'testimonial-default' ),
			 'excerpt_length' =>  ( isset( $etp_options['wtexcerptlength'] ) ? $etp_options['wtexcerptlength'] : 45 ),
			 'excerpt_text' => ( isset( $etp_options['wtreadmoretext'] ) ? $etp_options['wtreadmoretext'] : 'Read More' ),
			 'show_title' => 1,
			 'show_date' => 1,
			 'date_format' => ( isset( $etp_options['wtdateformat'] ) ? $etp_options['wtdateformat'] : 'F j, Y' ),
			 'more_button' => ( isset( $etp_options['wttestimonialbutton'] ) ? 1 : 0 ),
			 'timonialinfotop' => ( isset( $etp_options['wttestimonialinfotop'] ) ? 1 : 0 ),
			),
			$atts
		);
		
		// extract shorcodes
		extract( $atts );
		
		// fetch testimonial object form post id
		$wttestimonial = get_post( $atts['id'], OBJECT );
		
		// store testimonial object and shorcode attributes into in array $data
		$data = array(
				'testimonial' => $wttestimonial,
				'atts' => $atts
			);
		
		// create object for get single testimonial item contens
		$wttestimonial = new ETP_Single_Item( $data );
		
		$output = '';
		ob_start();
			
			// call function for render html
			$wttestimonial->etp_html();
			
			// adding more button
			etp_more_btn( $more_button );
			
		$output = ob_get_contents();
				  ob_end_clean();
		
		// before testimonial
		do_action( 'etp_before_testimonial' , $width );
			echo apply_filters( 'etp_testimonial_single_html', $output);
		// after testimonial
		do_action( 'etp_after_testimonial' );
	}
	
}