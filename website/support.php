<?PHP
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib
$log= new log($_SERVER["PHP_SELF"]);
$sess = new SessionData();					// Creates session object
//$sess->CheckValidFBSession();
$schoolsuggested=NULL;

if($_SERVER['REQUEST_METHOD'] == "POST"){
	

	extract($_POST);

	if(strlen($remail)>1&&strlen($bid)>1){

					$body = "A new bid was suggested by: ".$remail.". <br>";
					
				$body .= "The bid is: ".$bid.".";
				$email = new email();																		
				if($site->get_setting('email_alerts')==1){
					$email->send('suggest@harvardconnection.co','New Bid',$body);
				}
				$schoolsuggested="Your bid has been sent to the HarvardConnection team.";
		
	}else{
		$error="<p class='red'><b>It appears you left something blank. Please try again.</b></p>";
	}
}

?><html xmlns:fb="http://www.facebook.com/2008/fbml">
<title>HarvardConnection | Buy Us</title> 
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
<tr><td class='white' bgcolor=#3B5998>Support</td></tr></table><center><p class='title'>[ Support HarvardConnection ]</p><center><table cellspacing=0 cellpadding=0 width=95% border=0><tr><td><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Donate</td></tr></table>&nbsp;<br><center>
<?PHP if(!$schoolsuggested){ 
echo $error;
?>
Want more from HarvardConnection? We are eager to provide a better service to all of our users and can really use the support from our online followers. Please help by clicking the link below and donating any amount you can afford. <br><br>
We greatly appreciate everyones support and will continue to provide the best service possible.<br><br>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_new">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<?PHP }else {
echo "<table style='width:100%;height:150px'><tr><td><p class='red'><b>$schoolsuggested</b></p></td></tr></table></table>"; // REGISTRATION SUCCESSFUL MESSAGE
}
?><br><br>
<input class='inputsubmit' type=button value='Home' onclick='javascript:document.location="home.php";'><br>&nbsp;</td></tr></table>  </td></tr></table>

  </td></tr></table>

  <center>

<?PHP include('modules/default/bottomnav.php');	?> 

  </center><br>

  </td></table></table><br>


