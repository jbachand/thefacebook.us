<?PHP

class Dropdowns{

	function __construct(){

	}

	
	public function options($name){
		$db = new Database();						
		$db->connect();

			$query="
				select id, name
				from `".$name."` tabl
				";
			// interestedin
			// lookingfor
			// relationshiptype
			// sex
			// schoolstatus
			// political
			
			$db->query($query);

			
			$tmp=$db->getresult();
			


		
	return($tmp);
	}
	
}

?>