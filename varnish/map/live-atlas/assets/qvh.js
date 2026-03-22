ah=1;
function checkFlag() {
    if(!window.liveAtlasLoaded) {
        window.setTimeout(checkFlag, 100);
    } else {
        var posbox = document.getElementsByClassName("leaflet-top leaflet-left")[0];
        var searchbox = document.createElement("div");
        searchbox.id = "qvhhackbox"+ah;
        searchbox.className = "leaflet-control-logo leaflet-control";
        searchbox.innerHTML = `<svg class="svg-icon" viewBox="0 -960 960 960" fill="#e3e3e3"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>`;
        searchbox.style.cursor = "pointer";
        searchbox.addEventListener("click", function() {
            var panel = document.getElementById("qvh-search-panel");
            if (panel) {
                panel.classList.toggle("open");
                searchbox.classList.toggle("active");
                if (panel.classList.contains("open")) {
                    document.getElementById("qvh-search-input").focus();
                }
            }
        });
        posbox.appendChild(searchbox);
        ah++;

        var style = document.createElement("style");
        style.textContent = `
#qvh-search-panel {
    position: fixed;
    left: 6.5rem;
    top: 24.7rem;
    z-index: 9999;
    width: 280px;
    background: #1a1b26;
    border-radius: 0.375rem;
    color: #c0caf5;
    font-family: 'Fira Code', monospace;
    font-size: 15px;
    display: none;
    flex-direction: column;
    max-height: 60vh;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.5);
}
#qvh-search-panel.open { display: flex; }
#qvh-search-input {
    background: #1a1b26;
    border: none;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    color: #c0caf5;
    padding: 0.5rem 0.75rem;
    font-family: inherit;
    font-size: 15px;
    outline: none;
    width: 100%;
    box-sizing: border-box;
    border-radius: 0.375rem 0.375rem 0 0;
}
#qvh-search-input::placeholder { color: #6c7086; }
#qvh-search-results { overflow-y: auto; flex: 1; background: #1a1b26; }
.qvh-result {
    padding: 0.5rem 0.75rem;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    cursor: pointer;
    transition: background 0.1s;
    font-size: 15px;
}
.qvh-result:hover { background: rgba(255,255,255,0.07); }
.qvh-result-name { color: #c0caf5; font-weight: bold; }
.qvh-result-dial { color: #89dceb; }
.qvh-result-meta { color: #6c7086; font-size: 12px; margin-top: 2px; }
.qvh-no-results { padding: 0.75rem; color: #6c7086; text-align: center; font-size: 15px; }
#qvh-search-header {
    padding: 0.35rem 0.75rem;
    background: #1a1b26;
    color: #6c7086;
    font-size: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.leaflet-control-logo.active { background: rgb(55, 58, 80) !important; }
        `;
        document.head.appendChild(style);

        var panel = document.createElement("div");
        panel.id = "qvh-search-panel";
        panel.innerHTML = `
            <input id="qvh-search-input" type="text" placeholder="Search markers...">
            <div id="qvh-search-header">
                <span>Only searches dial names, not labels.</span>
                <span id="qvh-result-count"></span>
            </div>
            <div id="qvh-search-results"></div>
        `;
        document.body.appendChild(panel);

        var debounce;
        document.getElementById("qvh-search-input").addEventListener("input", function(e) {
            clearTimeout(debounce);
            var q = e.target.value.trim();
            if (q.length < 2) {
                document.getElementById("qvh-search-results").innerHTML = "";
                document.getElementById("qvh-result-count").textContent = "";
                return;
            }
            debounce = setTimeout(function() { search(q); }, 300);
        });

        function search(q) {
            var results = document.getElementById("qvh-search-results");
            var count = document.getElementById("qvh-result-count");
            results.innerHTML = '<div class="qvh-no-results">Searching...</div>';
            fetch("/search.php?q=" + encodeURIComponent(q) + "&a=20")
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (!data || !data.length) {
                        results.innerHTML = '<div class="qvh-no-results">No results found</div>';
                        count.textContent = "";
                        return;
                    }
                    count.textContent = data.length + " result" + (data.length !== 1 ? "s" : "");
                    results.innerHTML = data.map(function(item) {
                        return '<div class="qvh-result" data-x="' + item.x + '" data-y="' + (item.y || 64) + '" data-z="' + item.z + '">' +
                            '<div class="qvh-result-name">' + item.name + '</div>' +
                            '<div class="qvh-result-dial">/dial ' + item.dial + '</div>' +
                            '<div class="qvh-result-meta">X: ' + item.x + ' &nbsp; Z: ' + item.z + '</div>' +
                            '</div>';
                    }).join("");
                    results.querySelectorAll(".qvh-result").forEach(function(el) {
                        el.addEventListener("click", function() {
                            window.location.hash = "world;flat;" + el.dataset.x + "," + el.dataset.y + "," + el.dataset.z + ";5";
                            panel.classList.remove("open");
                            searchbox.classList.remove("active");
                        });
                    });
                })
                .catch(function() {
                    results.innerHTML = '<div class="qvh-no-results">Search failed</div>';
                    count.textContent = "";
                });
        }
    }
}
checkFlag();
