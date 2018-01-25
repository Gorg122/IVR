<?php 
/**
 * The file responsible for starting the WordPress Testimonial plugin
 *
 * The WordPress Testimonial is a plugin that displays the custom post type testimonials
 * This particular file is responsible for including the necessary dependencies and
 * starting the plugin.
 *
 * @package wp-easy-testimonial
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Testimonial Plugin - Webriti
 * Description:       WordPress Testimonial Plugin is the simplest plugin for displaying testimonials to your WordPress blog or company site.
 * Version:           1.0.1
 * Author:            priyanshu.mittal , a.ankit
 * Author URI:        https://webriti.com/
 * Text Domain:       wp-easy-testimonial
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:       /languages
 */

/**
 * Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;


/* 
 * defining variables
 *
 */
 
if ( ! defined( 'etp_testimonialpluginfile' ) ) {
	define( 'etp_testimonialpluginfile', __FILE__ );
}

if ( ! defined( 'etp_testimonialdir' ) ) {
	define("etp_testimonialdir", plugin_dir_path( __FILE__ ));
}

if ( ! defined( 'etp_testimonialurl' ) ) {
	define("etp_testimonialurl", plugin_dir_url( __FILE__ ));
}


/**
 * Include the core class responsible for loading all necessary components of the plugin.
 *
 */
require_once etp_testimonialdir . 'includes/class-etp-testimonials-manager.php';


/**
 * Instantiates the WordPress Testimonial Manager class and then
 * calls its run method officially starting up the plugin.
 */
function etp_testimonials_manager(){
	$webriti_testimonials = new ETP_Testimonials_Manager();
	$webriti_testimonials->etp_run();
}


/**
 * Call the above function to begin execution of the plugin.
 *
 */
etp_testimonials_manager();