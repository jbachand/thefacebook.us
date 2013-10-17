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
$friendarray=$profile->friendsids($id,0,5000);


$resultsperpage=20;							// Adjustable up to 50

$relationpend=new Relationship();
$requestsyourpending=$relationpend->pending_requests();




?>
<title>TheFacebook | Requests</title> 
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
	  Requests
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
									Your pending requests
								</td>
								
							</tr>
							<tr>
								<td bgcolor="#d9dfea"> &nbsp;
								</td>
							</tr>
								
						

						<?PHP ?>
									

									<table width=95%>
									<?PHP foreach ($requestsyourpending as $ids){
										$name=$relationpend->getname('user',$ids);
										$searchn=$profile->get_searchnail($ids);

										if($ids>0){
											?>
										<tr>
											<td align=left>
												<table class="bottomborder" width="100%">
													<tr valign=stop>
														<td width="100px" align=left>
															<img border=0 src="<?PHP echo $searchn;?>"> 
														</td>
														<td width="300px" align=left>
															<table width="200px">
																<tr>
																	<td width="30px">
																		Name
																	</td>
																	<td width="270px">
																		<a href="profile.php?id=<?PHP echo $ids;?>"><?PHP echo $name;?></a>
																	</td>
																</tr>
															</table>
														</td>
														<td width="100px" align=right>
															<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
																<tr>
																	<td>
																		<table cellspacing=0 cellpadding=2 border=0 width=100%> 
																			<tr>
																				<td>
																					<a href="profile.php?id=<?PHP echo $ids;?>">View Profile</a>
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
																					<a href="friends.php?id=<?PHP echo $ids;?>">View Friends</a>
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
																					<a href="viewmessages.php?compose=true&id=<?PHP echo $ids;?>">Send A Message</a>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																
																<tr >
																	<td>
																		<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
																			<tr>
																				<td style="color:#538ae2">
																					<a href="addfriend.php?id=<?PHP echo $ids;?>"><b>Respond</b></a>
																				
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



 
