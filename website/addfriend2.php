<form method="post" action="https://www.facebook.com/addfriend.php?id=4&amp;hf=friend_other" onsubmit="return Event.__inlineSubmit(this,event)"> 
<input type="hidden" name="charset_test" value="&euro;,&acute;,€,´,?,?,?" />
<input type="hidden" name="fb_dtsg" value="AQDww100" autocomplete="off" />
<input type="hidden" autocomplete="off" id="confirmed" name="confirmed" value="1" />
<input type="hidden" autocomplete="off" id="post_form_id" name="post_form_id" value="145971dbfcc98d02a00d9d61ca815d6c" />
<div id="addMsg"><p><a href="#" onclick="show('addMsgBox'); hide('addMsg'); return false; ">[ Add a personal message ]</a></p>
</div><div id="addMsgBox" style="display:none; margin-left: 10px;">
<div class="add_personal_message" style="margin-bottom: 4px;">Add a personal message:&nbsp;
<a href="#" onclick="hide('addMsgBox'); show('addMsg'); return false;">Cancel</a></div>
<textarea onkeyup="textLimit(&#039;message&#039;,255,&#039;message_msg&#039;);" id="message" name="message" class="textarea" cols="30" rows="3" style="width: 250px;" onfocus="" onblur=""></textarea><br/><span id="message_msg" style="display: none;"><small>Keep it under 255 characters.</small></span></div></div>
<div class="buttonbox">
<input type="submit" class="inputsubmit" onclick="var w = add_to_friend_list_widget.dict[&quot;4&quot;];var d = w.get_form_data();for(k in d) &#123; var i = document.createElement(&#039;input&#039;);i.type=&quot;hidden&quot;;i.name=k;i.value=d[k];this.form.appendChild(i);&#125;;return true;" id="add" name="add" value="Add Friend" />
&nbsp;&nbsp;<input type="button" class="inputbutton inputaux" onclick="history.go(-1);return true" id="cancel" name="cancel" value="Cancel" /></div></form>