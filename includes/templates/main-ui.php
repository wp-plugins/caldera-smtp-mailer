<div class="caldera-smtp-mailer-main-header">
		<h2><?php _e( 'Caldera SMTP Mailer', 'caldera-smtp-mailer' ); ?> <span class="caldera-smtp-mailer-version"><?php echo CSMTP_VER; ?></span></h2>
	<ul class="caldera-smtp-mailer-header-tabs caldera-smtp-mailer-nav-tabs">
		<li class="{{#is _current_tab value="#caldera-smtp-mailer-panel-smtp"}}active {{/is}}caldera-smtp-mailer-nav-tab"><a href="#caldera-smtp-mailer-panel-smtp"><?php _e('SMTP', 'caldera-smtp-mailer') ; ?></a></li>
		<li class="{{#is _current_tab value="#caldera-smtp-mailer-panel-extra"}}active {{/is}}caldera-smtp-mailer-nav-tab"><a href="#caldera-smtp-mailer-panel-extra"><?php _e('Extras', 'caldera-smtp-mailer') ; ?></a></li>
		<li class="{{#is _current_tab value="#caldera-smtp-mailer-panel-advanced"}}active {{/is}}caldera-smtp-mailer-nav-tab"><a href="#caldera-smtp-mailer-panel-advanced"><?php _e('Advanced', 'caldera-smtp-mailer') ; ?></a></li>
		<li id="caldera-smtp-mailer-save-indicator"><span style="float: none; margin: 16px 0px -5px 10px;" class="spinner"></span></li>
	</ul>
	<span class="wp-baldrick" id="caldera-smtp-mailer-field-sync" data-event="refresh" data-target="#caldera-smtp-mailer-main-canvas" data-callback="csmtp_canvas_init" data-type="json" data-request="#caldera-smtp-mailer-live-config" data-template="#main-ui-template"></span>
</div>
<div class="caldera-smtp-mailer-sub-header">
	<ul class="caldera-smtp-mailer-sub-tabs caldera-smtp-mailer-nav-tabs">
		<li class="{{#is _current_tab value="#caldera-smtp-mailer-panel-test_send"}}active {{/is}}caldera-smtp-mailer-nav-tab"><a href="#caldera-smtp-mailer-panel-test_send"><?php _e('Send Test', 'caldera-smtp-mailer') ; ?></a></li>
	</ul>
</div>

<form id="caldera-smtp-mailer-main-form" action="?page=caldera_smtp_mailer" method="POST">
	<input type="hidden" value="caldera_smtp_mailer" name="id" id="caldera_smtp_mailer-id">
	<input type="hidden" value="{{_current_tab}}" name="_current_tab" id="caldera-smtp-mailer-active-tab">
	<?php wp_nonce_field( 'caldera-smtp-mailer', 'caldera-smtp-setup' ); ?>
		<div id="caldera-smtp-mailer-panel-smtp" class="caldera-smtp-mailer-editor-panel" {{#is _current_tab value="#caldera-smtp-mailer-panel-smtp"}}{{else}} style="display:none;" {{/is}}>		
		<h4><?php _e('Server Settings', 'caldera-smtp-mailer') ; ?> <small class="description"><?php _e('SMTP', 'caldera-smtp-mailer') ; ?></small></h4>
		<?php
		// pull in the general settings template
		include CSMTP_PATH . 'includes/templates/smtp-panel.php';
		?>
	</div>
	<div id="caldera-smtp-mailer-panel-extra" class="caldera-smtp-mailer-editor-panel" {{#is _current_tab value="#caldera-smtp-mailer-panel-extra"}}{{else}} style="display:none;" {{/is}}>		
		<h4><?php _e('Additional Settings', 'caldera-smtp-mailer') ; ?> <small class="description"><?php _e('Extras', 'caldera-smtp-mailer') ; ?></small></h4>
		<?php
		// pull in the additional settings template
		include CSMTP_PATH . 'includes/templates/extra-panel.php';
		?>
	</div>
	<div id="caldera-smtp-mailer-panel-advanced" class="caldera-smtp-mailer-editor-panel" {{#is _current_tab value="#caldera-smtp-mailer-panel-advanced"}}{{else}} style="display:none;" {{/is}}>		
		<h4><?php _e('Advanced Settings', 'caldera-smtp-mailer') ; ?> <small class="description"><?php _e('Extras', 'caldera-smtp-mailer') ; ?></small></h4>
		<?php
		// pull in the advanced settings template
		include CSMTP_PATH . 'includes/templates/advanced-panel.php';
		?>
	</div>
	<div id="caldera-smtp-mailer-panel-test_send" class="caldera-smtp-mailer-editor-panel" {{#is _current_tab value="#caldera-smtp-mailer-panel-test_send"}}{{else}} style="display:none;" {{/is}}>		
		<h4><?php _e('Issue a test mail', 'caldera-smtp-mailer') ; ?> <small class="description"><?php _e('Send Test', 'caldera-smtp-mailer') ; ?></small></h4>
		<?php
		// pull in the test sending template
		include CSMTP_PATH . 'includes/templates/test_send-panel.php';
		?>
	</div>

	
	<div class="clear"></div>
	<div class="caldera-smtp-mailer-footer-bar">
		<button type="submit" id="primary-save-button" class="button button-primary wp-baldrick" data-action="csmtp_save_config" data-active-class="none" data-load-element="#caldera-smtp-mailer-save-indicator" data-before="csmtp_get_config_object" ><?php _e('Save Changes', 'caldera-smtp-mailer') ; ?></button>
	</div>	

</form>

{{#unless _current_tab}}
	{{#script}}
		jQuery(function($){
			$('.caldera-smtp-mailer-nav-tab').first().find('a').trigger('click');
		});
	{{/script}}
{{/unless}}