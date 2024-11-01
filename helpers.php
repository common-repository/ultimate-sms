<?php

/**
 * Sends the actual SMS
 * @param  array $args Array of arguments
 * @return array Response object from Twilio PHP library on success or WP_Error object on failure
 */
function smswp_send_sms( $args ) {
	$options = smswp_get_options();
	$options['number_to'] = $options['message'] = '';
	$options = wp_parse_args( $options, smswp_get_defaults() );
	$args = wp_parse_args( $args, $options );
	$log = smswp_validate_sms_args( $args );

	if( !$log ) {
		extract( $args );

		$message = apply_filters( 'smswp_sms_message', $message, $args );

		$client = new Twilio\Rest\Client( $account_sid, $auth_token );

		try {
			$response = $client->messages->create( $number_to, array( 'from' => $number_from, 'body' => $message ) );
			$log = smswp_log_entry_format( sprintf( __( 'Success! Message SID: %s', SMSWP_TD ), $response->sid ), $args );
			$return = $response;
		} catch( \Exception $e ) {
			$log = smswp_log_entry_format( sprintf( __( '****** API Error: %s ******', SMSWP_TD ), $e->getMessage() ), $args );
			$return = new WP_Error( 'api-error', $e->getMessage(), $e );
		}

	} else {
		$return = new WP_Error( 'missing-details', __( 'Some details are missing. Please make sure you have added all details in the settings tab.', SMSWP_TD ) );
	}
	smswp_update_logs( $log, $args['logging'] );
	return $return;
}

/**
 * Update logs primarily from smswp_send_sms() function
 * @param  string $log String of new-line separated log entries to be added
 * @param  int/boolean $enabled Whether to update logs or skip
 * @return void
 */
function smswp_update_logs( $log, $enabled = 1 ) {
	$options = smswp_get_options();
	if ( $enabled == 1 ) {
		$current_logs = get_option( SMSWP_LOGS_OPTION );
		$new_logs = $log . $current_logs;

		$logs_array = explode( "\n", $new_logs );
		if ( count( $logs_array ) > 100 ) {
			$logs_array = array_slice( $logs_array, 0, 100 );
			$new_logs = implode( "\n", $logs_array );
		}

		update_option( SMSWP_LOGS_OPTION, $new_logs );
	}
}

/**
 * Get saved options
 * @return array of saved options
 */
function smswp_get_options() {
	return apply_filters( 'smswp_options', get_option( SMS_WP_OPTION, array() ) );
}

/**
 * Sanitizes option array before it gets saved
 * @param $array array of options to be saved
 * @return array of sanitized options
 */
function smswp_sanitize_option( $option ) {
	$keys = array_keys( smswp_get_defaults() );
	foreach( $keys as $key ) {
		if( !isset( $option[$key] ) ) {
			$option[$key] = '';
		}
	}
	return $option;
}

/**
 * Get default option array
 * @return array of default options
 */
function smswp_get_defaults() {
	$smswp_defaults = array(
		'number_from' => '',
		'account_sid' => '',
		'auth_token' => '',
		'service_id' => '',
		'logging' => '',
		'mobile_field' => '',
		'url_shorten' => '',
		'url_shorten_api_key' => '',
		'url_shorten_bitly' => '',
		'url_shorten_bitly_token' => '',
	);
	return apply_filters( 'smswp_defaults', $smswp_defaults );
}

/**
 * Format log message with more information
 * @param  string $message Message to be formatted
 * @param  array $args Send message arguments
 * @return string Formatted message entry
 */
function smswp_log_entry_format( $message = '', $args ) {
	if ( $message == '' )
		return $message;

	return date( 'Y-m-d H:i:s' ) . ' -- ' . __( 'From: ', SMSWP_TD ) . $args['number_from'] . ' -- ' . __( 'To: ', SMSWP_TD ) . $args['number_to'] . ' -- ' . $message . "\n";
}

/**
 * Validates args before sending message
 * @param  array $args Send message arguments
 * @return string Log entries for invalid arguments
 */
function smswp_validate_sms_args( $args ) {
	// Check that we have the required elements
	$log = '';

	if( !$args['number_from'] ) {
		$log .= smswp_log_entry_format( __( '****** Missing Twilio Number ******', SMSWP_TD ), $args );
	}

	if( !$args['number_to'] ) {
		$log .= smswp_log_entry_format( __( '****** Missing Recipient Number ******', SMSWP_TD ), $args );
	}

	if( !$args['message'] ) {
		$log .= smswp_log_entry_format( __( '****** Missing Message ******', SMSWP_TD ), $args );
	}

	if( !$args['account_sid'] ) {
		$log .= smswp_log_entry_format( __( '****** Missing Account SID ******', SMSWP_TD ), $args );
	}

	if( !$args['auth_token'] ) {
		$log .= smswp_log_entry_format( __( '****** Missing Auth Token ******', SMSWP_TD ), $args );
	}

	return $log;
}

/**
 * Saves the User Profile Settings
 * @param  int $user_id The User ID being saved
 * @return void         Saves to Usermeta
 */
function smswp_save_profile_settings( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	$user_key = sanitize_text_field( $_POST['mobile_number'] );

	update_user_meta( $user_id, 'mobile_number', $user_key );
}

/**
 * Add the Mobile Number field to the Profile page
 * @param  array $contact_methods List of contact methods
 * @return array The list of contact methods with the mobile field added
 */
function smswp_add_contact_item( $contact_methods ) {
	$contact_methods['mobile_number'] = __( 'Mobile Number', SMSWP_TD );

	return $contact_methods;
}

/**
 * Get default option array
 * @return array of default notification options
 */
function smswp_get_notification_defaults() {
	$smswp_defaults = array(
		'notification_number' 		=> '',
		'new_post_published_cb' 		=> 0,
		'new_post_published_message' 		=> 'New post has been published',
		'new_user_registered_cb' 		=> 0,
		'new_user_registered_message' 		=> 'New user has registered.',
		'new_comment_cb' 		=> 0,
		'new_comment_message' 		=> 'New comment posted.',
		'new_login_cb' 		=> 0,
		'new_login_message' 		=> 'New login.',
	);
	return apply_filters( 'smswp_get_notification_defaults', $smswp_defaults );
}

/**
 * Replace post related place holders
 * @return replaced message
 */
function smswp_replace_post_message_variables($message, $post) {
	$replacements = array(
		'%post_title%'       => $post->post_title,
		'%post_content%'       => get_the_excerpt($post),
		'%post_url%'       => get_post_permalink($post),
		'%post_date%'       => get_the_date('',$post),
	);

	return str_replace( array_keys( $replacements ), $replacements, $message );
}

/**
 * Replace user related place holders
 * @return replaced message
 */
function smswp_replace_user_registered_variables($message, $user_id) {

	$user = get_user_by('id', $user_id);
	$replacements = array(
		'%user_login%'       => $user->user_login,
		'%user_email%'       => $user->user_email,
		'%date_register%'       => date(get_option( 'date_format' ),strtotime($user->user_registered))
	);

	return str_replace( array_keys( $replacements ), $replacements, $message );
}

/**
 * Replace comments related place holders
 * @return replaced message
 */
function smswp_replace_comment_post_variables($message, $commentdata) {

	
	$replacements = array(
		'%comment_author%'       => $commentdata['comment_author'],
		'%comment_author_email%'       => $commentdata['comment_author_email'],
		'%comment_author_url%'       => $commentdata['comment_author_url'],
		'%comment_author_IP%'       => $commentdata['comment_author_IP'],
		'%comment_date%'       => date(get_option( 'date_format' ),strtotime($commentdata['comment_date'])),
		'%comment_content%'       => $commentdata['comment_content'],
	);

	return str_replace( array_keys( $replacements ), $replacements, $message );
}

/**
 * Replace user related place holders
 * @return replaced message
 */
function smswp_replace_new_login_variables($message, $user) {

	$replacements = array(
		'%username_login%'       => $user->user_login,
		'%display_name%'       => $user->display_name
	);

	return str_replace( array_keys( $replacements ), $replacements, $message );
}

/**
 * Replace user related place holders
 * @return replaced message
 */
function smswp_replace_newsletter_sms_variables($message, $post_id) {
	$post   = get_post( $post_id );
	$number = get_post_meta($post_id,'smswp_sms_number');
	
	$replacements = array(
		'%subscriber_name%'       => $post->post_title,
		'%subscriber_number%'       => $number[0]
	);

	return str_replace( array_keys( $replacements ), $replacements, $message );
}



// Load notice css
add_action('admin_enqueue_scripts', 'wpsms_ultimate_notice_admin_css');
 
function wpsms_ultimate_notice_admin_css() {
	
    wp_enqueue_style('admin_css', plugins_url('assets/css/admin.css',__FILE__ ));

}

/*
* Display Tab test sms
* @return void
*/
function smswp_display_tab_test_sms() {
//Page url
$page_url = admin_url( 'admin.php?page=smswordpress#send-a-test' );
//Tab name
$tab ='send-a-test';
	$number_to = $message = '';
	
	$clean_message = sanitize_text_field($_POST['message']);
	$clean_number_to = sanitize_text_field($_POST['number_to']);
	
	if( isset( $_POST['submit'] ) ) {
		check_admin_referer( 'smswp-test' );
		if( !$clean_number_to || !$clean_message ) {
			printf( '<div class="error"> <p> %s </p> </div>', esc_html__( 'Some details are missing. Please fill all the fields below and try again.', SMSWP_TD ) );
			extract( $_POST );
		} else {
			$response = smswp_send_sms( stripslashes_deep( $_POST ) );
			if( is_wp_error( $response ) ) {
				printf( '<div class="error"> <p> %s </p> </div>', esc_html( $response->get_error_message() ) );
				extract( $_POST );
			} else {
				printf( '<div class="updated settings-error notice is-dismissible"> <p> Successfully Sent! Message SID: <strong>%s</strong> </p> </div>', esc_html( $response->sid ) );
			}
		}
	}
	?>
	<p><?php _e( 'If you are sending messages while in trial mode, the recipient phone number must be verified with Twilio.', SMSWP_TD ); ?></p>
	<form method="post" action="<?php echo esc_url( add_query_arg($page_url ) ); ?>">
	
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Recipient Number', SMSWP_TD ); ?></th>
				<td>
					<input size="50" type="text" name="number_to" placeholder="+16175551212" value="<?php echo $number_to; ?>" class="regular-text" />
					<br />
					<small><?php _e( 'The destination phone number. Format with a \'+\' and country code e.g., +16175551212 ', SMSWP_TD ); ?></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e( 'Message Body', SMSWP_TD ); ?><br /><span style="font-size: x-small;">
				<td>
					<textarea name="message" maxlength="1600" class="large-text" rows="7"><?php echo $message; ?></textarea>
					<small><?php _e( 'The text of the message you want to send, limited to 1600 characters.', SMSWP_TD ); ?></small><br />
				</td>
			</tr>
		</table>
		<?php wp_nonce_field( 'smswp-test' ); ?>
		
		
		<button type="submit" name="submit" class="button-primary sendsms">
    <i class="fas fa-paper-plane"></i><?php _e( 'Send Message', SMSWP_TD ) ?></button>
	</form>
	<?php 
}





/**
 * Display the Logs tab
 * @return void
 */
function smswp_display_tab_logs_sms($prefix) {

//Page url
$page_url= admin_url( 'admin.php?page=smswordpress#logs' );
//Tab name
$tab ='logs';

	if ( isset( $_GET['clear_logs'] ) && $_GET['clear_logs'] == '1' ) {
		check_admin_referer( 'clear_logs' );
		update_option( SMSWP_LOGS_OPTION, '' );
		$logs_cleared = true;
	}

	if ( isset( $logs_cleared ) && $logs_cleared ) { ?>
		<div id="setting-error-settings_updated" class="updated settings-error"><p><strong><?php _e( 'Logs Cleared', SMSWP_TD ); ?></strong></p></div>
	<?php
	}

	$options = smswp_get_options();
	if ( !$options['logging'] ) {
		printf( '<div class="error"> <p> %s </p> </div>', esc_html__( 'Logging currently disabled.', SMSWP_TD ) );
	}
	$clear_log_url = esc_url( wp_nonce_url( add_query_arg( array( 'tab' => $tab, 'clear_logs' => 1 ), $page_url ), 'clear_logs' ) );
	?>

<pre>
<?php echo get_option( SMSWP_LOGS_OPTION ); ?>
</pre>	

<p><a class="button gray" href="<?php echo $clear_log_url; ?>"><?php _e( 'Clear Logs', SMSWP_TD ); ?></a></p>
	<?php
}






// new tab for notifications
function smswp_display_tab_notifications_sms() {
   

	$options = get_option( SMS_WP_NOTIFICATION_OPTION );
	
	$options = wp_parse_args($options,smswp_get_notification_defaults());
	
	?>
	
	<form method="post" action="options.php">
	
	<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Notification Number:', SMSWP_TD ); ?></th>
				<td>
					<input size="50" type="text" name="<?php echo SMS_WP_NOTIFICATION_OPTION; ?>[notification_number]" placeholder="<?php _e( 'Enter Notification Number', SMSWP_TD ); ?>" value="<?php echo htmlspecialchars( $options['notification_number'] ); ?>" class="regular-text" />
					<p><?php _e( 'Set the number to receive SMS.', SMSWP_TD ); ?></p>
					<p><?php _e( 'Leave empty if you want to receive sms on the main settings number.', SMSWP_TD ); ?></p>
				</td>
			</tr>
	</table>
	<hr />
	<h3><?php _e( 'New Post Published', SMSWP_TD ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Activate:', SMSWP_TD ); ?></th>
				<td>
				<label class="switch">
					<input type="checkbox" name="<?php echo SMS_WP_NOTIFICATION_OPTION;?>[new_post_published_cb]" value="1" <?php checked( $options['new_post_published_cb'], 1, true ); ?> />
				  <span class="slider"></span>
				  	<span class="on">On</span><span class="off">Off</span>
				</label>
				
					
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Message:', SMSWP_TD ); ?></th>
				<td>
					<textarea name="<?php echo SMS_WP_NOTIFICATION_OPTION;?>[new_post_published_message]" class="regular-text" style="display:block;"><?php echo $options['new_post_published_message']; ?></textarea>
					<p><?php _e( 'Enter the content of the sms message', SMSWP_TD ); ?></p>
					<p><?php _e( 'Post title: %post_title%, Post content: %post_content%, Post url: %post_url%, Post date: %post_date%', SMSWP_TD ); ?></p>

				</td>
			</tr>
		</table>
		<hr />
		<h3><?php _e( 'New User Registered', SMSWP_TD ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Activate:', SMSWP_TD ); ?></th>
				<td>
					
					<label class="switch">
					<input type="checkbox" name="<?php echo SMS_WP_NOTIFICATION_OPTION;?>[new_user_registered_cb]" value="1" <?php checked( $options['new_user_registered_cb'], 1, true ); ?> />
				  <span class="slider"></span>
				  	<span class="on">On</span><span class="off">Off</span>
				</label>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Message:', SMSWP_TD ); ?></th>
				<td>
					<textarea name="<?php echo SMS_WP_NOTIFICATION_OPTION;?>[new_user_registered_message]" class="regular-text" style="display:block;"><?php echo $options['new_user_registered_message']; ?></textarea>
					<p><?php _e( 'Enter the content of the sms message', SMSWP_TD ); ?></p>
					<p><?php _e( 'User Login: %user_login%, User email: %user_email%, Register date: %date_register%', SMSWP_TD ); ?></p>

				</td>
			</tr>
		</table>
		<hr />
		<h3><?php _e( 'New Comment', SMSWP_TD ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Activate:', SMSWP_TD ); ?></th>
				<td>
				
					
					<label class="switch">
					<input type="checkbox" name="<?php echo SMS_WP_NOTIFICATION_OPTION;?>[new_comment_cb]" value="1" <?php checked( $options['new_comment_cb'], 1, true ); ?> />
				  <span class="slider"></span>
				  	<span class="on">On</span><span class="off">Off</span>
				</label>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Message:', SMSWP_TD ); ?></th>
				<td>
					<textarea name="<?php echo SMS_WP_NOTIFICATION_OPTION;?>[new_comment_message]" class="regular-text" style="display:block;"><?php echo $options['new_comment_message']; ?></textarea>
					<p><?php _e( 'Enter the content of the sms message', SMSWP_TD ); ?></p>
					<p><?php _e( 'Comment Author: %comment_author%, Author email: %comment_author_email%, Author url: %comment_author_url%, Author IP: %comment_author_IP%, Comment date: %comment_date%, Comment content: %comment_content%', SMSWP_TD ); ?></p>

				</td>
			</tr>
		</table>
		<hr />
		<h3><?php _e( 'New Login', SMSWP_TD ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e( 'Activate:', SMSWP_TD ); ?></th>
				<td>
				


					<label class="switch">
				
					<input type="checkbox" name="<?php echo SMS_WP_NOTIFICATION_OPTION;?>[new_login_cb]" value="1" <?php checked( $options['new_login_cb'], 1, true ); ?> />
				
				  <span class="slider"></span>
				  	<span class="on">On</span><span class="off">Off</span>
				</label>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e( 'Message:', SMSWP_TD ); ?></th>
				<td>
					<textarea name="<?php echo SMS_WP_NOTIFICATION_OPTION;?>[new_login_message]" class="regular-text" style="display:block;"><?php echo $options['new_login_message']; ?></textarea>
					<p><?php _e( 'Enter the content of the sms message', SMSWP_TD ); ?></p>
					<p><?php _e( 'Username: %username_login%, Nickname: %display_name%', SMSWP_TD ); ?></p>

				</td>
			</tr>
		</table>
		
		<?php settings_fields( SMS_WP_NOTIFICATION_SETTING ); ?>
	
	</form>

	<?php
}




function smswp_display_tab_send_sms_newsletter() {
	
	require_once(SMSWP_PATH . 'inc/views/send_sms_newsletter.php');
}