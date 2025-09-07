<?php
function sqlsan($array,$conn) {
                $res=[];
        foreach ($array as $key => $value) {
		if(empty($value)){$res[$key]="";}
		else {$res[$key]=mysqli_real_escape_string($conn,$value);}
}
return $res;
}

function htmlsan($array) {
                $res=[];
        foreach ($array as $key => $value) {
		if(empty($value)){$res[$key]="";}
		else{$res[$key]=htmlspecialchars($value);}
}
return $res;
}


?>

