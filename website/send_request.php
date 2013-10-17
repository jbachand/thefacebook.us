<?php
// PATH TO THE FB-PHP-SDK
include($_SERVER["DOCUMENT_ROOT"].'/admin/classes/classes.php');		// Include local class lib

$facebook = new Facebook(array(
'appId' => 'APP_ID',
'secret' => 'APP_SECRET'
));

$user = $facebook->getUser();
$loginUrl = $facebook->getLoginUrl();

if ( empty($user) ) {
echo("<script> top.location.href='" . $loginUrl . "'</script>");
exit();
}
?>
<!doctype html>
<html>
<head>
<script type="text/javascript" src="/js/jquery-1.5.2.min.js"></script>
</head>
<body>
<a href="#">Send your friends a flower!</a>

<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
FB.init({
appId : 'APP_ID',
status : true,
cookie : true,
xfbml : true
});
};

$('a').click(sendRequest);
function sendRequest() {
FB.ui({
method: 'apprequests',
message: 'I want to give you this flower!',
title: 'Give a flower to some of your friends',
data: '{"item_id":1254,"item_type":"plant"}'
},
function (response) {
if (response && response.request_ids) {
var requests = response.request_ids.join(',');
$.post('handle_requests.php',{uid: <?php echo $user; ?>, request_ids: requests},function(resp) {
});
} else {
alert('canceled');
}
});
return false;
}

(function() {
var e = document.createElement('script');
e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
e.async = true;
document.getElementById('fb-root').appendChild(e);
}());
</script>
</body>
