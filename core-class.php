<?php

/**
 * Caldera SMTP Mailer.
 *
 * @package   Caldera_Smtp_Mailer
 * @author    David <david@digilab.co.za>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2014 David
 */

/**
 * Plugin class.
 * @package Caldera_Smtp_Mailer
 * @author  David <david@digilab.co.za>
 */
class Caldera_Smtp_Mailer {

	/**
	 * @var      string
	 */
	protected $plugin_slug = 'caldera-smtp-mailer';
	/**
	 * @var      object
	 */
	protected static $instance = null;
	/**
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Load plugin hook settings
		add_action( 'init', array( $this, 'caldera_smtp_setup' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylescripts' ) );

	}

	/**
	 * Register the mailer hook to include custom priority
	 *
	 */
	public function caldera_smtp_setup(){
		$settings = get_option( '_caldera_smtp_mailer' );
		if( empty( $settings) ){
			return;
		}

		$priority = 10;
		if( !empty( $settings['advanced']['priority'] ) ){
			$priority = $settings['advanced']['priority'];
		}

		// hook into the phpmailer
		add_action( 'phpmailer_init', array( $this, 'caldera_smtp_mailer' ), $priority ); // issue it later to be safe.	

	}


	/**
	 * update the phpmailer object
	 *
	 */
	public function caldera_smtp_mailer($phpmailer){
		
		$settings = get_option( '_caldera_smtp_mailer' );
		if( empty( $settings) ){
			return;
		}

		$phpmailer->IsSMTP();     
		$phpmailer->Host = $settings['smtp']['host'];
		$phpmailer->Port = $settings['smtp']['port'];
		$phpmailer->Username = $settings['smtp']['username'];
		$phpmailer->Password = $settings['smtp']['password'];
		
		// Set auth
		if($settings['smtp']['auth'] != 'none'){
			$phpmailer->SMTPAuth = true;
			$phpmailer->SMTPSecure = $settings['smtp']['auth'];
		}
		// replace name if default only
		if(!empty($settings['extra']['from_name'])){
			if($phpmailer->FromName == 'WordPress'){
				$phpmailer->FromName = $settings['extra']['from_name'];
			}
		}
		// replace from email if default only
		if(!empty($settings['extra']['from_email'])){
			if(false !== strpos($phpmailer->From, 'wordpress') ){
				$phpmailer->From = $settings['extra']['from_email'];
			}
		}

	}	

	/**
	 * Return an instance of this class.
	 *
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide  ) {
				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::single_activate();
				}
				restore_current_blog();
			} else {
				self::single_activate();
			}
		} else {
			self::single_activate();
		}
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			if ( $network_wide ) {
				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::single_deactivate();
				}
				restore_current_blog();
			} else {
				self::single_deactivate();
			}
		} else {
			self::single_deactivate();
		}
	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 *
	 * @param	int	$blog_id ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {
		if ( 1 !== did_action( 'wpmu_new_blog' ) )
			return;

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 *
	 * @return	array|false	The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {
		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";
		return $wpdb->get_col( $sql );
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 */
	private static function single_activate() {
		// TODO: Define activation functionality here if needed
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 */
	private static function single_deactivate() {
		// TODO: Define deactivation functionality here needed
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain( $this->plugin_slug, FALSE, basename( CSMTP_PATH ) . '/languages');

	}
	
	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 *
	 * @return    null
	 */
	public function enqueue_admin_stylescripts() {

		$screen = get_current_screen();

		
		if( false !== strpos( $screen->base, 'caldera_smtp_mailer' ) ){

			wp_enqueue_style( 'caldera_smtp_mailer-core-style', CSMTP_URL . '/assets/css/styles.css' );
			wp_enqueue_script( 'caldera_smtp_mailer-wp-baldrick', CSMTP_URL . '/assets/js/wp-baldrick-full.js', array( 'jquery' ) , false, true );
			wp_enqueue_script( 'caldera_smtp_mailer-core-script', CSMTP_URL . '/assets/js/scripts.js', array( 'caldera_smtp_mailer-wp-baldrick' ) , false );
		
		}


	}


}















