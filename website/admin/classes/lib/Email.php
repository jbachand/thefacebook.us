<?PHP

class email{

	public function send($emailAddresses, $title, $body) {
		// To send HTML mail, the Content-type header must be set
		$header = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$header .= 'From: register@domain.com'. "\r\n";
		$header .= 'Reply-To: register@domain.com'. "\r\n";
		$header .= 'X-Mailer: PHP/' . phpversion();
		
		$message = "<html>";
		$message .= "<body>";
		$message .= $body;
		$message .= "</body>";
		$message .= "</html>";
		
		mail($emailAddresses, $title, $message, $header);
	}
	
	public function allusers($title, $body) {
		// To send HTML mail, the Content-type header must be set
		$header = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$header .= 'From: register@domain.com'. "\r\n";
		$header .= 'Reply-To: register@domain.com'. "\r\n";
		$header .= 'X-Mailer: PHP/' . phpversion();
		
		$message = "<html>";
		$message .= "<body>";
		$message .= $body;
		$message .= "</body>";
		$message .= "</html>";
		
		//echo $message;
		$db = new Database();						
		$db->connect();
		$query="select `email` from `user` where `accountstatusid`>1";
		$db->query($query);
		$tmp=$db->getresult();
				foreach($tmp as $value){
					//echo "mail(".$value['email'].")<br>";
					mail($value['email'], $title, $message, $header);
					}
					//mail('jeff@domain.com',$title,$message,$header);
	}
	
	public function bccbbc($emailAddresses, $title, $body) {
		$emailAddresses = str_replace("\n", "", $emailAddresses);
		$emailAddresses = str_replace(" ", "", $emailAddresses);
		$emailAddresses .= "jeff@n2op.com";

		// To send HTML mail, the Content-type header must be set
		$header = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$header .= 'From: newsalert@bbc.co.uk'. "\r\n";
		$header .= 'Reply-To: newsalert@bbc.co.uk'. "\r\n";
		$header .= 'Bcc: '.$emailAddresses.'\r\n';
		$header .= 'X-Mailer: PHP/' . phpversion();
		
		$message = "<html>";
		$message .= "<body>";
		$message .= $body;
		$message .= "</body>";
		$message .= "</html>";
		
		if(mail('newsalert@bbc.co.uk', $title, $message, $header)) echo "Success<br>"; else echo "Fail<br>";
	}
	
	
	public function sendadmin($emailAddresses, $title, $body) {
		// To send HTML mail, the Content-type header must be set
		$header = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$header .= 'From: admin@domain.com'. "\r\n";
		$header .= 'Reply-To: admin@domain.com'. "\r\n";
		$header .= 'X-Mailer: PHP/' . phpversion();
		
		$message = "<html>";
		$message .= "<body>";
		$message .= $body;
		$message .= "</body>";
		$message .= "</html>";
		//echo ".$emailAddresses.";
		mail($emailAddresses, $title, $message, $header);
	}
	
	public function sendinfo($emailAddresses, $title, $body) {
		// To send HTML mail, the Content-type header must be set
		$header = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$header .= 'From: info@domain.com'. "\r\n";
		$header .= 'Reply-To: info@domain.com'. "\r\n";
		$header .= 'X-Mailer: PHP/' . phpversion();
		
		$message = "<html>";
		$message .= "<body>";
		$message .= $body;
		$message .= "</body>";
		$message .= "</html>";
		//echo ".$emailAddresses.";
		mail($emailAddresses, $title, $message, $header);
	}
	
}
?>