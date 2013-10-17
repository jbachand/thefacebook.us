<?PHP

include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib
		$sess = new SessionData();
		//$sess->CheckValidFBSession();
		$log= new log($_SERVER["PHP_SELF"]);
			
?>
 
<style> 
 
  .title {
    color:#000000;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 18px;
    font-weight: bold;
    text-decoration:none;
  }
  
  .larger {
    color:#000000;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 13px;
    font-weight: none;
    text-decoration:none;
  }
 
  .larger-a {
    //color:#D19160;
    color:#538ADC;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 13px;
    font-weight: none;
    text-decoration:none;
  }
 
  .larger-a:hover {
    //color:#FF0000;
    color:#77C9F3;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 13px;
    font-weight: none;
    text-decoration:underline;
  }
  
  select {
    font-family: Tahoma;
    font-size: 11px;
  }
   
  .white {
    color:#FFFFFF;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 12px;
    font-weight: none;
    text-decoration:none;
  }
 
  .blue {
    color:#3B5998;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 12px;
    font-weight: none;
    text-decoration:none;
  } 
  
  .red {
    color:#FF0000;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
 
  .menu {
    color:#FFFFFF;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
 
  .menu:hover {
    color:#77C9F3;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
 
  .alternate {
    color:#3B5998;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
 
  .alternate:hover {
    color:#000000;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:underline;
  }
  
  a {
    //color:#D19160;
    color:#538ADC;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
  
  a:hover {
    //color:#FF0000;
    color:#77C9F3;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:underline;
  }
 
  .bordertable {
    border-width: 1px;
    border-color: #3B5998;
    border-style: solid;
  }
 
  .dashedtable {
    border-width: 1px;
    border-color: #3B5998;
    border-style: dashed;
  }
 
  .bottomborder {
    border-style:solid;
    border-color: #3B5998;
    border-top-width:0px;
    border-bottom-width:1px;
    border-right-width:0px;
    border-left-width:0px;
  }
 
  .one-column {
    color:#000000;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
    border-style:solid;
    border-color: #3B5998;
    border-top-width:1px;
    border-bottom-width:0px;
    border-right-width:1px;
    border-left-width:1px;
  }
 
  .text {
    font-Family: Serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
  
  .td0 {
    color:#000000;
    background-color:#D9DFEA;
    border: 0;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
 
  .td1 {
    color:#000000;
    background-color:#86A1CE;
    border: 0;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }    
 
  .schedule_table {
    border-right-width: 0px;
    border-bottom-width: 0px;
    border-left-width: 1px;
    border-top-width: 1px;
    border-style: solid;
    border-color: #000000;
  }
 
  .top-border {
    border-right-width: 0px;
    border-bottom-width: 0px;
    border-left-width: 0px;
    border-top-width: 1px;
    border-style: solid;
    border-color: #3B5998;
  }
  
  .schedule {
    color:#000000;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 0px;
    border-top-width: 0px;
    border-style: solid;
    border-color:#000000;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
 
  .border-td {
    color:#000000;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
    border-top-width: 1px;
    border-style: solid;
    border-color:#3B5998;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
  
  td {
    color:#000000;
    border: 0;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: none;
    text-decoration:none;
  }
  
  .inputtext {
    border:double;
    border-width:1;
    border-color:#555555;
    background-color:#D9DFEA;
    font-size:11px;
    color: #000000;
    font-Family: Tahoma, Arial, Helvetica, sans-serif;
  }
  
  .inputsubmit {
    border-style:solid;
    border-top-width:1px;
    border-bottom-width:2px;
    border-right-width:2px;
    border-left-width:1px;
    border-top-color:#D9DFEA;
    border-bottom-color:#3B5998;
    border-right-color:#3B5998;
    border-left-color:#D9DFEA;
    background-color:#538ADC;
    font-family:Tahoma, arial;
    font-size:11px;
    color:#FFFFFF;
    font-weight:none;
  }
 
  <!--
  #8EA7C5 - blue
  #D9DFEA - grey
  59 89 152                (#3B5998)
  217 223 234              (#D9DFEA)
  83 138 220 - link normal (#538ADC)
  119 201 243 - link down  (#77C9F3)
  -->
  
</style><title>TheFacebook | Terms</title> 
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
          <tr><td><a href='index.php?PHPSESSID=<?PHP echo session_id(); ?>'><img src='images/logo-right.jpg' border=0></a></td> 
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
      </table> 
      </td><td width=595 valign=top> 
        <table class="bordertable" cellspacing=0 cellpadding=0 border=1 width=100%><tr><td> 
 

	  <table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>Terms</td></tr></table><center><p class='title'>[ Terms ]</p><center><table cellspacing=0 cellpadding=0 border=0 width=95%><tr><td><center>

<table class='bordertable' cellspacing=0 cellpadding=0 width=90%><tr><td><table cellspacing=0 cellpadding=2 border=0 width=100%> 
<tr><td class='white' bgcolor=#3B5998>By using HarvardConnection you are agreeing with the following terms:</td></tr></table>
&nbsp;<br><center> 
<table cellspacing=0 cellpadding=2 border=0 width=95%>
	<tr>
		<td>
<ol>
		<li>
			<b>Privacy</b><br>
			<br>
			We designed our <a href="http://www.HarvardConnection.co/policy.php">Privacy Policy</a> to make important disclosures about how you can use HarvardConnection to share with others and how we collect and can use your content and information.&nbsp; We encourage you to read the Privacy Policy, and to use it to help make informed decisions.
			<br><br>
		</li>
		<li>
			<b>Sharing Your Content and Information</b><br>
			<br>
			You own all of the content and information you post on HarvardConnection. In addition:
			<ol>
				<li>
					For content that is covered by intellectual property rights, like photos ("IP content"), you specifically give us the following permission: you grant us a non-exclusive, transferable, sub-licensable, royalty-free, worldwide license to use any IP content that you post on or in connection with HarvardConnection ("IP License"). This IP License ends when you delete your IP content or your account unless your content has been shared with others, and they have not deleted it.</li>
				<li>
					When you delete IP content, it is deleted in a manner similar to emptying the recycle bin on a computer. However, you understand that removed content may persist in backup copies for a reasonable period of time (but will not be available to others).</li>
				<li>
					When you publish content or information using the "everyone" setting, it means that you are allowing everyone, including people off of HarvardConnection, to access and use that information, and to associate it with you (i.e., your name and profile picture).</li>
				<li>
					We always appreciate your feedback or other suggestions about HarvardConnection, but you understand that we may use them without any obligation to compensate you for them (just as you have no obligation to offer them).</li>
			</ol>
		<br><br>
		</li>
		<li>
			<b>Safety</b><br>
			<br>
			We do our best to keep HarvardConnection safe, but we cannot guarantee it. We need your help to do that, which includes the following commitments:
			<ol>
				<li>
					You will not send or otherwise post unauthorized commercial communications (such as spam) on HarvardConnection.</li>
				<li>
					You will not collect users' content or information, or otherwise access HarvardConnection, using automated means (such as harvesting bots, robots, spiders, or scrapers) without our permission.</li>
				<li>
					You will not engage in unlawful multi-level marketing, such as a pyramid scheme, on HarvardConnection.</li>
				<li>
					You will not upload viruses or other malicious code.</li>
				<li>
					You will not solicit login information or access an account belonging to someone else.</li>
				<li>
					You will not bully, intimidate, or harass any user.</li>
				<li>
					You will not post content that: is hateful, threatening, or pornographic; incites violence; or contains nudity or graphic or gratuitous violence.</li>
				<li>
					You will not offer any contest, giveaway, or sweepstakes ("promotion") on HarvardConnection without our prior written consent.</li>
				<li>
					You will not use HarvardConnection to do anything unlawful, misleading, malicious, or discriminatory.</li>
				<li>
					You will not do anything that could disable, overburden, or impair the proper working of HarvardConnection, such as a denial of service attack.</li>
				<li>
					You will not facilitate or encourage any violations of this Statement.</li>
			</ol>
		<br><br>
		</li>
		<li>
			<b>Registration and Account Security</b><br>
			<br>
			HarvardConnection users provide their real names and information, and we need your help to keep it that way. Here are some commitments you make to us relating to registering and maintaining the security of your account:
			<ol>
				<li>
					You will not provide any false personal information on HarvardConnection, or create an account for anyone other than yourself without permission.</li>
				<li>
					You will not create more than one personal profile.</li>
				<li>
					If we disable your account, you will not create another one without our permission.</li>
				<li>
					You will not use your personal profile for your own commercial gain (such as selling your status update to an advertiser).</li>
				<li>
					You will not use HarvardConnection if you are under 13.</li>
				<li>
					You will not use HarvardConnection if you are a convicted sex offender.</li>
				<li>
					You will keep your contact information accurate and up-to-date.</li>
				<li>
					You will not share your password, let anyone else access your account, or do anything else that might jeopardize the security of your account.</li>
				<li>
					You will not transfer your account (including any page or application you administer) to anyone without first getting our written permission.</li>
			</ol>
		</li>
		
		
	</ol>
			</td>
	</tr>
</table>
</td></tr></table>
</td></tr></table> <br>
</td></tr></table> 
  <center> 
  <?PHP include('modules/default/bottomnav.php');	?>
  </center><br> 
  </td></tr></table> 
 

 