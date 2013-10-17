<?PHP

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib

$sess = new SessionData();					// Creates session object
$sess->CheckValidFBSession();
if(!$sess->CheckValidSession()){			// Validates Session
	$sess->Login();
}

$log= new log($_SERVER["PHP_SELF"]);
$db = new Database();						// Creates database object
if(!$db->connect()){
	echo "<p>Error connecting to the database</p>";
}



$id=$sess->Retrieve('id');

$relation= new Relationship;

if(isset($_REQUEST['id'])&&$_REQUEST['id']>0)
	$fid=$_REQUEST['id'];
	else
	header('Location: home.php');
	
$profile = new Profile($fid);
$friendarray=$profile->friendsids($id,0,999999);
	
	
$success=false;	
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$success=$relation->deny($id,$fid);
		if($_REQUEST['remove']=="Remove") $error="</b></font>You are no longer connected with this user directly.<br> <a href='editfriends.php'>Back to friends</a>";

		$success=true;
	
	
}


?>
<title>TheFacebook | Add Friend</title> 
<link rel="stylesheet" href="style.css"> 
<link rel="shortcut icon" href="favicon.ico"> 


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
		   include('modules/loggedin/topnav.php');
		   ?>

                    <td bgcolor=#3B5998 width=100%>&nbsp;</td>

          </tr></table></td>

          </tr></table>

      </td></tr></table>

  </td></tr>

  <tr><td><table cellspacing=0 cellpadding=2 border=0 width="100%">

      <tr><td valign=top width="136px" style="width:136px">

      <table cellspacing=0 cellpadding=0 border=0 width=100%>

        <tr><td>

           <?PHP
		   include('modules/loggedin/leftnav.php');
		   ?>

        </td></tr>



      </td></tr>

      </table>

      </td><td width=595 style="width:595px" valign=top>

        <table class="bordertable" cellspacing=0 cellpadding=0 border=1 width=100%><tr><td>



	  <table cellspacing=0 cellpadding=2 border=0 width=100%><tr><td class='white' bgcolor=#3B5998>
	  Confirmation
	  </td></tr></table>


<br>
<table cellspacing=0 cellpadding=6 border=0 width=97% align=center valign=top>
	<tr>


		<td width="100%" valign=top>

			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Remove your connection to <?PHP echo $profile->retrieve("name");?>
								</td>
								
							</tr>
						</table>
						<?PHP if(!$success){?>
						<form method=post>
						<input type=hidden name=id value=<?PHP echo $fid;?>>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td>
								<img src='<?PHP echo $profile->retrieve("thumbnail");?>' align=left>
								<font color=red><b><?PHP echo $error; ?></b></font>
								Remove <?PHP echo $profile->retrieve("name");?>?
								<br>
								<input type=submit name=remove value="Remove" class=inputsubmit>
								</td>
							</tr>
						</table>
						</form>
						<? } else {?>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td>
								<img src='<?PHP echo $profile->retrieve("thumbnail");?>' align=left>
								<font color=red><b><?PHP echo $error; ?></b></font>
								</td>
							</tr>
						</table>
						<? } ?>
					</td>
				</tr>
			</table>
	
	</table>
	<br>&nbsp;<center>
	<table class='bordertable' cellspacing=0 cellpadding=0 width=96%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 

  </td></tr></table>

  <center>

<?PHP include('modules/default/bottomnav.php');	?> 

  </center><br>

  </td></table><br></table>



 
