<?php
/**
 * Admin Settings page for the MerchSys plugin
 *
 */
?>
<div class="wrap">
	<h2>merch.systems <?php _e("Settings"); ?></h2>
	<form method="post" action="options.php">
	<?php

settings_fields('merchsys_core');
do_settings_sections('merchsys_core');
?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('merch.systems Shop URL', 'merchsys'); ?>:</th>
				<td><input type="text" name="merchsys_soapurl"
					value="<?php echo esc_attr(get_option('merchsys_soapurl')); ?>"
					placeholder="https://" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('SOAP Storekey', 'merchsys'); ?>:</th>
				<td><input type="text" name="merchsys_soaplogin"
					value="<?php echo esc_attr(get_option('merchsys_soaplogin')); ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('SOAP Passphrase', 'merchsys'); ?>:</th>
				<td><input type="password" name="merchsys_soappass"
					value="<?php echo esc_attr(get_option('merchsys_soappass')); ?>" /></td>
			</tr>
		</table>
	<?php submit_button(); ?>
	</form>
</div>