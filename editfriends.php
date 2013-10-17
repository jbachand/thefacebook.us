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



//$friendarray=$profile->friendsids($id,0,5000);
?>
<title>TheFacebook | Edit Friends</title> 
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
	  Friends
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
									Edit Friends - [ <a class=menu href="friends.php">view</a> ]
								</td>
								
							</tr>
						<tr>
								<td bgcolor="#d9dfea">

						<?PHP 		$resultsperpage=20;
						
									switch ($_GET['view']){
										case "ru":
											$orderby='lastupdate';
										break;
										case "ra":
											$orderby='lastactive';
										break;
										default:
											$orderby='friend';
										break;
									}
									
									$results=$profile->friends($id, $_GET['page'], $resultsperpage,$orderby);
									
									$actualtotal=$profile->get_totalrows();
									$totalresults=count($results);
									if($results[0]['id']<1)$totalresults--;
									$startresult=$_GET['page']*$resultsperpage+1;
									$endresult=$startresult+$totalresults-1;
									
									$pagestring="page=".$_GET['page']."&";
									$stringwithoutpage=str_replace($pagestring,"",$_SERVER['QUERY_STRING']);
									
									if($actualtotal==0) $startresult=0;
									
									echo "<table width=95%><tr><td style='color:#3b5998'>";
									if($resultsperpage<$actualtotal){
									echo "Displaying $startresult - $endresult of $actualtotal friends. ";
										if($_GET['page']>0){
											$prevpage=$_GET['page']-1;
											echo "[ <a href='?page=$prevpage&$stringwithoutpage'>Previous</a> ]";
										} else echo "[ <font color=black>Previous</font> ]";
										if($endresult<$actualtotal){
											$nextpage=$_GET['page']+1;
											echo "[ <a href='?page=$nextpage&$stringwithoutpage'>Next</a> ]";
										} else echo "[ <font color=black>Next</font> ]";
									} else echo "Displaying all $actualtotal friends. ";
									echo "</td></tr></table>";

									
									?>
									</td></tr></table>
									<table width=90%><tr><td style='color:#538ADC'>
									&nbsp;<font color=black>Filter:</font>&nbsp;&nbsp;&nbsp;
									[ <a href="?view=ra">Recently Active</a> ]&nbsp;&nbsp;&nbsp;
									[ <a href="?view=ru">Recently Updated Profiles</a> ]&nbsp;&nbsp;&nbsp;
									[ <a href="editfriends.php">All</a> ]
									</td></tr></table>
									
									<table width=95%>
									<?PHP for($threeimg=0;$threeimg<=51;$threeimg++){

										if($results[$threeimg]['id']>0){
											?>
										<tr>
											<td align=center>
												<table cellspacing=10 cellpadding=0  class='bordertable' width="80%">
													<tr valign=stop>
														<td width="50px" align=left>
															<img border=0 src="<?PHP echo $results[$threeimg]['thumb'];?>">
														</td>
														<td width="250px" align=left>
															<a href="profile.php?id=<?PHP echo $results[$threeimg]['id'];?>"><?PHP echo $results[$threeimg]['name'];?></a>
															<?PHP if ($orderby=='lastupdate') echo "<br>Last updated:<br>".date('M jS, Y g:h:i a',strtotime($results[$threeimg]['lastupdate'])); ?>
															<?PHP if ($orderby=='lastactive') echo "<br>Last active:<br>".date('M jS, Y g:h:i a',strtotime($results[$threeimg]['lastactive'])); ?>
														</td>
														<td width="200px" align=right  style="color:#538ae2">
														[ <a href="viewmessages.php?compose=true&id=<?PHP echo $results[$threeimg]['id'];?>"> message </a> ]&nbsp;&nbsp;&nbsp;[ <a href="confirmremove.php?id=<?PHP echo $results[$threeimg]['id'];?>"> remove </a> ]

														</td>
													</tr>
												</table><br>																
											</td>
										</tr>
											<?PHP } } 
											
											if ($actualtotal==0) {
												echo "<tr><td>";
												echo "It appears you haven't added any friends yet. <a href='search.php'>Search for friends</a>";
												echo "<br></td></tr>";
											}
											 ?>
									</table>
										<?
										
										echo "<table width=100%><tr><td bgcolor='#d9dfea'><table width=100% ><tr><td style='color:#3b5998'>";
									if($resultsperpage<$actualtotal){
									echo "Displaying $startresult - $endresult of $actualtotal friends. ";
										if($_GET['page']>0){
											$prevpage=$_GET['page']-1;
											echo "[ <a href='?page=$prevpage&$stringwithoutpage'>Previous</a> ]";
										} else echo "[ <font color=black>Previous</font> ]";
										if($endresult<$actualtotal){
											$nextpage=$_GET['page']+1;
											echo "[ <a href='?page=$nextpage&$stringwithoutpage'>Next</a> ]";
										} else echo "[ <font color=black>Next</font> ]";
									} else echo "Displaying all $actualtotal friends. ";
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



 
