<?PHP
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib
$log= new log($_SERVER["PHP_SELF"]);
$sess = new SessionData();					// Creates session object
//$sess->CheckValidFBSession();
$schoolsuggested=NULL;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	

	extract($_POST);

	if(strlen($newschool)>1){
		$db = new Database();																		
		$db->connect();
		$values=array('NULL', $email, $newschool, 'NOW()');
		if($db->insert('schoolsuggestions',$values)){	
				if(strlen($email)>0)
					$body = "A new school was suggested by: ".$email.". <br>";
					
				$body .= "The school is: ".$newschool.".";
				$email = new email();																		
				if($site->get_setting('email_alerts')==1){
					$email->send('suggest@harvardconnection.co','New School Suggestion',$body);
				}
				$schoolsuggested="Your suggestion has been sent to the HarvardConnection team.";
		}
	}else{
		$error="<p class='red'><b>This does not appear to be a valid school. Please try again.</b></p>";
	}
}

?><html xmlns:fb="http://www.facebook.com/2008/fbml">
<title>TheFacebook | Contact Us</title> 
<link rel="stylesheet" href="style.css"> 
<link rel="shortcut icon" href="favicon.ico"> 
  <div id="fb-root"></div>
  <script>
    window.fbAsyncInit = function() {
   FB.Canvas.setAutoResize();
    };
    (function() {
   var e = document.createElement('script'); e.async = true;
   e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
   document.getElementById('fb-root').appendChild(e);
    }());
  </script>


<center>

<table class="bordertable" cellspacing=0 cellpadding=0 border=0 width=700>

  <tr><td>

      <table class="bottomborder" cellspacing=0 cellpadding=0 border=0 width=100%>

      <tr><td width=350 bgcolor=#3B5998>

          <img src='images/logo-left.jpg'></td>

          <td><table cellspacing=0 cellpadding=0 border=0 width=100%><tr><td>

          <table cellspacing=0 cellpadding=0 border=0 width=100%>

          <tr><td><a href='index.php'><img src='images/logo-right.jpg' border=0></a></td>

          <td width=100% bgcolor=#3B5998>&nbsp;</td></tr></table></td></tr>

          <tr><td><table cellspacing=0 cellpadding=4 border=0 width=100%><tr height=21>

          <!--<td bgcolor=#3B5998 width=10>&nbsp;</td>-->

		 <?PHP
			
			if(!$sess->CheckValidSession()){			
				include('modules/default/topnav.php');
			}else{
				include('modules/loggedin/topnav.php');		  
			}
			?>

                    <td bgcolor=#3B5998 width=100%>&nbsp;</td>

          </tr></table></td>

          </tr></table>

      </td></tr></table>

  </td></tr>

  <tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%>

      <tr><td valign=top>

      <table cellspacing=0 cellpadding=0 border=0 width=105>

        <tr><td>

			<?PHP
			
			if(!$sess->CheckValidSession()){			
				include('modules/default/leftnav.php');
			}else{
				include('modules/loggedin/leftnav.php');		  
			}
			?>              

         





        </td></tr>



      </td></tr>

      </table>

      </td><td width=595 valign=top>

        <table class="bordertable" cellspacing=0 cellpadding=0 border=1 width=100%><tr><td>



	  <table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Contact Us</td></tr></table><center><p class='title'>[ Contact Us ]</p><center><table cellspacing=0 cellpadding=0 width=95% border=0><tr><td><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Suggest a New School</td></tr></table>&nbsp;<br><center>
<?PHP if(!$schoolsuggested){ 
echo $error;
?>
<table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td><tr><td>Suggest a new school to be added to the harvardconnection network. If you provide us with your email address, we will notify you when the school is added.</td></tr><form method=post action='contact.php'> 
<table cellspacing=4 cellpadding=2 border=0> 
<tr><td>New School:</td><td>&nbsp;
<input type=text class='inputtext' name='newschool' size=30></td></tr><tr><td>Email (optional):</td><td>&nbsp;
<input type=text class='inputtext' name='email' size=30></td></tr></table> 
<center><input type=submit class='inputsubmit' value='  Submit  '></center><p></form> 
</table>
<?PHP }else {
echo "<table style='width:100%;height:150px'><tr><td><p class='red'><b>$schoolsuggested</b></p></td></tr></table>"; // REGISTRATION SUCCESSFUL MESSAGE
}
?>
<p><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Email</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=0 border=0 width=95%><tr><td><table cellspacing=0 cellpadding=3 border=0><tr><td><b>Information/Support:</b>&nbsp;&nbsp;</td><td><a href="javascript:window.location='mailto:info'+'@'+'HarvardConnection.co'">info@<blink></blink>HarvardConnection.co</a></td></tr><tr><td><b>Suggestions/Requests:</b>&nbsp;&nbsp;</td><td><a href="javascript:window.location='mailto:suggest'+'@'+'HarvardConnection.co'">suggest@<blink></blink>HarvardConnection.co</a></td></tr><tr><td><b>Business Development:</b></td><td><a href="javascript:window.location='mailto:business'+'@'+'HarvardConnection.co'">business@<blink></blink>HarvardConnection.co</a></\
td></tr><tr><td><b>Press Inquiries:</b></td><td><a href="javascript:window.location='mailto:press'+'@'+'HarvardConnection.co'">press@<blink></blink>HarvardConnection.co</a></t\
d></tr><tr><td><b>Advertising:</b></td><td><a href="javascript:window.location='mailto:advertise'+'@'+'HarvardConnection.co'">advertise@<blink></blink>HarvardConnection.co</a></td></tr></table></td></tr></table>&nbsp;<br></td></tr></table>&nbsp;<br><input class='inputsubmit' type=button value='Home' onclick='javascript:document.location="home.php";'><br>&nbsp;</td></tr></table>  </td></tr></table>

  </td></tr></table>

  <center>

<?PHP include('modules/default/bottomnav.php');	?> 

  </center><br>

  </td></table></table><br>


