	function customreload (){
		if (document.documentElement.getAttribute('data-theme') === 'dark' ){
		Coloris(  {themeMode: 'dark' }); 
		}else {
		Coloris(  {themeMode: 'light' }); 
		}
		
		}

addEventListener("DOMContentLoaded", (event) => { 
	
		Coloris({
      el: '.colorpicker',
	        alpha: false,
		  format: 'hex',
		});
	

});
