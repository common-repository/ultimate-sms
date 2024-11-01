<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//
// Set a unique slug-like ID
//
$prefix = 'smswp_option';

//
// Create options
//
CSF::createOptions( $prefix, array(
  'menu_title' => 'SMS WordPress',
  'menu_slug'  => 'smswordpress',
  'menu_icon'   => 'dashicons-email-alt',
) );





//
// Create a section
//
CSF::createSection( $prefix, array(
  'title'  => 'SMSWP Settings',
  'icon'   => 'fas fa-list',
  'fields' => array(
  
  
  array(
  'type'    => 'notice',
  'style'   => 'success',
  'content' => '<b>General settings</b>',
  
),


	array(
  'id'      => 'account_sid',
  'type'    => 'text',
  'title'    => 'Account SID',
   'subtitle'    => 'Available from within your Twilio account',
  'desc'   => 'To view API credentials visit <a target="_blank" href="https://www.twilio.com/user/account/voice-sms-mms">https://www.twilio.com/user/account/voice-sms-mms</a>',
  'default' => 'Enter Account SID'
),


	array(
  'id'      => 'auth_token',
  'type'    => 'text',
  'title'    => 'Auth Token',
   'subtitle'    => 'Available from within your Twilio account',
  'desc'   => 'To view API credentials visit <a href="https://www.twilio.com/user/account/voice-sms-mms" target="_blank">https://www.twilio.com/user/account/voice-sms-mms</a>',
  'default' => 'Enter Auth Token'
),

	array(
  'id'      => 'service_id',
  'type'    => 'text',
  'title'    => 'Service ID',
   'subtitle'    => 'Available from within your Twilio account It\'s require for bulk SMS',
  'desc'   => 'To view or create Notify Service ID visit <a href="https://www.twilio.com/console/notify/services" target="_blank">https://www.twilio.com/console/notify/services</a>',
  'default' => 'Enter Notify Service ID'
),

	array(
  'id'      => 'number_from',
  'type'    => 'text',
  'title'    => 'Twilio Number',
   'subtitle'    => 'Must be a valid number associated with your Twilio account',
  'desc'   => 'Country code + 10-digit Twilio phone number (i.e. +16175551212)',
  'default' => 'Enter Auth Token'
),


   array(
      'id'    => 'logging',
      'type'  => 'switcher',
      'title' => 'Enable Logging',
      'label' => 'Enable or Disable Logging.',
    ),
	
	
 array(
      'id'    => 'mobile_field',
      'type'  => 'switcher',
      'title' => 'Add Mobile Number Field to User Profiles',
      'label' => 'Adds a new field "Mobile Number" under Contact Info on all user profile forms.',
    ),
	
	
	
	 array(
      'id'    => 'url_shorten_bitly',
      'type'  => 'switcher',
      'title' => 'Shorten URLs using Bit.ly',
     
    ),
	
	
	 array(
      'id'    => 'url_shorten_bitly_token',
      'type'  => 'text',
      'title' => 'Enter Bit.ly Access Token',
	   'dependency' => array( 'url_shorten_bitly', '==', 'true' ),
	    'desc' => 'Shorten all URLs in the message using the <a href="https://dev.bitly.com/v4_documentation.html" target="_blank">Bit.ly URL Shortener API</a>. Checking will display the access token field.',
    ),
	
 array(
      'id'    => 'url_shorten',
      'type'  => 'switcher',
      'title' => 'Enable google Shorten url',
    ),



array(
      'id'    => 'url_shorten_api_key',
      'type'  => 'text',
      'title' => 'Shorten URLs using Google (Deprecated)',
      'label' => 'Enter Google Project API key',
	    'dependency' => array( 'url_shorten', '==', 'true' ),
		'desc' => 'Shorten all URLs in the message using the <a href="https://code.google.com/apis/console/" target="_blank">Google URL Shortener API</a>. Checking will display the API key field.',
    ),
	
	



  
  )
  
) );









//
// Create a section
//
CSF::createSection( $prefix, array(
  'title'  => 'Send a Test',
  'icon'   => 'fas fa-paper-plane',
  'fields' => array(
  
    // A Heading
array(
  'type'    => 'notice',
  'style'   => 'success',
  'content' => '<b>Send Test SMS</b>',
  
),
  
  
   
	
// A Callback Field Example
array(
  'type'     => 'callback',
  'function' => 'smswp_display_tab_test_sms',
),


	
  )
) );










//
// Create a section
//
CSF::createSection( $prefix, array(
  'title'  => 'Notifications',
  'icon'   => 'fas fa-flag',
  'fields' => array(
  
    // A Heading
array(
  'type'    => 'notice',
  'style'   => 'success',
  'content' => '<b>Notifications Settings</b>',
  
),
  
  
   
	
// A Callback Field Example
array(
  'type'     => 'callback',
  'function' => 'smswp_display_tab_notifications_sms',
),


	
  )
) );





//
// Create a section
//
CSF::createSection( $prefix, array(
  'title'  => 'Logs',
  'icon'   => 'fas fa-clipboard-list',
  'fields' => array(
  
    // A Heading
array(
  'type'    => 'notice',
  'style'   => 'success',
  'content' => '<b>Logs settings</b>',
  
),
  
  
   
	
// A Callback Field Example
array(
  'type'     => 'callback',
  'function' => 'smswp_display_tab_logs_sms',
),


	
  )
) );