<?php
include("../../shared/db.php");
$directory = "./part";
foreach (array_diff(scandir($directory), array('..', '.')) as $ah) {
include($directory.'/'.$ah);
}
$jsonarg=JSON_PRETTY_PRINT;
if($_SERVER['PATH_INFO']==='/staging/all'){
header('Content-Type: application/json');
echo(json_encode(api_all($conn,$_GET['dial']),$jsonarg));
}elseif($_SERVER['PATH_INFO']==='/staging/cords'){
header('Content-Type: application/json');
echo(json_encode(api_cords($conn,$_GET["x"],$_GET["z"],$_GET["r"],$_GET["a"],$_GET["d"]),$jsonarg));
}elseif($_SERVER['PATH_INFO']==='/staging/markers'){
header('Content-Type: application/json');
echo(json_encode(api_markers($conn),$jsonarg));
}elseif($_SERVER['PATH_INFO']==='/staging/markers_icon'){
header('Content-Type: application/json');
echo(json_encode(api_markers_icon(),JSON_FORCE_OBJECT+$jsonarg));
}elseif($_SERVER['PATH_INFO']==='/staging/railline'){
header('Content-Type: application/json');
echo(json_encode(api_railline($conn),$jsonarg));
}elseif($_SERVER['PATH_INFO']==='/staging/search'){
header('Content-Type: application/json');
echo(json_encode(api_search($conn,$_GET["q"],$_GET["a"],$_GET["w"],$_GET["d"]),$jsonarg));
}elseif($_SERVER['PATH_INFO']==='/staging/search_railline'){
header('Content-Type: application/json');
echo(json_encode(api_search_railline($conn,$_GET["q"],$_GET["a"]),$jsonarg));
}elseif($_SERVER['PATH_INFO']==='/staging/info'){
header('Content-Type: application/json');
echo(json_encode(api_info($conn,$_GET["id"]),$jsonarg));
}elseif($_SERVER['PATH_INFO']==='/staging/info_railline'){
header('Content-Type: application/json');
echo(json_encode(api_info_railline($conn,$_GET["id"]),$jsonarg));
}elseif($_SERVER['PATH_INFO']==='/staging/shot'){
header('Content-Type: image/png');
echo(api_shot($conn,$_GET["id"]));
}elseif($_SERVER['PATH_INFO']==='/staging/wikidump'){
echo(api_wikidump($conn));
}else {
echo(json_encode(["error"=>"No API Found"],$jsonarg));
}
?>
