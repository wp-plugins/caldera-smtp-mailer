
		<div class="caldera-smtp-mailer-config-group">
			<label for="caldera-smtp-mailer-advanced-priority"><?php _e( 'Priority', 'caldera-smtp-mailer' ); ?></label>
			<input id="caldera-smtp-mailer-advanced-priority" type="number" name="advanced[priority]" value="{{#if advanced/priority}}{{advanced/priority}}{{else}}30{{/if}}" style="width:50px;">
			<p class="description"><?php _e( 'If another plugin overrides wp_mail sending, Set this higher to kick in later. e.g. 50', 'caldera-smtp-mailer' ); ?></p>
		</div>
