<?php

// Default options
function smswp_get_newsletter_defaults() {
	$smswp_newsletter_defaults = array(
		'show_groups_cb' 		=> 0,
		'verify_subscriber_cb' 		=> 0,
		'welcome_sms_cb' 		=> 0,
		'welcome_sms_message' 		=> '',
		'name_place_holder' 		=> '',
		'number_place_holder' 		=> '',
		'confirmation_text' 		=> '',
		'enable_gdpr_cb' 		=> 0,
		'gdpr_agreement' 		=> '',
		'disable_styles_cb' 		=> 0,
	);
	return apply_filters( 'smswp_get_newsletter_defaults', $smswp_newsletter_defaults );	
}

?>