<?php

// Firebase Cloud Messaging Server Key
define('FCM_SERVER_KEY', 'AAAABUMvGpQ:APA91bGfwNo7_Jj8At13vLO6PJI5KfYF2laOc-bAcpjcYXsNjLG44Z5dG8yBQ3zCjlbnE2579KKelisrKaBlegRzQRdfBhmtgcTa46IVALTlGMGVmIKv8x1m_zfu8cnweeZCTxwjq7ZA');

function sendPush($to, $title, $body, $icon, $url) {
    $data = [
        'notification' => [
            'title' => $title,
            'body' => $body,
            'icon' => $icon,
            'click_action' => $url
        ],
        'to' => $to
    ];

    $headers = [
        'Authorization: key=' . FCM_SERVER_KEY,
        'Content-Type: application/json'
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $result = curl_exec($ch);
    curl_close($ch);

    if ($result) {
        return json_decode($result);
    } else {
        return false;
    }
}

$result = sendPush(
    'your-device-registration-token',
    'This is the title!',
    'And this is the text.',
    'https://anysite.com/some_image.png',
    'https://openthissiteonclick.com'
);

if ($result) {
    echo 'Push notification sent successfully.';
} else {
    echo 'Failed to send push notification.';
}
?>
