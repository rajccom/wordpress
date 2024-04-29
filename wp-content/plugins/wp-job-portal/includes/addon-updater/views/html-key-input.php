<tr id="<?php echo esc_attr( sanitize_title( $addon_slug . '_transaction_key_row' ) ); ?>" class="active plugin-update-tr wpjobportal-updater-licence-key-tr">
	<td class="plugin-update" colspan="3">
		<div class="wpjobportal-updater-licence-key">
			<label for="<?php echo esc_attr(sanitize_title( $addon_slug )); ?>_transaction_key"><?php _e( 'Transaction Key' ); ?>:</label>
			<input type="text" id="<?php echo esc_attr(sanitize_title( $addon_slug )); ?>_transaction_key" name="<?php echo esc_attr( $addon_slug ); ?>_transaction_key" placeholder="XXXXXXXXXXXXXXXX" />
			<input type="submit" id="<?php echo esc_attr(sanitize_title( $addon_slug )); ?>_submit_button" name="<?php echo esc_attr( $addon_slug ); ?>_submit_button" value="Authenticate" />
			<input type="hidden" name="wpjobportal_addon_array_for_token[]" value="<?php echo esc_attr( $addon_slug ); ?>" />
			<div>
				<span class="description"><?php _e( 'Please select '.wpjobportalphplib::wpJP_strtoupper( wpjobportalphplib::wpJP_substr( $updateaddon_slug, 0, 2 ) ).wpjobportalphplib::wpJP_substr(  wpjobportalphplib::wpJP_ucwords($updateaddon_slug), 2 ).'</b> and Enter your license key and hit to authenticate. A valid key is required for updates.' ); ?> <?php printf( 'Lost your key? <a href="%s">Retrieve it here</a>.', esc_url( 'https://wpjobportal.com/my-account/' ) ); ?></span>
			</div>
		</div>
	</td>
</tr>
<tr>
	<?php
	/*
	$latest_version = get_option('jsticketdsknotifwp_latest_version');
	if ($latest_version != false && version_compare( $latest_version, $this->plugin_data['Version'], '>' ) ) {
	?>
		<td class="plugin-update plugin-update colspanchange" colspan="3">
			<div class="update-message notice inline notice-warning notice-alt"><p>There is a new version of JS Ticket Notification available. Insert key to update plugin </p></div>
		</td>
	<?php }
	*/ ?>
</tr>
