<?PHP

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib
		$sess = new SessionData();
		//$sess->CheckValidFBSession();
		$log= new log($_SERVER["PHP_SELF"]);
			
?><html xmlns:fb="http://www.facebook.com/2008/fbml">
<title>TheFacebook | Privacy Policy</title> 
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

      </table>

      </td><td width=595 valign=top>

        <table class="bordertable" cellspacing=0 cellpadding=0 border=1 width=100%><tr><td>



	  <table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>HarvardConnection Privacy Policy</td></tr></table><center><p class='title'>[ Privacy Policy ]</p><center><table cellspacing=0 cellpadding=0 width=95% border=0><tr><td><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Coverage</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>This privacy statement covers the site www.HarvardConnection.co.  Because we want to
demonstrate our commitment to our users' privacy, we will disclose our information
and privacy practices below. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>About HarvardConnection and the Information We Collect</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>HarvardConnection is an online directory and social networking community that helps 
people find friends and other people.  To accomplish this, our users create their 
own profiles and privacy settings, and some personal information we ask for is 
displayed to people in the groups specified in the users' privacy settings. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Information Collected by HarvardConnection</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>HarvardConnection collects user-submitted account information such as name and email
address to identify users and send notifications related to use of the site.
HarvardConnection also collects user-submitted profile information such as gender, 
  field, location, courses, etc.
<p>HarvardConnection also collects information that is not personally identifiable and
not submitted directly by users, such as browser type and IP address.  This
information is gathered for all users to the site.  
<p>HarvardConnection collects information from other sources, such as newspapers and 
instant messaging services.  This information is gathered regardless of use of
the site. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Use of Information Obtained by HarvardConnection</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>Profile information, as well as name, email and photo, are displayed to people in the
groups specified in a user's privacy settings to support the function of the 
site.  Except when inviting a friend to join the site, a user's name and email will
never be given to anyone outside the site.  No information submitted to HarvardConnection
will be available to any user of the site who does not belong to at least one of the
groups specified in a user's privacy settings.
<p>We use server, IP and browser type for site administration.  We also use information 
not directly submitted to HarvardConnection by users to supplement users' profiles unless 
they specify that they do not want this done in their privacy settings. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Spam Policy</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>Email addresses will never be sold to anyone, and they will not be used for spam or
any other purpose outside of the site itself. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Links</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>This site may contain links to other websites.  HarvardConnection is not responsible for
the privacy practices of other web sites.  We encourage our users to be aware when
they leave our site and to read the privacy statements of each and every web site that
collects personally identifiable information.  This privacy statement applies solely
to information collected by this web site. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Use of Cookies</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>A cookie is a piece of data stored on the user's computer tied to information about
the user.  We use session ID cookies to confirm that users are logged in.  These cookies
terminate once the users close the browser.  We do not and will not use cookies to collect
private information from any user. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Third Party Advertising</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>Advertisements that appear on this web site are delivered to users by our advertising
partners.  Our advertising partners may set cookies.  Doing this allows the advertising
network to recognize your computer each time they send you an advertisement.  In this
way, they may compile information about where you, or others who are using your computer,
saw their advertisements and determine which advertisements are clicked.  This information
allows an advertising network to deliver targeted advertisements that they believe will be
of most interest to you.  HarvardConnection does not have access to or control of the cookies
that may be placed by the third party advertising servers of ad networks.
<p>This privacy statement covers the use of cookies by HarvardConnection and does not cover
the use of cookies by any of its advertisers. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Changing or Removing Information</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>HarvardConnection users may modify or remove any of their personal information at any time
by logging into their account.  Information will be updated immediately and old
information will never be displayed to any user of the site. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Security</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>HarvardConnection accounts are password-protected.  This web site takes every precaution to
protect our users' information.  Passwords are stored in hashed form in our database,
and different sections of users' profiles are stored in different parts of our database
to separate access to all of the information and make it more difficult to piece
everything together.  If you have any questions about the security of our web site,
please <a href='contact.php'>contact us</a>. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Changes in Our Privacy Policy</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>We reserve the right to change our privacy policy at any time.  If we do this, we will post
the changes on our web site so our users are always aware of what information we collect,
how we use it, and under what circumstances, if any, we disclose it.  If we are going to
use users' personally identifiable information in a manner different from that stated at
the time of collection, we will notify users via email. <br>&nbsp;</td></tr></table></td></tr></table><p><center><table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Contacting the Web Site</td></tr></table>&nbsp;<br><center><table cellspacing=0 cellpadding=2 border=0 width=95%><tr><td>If you have any questions about this privacy statement, the practices of this site, or
your dealings with this web site, please <a href='contact.php'>contact us</a>. <br>&nbsp;</td></tr></table></td></tr></table><p></td></tr></table>  </td></tr></table>

  </td></tr></table>

  <center>

<?PHP include('modules/default/bottomnav.php');	?> 

  <br>

  </center><br>

  </td></table></table><br>
