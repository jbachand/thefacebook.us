<?PHP

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib

$sess = new SessionData();					// Creates session object
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
	if($_REQUEST['confirm'] == "Confirm")
	$success=$relation->confirm($id,$fid);
	else if($_REQUEST['deny'] == "Deny")
	$success=$relation->deny($id,$fid);
	else
	$success=$relation->add_relationship($id,$fid,$_POST['addas']);
	
	if($success<0){
	$cases=$success;
	$success=TRUE;
		switch($cases){
			case -6:
				$error="You already have the maximum amount of personal connections, please remove one before you try to add another";
			break;
			case -5:
				$error="A request has been previously submitted for the user that has not been confirmed yet.";
			break;
			case -4:
				$error="This user has too many pending requests, please try again later.";
			break;
			case -3:
				$error="You have too many pending friend requests, please try again later.";
			break;
			case -2:
				$error="You are already in this relationship.";
			break;
			case -1:
				$error="You cannot add yourself.";
			break;
			default:
				$error="An error has occurred, please try again later.";
				$success=FALSE;
			break;
		}
		$error.="<br>";
		
	}else{
		$error=	"</b></font>A request has been sent to ".$profile->retrieve("name")." to confirm your request.";
		if($_REQUEST['confirm']=="Confirm") $error="</b></font>Confirmed! <a href='profile.php?id=".$fid."'>View their profile</a> or <a href='reqs.php'>Go Back to Pending Requests</a>";
		if($_REQUEST['deny']=="Deny") $error="</b></font>The request has been removed. <a href='reqs.php'>Go Back to Pending Requests</a>";

		$success=true;
	}
	
}

$yourpending=$relation->pending_requests();
		if(in_array($fid,$yourpending)){
			$success=true;
			$relationshipwanted=strtolower($relation->getname('relationshiptype',$relation->getrelationshiptype($id,$fid)));
			$error= "</b></font><form method=post action=addfriend.php><input type=hidden name=id value='".$fid."'><a href='profile.php?id=".$fid."'>".$profile->retrieve("name")."</a> would like you to confirm that you are ".$relationshipwanted.". <input class=inputsubmit type=submit name='confirm' value='Confirm'><input class=inputsubmit type=submit name='deny' value='Deny'></form>";
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
	  Connect
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
									Send a request to <?PHP echo $profile->retrieve("name");?>
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
								Send a request to <?PHP echo $profile->retrieve("name");?> so they can confirm you are
								<?PHP
								$addas=Dropdowns::options('relationshiptype');
								?>
								<select name=addas>
									<?PHP foreach ($addas as $addasname){
										echo "<option>".$addasname['name']."</option>";
										}
									?>
								</select>
								<br>
								<input type=submit name=submit value="Request" class=inputsubmit>
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



 
