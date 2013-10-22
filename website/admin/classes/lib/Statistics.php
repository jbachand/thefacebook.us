<?PHP

class Statistics{

	function __construct(){
	
	}


	public function totalusers() {
			$db = new Database();																		
			$db->connect();		
			$where="`accountstatusid`>1";
			//$db->select('`user`','`id`',$where);
			$sql="select count(id) as nofu from `user` where `accountstatusid`>'1'";
			$db->query($sql);
			$result=$db->getresult();
			$users=$result['nofu'];

		return ( $users );
	}
	
	public function totalscope() {
			$db = new Database();																		
			$db->connect();		
			$where="`accountstatusid`>1";
			//$db->select('`user`','`id`',$where);
			$sql="select count(id) as nofu from `user` where `accountstatusid`>'0'";
			$db->query($sql);
			$result=$db->getresult();
			$users=$result['nofu'];

		return ( $users );
	}
	
	
	public function usercount($date) {	//$date must be in format 2011-02-23

			$db = new Database();																		
			$db->connect();		
			$where="`accountstatusid`>1";
			//$db->select('`user`','`id`',$where);
			$sql="select count(id) as nofu from `user` where  `registerdate`>='".$date." 00:00:00' and `registerdate`<='".$date." 23:59:59'";
			$db->query($sql);
			$result=$db->getresult();
			$users=$result['nofu'];
			//$db->clearResult(); 
		return ( $users );
	}
	
	public function dailyactiveusercount($date) {	//$date must be in format 2011-02-23
			$db = new Database();																		
			$db->connect();		
			$sql="select `hits` from `Users_Per_Day` WHERE `date`='".$date."'";
			$db->query($sql);
			$result=$db->getresult();
			$users=$result['hits'];

			

		return ( $users );
	}
	
	public function usersince($date) {	//$date must be in format 2011-02-23
			$db = new Database();																		
			$db->connect();		
			$where="`accountstatusid`>1 and `registerdate`>='".$date." 00:00:00'";
			$sql="select count(id) as nofu from `user` where ". $where;
			$db->query($sql);
			$result=$db->getresult();
			$users=$result['nofu'];

		return ( $users );
	}
	
	public function totalviews() {	

			
			$m = new MongoClient();
			$collection = $m->selectCollection('thefacebook', 'log');
			$cursor = $collection->find();
		return ( $cursor->count() );
	}
	
	public function topsuggested() {	
			$db = new Database();																		
			$db->connect();		
			$query="select school as name, count(id) as entries from schoolsuggestions group by school order by entries DESC limit 10";
			$db->query($query);
			$result=$db->getresult();
			//print_r($result);
		return ( $result );
	}
	
	public function todaysrefs($date){
			$db = new Database();																		
			$db->connect();	
			$query="SELECT ref, count(id) as hits FROM `log` USE INDEX (idx_times) WHERE `timestamp`>'".$date." 00:00:00' group by ref order by hits desc limit 10";
			$db->query($query);
			$result=$db->getresult();
		return ( $result );
	}
	
	public function averageviews($date) {	//$date must be in format 2011-02-23

			$views=$this->totalviews();
			$site=new Site();
			$launchdate=strtotime($site->get_setting('launch_date'));
			$today=strtotime($date);
			
			$diff=$today-$launchdate;
			$days=$diff/86400;
			
			$viewsperday=$views/$days;

		return ( $viewsperday );
	}
	
	public function viewcount($date) {	//$date must be in format 2011-02-23

//echo strtotime($date. " 23:59:59"); die;
		$m = new MongoClient();
			$collection = $m->selectCollection('thefacebook', 'log');
			$rangeQuery = array('timestamp' => array( '$gte' => strtotime($date." 00:00:00"), '$lte' => strtotime($date." 23:59:59" )));
			$cursor = $collection->find($rangeQuery);
		return ( $cursor->count() );
	}
	
	public function monthlyviewcount($month) {	
			$db = new Database();					
			$db->connect();		
			$where="`date`='".$month."'";
			$sql="select `hits` as nofu from `Hits_Per_Month` where ".$where;
			$db->query($sql);
			$result=$db->getresult();
			$views=$result['nofu'];
		return ( $views );
	}
	
	public function multidayvisitors() {	
			//1.147.128.58
			$db = new Database();																		
			$db->connect();		
			$query="
				SELECT distinct count(distinct concat (year(`timestamp`),month(`timestamp`),day(`timestamp`))) as `uniquedaysactive`, ip FROM log  group by `ip` having `uniquedaysactive`>1
				";
			$db->query($query);
			$result=$db->getresult();
			
			if(!$result[0]['ip'])
				$retvalue[0]=$result;
			else
				$retvalue=$result;

		return ( $retvalue );
	}
	
	public function multidayusers() {	
			$db = new Database();																		
			$db->connect();		
			$query="
				SELECT uip.`userid` as `userid`, COUNT( uip.ymd ) AS uniquedaysactive, MAX( uip.ymd ) AS lastactiveday
				FROM (
				SELECT DISTINCT DATE_FORMAT( `timestamp`,  '%Y-%m-%d' ) AS ymd, `userid`
				FROM log
				) uip
				GROUP BY uip.`userid`
				HAVING uniquedaysactive >1 AND `userid`!= 0
				ORDER BY uniquedaysactive DESC 
				";
			$newquery="	SELECT distinct count(distinct concat(year(`timestamp`),month(`timestamp`),day(`timestamp`))) as `uniquedaysactive`,
						userid 
						FROM log  
						where userid>0
						group by `userid` 
						having `uniquedaysactive`>1";
			$db->query($newquery);
			
			$result=$db->getresult();

				
				

		return ( $result );
	}
	
	
	public function harvardcampususers() {	
			$db = new Database();																		
			$db->connect();		
			$query="
					SELECT ip 
					FROM log
					WHERE 1 =3
					OR ip LIKE  '140.247%'
					OR ip LIKE  '127.103%'
					OR ip LIKE  '131.142%'
					OR ip LIKE  '207.86.182%'
					OR ip LIKE  '134.174.4%'
					OR ip LIKE  '134.174.14%'
					OR ip LIKE  '134.174.140%'
					OR ip LIKE  '134.174.178%'
					OR ip LIKE  '134.174.193%'
					OR ip LIKE  '199.194.0%'
					OR ip LIKE  '212.171.47.146' 
				";
			$db->query($query);
			$result=$db->getresult();
			
			if(!$result[0]['ip'])
				$retvalue[0]=$result;
			else
				$retvalue=$result;

		return ( $retvalue );
	}
	
		public function last20hits() {	
			$m = new MongoClient();
			$collection = $m->selectCollection('thefacebook', 'log');
			$cursor = $collection->find();
			$cursor->sort(array('timestamp'=>-1))->limit(10);
			$records = iterator_to_array($cursor);
			foreach($records as &$record){
				unset($record['$id']);
				$record['gets'] = implode(',',$record['gets']);
				$record['posts'] = implode(',',$record['posts']);
			}
		return ( $records );
	}
	
	public function last10useractivity() {	
			$m = new MongoClient();
			$collection = $m->selectCollection('thefacebook', 'log');
			$cursor = $collection->find(array('userid'=>array('$gt'=>0)));
			$cursor->sort(array('timestamp'=>-1))->limit(10);
			$records = iterator_to_array($cursor);
			foreach($records as &$record){
				unset($record[0]);
				$record[5] = implode(',',$record[5]);
				$record[6] = implode(',',$record[6]);
			}
		return ( $records );
	}
	

	
		public function uniquevisitors($date) {	//$date must be in format 2011-02-23
			$db = new Database();																		
			$db->connect();		
			$where="`date`='".$date."'";

			$query="select `hits` from `Uniques_Per_Day` where ".$where."";
			//echo $query;
			$db->query($query);
			//$db->select('`log`','`ip`',$where,$order,$group);
			$result=$db->getresult();
			$views=$result['hits'];

		return ( $views );
	}
	
	public function monthlyuniques(){
	
		$db = new Database();																		
		$db->connect();		
		$query="SELECT sum(hits) as uniques, year(`Uniques_Per_Day`.`date`) as year, month(`Uniques_Per_Day`.`date`) as month FROM `Uniques_Per_Day` group by `year`, `month` ORDER BY `Uniques_Per_Day`.`date` DESC ";
		$db->query($query);
		
		$result=$db->getresult();
		$views=$result['hits'];

		return ( $views );
		
	}
	
	public function totaluniquevisitors() {	
			$db = new Database();																		
			$db->connect();		
			$query="select sum(`hits`) as `thits` from `Uniques_Per_Day` ";
			//echo $query;
			$db->query($query);
			//$db->select('`log`','`ip`',$where,$order,$group);
			$result=$db->getresult();
			$views=$result['thits'];

		return ( $views );
	}
}

?>