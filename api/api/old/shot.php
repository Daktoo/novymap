<?php
include('../../shared/db.php');
		    header('Access-Control-Allow-Origin: *');

 if (isset($_GET['id'])){
            $daid = intval($_GET['id']);
   $sql = "SELECT `shot` FROM novy WHERE id = $daid;";
                $result = mysqli_query($conn, $sql);
$shotid="";
	    while ($row = mysqli_fetch_assoc($result)){
			$shotid=$row['shot'];
		            }
	    if(is_file("/srv/http/shot2/".$shotid.".png")){
		    header('Content-Type: image/png');
 readfile("/srv/http/shot2/".$shotid.".png");
	    } else {
		    header('Content-Type: application/json');
		    http_response_code(500);
		    $fucked=json_encode(["request"=>[
		    "id"=>$_GET['id'],
		    ],
		    "error" =>[ "message" => "No Sceenshot found" ]
		    ]);
	    }
 }else{
 header('Content-Type: application/json');
		    http_response_code(500);
 $fucked=json_encode(["request"=>[
		    ],
		    "error" =>[ "message" => "Required ID" ]
		    ]);
 }
echo($fucked ?? '');
 ?>

