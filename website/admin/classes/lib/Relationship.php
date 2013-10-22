<?PHP

class Relationship{

	function __construct(){
	 $this->session_id();
	}
	
	public function user_friends($uid, $startresults = 0, $totalresults = 20, $orderby = "friend", $orderdirection = "DESC", $ignoreusers = 0){
	
		$db = new Database();						
		$db->connect();		
		$sess=new SessionData('account');
		$id=$sess->Retrieve('id');
		if($id==$uid) { // run my_friends now to return more results than just user ids
			$myfriends=Relationship::my_friends($startresults, $totalresults, $orderby, $orderdirection, $ignoreusers);
			return($myfriends); 
		}
 
		
					$relationshipquery="
					(select distinct SQL_CALC_FOUND_ROWS
					r.senderid as friend
					from relationship r
					join user u on u.id=r.senderid
					WHERE r.receiverid IN (".$uid.")
					and r.senderid NOT IN (".$ignoreusers.")
					and r.senderid != '".$id."'
					and r.confirmed=1
					and u.accountstatusid>1)
					UNION
					(select distinct 
					r.receiverid as friend
					from relationship r
					join user u on u.id=r.receiverid
					WHERE r.senderid IN (".$uid.")
					and r.receiverid NOT IN (".$ignoreusers.")
					and r.receiverid != '".$id."'
					and r.confirmed=1
					and u.accountstatusid>1)
					order by ".$orderby." ".$orderdirection."
					limit ".$startresults.", ".$totalresults."
					";
					

		$db->query($relationshipquery);		
		$tmp=$db->getresult();
		
		if($tmp[0]['friend']<1){
			$tmp2[0]['friend']=$tmp['friend'];
			}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['friend'];	
		}
		Profile::set_totalrows($db->getTotalRows());
		
		//if($farray[0]<1) $farray[0]=$id;
		return ($farray); 
	
	}
	
	
	
	public function my_friends($startresults = 0, $totalresults = 20, $orderby = "friend", $orderdirection = "DESC", $ignoreusers = 0){
	
		$db = new Database();						
		$db->connect();		
		$sess=new SessionData('account');
		$id=$sess->Retrieve('id');
		//if($id==$uid) return;
		if($orderby=="lastupdate"||$orderby=="lastactive"){
		
		//this is slow need to make faster
					$relationshipquery="
					(select distinct SQL_CALC_FOUND_ROWS
					r.senderid as friend, lu.last as lastupdate, la.last as lastactive
					from relationship r
					join user u on u.id=r.senderid
					
					left outer join 
					`last_update` lu on lu.user_id=u.id
					
					left outer join 
					`last_activity` la on la.user_id=u.id
					
					WHERE r.receiverid = ".$id."
					and r.confirmed=1
					and u.accountstatusid>1)
					UNION
					(select distinct 
					r.receiverid as friend, lu.last as lastupdate, la.last as lastactive
					from relationship r
					join user u on u.id=r.receiverid
					
					left outer join 
					`last_update` lu on lu.user_id=u.id 
					
					left outer join 
					`last_activity` la on la.user_id=u.id
					
					WHERE r.senderid = ".$id."
					and r.confirmed=1
					and u.accountstatusid>1)
					order by `".$orderby."` ".$orderdirection."
					limit ".$startresults.", ".$totalresults."
					";
					
			}else{		
					$relationshipquery="
					(select distinct SQL_CALC_FOUND_ROWS
					r.senderid as friend
					from relationship r
					join user u on u.id=r.senderid					
					WHERE r.receiverid = ".$id."
					and r.confirmed=1
					and u.accountstatusid>1)
					UNION
					(select distinct 
					r.receiverid as friend
					from relationship r
					join user u on u.id=r.receiverid
					WHERE r.senderid = ".$id."
					and r.confirmed=1
					and u.accountstatusid>1)
					order by `".$orderby."` ".$orderdirection."
					limit ".$startresults.", ".$totalresults."
					";
					//echo $relationshipquery; die;
			}
					//echo $relationshipquery; 
		$db->query($relationshipquery);		
		$tmp=$db->getresult();
		
		//print_r($tmp); 
		
		if($tmp[0]['friend']<1){
			$tmp2[0]['friend']=$tmp['friend'];
			}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['friend'];	
		}
		Profile::set_totalrows($db->getTotalRows());
		
		//if($farray[0]<1) $farray[0]=$id;
		
		//print_r($farray); die;
		return ($farray); 
	
	}
	


	
	public function network_friends($uid, $startresults = 0, $totalresults = 20, $orderby = "friend", $orderdirection = "DESC"){
	$friendslist=array();
		$friendslist=Relationship::user_friends($uid, 0 , 5000, $orderby, $orderdirection);
		$friendscompact=implode(",",$friendslist);
		if(strlen($friendscompact)<1) $friendscompact=-2;
		$friendsoffriends=Relationship::user_friends($friendscompact, $startresults, $totalresults, $orderby, $orderdirection, $friendscompact);
		$fof=$friendsoffriends;
		
		//$friendcount=count($friendslist);

		//$fof=array_merge($friendslist,$friendsoffriends);
		//$fof=array_diff($friendsoffriends,$friendslist);
		//$totrows=profile::get_totalrows();
		//profile::set_totalrows($friendcount+$totrows);
		//print_r($fof);
		return ($fof); 
	
	}
	
	
	public function user_personal($uid, $startresults = 0, $totalresults = 20, $orderby = "friend", $orderdirection = "DESC", $ignoreusers = 0){
	
		$db = new Database();						
		$db->connect();		
		$sess=new SessionData('account');
		$id=$sess->Retrieve('id');
		
					$relationshipquery="
					(select distinct SQL_CALC_FOUND_ROWS
					r.senderid as friend
					from relationship r
					join user u on u.id=r.senderid
					WHERE r.receiverid IN (".$uid.")
					and r.senderid NOT IN (".$ignoreusers.")
					and r.senderid != '".$id."'
					and r.confirmed=1
					and r.realtionshiptypeid>1
					and u.accountstatusid>1)
					UNION
					(select distinct 
					r.receiverid as friend
					from relationship r
					join user u on u.id=r.receiverid
					WHERE r.senderid IN (".$uid.")
					and r.receiverid NOT IN (".$ignoreusers.")
					and r.receiverid != '".$id."'
					and r.confirmed=1
					and r.realtionshiptypeid>1
					and u.accountstatusid>1)
					order by ".$orderby." ".$orderdirection."
					limit ".$startresults.", ".$totalresults."
					";
					//echo $relationshipquery;
		$db->query($relationshipquery);		
		$tmp=$db->getresult();
		
		
		
		if($tmp[0]['friend']<1){
			$tmp2[0]['friend']=$tmp['friend'];
			}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['friend'];	
		}
		Profile::set_totalrows($db->getTotalRows());
		return ($farray); 
	
	}
	
	public function network_personal($uid, $startresults = 0, $totalresults = 20, $orderby = "friend", $orderdirection = "DESC"){

		$friendslist=Relationship::user_personal($uid, 0 , 999999, $orderby, $orderdirection);
		$friendscompact=implode(",",$friendslist);
		if(strlen($friendscompact)<1) $friendscompact=-2;
		$friendsoffriends=Relationship::user_personal($friendscompact, $startresults, $totalresults, $orderby, $orderdirection, $friendscompact);
		$fof=$friendsoffriends;

		$fof=array_merge($friendslist,$friendsoffriends);
		//print_r($fof);
		return ($fof); 
	
	}
	
	public function network_classes($uid, $startresults = 0, $totalresults = 20, $orderby = "friend", $orderdirection = "DESC"){

		$db = new Database();						
		$db->connect();		
		$sess=new SessionData('account');
		$id=$sess->Retrieve('id');

		
					$classesquery="
					select distinct SQL_CALC_FOUND_ROWS
					cl.userid as friend
					from classlink r
					join classlink cl on cl.classid=r.classid
					join user u on u.id=cl.userid
					join user us on u.schoolid=us.schoolid and us.id=r.userid
					WHERE r.userid IN (".$uid.")
					and cl.userid != '".$id."'
					and u.accountstatusid>1
					order by ".$orderby." ".$orderdirection."
					limit ".$startresults.", ".$totalresults."
					";
					

					//echo $classesquery; 
		$db->query($classesquery);		
		$tmp=$db->getresult();
		
		if($tmp[0]['friend']<1){
			$tmp2[0]['friend']=$tmp['friend'];
			}else $tmp2=$tmp;

		$farray=array();
		
		foreach($tmp2 as $spaceid => $frienddata){
			$farray[$spaceid]=$frienddata['friend'];	
		}
		
		Profile::set_totalrows($db->getTotalRows());
		//$fof=array_merge($friendslist,$friendsoffriends);
		//print_r($fof);
		return ($farray); 
	
	}
	
	
	public function find_connection($uid){
		$db = new Database();						
		$db->connect();

		$userid=Relationship::session_id();
		
		
		
		$viewable=FALSE;
		
		
		$id=$userid;
		
		
		
					$relationshipquery="
					select rt.name as relationship
					from relationship r
					left join relationshiptype rt on r.realtionshiptypeid=rt.id
					join user s on s.id=r.senderid 
					join user rc on rc.id=r.receiverid
					where ((r.senderid ='".$id."' and r.receiverid='".$uid."')
					or (r.senderid ='".$uid."' and r.receiverid='".$id."'))
					and r.confirmed=1
					and r.realtionshiptypeid>0
					and s.accountstatusid>0
					and rc.accountstatusid>0
					order by r.realtionshiptypeid DESC
					";

		$db->query($relationshipquery);		
		$tmp=$db->getresult();
		if(strlen($tmp['relationship'])>2)
			$viewable="You are ".strtolower($tmp['relationship']).".";
		else
			$viewable=FALSE;
			
		return($viewable);
	
	}
	
	
	public function add_relationship($uid,$rid,$type = "Friends"){
		if($uid==$rid) return -1;
		
		$typeid=0;
		$typeid=$this->getid("relationshiptype",$type);
		if($typeid<1) return -10;
		
		$yoursent=$this->sent_requests();
		if(count($yoursent)>9&&$uid!=3) return -3;
		
		
		
		//see if the request already exists
		if(in_array($rid,$yoursent)) return -5;
		
		//see if the relationship already exists
		if($typeid==$currentrelationship=$this->getrelationshiptype($uid,$rid)) return -2;
		
		//see if the user can receive requests from this person (network settings)
		
		
		//count total of personal connections (ex dating, etc) max is 5
		if(count($this->personal_connections($uid))>4) return -6;
		
		$query="select * from relationship";
		

			if($currentrelationship<1){
				$query="
				insert into relationship 
				(`senderid`, `receiverid`, `realtionshiptypeid`, `confirmed`) 
				VALUES 
				('".$uid."','".$rid."','".$typeid."','0')
				";	
			}
			
			if($currentrelationship>1){
				$query="
				update relationship
				set `relationshiptypeid`='".$typeid."'
				where (`senderid`='".$uid."' and `receiverid`='".$rid.")
				or (`senderid`='".$rid."' and `receiverid`='".$uid.") limit 1";
			}
		
		
		
		
		$db = new Database();						
		$db->connect();		
		//echo $query;
		$db->query($query);
		
		$body="<font face=arial size=2>".$this->getname('user',$uid)." requested you to confirm that you are ".$type." with them.<br><br>Please login at <a href='http://www.harvardconnection.co'>http://www.harvardconnection.co</a> to confirm or deny this request.<br><br>Thanks,<br>The Harvardconnection Team";
		email::sendinfo(Relationship::getemail($rid),'New Request',$body);
		
		return 1;
	}
	
	public function getrelationshiptype($uid,$rid){
		$db = new Database();						
		$db->connect();
			$query="select distinct 
					r.realtionshiptypeid as typeid
					from relationship r
					join user u on u.id=r.senderid
					join user ur on ur.id=r.receiverid
					WHERE (r.receiverid = '".$rid."' and r.senderid = '".$uid."')
					or (r.receiverid = '".$uid."' and r.senderid = '".$rid."')
					and u.accountstatusid>1
					and ur.accountstatusid>1
					";
		$db->query($query);
		$tmp=$db->getresult();
	
		return $tmp['typeid'];
	}
	
	private function personal_connections($uid){
		$db = new Database();						
		$db->connect();
			$query="select distinct 
					r.senderid as friend
					from relationship r
					join user u on u.id=r.senderid
					WHERE r.receiverid IN (".$uid.")
					and r.confirmed=0
					and r.relationshiptype>1
					and u.accountstatusid>1
					UNION
					select distinct 
					r.receiverid as friend
					from relationship r
					join user u on u.id=r.receiverid
					WHERE r.senderid IN (".$uid.")
					and r.confirmed=0
					and r.relationshiptype>1
					and u.accountstatusid>1
					";
		$db->query($query);		
		$tmp=$db->getresult();
		
		if($tmp[0]['friend']<1){
			$tmp2[0]['friend']=$tmp['friend'];
			}else $tmp2=$tmp;
		
		$friendarray=array();
		
		foreach($tmp2 as $friend){
					$position=count($friendarray);
					$friendarray[$position]=$friend['friend'];
		}

		return($friendarray);
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
	
		
	return($rid);
	
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
	
	
	public function confirm($uid,$rid){
		$db = new Database();						
		$db->connect();
		$query="
				update relationship
				set `confirmed`='1'
				where (`senderid`='".$uid."' and `receiverid`='".$rid."')
				or (`senderid`='".$rid."' and `receiverid`='".$uid."') limit 1";
				//echo $query;
		$db->query($query);
		
		$body="<font face=arial size=2>".$this->getname('user',$uid)." confirmed your request.<br><br>Please login at <a href='http://www.harvardconnection.co'>http://www.harvardconnection.co</a> to view their profile.<br><br>Thanks,<br>The Harvardconnection Team";
		email::sendinfo(Relationship::getemail($rid),'Request Confirmed',$body);
		return 1;
	}
	
	public function deny($uid,$rid){
		$db = new Database();						
		$db->connect();
		$query="
				delete from relationship
				where (`senderid`='".$uid."' and `receiverid`='".$rid."')
				or (`senderid`='".$rid."' and `receiverid`='".$uid."') limit 1";
				//echo $query;
		$db->query($query);
		return 1;
	}
	
	
	public function sent_requests(){
		$db = new Database();						
		$db->connect();		
		$uid=$this->userid;
		
					$relationshipquery="
					select distinct 
					r.receiverid as friend
					from relationship r
					join user u on u.id=r.receiverid
					WHERE r.senderid IN (".$uid.")
					and r.confirmed=0
					and u.accountstatusid>1
					";
		
		$db->query($relationshipquery);		
		$tmp=$db->getresult();
	
		if($tmp[0]['friend']<1){
			$tmp2[0]['friend']=$tmp['friend'];
			}else $tmp2=$tmp;
		
		$friendarray=array();
		
		foreach($tmp2 as $friend){
					$position=count($friendarray);
					$friendarray[$position]=$friend['friend'];
		}

		return($friendarray); 
	}
	
	
	
	
	
	public function pending_requests(){
		$db = new Database();						
		$db->connect();		
		$uid=$this->userid;
		
					$relationshipquery="
					select distinct 
					r.senderid as friend
					from relationship r
					join user u on u.id=r.senderid
					WHERE r.receiverid IN (".$uid.")
					and r.confirmed=0
					and u.accountstatusid>1
					";
		
		$db->query($relationshipquery);		
		$tmp=$db->getresult();
		
		if($tmp[0]['friend']<1){
			$tmp2[0]['friend']=$tmp['friend'];
			}else $tmp2=$tmp;
		
		$friendarray=array();
		
		foreach($tmp2 as $friend){
					$position=count($friendarray);
					$friendarray[$position]=$friend['friend'];
		}
		
		return($friendarray); 
	}
	
	

	
	public function showrandom6($id){
	
	return($info);
	}

	
	private function session_id(){
			$sessdata= new SessionData('account');
			$this->userid=$sessdata->Retrieve('id');
		return($this->userid);
	}
}

?>