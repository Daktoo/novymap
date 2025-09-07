<?php
// statslog.php — Enhanced stats logger with client tracking and anonymized IP

    include('db.php');

function logStats() {

global $conn;
    // Collect data
    $timestamp = date('Y-m-d H:i:s');

    // IP anonymization (IPv4 truncate last octet)
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;

    // User agent
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

    // GET parameters
    $queryParams = json_encode($_GET, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $server_var = json_encode($_SERVER, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


    // Insert into DB
    $stmt = $conn->prepare("
        INSERT INTO usage_log_qvh (timestamp,  ip_address, user_agent, query_params, server_var)
        VALUES (?,  ?, ?, ?, ?)
    ");

    if ($stmt) {
        $stmt->bind_param('sssss', $timestamp,  $ip, $userAgent, $queryParams, $server_var);
        $stmt->execute();
        $stmt->close();
    } else {
        error_log("Statslog DB insert failed: " . $conn->error);
    }

}
?>
