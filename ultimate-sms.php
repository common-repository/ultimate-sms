<?php
/**
 * Plugin Name: Ultimate SMS
 * Description: Wordpress SMS Plugin - Send SMS Messages & Notifications to users.
 * Version: 1.0.3
 * Author: wpsmspro.com
 * Author URI: https://wpsmspro.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

define( 'SMS_WP_VERSION', '1.0.3' );
define( 'SMS_WP_OPTION', 'smswp_option' );
define( 'SMS_WP_SETTING', 'smswp_options' );
define( 'SMS_WP_OPTION_PAGE', 'smswordpress' );
define( 'SMSWP_LOGS_OPTION', 'smswp_logs' );
define( 'SMS_WP_NOTIFICATION_OPTION', 'smswp_notification_option' );
define( 'SMS_WP_NOTIFICATION_SETTING', 'smswp_notification-options' );
define( 'SMS_WP_NEWSLETTER_OPTION', 'smswp_newsletter_option' );
define( 'SMS_WP_NEWSLETTER_SETTING', 'twilio-newsletter-options' );

if( !defined( 'SMSWP_TD' ) ) {
	define( 'SMSWP_TD', 'smswp-td' );
}

if( !defined( 'SMSWP_PATH' ) ) {
	define( 'SMSWP_PATH', plugin_dir_path( __FILE__ ) );
}

//Include Gateways:: Twilio
require_once( SMSWP_PATH . 'gateways/twilio/src/Twilio/autoload.php' );
require_once( SMSWP_PATH . 'helpers.php' );
require_once( SMSWP_PATH . 'url-shorten.php' );
require_once( SMSWP_PATH . 'inc/actions.php');

//Include Admin panel
require_once (SMSWP_PATH.'admin/classes/setup.class.php' );
require_once (SMSWP_PATH .'admin/options/admin-options.php' );

//Include Newsletter feature
//require_once( SMSWP_PATH . 'inc/features.php' );


//Include Admin panel
class SMSWP_Core {
	private static $instance;


	
// init
	public function init() {
		$options = get_option('smswp_option');

		load_plugin_textdomain( SMSWP_TD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		

		/** User Profile Settings **/
		if( isset( $options['mobile_field'] ) && $options['mobile_field'] ) {
			add_filter( 'user_contactmethods', 'smswp_add_contact_item', 10 );
		}
	}


	/**
	 * Register/Whitelist our settings on the settings page, allow extensions and other plugins to hook into this
	 * @return void
	 * @access public
	 */
	public function register_settings() {
		
		register_setting( SMS_WP_NOTIFICATION_SETTING, SMS_WP_NOTIFICATION_OPTION, 'smswp_sanitize_option' );
		register_setting( SMS_WP_NEWSLETTER_SETTING, SMS_WP_NEWSLETTER_OPTION, 'smswp_sanitize_option' );
		do_action( 'smswp_register_additional_settings' );
	}

	/**
	 * Original get_options unifier
	 * @return array List of options
	 * @access public
	 */
	public function get_options() {
		return smswp_get_options();
	}

	/**
	 * Get the singleton instance of our plugin
	 * @return class The Instance
	 * @access public
	 */
	public static function get_instance() {
		if ( !self::$instance ) {
			self::$instance = new SMSWP_Core();
		}

		return self::$instance;
	}

	/**
	 * Adds the options to the options table
	 * @return void
	 * @access public
	 */
	public static function plugin_activated() {
		add_option( SMS_WP_OPTION, smswp_get_defaults() );
		add_option( SMSWP_LOGS_OPTION, '' );
		add_option( SMS_WP_NOTIFICATION_OPTION, smswp_get_notification_defaults() );
		add_option( SMS_WP_NEWSLETTER_OPTION, smswp_get_newsletter_defaults() );
	}

	/**
	 * Deletes the options to the options table
	 * @return void
	 * @access public
	 */
	public static function plugin_uninstalled() {
		delete_option( SMS_WP_OPTION );
		delete_option( SMSWP_LOGS_OPTION );
		delete_option( SMS_WP_NOTIFICATION_OPTION );
		delete_option( SMS_WP_NEWSLETTER_OPTION );
	}

}

$smswp_instance = SMSWP_Core::get_instance();
add_action( 'plugins_loaded', array( $smswp_instance, 'init' ) );
register_activation_hook( __FILE__, array( 'SMSWP_Core', 'plugin_activated' ) );

//SMS WP Hooks	
require_once( SMSWP_PATH . 'hooks.php' );