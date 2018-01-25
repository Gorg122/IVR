<?php 

/**
 * The WordPress Testimonial Manager Admin defines all functionality for the dashboard
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

class ETP_Testimonials_Manager_Admin {
	
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
	 * Enqueues custom scripts and styles
	 */
	public function etp_enqueue_styles() {
		
		// css
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style(
			'star-rating',
			etp_testimonialurl . 'assets/css/star-rating.css',
			array(),
			$this->version,
			FALSE
		);
		wp_enqueue_style(
			'admin-custom',
			etp_testimonialurl . 'assets/css/admin-custom.css',
			array(),
			$this->version,
			FALSE
		);
		
		// scripts
		wp_enqueue_script(
			'admin-custom',
			etp_testimonialurl . 'assets/js/admin-custom.js',
			array( 'wp-color-picker' ),
			$this->version,
			true
		);
		
		wp_enqueue_script(
			'star-rating',
			etp_testimonialurl . 'assets/js/star-rating.js',
			array(),
			$this->version,
			false
		);

	}
	
	/**
	 * Enqueues custom scripts and styles
	 */
	public function etp_setupposttype(){
		global $etp_options;
		
		$showinsearch = ( isset($etp_options['wtshow_search']) && $etp_options['wtshow_search'] == true ? 1 : 0 );
		
		$labels = array(
			'name' => _x('Testimonial', 'wp-easy-testimonial'),
			'singular_name' => _x('Testimonial Item', 'wp-easy-testimonial'),
			'add_new' => _x('Add New', 'wp-easy-testimonial'),
			'add_new_item' => __('Add New Testimonial Item'),
			'edit_item' => __('Edit Testimonial Item'),
			'new_item' => __('New Testimonial Item'),
			'view_item' => __('View Testimonial Item'),
			'search_items' => __('Search Testimonial Items'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
		
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 20,
			'menu_icon'          => 'dashicons-format-quote',
			'exclude_from_search' => $showinsearch,
			'supports' => array('title','editor','excerpt','author','thumbnail','comments')
		); 	
		register_post_type( 'testimonial', $args );
		
		/** Categories */
		$labels = array(
			'name'              => _x( 'Categories', 'wp-easy-testimonial' ),
			'singular_name'     => _x( 'Category', 'wp-easy-testimonial' ),
			'search_items'      => __( 'Search Categories' ),
			'all_items'         => __( 'All Categories' ),
			'parent_item'       => __( 'Parent Category' ),
			'parent_item_colon' => __( 'Parent Category:' ),
			'edit_item'         => __( 'Edit Category' ),
			'update_item'       => __( 'Update Category' ),
			'add_new_item'      => __( 'Add New Category' ),
			'new_item_name'     => __( 'New Category Name' ),
			'menu_name'         => __( 'Categories' ),
		);
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'categories' ),
		);
		register_taxonomy( 'testimonial_categories', array( 'testimonial' ), $args );
		
	}
	
}