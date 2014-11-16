<?php

$caldera_smtp_mailer = get_option( '_caldera_smtp_mailer' );

?>
<div class="wrap" id="caldera-smtp-mailer-main-canvas">
	<span class="wp-baldrick spinner" style="float: none; display: block;" data-target="#caldera-smtp-mailer-main-canvas" data-callback="csmtp_canvas_init" data-type="json" data-request="#caldera-smtp-mailer-live-config" data-event="click" data-template="#main-ui-template" data-autoload="true"></span>
</div>

<div class="clear"></div>

<input type="hidden" class="clear" autocomplete="off" id="caldera-smtp-mailer-live-config" style="width:100%;" value="<?php echo esc_attr( json_encode($caldera_smtp_mailer) ); ?>">

<script type="text/html" id="main-ui-template">
	<?php
	// pull in the join table card template
	include CSMTP_PATH . 'includes/templates/main-ui.php';
	?>	
</script>