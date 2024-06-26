<?php

// Firebase Cloud Messaging Authorization Key
define('FCM_AUTH_KEY', 'AAAABUMvGpQ:APA91bGfwNo7_Jj8At13vLO6PJI5KfYF2laOc-bAcpjcYXsNjLG44Z5dG8yBQ3zCjlbnE2579KKelisrKaBlegRzQRdfBhmtgcTa46IVALTlGMGVmIKv8x1m_zfu8cnweeZCTxwjq7ZA');

function sendPush($to, $title, $body, $icon, $url) {
	$postdata = json_encode(
	    [
	        'notification' => 
	        	[
	        		'title' => $title,
	        		'body' => $body,
	        		'icon' => $icon,
	        		'click_action' => $url
	        	]
	        ,
	        'to' => $to
	    ]
	);

	$opts = array('http' =>
	    array(
	        'method'  => 'POST',
	        'header'  => 'Content-type: application/json'."\r\n"
	        			.'Authorization: key='.FCM_AUTH_KEY."\r\n",
	        'content' => $postdata
	    )
	);

	$context  = stream_context_create($opts);

	$result = file_get_contents('https://fcm.googleapis.com/fcm/send', false, $context);
	if($result) {
		return json_decode($result);
	} else return false;
}

sendPush('your-client-push-authorization-key', 'This is the title!', 'And this is the text.', 'https://anysite.com/some_image.png', 'https://openthissiteonclick.com');