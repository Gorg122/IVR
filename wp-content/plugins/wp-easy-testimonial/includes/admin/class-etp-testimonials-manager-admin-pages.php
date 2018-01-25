<?php 
	
/**
 * The WordPress Testimonial Manager Admin Pages defines all functionality for the dashboard
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

class ETP_Testimonials_Manager_Admin_Pages {
	
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
	 * Add a function for admin notice functionality of this plugin.
	 *
	 */
	public function etp_admin_messages(){
		
		$notices = array(
			'updated' => array(),
			'error'   => array(),
		);
		
		if ( isset( $_GET['settings-updated'] ) ) {
			$notices['updated']["success"] = "Testimonials settings updated successfully.";
		}
		
		if( count( $notices['updated'] ) > 0 ) {
			foreach( $notices['updated'] as $notice => $message ) {
				add_settings_error( 'wt-notices', $notice, $message, 'updated' );
			}
		}

		if ( count( $notices['error'] ) > 0 ) {
			foreach( $notices['error'] as $notice => $message ) {
				add_settings_error( 'wt-notices', $notice, $message, 'error' );
			}
		}

		settings_errors( 'wt-notices' );
	}
	
	/**
	 * Add a function for admin submenu in admin dashboard.
	 *
	 */
	public function etp_add_options_link(){
		// admin sub menu
		$menu = add_menu_page(
			__('Testimonial', 'wp-easy-testimonial'), 
			__('Testimonial', 'wp-easy-testimonial'), 
			'administrator', 
			'etp-settings',
			array( $this ,'etp_options_page'),  
			'dashicons-admin-generic'
			);
		
		$slider = add_submenu_page( 
					'etp-settings', 
					__( 'Slider Settings', 'wp-easy-testimonial' ),
					__( 'Slider Settings', 'wp-easy-testimonial' ), 
					'administrator', 
					'admin.php?page=etp-settings&tab=slider'
					);
					
		$theme = add_submenu_page( 
					'etp-settings', 
					__( 'Theme Settings', 'wp-easy-testimonial' ),
					__( 'Theme Settings', 'wp-easy-testimonial' ), 
					'administrator', 
					'admin.php?page=etp-settings&tab=theme'
					);
		$shortcodes = add_submenu_page( 
					'etp-settings', 
					__( 'Shortcodes', 'wp-easy-testimonial' ),
					__( 'Shortcodes', 'wp-easy-testimonial' ), 
					'administrator', 
					'wt-shortcode',
					array( $this ,'etp_options_page_shortcodes_callback')
					);
		add_action( 'admin_print_styles-' . $shortcodes, 
			array( $this, 'etp_options_page_shortcodes_scripts' ) 
		);
	}
	
	/**
	 * Add a function for display pugin dashboard settings.
	 *
	 */
	public function etp_options_page(){
		
		ob_start();
		
		$settings_tabs = etp_get_settings_tabs();
		$settings_tabs = empty($settings_tabs) ? array() : $settings_tabs;
		$active_tab    = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general';
		$active_tab    = array_key_exists( $active_tab, $settings_tabs ) ? $active_tab : 'general';
		
		$sections      = etp_get_settings_tab_sections( $active_tab );
		$key           = 'main';
		
		if ( is_array( $sections ) ) {
			$key = key( $sections );
		}
		
		$registered_sections = etp_get_settings_tab_sections( $active_tab );
		$section             = isset( $_GET['section'] ) && ! empty( $registered_sections ) && array_key_exists( $_GET['section'], $registered_sections ) ? sanitize_text_field( $_GET['section'] ) : $key;
		
		do_action('etp_before_admin_content');
		?>
		<div class="wrap wt-wrapper">
			<h2><?php _e('WordPress Testimonial Plugin Settings','wp-easy-testimonial') ?></h2>
			<h2 class="nav-tab-wrapper">
				<?php do_action('etp_setting_tabs_filter'); ?>
			</h2>
			
			<?php do_action('etp_settings_sections_filter'); ?>
			
			<div id="tab_container">
				<form method="post" action="options.php">
				<?php 
					settings_fields( 'etp_settings' );
					
					do_settings_sections( 'etp_settings_' . $active_tab . '_' . $section );
					
					submit_button();
				?>
				</form>
			</div>
		</div>
		
		<?php if( $active_tab == 'theme'): ?>
		<?php 
		global $etp_options;
		$theme = isset( $etp_options['wtthemes'] ) ? $etp_options['wtthemes'] : 'testimonial-default'; 
		?>
		<div class="wrap wt-wrapper">
			<h2><?php _e('Theme Preview','wp-easy-testimonial') ?></h2>
			<p><?php _e('Preview all the themes and select one you like the most.','wp-easy-testimonial') ?></p>
			<div class="wttheme_preview">
				<img src="<?php echo etp_testimonialurl . 'images/'. $theme .'.png'; ?>" />
			</div>
		</div>
		<?php endif; ?>
		
		<script>
			(function( $ ) {
 
			// Add Color Picker to all inputs that have 'color-field' class
			$(function() {
				$('.wt-color-picker').wpColorPicker();
			});
			
			$(document).ready( function (){
				$( "select" ).change(function () {
					var value = "";
					$( "select option:selected" ).each(function() {
					  value = $( this ).val();
					});
					var src = "<?php echo etp_testimonialurl; ?>images/" + value + ".png";
					$(".wttheme_preview img").attr("src", src );
				});
			});
			 
		})( jQuery );
		</script>
		<?php
		do_action('etp_after_admin_content');
		echo ob_get_clean();
	}
	
	/**
	 * Admin shortcodes option page callback
	 *
	 */
	public function etp_options_page_shortcodes_callback(){
		require_once etp_testimonialdir . 'includes/admin/pages/page-shortcodes.php';
	}
	
	/**
	 * Admin shortcodes option page scripts callback function
	 *
	 */
	public function etp_options_page_shortcodes_scripts(){
	}
	
}