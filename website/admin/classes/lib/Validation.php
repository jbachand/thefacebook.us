<?PHP

class validation{

	public function IP($address){
		if(!preg_match("/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/",$address)){
			return false;
		}else{
			return true;
		}
	}
	
	public function Email($address){
		if(!preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/",$address)){
			return false;
		}else{
			return true;
		}
	}
	
	public function ZIP($number){
		if(!preg_match("/^\d{5}$/",$number)){
			return false;
		}else{
			return true;
		}
	}
	
	public function Street($street){
		if(!preg_match("/^\d{1,6}\040([a-zA-Z]{1}[a-z]{1,}\040[a-zA-Z]{1}[a-z]{1,})$|^\d{1,6}\040([a-zA-Z]{1}[a-z]{1,}\040[a-zA-Z]{1}[a-z]{1,}\040[a-zA-Z]{1}[a-z]{1,})$|^\d{1,6}\040([a-zA-Z]{1}[a-z]{1,}\040[a-zA-Z]{1}[a-z]{1,}\040[a-zA-Z]{1}[a-z]{1,}\040[a-zA-Z]{1}[a-z]{1,})$/",$street)){
			return false;
		}else{
			return true;
		}
	}
	
	public function FormalName($name){
		if(!preg_match("/^(?P<salutation>(Mr|MR|Ms|Miss|Mrs|Dr|Sir)(\.?))?\s*((?<first>[A-Za-z\-]*?) )?((?<second>[A-Za-z\-]*?) )?((?<third>[A-Za-z\-]*?) )?(?(?!(PHD|MD|3RD|2ND|RN|JR|II|SR|III))(?<last>([A-Za-z](([a-zA-Z\-\']{1,2})[A-Za-z\-\'])?[a-zA-Z\-\']+)))( (?P<suffix>(PHD|MD|3RD|2ND|RN|JR|II|SR|III)))?$/",$name)){
			return false;
		}else{
			return true;
		}
	}
	
	public function State($state){
		$state=strtoupper($state);
		if(!preg_match("/^(?:(A[KLRZ]|C[AOT]|D[CE]|FL|GA|HI|I[ADLN]|K[SY]|LA|M[ADEINOST]|N[CDEHJMVY]|O[HKR]|P[AR]|RI|S[CD]|T[NX]|UT|V[AIT]|W[AIVY]))$/",$state)){
			return false;
		}else{
			return true;
		}
	}
	
	
	public function Text($text){
		if(!preg_match("/^\s*[a-zA-Z,\s]+\s*$/",$text)){
			return false;
		}else{
			return true;
		}
	}
	
	public function Number($text){
		if(!is_numeric($text)){
			return false;
		}else{
			return true;
		}
	}
}

?>