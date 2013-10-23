<?PHP

include('../admin/classes/classes.php');				// Include local class lib

$sess = new SessionData();					// Creates session object

$log= new log($_SERVER["PHP_SELF"], $_GET, $_POST, $_SERVER['HTTP_REFERER'] ); 

if(!$sess->CheckValidAdminSession()){			// Validates Session
	if(!$sess->CheckValidSession())
		header('Location: login.php');
	else
		header('Location: http://www.harvardconnection.co/home.php');
}

$db = new Database();						// Creates database object
if(!$db->connect()){
	echo "<p>Error connecting to the database</p>";
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$rows=array("site_on"=>$_POST['site_on'],"email_alerts"=>$_POST['email_alerts'],"launch_date"=>$_POST['launch_date'],"registration_on"=>$_POST['registration_on'],"login_on"=>$_POST['login_on']);
	$db->update('settings',$rows,array());
	header("location: index.php");
}

//$log= new log('AdminIndex');
$stats = new statistics();

$today=date('Y-m-d');

?>
<title>HarvardConnection | Admin</title> 
<link rel="stylesheet" href="../style.css"> 
<link rel="shortcut icon" href="../favicon.ico"> 


<center>

<table class="bordertable" cellspacing=0 cellpadding=0 border=0 width=700>

  <tr><td>

      <table class="bottomborder" cellspacing=0 cellpadding=0 border=0 width=100%>

      <tr><td width=350 bgcolor=#3B5998>

          <img src='../images/logo-left.jpg'></td>

          <td><table cellspacing=0 cellpadding=0 border=0 width=100%><tr><td>

          <table cellspacing=0 cellpadding=0 border=0 width=100%>

          <tr><td><a href='index.php'><img src='../images/logo-right.jpg' border=0></a></td>

          <td width=100% bgcolor=#3B5998>&nbsp;</td></tr></table></td></tr>

          <tr><td><table cellspacing=0 cellpadding=4 border=0 width=100%><tr height=21>

          <!--<td bgcolor=#3B5998 width=10>&nbsp;</td>-->
		  
		 <?PHP
		
				include('../modules/loggedin/topnav.php');		  
			
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
			
				include('../modules/loggedin/leftnav.php');		  
			
			?>



        </td></tr>



      </td></tr>

      </table>

      </td><td width=595 valign=top>

        <table class="bordertable" cellspacing=0 cellpadding=0 border=1 width=100%><tr><td>



	  <table cellspacing=0 cellpadding=2 border=0 width=100%> 
		<tr>
			<td class='white' bgcolor=#3B5998>Admin Panel</td>
		</tr>
	</table>
	
	<center>
	
	<p class='title'>[ Admin Panel ]</p><center>
	
	<table cellspacing=0 cellpadding=0 border=0 width=95%>
		<tr>
			<td>
				<center>
					
					<br>&nbsp;<center>
					<table class='bordertable' cellspacing=0 cellpadding=0 width=90%>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=100%> 
									<tr>
										<td class='white' bgcolor=#3B5998>Site Settings </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
							<form method=post>
								<table cellspacing=0 cellpadding=2 border=0 width=95%>
									<tr>
										<td>
											Site On:
										</td>
										<td>
											<input name='site_on' type=text value="<?PHP echo $site->get_setting('site_on'); ?>">
										</td>
									</tr>
									<tr>
										<td>
											Email Alerts:
										</td>
										<td>
											<input name='email_alerts' type=text value="<?PHP echo $site->get_setting('email_alerts'); ?>">
										</td>
									</tr>
									<tr>
										<td>
											Go-Live Date:
										</td>
										<td>
											<input name='launch_date' type=text value="<?PHP echo $site->get_setting('launch_date');?>">
										</td>
									</tr>
									<tr>
										<td>
											Registration Enabled:
										</td>
										<td>
											<input name='registration_on' type=text value="<?PHP echo $site->get_setting('registration_on'); ?>">
										</td>
									</tr>
									<tr>
										<td>
											Login Enabled:
										</td>
										<td>
											<input name='login_on' type=text value="<?PHP echo $site->get_setting('login_on'); ?>">
										</td>
									</tr>
									<tr>
										<td>
											Save:
										</td>
										<td>
											<input name='submit' type=submit value="Save" class="inputsubmit">
										</td>
									</tr>
								</table>
								</form>
							</td>
						</tr>
					</table>
					<br>&nbsp;<center>
					<table class='bordertable' cellspacing=0 cellpadding=0 width=90%>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=100%> 

  </td></tr></table>

  <center>

  <p><a href="../about.php">about</a>&nbsp;&nbsp;

  <a href="../contact.php">contact</a>&nbsp;&nbsp;

  <a href="../faq.php">faq</a>&nbsp;&nbsp;

  <a href="../terms.php">terms</a>&nbsp;&nbsp;

  <a href="../policy.php">privacy</a>

  <br>a Mark Zuckerberg production

  <br>HarvardConnection &copy; 2004

  </center><br>

  </td></table></table><br>



 
