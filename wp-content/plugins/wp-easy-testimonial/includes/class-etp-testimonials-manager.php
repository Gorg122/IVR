<?php 
/**
 * The WordPress Testimonial Manager is the core plugin responsible for including and
 * instantiating all of the code that composes the plugin
 *
 * @package wp-easy-testimonial
 * @since    0.1
 */
 
/**
 * Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Testimonials_Manager{
	
	/**
	 * The hooks and callbacks
	 *
	 * @access protected
	 * @var    ETP_Testimonials_Manager_Loader   $loader
	 */
	protected $loader;
	
	/**
	 * Represents the slug of hte plugin that can be used throughout the plugin
	 *
	 * @access protected
	 * @var    string   $plugin_slug
	 */
	protected $plugin_slug;
	
	/**
	 * Maintains the current version of the plugin
	 *
	 * @access protected
	 * @var    string   $version
	 */
	protected $version;
	
	/**
	 * loading all necessary dependencies and defining the hooks throughout the
	 * plugin.
	 */
	public function __construct() {

		$this->plugin_slug = 'wp-easy-testimonial';
		$this->version = '0.1';
		$this->etp_load_dependencies();
		$this->etp_define_admin_hooks();
		$this->etp_define_public_hooks();

	}
	
	/**
	 * Imports the WordPress Testimonial administration classes, and the WordPress Testimonial Loader.
	 *
	 * @access    private
	 */
	private function etp_load_dependencies() {
		
		global $etp_options;
		
		require_once etp_testimonialdir . 'includes/admin/admin_functions.php';
		require_once etp_testimonialdir . 'includes/admin/tabs/tabs.php';
		require_once etp_testimonialdir . 'includes/admin/sections/sections.php';
		require_once etp_testimonialdir . 'includes/admin/settings/settings.php';
		require_once etp_testimonialdir . 'includes/admin/class-etp-testimonials-manager-admin.php';
		require_once etp_testimonialdir . 'includes/admin/class-etp-testimonials-manager-admin-pages.php';
		require_once etp_testimonialdir . 'includes/admin/class-etp-testimonials-manager-metabox.php';
		require_once etp_testimonialdir . 'includes/admin/class-etp-testimonials-manager-column.php';
		$etp_options = etp_get_settings();
		
		require_once etp_testimonialdir . 'includes/class-etp-testimonials-manager-loader.php';
		$this->loader = new ETP_Testimonials_Manager_Loader();
		require_once etp_testimonialdir . 'public/class-etp-testimonials-manager-public.php';
		require_once etp_testimonialdir . 'includes/template-tags.php';
		require_once etp_testimonialdir . 'includes/class-etp-testimonials-manager-actions.php';
		require_once etp_testimonialdir . 'includes/class-item.php';
		require_once etp_testimonialdir . 'includes/class-shortcode-count.php';
		require_once etp_testimonialdir . 'includes/class-shortcode-single.php';
		require_once etp_testimonialdir . 'includes/class-shortcode-list.php';
		require_once etp_testimonialdir . 'includes/class-shortcode-random.php';
		require_once etp_testimonialdir . 'includes/class-shortcode-grid.php';
		require_once etp_testimonialdir . 'includes/class-shortcode-slider.php';
	}
	
	/**
	 * Defines the hooks and callback functions that are used for setting up the plugin stylesheets
	 * and the plugin's custom post type and metabox.
	 *
	 * @access    private
	 */
	private function etp_define_admin_hooks() {

		$admin = new ETP_Testimonials_Manager_Admin( $this->etp_get_version() );
		$this->loader->etp_action( 'admin_enqueue_scripts', $admin, 'etp_enqueue_styles' );
		$this->loader->etp_action( 'init', $admin, 'etp_setupposttype' );
		$adminpages = new ETP_Testimonials_Manager_Admin_Pages( $this->etp_get_version() );
		$this->loader->etp_action( 'admin_menu', $adminpages, 'etp_add_options_link' );
		$this->loader->etp_action( 'admin_notices', $adminpages, 'etp_admin_messages' );
		$metabox = new ETP_Testimonials_Manager_Metabox( $this->etp_get_version() );
		$this->loader->etp_action( 'add_meta_boxes', $metabox, 'etp_testimonial_meta_box' );
		$this->loader->etp_action( 'save_post', $metabox, 'etp_testimonial_meta_box_save' );
		$tablecolumn = new ETP_Testimonials_Manager_Table_Column( $this->etp_get_version() );
		$this->loader->etp_action( 'plugins_loaded', $this, 'etp_loadlanguage' );

	}
	
	
	/**
	 * Defines the hooks and callback functions that are used for rendering information on the front
	 * end of the site.
	 *
	 * @access    private
	 */
	private function etp_define_public_hooks() {

		$public = new ETP_Testimonials_Manager_Public( $this->etp_get_version() );
		$this->loader->etp_filter( 'wp_head', $public, 'etp_customcss' );
		$this->loader->etp_filter( 'get_the_excerpt', $public, 'etp_excerpt_content', 9999999 );
		$this->loader->etp_filter( 'excerpt_more', $public, 'etp_continue_reading' , 9999999 );
		$this->loader->etp_filter( 'excerpt_length', $public, 'etp_excerpt_length' , 9999999 );
		$this->loader->etp_filter( 'post_class', $public, 'etp_addpostclass' );
		$this->loader->etp_filter( 'wtbloginfo', $public, 'etp_bloginfo_callback' );
		$this->loader->etp_action( 'wp_loaded', $public, 'etp_registerscripts', 999 );
		$this->loader->etp_action( 'wp_enqueue_scripts', $public, 'etp_enqueuescripts', 999 );
		
		$actions = new ETP_Testimonials_Manager_Actions( $this->etp_get_version() );
		$this->loader->etp_action( 'etp_before_testimonial', $actions, 'etp_before_testimonial_callback' );
		$this->loader->etp_action( 'etp_after_testimonial', $actions, 'etp_after_testimonial_callback' );
		$count  = new ETP_Shortcode_Count  ( $this->etp_get_version() );
		$single = new ETP_Shortcode_Single ( $this->etp_get_version() );
		$list = new ETP_Shortcode_List ( $this->etp_get_version() );
		$random = new ETP_Shortcode_Random ( $this->etp_get_version() );
		$grid = new ETP_Shortcode_Grid ( $this->etp_get_version() );
		$slider = new ETP_Shortcode_Slider ( $this->etp_get_version() );
	}
	
	
	/**
	 * Defines the the text domain name with text wp-easy-testimonial for the languages
	 * translations.
	 *
	 */
	public function etp_loadlanguage() {
		load_plugin_textdomain( $this->plugin_slug , FALSE, dirname( plugin_basename( __FILE__ ) ) .'/languages/' );
    }
	
	
	/**
	 * Executes the plugin by calling the etp_run method of the plugin
	 */
	public function etp_run() {
		$this->loader->etp_run();
	}
	
	/**
	 * Returns the current version of the plugin
	 *
	 * @return    string    $this->version
	 */
	public function etp_get_version() {
		return $this->version;
	}
	
}