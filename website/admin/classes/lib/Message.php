<?PHP

class Message{

	function __construct($uid=0){
		if($uid<1){
			$uid=$this->session_id();
		}

	 //$this->set($uid);
	}
	
	private function session_id(){
		$userid=$this->userid;
			$sess = new SessionData('account');
			$userid=$sess->Retrieve('id');
			$this->userid=$userid;
			$this->schoolid=$sess->Retrieve('schoolid');
		
		return($userid);
	}

	public function send($to, $subject, $message){
		$db = new Database();						
		$db->connect();
		
		$from=$this->userid;
		$today=date('Y-m-d H:i:s');
		
		$query="insert into message 
		(`id`, `senderid`, `receiverid`, `messagestatusid`, `subject`, `text`, `timestamp`) 
		VALUES 
		(NULL, '".$from."','".$to."','1','".$subject."','".$message."','".$today."')";
		$db->query($query);
		
		$body="<font face=arial size=2>".$this->getname('user',$from)." has sent you a new message!<br><br>Please login at <a href='http://www.harvardconnection.co'>http://www.harvardconnection.co</a> to view the message.<br><br>Thanks,<br>The Harvardconnection Team";
		email::sendinfo($this->getemail($to),'New Message',$body); 
		
	return;
	}
	
	public function getname($table,$id){
	
		$db2 = new Database();						
		$db2->connect();
		
		$rid=0;
		$qr="";
		$ar="";
		
		$qr="id='".$id."'";
		$db2->select($table,'name',$qr);
		$ret=$db2->getresult();
		$rid=$ret['name'];
	
		
	return($rid);
	
	}
	
	public function getemail($id){
	
		$db2 = new Database();						
		$db2->connect();
		$table="user";
		$rid=0;
		$qr="";
		$ar="";
		
		$qr="id='".$id."'";
		$db2->select($table,'email',$qr);
		$ret=$db2->getresult();
		$rid=$ret['email'];
	
		
	return($rid);
	
	}
	

	
	public function delete($messageid){
	
	return($info);
	}
	
	public function viewunread($type=0, $startresults = 0, $totalresults= 10000){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		if($type=='unread') $type=1;
		
					$inboxquery="
					select distinct SQL_CALC_FOUND_ROWS
					r.senderid as sender
					from message r
					join user u on u.id=r.senderid
					WHERE r.receiverid = '".$id."'
					and u.accountstatusid>1";
					
					if($type>0) $inboxquery .= " and `messagestatusid`=1 ";
					
					$inboxquery .= "order by r.id DESC
					limit ".$startresults.", ".$totalresults."
					";
					//echo $relationshipquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();
		
		if($tmp[0]['sender']<1){
			$tmp2[0]['sender']=$tmp['sender'];
		}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['sender'];	
		}

		return ($farray); 
		

	}
	
	public function viewinbox($startresults = 0, $totalresults= 10000){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		
					$inboxquery="
					select distinct SQL_CALC_FOUND_ROWS
					r.senderid as sender
					from message r
					join user u on u.id=r.senderid
					WHERE r.receiverid = '".$id."'
					and u.accountstatusid>1
					order by r.id DESC
					limit ".$startresults.", ".$totalresults."
					";
					//echo $relationshipquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();
		
		if($tmp[0]['sender']<1){
			$tmp2[0]['sender']=$tmp['sender'];
		}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['sender'];	
		}

		return ($farray); 
		

	}
	
	
	public function viewsentbox($startresults = 0, $totalresults= 10000){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		
					$inboxquery="
					(select distinct SQL_CALC_FOUND_ROWS
					r.receiverid as receiver
					from message r
					join user u on u.id=r.senderid
					WHERE r.senderid = '".$id."'
					and u.accountstatusid>1)
					order by r.id DESC
					limit ".$startresults.", ".$totalresults."
					";
					//echo $relationshipquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();
		
		if($tmp[0]['receiver']<1){
			$tmp2[0]['receiver']=$tmp['receiver'];
		}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['receiver'];	
		}

		return ($farray);
		

	}
	
	public function messagecenter($startresults = 0, $totalresults= 10000){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		
					$inboxquery="
					select distinct SQL_CALC_FOUND_ROWS
					friend from (
						(select distinct 
						r.senderid as friend, r.timestamp as ts
						from message r
						join user u on u.id=r.senderid
						WHERE r.receiverid = '".$id."'
						and u.accountstatusid>1
						)
						UNION
						(select distinct 
						r.receiverid as friend, r.timestamp as ts
						from message r
						join user u on u.id=r.receiverid
						WHERE r.senderid = '".$id."'
						and u.accountstatusid>1
						)
						order by ts desc
					) as getmsgs
					limit ".$startresults.", ".$totalresults."
					";
					
					//echo $inboxquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();
		
		//print_r($tmp);
		
		if($tmp[0]['friend']<1){
			$tmp2[0]['friend']=$tmp['friend'];
		}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['friend'];	
		}

		return ($farray);
		
	}
	
	public function get_messagecount($uid, $type = ''){
	
	$db = new Database();						
		$db->connect();
		$id=$this->userid;
		
		if($type=='unread') $type=1;
		
					$inboxquery="
					select
					count(r.id) as messages
					from message r
					join user u on u.id=r.senderid
					join user ur on ur.id=r.receiverid
					WHERE ((r.receiverid = '".$id."'";
					if($uid>0) $inboxquery .= " and r.senderid = '".$uid."'";
					$inboxquery .=")
					or
					(";
					if($type!=1)
						$inboxquery .= "r.receiverid = '".$uid."' and r.senderid = '".$id."'";
					else
						$inboxquery .= "1=2";
					$inboxquery .="))
					and u.accountstatusid>1
					and ur.accountstatusid>1
					";
					if($type)
					$inboxquery .= "and r.messagestatusid='".$type."'";
					
					//echo $inboxquery."<br><br>";
		$db->query($inboxquery);		
		$tmp=$db->getresult();

		return ($tmp['messages']);
	
	}
	
	public function get_lastsubject($uid, $type = 'both'){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		
	
		
					$inboxquery="
					select
					subject as subject
					from message r
					join user u on u.id=r.senderid
					join user ur on ur.id=r.receiverid
					WHERE (";
					
					if($type=='both'||$type=='inbox')
						$inboxquery .= "(r.receiverid = '".$id."' and r.senderid = '".$uid."')";
					else
						$inboxquery .= "(1=2)";
					
					$inboxquery .= " or ";
					
					if($type=='both'||$type=='outbox')
						$inboxquery .= "(r.receiverid = '".$uid."' and r.senderid = '".$id."')";
					else
						$inboxquery .= "(1=2)";
					
					$inboxquery .= ") and u.accountstatusid>1
					and ur.accountstatusid>1
					order by r.id desc
					limit 1
					";
					
					//echo $inboxquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();

		return ($tmp['subject']);
	
	}
	
	
	
	
		public function get_lasttext($uid, $type = 'both'){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		
	
		
					$inboxquery="
					select
					r.text as text
					from message r
					join user u on u.id=r.senderid
					join user ur on ur.id=r.receiverid
					WHERE (";
					
					if($type=='both'||$type=='inbox')
						$inboxquery .= "(r.receiverid = '".$id."' and r.senderid = '".$uid."')";
					else
						$inboxquery .= "(1=2)";
					
					$inboxquery .= " or ";
					
					if($type=='both'||$type=='outbox')
						$inboxquery .= "(r.receiverid = '".$uid."' and r.senderid = '".$id."')";
					else
						$inboxquery .= "(1=2)";
					
					$inboxquery .= ") and u.accountstatusid>1
					and ur.accountstatusid>1
					order by r.id desc
					limit 1
					";
					
					//echo $inboxquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();

		return ($tmp['text']);
	
	}
	
	public function get_lasttime($uid, $type = 'both'){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		
	
		
					$inboxquery="
					select
					r.timestamp as timestamp
					from message r
					join user u on u.id=r.senderid
					join user ur on ur.id=r.receiverid
					WHERE (";
					
					if($type=='both'||$type=='inbox')
						$inboxquery .= "(r.receiverid = '".$id."' and r.senderid = '".$uid."')";
					else
						$inboxquery .= "(1=2)";
					
					$inboxquery .= " or ";
					
					if($type=='both'||$type=='outbox')
						$inboxquery .= "(r.receiverid = '".$uid."' and r.senderid = '".$id."')";
					else
						$inboxquery .= "(1=2)";
					
					$inboxquery .= ") and u.accountstatusid>1
					and ur.accountstatusid>1
					order by r.id desc
					limit 1
					";
					
					//echo $inboxquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();

		return ($tmp['timestamp']);
	
	}
	
	public function get_subject($mid){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		
	
		
					$inboxquery="
					select
					r.subject as subject
					from message r
					where
					r.id='".$mid."'
					limit 1
					";
					
					//echo $inboxquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();

		return ($tmp['subject']);
	
	}
	
	public function get_text($mid){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		
	
		
					$inboxquery="
					select
					r.text as text
					from message r
					where
					r.id='".$mid."'
					limit 1
					";
					
					//echo $inboxquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();

		return ($tmp['text']);
	
	}
	
	public function get_name($uid){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		$query="select name from user where id='".$uid."'";
		$db->query($query);
		
		$tmp=$db->getresult();
		$name=$tmp['name'];
		
	return $name;
	}
	
	public function get_thumb($uid){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		$query="
				select p.link as defaultpicture
				from picture p
				where p.userid='".$uid."'
				and p.albumid=0
				order by p.id desc
				limit 1
				";
		$db->query($query);		
		$tmp=$db->getresult();
		
		
		$thumb=$tmp['defaultpicture'];
		
		if(strlen($thumb)<1){
					$name="http://photos.harvardconnection.co/8334427_9823838_87100968_s.gif";				
				}else{
					$name="http://photos.harvardconnection.co/".$thumb."_t.jpg";
				}
		
	return $name;
	}
	
	public function get_thumb_message($mid){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		$query="
				select p.link as defaultpicture
				from picture p
				join message m on p.userid=m.senderid
				where m.id='".$mid."'
				and p.albumid=0
				order by p.id desc
				limit 1
				";
		$db->query($query);		
		$tmp=$db->getresult();
		
		
		$thumb=$tmp['defaultpicture'];
		
		if(strlen($thumb)<1){
					$name="http://photos.harvardconnection.co/8334427_9823838_87100968_s.gif";				
				}else{
					$name="http://photos.harvardconnection.co/".$thumb."_t.jpg";
				}
		
	return $name;
	}
	
	public function get_name_message($mid){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		$query="select u.name as name from user u join message m on u.id=m.senderid where m.id='".$mid."'";
		$db->query($query);
		
		$tmp=$db->getresult();
		$name=$tmp['name'];
		
	return $name;
	}
	
	
	public function get_userid_message($mid){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		$query="select u.id as name from user u join message m on u.id=m.senderid where m.id='".$mid."'";
		$db->query($query);
		
		$tmp=$db->getresult();
		$name=$tmp['name'];
		
	return $name;
	}
	
	public function get_time($mid){
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		$query="select timestamp as timestamp from message where id='".$mid."'";
		$db->query($query);
		
		$tmp=$db->getresult();
		$name=$tmp['timestamp'];
		
	return $name;
	}



	
	public function viewthread($uid, $type = '', $startresults = 0, $totalresults = 5){ //last 5 to or from that person
		$db = new Database();						
		$db->connect();
		$id=$this->userid;
		if($type=='unread') $type=1;
		$inboxquery="
					select
					r.id as messages
					from message r
					join user u on u.id=r.senderid
					join user ur on ur.id=r.receiverid
					WHERE ((r.receiverid = '".$id."' and r.senderid = '".$uid."')
					or
					(";
					if($type!=1)
						$inboxquery .= "r.receiverid = '".$uid."' and r.senderid = '".$id."'";
					else
						$inboxquery .= "1=2";
					$inboxquery .="))
					and u.accountstatusid>1
					and ur.accountstatusid>1
					";
					if($type)
					$inboxquery .= "and r.messagestatusid='".$type."'";
					
					$inboxquery .= " order by r.id desc";
					
					
					//echo $inboxquery;
		$db->query($inboxquery);		
		$tmp=$db->getresult();
		
		//print_r($tmp);
		
		if($tmp[0]['messages']<1){
			$tmp2[0]['messages']=$tmp['messages'];
		}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['messages'];	
		}

		return ($farray);
	}

	private function report($messageid){
	
	return($info);
	}

		
	public function markread($messageid){
		$db = new Database();						
		$db->connect();
		$messageids=implode(",",$messageid);
		$id=$this->userid;
		
		$query="update message set `messagestatusid`='2' where `receiverid`='".$id."' and `id` IN (".$messageids.")";
		$db->query($query);
		
	return;
	
	}
	
	public function markunread($messageids){
		$db = new Database();						
		$db->connect();
		
		$query="update message set `messagestatusid`='1' where `id` IN (".$messageids.")";
		$db->query($query);
		
	return;
	}

}

?>