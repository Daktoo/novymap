<?php
include_once "credential.php";


function webhookmsg( $avatarUrl,$webhookUrl,$name,$message ) {
    $data = json_encode(array(
        "username" => $name,
        "content" => $message,
        "avatar_url" => $avatarUrl
    ));

    // Initialize cURL session
    $ch = curl_init($webhookUrl);

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session
    $result = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error occurred: ' . curl_error($ch);
    }

}

?>
