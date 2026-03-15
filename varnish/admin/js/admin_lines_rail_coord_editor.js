
  async function callupapi(upcoord,upcoord_pr,tr,x,y,z) {
	 response =await fetch(upcoord+"?"+upcoord_pr);
		 if(response.headers.get("Sqlst")==="ok"){
	  	tr.cells[1].innerText=x;
        tr.cells[2].innerText=y;
        tr.cells[3].innerText=z;
		 }

	 }


function showEdit(btn) {
                var table = btn.closest('table');
                var tr = btn.closest('tr');
                var seq = tr.cells[0].innerText;
                var x = tr.cells[1].innerText;
                var y = tr.cells[2].innerText;
                var z = tr.cells[3].innerText;
                var coordId = tr.querySelector('input[name="coord_id"]').value;
           var name = document.getElementById("line_id").innerText;
	 var btus=[["Save","save"],["Cancel","can"]];
	 var inputs=[["X :",x],["Y :",y],["Z :",z]];
                var OldHTML = tr.cells[4].innerHTML;
	 
                var box =document.createElement("div");
	box.setAttribute("class","fakepage");
                var pagetile =document.createElement("h1");
	pagetile.setAttribute("class","qvhtile");
	pagetile.innerText="Editing Coordinate Of "+name;
		box.appendChild( pagetile);
	inputs.forEach((input) => { 
	input[2]=document.createElement("input");
	input[2].setAttribute("class","input");
	input[2].setAttribute("value",input[1]);
	input[2].setAttribute("type","input");
	input[3]=document.createElement("label");
	 input[3].innerHTML=input[0];
		box.appendChild(input[3]);
		box.appendChild(input[2]);
})
	btus.forEach((btu) => { 
	btu[2]=document.createElement("button");
	btu[2].setAttribute("class","button");
	btu[2].setAttribute("id",btu[1]);
	btu[2].setAttribute("type","button");
	 btu[2].innerHTML=btu[0];
	 btu[2].addEventListener("click", function (e) {
  document.getElementById("add-coord").removeAttribute("style");
 table.removeAttribute("style");
                tr.cells[4].innerHTML = OldHTML;
});
		box.appendChild(btu[2]);
})
                tr.cells[4].innerHTML = "";
                tr.cells[4].appendChild(box);
  document.getElementById("add-coord").setAttribute("style","display :none;");
  table.setAttribute("style","display: block;height: 30em;");
 btus[0][2].addEventListener("click", function (e) {
 upcoord="/admin_lines/upcoord";
upcoord_pr=new URLSearchParams();
	 x=inputs[0][2].value;
	 y=inputs[1][2].value;
	 z=inputs[2][2].value;

	upcoord_pr.set("coord_id", coordId);
	upcoord_pr.set("x", x);
	upcoord_pr.set("y", y);
	upcoord_pr.set("z", z);
	upcoord_pr.set("noredrect", "yes");
callupapi(upcoord,upcoord_pr,tr,x,y,z); 



	});
            }



