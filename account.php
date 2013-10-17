<?PHP

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib

$sess = new SessionData('account');					// Creates session object
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
$profile = new Profile($id);

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(strlen($_POST['savepassword'])>5){
		//echo "update";
		$o=$_POST['o'];
		$n=$_POST['n'];
		$c=$_POST['c'];
		$result=$profile->updatepassword($o,$n,$c);
		if($result==1) $error="</font>Password Updated"; else $error="An error has occurred";
	}
	
	if(strlen($_POST['deactivate'])>5){
		$profile->deactivate();
		$sess->Logout();
		//echo "deactivate";
	}
	
	if(strlen($_POST['activate'])>3){
		$profile->activate();
		Authenticate::reauth($id);
		header("Location: home.php");
		//echo "deactivate";
	}
	/*if(!$profile->save($_POST))
		$error = "Error saving. Please try again later";
	
	else
		$profile = new Profile($id); //reloads profile
		*/
		
}
	
	


$dropdowns = new Dropdowns();
?>
<title>TheFacebook | Account Preferences</title> 
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
	  Account Preferences
	  </td></tr></table>


<br>
<table cellspacing=0 cellpadding=6 border=0 width=97% align=center valign=top>
	<tr>


		<td width="100%" valign=top>
		<?PHP 
			if($sess->Retrieve('accountstatus')>1){
		?>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Name
								</td>
								
							</tr>
						</table>
						<center>
						<table cellspacing=0 cellpadding=2 border=0 width=95%>
							<tr>
								<td>
									<table cellspacing=0 cellpadding=0 border=0 width=100%>
										<tr>
											<td>
												<table cellspacing=0 cellpadding=2 border=0 width=100%>
													<tr>
														<td style="width:110px">
															Name:
														</td>
														<td style="width:430px">
															<?PHP echo $profile->retrieve('name'); ?><br>
															
														</td>
													</tr>
													<tr>
														<td colspan=2>
															<b>To edit your name, please contact info@thefacebook.us</b>
														</td>
													</tr>

													
												</table>
											
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			<br>
			<!--
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Password
								</td>
								
							</tr>
						</table>
						<center>
						<table cellspacing=0 cellpadding=2 border=0 width=95%>
							<tr>
								<td>
									<table cellspacing=0 cellpadding=0 border=0 width=100%>
										<tr>
											<td>
												<table cellspacing=0 cellpadding=2 border=0 width=100%>
													<tr>
														<td style="width:110px">
															Update Password:
														</td>
														<td style="width:430px">
														<font color=red><b><?PHP echo $error; ?></b></font>
															<form method="post" action="account.php">
															<table>
																<tr>
																	<td>Old:</td>
																	<td><input class="inputtextprofile" type="password" name="o" value=""></td>
																</tr>
																<tr>
																	<td>New:</td>
																	<td><input class="inputtextprofile" type="password" name="n" value=""></td>
																</tr>
																<tr>
																	<td>Confirm:</td>
																	<td><input class="inputtextprofile" type="password" name="c" value=""></td>
																</tr><tr>
																	<td colspan=2><input class="inputsubmit" type="submit" name="savepassword" value="Update Password"></td>
																</tr>
															</table>
															</form>
														</td>
													</tr>	

													
												</table>
											
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
-->			
			<? } ?>
	
	
	<br>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Account Status
								</td>
								
							</tr>
						</table>
						<center>
						<table cellspacing=0 cellpadding=2 border=0 width=95%>
							<tr>
								<td>
									<table cellspacing=0 cellpadding=0 border=0 width=100%>
										<tr>
											<td>
												<table cellspacing=0 cellpadding=2 border=0 width=100%>
														<tr>
														<td style="width:110px" valign=top>
															Account Status:
														</td>
														<td style="width:430px" valign=top>
															<form method=post>
															<?PHP 
															if($sess->Retrieve('accountstatus')==-1){
															?>
															<input class="inputsubmit" type="submit" name="activate" value="Activate Account">															
															<?PHP }else{?>
															<input class="inputsubmit" type="submit" name="deactivate" value="Deactivate Account">
															<?PHP }?>
															</form>
														</td>
													</tr>
													
												</table>
											
											</td>
										</tr>
									</table>
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



 
