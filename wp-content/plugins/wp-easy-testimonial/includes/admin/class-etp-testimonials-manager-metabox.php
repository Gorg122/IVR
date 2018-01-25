<?php 

/**
 * The WordPress Testimonial Manager Metabox class create meta data of custom post type
 *
 * @package wp-easy-testimonial
 * @since    0.1
 */
 
/**
 * Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Testimonials_Manager_Metabox {
	
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
	 * Metabox callback function
	 */
	public function etp_testimonial_meta_box(){
		
		add_meta_box( 
			'wttestimonial_info', 
			sprintf( __( '%1$s Clients Informations', 'wp-easy-testimonial' ), 
			etp_get_label_singular(), 
			etp_get_label_plural() ),  
			array( $this ,'etp_render_testimonial_meta_box'), 
			'testimonial', 
			'normal', 
			'high' 
			);
			
		add_meta_box( 
			'wttestimonial_shortcode', 
			sprintf( __( 'Single Shortcode', 'wp-easy-testimonial' ), 
			etp_get_label_singular(), 
			etp_get_label_plural() ),  
			array( $this ,'etp_render_shortcode_meta_box'), 
			'testimonial', 
			'side', 
			'low' 
			);
	}
	
	/**
	 * Create function for display meta box settings form
	 */
	public function etp_render_testimonial_meta_box(){
		require_once plugin_dir_path( __FILE__ ) . 'partials/testimonial-post-meta-manager.php';
	}
	
	/**
	 * Create function for save post meta contents
	 */
	public function etp_testimonial_meta_box_save( $post_id ){
		if((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit'])){
			return;
		}
		
		if ( ! current_user_can( 'edit_page', $post_id ) ){
			return ;	
		}
		
		if(isset($_POST['post_ID'])){
			$post_ID   = $_POST['post_ID'];
			$post_type = get_post_type( $post_ID );
			if( $post_type == 'testimonial' ){
				
				update_post_meta( $post_ID, 'wtclientname', sanitize_text_field( $_POST['wtclientname'] ) );
				update_post_meta( $post_ID, 'wtclientemail', sanitize_email( $_POST['wtclientemail'] ) );
				update_post_meta( $post_ID, 'wtclientdesignation', sanitize_text_field( $_POST['wtclientdesignation'] ) );
				update_post_meta( $post_ID, 'wtclientrate2', sanitize_text_field( $_POST['wtclientrate2'] ) );
			}
		}
	}
	
	/**
	 * Create function for display single post shortcode.
	 */
	public function etp_render_shortcode_meta_box(){
		require_once plugin_dir_path( __FILE__ ) . 'partials/testimonial-shortcode-manager.php';
	}
}