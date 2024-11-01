<?php 
/**
 * Function to send new post notifications
 */
function smswp_send_post_notification($new_status, $old_status, $post) {
	
	$options = get_option( SMS_WP_NOTIFICATION_OPTION );
	$options = wp_parse_args($options,smswp_get_notification_defaults());

	if( $new_status == 'publish' && $old_status != 'publish' && $options["new_post_published_cb"] ) {

		$message = $options[ 'new_post_published_message'];
		$message = smswp_replace_post_message_variables( $message, $post );

		$contact_number = $options["notification_number"];
		if(!empty($contact_number))
		{
			$args = array(
				'number_to' => $contact_number,
				'message' => $message,
			);
			smswp_send_sms( $args );
		}
		

	}
}

add_action('transition_post_status', 'smswp_send_post_notification', 10, 3);

/**
 * Function to send new user registration notifications
 */
function smswp_send_user_registered_notification($user_id) {
	
	$options = get_option( SMS_WP_NOTIFICATION_OPTION );
	$options = wp_parse_args($options,smswp_get_notification_defaults());

	if( $options["new_user_registered_cb"] ) {

		$message = $options[ 'new_user_registered_message'];
		$message = smswp_replace_user_registered_variables( $message, $user_id );

		$contact_number = $options["notification_number"];
		if(!empty($contact_number))
		{
			$args = array(
				'number_to' => $contact_number,
				'message' => $message,
			);
			smswp_send_sms( $args );
		}
		

	}
}

add_action('user_register','smswp_send_user_registered_notification');

/**
 * Function to send comment post notification
 */
function smswp_send_comment_post_notification($comment_ID, $comment_approved, $commentdata) {
	
	$options = get_option( SMS_WP_NOTIFICATION_OPTION );
	$options = wp_parse_args($options,smswp_get_notification_defaults());

	if( $options["new_comment_cb"] ) {

		$message = $options[ 'new_comment_message'];
		$message = smswp_replace_comment_post_variables( $message, $commentdata);
	
		$contact_number = $options["notification_number"];
		if(!empty($contact_number))
		{
			$args = array(
				'number_to' => $contact_number,
				'message' => $message,
			);
			smswp_send_sms( $args );
		}
		

	}
}

add_action('comment_post','smswp_send_comment_post_notification', 10, 3);

/**
 * Function to send new user registration notifications
 */
function smswp_send_user_login_notification($user_login, $user) {
	
	$options = get_option( SMS_WP_NOTIFICATION_OPTION );
	$options = wp_parse_args($options,smswp_get_notification_defaults());

	if( $options["new_login_cb"] ) {

		$message = $options[ 'new_login_message'];
		$message = smswp_replace_new_login_variables( $message, $user);
	
		$contact_number = $options["notification_number"];
		if(!empty($contact_number))
		{
			$args = array(
				'number_to' => $contact_number,
				'message' => $message,
			);
			smswp_send_sms( $args );
		}
		

	}
}

add_action('wp_login','smswp_send_user_login_notification', 10, 2);

?>