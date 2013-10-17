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
$friendarray=$profile->friendsids($id,0,999999);


$resultsperpage=20;							// Adjustable up to 50

$browsetype=$_GET['network'];

if(!$browsetype||strlen($browsetype)<1||$browsetype=="extended"){
	$results=$profile->network($id, $_GET['page'], $resultsperpage);
	$browsetype="extended";
	$browseexplain=" - Results contain all friends of friends and relationships";
	}
	
if($browsetype=="personal"){
	$results=$profile->personalnetwork($id,$_GET['page'], $resultsperpage);
	$browseexplain=" - Results contain all relationships of relationship status";
	}
	
if($browsetype=="classes"){
	$results=$profile->classesnetwork($id,$_GET['page'], $resultsperpage);
	$browseexplain=" - Results contain all people in your classes";
	}


?>
<title>TheFacebook | Browse Network</title> 
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
	  Browse
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
									Browse your networks
								</td>
								
							</tr>
							<tr>
								<td align=center style='color:#538ADC'><br>
									<center> 
									[ <a href="?network=extended">Extended Network</a> ]
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									[ <a href="?network=personal">Extended Personal Network</a> ]
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									[ <a href="?network=classes">Classes Network</a> ]
									</center><br>
								</td>
							</tr>
						</table>
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
									Your <?PHP echo $browsetype;?> network <?PHP echo $browseexplain; ?>
								</td>
								
							</tr>
							<tr>
								<td bgcolor="#d9dfea">
								
						

						<?PHP 
									
									$actualtotal=$profile->get_totalrows();
									$totalresults=count($results);
									if($results[0]['id']<1)$totalresults--;
									$startresult=$_GET['page']*$resultsperpage+1;
									$endresult=$startresult+$totalresults-1;
									
									$pagestring="page=".$_GET['page']."&";
									$stringwithoutpage=str_replace($pagestring,"",$_SERVER['QUERY_STRING']);
									
									echo "<table width=95%><tr><td style='color:#3b5998'>";
									if($resultsperpage<$actualtotal){
									echo "Displaying $startresult - $endresult of $actualtotal users in your $browsetype network. ";
										if($_GET['page']>0){
											$prevpage=$_GET['page']-1;
											echo "[ <a href='?page=$prevpage&$stringwithoutpage'>Previous</a> ]";
										} else echo "[ <font color=black>Previous</font> ]";
										if($endresult<$actualtotal){
											$nextpage=$_GET['page']+1;
											echo "[ <a href='?page=$nextpage&$stringwithoutpage'>Next</a> ]";
										} else echo "[ <font color=black>Next</font> ]";
									} else echo "Displaying all $actualtotal users in your $browsetype network. ";
									echo "</td></tr></table><center>";

									?>
									</td></tr></table>
									<table width=95%>
									<?PHP for($threeimg=0;$threeimg<=51;$threeimg++){

										if($results[$threeimg]['id']>0){
											?>
										<tr>
											<td align=left>
												<table class="bottomborder" width="100%">
													<tr valign=stop>
														<td width="100px" align=left>
															<img border=0 src="<?PHP echo $results[$threeimg]['searchn'];?>"> 
														</td>
														<td width="300px" align=left>
															<table width="200px">
																<tr>
																	<td width="30px">
																		Name
																	</td>
																	<td width="270px">
																		<a href="profile.php?id=<?PHP echo $results[$threeimg]['id'];?>"><?PHP echo $results[$threeimg]['name'];?></a>
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
															
																<tr >
																	<td>
																		<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
																			<tr>
																				<td>
																					<a href="friends.php?id=<?PHP echo $results[$threeimg]['id'];?>">View Friends</a>
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
															</table>
														</td>
													</tr>
												</table>																
											</td>
										</tr>
											<?PHP } } 
											
											if ($actualtotal==0){
												echo "<tr><td>There appears to be no one in your network. ";
												
												if ($browsetype=="personal"||$browsetype=="extended") echo "<a href='search.php?name=+'>Search for ";
												
												if($browsetype=="personal")
												echo "relationships";
												else if($browsetype=="extended")
												echo"friends";
												
												if($browsetype=="classes") echo "<a href='editprofile.php?s=personal'>Add more classes";
												
												
												echo"</a><br></td></tr>";
											}
											 ?>
									</table>
										<?
										
										echo "<table width=100%><tr><td bgcolor='#d9dfea'><table width=100% ><tr><td style='color:#3b5998'>";
									if($resultsperpage<$actualtotal){
									echo "Displaying $startresult - $endresult of $actualtotal users in your $browsetype network. ";
										if($_GET['page']>0){
											$prevpage=$_GET['page']-1;
											echo "[ <a href='?page=$prevpage&$stringwithoutpage'>Previous</a> ]";
										} else echo "[ <font color=black>Previous</font> ]";
										if($endresult<$actualtotal){
											$nextpage=$_GET['page']+1;
											echo "[ <a href='?page=$nextpage&$stringwithoutpage'>Next</a> ]";
										} else echo "[ <font color=black>Next</font> ]";
									} else echo "Displaying all $actualtotal users in your $browsetype network. ";
									echo "</td></tr></table></td></tr></table>";
									?>
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



 
