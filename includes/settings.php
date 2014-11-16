<?php


class Settings_Caldera_Smtp_Mailer extends Caldera_Smtp_Mailer{


	/**
	 * Start up
	 */
	public function __construct(){

		// add admin page
		add_action( 'admin_menu', array( $this, 'add_settings_pages' ), 25 );
		// save config
		add_action( 'wp_ajax_csmtp_save_config', array( $this, 'save_config') );
		// send test mail
		add_action( 'wp_ajax_csmtp_send_test', array( $this, 'send_test_mail') );
		// hook manual saving
		add_action( 'init', array( $this, 'save_config') );

	}

	
	/**
	 * sends a test email
	 */
	public function send_test_mail(){
		
		$user = wp_get_current_user();

		if( $result = wp_mail( array($user->data->user_email), __( 'Caldera SMTP Test Mail', 'caldera-smtp-mailer' ), __( 'You have successfully configured Caldera SMTP.', 'caldera-smtp-mailer' ) ) ){
			echo '<div class="updated"><p><strong>' . __( 'Test mail has been sent to:', 'caldera-smtp-mailer' ) . ' ' . $user->data->user_email . '</strong></p></div>';
		}else{
			global $phpmailer;
			echo '<div class="error"><p><strong>' . __( 'ERROR', 'caldera-smtp-mailer' ) . '</strong>: ' . $phpmailer->ErrorInfo . '</p></div>';
		}

		die;

	}

	/**
	 * saves a config
	 */
	public function save_config(){
		
		if( empty( $_POST['caldera-smtp-setup'] ) || !wp_verify_nonce( $_POST['caldera-smtp-setup'], 'caldera-smtp-mailer' ) ){
			if( empty( $_POST['config'] ) ){
				return;
			}
		}

		if( !empty( $_POST['caldera-smtp-setup'] ) && empty( $_POST['config'] ) ){
			$config = stripslashes_deep( $_POST );
			update_option( '_caldera_smtp_mailer', $config );
			wp_redirect( '?page=caldera_smtp_mailer&updated=true' );
			exit;
		}

		if( !empty( $_POST['config'] ) ){

			$config = json_decode( stripslashes_deep( $_POST['config'] ), true );
			if(	wp_verify_nonce( $config['caldera-smtp-setup'], 'caldera-smtp-mailer' ) ){
				update_option( '_caldera_smtp_mailer', $config );
				wp_send_json_success( $config );
			}else{
				wp_send_json_error( $config );
			}

		}

	}

	

	/**
	 * Add options page
	 */
	public function add_settings_pages(){
		// This page will be under "Settings"
		
	
			$this->plugin_screen_hook_suffix['caldera_smtp_mailer'] =  add_submenu_page( 'options-general.php', __( 'Caldera SMTP Mailer', $this->plugin_slug ), __( 'Caldera SMTP', $this->plugin_slug ), 'manage_options', 'caldera_smtp_mailer', array( $this, 'create_admin_page' ) );
			add_action( 'admin_print_styles-' . $this->plugin_screen_hook_suffix['caldera_smtp_mailer'], array( $this, 'enqueue_admin_stylescripts' ) );


	}


	/**
	 * Options page callback
	 */
	public function create_admin_page(){
		// Set class property        
		$screen = get_current_screen();
		$base = array_search($screen->id, $this->plugin_screen_hook_suffix);
			
		// include main template
		include CSMTP_PATH .'includes/edit.php';

		// php based script include
		if( file_exists( CSMTP_PATH .'assets/js/inline-scripts.php' ) ){
			echo "<script type=\"text/javascript\">\r\n";
				include CSMTP_PATH .'assets/js/inline-scripts.php';
			echo "</script>\r\n";
		}

	}


}

if( is_admin() )
	$settings_caldera_smtp_mailer = new Settings_Caldera_Smtp_Mailer();
