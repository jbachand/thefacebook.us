<?PHP 
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib


//$log= new log($_SERVER["REQUEST_URI"]);
$log= new log($_SERVER["PHP_SELF"], $_GET, $_POST, $_SERVER['HTTP_REFERER'] ); 


	$sess = new SessionData();					// Creates session object
	$sess->CheckValidFBSession();
	if(!$sess->CheckValidSession()){			// Validates Session
		$sess->Login();

	}


	if($sess->Retrieve('id')!=3&&$sess->Retrieve('id')!=100002408771848){
		//header('Location: profile.php');
		//exit();
	}

$id=$sess->Retrieve('id');

	$db = new Database();						// Creates database object
	if(!$db->connect()){
		echo "<p>Error connecting to the database</p>";
	}
	

	//FBData::clearcount($id);

	
$uid=$id;

$profile = new Profile($id);
$friendarray=$profile->friendsids($id,0,999999);



?>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>TheFacebook | Home</title> 
<link rel="stylesheet" href="style.css"> 
<link rel="shortcut icon" href="favicon.ico"> 
</head>
 <body>
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
					<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998 colspan=2>
									Welcome <?PHP $fname=$profile->retrieve('name'); $fname=explode(" ",$fname); echo $fname[0]; ?>!
								</td>
							</tr>
						</table>


	  <br>
<table cellspacing=0 cellpadding=6 border=0 width=97% align=center valign=top>
	<tr>
		<td width="95%" align=center valign=top>
			
			<center><p class='title'>[ Welcome <?PHP $fname=$profile->retrieve('name'); $fname=explode(" ",$fname); echo $fname[0]; ?> ]</p>
			<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
				<tr>
					<td>
						<table cellspacing=0 cellpadding=2 border=0 width=100%> 
							<tr>
								<td class='white' bgcolor=#3B5998 colspan=2>
									My Account
								</td>
							</tr>
						</table>

				
						<table cellspacing=0 cellpadding=6 border=0 width=100%>
							<tr>
								<td valign=middle align=center width="20%">
									<?PHP 
									$pic=$profile->retrieve('defaultpicture');
									
										
									echo "<img src='$pic'>"; 
									?>
								</td>
								<td valign=middle align=left width="20%">
									<table class='bordertable' cellspacing=0 cellpadding=0 width=100% valign=top>
									
										<tr>
											<td>
												<table cellspacing=0 cellpadding=2 border=0 width=100%> 
													<tr>
														<td>
															<a href="profile.php">View&nbsp;My&nbsp;Profile</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									<?PHP if($yourpending[0]>0){?>
										<tr >
											<td>
												<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
													<tr>
														<td>
															<a href="reqs.php">My&nbsp;Requests&nbsp;<b>[&nbsp;<?PHP echo count($yourpending);?>&nbsp;]</b></a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<?PHP }
										if($msg->get_messagecount(-1, 'unread')>0){
										?>
										<tr >
											<td>
												<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
													<tr>
														<td>
															<a href="messages.php">New&nbsp;Messages&nbsp;<b>[&nbsp;<?PHP echo $msg->get_messagecount(-1, 'unread');?>&nbsp;]</b></a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<?PHP }?>
										<tr >
											<td>
												<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
													<tr>
														<td>
															<a href="editfriends.php?view=ra">View&nbsp;My&nbsp;Friends</a>
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
															<a href="search.php?name">Search&nbsp;for&nbsp;People</a>
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
															<a href="browse.php">Browse&nbsp;My&nbsp;Network</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<?PHP if($id==3){?>
										<tr >
											<td>
												<table class='bordertop' cellspacing=0 cellpadding=2 border=0 width=100%> 
													<tr>
														<td>
															<a onclick="sendreq('friend',<?PHP echo FBData::get_fbid('4');?>);" href="#">Send Req</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<?PHP } ?>
									</table>
								</td>
								<td valign=middle align=left width="45%"> 
									You are connected to <b><?PHP $classcount=$profile->classesnetworkcount($id,0,100000); echo $classcount;?></b> <?PHP if($classcount==1) echo "person"; else echo "people"; ?> through classes.<br><br>You are connected to <b><?PHP $netcount=$profile->networkcount($id,0,1000000); echo $netcount;?></b> <?PHP if($netcount==1) echo "person"; else echo "people"; ?> through friends.
								</td>
								<td valign=middle align=right width="10%" style="color:#538ADC">
									<?PHP if($classcount>0){ ?>
									[&nbsp;<a href="browse.php?network=classes">browse&nbsp;them</a>&nbsp;]
									<?PHP }else {?>
									[&nbsp;<a href="editprofile.php?s=personal">add&nbsp;classes</a>&nbsp;]
									<?PHP }?>
									<br><br><br><br>
									<?PHP if($netcount>0){ ?>
									[&nbsp;<a href="browse.php?network=extended">browse&nbsp;them</a>&nbsp;]
									<?PHP }else {?>
									[&nbsp;<a href="search.php?name=+">add&nbsp;friends</a>&nbsp;] 
									<?PHP }?>
								
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



 
