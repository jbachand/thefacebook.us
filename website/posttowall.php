<?php 

require 'facebook.php';
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '216469101714486',
  'secret' => '0f13a829aa3f9df1edd1b848e28d9f78',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	$status = $facebook->api('/me/feed', 'POST', array('message' => 'I\'m using the original facebook: http://apps.facebook.com/harvardconnection'));
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
header('location: posted.php');
?> 