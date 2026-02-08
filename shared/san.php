<?php
//Dont use empty() here 0 is empty for empty()
//i love php
function sqlsan($array,$conn) {
                $res=[];
        foreach ($array as $key => $value) {
		if($value === NULL){$res[$key]="";}
		else {$res[$key]=mysqli_real_escape_string($conn,$value);}
}
return $res;
}

function htmlsan($array) {
                $res=[];
        foreach ($array as $key => $value) {
		if($value === NULL){$res[$key]="";}
		else{$res[$key]=htmlspecialchars($value);}
}
return $res;
}


?>

