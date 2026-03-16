<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include_once '/etc/novy/shared/credential.php';

$q = trim($_GET['q'] ?? '');
$a = min((int)($_GET['a'] ?? 20), 50);

if (strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_database);
if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}

$safe = mysqli_real_escape_string($conn, $q);
$sql = "SELECT n.id, n.name, n.dial, n.x, n.y, n.z, m.name AS marker_name
        FROM novy n
        JOIN marker m ON n.marker = m.id
        WHERE n.dial REGEXP '(^|[^a-zA-Z0-9])$safe([^a-zA-Z0-9]|$)'
        LIMIT $a";

$result = mysqli_query($conn, $sql);
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed']);
    exit;
}

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = [
        'id'       => (int)$row['id'],
        'name'     => $row['name'],
        'dial'     => $row['dial'],
        'x'        => (int)$row['x'],
        'y'        => (int)$row['y'],
        'z'        => (int)$row['z'],
        'category' => $row['marker_name']
    ];
}

mysqli_close($conn);
echo json_encode($rows);
