<?PHP
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib

$sess = new SessionData();					// Creates session object
$sess->CheckValidFBSession();
if(!$sess->CheckValidSession()){			// Validates Session
	$sess->Login();
}

$log= new log($_SERVER["REQUEST_URI"]);
$db = new Database();						// Creates database object
if(!$db->connect()){
	echo "<p>Error connecting to the database</p>";
}

foreach ($_GET as $searchid => $searchterm){
break;
}

if(!$searchid) $searchid="name";
//if(!$searchterm) $searchterm="null";

$id=$sess->Retrieve('id');
$profile = new Profile($id);
$friendarray=$profile->friendsids($id,0,999999);

$searchterms=array('User ID'=>'id', 'Name'=>'name', 'School'=>'school', 'School Status'=>'status', 'Sex'=>'sex', 'Residence'=>'residence', 'Birthday'=>'birthday', 'Home Town'=>'hometown', 'Looking For'=>'lookingfor', 'Interested In'=>'interestedin', 'Political Views'=>'political', 'Interests'=>'interests', 'Preferred Music'=>'music', 'Classes'=>'class', 'Mutual friends'=>'mfriends');
// removed: 'Fridge contents'=>'fridge', 

?>
<html xmlns:fb="http://www.facebook.com/2008/fbml"  xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>TheFacebook | Search</title> 
<link rel="stylesheet" href="style.css"> 
<link rel="shortcut icon" href="favicon.ico"> 
</head>
 <body style="overflow: visible">

 <div id="fb-root"></div>
  <script>
 
	window.fbAsyncInit = function() {
    FB.init({
      appId  : '<?PHP echo $app_id;?>',
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true  // parse XFBML
    });

	 FB.Canvas.setAutoResize();
 
  };

  (function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  }());


	function sendreq(type,uid) {
	if(type=="message")
		mess='<? echo $fbreq_message;?>';
	if(type=="friend")
		mess='<? echo $fbreq_friend;?>';
	
	  FB.ui({
		method: 'apprequests',
		message: mess,
		to: uid,
		data: 'senddata'
	  },
	   function(response) {
		 if (response) {
		   alert('Post was published.');
		 } else {
		   alert('Post was not published.');
		 }
	   }
	  
	  );
	}
	



  </script>
 <style>
 	img.normal{
 		max-width:100px
 	}
 </style>

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
	  Search
	  </td></tr></table>


<br>
<table cellspacing=0 cellpadding=6 border=0 width=97% align=center valign=top>
	<tr>


		<td width="100%" valign=top>
		<?PHP
		if($_GET['hide']!='y'){?>
		<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Search - <select onchange="window.location='search.php?'+this.value;" style="width:100px;height:15px"> 
											<? 
												foreach ($searchterms as $searchoptions => $searchoptionsid){
												$selected="";
												if($searchid==$searchoptionsid) $selected=" selected";
													echo "<option value='$searchoptionsid' $selected>$searchoptions</option>"; 
												}
										?>
										</select>
								</td>
							</tr>
						</table>
								<center>
								<p>
								<form>
								<input class="inputtext" name="<?PHP echo $searchid;?>" type="text" style="width:400px" value="<?PHP echo $searchterm;?>">&nbsp;<input type="submit" class="inputsubmit" style="width:60px" value="Search">
								</form>
								</p>
						
			
					</td>
				</tr>
			</table>
		<br><br>
		<?PHP } ?>
		<?PHP if(strlen($_SERVER['QUERY_STRING'])>1){?>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998>
									Searched all people's <?=$searchid?> for <u><?=$searchterm?></u>.
								</td>
								
							</tr>
							<tr>
								<td bgcolor="#d9dfea">

						<?PHP 
						if(!$searchterm) $_GET['id']=-1;
									//$results=$profile->search($_GET);
									$resultsperpage=20;
									$results=$profile->search($_GET, $_GET['page'], $resultsperpage); 
									//print_r($results); die;
									$actualtotal=$profile->get_totalrows();
									$totalresults=count($results);
									if($results[0]['id']<1)$totalresults--;
									$startresult=$_GET['page']*$resultsperpage+1;
									$endresult=$startresult+$totalresults-1;
									
									$pagestring="&page=".$_GET['page'];
									$stringwithoutpage=str_replace($pagestring,"",$_SERVER['QUERY_STRING']);
									
									if($actualtotal==0) $startresult=0;
									
									echo "<table width=95%><tr><td style='color:#3b5998'>";
									if($resultsperpage<$actualtotal){
									echo "Displaying $startresult - $endresult of $actualtotal matches. ";
										if($_GET['page']>0){
											$prevpage=$_GET['page']-1;
											echo "[ <a href='?$stringwithoutpage&page=$prevpage'>Previous</a> ]";
										} else echo "[ <font color=black>Previous</font> ]";
										if($endresult<$actualtotal){
											$nextpage=$_GET['page']+1;
											echo "[ <a href='?$stringwithoutpage&page=$nextpage'>Next</a> ]";
										} else echo "[ <font color=black>Next</font> ]";
									} else echo "Displaying all $actualtotal matches. ";
									echo "</td></tr></table><center>";

									
									
									?></td></tr></table>
									<table width=95%>
									<?PHP 
									if(!$searchterm) echo "<tr><td><b>Please search by typing in the field above.</b></td></tr>";
									for($threeimg=0;$threeimg<=51;$threeimg++){

										if($results[$threeimg]['id']>0){
										
											?>
										<tr>
											<td align=left>
												<table class="bottomborder" width="100%">
													<tr valign=stop>
														<td width="100px" align=left>
															<img class="normal" border=0 src="<?PHP echo $results[$threeimg]['searchn'];?>"> 
														</td>
														<td width="300px" align=left>
															<table width="200px">
																<tr>
																	<td width="30px">
																		Name
																	</td>
																	<td width="270px">
																		<?PHP if(in_array($results[$threeimg]['id'],$friendarray)||$sess->Retrieve('id')==3){?>
																		<a href="profile.php?id=<?PHP echo $results[$threeimg]['id'];?>">
																		<?PHP } ?>
																		<?PHP echo $results[$threeimg]['name'];?></a>
																	</td>
																</tr>
																<tr>
																	<td>
																		School
																	</td>
																	<td>
																		<?PHP echo $results[$threeimg]['school'];?>
																	</td>
																</tr>
																<tr>
																	<td>
																		Residence
																	</td>
																	<td>
																		<?PHP echo $results[$threeimg]['residence'];?>
																	</td>
																</tr>
															</table>
														</td>
														<td width="100px" align=right>
															<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
																<?PHP if($profile->viewable_profile($results[$threeimg]['id'])||$sess->Retrieve('id')==3){ $shownextbar=true;?>
																<tr>
																	<td>
																		<table cellspacing=0 cellpadding=2 border=0 width=100%> 
																			<tr>
																				<td>
																					<a href="profile.php?id=<?PHP echo $results[$threeimg]['id'];?>">View Profile</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<?PHP }?>
																<tr >
																	<td>
																		<table <?php if($shownextbar) echo "class='bordertop'"; ?> cellspacing=0 cellpadding=2 border=0 width=100%> 
																			<tr>
																				<td>
																					<a href="friends.php?id=<?PHP echo $results[$threeimg]['id'];?>">View Friends</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<?PHP if(!in_array($results[$threeimg]['id'],$friendarray)){?>
																<tr >
																	<td>
																		<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
																			<tr>
																				<td style="color:#538ae2"><?if($results[$threeimg]['id']!=$id){ ?>
																					<a href="addfriend.php?id=<?PHP echo $results[$threeimg]['id'];?>">Add to Friends</a>
																					<?PHP }else echo "This is you"; ?>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<?PHP } ?>
																<tr >
																	<td>
																		<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
																			<tr>
																				<td>
																					<a href="poke.php?id=<?PHP echo $results[$threeimg]['id'];?>">Poke Them!</a>
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
																					<a href="viewmessages.php?compose=true&id=<?PHP echo $results[$threeimg]['id'];?>">Send A Message</a>
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
											<?PHP } } 
											
											if ($actualtotal==0) 
											echo "<tr><td>No matches to your search. Please try again.<br></td></tr>";

											 ?>
									</table>
										<?
										
										echo "<table width=100%><tr><td bgcolor='#d9dfea'><table width=100% ><tr><td style='color:#3b5998'>";
									
									if($resultsperpage<$actualtotal){
									echo "Displaying $startresult - $endresult of $actualtotal matches. ";
										if($_GET['page']>0){
											$prevpage=$_GET['page']-1;
											echo "[ <a href='?$stringwithoutpage&page=$prevpage'>Previous</a> ]";
										} else echo "[ <font color=black>Previous</font> ]";
										if($endresult<$actualtotal){
											$nextpage=$_GET['page']+1;
											echo "[ <a href='?$stringwithoutpage&page=$nextpage'>Next</a> ]";
										} else echo "[ <font color=black>Next</font> ]";
									} else echo "Displaying all $actualtotal matches. ";
									echo "</td></tr></table></td></tr></table>";
									?>

									
					</td>
				</tr>
			</table>
		<?PHP } ?>
	</table>
	<br>&nbsp;<center>
	<table class='bordertable' cellspacing=0 cellpadding=0 width=96%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 

  </td></tr></table>

  <center>

<?PHP include('modules/default/bottomnav.php');	?> 

  </center><br>

  </td></table><br></table>
</body>
</html>

<script type="text/javascript"> 
            window.fbAsyncInit = function() {
                FB.init({appId: '216469101714486', status: true, cookie: true, xfbml: true});
                FB.Canvas.setAutoResize();
            };
            
            (function() {
                var e = document.createElement('script');
                e.type = 'text/javascript';
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());
</script>
 