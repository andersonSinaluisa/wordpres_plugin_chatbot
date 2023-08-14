<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Chatbot_Wp_Istg_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		CHATBOTWP
 * @subpackage	Classes/Chatbot_Wp_Istg_Run
 * @author		Anderson Sinaluisa
 * @since		1.0.0
 */
class Chatbot_Wp_Istg_Run{

	/**
	 * Our Chatbot_Wp_Istg_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
		$this->register_api();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_backend_scripts_and_styles' ), 20 );
		add_action('wp_enqueue_scripts', array( $this, 'enqueue_ajax_script'));

	}

	private function register_api(){
		new Chatbot_Wp_Chat();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	 * Enqueue the backend related scripts and styles for this plugin.
	 * All of the added scripts andstyles will be available on every page within the backend.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_backend_scripts_and_styles() {

		wp_enqueue_style( 'chatbotwp-backend-styles', CHATBOTWP_PLUGIN_URL . 'core/includes/assets/css/backend-styles.css', array(), CHATBOTWP_VERSION, 'all' );
		//set image
		$chatbotwp_icon = CHATBOTWP_PLUGIN_URL . 'core/includes/assets/img/logo.png';
		
		wp_localize_script( 'chatbotwp-backend-scripts', 'chatbotwp', array(
			'plugin_name'   	=> __( CHATBOTWP_NAME, 'chatbot-wp-istg' ),
			'icon_url'		=> $chatbotwp_icon,
		));
	}

	public function enqueue_ajax_script() {

		wp_enqueue_script( 'chatbotwp-home-scripts', CHATBOTWP_PLUGIN_URL . 'core/includes/assets/js/home-scripts.js', array('jquery'), CHATBOTWP_VERSION, true );

		wp_enqueue_script( 'chatbotwp-backend-scripts', CHATBOTWP_PLUGIN_URL . 'core/includes/assets/js/backend-scripts.js', array('jquery'), CHATBOTWP_VERSION, true );
		wp_localize_script('chatbotwp-backend-scripts', 'myAjax', array('ajax_url' => admin_url('admin-ajax.php')));

	}
	
	
	

}
