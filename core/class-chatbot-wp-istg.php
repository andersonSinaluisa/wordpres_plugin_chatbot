<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Chatbot_Wp_Istg' ) ) :

	/**
	 * Main Chatbot_Wp_Istg Class.
	 *
	 * @package		CHATBOTWP
	 * @subpackage	Classes/Chatbot_Wp_Istg
	 * @since		1.0.0
	 * @author		Anderson Sinaluisa
	 */
	final class Chatbot_Wp_Istg {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Chatbot_Wp_Istg
		 */
		private static $instance;

		/**
		 * CHATBOTWP helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Chatbot_Wp_Istg_Helpers
		 */
		public $helpers;

		/**
		 * CHATBOTWP settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Chatbot_Wp_Istg_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'chatbot-wp-istg' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'chatbot-wp-istg' ), '1.0.0' );
		}

		/**
		 * Main Chatbot_Wp_Istg Instance.
		 *
		 * Insures that only one instance of Chatbot_Wp_Istg exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Chatbot_Wp_Istg	The one true Chatbot_Wp_Istg
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Chatbot_Wp_Istg ) ) {
				self::$instance					= new Chatbot_Wp_Istg;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Chatbot_Wp_Istg_Helpers();
				self::$instance->settings		= new Chatbot_Wp_Istg_Settings();
				
				//Fire the plugin logic
				new Chatbot_Wp_Istg_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require CHATBOTWP_PLUGIN_DIR . 'core/includes/classes/class-chatbot-wp-istg-helpers.php';
			require CHATBOTWP_PLUGIN_DIR . 'core/includes/classes/class-chatbot-wp-istg-settings.php';
			require CHATBOTWP_PLUGIN_DIR . 'core/includes/classes/models/class-chatbot-wp-istg-question.php';
			require CHATBOTWP_PLUGIN_DIR . 'core/includes/classes/rest/class-chatbot-wp-chat.php';
			require CHATBOTWP_PLUGIN_DIR . 'core/includes/classes/class-chatbot-wp-istg-run.php';


		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
			add_action( 'plugins_loaded', array( self::$instance, 'migrate' ) );

			add_action('deactivate_plugin', [self::$instance, 'rollback']);


		}


		public static function migrate(){
			error_log('migrate load');
			Chatbot_Wp_Istg_Question::setup();
		}

		public static function rollback(){
			error_log('rollback load');
			Chatbot_Wp_Istg_Question::drop();
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'chatbot-wp-istg', FALSE, dirname( plugin_basename( CHATBOTWP_PLUGIN_FILE ) ) . '/languages/' );
		}


	

	}

endif; // End if class_exists check.