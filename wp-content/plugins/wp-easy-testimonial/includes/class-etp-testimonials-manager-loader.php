<?php 
/**
 * The WordPress Testimonial Manager Loader is a class that is responsible for
 * coordinating all actions and filters used throughout the plugin
 * 
 * This class maintains two internal collections - one for actions, one for
 * hooks - each of which are coordinated through external classes that
 * register the various hooks through this class.
 *
 * @package wp-easy-testimonial
 * @since    0.1
 */
 
/**
 * Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;

class ETP_Testimonials_Manager_Loader{
	
	/**
	 * A reference to the collection of actions used throughout the plugin.
	 *
	 * @access protected
	 * @var    array    $actions
	 */
	protected $actions;
	
	/**
	 * A reference to the collection of filters used throughout the plugin.
	 *
	 * @access protected
	 * @var    array    $actions
	 */
	protected $filters;
	
	/**
	 * Instantiates the plugin by setting up the data structures that will
	 * be used to maintain the actions and the filters.
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}
	
	/**
	 * Registers the actions with WordPress and the respective objects and
	 * their methods.
	 *
	 * @param  string    $hook  
	 * @param  object    $component
	 * @param  string    $callback
	 */
	public function etp_action( $hook, $component, $callback, $priority = 10 ) {
		$this->actions = $this->etp_create_hooks( $this->actions, $hook, $component, $callback, $priority );
	}

	/**
	 * Registers the filters with WordPress and the respective objects and
	 * their methods.
	 *
	 * @param  string    $hook
	 * @param  object    $component
	 * @param  string    $callback
	 */
	public function etp_filter( $hook, $component, $callback, $priority = 10 ) {
		$this->filters = $this->etp_create_hooks( $this->filters, $hook, $component, $callback, $priority );
	}

	/**
	 * Registers the filters with WordPress and the respective objects and
	 * their methods.
	 *
	 * @access private
	 *
	 * @param  array     $hooks
	 * @param  string    $hook
	 * @param  object    $component
	 * @param  string    $callback
	 *
	 * @return array
	 */
	private function etp_create_hooks( $hooks, $hook, $component, $callback, $priority ) {

		$hooks[] = array(
			'hook'           => $hook,
			'component'      => $component,
			'callback'       => $callback,
			'priority'       => $priority,
		);

		return $hooks;

	}

	/**
	 * Registers all of the defined filters and actions with WordPress.
	 */
	public function etp_run() {

		 foreach ( $this->filters as $hook ) {
			 add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ) , $hook['priority'] );
		 }

		 foreach ( $this->actions as $hook ) {
			 add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ) , $hook['priority'] );
		 }

	}
	
}