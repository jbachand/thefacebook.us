<?php 
require 'facebook.php';

         $app_id = "216469101714486";
		$facebook = new Facebook(array(
		  'appId'  => '216469101714486',
		  'secret' => '0f13a829aa3f9df1edd1b848e28d9f78',
		));

		// Get User ID
		$user = $facebook->getUser();
		 
		 $attachment = array('message' => 'I\'m looking for people to join me at TheFacebook!',
						'name' => 'TheFacebook',
						'caption' => "The original facebook!",
						'link' => 'https://www.thefacebook.us',
						'description' => 'TheFacebook is an online directory that connects people from facebook through social networks at colleges.',
						'picture' => 'https://www.thefacebook.us/fb/images/app.gif',
						'actions' => array(array('name' => 'Join TheFacebook',
										  'link' => 'https://www.thefacebook.us/bind.php'))
						);


					//$posttofb = $facebook->api('/me/feed/','post',$attachment);

         $canvas_page = "http://www.thefacebook.us/invite.php";

         $message = "Check out the original facebook!";

         $requests_url = "https://www.facebook.com/dialog/apprequests?app_id=" 
                . $app_id . "&redirect_uri=" . urlencode($canvas_page)
                . "&message=" . $message;

         if (empty($_REQUEST["request_ids"])) {
            echo("<script> top.location.href='" . $requests_url . "'</script>");
         } else {
			 header('location:  invite.php');
         }
?>