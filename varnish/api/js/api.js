        async function callApi(endpoint) {
	const jsonbox = document.getElementById(`${endpoint}-response`) ?? '' ;
		const otherbox = document.getElementById(`${endpoint}-response-blob`) ?? '' ;
let dontfetch=false;
            const params = new URLSearchParams();
            document.querySelectorAll(`#${endpoint}-form input, #${endpoint}-form select`).forEach(input => {
               
		    if ((!input.value) && input.required) {
			dontfetch=true;
                }
 if (input.value) {
                    params.append(input.getAttribute("data-urlpart"), input.value);
                }
            });
		if (dontfetch){
	if ( jsonbox !== '' ) {
            jsonbox.innerHTML = 'Response will appear here...<br><span class="required">(Error : Required fill ain\'t filled)</span>';
			}

			return;
		} 
            const url = `https://novyapi.daktoinc.co.uk/api/staging/${endpoint}?` + params.toString();
            document.getElementById(`${endpoint}-url`).textContent = url;
            const response = await fetch(url);
	    const mine = await response.headers.get('Content-Type');
	
		if(mine==="application/json"){
			if ( jsonbox !== '' ) {
            const data = await response.json();
            jsonbox.innerHTML = syntaxHighlight(data);
				jsonbox.removeAttribute("data-hidden");
			}
			if ( otherbox !== '' ) {
				otherbox.setAttribute("data-hidden","");
			}
		} else {
			if ( otherbox !== '' ) {
            otherbox.src = url;
				otherbox.removeAttribute("data-hidden");
			}
		if ( jsonbox !== '' ) {
				jsonbox.setAttribute("data-hidden","");
			}

		}
        
	}
               function syntaxHighlight(json) {
            if (typeof json !== "string") {
                json = JSON.stringify(json, null, 2);
            }
            json = json
                .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;")
                .replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|\b\d+\.?\d*\b)/g, match => {
                let cls = 'json-number';
                if (/^"/.test(match)) {
                    cls = /:$/.test(match) ? 'json-key' : 'json-string';
                } else if (/true|false/.test(match)) {
                    cls = 'json-boolean';
                } else if (/null/.test(match)) {
                    cls = 'json-null';
                }
                return `<span class="${cls}">${match}</span>`;
                });
            return json;
        }
