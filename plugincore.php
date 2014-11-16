<?php
/**
 * @package   Caldera_Smtp_Mailer
 * @author    David <david@digilab.co.za>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 David
 *
 * @wordpress-plugin
 * Plugin Name: Caldera SMTP Mailer
 * Plugin URI:  
 * Description: Configure the WordPress Mailer to use SMTP server like SendGrid, MandrillApp or your own.
 * Version:     1.0.0
 * Author:      David Cramer
 * Author URI:  http://cramer.co.za
 * Text Domain: caldera-smtp-mailer
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('CSMTP_PATH',  plugin_dir_path( __FILE__ ) );
define('CSMTP_URL',  plugin_dir_url( __FILE__ ) );
define('CSMTP_VER',  '1.0.0' );



// load internals
require_once( CSMTP_PATH . 'core-class.php' );
require_once( CSMTP_PATH . 'includes/settings.php' );


// Register hooks that are fired when the plugin is activated or deactivated.
// When the plugin is deleted, the uninstall.php file is loaded.
register_activation_hook( __FILE__, array( 'Caldera_Smtp_Mailer', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Caldera_Smtp_Mailer', 'deactivate' ) );

// Load instance
add_action( 'plugins_loaded', array( 'Caldera_Smtp_Mailer', 'get_instance' ) );