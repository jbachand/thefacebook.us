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

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(!$profile->save($_POST))
		$error = "Error saving. Please try again later";
	else
		$profile = new Profile($id); //reloads profile
}
	


$dropdowns = new Dropdowns();
?>
<html xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
<title>TheFacebook | Edit Profile</title> 
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


</head>

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
	  Profile (This is you)
	  </td></tr></table>


<br>
<table cellspacing=0 cellpadding=6 border=0 width=97% align=center valign=top>
	<tr>


		<td width="100%" valign=top>
		<font color=red size=3><b><?PHP echo $error; ?></b></font>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Information
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
											<form method="post" action="editprofile.php">
												<table cellspacing=0 cellpadding=2 border=0 width=100%>
													<tr>
														<td colspan=2>
															<b>Account Info:</b>
														</td>
														
													</tr>
													<tr>
														<td style="width:110px">
															Name:
														</td>
														<td style="width:430px">
															<?PHP echo $profile->retrieve('name'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Member&nbsp;Since:
														</td>
														<td>
															<?PHP echo date("F j, Y", strtotime($profile->retrieve('registerdate'))); ?>
														</td>
													</tr>
													<tr>
														<td>
															Last&nbsp;Update:
														</td>
														<td>
															<?PHP echo date("F j, Y g:i a", strtotime($profile->retrieve('lastupdate'))); ?>
														</td>
													</tr>
													
													<?PHP
													if($_GET['s']=="basic"){
													?>
													<tr>
														<td>
															<b>Basic Info:</b>
														</td>
														<td align=right style="color:#538ae2">
															<input type="submit" class="inputsubmit" value="Save">
														</td>
													</tr>
													<tr>
														<td>
															School:
														</td>
														<td>
															<?PHP echo $profile->retrieve('school'); ?>
														</td>
													<tr>
													<tr>
														<td>
															Status:
														</td>
														<td>
															<select width='200px' class='inputtextprofile' name=status>
															<?PHP 
															$statusoptions=$dropdowns->options('schoolstatus');
															foreach ($statusoptions as $option){
																$opid=$option['id'];
																$opname=$option['name'];
																echo "<option value='$opid'";
																if($profile->retrieve('status')==$opname)
																	echo " selected";
																echo " >$opname</option>";
															}
															?>
															</select>
														</td>
													</tr>
													<tr>
														<td>
															Sex:
														</td>
														<td>
														<select width='200px' class='inputtextprofile' name=sex>
															<?PHP 
															$statusoptions=$dropdowns->options('sex');
															foreach ($statusoptions as $option){
																$opid=$option['id'];
																$opname=$option['name'];
																echo "<option value='$opid'";
																if($profile->retrieve('sex')==$opname)
																	echo " selected";
																echo " >$opname</option>";
															}
															?>
															</select>
															
														</td>
													</tr>
													<tr>
														<td>
															Residence:
														</td>
														<td>
															<input class='inputtextprofile' type=text name=residence value="<?PHP echo $profile->retrieve('residence'); ?>">
														</td>
													</tr>
													<tr>
														<td>
															Birthday:
														</td>
														<td>
														<input class='inputtextprofile' type=text name=birthday value="<?PHP
														$birthday=date("m/d/Y", strtotime($profile->retrieve('birthday'))); 
														if($birthday=='12/31/1969') $birthday="";
															echo $birthday;
															?>">
														</td>
													</tr>
													<tr>
														<td>
															Home&nbsp;Town:
														</td>
														<td>
															<input class='inputtextprofile' type=text name=hometown value="<?PHP echo $profile->retrieve('hometown'); ?>">
														</td>
													</tr>
													<tr>
														<td>
															Highschool:
														</td>
														<td>
															<input class='inputtextprofile' type=text name=highschool value="<?PHP echo $profile->retrieve('highschool'); ?>">
														</td>
													</tr>
													<?PHP
													}else{
													?>
													<tr>
														<td>
															<b>Basic Info:</b>
														</td>
														<td align=right style="color:#538ae2">
															[ <a href="editprofile.php?s=basic">edit</a> ]
														</td>
													</tr>
													<tr>
														<td>
															School:
														</td>
														<td>
															<?PHP echo $profile->retrieve('school'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Status:
														</td>
														<td>
															<?PHP echo $profile->retrieve('status'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Sex:
														</td>
														<td>
															<?PHP echo $profile->retrieve('sex'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Residence:
														</td>
														<td>
															<?PHP echo $profile->retrieve('residence'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Birthday:
														</td>
														<td>
															<?PHP $birthday=date("m/d/Y", strtotime($profile->retrieve('birthday'))); 
															if($birthday=='12/31/1969') $birthday="";
															echo $birthday;
															?>
														</td>
													</tr>
													<tr>
														<td>
															Home&nbsp;Town:
														</td>
														<td>
															<?PHP echo $profile->retrieve('hometown'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Highschool:
														</td>
														<td>
															<?PHP echo $profile->retrieve('highschool'); ?>
														</td>
													</tr>
													<?PHP
													}
													?>
													<?PHP
													if($_GET['s']=="contact"){
													?>
													<tr>
														<td>
															<b>Contact Info:</b>
														</td>
														<td align=right style="color:#538ae2">
															<input type="submit" class="inputsubmit" value="Save">
														</td>
													</tr>
													<tr>
														<td>
															Email:
														</td>
														<td>
															<input class='inputtextprofile' type=text name=email value="<?PHP echo $profile->retrieve('email'); ?>">
														</td>
													</tr>
													<tr>
														<td>
															Screenname:
														</td>
														<td>
															<input class='inputtextprofile' type=text name=screenname value="<?PHP echo $profile->retrieve('screenname'); ?>">
														</td>
													</tr>
													<tr>
														<td>
															Mobile:
														</td>
														<td>
															<input class='inputtextprofile' type=text name=mobile value="<?PHP echo $profile->retrieve('mobile'); ?>">
														</td>
													</tr>
													<tr>
														<td>
															Websites:
														</td>
														<td>
															<textarea class='inputtextareaprofile' name=websites><?PHP echo $profile->retrieve('website'); ?></textarea>
														</td>
													</tr>
													<?PHP
													}else{
													?>
													<tr>
														<td>
															<b>Contact Info:</b>
														</td>
														<td align=right style="color:#538ae2">
															[ <a href="editprofile.php?s=contact">edit</a> ]
														</td>
													</tr>
													<tr>
														<td>
															Email:
														</td>
														<td>
															<?PHP echo $profile->retrieve('email'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Screenname:
														</td>
														<td>
															<?PHP echo $profile->retrieve('screenname'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Mobile:
														</td>
														<td>
															<?PHP echo $profile->retrieve('mobile'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Websites:
														</td>
														<td>
															<?PHP echo $profile->retrieve('website'); ?>
														</td>
													</tr>
													<?PHP
													}
													?>
													<?PHP
													if($_GET['s']=="personal"){
													?>
													<tr>
														<td >
															<b>Personal Info:</b>
														</td>
														<td align=right style="color:#538ae2">
															<input type="submit" class="inputsubmit" value="Save">
														</td>
													</tr>
													<tr>
														<td>
															Looking&nbsp;For:
														</td>
														<td>
															<?PHP 
															$statusoptions=$dropdowns->options('lookingfor');
															$lookingforvalues=$profile->retrieve('lookingfor');
															if(!is_array($lookingforvalues))
																$lookingforvalues=array($profile->retrieve('lookingfor'));
																
															foreach ($statusoptions as $option){
																$opid=$option['id'];
																$opname=$option['name'];
																echo "<input type=checkbox name='lookingfor[]' value='$opid'";
																if(in_array($opname,$lookingforvalues))
																	echo " checked='checked'";
																echo " > $opname <br />";
															}
															?>
														</td>
													</tr>
													<tr>
														<td>
															Interested&nbsp;In:
														</td>
														<td>
														
															<?PHP 
															$statusoptions=$dropdowns->options('interestedin');
															$lookingforvalues=$profile->retrieve('interestedin');
															if(!is_array($lookingforvalues))
																$lookingforvalues=array($profile->retrieve('interestedin'));
																
															foreach ($statusoptions as $option){
																$opid=$option['id'];
																$opname=$option['name'];
																echo "<input type=checkbox name='interestedin[]' value='$opid'";
																if(in_array($opname,$lookingforvalues))
																	echo " checked='checked'";
																echo " > $opname <br />";
															}
															?>
														</td>
													</tr>
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
																		echo "<a href='profile.php?id=$receiverid[$key]'>$receivername[$key]</a> [ <a href='confirmremove.php?id=$receiverid[$key]'>remove</a> ]";
																	else
																		echo "<a href='profile.php?id=$senderid[$key]'>$sendername[$key]</a> [ <a href='confirmremove.php?id=$senderid[$key]'>remove</a> ]";
																		
																	echo "<br>";
																	}
																
															}else if($senderid>0||$receiverid>0){
																echo "$relationship with ";
																	
																if($senderid==$id)
																	echo "<a href='profile.php?id=$receiverid'>$receivername</a> [ <a href='confirmremove.php?id=$recieverid'>remove</a> ]";
																else
																	echo "<a href='profile.php?id=$senderid'>$sendername</a> [ <a href='confirmremove.php?id=$senderid'>remove</a> ]";
															}else echo "Single";
															?>
														</td>
													</tr>
													<tr>
														<td>
															Political&nbsp;Views:
														</td>
														<td>
															<select class='inputtextprofile' name=political>
															<?PHP 
															$politicaloptions=$dropdowns->options('political');
															foreach ($politicaloptions as $option){
																$opid=$option['id'];
																$opname=$option['name'];
																echo "<option value='$opid'";
																if($profile->retrieve('political')==$opname)
																	echo " selected";
																echo " >$opname</option>";
															}
															?>
															</select>
														</td>
													</tr>
													<tr>
														<td>
															Interests:
														</td>
														<td>
														<textarea class='inputtextareaprofile' name=interests><?PHP 
															if(is_array($interests=$profile->retrieve('interests'))){
																foreach($interests as $value){
																	echo $value;
																	if(!next($interests)===FALSE) echo ", ";
																}
															}else
																echo $interests;
															?></textarea>
														</td>
													</tr>
													<tr>
														<td>
															Music:
														</td>
														<td>
														<textarea class='inputtextareaprofile' name=music><?PHP 
															if(is_array($music=$profile->retrieve('music'))){
																foreach($music as $value){
																	echo $value;
																	if(!next($music)===FALSE) echo ", ";
																}
															}else
																echo $music;
															?></textarea>
														</td>
													</tr>
													<tr>
														<td>
															Classes:
														</td>
														<td>
														<textarea class='inputtextareaprofile' name='classes'><?PHP 
															if(is_array($classes=$profile->retrieve('classes'))){
																foreach($classes as $value){
																	echo $value;
																	if(!next($classes)===FALSE) echo "\n";
																}
															}else
																echo $classes;
															?></textarea>
														</td>
													<tr>
													<!-- <tr>
														<td>
															Fridge:<br>(friends only)
														</td>
														<td>
														<textarea class='inputtextareaprofile' name='fridge'><?PHP 
															if(is_array($fridge=$profile->retrieve('fridge'))){
																foreach($fridge as $value){
																	echo $value;
																	if(!next($fridge)===FALSE) echo "\n";
																}
															}else
																echo $fridge;
															?></textarea>
														</td>
													<tr> -->
													<?PHP
													}else{
													?>
													<tr>
														<td >
															<b>Personal Info:</b>
														</td>
														<td align=right style="color:#538ae2">
															[ <a href="editprofile.php?s=personal">edit</a> ]
														</td>
													</tr>
													<tr>
														<td>
															Looking&nbsp;For:
														</td>
														<td>
															<?PHP 
															if(is_array($lookingfor=$profile->retrieve('lookingfor'))){
																foreach($lookingfor as $value){
																	echo $value;
																	if(!next($lookingfor)===FALSE) echo ", ";
																}
															}else
																echo $lookingfor;
															?>
														</td>
													</tr>
													<tr>
														<td>
															Interested&nbsp;In:
														</td>
														<td>
															<?PHP 
															if(is_array($interestedin=$profile->retrieve('interestedin'))){
																foreach($interestedin as $value){
																	echo $value;
																	if(!next($interestedin)===FALSE) echo ", ";
																}
															}else
																echo $interestedin;
															?>
														</td>
													</tr>
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
																
															}else if($senderid>0||$receiverid>0){
																echo "$relationship with ";
																	
																if($senderid==$id)
																	echo "<a href='profile.php?id=$receiverid'>$receivername</a>";
																else
																	echo "<a href='profile.php?id=$senderid'>$sendername</a>";
															}else echo "Single";
															?>
														</td>
													</tr>
													<tr>
														<td>
															Political&nbsp;Views:
														</td>
														<td>
															<?PHP echo $profile->retrieve('political'); ?>
														</td>
													</tr>
													<tr>
														<td>
															Interests:
														</td>
														<td>
															<?PHP 
															if(is_array($interests=$profile->retrieve('interests'))){
																foreach($interests as $value){
																	echo $value;
																	if(!next($interests)===FALSE) echo ", ";
																}
															}else
																echo $interests;
															?>
														</td>
													</tr>
													<tr>
														<td>
															Music:
														</td>
														<td>
															<?PHP 
															if(is_array($music=$profile->retrieve('music'))){
																foreach($music as $value){
																	echo $value;
																	if(!next($music)===FALSE) echo ", ";
																}
															}else
																echo $music;
															?>
														</td>
													</tr>
													<tr>
														<td>
															Classes:
														</td>
														<td>
															<?PHP 
															if(is_array($classes=$profile->retrieve('classes'))){
																foreach($classes as $value){
																	echo $value;
																	if(!next($classes)===FALSE) echo "<br>";
																}
															}else
																echo $classes;
															?>
														</td>
													<tr>
													<!--<tr>
														<td>
															Fridge:<br>(friends only)
														</td>
														<td>
															<?PHP 
															if(is_array($fridge=$profile->retrieve('fridge'))){
																foreach($fridge as $value){
																	echo $value;
																	if(!next($fridge)===FALSE) echo "<br>";
																}
															}else
																echo $fridge;
															?>
														</td>
													<tr>-->
													<?PHP
													}
													?>
												</table>
												<?PHP if(isset($_GET['s'])){?>
												<input type="submit" class="inputsubmit" value="Save">
												<?PHP } ?>
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
	
	</table>
	<br>&nbsp;<center>
	<table class='bordertable' cellspacing=0 cellpadding=0 width=96%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 

  </td></tr></table>

  <center>

<?PHP include('modules/default/bottomnav.php');	?> 

  </center><br>

  </td></table><br></table>



 
