<?php
$page="map";
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once('../../../shared/db.php');
include('../../../shared/statslog.php');
include('../../../shared/webhook.php');
include('../../../shared/san.php');
include_once('../../../shared/credential.php');

webhookmsg("https://map.novymap-qvh.top/live-atlas/assets/fbi.png",$discord_maphook,"FBI","A user is using `" . $_SERVER['HTTP_USER_AGENT'] . "`" );
logStats("map");
$dialres=[];
$dialQuery = "
    SELECT 
        n.shot, 
        n.id, 
        n.name, 
        n.dial, 
        n.x, 
        n.y, 
        n.z, 
        n.admin, 
        m.name AS marker_name, 
        m.icon AS marker_icon, 
        m.id AS marker_id, 
        n.info
    FROM novy n
    JOIN marker m ON n.marker = m.id
";



$dialResult = mysqli_query($conn, $dialQuery);

while ($rawdialRow = mysqli_fetch_assoc($dialResult)) {
$dialRow=htmlsan($rawdialRow);
if (!isset( $dialres[$dialRow['marker_id']] )){
 $dialres[$dialRow['marker_id']] = [
	"hide" => false,
    "circles" => new stdClass(),
    "areas" => new stdClass(),
    "label" => "Dial (" . $dialRow['marker_name'] . ")",
    "lines" => new stdClass(),
    "layerprio" => 1 
    ];

}
if (empty($dialRow['admin'])){
$dialRow['admin']="Who?";
}
	$lowcaseicon = strtolower($dialRow['marker_icon']);
		$resdesc = "<div class=\"dial-box\">";
	$resdesc .= "<h1 class=\"dial-name\">" . $dialRow['name'] . "</h1>";
		$resdesc .= "<div class=\"dial-bar\"></div>";
		if (!(empty($dialRow['shot'])||$dialRow['shot']==="No Screenshot"))
		{
			 $resdesc .= '<a class="dial-img-warpper" href="https://api.novymap-qvh.top/api/staging/shot?id='.$dialRow['id'].'">';
			 $resdesc .= '<img class="dial-img" src="https://api.novymap-qvh.top/api/staging/shot?id='.$dialRow['id'].'">';
			 $resdesc .= '</a>';
		}

		$resdesc .= "<p  class=\"dial-dial\">/dial " . $dialRow['dial'] . "</p>";
		 $resdesc .= "<p  class=\"dial-info\">" . $dialRow['info'] . "</p>";
		$resdesc .= "<p  class=\"dial-coord\">" ."X : ". $dialRow['x'] ." Y : ".$dialRow['y'] . " Z : " . $dialRow['z'] . "<br> ID : ".$dialRow['id']. " Added by : ".$dialRow['admin']. "</p>";
		$resdesc .= "</div>";

    $dialres[$dialRow['marker_id']]["markers"][$dialRow['id']] = [
        "label" => $dialRow['name'],
        "desc" => $resdesc,
        "x" => $dialRow['x'],
        "y" => $dialRow['y'],
        "z" => $dialRow['z'],
        "icon" => $lowcaseicon,
        "info" => $dialRow['name']
    ];
}

if (!$dialResult) {
    http_response_code(500);
    $response['error'] = 'Query failed: ' . mysqli_error($conn);
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit();
}

// Fetch train/lines data
$trainQuery = "
    SELECT 
        l.id AS line_id, 
        l.name AS line_name, 
        l.color AS line_color, 
        l.info AS line_info, 
        lc.seq, 
        lc.x, 
        lc.y, 
        lc.z
    FROM `lines` l
    JOIN line_coords lc ON l.id = lc.line_id
    ORDER BY l.id, lc.seq
";

$trainResult = mysqli_query($conn, $trainQuery);

if (!$trainResult) {
    http_response_code(500);
    $response['error'] = 'Train query failed: ' . mysqli_error($conn);
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit();
}

// Format train/lines data
$trains = [];
while ($trainRow = mysqli_fetch_assoc($trainResult)) {
	$trainsan=htmlsan([
		"name"=>$trainRow['line_name'],
		"info"=>$trainRow['line_info']
	]);
    $lineId = $trainRow['line_id'];
    if (!isset($trains[$lineId])) {
		$resdesc = "<div class=\"dial-box\">";
	$resdesc .= "<h1 class=\"dial-name\">" . $trainsan['name'] . "</h1>";
		$resdesc .= "<div class=\"dial-bar\"></div>";
		 $resdesc .= "<p  class=\"dial-info\">" . $trainsan['info'] . "</p>";
		$resdesc .= "</div>";

        $trains[$lineId] = [
            "color" => $trainRow['line_color'],
            "markup" => false,
        "desc" => $resdesc,
            "x" => [],
            "y" => [],
            "z" => [],
            "label" => $trainRow['line_name'],
            "opacity" => 0.80,
            "weight" => 3
        ];
    }
    $trains[$lineId]["x"][] = $trainRow['x'];
    $trains[$lineId]["y"][] = $trainRow['y'];
    $trains[$lineId]["z"][] = $trainRow['z'];
}

$response = [
    "sets" => [],
    "timestamp" => round(microtime(true) * 1000)
];
$response['sets']=$dialres;
$response['sets']["rail"]= [
    "hide" => false,
    "circles" => new stdClass(),
    "areas" => new stdClass(),
    "label" => "Rail Lines",
    "markers" => new stdClass(),
    "lines" => $trains,
    "layerprio" => 1
];
$response["sets"]["markers"]=[
            "hide" => false,
            "circles" => new stdClass(),
            "areas" => [
                "_worldborder_world" => [
                    "fillcolor" => "#000000",
                    "ytop" => 64.00,
                    "color" => "#FF0000",
                    "markup" => false,
                    "y" => "100",
                    "x" => [-19999.50, 20000.50, 20000.50, -19999.50],
                    "weight" => 3,
                    "z" => [-19999.50, -19999.50, 20000.50, 20000.50],
                    "ybottom" => 64.00,
                    "label" => "Border",
                    "opacity" => 0.80,
                    "fillopacity" => 0.00
                ]
            ],
            "label" => "World Border",
            "markers" => [],
            "lines" => [],
            "layerprio" => 0
];

// Close DB connection
mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
?>

