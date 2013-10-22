<?PHP

class SessionData{

	function __construct($page = 'default'){
		$this->SetSession($page);
	}


	public function SetSession($page = 'default'){
			$currentCookieParams = session_get_cookie_params(); 

		$rootDomain = '.thefacebook.us'; 

		session_set_cookie_params( 
			$currentCookieParams["lifetime"], 
			$currentCookieParams["path"], 
			$rootDomain, 
			$currentCookieParams["secure"], 
			$currentCookieParams["httponly"] 
		); 
		session_start();
		$this->authData = $_SESSION['authData'];
	
		if($_SESSION['authData']['accountstatus']=="-1" && $page=="default"){
		//echo $page;
			header("Location: account.php");
			//exit();
		}
			/*
			Currently Known Values
			
			$this->authData['email']        
	 		$this->authData['id']              
	 		$this->authData['name']       

			*/

	}				

	public function Retrieve($name){
		if( in_array($name,$this->validSessVars()) && isset($this->authData[$name]) ){
				return($this->authData[$name]);
		}
		return(FALSE);
	}		
	
	public function RetrieveAll(){
		return($this->authData);
	}
	
	private function validSessVars(){
		$valid=array();
		$count=0;
		if(is_array($this->authData))
		foreach($this->authData as $key => $value){
			$valid[$count]=$key;
			$count++;
		}
		return($valid);	
	}
		
		
	public function Logout(){
			unset($authData);
			$_SESSION['authData'] = $authData;
			header("Location: http://".$_SERVER["HTTP_HOST"]."/index.php");
			exit();
	}

	public function Login(){
				unset($authData);
				$_SESSION['authData'] = $authData;
				header("Location: http://".$_SERVER["HTTP_HOST"]."/login.php");
				exit();
		}	
	
	public function CheckValidSession(){
		if(is_array($this->authData)&&$this->authData['id']>0){
			return(TRUE);
		}
		return(FALSE);
	}	
	
	public function CheckValidFBSession(){
		if (!$this->CheckValidSession()){
			header('location: bind.php');
		}

	}	
	
	
	public function CheckValidAdminSession(){
		if($this->authData['accountstatus']==9){
			return(TRUE);
		}
		return(FALSE);
	}	

}

?>