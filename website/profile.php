<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); 
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
//echo 'Classes loaded in: '.$total_time.' seconds.'."\n";

$id=$_GET['id'];
$log= new log($_SERVER["REQUEST_URI"]);

	$sess = new SessionData();					// Creates session object
	$sess->CheckValidFBSession();
	if(!$sess->CheckValidSession()){			// Validates Session
		$sess->Login();

	}



	if($sess->Retrieve('id')==$id){
		header('Location: profile.php');
		exit();
	}

$uid=$sess->Retrieve('id');


	$db = new Database();						// Creates database object
	if(!$db->connect()){
		echo "<p>Error connecting to the database</p>";
	}
	
	if(!$id||$id=="0") $id=$uid;


$profile = new Profile($id);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
//echo 'Basic profile data loaded in: '.$total_time.' seconds.'."\n";
$connection = $profile->viewable_profile($id);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
//echo 'Viewable profile data loaded in: '.$total_time.' seconds.'."\n";
if($id==$uid) $connection="This is you.";

	if(!$connection&&$sess->Retrieve('id')!=3){
		header('Location: search.php?id='.$id);
	}
	
$friendarray=$profile->friendsids($uid,0,5000);

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
//echo 'Friend data loaded in: '.$total_time.' seconds.'."\n";

?>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>TheFacebook | <?PHP echo $profile->retrieve('name'); ?></title> 
<link rel="stylesheet" href="style.css"> 
<link rel="shortcut icon" href="favicon.ico"> 
</head>
 <body>
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
	  <?PHP echo $profile->retrieve('name'); ?>'s Profile <?=($id==$uid)?'&nbsp;(This is you)':''?>
	  </td></tr></table>


<br>
<table cellspacing=0 cellpadding=6 border=0 width=97% align=center valign=top>
	<tr>
		<td width="40%" valign=top>
			
			
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998 colspan=2>
									Picture
								</td>
								<?PHP if($uid==$id){?>
								<td align=right class='white' bgcolor=#3B5998>
									[ <a href="editpicture.php" class=menu>edit</a> ]
								</td>
								<?PHP } ?>
							</tr>
						</table>
						&nbsp;<br><center>
				
						<table cellspacing=0 cellpadding=2 border=0 width=95%>
							<tr>
								<td align=center>
									<?PHP 
									$pic=$profile->retrieve('defaultpicture');
									
										
									echo "<img src='$pic'>"; 
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			<br>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<?PHP
				if($id==$uid){
				?>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td>
									<a href="editprofile.php">Edit your profile</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			
				<tr >
					<td>
						<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td>
									<a href="account.php">My account preferences</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr >
					<td>
						<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td>
									<a href="accountprivacy.php">My privacy preferences</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?PHP }else{ ?>
				<?PHP $atf=false; if(is_array($friendarray)) if($id!=$uid&&!in_array($id,$friendarray)) { $atf=true;?>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td>
									<a href="addfriend.php?id=<?PHP echo $id; ?>">Add to Friends</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?PHP } ?>
				<tr>
					<td>
						<table <?PHP if($atf) echo "class='bordertop'"; ?> cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td>
									<a href="viewmessages.php?compose=true&id=<?PHP echo $id; ?>">Send a Message</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table  class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td>
									<a href="friends.php?id=<?PHP echo $id; ?>">View Friends</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?PHP } ?>
				<!--
				<tr>
					<td>
						<table  class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td>
									<a href="mash.php?id=<?PHP echo $id; ?>">Mash!</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			-->
			</table>
			

			
			<br>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Connection
								</td>
							</tr>
						</table>				
						<table cellspacing=0 cellpadding=2 border=0 width=95% align=center>
							<tr>
								<td align=center>
									<?PHP print_r($connection); 
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			<br>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998 colspan=2>
									Friends at <?PHP echo $profile->retrieve('school'); ?>
								</td>
								<?PHP if($uid==$id){ ?>
								<td align=right class='white' bgcolor=#3B5998>
									[ <a href="editfriends.php" class=menu>edit</a> ]
								</td>
								<?PHP } ?>
							</tr>
						</table>
						&nbsp;<br><center>
				
						<table cellspacing=0 cellpadding=2 border=0 width=95%>
							<tr>
								<td>
									<?PHP 
									$random6=$profile->random6($id);
									?>
									<table width=90%>
										<tr>
											<?PHP for($threeimg=0;$threeimg<=2;$threeimg++){
												if($random6[$threeimg]['id']>0){
											?>
											<td align=center>
												<a href="profile.php?id=<?PHP echo $random6[$threeimg]['id'];?>">
												<img border=0 src="<?PHP echo $random6[$threeimg]['thumb'];?>"><br>
												<?PHP echo $random6[$threeimg]['name'];?></a>
											</td>
											<?PHP } } ?>
										</tr>
										<tr>
											<?PHP for($threeimg=3;$threeimg<=5;$threeimg++){
												if($random6[$threeimg]['id']>0){
											?>
											<td align=center>
												<a href="profile.php?id=<?PHP echo $random6[$threeimg]['id'];?>">
												<img border=0 src="<?PHP echo $random6[$threeimg]['thumb'];?>"><br>
												<?PHP echo $random6[$threeimg]['name'];?></a>
											</td>
											<?PHP } } ?>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			
			
		</td>

		<td width="60%" valign=top>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998 colspan=2>
									Information
								</td>
								<?PHP if($uid==$id){ ?>
								<td align=right class='white' bgcolor=#3B5998>
									[ <a href="editprofile.php" class=menu>edit</a> ]
								</td>
								<?PHP } ?>
							</tr>
						</table>
						<center>
						<table cellspacing=0 cellpadding=2 border=0 width=95%>
							<tr>
								<td>
									<table cellspacing=0 cellpadding=0 border=0>
										<tr>
											<td>
												<table cellspacing=0 cellpadding=2 border=0>
													<tr>
														<td colspan=2>
															<b>Account Info:</b>
														</td>
														
													</tr>
													<tr>
														<td style="width:104px">
															Name:
														</td>
														<td style="width:187px">
															<?PHP echo $profile->retrieve('name'); ?>
														</td>
													<tr>
													<tr>
														<td>
															Member&nbsp;Since:
														</td>
														<td>
															<?PHP echo date("F j, Y", strtotime($profile->retrieve('registerdate'))); ?>
														</td>
													<tr>
													<tr>
														<td>
															Last&nbsp;Update:
														</td>
														<td>
															<?PHP echo date("F j, Y g:i a", strtotime($profile->retrieve('lastupdate'))); ?>
														</td>
													<tr>
													<tr>
														
														<?PHP if($uid==$id){?>
														<td>
															<b>Basic Info:</b>
														</td>
														<td align=right style="color:#538ae2">
															[ <a href="editprofile.php?s=basic">edit</a> ]
														</td>
														<?PHP } else {?>
														<td colspan=2>
															<b>Basic Info:</b>
														</td>
														<?PHP } ?>
														
													</tr>
													<tr>
														<td>
															School:
														</td>
														<td>
															<?PHP echo "<a href='search.php?school=".$profile->retrieve('school')."'>".$profile->retrieve('school')."</a>"; ?>
														</td>
													<tr>
													<tr>
														<td>
															Status:
														</td>
														<td>
															<?PHP echo "<a href='search.php?status=".$profile->retrieve('status')."'>".$profile->retrieve('status')."</a>"; ?>
														</td>
													<tr>
													<tr>
														<td>
															Sex:
														</td>
														<td>
															<?PHP echo "<a href='search.php?sex=".$profile->retrieve('sex')."'>".$profile->retrieve('sex')."</a>"; ?>
														</td>
													<tr>
													<tr>
														<td>
															Residence:
														</td>
														<td>
															<?PHP echo "<a href='search.php?residence=".$profile->retrieve('residence')."'>".$profile->retrieve('residence')."</a>"; ?>
														</td>
													<tr>
													<tr>
														<td>
															Birthday:
														</td>
														<td>
															<?PHP $birthday=date("m/d/Y", strtotime($profile->retrieve('birthday'))); 
															if($birthday=='12/31/1969') $birthday="";
															echo "<a href='search.php?birthday=$birthday'>$birthday</a>";
															?>
														</td>
													<tr>
													<tr>
														<td>
															Home&nbsp;Town:
														</td>
														<td>
															<?PHP echo "<a href='search.php?hometown=".$profile->retrieve('hometown')."'>".$profile->retrieve('hometown')."</a>"; ?>
														</td>
													<tr>
													<tr>
														<td>
															Highschool:
														</td>
														<td>
															<?PHP echo $profile->retrieve('highschool'); ?>
														</td>
													<tr>
													<tr>
														
														<?PHP if($uid==$id){?>
														<td>
															<b>Contact Info:</b>
														</td>
														<td align=right style="color:#538ae2">
															[ <a href="editprofile.php?s=contact">edit</a> ]
														</td>
														<?PHP } else {?>
														<td colspan=2>
															<b>Contact Info:</b>
														</td>
														<?PHP } ?>
														
													</tr>
													<tr>
														<td>
															Email:
														</td>
														<td>
															<?PHP echo $profile->retrieve('email'); ?>
														</td>
													<tr>
													<tr>
														<td>
															Screenname:
														</td>
														<td>
															<?PHP echo $profile->retrieve('screenname'); ?>
														</td>
													<tr>
													<tr>
														<td>
															Mobile:
														</td>
														<td>
															<?PHP echo $profile->retrieve('mobile'); ?>
														</td>
													<tr>
													<tr>
														<td>
															Websites:
														</td>
														<td>
															<?PHP echo $profile->make_clickable($profile->retrieve('website')); ?>
														</td>
													<tr>
													<tr>
														<?PHP if($uid==$id){?>
														<td>
															<b>Personal Info:</b>
														</td>
														<td align=right style="color:#538ae2">
															[ <a href="editprofile.php?s=personal">edit</a> ]
														</td>
														<?PHP } else {?>
														<td colspan=2>
															<b>Personal Info:</b>
														</td>
														<?PHP } ?>
														
													</tr>
													<tr>
														<td>
															Looking&nbsp;For:
														</td>
														<td>
															<?PHP 
															if(is_array($lookingfor=$profile->retrieve('lookingfor'))){
																foreach($lookingfor as $value){
																	echo "<a href='search.php?lookingfor=$value'>$value</a>";
																	if(!next($lookingfor)===FALSE) echo ", ";
																}
															}else
																echo "<a href='search.php?lookingfor=$lookingfor'>$lookingfor</a>";
															?>
														</td>
													<tr>
													<tr>
														<td>
															Interested&nbsp;In:
														</td>
														<td>
															<?PHP 
															if(is_array($interestedin=$profile->retrieve('interestedin'))){
																foreach($interestedin as $value){
																	echo "<a href='search.php?interestedin=$value'>$value</a>";
																	if(!next($interestedin)===FALSE) echo ", ";
																}
															}else
																echo "<a href='search.php?interestedin=$interestedin'>$interestedin</a>";
															?>
														</td>
													<tr>
													<tr>
														<td>
															Relationship&nbsp;Status:
														</td>
														<td>
															<?PHP 
															$senderid=$profile->retrieve('relationshipsenderid');
															$receiverid=$profile->retrieve('relationshipreceiverid');
															$sendername=$profile->retrieve('relationshipsender');
															$receivername=$profile->retrieve('relationshipreceiver');
															
															if(is_array($relationship=$profile->retrieve('relationship'))){
																foreach($relationship as $key => $value){
																
																	echo "$value with ";
																	
																	if($senderid[$key]==$id)
																		echo "<a href='profile.php?id=$receiverid[$key]'>$receivername[$key]</a>";
																	else
																		echo "<a href='profile.php?id=$senderid[$key]'>$sendername[$key]</a>";
																		
																	echo "<br>";
																	}
																
															}else if($relationship){
																
																echo "$relationship with ";
																	
																if($senderid==$id)
																	echo "<a href='profile.php?id=$receiverid'>$receivername</a>";
																else
																	echo "<a href='profile.php?id=$senderid'>$sendername</a>";;
															}else echo "Single";
															?>
														</td>
													<tr>
													<tr>
														<td>
															Political&nbsp;Views:
														</td>
														<td>
															<?PHP echo "<a href='search.php?political=".$profile->retrieve('political')."'>".$profile->retrieve('political')."</a>"; ?>
														</td>
													<tr>
													<tr>
														<td>
															Interests:
														</td>
														<td>
															<?PHP 
															if(is_array($interests=$profile->retrieve('interests'))){
																foreach($interests as $value){
																	echo "<a href='search.php?interests=$value'>$value</a>";
																	if(!next($interests)===FALSE) echo ", ";
																}
															}else
																echo "<a href='search.php?interests=$interests'>$interests</a>";
															?>
														</td>
													<tr>
													<tr>
														<td>
															Music:
														</td>
														<td>
															<?PHP 
															if(is_array($music=$profile->retrieve('music'))){
																foreach($music as $value){
																	echo "<a href='search.php?music=$value'>$value</a>";
																	if(!next($music)===FALSE) echo ", ";
																}
															}else
																echo "<a href='search.php?music=$music'>$music</a>";
															?>
														</td>
													<tr>
													<tr>
														<td>
															Classes:
														</td>
														<td>
															<?PHP 
															if(is_array($classes=$profile->retrieve('classes'))){
																foreach($classes as $value){
																	echo "<a href='search.php?class=".urlencode($value)."'>$value</a>";
																	if(!next($classes)===FALSE) echo "<br> ";
																}
															}else
																echo "<a href='search.php?class=".urlencode($classes)."'>$classes</a>";
															?>
														</td>
													<tr>
													<?PHP 
													/*
													if(in_array($id,$friendarray)||$id==$uid){
													?>
													<tr>
														<td>
															Fridge:<br>(friends only)
														</td>
														<td>
															<?PHP 
															if(is_array($fridge=$profile->retrieve('fridge'))){
																foreach($fridge as $value){
																	echo "<a href='search.php?fridge=".urlencode($value)."'>$value</a>";
																	if(!next($fridge)===FALSE) echo "<br> ";
																}
															}else
																echo "<a href='search.php?fridge=".urlencode($fridge)."'>$fridge</a>";
															?>
														</td>
													<tr>
													<?}
													*/
													?>
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
  <?PHP
  
  $time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<!--Page loaded in: '.$total_time.' seconds.'."\n-->";
?>



 
