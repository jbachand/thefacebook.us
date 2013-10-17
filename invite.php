<?PHP
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib
$log= new log($_SERVER["PHP_SELF"]);

$sess = new SessionData();					// Creates session object
$sess->CheckValidFBSession();
$sess->CheckValidSession();
$schoolsuggested=NULL;

if(!stristr($_SERVER["QUERY_STRING"],"request_ids")) header('location: home.php');


?>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<title>TheFacebook | Invitations</title> 
<link rel="stylesheet" href="style.css"> 
<link rel="shortcut icon" href="favicon.ico"> 
<body>
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
			
			if(!$sess->CheckValidSession()){			
				include('modules/default/topnav.php');
			}else{
				include('modules/loggedin/topnav.php');		  
			}
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
			
			if(!$sess->CheckValidSession()){			
				include('modules/default/leftnav.php');
			}else{
				include('modules/loggedin/leftnav.php');		  
			}
			?>              

         





        </td></tr>



      </td></tr>

      </table>

      </td><td width=595 valign=top>

        <table class="bordertable" cellspacing=0 cellpadding=0 border=1 width=100%><tr><td>



	  <table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Send Invites</td></tr></table><center><p class='title'>[ Invitations ]</p>
<center><table cellspacing=0 cellpadding=0 width=95% border=0><tr><td><center><table class='bordertable' cellspacing=0 cellpadding=0 width=96%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Invitations sent!</td></tr></table>&nbsp;<br><center>
   Invitations have been sent to your selected friends. Thanks for your support!<br><br>
</table>
	<br>&nbsp;<center>
	<table class='bordertable' cellspacing=0 cellpadding=0 width=96%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 

  </td></tr></table>

  <center>

<?PHP include('modules/default/bottomnav.php');	?> 

  </center><br>

  </td></table><br></table>

