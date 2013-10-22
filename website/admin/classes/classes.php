<?PHP

error_reporting(0);



date_default_timezone_set('America/Chicago');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Database.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Validation.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/SessionData.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Authentication.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Email.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Statistics.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Log.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Profile.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Search.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Event.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Relationship.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Picture.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Message.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Dropdowns.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Thumbnail.php');
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/lib/Site.php');


/*

FB data include and globals

*/
include($_SERVER["DOCUMENT_ROOT"].'/facebook.php');

class FBData{
	/**
	* 	SET THE FOLLOWING CONST VARIABLES
	*/
	const app_id='';
	const app_secret='';
	const admintoken='';
	const adminuser='';
	
	/**
	*	user_ports take user ids and port them to user ids locally
	*/
	//public static  $user_ports=array('45403199'=>'3'); 
	public static $user_ports=array();
	public static  $dont_alert=array('1');
	
	public function updatecount($uid){
	
		$senduser = new Profile($uid);
		$uinfo=$senduser->profile;
		
		$tfbid=self::get_fbid($uid);
					
					
		if($uinfo['activeaccount']>1&&!in_array($tfbid,self::$dont_alert)){
			$facebook = new Facebook(array('appId'  => self::app_id,'secret' => self::app_secret,));
		}
	
	}
	
	public function get_fbid($uid){
		
		$revports=self::$user_ports;
		$revports=array_flip($revports);
		
			if($revports[$uid]>0)
					$tfbid=$revports[$uid];
				else
					$tfbid=$uid;
					
		return($tfbid);
	}
	
	public function clearcount($uid){
	
		$senduser = new Profile($uid);
		$uinfo=$senduser->profile;
		
		$tfbid=self::get_fbid($uid);
					
					
		if($uinfo['activeaccount']>1&&!in_array($tfbid,self::$dont_alert)){
			$atoken=self::admintoken;
			$facebook = new Facebook(array('appId'  => self::app_id,'secret' => self::app_secret,));
			  try {
				// Proceed knowing you have a logged in user who's authenticated.
				$update=$facebook ->api(array('method' => 'dashboard.setCount', 'uid' => $tfbid, 'access_token' => $atoken, 'count'=>'0', 'format'=>'json'));
			  } catch (FacebookApiException $e) {
				//echo "failed"; die();
			  }
		
			$apprequests = $facebook->api('/me/apprequests');		
			$appreq=$apprequests['data'];
			foreach($appreq as $appreqdat){
				$apprequestsresult = $facebook->api($appreqdat['id'], 'DELETE');
			}
		}
	
	}


}



	$app_id=FBData::app_id;
	$app_secret=FBData::app_secret;
	$admintoken=FBData::admintoken;
	$fulladmintoken='access_token='.$admintoken;
	$user_ports=FBData::$user_ports;
	$reverse_ports=array_flip($user_ports);
	$fbreq_friend="I added you as a friend on HarvardConnection! Join me there, its the original facebook!";
	$fbreq_message="I sent a message to you, but to view it you have to sign up at HarvardConnection. Its the original facebook!";
	
	$facebook = new Facebook(array(
	  'appId'  => $app_id,
	  'secret' => $app_secret,
	));

	
/*

Start the site

*/	
	
$site=new Site();
if($site->get_setting('site_on')==0){
	header("Location: thewebsiteisdownahhhh.php"); 
	die(); 
}



// TRIGGERS

/*
Last Activity 
DROP TRIGGER log_trigger;

DELIMITER |

CREATE TRIGGER log_trigger
AFTER INSERT ON log
FOR EACH ROW BEGIN
REPLACE INTO `last_activity` (`last`, `user_id`) VALUES (DATE_ADD(NOW(), INTERVAL 1 HOUR), NEW.userid);
IF (Select count(1) from `Hits_Per_Day` WHERE `date`=CURDATE())=0 THEN
	INSERT INTO `Hits_Per_Day` (`date`,`hits`) VALUES (CURDATE(),'1');
ELSE
	UPDATE `Hits_Per_Day` SET `hits`=`hits`+1 WHERE `date`=CURDATE();
END IF;
IF (Select count(1) from `Hits_Per_Month` WHERE `date`=concat(YEAR(curdate()),"-",month(curdate()),"-0"))=0 THEN
	INSERT INTO `Hits_Per_Month` (`date`,`hits`) VALUES (concat(YEAR(curdate()),"-",month(curdate()),"-0"),'1');
ELSE
	UPDATE `Hits_Per_Month` SET `hits`=`hits`+1 WHERE `date`=concat(YEAR(curdate()),"-",month(curdate()),"-0");
END IF;
IF NEW.userid>0 AND (Select count(1) from `log` WHERE `userid`=NEW.userid AND `timestamp`>CURDATE())=1 THEN
	IF (Select count(1) from `Users_Per_Day` WHERE `date`=CURDATE())=0 THEN
		INSERT INTO `Users_Per_Day` (`date`,`hits`) VALUES (CURDATE(),'1');
	ELSE
		UPDATE `Users_Per_Day` SET `hits`=`hits`+1 WHERE `date`=CURDATE();
	END IF;
END IF;
IF (Select count(1) from `log` WHERE `ip`=NEW.ip AND `timestamp`>CURDATE())=1 THEN
	IF (Select count(1) from `Uniques_Per_Day` WHERE `date`=CURDATE())=0 THEN
		INSERT INTO `Uniques_Per_Day` (`date`,`hits`) VALUES (CURDATE(),'1');
	ELSE
		UPDATE `Uniques_Per_Day` SET `hits`=`hits`+1 WHERE `date`=CURDATE();
	END IF;
END IF;
END;

|

DELIMITER ;

// sync tables
REPLACE INTO last_activity
SELECT last,`userid` as `user_id` 
FROM lastactivity
*/

/*
Last Update

DELIMITER |

CREATE TRIGGER lu_trigger
AFTER INSERT ON profileupdates
FOR EACH ROW BEGIN
REPLACE INTO `last_update` (`last`, `user_id`) VALUES (DATE_ADD(NOW(), INTERVAL 1 HOUR), NEW.userid);
END;

|

DELIMITER ;

// sync tables
REPLACE INTO last_update
SELECT last,`userid` as `user_id` 
FROM lastupdate









*/
?>