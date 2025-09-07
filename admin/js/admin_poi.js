function dropdownclick(name,fakevalue,value,img) {

        let dropdownicon=`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="dropdown-fake-arrow" ><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M7 10l5 5 5-5H7z"></path></svg>`;
document.getElementById(name).setAttribute("value",value);
        let btu='<img class="drowdrop-fake-img" src="';
                btu+=img;
                btu+='">';
                btu+="<p class=\"drowdrop-fake-text\">";
        btu+=fakevalue;
btu+="</p>";
                btu+=dropdownicon;

        document.getElementById("fake-"+name).innerHTML=btu;
                document.getElementById(name+"-dropdown").toggleAttribute("open");
}

