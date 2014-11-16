
		<div class="caldera-smtp-mailer-config-group">
			<label for="caldera-smtp-mailer-smtp-host"><?php _e( 'Host', 'caldera-smtp-mailer' ); ?></label>
			<input id="caldera-smtp-mailer-smtp-host" type="text" name="smtp[host]" value="{{smtp/host}}" required="required">
			<p class="description" style="margin-left: 190px;"> Server Hostname e.g. mail.example.com</p>
		</div>
		<div class="caldera-smtp-mailer-config-group">
			<label for="caldera-smtp-mailer-smtp-port"><?php _e( 'Port', 'caldera-smtp-mailer' ); ?></label>
			<input id="caldera-smtp-mailer-smtp-port" type="text" name="smtp[port]" value="{{smtp/port}}" required="required">
			<p class="description" style="margin-left: 190px;"> SMTP Port. e.g. 587</p>
		</div>
		<div class="caldera-smtp-mailer-config-group">
			<label for="caldera-smtp-mailer-smtp-auth"><?php _e( 'Auth', 'caldera-smtp-mailer' ); ?></label>
			
			<select id="caldera-smtp-mailer-smtp-auth" name="smtp[auth]">
				<option value=""><?php _e( 'None', 'caldera-smtp-mailer' ); ?></option>
				<option value="ssl" {{#is smtp/auth value="ssl"}}selected="selected"{{/is}}><?php _e( 'SSL', 'caldera-smtp-mailer' ); ?></option>
				<option value="tls" {{#is smtp/auth value="tls"}}selected="selected"{{/is}}><?php _e( 'TLS', 'caldera-smtp-mailer' ); ?></option>
			</select>

			<p class="description" style="margin-left: 190px;"> Authentication Method</p>
		</div>
		<div class="caldera-smtp-mailer-config-group">
			<label for="caldera-smtp-mailer-smtp-username"><?php _e( 'Username', 'caldera-smtp-mailer' ); ?></label>
			<input id="caldera-smtp-mailer-smtp-username" type="text" name="smtp[username]" value="{{smtp/username}}" required="required">
			<p class="description" style="margin-left: 190px;"> Username for SMTP account. Get this from your provider</p>
		</div>
		<div class="caldera-smtp-mailer-config-group">
			<label for="caldera-smtp-mailer-smtp-password"><?php _e( 'Password', 'caldera-smtp-mailer' ); ?></label>
			<input id="caldera-smtp-mailer-smtp-password" type="text" name="smtp[password]" value="{{smtp/password}}" required="required">
			<p class="description" style="margin-left: 190px;"> Password for SMTP account. Get this from your provider</p>
		</div>