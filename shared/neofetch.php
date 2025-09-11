<?php
function loopoutput($fuck){
$res="";
$length = count($fuck); 
for ($i = 0; $i < $length; $i++) { 
    $res.= $fuck[$i]; 
    if ( ! empty($fuck[$i]) ) {
	    $res.=('<br>');
    }
}
  return $res;

}

function neofetch($neofetch_A = false,$conn = false){
$neofetch_useless="";
$neofetch_outputA="";
$neofetch_outputB="";
$res="";
putenv("PHPSERVER=".$_SERVER['SERVER_SOFTWARE']);
putenv("PHPVER=".phpversion());
putenv("PHPSAPI=".PHP_SAPI);
if ($conn) {
putenv("SQLVER=".mysqli_get_server_info($conn));
}
if ($neofetch_A){
	$res .= '<div class="archbox-center terminal">';
} else {
	$res .= '<div class="archbox terminal">';
}
 $res .= '<pre class="archlogo">';
exec('neofetch -L | aha --no-header', $neofetch_outputA, $neofetch_useless);
$res .= loopoutput($neofetch_outputA);
$res .=  '</pre>';
 $res .=  '<pre  class="archinfo">';
exec('neofetch --off | aha --no-header', $neofetch_outputB, $neofetch_useless);
 $res .=loopoutput($neofetch_outputB);

$res .= '</pre>';
$res .= '</div>';
    return $res;
}


?>
