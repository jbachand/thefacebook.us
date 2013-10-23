<?PHP

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib

$sess = new SessionData();					// Creates session object
if(!$sess->CheckValidAdminSession()){			// Validates Session
	$log= new log($_SERVER["PHP_SELF"], $_GET, $_POST, $_SERVER['HTTP_REFERER'] ); 
	if(!$sess->CheckValidSession())
		header('Location: login.php');
	else
		header('Location: ../fb/bind.php');
}

$db = new Database();						// Creates database object
if(!$db->connect()){
	echo "<p>Error connecting to the database</p>";
}

//$log= new log('AdminIndex');
$stats = new statistics();

$getstatsbackdays=60;
$daysago=0;

$getstatsbackmonths=24;
$monthsago=0;

$active_users_graph = $pageviews_graph = $month_pageviews_graph = array();

while($getstatsbackdays>=$daysago){
	$datetopull=date('Y-m-d', strtotime("-".$daysago." days"));
	$active_users_graph[]="['".$datetopull."', ".intval($stats->dailyactiveusercount($datetopull))."]";
	$pageviews_graph[]="['".$datetopull."', ".intval($stats->viewcount($datetopull))."]";
	$daysago++;
}

while($getstatsbackmonths>=$monthsago){
	$monthtopull=date('Y-m', strtotime("-".$monthsago." months"))."-0";
	$monthly_pageviews_graph[]="['".date('Y-m', strtotime("-".$monthsago." months"))."', ".intval($stats->monthlyviewcount($monthtopull))."]";
	$monthsago++;
}

$sevendaysago=date('Y-m-d', strtotime("-7 days"));
$today=date('Y-m-d');

?>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>HarvardConnection | Admin</title> 
<link rel="stylesheet" href="../style.css"> 
<link rel="shortcut icon" href="../favicon.ico"> 
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var user_trend_data = google.visualization.arrayToDataTable([
          ['Day', 'Users'],
          <?php echo implode(",", array_reverse($active_users_graph)); ?>
        ]);

        var user_trend_options = {
          title: 'Active Users'
        };

        var chart = new google.visualization.LineChart(document.getElementById('active_users_div'));
        chart.draw(user_trend_data, user_trend_options);
        
        var pageviews_data = google.visualization.arrayToDataTable([
          ['Day', 'Hits'],
          <?php echo implode(",", array_reverse($pageviews_graph)); ?>
        ]);

        var pageviews_options = {
          title: 'Pageviews'
        };

        var chart = new google.visualization.LineChart(document.getElementById('pageviews_div'));
        chart.draw(pageviews_data, pageviews_options);
        
        
        var monthly_pageviews_data = google.visualization.arrayToDataTable([
          ['Month', 'Hits'],
          <?php echo implode(",", array_reverse($monthly_pageviews_graph)); ?>
        ]);

        var monthly_pageviews_options = {
          title: 'Monthly Pageviews'
        };

        var chart = new google.visualization.LineChart(document.getElementById('monthly_pageviews_div'));
        chart.draw(monthly_pageviews_data, monthly_pageviews_options);
        
      }
    </script>
</head>
 <body >



<center>

<table class="bordertable" cellspacing=0 cellpadding=0 border=0 width=700>

  <tr><td>

      <table class="bottomborder" cellspacing=0 cellpadding=0 border=0 width=100%>

      <tr><td width=350 bgcolor=#3B5998>

          <img src='../images/logo-left.jpg'></td>

          <td><table cellspacing=0 cellpadding=0 border=0 width=100%><tr><td>

          <table cellspacing=0 cellpadding=0 border=0 width=100%>

          <tr><td><a href='index.php'><img src='../images/logo-right.jpg' border=0></a></td>

          <td width=100% bgcolor=#3B5998>&nbsp;</td></tr></table></td></tr>

          <tr><td><table cellspacing=0 cellpadding=4 border=0 width=100%><tr height=21>

          <!--<td bgcolor=#3B5998 width=10>&nbsp;</td>-->
		  
		 <?PHP
		
				include('../modules/loggedin/topnav.php');		  
			
			?>

		  <td bgcolor=#3B5998 width=100%>&nbsp;</td>


					
          </tr></table></td>

          </tr></table>

      </td></tr></table>

  </td></tr>

  <tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%>

      <tr><td valign=top>

      <table cellspacing=0 cellpadding=0 border=0 width=105>

        <tr><td>
		 	 <?PHP
			
				include('../modules/loggedin/leftnav.php');		  
			
			?>



        </td></tr>



      </td></tr>

      </table>

      </td><td width=595 valign=top>

        <table class="bordertable" cellspacing=0 cellpadding=0 border=1 width=100%><tr><td>



	  <table cellspacing=0 cellpadding=2 border=0 width=100%> 
		<tr>
			<td class='white' bgcolor=#3B5998>Admin Panel</td>
		</tr>
	</table>
	
	<center>
	
	<p class='title'>[ Admin Panel ]</p><center>
	<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><span><iframe frameborder="no" id="f11f88a338" name="f33a87791c" scrolling="no" style="border-width: initial; border-color: initial; overflow-x: hidden; overflow-y: hidden; height: 20px; width: 90px; border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; " title="Like this content on Facebook." class="fb_ltr" src="http://www.facebook.com/plugins/like.php?channel_url=http%3A%2F%2Fstatic.ak.fbcdn.net%2Fconnect%2Fxd_proxy.php%3Fversion%3D3%23cb%3Df1692fef68%26origin%3Dhttp%253A%252F%252Fwww.harvardconnection.co%252Ff6b3be0d4%26relation%3Dparent.parent%26transport%3Dpostmessage&amp;href=http%3A%2F%2Fwww.harvardconnection.co&amp;layout=button_count&amp;locale=en_US&amp;node_type=link&amp;sdk=joey&amp;send=false&amp;show_faces=false&amp;width=90"></iframe></span>

	
	<table cellspacing=0 cellpadding=0 border=0 width=95%>
		<tr>
			<td>
				<center>
					<table class='bordertable' cellspacing=0 cellpadding=0 width=90%>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=100%> 
									<tr>
										<td class='white' bgcolor=#3B5998>Current Users - [ <a href='newsletter.php'>send a newsletter</a> ] [ <a href='addonetocount.php'>Add one to everyones count</a> ]</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=95%>
									<tr>
										<td>
										Total User Count:
										</td>
										<td align=right>
										<?PHP echo $totalusers=$stats->totalusers();?>
										</td>
									</tr>
									
									<tr>
										<td>
											Multiday Users:
										</td>
										<td align=right>
											<?PHP echo $multiday=count($stats->multidayusers());?>
										</td>
									</tr>
									<tr>
										<td>
										Confirmed Users Today:
										</td>
										<td align=right>
										<?PHP echo $userstoday=$stats->usercount($today);?>
										</td>
									</tr>
									<tr>
										<td>
											Return Rate:
										</td>
										<td align=right>
											<?PHP $rate=$multiday/($totalusers-$userstoday)*100; echo $rate."%";?>
										</td>
									</tr>
									
									<tr>
										<td>
										Active Users Today:
										</td>
										<td align=right>
										<?PHP echo $activetoday=$stats->dailyactiveusercount($today);?>
										</td>
									</tr>
									<tr>
										<td>
										Active Users:
										</td>
										<td align=right>
											<div id="active_users_div" style="width: 400px; height: 300px;"></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br>&nbsp;<center>
					<table class='bordertable' cellspacing=0 cellpadding=0 width=90%>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=100%> 
									<tr>
										<td class='white' bgcolor=#3B5998>Hits</td>
									</tr>
								</table>
								</td>
						</tr>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=95%>
									<tr>
										<td>
											Pageviews Total:
										</td>
										<td align=right>
											<?PHP echo $totalviews=$stats->totalviews();?>
										</td>
									</tr>
									<tr>
										<td>
										Pageviews:
										</td>
										<td align=right>
											<div id="pageviews_div" style="width: 400px; height: 300px;"></div>
										</td>
									</tr>
									<tr>
										<td>
										Monthly Pageviews:
										</td>
										<td align=right>
											<div id="monthly_pageviews_div" style="width: 400px; height: 300px;"></div>
										</td>
									</tr>
									<tr>
										<td>
											Unique Visitors Total:
										</td>
										<td align=right>
											<?PHP echo $totalunique=$stats->totaluniquevisitors();?>
										</td>
									</tr>
									<tr>
										<td>
											Multiday Visitors:
										</td>
										<td align=right>
											<?PHP echo $multidayviews=count($stats->multidayvisitors());?>
										</td>
									</tr>
									<tr>
										<td>
											Visitor Return Rate:
										</td>
										<td align=right>
											<?PHP $rate2=$multidayviews/$totalunique*100; echo $rate2."%"?>
										</td>
									</tr>
									<tr>
										<td>
											Average views per day (Lifetime):
										</td>
										<td align=right>
											<?PHP echo $stats->averageviews($today);?>
										</td>
									</tr>
									<tr>
										<td>
											Pageviews Today:
										</td>
										<td align=right>
											<?PHP echo $stats->viewcount($today);?>
										</td>
									</tr>
									<tr>
										<td>
											Unique Visitors Today:
										</td>
										<td align=right>
											<?PHP echo $stats->uniquevisitors($today);?>
										</td>
									</tr>
									<tr>
										<td>
											Harvard Campus User Views:
										</td>
										<td align=right>
											<?PHP echo count($stats->harvardcampususers());?>
										</td>
									</tr>
									<tr>
										<td>
											Last 10 Hits:
										</td>
										<td align=right><?PHP
										$hit = $stats->last20hits();
										echo "<table width='100%'>";
										foreach($hit as $rdata){
											echo "<tr><td>";
											foreach ($rdata as $rfield){
												echo $rfield."</td><td>";
											}
											echo "</td></tr>";
										}
										echo "</table>";
										?>
										<hr>
										</td>
									</tr>
									<tr>
										<td>
											Last 10 User Hits:
										</td>
										<td align=left><?PHP
										$users = $stats->last10useractivity();
										echo "<table width='100%'>";
										foreach($users as $rdata){
											echo "<tr><td>";
											foreach ($rdata as $rfield){
											if(is_numeric($rfield))
												echo "<a href='../fb/profile.php?id=$rfield' target='_new'>$rfield</a> [<a href='http://www.facebook.com/profile.php?id=$rfield' target='_new'>fb</a>]</td><td>";
											else
												echo $rfield."</td><td>";
											}
											echo "</td></tr>";
										}
										echo "</table>";
										?>
										<hr>
										</td>
									</tr>
									<tr>
										<td>
											Top 10 Refs Today:
										</td>
										<td align=left><?PHP
										$refs = $stats->todaysrefs($today);
										echo "<table width='100%'>";
										foreach($refs as $rdata){
											echo "<tr><td>";
											foreach ($rdata as $rfield){
												echo "<a href='$rfield' target='_new'>".substr($rfield,0,60)."</a></td><td>";
											}
											echo "</td></tr>";
										}
										echo "</table>";
										?>
										
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br>&nbsp;<center>
					
					<table class='bordertable' cellspacing=0 cellpadding=0 width=90%>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=100%> 
									<tr>
										<td class='white' bgcolor=#3B5998>Suggested Schools</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=95%>
									<tr>
										<td width=50%>
										School
										</td>
										<td width=50% align=right>
										Suggestions
										</td>
									</tr>
								<?PHP 
								$suggested=$stats->topsuggested();
								foreach($suggested as $school){
								?>
									<tr>
										<td>
										<? echo $school[name]; ?>
										</td>
										<td align=right>
										<? echo $school[entries]; ?>
										</td>
									</tr>
								<?PHP }?>
								</table>
							</td>
						</tr>
					</table>
					<br>&nbsp;<center>
					<table class='bordertable' cellspacing=0 cellpadding=0 width=90%>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=100%> 
									<tr>
										<td class='white' bgcolor=#3B5998>Site Settings - [ <a href='editsitesettings.php'>edit</a> ]</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=95%>
									<tr>
										<td>
											Site On:
										</td>
										<td align=right>
											<?PHP if($site->get_setting('site_on')==1) echo "Yes"; else echo "No"; ?>
										</td>
									</tr>
									<tr>
										<td>
											Email Alerts:
										</td>
										<td align=right>
											<?PHP if($site->get_setting('email_alerts')==1) echo "Yes"; else echo "No"; ?>
										</td>
									</tr>
									<tr>
										<td>
											Go-Live Date:
										</td>
										<td align=right>
											<?PHP echo $site->get_setting('launch_date');?>
										</td>
									</tr>
									<tr>
										<td>
											Registration Enabled:
										</td>
										<td align=right>
											<?PHP if($site->get_setting('registration_on')==1) echo "Yes"; else echo "No"; ?>
										</td>
									</tr>
									<tr>
										<td>
											Login Enabled:
										</td>
										<td align=right>
											<?PHP if($site->get_setting('login_on')==1) echo "Yes"; else echo "No"; ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br>&nbsp;<center>
					<table class='bordertable' cellspacing=0 cellpadding=0 width=90%>
						<tr>
							<td>
								<table cellspacing=0 cellpadding=2 border=0 width=100%> 

  </td></tr></table>

  <center>

  <p><a href="../about.php">about</a>&nbsp;&nbsp;

  <a href="../contact.php">contact</a>&nbsp;&nbsp;

  <a href="../faq.php">faq</a>&nbsp;&nbsp;

  <a href="../terms.php">terms</a>&nbsp;&nbsp;

  <a href="../policy.php">privacy</a>

  <br>a Mark Zuckerberg production

  <br>HarvardConnection &copy; 2004

  </center><br>

  </td></table></table><br>



 
