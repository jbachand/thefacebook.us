<?PHP

class Authenticate{

	function __construct(){
	
	}


	public function login($email, $pass) {
		session_start();
		unset($authData);
		$_SESSION[SESSION_AUTHDATA] = $authData;
		
		$site=new Site();
		if($site->get_setting('login_on')==0){
			return( false );
			exit();
		}
		  
		if ( !empty( $email ) ) {  
			$db = new Database();																		
			$db->connect();		
			$where="`email`='".$email."' and (`accountstatusid`>1 or `accountstatusid`=-1)";
			$db->select('`user`','`id`,`name`,`accountstatusid`,`schoolid`, `password`',$where);
			$result=$db->getresult();
			extract($result);

			   if (strcmp($password, md5($pass)) == 0 ) {
				 $authData = array();
				 $authData['name']  = $name;
				 $authData['id']    = $id;
				 $authData['accountstatus'] = $accountstatusid;
				 $authData['schoolid']=$schoolid;
				
				 $_SESSION['authData'] = $authData; 
				 session_write_close();
				 return ( true ); 
			   }
			 		
		  }

		return ( false );
	}
	
	
	
	public function reauth($id) {
		session_start();
		unset($authData);
		$_SESSION[SESSION_AUTHDATA] = $authData;
			$db = new Database();																		
			$db->connect();	
			$where="`id`='".$id."' and (`accountstatusid`>1 or `accountstatusid`=-1)";
			$db->select('`user`','`id`,`name`,`accountstatusid`, `password`, `schoolid`',$where);
			$result=$db->getresult();
			extract($result);

			
				 $authData = array();
				 $authData['name']  = $name;
				 $authData['id']    = $id;
				 $authData['accountstatus'] = $accountstatusid;
				 $authData['schoolid'] = $schoolid;
				
				 $_SESSION['authData'] = $authData; 
				 session_write_close();
				 return ( true ); 
			   
			 		
		  

		return ( false );
	}
	
	public function fbauth($me) {
	//echo "it makes it here";
		session_start();
		unset($authData);
		$_SESSION[SESSION_AUTHDATA] = $authData;
		//$id=$me['id'];
			$db = new Database();																		
			$db->connect();	
			$where="`id`='".$me['id']."' ";
			$db->select('`user`','`id`,`name`,`accountstatusid`, `password`, `schoolid`',$where);
			$result=$db->getresult();
			extract($result);
			//echo "its trying to auth with id". $id;
			
			if($accountstatusid>1||$accountstatusid==-1){
			
			
			$revports=FBData::$user_ports;
			$revports=array_flip($revports);
			if($revports[$id]>0)
					$fbid=$revports[$id];
				else
					$fbid=$id;
					

					
				 $authData = array();
				 $authData['name']  = $name;
				 $authData['id']    = $id;
				 $authData['fbid']	= $fbid;
				 $authData['accountstatus'] = $accountstatusid;
				 $authData['schoolid'] = $schoolid;
				 $authData['fblogin']=TRUE;
				 $authData['logoutUrl']=$me['fblogout'];
				 $_SESSION['authData'] = $authData; 
				 session_write_close();
				 
				 
				$friends=$me['friends'];
					$importfriendquery="INSERT IGNORE INTO user(`id`,`name`,`password`,`accountstatusid`,`schoolid`) VALUES ";
					foreach($friends as $arrid => $frienddata){
					$fname=str_replace("'","&#39;",$frienddata['name']);
						$importfriendquery .= "('".$frienddata['id']."','".$fname."','fblogin','1','".$schoolid."')";
						if(!next($friends)===FALSE) $importfriendquery .=", ";
					}
				$dbimport = new Database();																		
				$dbimport->connect();	
				$dbimport->query($importfriendquery);
				
				 
				 
				 if($this->newuser==true)
				 return( true );
				 else
				 return ( false ); 
			}else{
				//register the new user automatically
				$affs=$me['affiliations'];
				
				$schoolid=-1;
				$affs2=array_reverse($affs);
				if(is_array($affs2[0])){
					foreach ($affs2 as $indaff){
						if($indaff['type']=="college"){
							$schoolid=$indaff['nid'];
							$schoolname=$indaff['name'];
							break;
						}
					}
				}
				
				if($me['id']=="100002408771848") $schoolid=-1;
				if($schoolid=="16777217") $schoolid=1;
				
				
				
					$checkschool="select name from school where id='".$schoolid."'";
					$db = new Database();
					$db->query($checkschool);
					$result=$db->getresult();
					
					if(strlen($result['name']<1)){
						$insertschool="insert into school set id='".$schoolid."', name='".$schoolname."'";
						$db->query($insertschool);
					}
			
				
					if($me['gender']=='male') $sex=2; else $sex=1;
		
					$defaultpicture="http://graph.facebook.com/".$me['id']."/picture?type=large";
					$contents= file_get_contents($defaultpicture);
					$target_path = "/home/newportb/public_html/photos/";					
					
					$firstsubset=rand(100000,9999999);
					$secondsubset=rand(100000,9999999);
					$thirdsubset=rand(1000000,99989999);
					$generated_path=$target_path.$firstsubset."_".$secondsubset."_".$thirdsubset."_n.jpg";
					
					while(file_exists($generated_path)){
						$firstsubset=rand(100000,9999999);
						$secondsubset=rand(100000,9999999);
						$thirdsubset=rand(1000000,99989999);
						$generated_path=$target_path.$firstsubset."_".$secondsubset."_".$thirdsubset."_n.jpg";
					}
					
					$full_target_path = $target_path .$firstsubset."_".$secondsubset."_".$thirdsubset."_f.jpg";
					file_put_contents($full_target_path, $contents);
					
					
					//NORMAL
					$pic3 = new Thumbnail();
					$pic3->filename=$full_target_path; 
					$pic3->filename2=$target_path.$firstsubset."_".$secondsubset."_".$thirdsubset."_n.jpg";  
					$pic3->maxW=170; 
					$pic3->maxH=400;
					$pic3->Text=""; 
					$pic3->SetNewWH(); 
					$pic3->MakeNew(); 
					$pic3->FinirPImage(); 
					

					
					//SEARCH
					$pic2 = new Thumbnail();
					$pic2->filename=$full_target_path; 
					$pic2->filename2=$target_path.$firstsubset."_".$secondsubset."_".$thirdsubset."_s.jpg"; 
					$pic2->maxW=100; 
					$pic2->maxH=200;
					$pic2->Text=""; 
					$pic2->SetNewWH(); 
					$pic2->MakeNew(); 
					$pic2->FinirPImage();
					
					//THUMBNAIL
					$pic2 = new Thumbnail();
					$pic2->filename=$full_target_path; 
					$pic2->filename2=$target_path.$firstsubset."_".$secondsubset."_".$thirdsubset."_t.jpg"; 
					$pic2->maxW=50; 
					$pic2->maxH=50;
					$pic2->Text=""; 
					$pic2->SetNewWH(); 
					$pic2->MakeNew(); 
					$pic2->FinirPImage();
					
					unlink($full_target_path);

					
					
					$registerdate=date("Y-m-d");
					$dtime=date('Y-m-d H:i:s');
					$me['name']=str_replace("'","&#39;",$me['name']);
					
					if($accountstatusid!=1){
					$newfbuser="INSERT INTO `user` 
					(`id`, `email`, `password`, `accountstatusid`, `registerdate`, `name`, `schoolid`, `phone`, 
					`phoneproviderid`, `graduationyear`, `schoolstatusid`, `sexid`, `residenceid`, `birthday`, 
					`hometown`, `highschoolid`, `screennameid`, `websites`, `politicalid`)
					VALUES 
					('".$me['id']."', '".$me['email']."', 'fblogin', '2', '".$registerdate."', '".$me['name']."', '".$schoolid."', '', '', '', '1', '".$sex."', '', '".$me['birthday']."', '', '', '', '', '');";
					}else{
					$newfbuser="UPDATE `user` SET
					`email`='".$me['email']."',
					`accountstatusid`='2', 
					`registerdate`='".$registerdate."', 
					`schoolid`='".$schoolid."', 
					`schoolstatusid`='1', 
					`sexid`='".$sex."', 
					`birthday`='".$me['birthday']."'
					WHERE `id`='".$me['id']."' LIMIT 1
					"; 
					}
					
					
					
					$updateprofile="insert into `profileupdates` (`id`, `userid`, `timestamp`) VALUES (NULL, '".$me['id']."', '".$dtime."');";
					$setpicture="insert into `picture` (`userid`, `albumid`, `link`) VALUES ('".$me['id']."', '0', '".$firstsubset."_".$secondsubset."_".$thirdsubset."');";
					
					$site= new site();
					if($site->get_setting('email_alerts')==1){
						$body = "Name: ".$me['name'].".<br>Email: ".$me['email'];
						email::send('reports@harvardconnection.co','New Registration',$body);
					}
					
					
					$db->query($newfbuser);
					$db->query($updateprofile);
					$db->query($setpicture);
					
					$this->newuser=true;
					$this->fbauth($me);
					
					return( true );

			}
			 		
	}
	
	
	
	
		public function register($email, $pass, $status, $uname, $acceptterms) {
		$site=new Site();
		if($site->get_setting('registration_on')==0)
			return('-99'); // Currently not accepting registrations
				
			$emailext=explode("@",$email);
			$emailext=$emailext[1];
			$emailexte=explode(".", $emailext);
			$emailext=$emailexte[count($emailexte)-2].".".$emailexte[count($emailexte)-1];
			
			if($emailext=="ac.uk"){
			$emailext = $emailexte[count($emailexte)-3].".".$emailext;
			}
			
			//echo $emailext;

  
			$db = new Database();																		
			$db->connect();		
			
			$validation = new validation();
			if(!$validation->Email($email)){
				return('-10'); // Not a valid email address
			}
			
			if(!$validation->FormalName($uname)){
				return('-11'); // Not a valid name
			}
			
			if(!$validation->Number($status)||$status<1&&$status>4){
				return('-12'); // Not a valid status
			}
			
			if($acceptterms!=1)
				return('-13'); // Did not accept terms
				
			if(strlen($pass)<3)
				return('-14'); // Password not valid
			
			$where="`email`='".$email."'";
			$db->select('`user`','`id`',$where);
			$result=$db->getresult();
			extract($result);
			if($id>0)
				return('-4'); //Email already in database
				
			$id=NULL;
				
			$where="`emailextension`='".$emailext."'";
			$db->select('`school`','`id`, `name`',$where);
			$result=$db->getresult();
			//print_r($result);
			extract($result);
			//echo "$id - $name";
			if($id<1&&$emailext!='harvardconnection.co'){
				return('-2'); //School extension not valid
				}
			$schoolname=$name;	
			$schoolid=$id;
			$id=NULL;
			$name=NULL;
			
	
			


		return ( $schoolid ); //Check your email yo
	}
	
	public function confirmation($id, $code){
		$db = new Database();																		
		$db->connect();	
		
		$where="`confirmnumber`='".$id."' and `codenumber`='".$code."'";
		$db->select('`confirmationemail`','`userid`',$where);
		$result=$db->getresult();
		
		$userid=$result['userid'];
		
		if($userid<1) return -1;
		
		$confirmuserquery="update user set `accountstatusid`='2' where `id`='".$userid."' limit 1";
		$removeconfirmquery="delete from confirmationemail where `userid`='".$userid."'";
		
		$db->query($confirmuserquery);
		$db->query($removeconfirmquery);
		
	
	return 1;
	}

}

?>