<?php 

/**
 * The WT Shortcode Slider class show testimonials in slider from the plugin.
 *
 * @package wp-easy-testimonial
 * @since    0.1
 */
 
/**
 * The Slider Testimonials shorcode to display testimonial posts in slider from this function
 *
 */
 
/**
 * Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Shortcode_Slider {
	
	/**
	 * A reference to the version of the plugin
	 *
	 * @access private
	 * @var    string    $version
	 */
	private $version;

	/**
	 * Initializes this class and stores the current version of this plugin.
	 * and adding wbr-slider-testimonials shorcode
	 *
	 * @param    string    $version
	 */
	public function __construct( $version ) {
		$this->version = $version;
		add_shortcode( 'wbr-slider-testimonials' , array( $this, 'etp_testimonials_slider_callback' ) );
	}
	
	public function etp_testimonials_slider_callback( $atts ){
		global $etp_options;
		
		$slider = rand();
		
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
			 'show_excerpt' => ( isset( $etp_options['wtshow_excerpt'] ) ? 1 : 0 ),
			 'excerpt_length' =>  ( isset( $etp_options['wtexcerptlength'] ) ? $etp_options['wtexcerptlength'] : 45 ),
			 'excerpt_text' => ( isset( $etp_options['wtreadmoretext'] ) ? $etp_options['wtreadmoretext'] : 'Read More' ),			 
			 'count' => -1,
			 'cat' => '',
			 'order' => 'DESC', // ASC or DESC
			 'orderby' => 'date',
			 'post_status' => 'publish',
			 
			 'column' => ( isset( $etp_options['wtslidercolumn'] ) ? $etp_options['wtslidercolumn'] : 1 ),
			 'type' => ( isset( $etp_options['wtslidertype'] ) ? $etp_options['wtslidertype'] : 'slide' ),
			 'nav' => ( isset( $etp_options['wtslidernav'] ) ? 'false' : 'true' ),
			 'next' => ( isset( $etp_options['wtslidernexttext'] ) ? $etp_options['wtslidernexttext'] : 'Next' ),
			 'prev' => ( isset( $etp_options['wtsliderprevtext'] ) ? $etp_options['wtsliderprevtext'] : 'Prev' ),
			 'pagination' => ( isset( $etp_options['wtsliderpagi'] ) ? 'false' : 'true' ),
			 'mousedrag' => ( isset( $etp_options['wtslidermousedrag'] ) ? 'false' : 'true' ),
			 
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
		
		if( ! is_numeric( $count ) ){
			$count = -1;
		}
		
		// check if category exist or not
		$taxarg = array();
		
		if( strlen($cat) > 0 ){
			$taxarg = array(
				array(
					'taxonomy' => 'testimonial_categories',
					'field' => 'slug',
					'terms' => $cat
				)
			);
		}
		
		// create query arg for loop
		$args = array( 
			'post_type' => 'testimonial',
			'posts_per_page' => $count, 
			'tax_query' => $taxarg,
			'post_status' => $post_status,
			'orderby' => $orderby,
			'order' => $order
		);
		
		$output = '';
		ob_start();
		
		$loop = etp_get_loop( $args );		
		$posts = $loop->get_posts();
		
			foreach( $posts as $post ){
				// store testimonial object and shorcode attributes into in array $data
				$data = array(
						'testimonial' => $post,
						'atts' => $atts
					);
					
				// create object for get single testimonial item contens
				$wttestimonial = new ETP_Single_Item( $data );
				
				// call function for render html
				$wttestimonial->etp_html();
			}
			
			wp_reset_postdata();
			
		$output = ob_get_contents();
				  ob_end_clean();
			
			?>
			<script>
				jQuery(document).ready(function(){
					
					jQuery('body').addClass("wt-testimonial-slider");
					
					jQuery('#wtslider-<?php echo $slider; ?>').owlCarousel({
						autoplay:true,
						autoHeight : true,
						autoplayTimeout:3000,
						loop: true, 
						nav: <?php echo $nav; ?>, 
						margin:10,
						responsiveClass:true,
						items: <?php echo $column; ?>,
						dots: <?php echo $pagination; ?>,
						navText: ["<?php echo $prev; ?>","<?php echo $next; ?>"],
						
						<?php if($type != 'slide'){ ?>
						animateIn: 'fadeIn',
						animateOut: 'fadeOut',
						<?php } ?>
						mouseDrag: <?php echo $mousedrag; ?>,
					});
				});
			</script>
			<?php
		
		// before testimonial
		do_action( 'etp_before_testimonial' , $width );
			echo  '<div id="wtslider-'.$slider.'" class="owl-carousel owl-theme">';
			echo apply_filters( 'etp_testimonial_slider_html', $output);
			echo  '</div>';
			
			// adding more button
			etp_more_btn( $more_button );
			
		// after testimonial
		do_action( 'etp_after_testimonial' );
	}
	
}