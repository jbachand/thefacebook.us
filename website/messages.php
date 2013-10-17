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
$profile = new Profile($id);
?>
<title>TheFacebook | Messages</title> 
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
					<td style='color:#538ADC'>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Message Center
								</td>
								
							</tr>
						</table>
						<br>
						<center>
						[ <a href="?">All Messages</a> ]&nbsp;&nbsp;&nbsp;
						[ <a href="?view=unread">Unread</a> ]

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
									<?PHP
									if(strlen($_GET['view'])<1) echo "All Messages"; else echo "Unread Messages";
									?>
								</td>
								
							</tr>
						</table>
						<center>
						<table width=95%>
									<?PHP 
										$message= new Message();
										
										switch($_GET['view']){
											case "inbox":
												//$messages=$message->viewinbox();
											break;
											case "outbox":
												//$messages=$message->viewsentbox();
											break;
											case "unread":
												$messages=$message->viewunread();
											break;
											default:
												$messages=$message->messagecenter();
											break;
										}
										
										$shownresults = 0;
										foreach($messages as $threads){
										
										if($threads<1) continue;
										$shownresults++;
										
										$thumb=$message->get_thumb($threads);
										$name=$message->get_name($threads);
										
										$threadview=$_GET['view'];
										if(!$threadview) $threadview='both';
										if($threadview=='unread') $threadview='inbox';
										$lastsubject=$message->get_lastsubject($threads, $threadview);
										$lasttext=substr($message->get_lasttext($threads, $threadview),0,20)."...";
										
										$time=$message->get_lasttime($threads, $threadview);
										$lasttime=date('M jS, Y g:h:i a',strtotime($time));
										
										$messagecount=$message->get_messagecount($threads);
										$unreadmessages=$message->get_messagecount($threads,'unread');
										if($unreadmessages>0) $backgroundcolor="bgcolor='#e4e2e2'"; else $backgroundcolor="";
											?>
										<tr>
											<td align=left>
												<table cellspacing=10 cellpadding=0  class='bordertable' width="100%" <?PHP echo $backgroundcolor;?>>
													<tr valign=stop>
														<td width="50px" align=left>
															<img border=0 src="<?PHP echo $thumb;?>">
														</td>
														<td width="150px" align=left>
															<a href="profile.php?id=<?PHP echo $threads;?>"><?PHP echo $name;?></a><br>
															<?PHP echo $lasttime; ?><br>
															<b><?PHP echo $lastsubject; ?></b><br>
															<?PHP echo $lasttext; ?>		
														</td>
														<td width="300px" align=right   style='color:#538ADC'>
														<?PHP if($unreadmessages>0) { ?>
														[ <a href="viewmessages.php?type=unread&id=<?PHP echo $threads;?>">Unread</a> (<?PHP echo $unreadmessages; ?>) ]
														<?PHP } ?>
														[ <a href="viewmessages.php?id=<?PHP echo $threads;?>">All Messages</a> (<?PHP echo $messagecount; ?>) ]
														</td>
													</tr>
												</table><br>																
											</td>
										</tr>
											<?PHP } 
											if($shownresults==0&&$_GET['view']=='unread') echo "<tr><td><br>It appears you have no unread messages. <a href='messages.php'>View all messages.</a><br><br></td></tr>";
											if($shownresults==0&&$_GET['view']!='unread') echo "<tr><td><br>It appears you have no messages.<br><br></td></tr>";
											
											?>
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



 
