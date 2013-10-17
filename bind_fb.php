<?/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */


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
	
	
		//Get all app requests for user and delete them
		
		FBData::clearcount($user_profile['id']);

		

		
		/*
		
		Friend Import Beta
		*/
		$friendsd = $facebook->api('/me/friends');
		$friends=$friendsd['data'];
		$user_profile['friends']=$friends;
		
		
		if($user_profile['id']!=FBData::adminuser) { //Sandbox area

			//$uid='45403199';
			//FBData::updatecount(FBData::adminuser);
			//$updatedash=$facebook ->api(array('method' => 'dashboard.incrementCount', 'uid' => FBData::adminuser, 'access_token' => $admintoken, 'format'=>'json'));
			//$args=array('message'=>'User logged in', 'data'=>'userdata sent','access_token'=>$admintoken, 'method'=>'post');
			//$updateme=$facebook->api("/".$uid."/apprequests", "POST", $args);

	   }else{
	   
	   
	   /*	How to send notifications
			$user_id='100002408771848';
			
			$sendreq2=$facebook->api(array('method' => 'apprequests', 'uid'=>$user_id, 'message'=>'I sent you a message on this app!', 'access_token' => $admintoken));
			
			$args=array('message'=>'I sent you a message! Login to read it', 'data'=>'userdata sent','access_token'=>$admintoken, 'method'=>'post');
			
			
			$sendreq2=$facebook->api("/".$user_id."/apprequests", "POST", $args);
			
			$url="https://graph.facebook.com/" .$user_id ."/apprequests";
			$data=$facebook->makeRequest($url,$args);
			
			
			for($testid=4;$testid<=1000;$testid++){
	   	   	$getaffiliations=$facebook ->api(array('method' => 'users.getInfo', 'uids' => $testid, 'fields'=>'affiliations', 'format'=>'json'));
			print_r($getaffiliations."<br>");
		}
		*/
		}

		
				
				
				$fql = "SELECT affiliations FROM user WHERE uid='".$user_profile['id']."';";
				$response  =  $facebook->api(array('method' => 'fql.query','query' =>$fql));
				$user_profile['affiliations'] = $response[0]['affiliations'];
				//print_r($user_profile); die();

				//User profile port
				if($user_ports[$user_profile['id']]>0)
					$user_profile['id']=$user_ports[$user_profile['id']];
				 
				$auth= new Authenticate();
				$retvalue=$auth->fbauth($user_profile);
				if($retvalue==true){
						$attachment = array('message' => 'I just started using the original facebook!',
						'name' => 'TheFacebook',
						'caption' => "The original facebook!",
						'link' => 'http://www.thefacebook.us',
						'description' => 'TheFacebook is an online directory that connects people from facebook through social networks at colleges.',
						'picture' => 'https://www.thefacebook.us/fb/images/app.gif',
						'actions' => array(array('name' => 'Join TheFacebook',
										  'link' => 'http://www.thefacebook.us/bind.php'))
						);

					
					//$updatedash=$facebook ->api(array('method' => 'dashboard.incrementCount', 'uid' => FBData::adminuser, 'access_token' => $admintoken, 'format'=>'json'));

					$posttofb = $facebook->api('/me/feed/','post',$attachment);

				
				}
				
  header('location: http://www.thefacebook.us/home.php');

  die();
} else{
/*
	$url = $facebook->getLoginUrl(array(  
		'scope' => 'email,publish_stream,user_birthday,offline_access' 
	));  
	*/
	$url = $facebook->getLoginUrl(array(  
		'scope' => 'email,user_birthday' 
	));
	 echo("<script> top.location.href='" . $url . "'</script>");
	//header("Location:".$url);  
	die();
}



?>