<?PHP

class Profile{

		public $userid;
		public $db; 
		


	function __construct($uid=0){
		if($uid<1){
			$uid=$this->session_id();
		}

	 $this->set($uid);
	}
	
	private function session_id(){
		$userid=$this->userid;
			$sess = new SessionData();
			$userid=$sess->Retrieve('id');
			$this->userid=$userid;
			$this->schoolid=$sess->Retrieve('schoolid');
		
		return($userid);
	}
	
	
	public function set($userid){
		global $db;
		$db = new Database();						
		$db->connect();
		


		//relationshipstatus

		//music
		//defaultpicture

			$mainquery="
				select p.name as name, p.registerdate as registerdate,
				s.name as school, ss.name as status, sx.name as sex, r.name as residence, 
				p.birthday as birthday, p.hometown as hometown, h.name as highschool, p.email as email,
				sn.name as screenname, p.phone as mobile, p.websites as website, 
				pol.name as political, p.accountstatusid as activeaccount
				from user p 
				left join school s on p.schoolid=s.id
				left join schoolstatus ss on p.schoolstatusid=ss.id
				left join sex sx on p.sexid=sx.id
				left join residence r on p.residenceid=r.id
				left join highschool h on p.highschoolid=h.id
				left join screenname sn on p.screennameid=sn.id
				left join political pol on p.politicalid=pol.id	
				where p.id='".$userid."'
				";
				
			
			$lookingforquery="
				select lf.name as lookingfor
				from lookingfor lf
				join lookingforlink lfl on lfl.lookingforid=lf.id
				where lfl.userid='".$userid."'
				order by lf.id
				";
			$interestedinquery="
				select i.name as interestedin
				from interestedin i
				join interestedinlink il on il.interestedinid=i.id
				where il.userid='".$userid."'
				";
			$musicquery="
				select m.name as music
				from music m
				join musiclink ml on ml.musicid=m.id
				where ml.userid='".$userid."'
				order by ml.id
				";
			$classquery="
				select c.name as classes
				from class c
				join classlink cl on cl.classid=c.id
				where cl.userid='".$userid."'
				order by cl.id
				";
			$fridgequery="
				select f.name as fridge
				from fridge f
				join fridgelink fl on fl.fridgeid=f.id
				where fl.userid='".$userid."'
				order by fl.id
				";
			$interestsquery="
				select i.name as interests
				from interests i
				join interestslink il on il.interestsid=i.id
				where il.userid='".$userid."'
				order by il.id
				";
			$relationshipquery="
				select rt.name as relationship, s.id as relationshipsenderid, rc.id as relationshipreceiverid, s.name as relationshipsender, rc.name as relationshipreceiver
				from relationship r
				left join relationshiptype rt on r.realtionshiptypeid=rt.id
				join user s on s.id=r.senderid 
				join user rc on rc.id=r.receiverid
				where (r.senderid ='".$userid."' or r.receiverid='".$userid."')
				and r.confirmed=1
				and r.realtionshiptypeid>1
				and s.accountstatusid>0
				and rc.accountstatusid>0
				order by r.realtionshiptypeid DESC
				";
			$defaultpicturequery="
				select p.link as defaultpicture
				from picture p
				where p.userid='".$userid."'
				and p.albumid=0
				order by p.id desc
				limit 1
				";
				

				
			$mainprofile=array();
			
			$db->query($mainquery);
			$db->query($lookingforquery);
			$db->query($interestedinquery);
			$db->query($musicquery);
			$db->query($classquery);
			$db->query($fridgequery);
			$db->query($interestsquery);
			$db->query($relationshipquery);
			$db->query($defaultpicturequery);
			
			$tmp=$db->getresult();
				foreach($tmp as $key => $value){
					if(!is_array($value)){
						$mainprofile[$key]=$value;
					}else{
						foreach($value as $key2 => $value2){
							$mainprofile[$key2][$key]=$value2;
						}
					}
				}
				
			if($mainprofile['activeaccount']<=0)
				return FALSE;
				
			if(strlen($mainprofile['defaultpicture'])<1){
					$mainprofile['searchnail']="http://beta.thefacebook.us/photos/8334427_9823838_87100968_s.gif";
					$mainprofile['thumbnail']="http://beta.thefacebook.us/photos/8334427_9823838_87100968_s.gif";	
					$mainprofile['defaultpicture']="http://beta.thefacebook.us/photos/8334427_9823838_87100968_n.gif";					
				}else{ //https://graph.facebook.com/shaverm/picture?type=small
					$mainprofile['searchnail']="https://graph.facebook.com/".$userid."/picture?type=small";
					$mainprofile['thumbnail']="https://graph.facebook.com/".$userid."/picture?type=normal";
					$mainprofile['defaultpicture']="https://graph.facebook.com/".$userid."/picture?type=large";

				}
			
			$mainprofile['lastupdate']=$this->get_lastupdate($userid);
			
			$this->profile=$mainprofile;

			//$this->displayall();
			//echo "<img src='".$this->retrieve('defaultpicture')."'>";
		
	return(TRUE);
	}
	
	
	public function save($data){
	global $db;
		$db3 = new Database();						
		$db3->connect();
	
		$userid=$this->session_id();
		$dtime=date('Y-m-d H:i:s');
		
		$query="insert into `profileupdates` (`id`, `userid`, `timestamp`) VALUES (NULL, '$userid', '$dtime');";
		
		//print_r($data);
		//status,sex,residence,birthday,hometown,highschool,screenname,mobile,websites,lookingfor(array),interestedin(array),political,interests,music
		
		foreach ($data as $field => $fieldvalue){
			switch($field){
				case "picture":
				/*
					$acceptedfiles=array("jpg","jpeg","gif","png");
					$fileext=end(explode(".",basename( $fieldvalue['name'])));
					
					if(!in_array(strtolower($fileext),$acceptedfiles))
						return false;
					

					$target_path = $_SERVER["DOCUMENT_ROOT"]."/photos/";
					$full_target_path = $target_path . basename( $fieldvalue['name']);
					//echo $full_target_path; die; 
					if(!move_uploaded_file($fieldvalue['tmp_name'], $full_target_path)) {
						return false;
					}
					
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
					
					
					
					//NORMAL
					$pic = new Thumbnail();
					$pic->filename=$full_target_path; 
					$pic->filename2=$target_path.$firstsubset."_".$secondsubset."_".$thirdsubset."_n.jpg"; 
					$pic->maxW=170; 
					$pic->maxH=400;
					$pic->Text=""; 
					$pic->SetNewWH(); 
					$pic->MakeNew(); 
					$pic->FinirPImage(); 
					
					
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
					
					
					$this->pictureupdate($firstsubset."_".$secondsubset."_".$thirdsubset);
					unlink($full_target_path);
					*/
					return false;
				break;
				case "status":
					$this->regularupdate("schoolstatusid", $fieldvalue);
				break;
				case "sex":
					$this->regularupdate("sexid", $fieldvalue);
				break;
				case "residence":
					$id=$this->getid("residence", $fieldvalue);
					$this->regularupdate("residenceid",$id);
				break;
				case "birthday":
					$bday=date('Y-m-d', strtotime($fieldvalue));
					$this->regularupdate("birthday", $bday);
				break;
				case "email":
					$this->regularupdate("email", $fieldvalue);
				break;
				case "hometown":
					$this->regularupdate("hometown", $fieldvalue);
				break;
				case "highschool":
					$id=$this->getid("highschool", $fieldvalue);
					$this->regularupdate("highschoolid",$id);
				break;
				case "screenname":
					$id=$this->getid("screenname", $fieldvalue);
					$this->regularupdate("screennameid",$id);
				break;
				case "mobile":
					$this->regularupdate("phone", $fieldvalue);
				break;
				case "websites":
					$this->regularupdate("websites", $fieldvalue);
				break;
				case "lookingfor":
					$this->clearlinks("lookingforlink");
					foreach($fieldvalue as $lfid){
						if($lfid>0){
							$this->specialupdate("lookingforlink","lookingforid",$lfid);
						}
					}
				break;
				case "interestedin":
					$this->clearlinks("interestedinlink");
					foreach($fieldvalue as $lfid){
						if($lfid>0){
							$this->specialupdate("interestedinlink","interestedinid",$lfid);
						}
					}
				break;
				case "political":
					$this->regularupdate("politicalid", $fieldvalue);
				break;
				case "interests":
					$fieldvalue=str_replace("\n",",",$fieldvalue);
					$fixspacing=str_replace(", ",",",$fieldvalue);
					$dataarray=explode(",",$fixspacing);
					$this->clearlinks("interestslink");
					foreach($dataarray as $interest){
						$interest=trim($interest);
						if(strlen($interest)>0){
							$fid=$this->getid("interests", $interest);
							$this->specialupdate("interestslink","interestsid",$fid);
						}
					}
				
				break;
				case "music":
					$fieldvalue=str_replace("\n",",",$fieldvalue);
					$fixspacing=str_replace(", ",",",$fieldvalue);
					$dataarray=explode(",",$fixspacing);
					$this->clearlinks("musiclink");
					foreach($dataarray as $artist){
						$artist=trim($artist);
						if(strlen($artist)>0){
							$fid=$this->getid("music", $artist);
							$this->specialupdate("musiclink","musicid",$fid);
						}
					}
				break;
				case "classes":
					$fieldvalue=str_replace("\n",",",$fieldvalue);
					$fixspacing=str_replace(", ",",",$fieldvalue);
					$dataarray=explode(",",$fixspacing);
					$this->clearlinks("classlink");
					foreach($dataarray as $artist){
						$artist=trim($artist);
						if(strlen($artist)>0){
							$fid=$this->getid("class", $artist);
							$this->specialupdate("classlink","classid",$fid);
						}
					}
				break;
				case "fridge":
					$fieldvalue=str_replace("\n",",",$fieldvalue);
					$fixspacing=str_replace(", ",",",$fieldvalue);
					$dataarray=explode(",",$fixspacing);
					$this->clearlinks("fridgelink");
					foreach($dataarray as $artist){
						$artist=trim($artist);
						if(strlen($artist)>0){
							$fid=$this->getid("fridge", $artist);
							$this->specialupdate("fridgelink","fridgeid",$fid);
						}
					}
				break;
			}
			
		}
		
		
		if($db3->query($query))
			return(true);
		
		
		return(false);
	}
	
	
		public function search($data, $page = 0, $resultsperpage = 20){
			global $db;
			$userid=$this->session_id();
			$dtime=date('Y-m-d H:i:s');
			$resultstart=$page*$resultsperpage;	
			
			
			//print_r($data);
			//status,sex,residence,birthday,hometown,highschool,screenname,mobile,websites,lookingfor(array),interestedin(array),political,interests,music
			
			foreach ($data as $field => $fieldvalue){
				switch($field){
					case "id":
						$results=$this->regularsearch("id",$fieldvalue, $resultstart, $resultsperpage);
					break;
					case "name":
						$results=$this->regularwildsearch("name",$fieldvalue, $resultstart, $resultsperpage);
						//print_r($results);die;
					break;
					case "status":
						$id=$this->searchgetid("schoolstatus", $fieldvalue);
						$results=$this->regularsearch("schoolstatusid", $id, $resultstart, $resultsperpage);
					break;
					case "sex":
						$id=$this->searchgetstrictid("sex", $fieldvalue);
						$results=$this->regularsearch("sexid", $id, $resultstart, $resultsperpage);
					break;
					case "residence":
						$id=$this->searchgetid("residence", $fieldvalue);
						$results=$this->regularsearch("residenceid",$id, $resultstart, $resultsperpage);
					break;
					case "birthday":
						$bday=date('Y-m-d', strtotime($fieldvalue));
						$results=$this->regularsearch("birthday", $bday, $resultstart, $resultsperpage);
					break;
					case "hometown":
						$results=$this->regularsearch("hometown", $fieldvalue, $resultstart, $resultsperpage);
					break;
					case "highschool":
						$id=$this->searchgetid("highschool", $fieldvalue);
						$results=$this->regularsearch("highschoolid",$id, $resultstart, $resultsperpage);
					break;
					case "school":
						$id=$this->searchgetstrictid("school", $fieldvalue);
						$results=$this->regularsearch("schoolid",$id, $resultstart, $resultsperpage);
					break;
					case "screenname":
						$id=$this->searchgetid("screenname", $fieldvalue);
						$results=$this->regularsearch("screennameid",$id, $resultstart, $resultsperpage);
					break;
					case "mobile":
						$results=$this->regularsearch("phone", $fieldvalue, $resultstart, $resultsperpage);
					break;
					case "websites":
						$results=$this->regularsearch("websites", $fieldvalue, $resultstart, $resultsperpage);
					break;
					case "lookingfor":
						$id=$this->searchgetstrictid("lookingfor", $fieldvalue);	
						$results=$this->specialsearch("lookingforlink", "lookingforid", $id, $resultstart, $resultsperpage);	
					break;
					case "interestedin":
						$id=$this->searchgetstrictid("interestedin", $fieldvalue);	
						$results=$this->specialsearch("interestedinlink", "interestedinid", $id, $resultstart, $resultsperpage);
					break;
					case "political":
						$id=$this->searchgetstrictid("political", $fieldvalue);
						$results=$this->regularsearch("politicalid", $id, $resultstart, $resultsperpage);
					break;
					case "interests":
						$id=$this->searchgetid("interests", $fieldvalue);	
						$results=$this->specialsearch("interestslink", "interestsid", $id, $resultstart, $resultsperpage);
					break;
					case "music":
						$id=$this->searchgetid("music", $fieldvalue);	
						$results=$this->specialsearch("musiclink", "musicid", $id, $resultstart, $resultsperpage);
					break;
					case "class":
						$id=$this->searchgetid("class", $fieldvalue);	
						$results=$this->specialsearch("classlink", "classid", $id, $resultstart, $resultsperpage);
					break;
					case "fridge":
						$id=$this->searchgetid("fridge", $fieldvalue);	
						$results=$this->specialfriendsearch("fridgelink", "fridgeid", $id, $resultstart, $resultsperpage);
					break;
					case "mfriends":
						$results=$this->searchmutualfriends($fieldvalue, $resultstart, $resultsperpage); 
					break;
				}
				
			}
			
			//print_r($results);
			
		
		//$friendslist=Relationship::user_friends($uid,$resultstart, $resultsperpage);
		$friendsdata=$this->get_userinfo($results);

		foreach($friendsdata as $random => $data){
			if($data){
				$presults[$random]=$data;
				//if($presults[$random]['activeaccount']==1) $this->savefbpic($presults[$random]['id']); 
				
					$presults[$random]['searchn']="https://graph.facebook.com/".$presults[$random]['id']."/picture?type=normal";
					$presults[$random]['thumb']="https://graph.facebook.com/".$presults[$random]['id']."/picture?type=small";

			}
		}
		//print_r($presults);die;
		return($presults);
			

	}
	
	private function savefbpic($userid){
	/*
		$defaultpicture="http://graph.facebook.com/".$userid."/picture?type=large";
					$contents= file_get_contents($defaultpicture);
					$target_path = $_SERVER["DOCUMENT_ROOT"]."/photos/";					
					
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
					
					$setpicture="insert into `picture` (`userid`, `albumid`, `link`) VALUES ('".$userid."', '0', '".$firstsubset."_".$secondsubset."_".$thirdsubset."');";
					$db = new Database();																		
					$db->connect();
					$db->query($setpicture);
	*/
		return( true );
	}
	
	
	private function getid($table,$fname){
		$db2 = new Database();						
		$db2->connect();
		
		$rid=0;
		$qr="";
		$ar="";
		
		$qr="name='".$fname."'";
		$db2->select($table,'id',$qr);
		$ret=$db2->getresult();
		$rid=$ret['id'];
	
		if($rid<1){
			$ar= "insert into ".$table." (`name`) VALUES('".$fname."')";
			$db2->query($ar);
			$rid=$db2->getinsertedrow();
		}
		
	return($rid);
	}
	
	
	private function searchgetid($table,$fname){
		$db2 = new Database();						
		$db2->connect();
		
		$rid="";
		$qr="";
		$ar="";
		
		$qr="LOWER(name) LIKE '%".strtolower($fname)."%'";
		$db2->select($table,'id',$qr);
		$ret=$db2->getresult();
		

		
		if($ret[0]['id']>0){
			foreach($ret as $rdata){
				$rid .= $rdata['id'];
				if(!next($ret)===FALSE) 
					$rid .= ",";
			}
		}else{
			$rid=$ret['id'];
		}

	return($rid);
	}
	
	private function searchgetstrictid($table,$fname){
		$db2 = new Database();						
		$db2->connect();
		
		$rid="";
		$qr="";
		$ar="";
		
		$qr="LOWER(name) LIKE '".strtolower($fname)."'";
		$db2->select($table,'id',$qr);
		$ret=$db2->getresult();
		

		
		if($ret[0]['id']>0){
			foreach($ret as $rdata){
				$rid .= $rdata['id'];
				if(!next($ret)===FALSE) 
					$rid .= ",";
			}
		}else{
			$rid=$ret['id'];
		}

	return($rid);
	}
	
	private function get_name($table,$fname){
		$db2 = new Database();						
		$db2->connect();
		
		$rid="";
		$qr="";
		$ar="";
		
		$qr="id='".$fname."'";
		$db2->select($table,'name',$qr);
		$ret=$db2->getresult();
		

		
		if($ret[0]['name']>0){
			foreach($ret as $rdata){
				$rid .= $rdata['id'];
				if(!next($ret)===FALSE) 
					$rid .= ",";
			}
		}else{
			$rid=$ret['name'];
		}

	return($rid);
	}
	
	private function regularupdate($fieldname, $fieldvalue){
		global $db;
		$userid=$this->userid;
		$dtime=date('Y-m-d H:i:s');
		$dupdate="update `user` set `".$fieldname."`='".$fieldvalue."' where `id`='".$userid."'";
		$db->query($dupdate);
	}
	
	private function regularsearch($fieldname, $fieldvalue, $startresult = 0, $totalresults = 20){
		$userid=$this->userid;
		$db = new Database();						
		$db->connect();
		$dtime=date('Y-m-d H:i:s');
		$dsearch="
				select distinct SQL_CALC_FOUND_ROWS id
				from `user` 
				where `".$fieldname."`='".$fieldvalue."'
				and accountstatusid>0
				";
				if($this->userid!=3) $dsearch .= " and schoolid='".$this->schoolid."' ";
				$dsearch .= "
				order by id desc
				LIMIT ".$startresult.", ".$totalresults
				
				;
		$db->query($dsearch);
		$tmp=$db->getresult();
		
		if($tmp[0]['id']<1){
			$tmp2[0]['id']=$tmp['id'];
			}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['id'];	
		}
		
		
		$this->set_totalrows($db->getTotalRows());
		return($farray);;
	}
	
	private function searchmutualfriends($id, $startresult = 0, $totalresult = 20){
		$relation=new Relationship();
		$their_friends=$relation->user_friends($id,0, 5000);
		$my_friends=$relation->my_friends();
		$presults=array_intersect($my_friends, $their_friends);
		$this->set_totalrows(count($presults));
		foreach($presults as $uids){
			$preresults[] = $uids;
		}
		
		for($prime=$startresult;$prime<$totalresult;$prime++){
			if($preresults[$prime]>0)
			$results[]=$preresults[$prime];
		}
		//print_r($results);
		return($results);
		
	}
	
	private function specialsearch($table, $fieldid, $fieldvalue, $startresult = 0, $totalresults = 20){
		$userid=$this->userid;
		$db = new Database();						
		$db->connect();
		$dtime=date('Y-m-d H:i:s');
		$dsearch="
				select distinct SQL_CALC_FOUND_ROWS userid as id
				from `".$table."` t
				join `user` u on u.id=t.userid
				where t.`".$fieldid."` IN (".$fieldvalue.")
				and u.accountstatusid>0
				";
				if($this->userid!=3) $dsearch .= " and u.schoolid='".$this->schoolid."' ";
				$dsearch .= "order by u.id desc
				LIMIT ".$startresult.", ".$totalresults
				
				;
		$db->query($dsearch);
		$tmp=$db->getresult();
		
		if($tmp[0]['id']<1){
			$tmp2[0]['id']=$tmp['id'];
			}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['id'];	
		}
		
		
		$this->set_totalrows($db->getTotalRows());
		return($farray);
	}
	
	private function specialfriendsearch($table, $fieldid, $fieldvalue, $startresult = 0, $totalresults = 20){
		$userid=$this->userid;
		$friends=$this->friendsids($userid,0,999999);
		$friendsi=implode(",",$friends);
		$db = new Database();						
		$db->connect();
		$dtime=date('Y-m-d H:i:s');
		$dsearch="
				select distinct SQL_CALC_FOUND_ROWS userid as id
				from `".$table."` t
				join `user` u on u.id=t.userid
				where t.`".$fieldid."` IN (".$fieldvalue.")
				and u.id IN (".$friendsi.") 
				and u.accountstatusid>0
				and u.schoolid='".$this->schoolid."'
				order by u.id desc
				LIMIT ".$startresult.", ".$totalresults
				
				;
				
		$db->query($dsearch);
		$tmp=$db->getresult();
		
		if($tmp[0]['id']<1){
			$tmp2[0]['id']=$tmp['id'];
			}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['id'];	
		}
		
		
		$this->set_totalrows($db->getTotalRows());
		return($farray);
	}
	
	private function regularwildsearch($fieldname, $fieldvalue, $startresult = 0, $totalresults = 20){
		$userid=$this->userid;
		$db = new Database();						
		$db->connect();
		$dtime=date('Y-m-d H:i:s');

		$db->select('user','distinct SQL_CALC_FOUND_ROWS id',"`".$fieldname."` LIKE '%".$fieldvalue."%' and `accountstatusid`>0 and `schoolid`='".$this->schoolid."'","id DESC",NULL,$startresult.', '.$totalresults);
		$tmp=$db->getresult();
		//print_r($tmp);die;
		if(empty($tmp[0]['id'])){
			$tmp2[0]['id']=$tmp['id'];
			}else { $tmp2=$tmp; }

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[]=$frienddata['id'];	
		}
		
		//print_r($farray);die;
		$this->set_totalrows($db->getTotalRows());
		//print_r($farray);die;
		return($farray);
	}
	
	private function pictureupdate($link){
		global $db;
		$userid=$this->userid;
		$dupdate="insert into `picture` (`userid`, `albumid`, `link`) VALUES ('".$userid."', '0', '".$link."');";
		$db->query($dupdate);
	}
	
	private function specialupdate($table, $fieldid, $fieldvalue){
		global $db;
		$userid=$this->userid;
		$dupdate="insert into `".$table."` (`userid`, `".$fieldid."`) VALUES ('".$userid."', '".$fieldvalue."');";
		$db->query($dupdate);
	}
	
	private function clearlinks($table){
		global $db;
		$userid=$this->userid;
		$dupdate="delete from  `".$table."` where `userid`='".$userid."'";
		$db->query($dupdate);
	}
	
	
	public function displayall(){
		foreach($this->profile as $key => $field){
			echo " [$key] > ";
			print_r($field);
			echo "<br>";
		}
	}

	

	public function retrieve($field){
		//name
		//school
		//lastupdate
		//school
		//status
		//sex
		//residence
		//birthday
		//hometown
		//highschool
		//email
		//screenname
		//mobile
		//website
		//lookingfor
		//interestedin
		//relationshipstatus
		//political
		//interests
		//music
		//defaultpicture
		//connectiontoyou
		$info=$this->profile[$field];
		
	return($info);
	}
	
	public function retrieveall(){
		$info=$this->profile;
	return($info);
	}
	
	public function viewable_profile($uid){
		if($uid==4) return("Master and Commander");

		
		$sess=new SessionData('account');
		$id=$sess->Retrieve('id');
		
		if($id==$uid)
			return("This is you.");
		
		$relation=new Relationship();
		$their_friends=$relation->user_friends($uid,0, 5000);
		$my_friends=$relation->my_friends();
		
		$connections=count(array_intersect($my_friends, $their_friends)); 
		
		
		$retvalue=$relation->find_connection($uid);
		if($retvalue){
			$retvalue .= "<br>You have <a href='search.php?mfriends=$uid&hide=y'>".$connections." friend";
			if($connections!=1) $retvalue .="s";
			$retvalue .="</a> in common.";
			return($retvalue);
		}
		
		
		
		if($connections>0){
			$retvalue = "This is a friend of a friend.<br>You have <a href='search.php?mfriends=$uid&hide=y'>".$connections." friend";
			if($connections!=1) $retvalue .="s";
			$retvalue .="</a> in common.";
			return( $retvalue );
			}
		

		
		$pendingrequest=$relation->pending_requests();
		if(in_array($uid,$pendingrequest)){
			$retvalue = "Pending Request.<br>You have <a href='search.php?mfriends=$uid&hide=y'>".$connections." friend";
			if($connections!=1) $retvalue .="s";
			$retvalue .="</a> in common.";
			return( $retvalue );
		}
		
		
		return FALSE;
	}
	
  
	
	
	public function deactivate(){
		$userid=$this->session_id();
		$db = new Database();						
		$db->connect();
		$query="update user set accountstatusid='-1' where id='".$userid."' limit 1";
		$db->query($query);
	}
	
	public function activate(){
		$userid=$this->session_id();
		$db = new Database();						
		$db->connect();
		$query="update user set accountstatusid='2' where id='".$userid."' limit 1";
		$db->query($query);
	}
	
	public function newsletteractivate(){
		$userid=$this->session_id();
		$db = new Database();						
		$db->connect();
		$query="update user set newsletter='1' where id='".$userid."' limit 1";
		$db->query($query);
	}
	
	public function newsletterdeactivate(){
		$userid=$this->session_id();
		$db = new Database();						
		$db->connect();
		$query="update user set newsletter='0' where id='".$userid."' limit 1";
		$db->query($query);
	}
	
	public function updatepassword($old, $new, $confirm){
		if($new!=$confirm) return -1;
		$userid=$this->session_id();
		$db = new Database();						
		$db->connect();
		$query="select password from user where id='".$userid."' limit 1";
		$db->query($query);
		$tmp=$db->getResult();
		if($tmp['password']!=md5($old)) return -1;
		$db2 = new Database();						
		$db2->connect();
		$new=md5($new);
		$query2="update user set password='".$new."' where id='".$userid."' limit 1";
		$db2->query($query2);
		return 1;
	}
	
	
	
	
	public function commonfriends($uid){
	
	
	}
	
	public function connection($id){
	
	return($info);
	}
	
	public function random6($uid){
	
	
		$db = new Database();						
		$db->connect();
		//$id=$this->userid;
		
		
					$relationshipquery="
					select r.senderid as sender, s.name as sendername,  
					r.receiverid as receiver, rc.name as receivername
					from relationship r
					left join relationshiptype rt on r.realtionshiptypeid=rt.id
					join user s on s.id=r.senderid 
					join user rc on rc.id=r.receiverid
					where (r.senderid ='".$uid."' or r.receiverid='".$uid."')
					and r.confirmed=1
					and r.realtionshiptypeid>0
					and s.accountstatusid>0
					and rc.accountstatusid>0
					order by rand()
					limit 6
					";
		
		$db->query($relationshipquery);		
		$tmp=$db->getresult();
			
		$random6=array();
		if($tmp[0]['sender']>0){
			foreach($tmp as $numb => $relationship){
				if($relationship['sender']==$uid){
					$random6[$numb]['id']=$relationship['receiver'];
					$random6[$numb]['name']=$relationship['receivername'];
				}else{
					$random6[$numb]['id']=$relationship['sender'];
					$random6[$numb]['name']=$relationship['sendername'];
				}
			}
		}else{
			if($tmp['sender']==$uid){
					$random6[0]['id']=$tmp['receiver'];
					$random6[0]['name']=$tmp['receivername'];
				}else{
					$random6[0]['id']=$tmp['sender'];
					$random6[0]['name']=$tmp['sendername'];
				}
		}
		

		foreach($random6 as $random => $data){
			$random6[$random]=$data;
			$random6[$random]['thumb']=$this->get_thumbnail($random6[$random]['id']);
		}
		
		return($random6); 
	
	}
	
	public function friendsids($uid, $page = 0, $resultsperpage = 20){
		$resultstart=$page*$resultsperpage;	
		$friendslist=array();
		$friendslist=Relationship::user_friends($uid,$resultstart, $resultsperpage);
		return($friendslist);
	
	}
	
	
	public function friends($uid, $page = 0, $resultsperpage = 20, $orderby = 'friend', $orderdirection = 'DESC'){
		$resultstart=$page*$resultsperpage;	
		$friendslist=array();
		$friendslist=Relationship::user_friends($uid,$resultstart, $resultsperpage, $orderby, $orderdirection);
		//print_r($friendslist); die;
		$friendsdata=$this->get_userinfo($friendslist, $orderby);

		
		if($friendslist[0]<1) return;
		
		foreach($friendsdata as $random => $data){
			$frienddisplay[$random]=$data;
			$frienddisplay[$random]['searchn']=$this->get_searchnail($frienddisplay[$random]['id']);
			$frienddisplay[$random]['thumb']=$this->get_thumbnail($frienddisplay[$random]['id']);
		}
		//print_r($frienddisplay);
		return($frienddisplay);
	
	}
	
	public function mutual_friends($uid, $page = 0, $resultsperpage = 20){
		$resultstart=$page*$resultsperpage;	
		//$friendslist=Relationship::user_mutualfriends($uid,$resultstart, $resultsperpage, $orderby, $orderdirection);
		//jb
		if($friendslist[0]<1) return;
		
		$friendsdata=$this->get_userinfo($friendslist, $orderby);

		foreach($friendsdata as $random => $data){
			$frienddisplay[$random]=$data;
			$frienddisplay[$random]['searchn']=$this->get_searchnail($frienddisplay[$random]['id']);
			$frienddisplay[$random]['thumb']=$this->get_thumbnail($frienddisplay[$random]['id']);
		}
		//print_r($frienddisplay);
		return($frienddisplay);
	
	}
	
	
	public function network($uid, $page = 0, $resultsperpage = 20){
		$resultstart=$page*$resultsperpage;				
		$friendslist=Relationship::network_friends($uid,$resultstart, $resultsperpage);
		
		if($friendslist[0]<1) return;
		$friendsdata=$this->get_userinfo($friendslist);

		foreach($friendsdata as $random => $data){
			$frienddisplay[$random]=$data;
			$frienddisplay[$random]['searchn']=$this->get_searchnail($frienddisplay[$random]['id']);
			$frienddisplay[$random]['thumb']=$this->get_thumbnail($frienddisplay[$random]['id']);
		}
		//print_r($frienddisplay);
		return($frienddisplay);
	
	}
	
	public function networkcount($uid, $page = 0, $resultsperpage = 20){
		$resultstart=$page*$resultsperpage;				
		$friendslist=Relationship::network_friends($uid,$resultstart, $resultsperpage);
		if($friendslist[0]<1) return(0);
		
		$totforreturn=count($friendslist);
		return($totforreturn);
	
	}
	
	
	public function personalnetwork($uid, $page = 0, $resultsperpage = 20){
		$resultstart=$page*$resultsperpage;				
		$friendslist=Relationship::network_personal($uid,$resultstart, $resultsperpage);

		if($friendslist[0]<1) return;
		
		$friendsdata=$this->get_userinfo($friendslist);

		foreach($friendsdata as $random => $data){
			$frienddisplay[$random]=$data;
			$frienddisplay[$random]['searchn']=$this->get_searchnail($frienddisplay[$random]['id']);
			$frienddisplay[$random]['thumb']=$this->get_thumbnail($frienddisplay[$random]['id']);
		}
		//print_r($frienddisplay);
		return($frienddisplay);
	
	}
	

	
	public function classesnetwork($uid, $page = 0, $resultsperpage = 20){
		$resultstart=$page*$resultsperpage;				
		$friendslist=Relationship::network_classes($uid,$resultstart, $resultsperpage);

		if($friendslist[0]<1) return;
		
		$friendsdata=$this->get_userinfo($friendslist);

		foreach($friendsdata as $random => $data){
			$frienddisplay[$random]=$data;
			$frienddisplay[$random]['searchn']=$this->get_searchnail($frienddisplay[$random]['id']);
			$frienddisplay[$random]['thumb']=$this->get_thumbnail($frienddisplay[$random]['id']);
		}
		//print_r($frienddisplay);
		return($frienddisplay);
	
	}
	
	public function classesnetworkcount($uid, $page = 0, $resultsperpage = 20){
		$resultstart=$page*$resultsperpage;				
		$friendslist=Relationship::network_classes($uid,$resultstart, $resultsperpage);
		if($friendslist[0]<1) return(0);
		
		
		$totforreturn=count($friendslist);
		return($totforreturn);
	
	}
	
	public function set_totalrows($rows){
		$this->totalentries=$rows;
	}
	
	public function get_totalrows(){
		return $this->totalentries;
	}
	
	public function get_userinfo($userids, $order = 'p`.`id'){
		$db = new Database();						
		$db->connect();
		
		if($order=='friend') $order='p`.`id';
		
		if(is_array($userids))
			$userids=implode(",",$userids);
			
		//print_r($userids);die;

			$mainquery="
				select p.id as id, p.name as name, p.registerdate as registerdate,
				s.name as school, ss.name as status, sx.name as sex, r.name as residence, 
				p.birthday as birthday, p.hometown as hometown, h.name as highschool, p.email as email,
				sn.name as screenname, p.phone as mobile, p.websites as website, 
				pu.last as lastupdate, log.last as lastactive,
				pol.name as political, p.accountstatusid as activeaccount
				from user p 
				left outer join school s on p.schoolid=s.id
				left outer join schoolstatus ss on p.schoolstatusid=ss.id
				left outer join sex sx on p.sexid=sx.id
				left outer join residence r on p.residenceid=r.id
				left outer join highschool h on p.highschoolid=h.id
				left outer join screenname sn on p.screennameid=sn.id
				left outer join political pol on p.politicalid=pol.id	
				left outer join `lastupdate` pu on pu.userid=p.id
				left outer join `lastactivity` log on log.userid=p.id
					
				where p.id IN (".$userids.")
				and p.accountstatusid>0
				order by `".$order."` desc
				";
				
			
			//echo $mainquery;
			
			$db->query($mainquery);
			$tmp=$db->getresult();
			
			//print_r($tmp); die;
			
		if(empty($tmp[0]['id'])){
			$usersdata[0]=$tmp;
			}else{
			$usersdata=$tmp;
			}			
		return($usersdata);
			
						
	}
	
	public function get_thumbnail($uid){
		return("https://graph.facebook.com/".$uid."/picture?type=normal");
				
	}
	
	public function get_searchnail($uid){
		return("https://graph.facebook.com/".$uid."/picture?width=50&height=75");
				
				
	}
	
	public function get_lastupdate($uid){
		$db = new Database();						
		$db->connect();
		$lastupdatequery="
					select p.timestamp as last
					from profileupdates p
					where p.userid='".$uid."'
					order by p.timestamp desc
					limit 1
					";
				//echo $lastupdatequery;
				$db->query($lastupdatequery);
				//$db->select('profileupdates','`dtime` as lastupdate, count(`id`) as updates',"userid='".$uid."'",'dtime DESC');
				$tmp=$db->getresult();
				//print_r($tmp);
		return($tmp['last']);
			
	}
	
	public function make_clickable($text) 
	{ 
		$text = str_replace("\n","<br>\n",$text);
		$ret = ' ' . $text;
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" target=\"_new\" >\\2</a>'", $ret);
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" target=\"_new\">\\2</a>'", $ret);
		$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
		$ret = substr($ret, 1);
		return($ret);
	} 
	
	
	

}

?>