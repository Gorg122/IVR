<?php 

/**
 * The WordPress Testimonial Manager Table Column defines all functionality for the dashboard
 * of the plugin
 *
 * @package wp-easy-testimonial
 * @since    0.1
 */
 
/**
 * Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Testimonials_Manager_Table_Column {
	
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
		
		if( is_admin() ){
		
			// add custom columns
			add_filter( 'manage_testimonial_posts_columns' , array( $this , 'etp_testimonial_columns') );
			
			// add content in custom columns
			add_action( 'manage_testimonial_posts_custom_column' , array( $this , 'etp_testimonial_column_output'), 10, 2 );
		}
	}
	
	/**
	 * Store new table columns to view in admin show all custom posts.
	 *
	 * @param    array    $columns
	 * @param    array    $columns
	 */
	public function etp_testimonial_columns( $columns ){

		$new_cols = array(
			'rating' => __('Rating'),
			'designation' => __('Designation'),
			'shortcode' => __('Shortcode'),
		);
		
		$columns = array_slice($columns, 0, 2, true) +
				   $new_cols +
				   array_slice($columns, 2, count($columns)-2, true);
		
		return $columns;
	}
	
	/**
	 * show colums informations
	 *
	 * @param    string    $col
	 * @param    int       $postid
	 */
	public function etp_testimonial_column_output( $col, $postid ){
		switch ( $col )
		 {
			case 'rating' :
				$ratings = get_post_meta( $postid , 'wtclientrate2', true ); 
				echo !empty($ratings) ? $ratings : '-';
				break;
			case 'designation' :
				$designation = get_post_meta( $postid , 'wtclientdesignation', true ); 
				echo !empty($designation) ? $designation : '-';
				break;
			case 'shortcode' :	
				$shortcodeinput = '<input type=\"text\" value="[wbr-single-testimonial id=\'%s\']" style="width:100%%" onfocus="this.select();" />';
				printf($shortcodeinput, $postid);
				break;

			default:
				echo "$col";
				break;
		}
	}
	
}