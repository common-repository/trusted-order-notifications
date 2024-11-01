<?php
/**
 * Admin Settings.
 */
$data = $this->data();
?>

<div class="wrap">
	<h2><?php esc_html_e( 'Trusted Order Notifications Settings', 'trusted-order-notifications' ); ?></h2>
	<?php $this->message(); ?>
	<form method="post" id="vnf-settings-form" action="<?php echo $this->form_action(); ?>">
		<hr>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Show on Mobile', 'trusted-order-notifications' ); ?>: <br/>
					</th>
					<td>
						<input id="vnf_onmobile" name="vnf_options[onmobile]" type="checkbox" value="1" <?php checked('1', $data['onmobile']); ?> />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Transition Duration', 'trusted-order-notifications' ); ?>: <br/>
						<small><?php esc_html_e( '(Milliseconds)', 'trusted-order-notifications' ); ?></small>
					</th>
					<td>
						<input id="vnf_numorder" name="vnf_options[timenext]" type="text" class="regular-text" value="<?php if( $data['timenext'] =='') { echo '10000'; } else { esc_attr_e( $data['timenext'] ); } ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Customer List', 'trusted-order-notifications' ); ?>: <br/>
						<small><?php esc_html_e( 'Name|Phone Number|Time (one Per line)', 'trusted-order-notifications' ); ?></small>
					</th>
					<td>
						<textarea name="vnf_options[customer]" id="vnf_customer" cols="80" rows="10"><?php if( $data['customer'] =='') { echo 'Cristiano Ronaldo|096 352 xxx|1 minute ago
Lionel Messi |098 8765 xxx|5 minutes ago'; } else { esc_attr_e( $data['customer'] ); } ?></textarea>
						<small></small>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php esc_html_e( 'Background color', 'trusted-order-notifications' ); ?>:
					</th>
					<td><input name="vnf_options[color]" type="text" value="<?php if($data['color']==''){echo '#009611';}else{ echo $data['color']; } ?>" class="vnf_options-color" data-default-color="#009611" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php esc_html_e( 'Notification text', 'trusted-order-notifications' ); ?>:
					</th>
					<td>
						<div class="vnf_ntf">
						<input name="vnf_options[thankyou]" type="text" value="<?php if($data['thankyou']==''){echo 'Thank You,';}else{ echo $data['thankyou']; } ?>"/> <?php esc_html_e( 'Customer name', 'trusted-order-notifications' ); ?><br/>
						<?php esc_html_e( 'Phone number', 'trusted-order-notifications' ); ?> <input name="vnf_options[orderss]" type="text" value="<?php if($data['orderss']==''){echo 'Order Successful!';}else{ echo $data['orderss']; } ?>"/>.<br/>
						x <?php esc_html_e( 'Minutes ago.', 'trusted-order-notifications' ); ?>
						</div>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php esc_html_e( 'Position', 'trusted-order-notifications' ); ?>:</th>
					<td class="position">
						<div class="position-options">
							<div class="item">
								<input type="radio" id="position1" name="vnf_options[position]" value="top-left" <?php checked('top-left', $data['position']); ?>>
								<label title="top-left" for="position1">Top Left</label>
							</div>
							<div class="item">
								<input type="radio" id="position2" name="vnf_options[position]" value="bottom-left" <?php checked('bottom-left', $data['position']); ?>>
								<label title="bottom-left" for="position2">Bottom Left</label>
							</div>
							<div class="radio-item">
								<input type="radio" id="position3" name="vnf_options[position]" value="top-right" <?php checked('top-right', $data['position']); ?>>
								<label title="top-right" for="position3">Top Right</label>
							</div>
							<div class="radio-item">
								<input type="radio" id="position4" name="vnf_options[position]" value="bottom-right" <?php if($data['position'] ==''){echo 'checked';} checked('bottom-right', $data['position']); ?>>
								<label title="bottom-right" for="position4">Bottom Right</label>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<?php submit_button(); ?>
		<?php wp_nonce_field( 'vnf-settings', 'vnf-settings-nonce' ); ?>

	</form>
	<hr />
	<h2><?php esc_html_e( 'Support', 'trusted-order-notifications' ); ?></h2>
	<p>
		<?php _e( 'For submitting any support queries, feedback, bug reports or feature requests, please visit <a href="https://vnfaster.com/" target="_blank">this link</a>..', 'trusted-order-notifications' ); ?>
	</p>
	<style type="text/css">
	.vnf_ntf{background: blanchedalmond;border: 1px solid #ddd;display: inline-block;padding: 10px 20px}
	</style>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.vnf_options-color').wpColorPicker();
	});
	</script>
</div>
