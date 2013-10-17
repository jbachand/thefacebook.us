<?PHP 
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib


//$log= new log($_SERVER["REQUEST_URI"]);
$log= new log($_SERVER["PHP_SELF"], $_GET, $_POST, $_SERVER['HTTP_REFERER'] ); 


	$sess = new SessionData();					// Creates session object
	$sess->CheckValidFBSession();
	if(!$sess->CheckValidSession()){			// Validates Session
		$sess->Login();

	}


	if($sess->Retrieve('id')!=3&&$sess->Retrieve('id')!=100002408771848){
		//header('Location: profile.php');
		//exit();
	}

$id=$sess->Retrieve('id');

	$db = new Database();						// Creates database object
	if(!$db->connect()){
		echo "<p>Error connecting to the database</p>";
	}
	

	//FBData::clearcount($id);

	
$uid=$id;

$pokeid=$_GET['id'];

$profile = new Profile($pokeid);


?>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>TheFacebook | Poke</title> 
<link rel="stylesheet" href="style.css"> 
<link rel="shortcut icon" href="favicon.ico"> 
</head>
 <body>
 
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
					<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998 colspan=2>
									Poke Someone
								</td>
							</tr>
						</table>
						<table cellspacing=0 cellpadding=2 border=0 width=100% style="padding:10px"> 
							<tr>
								<td>
								<? if($pokeid==$id):?>
								<font color='red'>*You cannot poke yourself.</font>
								<br><br>
								To return to your home page, <a href='home.php'>click here</a>.
								<? else: 
								echo "Poked ".$profile->profile['name'];
								?>
								<br><br>
								<a href="<?=Log::lastpage($id)?>">Click here</a> to continue.
								<? endif; ?>
								</td>
							</tr>
						</table>

	 
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



 
