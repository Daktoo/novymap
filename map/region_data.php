<?php
header('Content-Type: application/json');
header('Cache-Control: public, max-age=60');

include_once '/etc/novy/shared/credential.php';

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_database);
if (!$conn) {
    echo json_encode([]);
    exit;
}

$regions = [];
$result = mysqli_query($conn, "SELECT id, name, color FROM `regions` ORDER BY id ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $rid = (int)$row['id'];
    $coords = [];
    $cres = mysqli_query($conn, "SELECT x, y, z FROM region_coords WHERE region_id=$rid ORDER BY seq ASC");
    while ($c = mysqli_fetch_assoc($cres)) {
        $coords[] = ['x' => (int)$c['x'], 'y' => (int)$c['y'], 'z' => (int)$c['z']];
    }
    if (count($coords) >= 3) {
        $regions[] = [
            'id'     => $rid,
            'name'   => $row['name'],
            'color'  => $row['color'],
            'coords' => $coords
        ];
    }
}

mysqli_close($conn);
echo json_encode($regions);
?>
