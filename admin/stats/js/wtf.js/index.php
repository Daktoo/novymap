
// My dumb ass ide think it is html but it is js ..
// so i puted script to fool it
// yes wtf
//<script>
<?php    
header('Content-Type: application/javascript');
include "../../../adm.phphidden";
include "../../st.phphidden";
$san=htmlsan([
'fromDate' => $_GET['from'] ?? '',
'toDate' => $_GET['to'] ?? '',
'aggregation' => $_GET['aggregation'] ?? 'day',
]);
$datalist=fatchstats($san['fromDate'],$san['toDate'],$san['aggregation'],$conn,false);
$san['tabid']=htmlspecialchars($_GET['tabid'] ?? $datalist[0][0]);


	 $wtf="const datalist = ";
	 $wtf.=json_encode($datalist,JSON_PRETTY_PRINT);
	 $wtf.=";";

echo($wtf."\n" );


?>
var QVHChart=[];

function drawChart(view,index,id,name,data) {
    if (QVHChart[index]){QVHChart[index].destroy()};
  Chart.defaults.color = window.getComputedStyle(document.body).getPropertyValue('--text');
  Chart.defaults.elements.arc.borderWidth = 0;
  Chart.defaults.borderColor = window.getComputedStyle(document.body).getPropertyValue('--chartcolor');
  Chart.defaults.backgroundColor = "rgba(0, 0, 0, 0)";
    QVHChart[index] = new Chart(document.getElementById(id+'Chart').getContext('2d'), {
        type: view,
        data: {
            labels: Object.keys(data),
            datasets: [{
                label: name+' Distribution',
                data: Object.values(data),
                backgroundColor: Object.keys(data).map(() => '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0')),
                color: Object.keys(data).map(() => '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0')),
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });
}


	function drawTable (id,name,data) {
		let eh = "";
  		eh+='<thead>';
               eh+=' <tr><th>'+name+'</th><th>Counts</th></tr>';
           	eh+=' </thead>';
             eh+='<tbody>';
	for (let [a, b] of Object.entries(data)) {
		eh+='<tr><td>';
			eh+= a;
		eh+='</td><td>';
			eh+=b;
		eh+='</td></tr>';
		}
		document.getElementById(id+"Table").innerHTML=eh;
	}


	function loadchartable () {
		datalist.forEach((element,index) => {
	let view = document.getElementById('viewtoggle').value;
    let chart = document.getElementById( element[0] +'Chart');
    let table = document.getElementById( element[0]+'Table');
	

 if (view === 'table') {
 chart.style.display = 'none';
        table.style.display = 'table';
        drawTable(element[0],element[1],element[2]);
    } else {
 chart.style.display = 'block';
        table.style.display = 'none';
        drawChart(view,index,element[0],element[1],element[2]);
    }

		});

}



function statsreload(bbbb) {
let activetab="";
	if (bbbb===""){
var list = document.getElementsByClassName("tabtu");
for (var i = 0; i < list.length; i++) {
    if(list[i].getAttribute("data-tabselected")===''){
	    activetab=list[i].getAttribute("data-tabid");
    }
}
	}else{
activetab=bbbb;	
	}

url="/stats/";
url+="?from=";
url+=document.getElementById("fromdate").value;
url+="&to=";
url+=document.getElementById("todate").value;
url+="&aggregation=";
url+=document.getElementById("aggregation").value;
url+="&viewtoggle=";
url+=document.getElementById("viewtoggle").value;
url+="&tabid=";
url+=activetab;
window.history.pushState({},'',url); 

}
	function customreload() {
		loadchartable();
	}

addEventListener("DOMContentLoaded", (event) => { 

var foumchild=document.getElementById("stats-from").childNodes;
for (let kidd of foumchild) {
if (kidd!==document.getElementById('viewtoggle')){
kidd.addEventListener('change',(e) => {
document.getElementById("stats-from").submit();
});
}
}
document.getElementById('viewtoggle').addEventListener('change',() => {
//document.getElementById('viewtoggle-hack').value=document.getElementById('viewtoggle').value;
statsreload("");
		loadchartable();
});
var tabtuwu = document.getElementsByClassName("tabtu");

for (let btuwu of tabtuwu) {
	btuwu.addEventListener('click', (e) => {
	let id=e.target.getAttribute("data-tabid");
	if (document.querySelector("#"+id+"tab[open]") === null ) 
	{document.getElementById(id+"tab").toggleAttribute("open");
	}
document.getElementById('tabid-input').value=id;
	statsreload(id);
	
	}, false);
}

var tabpages = document.getElementsByClassName("tabpage");
for (let tab of tabpages) {
    tab.addEventListener("toggle", (event) => { 
if(event.target.open){  
var tabtus = document.getElementsByClassName("tabtu");
for (let btu of tabtus) {
    if(btu.getAttribute("data-tabid")===event.target.getAttribute("data-tabid")){
    btu.setAttribute("data-tabselected","");
    }else{
    btu.removeAttribute("data-tabselected");
    }
}
}
    }); 
}
});

//</script>
