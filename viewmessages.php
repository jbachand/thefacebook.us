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

$message= new Message();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	extract($_POST);
	
	if($send=="Send"){
		$message->send($uid,$subject,$text);
		FBData::updatecount($uid);
	}	
	header("Location: viewmessages.php?id=".$uid);
}
	

$id=$sess->Retrieve('id');
$profile = new Profile($id);
?>
<title>TheFacebook |  View Messages</title> 
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
	  Messages
	  </td></tr></table>


<br>
<table cellspacing=0 cellpadding=6 border=0 width=97% align=center valign=top>
	<tr>
		<td width="100%" valign=top>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td  style='color:#538ADC'>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
								<?PHP
								if($_GET['compose']=='true') echo "Compose"; else echo "Message Center";
								?>
								</td>
								
							</tr>
						</table>
						<br>
						<center>
						<?PHP
						if($_GET['compose']=='true'){
						?>
						<form method=post><input type=hidden name=uid value="<?PHP echo $_GET['id'];?>">
						<table width=100%>
							<tr>
								<td>Subject:</td>
								<td><input type=text class="inputtext" style="width:450px" name="subject" value="<?PHP echo $_GET['subject'];?>"></td>
							</tr>
							<tr>
								<td>Message:</td>
								<td><textarea class="inputtextarea" style="width:450px;height:150px" name="text"></textarea></td>
							</tr>
							<tr>
								<td colspan=2>
									<input type=submit name=send value="Send" class="inputsubmit">&nbsp;&nbsp;&nbsp;<input type=submit name=cancel value="Cancel" class="inputsubmit">
						</table>
						</form>		
						<?PHP
							}else{
						?>
						[ <a href="messages.php">All Messages</a> ]&nbsp;&nbsp;&nbsp;
						[ <a href="messages.php?view=unread">Unread</a> ]&nbsp;&nbsp;&nbsp;
						<?PHP
						}
						?>
						</center>
						<br>
					</td>
				</tr>
			</table>

		<br><br>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Messages between you and <? echo $message->get_name($_GET['id']);?>
								</td>
								
							</tr>
						</table>
						<center>
						<table width=95%>
									<?PHP 
										
										
										switch($_GET['type']){
											case "unread":
												$messages=$message->viewthread($_GET['id'], 'unread');
											break;
											default:
												$messages=$message->viewthread($_GET['id']);
											break;
										}
										

										$message->markread($messages);
										
										foreach($messages as $messageids){
										
										if($messageids<1) continue;
										
										$thumb=$message->get_thumb_message($messageids);
										
										$name=$message->get_name_message($messageids);
										$messagerid=$message->get_userid_message($messageids);
										
										$subject=$message->get_subject($messageids);
										$resubject=urlencode("RE:".$subject);
										$text=$message->get_text($messageids);
										$time=$message->get_time($messageids);
										$time=date('M jS, Y g:h:i a',strtotime($time));
										
										$text=str_replace("\n", "<br>", $text);

										?>
										<tr>
											<td align=left>
												<table cellspacing=10 cellpadding=0  class='bottomborder' width="100%" >
													<tr valign=top>
														<td width="50px" align=left>
															<img border=0 src="<?PHP echo $thumb;?>">
															
														</td>
														<td width="400px" align=left valign=top>
															<a href="profile.php?id=<?PHP echo $messagerid;?>"><?PHP echo $name;?></a><br>
															<?PHP echo $time; ?><br>
															<b><?PHP echo $subject; ?></b><br>
															<?PHP echo $text; ?>		
														</td>
														<td width="50px" align=right  style="color:#538ae2">
														<?PHP
														if($messagerid!=$id){
														?>
														[ <a href="viewmessages.php?compose=true&subject=<?PHP echo $resubject;?>&id=<?PHP echo $_GET['id'];?>">Reply</a> ]<br>
														<?PHP }?>
														</td>
													</tr>
												</table><br>																
											</td>
										</tr>
											<?PHP } ?>
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



 
