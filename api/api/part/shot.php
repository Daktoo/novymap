<?php function api_shot($conn,$id=0) {     
	$daid = intval($id);   $sql = "SELECT `shot` FROM novy WHERE id = $daid;";     
	$result = mysqli_query($conn, $sql);$shotid="";	   
	while ($row = mysqli_fetch_assoc($result)){		
		$shotid=$row['shot'];		            }	  
	if(is_file("/srv/http/novy/shot2/".$shotid.".png")){ 
		return(readfile("/srv/http/novy/shot2/".$shotid.".png"));
	} else {	
		$fucked=json_encode(["request"=>[		  
			"id"=>$_GET['id'],		    ],	
			"error" =>[ "message" => "No Sceenshot found" ]		 
		]);	
	}	    return($fucked ?? '');}
?>
