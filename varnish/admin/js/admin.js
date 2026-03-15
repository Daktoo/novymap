function rufksure(php,thing,action="delete") {
  let res = prompt("Please type YES to confirm\nyou want to "+action + " " + thing, "fucking no");
let sure="";

if (res==="YES") {
	sure=true;
  } else {
	sure=false;
  }

if (php===null) {
	return sure;
}


if (sure) {
window.location.assign(php);
}
}
function shotrufksure() {
	shotimgexist=document.getElementById("shot-upload") ?? false;
	if (shotimgexist){
	shotimgexist=document.getElementById("shot-upload").files.length;
	}
	if (shotimgexist&&document.getElementById("shot-img")){
	return rufksure(null,"screenshot","overwrite");
	} else {
		return true;
	}
}
 
