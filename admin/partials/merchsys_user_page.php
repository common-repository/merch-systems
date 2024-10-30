<?php
/**
 * Custom MerchSys User fields for the Admin User page
 *
 */
?>
<h3>merch.systems <?php _e("User data", MerchSys_Settings::PLUGIN_NAME); ?></h3>
<table class="form-table">
<?php

foreach ($fields as $field) {
    if ($field['type'] == 'label' || isset($field['compare']) || $field['name'] == 'user_email')
        continue;
    $label = isset($field['label']) ? __($field['label'], MerchSys_Settings::PLUGIN_NAME) : $field['name'];
    ?>
<tr valign="top">
		<th scope="row"><label for="<?php echo $field['name']; ?>"><?php echo $label; ?>:</label></th>
		<td>
<?php
    if ($field['name'] == 'country' && $countries != null) {
        ?>
		<select name="<?php echo $field['name']; ?>">
		<?php foreach ($countries as $id => $country) { ?>
		<option value="<?php echo $id; ?>"
					<?php echo esc_attr($user_meta[$field['name']][0]) == $id ? 'selected' : ''; ?>><?php echo $country; ?></option>
		<?php } ?>
		</select>
<?php

} else {
        ?>
	<input type="text" name="<?php echo $field['name']; ?>"
			value="<?php echo esc_attr($user_meta[$field['name']][0]); ?>" />
<?php	} ?>
</td>
	</tr>
<?php } ?>
</table>