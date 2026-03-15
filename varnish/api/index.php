<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Playground</title>
    <link rel="stylesheet" href="/shared/nav.css">
    <link rel="stylesheet" href="css/sitewide.css">
    <link rel="stylesheet" href="css/api.css">
    <link rel="icon" type="image/png" href="/novymap-qvh.png">
    <meta property="og:title" content="Novymap API Playground">
    <meta property="og:description" content="Test and interact with the Novymap API endpoints.">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
</head>
<?php include '../shared/navbar.php'; ?>
<body>
<div class="api-main">
    <div class="api-side-bar">
        <h3>API Navigation</h3>
        <details id="api-dropdown">
            <summary class="api-dropdown-title">Map Endpoints</summary>
            <a href="#all">All Data API</a>
            <a href="#search">Search API</a>
            <a href="#search_railline">Search Railline API</a>
            <a href="#info">Info API</a>
            <a href="#info_railline">Info Railline API</a>
            <a href="#cords">Cordinate API</a>
            <a href="#railline">Railline API</a>
            <a href="#markers">Markers API</a>
            <a href="#markers_icon">Markers Icon API</a>
            <a href="#shot">Screenshot API</a>
        </details>
    </div>
    <div class="api-container">
        <h1>API fun</h1>
        <p>Test and interact with the provided API endpoints below. Fill in the parameters and click "Send Request" to see the response.</p>
        
        <h2>Open Endpoints</h2>

        <h3 id="all"><strong>All Data API</strong></h3>
        <div class="explanation">
            <p><strong>dial</strong> (optional): Filter data by the `dial` parameter.</p>
            <p>- `0`: Return all records.</p>
            <p>- `1`: Return only records where `dial` is not `N/A`.</p>
            <p>Example: `dial=1`</p>
        </div>
        <div id="all-form">
            <label class="api-label" for="all-dial">Dial (0 for all, 1 for filtered):</label>
            <input class="input" type="number" data-urlpart="dial" id="all-dial" placeholder="0">
            <button class="button" type="button" onclick="callApi('all')">Send Request</button>
        </div>
        <div class="url-display" id="all-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="all-response">Response will appear here...</pre>
        </div>
        
        <h3 id="search"><strong>Search API</strong></h3>
        <div class="explanation">
            <p><strong>q</strong> <span class="required">(required)</span>: The search query term.</p>
            <p>Example: `q=drop`</p>
            <p><strong>a</strong> (optional): The number of results to return. Default is 10.</p>
            <p>Example: `a=5`</p>
            <p><strong>w</strong> (optional): The field(s) to search in. Options:</p>
            <ul>
                <li>`name` – Search in the `name` field.</li>
                <li>`dial` – Search in the `dial` field.</li>
                <li>`both` (default) – Search in both fields.</li>
            </ul>
            <p>Example: `w=name`</p>
            <p><strong>d</strong> (optional): Filter results by `dial` value:</p>
            <ul>
                <li>`0` – Return all records, regardless of `dial`.</li>
                <li>`1` – Return records where `dial` is not `N/A`.</li>
            </ul>
            <p>Example: `d=1`</p>
        </div>
        <div id="search-form">
            <label class="api-label" for="search-q">Query (<strong>q</strong>):</label>
            <input required="" class="input" type="text" data-urlpart="q" id="search-q" placeholder="Enter search term">
            
            <label class="api-label" for="search-a">Amount (<strong>a</strong>):</label>
            <input class="input" type="number" data-urlpart="a" id="search-a" placeholder="10">
            
            <label class="api-label" for="search-w">Search in (<strong>w</strong>):</label>
            <select class="input" data-urlpart="w" id="search-w">
                <option value="both">Both</option>
                <option value="name">Name</option>
                <option value="dial">Dial</option>
            </select>
            
            <label class="api-label" for="search-d">Dial Filter (<strong>d</strong>):</label>
            <input class="input" type="number" data-urlpart="d" id="search-d" placeholder="0">
            
            <button class="button" type="button" onclick="callApi('search')">Send Request</button>
        </div>
        <div class="url-display" id="search-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="search-response">Response will appear here...</pre>
        </div>

        <h3 id="search_railline"><strong>Search Railline API</strong></h3>
        <div class="explanation">
            <p><strong>q</strong> <span class="required">(required)</span>: The search query term.</p>
            <p>Example: `q=drop`</p>
            <p><strong>a</strong> (optional): The number of results to return. Default is 10.</p>
            <p>Example: `a=5`</p>
        </div>
        <div id="search_railline-form">
            <label class="api-label" for="railline-search-q">Query (<strong>q</strong>):</label>
            <input required="" class="input" type="text" data-urlpart="q" id="railline-search-q" placeholder="Enter search term">
            
            <label class="api-label" for="railline-search-a">Amount (<strong>a</strong>):</label>
            <input class="input" type="number" data-urlpart="a" id="railline-search-a" placeholder="10">
 
            <button class="button" type="button" onclick="callApi('search_railline')">Send Request</button>
        </div>
        <div class="url-display" id="search_railline-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="search_railline-response">Response will appear here...</pre>
        </div>

        <h3 id="info_railline"><strong>Info Railline API</strong></h3>
        <div class="explanation">
            <p><strong>id</strong> <span class="required">(required)</span>: The Rail ID.</p>
            <p>Example: `id=6`</p>
        </div>
        <div id="info_railline-form">
            <label class="api-label" for="info-railline-id">ID (<strong>id</strong>):</label>
            <input required="" class="input" type="number" data-urlpart="id" id="info-railline-id" placeholder="Enter ID">
            <button class="button" type="button" onclick="callApi('info_railline')">Send Request</button>
        </div>
        <div class="url-display" id="info_railline-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="info_railline-response">Response will appear here...</pre>
        </div>

        <h3 id="info"><strong>Info API</strong></h3>
        <div class="explanation">
            <p><strong>id</strong> <span class="required">(required)</span>: The Dail ID.</p>
            <p>Example: `id=6`</p>
        </div>
        <div id="info-form">
            <label class="api-label" for="info-id">ID (<strong>id</strong>):</label>
            <input required="" class="input" type="number" data-urlpart="id" id="info-id" placeholder="Enter ID">
            <button class="button" type="button" onclick="callApi('info')">Send Request</button>
        </div>
        <div class="url-display" id="info-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="info-response">Response will appear here...</pre>
        </div>

        <h3 id="cords"><strong>Cordinate API</strong></h3>
        <div class="explanation">
            <p><strong>x</strong> <span class="required">(required)</span>: The X coordinate for the center point.</p>
            <p>Example: `x=420`</p>
            <p><strong>z</strong> <span class="required">(required)</span>: The Z coordinate for the center point.</p>
            <p>Example: `z=69`</p>
            <p><strong>r</strong> (optional): The radius within which to search, with a default value of 256.</p>
            <p>Example: `r=128`</p>
            <p><strong>a</strong> (optional): The number of results to return, default is 10.</p>
            <p>Example: `a=1`</p>
            <p><strong>d</strong> (optional): Filter results by `dial` value:</p>
            <ul>
                <li>`0` – Return all records, regardless of `dial`.</li>
                <li>`1` – Return records where `dial` is not `N/A`.</li>
            </ul>
            <p>Example: `d=1`</p>
        </div>
        <div id="cords-form">
            <label class="api-label" for="cords-x">X Coordinate (<strong>x</strong> <span class="required">(required)</span>):</label>
            <input class="input" type="number" data-urlpart="x" id="cords-x" placeholder="Enter X coordinate" required>
            <p>Example: <code>x=420</code></p>

            <label class="api-label" for="cords-z">Z Coordinate (<strong>z</strong> <span class="required">(required)</span>):</label>
            <input class="input" type="number" data-urlpart="z" id="cords-z" placeholder="Enter Z coordinate" required>
            <p>Example: <code>z=69</code></p>

            <label class="api-label" for="cords-r">Radius (<strong>r</strong> - optional):</label>
            <input class="input" type="number" data-urlpart="r" id="cords-r" placeholder="256">
            <p>Example: <code>r=128</code></p>

            <label class="api-label" for="cords-a">Amount (<strong>a</strong> - optional):</label>
            <input class="input" type="number" data-urlpart="a" id="cords-a" placeholder="10">
            <p>Example: <code>a=1</code></p>

            <label class="api-label" for="cords-d">Dial Filter (<strong>d</strong> - optional):</label>
            <input class="input" type="number" data-urlpart="d" id="cords-d" placeholder="0">
            <ul>
                <li><code>0</code> &ndash; Return all records, regardless of <code>dial</code>.</li>
                <li><code>1</code> &ndash; Return records where <code>dial</code> is not <code>N/A</code>.</li>
            </ul>
            <p>Example: <code>d=1</code></p>

            <button class="button" type="button" onclick="callApi('cords')">Send Request</button>
        </div>
        <div class="url-display" id="cords-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="cords-response">Response will appear here...</pre>
        </div>

        <h3 id="railline"><strong>Railline API</strong></h3>
        <div class="explanation">
            <p>No parameters are needed for this endpoint. It returns all available rail line data.</p>
        </div>
        <div id="railline-form">
            <button class="button" type="button" onclick="callApi('railline')">Send Request</button>
        </div>
        <div class="url-display" id="railline-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="railline-response">Response will appear here...</pre>
        </div>

        <h3 id="markers"><strong>Markers API</strong></h3>
        <div class="explanation">
            <p>No parameters are needed for this endpoint. It returns a list of all available markers.</p>
        </div>
        <div id="markers-form">
            <button class="button" type="button" onclick="callApi('markers')">Send Request</button>
        </div>
        <div class="url-display" id="markers-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="markers-response">Response will appear here...</pre>
        </div>

        <h3 id="markers_icon"><strong>Markers Icon API</strong></h3>
        <div class="explanation">
            <p>No parameters are needed for this endpoint. It returns a list of all available markers icons.</p>
        </div>
        <div id="markers_icon-form">
            <button class="button" type="button" onclick="callApi('markers_icon')">Send Request</button>
        </div>
        <div class="url-display" id="markers_icon-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="markers_icon-response">Response will appear here...</pre>
        </div>

        <h3 id="shot"><strong>Screenshot API</strong></h3>
        <div class="explanation">
            <p><strong>id</strong> <span class="required">(required)</span>: Dial ID.</p>
            <p>Example: `id=43`</p>
        </div>
        <div id="shot-form">
            <label class="api-label" for="shot-id">Dial ID (<strong>id</strong> <span class="required">(required)</span>):</label>
            <input required="" class="input" type="number" data-urlpart="id" id="shot-id" placeholder="Enter ID">
            <button class="button" type="button" onclick="callApi('shot')">Send Request</button>
        </div>
        <div class="url-display" id="shot-url">URL will be displayed here...</div>
        <div class="response-container">
            <h4>Response:</h4>
            <pre class="api-pre json-container" id="shot-response">Response will appear here...</pre>
            <img class="api-blob" data-hidden="" id="shot-response-blob">
        </div>
    </div>
</div>

<?php include '../shared/footer.php'; ?>
<script src="/js/api.js"></script>
</body>
</html>
