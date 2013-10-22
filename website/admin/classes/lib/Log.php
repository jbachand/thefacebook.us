<?PHP

class log{

	public function __construct($page, $get= '', $post = '', $ref = '') {
	
		$sess = new SessionData('account');	
		if($sess->CheckValidSession()){	
			$userid=$sess->Retrieve('id');
		}else{
			$userid="0";
		}
		
		if($userid=='45403199'){
			return false;
		}
		
		
		if(!$ref) $ref="";
		
		$ip=$_SERVER["REMOTE_ADDR"];
		

		$values=array('page'=>$page,'ip'=>$ip,'userid'=>$userid, 'timestamp'=>(int) time(), 'gets'=>$get, 'posts'=>$post, 'referral'=>$ref); 
		$m = new MongoClient();
		$collection = $m->selectCollection('thefacebook', 'log');
		$collection->insert($values);

		if($ip=='202.94.191.47'||$ip=='202.94.191.13'||$ip=='202.94.191.183'){
			echo "Your address: ".$ip." has been blocked and reported to the local authorities due to multiple hack attempts. Please contact admin@harvardconnection.co if you feel this is an error.";
			die(); 
		}
	}
	
	function lastpage($userid){
		$m = new MongoClient();
			$collection = $m->selectCollection('thefacebook', 'log');
			$cursor = $collection->find(array('userid'=>$userid));
			$cursor->sort(array('timestamp'=>-1))->limit(2);
			$records = iterator_to_array($cursor);
			
			return($records[1]['page']);
	}
	
}
?>