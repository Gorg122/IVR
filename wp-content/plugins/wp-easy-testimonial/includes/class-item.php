<?php 

/**
 * The WT Single Item Class getting single testimonial data from the plugin.
 *
 * @package wp-easy-testimonial
 * @since    0.1
 */

/**
 * Exit if accessed directly.
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Single_Item {
	
	/**
	 * A reference to the testimonial post of the plugin
	 *
	 * @access protected
	 * @var    object   $testimonial
	 */
	protected $testimonial;
	
	/**
	 * A reference to the shortcode attributes
	 *
	 * @access protected
	 * @var    array   $atts
	 */
	protected $atts;
	
	/**
	 * Initializes this class and store testimonial object and shortcode attributes in class member 
	 * variables
	 *
	 * @param    array    $data
	 */
	function __construct( $data = array() ){
		$this->testimonial  = !empty( $data['testimonial'] ) ? $data['testimonial'] : new stdClass;
		$this->atts         = $data['atts'];
	}
	
	public function etp_html(){
		global $post,$etp_options;
		$wbrcontentmore = isset( $etp_options['wtreadmoretext'] ) ? $etp_options['wtreadmoretext'] : '';
		
		setup_postdata( $GLOBALS['post'] =& $this->testimonial );
		$date = get_the_time( $this->atts['date_format'] );
		?>
		
		<div id="wtpost-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php 
			do_action( 'etp_before_post_content' );
			
				echo '<div class="'.esc_attr( $this->atts['theme'] ).' wtclear text-'. esc_attr( $this->atts['thumbnail_align'] ) .'">';
					
					// featured image of the post
					$this->etp_testimonial_image( get_the_post_thumbnail( '' , $this->atts['thumbnail_size'] , array( 'class' => ' thumbnail-' . $this->atts['thumbnail_size'] . ' img-' . $this->atts['thumbnail_type'] ) ) ); 
					
					
					if( $this->atts['show_title'] ){ 
						 the_title('<h4 class="wt-title">','</h4>'); 
					 } 

					 if( $this->atts['timonialinfotop'] == true ){ 
						$this->etp_testimonial_meta( $date );
					} 
					
					echo '<aside class="wt-content">';

						if( has_excerpt() ){
							the_excerpt();
						}else if( strpos( get_the_content() , '(more' ) ){
							the_content( sprintf(
								__( '%s', 'wp-easy-testimonial' ),
								$wbrcontentmore
							) );
						}else{
							the_excerpt();
						}
						
					echo '</aside>';

					
					if( $this->atts['timonialinfotop'] != true ){ 
						$this->etp_testimonial_meta( $date );
					}
		
				echo '</div>';
				
			do_action( 'etp_after_post_content' );
			?>	
		</div>
		
		<?php		
		wp_reset_postdata(); // reset post data
	}
	
	/**
	 * Fetch testimonial featured image from the post.
	 *
	 * @param    string    $image
	 */
	public function etp_testimonial_image( $image = '' ){
		setup_postdata( $GLOBALS['post'] =& $this->testimonial );
		
		$wtclientemail = sanitize_email( get_post_meta( $this->testimonial->ID, 'wtclientemail', true ));
		if( $this->atts['show_thumbnail'] == false ) :
			if( $this->atts['gravatar'] ){
				echo '<figure class="thumbnail-'. $this->atts['thumbnail_align'] .'">';
					echo get_avatar( $wtclientemail , 512 , 'mystery' , null , array('class' => array('thumbnail-'.$this->atts['thumbnail_size'].' img-'. $this->atts['thumbnail_type']) ) );
				echo '</figure>';
			}else{
				if( $image != '' ){
				echo '<figure class="thumbnail-'. $this->atts['thumbnail_align'] .'">';
					echo $image;
				echo '</figure>';
				}
			}
		endif;
	}
	
	/**
	 * Fetch testimonial post meta from the post.
	 *
	 * @param    string    $date
	 */
	public function etp_testimonial_meta( $date = '' ){
		$wtclientname = sanitize_text_field( get_post_meta( $this->testimonial->ID, 'wtclientname', true ));
		$wtclientemail = sanitize_email( get_post_meta( $this->testimonial->ID, 'wtclientemail', true ));
		$wtclientdesignation = sanitize_text_field( get_post_meta( $this->testimonial->ID, 'wtclientdesignation', true ));
		$wtclientrate2 = sanitize_text_field( get_post_meta( $this->testimonial->ID, 'wtclientrate2', true ));
		echo '<div class="wt-info">';
			// client name
			if( !empty( $wtclientname ) ) :
			echo '<span class="wt-name">'.$wtclientname.'</span>';
			endif;
			// client designation
			if( !empty( $wtclientdesignation ) ) :
			echo '<span class="wt-designation">'.$wtclientdesignation.'</span>';
			endif;
			// show email address
			if( !empty( $wtclientemail ) ) :
			echo '<span class="wt-email">'.$wtclientemail.'</span>';
			endif;
			// show date
			if( $this->atts['show_date'] ){
			echo '<span class="wt-date">'.$date.'</span>';
			}
			// show ratings
			if( $wtclientrate2 != '' ) {
				echo '<div class="wt-ratings">';
					for( $i = 1 ; $i <=5 ; $i++ ){ 
						if( $i <= $wtclientrate2 ){
							echo '<span class="wtstar fill"><i class="glyphicon-star"></i></span>';
						}else{
							echo '<span class="wtstar unfill"><i class="glyphicon-star"></i></span>';
						}
					} 
				echo '</div>';
			}
		echo '</div>';
	}
}