
		<div class="caldera-smtp-mailer-config-group">
			<label for="caldera-smtp-mailer-extra-from_name"><?php _e( 'From Name', 'caldera-smtp-mailer' ); ?></label>
			<input id="caldera-smtp-mailer-extra-from_name" type="text" name="extra[from_name]" value="{{extra/from_name}}" >
			<p class="description" style="margin-left: 190px;"> Name in which the email originated. Normally is "WordPress"</p>
		</div>
		<div class="caldera-smtp-mailer-config-group">
			<label for="caldera-smtp-mailer-extra-from_email"><?php _e( 'From Email', 'caldera-smtp-mailer' ); ?></label>
			<input id="caldera-smtp-mailer-extra-from_email" type="text" name="extra[from_email]" value="{{extra/from_email}}" >
			<p class="description" style="margin-left: 190px;"> Email address to send as. Normally the main admin email.</p>
		</div>