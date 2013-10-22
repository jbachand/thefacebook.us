<?
class Site{

	function __construct(){
		$this->set_settings();
	}

	public function set_settings(){
	
			$db = new Database();						
			$db->connect();
			
			$query="
				select site_on, email_alerts, launch_date, registration_on, login_on
				from settings
				";
			
			$db->query($query);				
			$this->site=$db->getresult();

			
			return(TRUE);
	}
	
	public function get_setting($setting){
		return($this->site[$setting]);
	}
}
?>