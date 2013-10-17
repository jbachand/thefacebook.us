<?
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib

$log= new log($_SERVER["PHP_SELF"], $_GET, $_POST, $_SERVER['HTTP_REFERER'] ); 


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
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user_profile) {
  $logoutUrl = $facebook->getLogoutUrl();
	$user_profile['fblogout']= $facebook->getLogoutUrl();
	$user_profile['fblogout']=str_replace("bind.php", "login.php?logout=1",$user_profile['fblogout']); 
	
		
		/*
		
		Friend Import Beta
		*/
		$friendsd = $facebook->api('/me/friends');
		$friends=$friendsd['data'];
		$user_profile['friends']=$friends;
		


		
				
				
				$fql = "SELECT affiliations FROM user WHERE uid='".$user_profile['id']."';";
				$response  =  $facebook->api(array('method' => 'fql.query','query' =>$fql));
				$user_profile['affiliations'] = $response[0]['affiliations'];
				//print_r($user_profile); die();

				//User profile port
				if($user_ports[$user_profile['id']]>0)
					$user_profile['id']=$user_ports[$user_profile['id']];
				 
				$auth= new Authenticate();
				$retvalue=$auth->fbauth($user_profile);
						
				
				
  header('location: home.php');

  die();
} else{

	$url = $facebook->getLoginUrl(array(  
		'scope' => 'email,user_birthday' 
	));
	 echo("<script> top.location.href='" . $url . "'</script>");
	die();
}



?>