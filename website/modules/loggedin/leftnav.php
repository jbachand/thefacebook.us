           <table class="dashedtable" cellspacing=0 cellpadding=2 width=100%>

              <tr>
				<td width="15%"></td>
				<td width="70%" align=right>
				<p><form action="search.php">
                  <input class="inputtext" name=name type=text style="width:85px">
				  <br>quick&nbsp;search&nbsp;<input type="submit" class="inputsubmit" style="width:22px" value="go">
				  </form>
				</p>
				</td>
				<td width="15%"></td>
			  </tr>
			  </table>
			  <br>
              <table class="dashedtable" cellspacing=0 cellpadding=10 width=100%>

              <tr><td align=left style="color:#538ADC">

                  <p style="color:#538ADC">
				  <a href="profile.php">My Profile</a> [ <a href="editprofile.php">edit</a> ]<br>
				   <?PHP
			  
					  $relation=new Relationship();
					  $yourpending=$relation->pending_requests();
					  
					  if($yourpending[0]>0){
					?>
				  <a href="reqs.php">My&nbsp;Requests&nbsp;<b>[ <?PHP echo count($yourpending);?> ]</b></a><br>
				  <?PHP }?>
				  <a href="editfriends.php">My Friends</a><br>
				  <a href="browse.php">My Network</a><br>
				  <a href="messages.php">My Messages</a>
				  <?PHP $msg=new Message(); if($msg->get_messagecount(-1, 'unread')>0) echo "<b>[ ".$msg->get_messagecount(-1, 'unread')." ]</b>"; ?>
				  <br>
				  <a href="account.php">My Account</a><br>
				  <a href="accountprivacy.php">My Privacy</a><br>
				
				</p>


                  <!--<br>-->

              </td></tr></table>
			  <br>
			  
			  <?PHP if($sess->Retrieve('accountstatus')==9){
				$ministats = new statistics();
				//$yesministats = new statistics();
				$today = date('Y-m-d');
				$yesterday = date('Y-m-d', strtotime("yesterday"));
			  
			  ?>
			  <table class="dashedtable" cellspacing=0 cellpadding=5 width=100%>

              <tr><td align=left style="color:#538ADC">

                  <p style="color:#538ADC">
				  
				  <a href="http://www.thefacebook.us/a/">Admin Panel</a><br>
				  <a href="https://gator1523.hostgator.com:2083/3rdparty/phpMyAdmin/index.php?db=newportb_harvardconnection" target="_new">PHPMYADMIN</a><br>
				  <br>
				  <b>Today:</b>
				  <hr>
				  <table width="100%">
					
														<tr>
															<td style="color:#538ADC">
															New&nbsp;Users:
															</td>
															<td style="color:#538ADC" align=right>
															<b><?PHP echo $ministats->usercount($today);?></b><br>
															</td>
														</tr>
														<tr>
															<td style="color:#538ADC">
															Active&nbsp;Users:
															</td>
															<td style="color:#538ADC" align=right>
															<b><?PHP echo $ministats->dailyactiveusercount($today);?></b><br>
															</td>
														</tr>														
														<tr>
															<td style="color:#538ADC">
																Total&nbsp;Views:
															</td>
															<td style="color:#538ADC" align=right>
																<b><?PHP echo $ministats->viewcount($today);?></b>
															</td>
														</tr>
														<tr>
															<td style="color:#538ADC">
																Unique&nbsp;Visitors:
															</td>
															<td style="color:#538ADC" align=right>
																<b><?PHP echo $ministats->uniquevisitors($today);?></b>
															</td>
														</tr>
					</table>
				  
			 </td></tr></table>
			  <br>
			  <?PHP } ?>
	