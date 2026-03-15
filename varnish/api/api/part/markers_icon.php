<?php
function api_markers_icon() {
header('Content-Type: application/json');

	$A=array_diff(scandir("/etc/novy/map/markers/"), array('..', '.'));
	$B=str_replace(".png","",$A);
	$C=0;
	$D=[];
foreach ($B as $value) {
	$D[$C]=$value;
	$C+=1;
}
$E=[
'data'=>$D
];

return($E);
}
?>
