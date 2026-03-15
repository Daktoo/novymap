var QVHChart = [];
var datalist = {};
function filpdata(data) {
    var out = {};
    for (let[a,b] of Object.entries(data)) {
        for (let[c,d] of Object.entries(b)) {
            if (typeof (out[c]) === 'undefined') {
                out[c] = {};
            }
            out[c][a] = d;
        }
    }
    return (out);
}
function drawChart(view, index, dataarry) {
    var id = dataarry[0];
    var name = dataarry[1];
    if (QVHChart[index]) {
        QVHChart[index].destroy()
    }
    ;Chart.defaults.color = window.getComputedStyle(document.body).getPropertyValue('--text');
    Chart.defaults.elements.arc.borderWidth = 0;
    Chart.defaults.borderColor = window.getComputedStyle(document.body).getPropertyValue('--text') + window.getComputedStyle(document.body).getPropertyValue('--charttransparent');
    Chart.defaults.backgroundColor = 'rgba(0, 0, 0, 0)';
    if (document.getElementById('filptoggle').value === 'yes') {
        var data = filpdata(dataarry[2]);
    } else {
        var data = dataarry[2];
    }
    const Labels = [...new Set(Object.values(data).flatMap(d => Object.keys(d)))].sort();
    const Datasets = Object.entries(data).map( ([page,views]) => {
        const color = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
        return {
            label: page,
            data: Labels.map(label => views[label] || 0),
            backgroundColor: color,
            borderColor: color,
            fill: false
        };
    }
    );
    if (document.getElementById('stacktoggle').value === 'yes') {
        stack = true;
    } else {
        stack = false;
    }
    QVHChart[index] = new Chart(document.getElementById(id + 'Chart').getContext('2d'),{
        type: view,
        data: {
            labels: Labels,
            datasets: Datasets,
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: stack
                },
                y: {
                    stacked: stack,
                    beginAtZero: true
                },
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
}
function drawTable(dataarry) {
    var id = dataarry[0];
    var name = dataarry[1];
    if (document.getElementById('filptoggle').value === 'yes') {
        var data = dataarry[2];
        var tilteA = name;
        var tilteB = 'Date';
    } else {
        var data = filpdata(dataarry[2]);
        var tilteB = name;
        var tilteA = 'Date';
    }
    let eh = '';
    eh += '<thead>';
    eh += ' <tr><th>' + tilteB + '</th><th>Counts</th></tr>';
    eh += ' </thead>';
    eh += '<tbody>';
    for (let[a,b] of Object.entries(data)) {
        let count = 0;
        for (let[c,d] of Object.entries(b)) {
            count = count + d;
        }
        eh += '<tr><td>';
        eh += a;
        eh += '</td>';
        eh += '<td>';
        eh += '<details><summary>' + count + ' (Click to expand)</summary><table class="stats-table-in-table">';
        eh += '<thead>';
        eh += ' <tr><th>' + tilteA + '</th>';
        eh += ' <th>Counts (' + count + ')</th></tr>';
        eh += ' </thead>';
        for (let[c,d] of Object.entries(b)) {
            eh += '<tr>';
            eh += '<td>';
            eh += c;
            eh += '</td>';
            eh += '<td>';
            eh += d;
            eh += '</td>';
            eh += '</tr>';
            eh += '</details>';
        }
        eh += '</table>';
        eh += '</td>';
        eh += '</tr>';
    }
    eh += '</tbody>';
    document.getElementById(id + 'Table').innerHTML = eh;
}
async function loadchartable(shoulditfetch) {
    if (shoulditfetch) {
        document.getElementsByClassName('nav-title')[0].textContent = 'Loading...';
        var params = new URLSearchParams();
        url = 'api/internal/data?';
        var foumchild = document.getElementById('stats-from').childNodes;
        for (let kid of foumchild) {
            if (typeof (kid.name) !== 'undefined' && typeof (kid.value) !== 'undefined') {
                params.append(kid.name, kid.value);
            }
        }
        url += params.toString();
        const response = await fetch(url);
        const mine = await response.headers.get('Content-Type');
        datalist = await response.json();
        if (mine === 'application/json') {
            document.getElementsByClassName('nav-title')[0].textContent = navtitletext;
        } else {
            document.getElementsByClassName('nav-title')[0].textContent = 'Error';
        }
    }
    datalist.forEach( (data, index) => {
        let view = document.getElementById('viewtoggle').value;
        let chart = document.getElementById(data[0] + 'Chart');
        let table = document.getElementById(data[0] + 'Table');
        if (view === 'table') {
            chart.style.display = 'none';
            table.style.display = 'table';
            document.querySelector('label[for=stacktoggle]').setAttribute('hidden', '');
            document.getElementById('stacktoggle').setAttribute('hidden', '');
            drawTable(data);
        } else {
            chart.style.display = 'block';
            table.style.display = 'none';
            document.querySelector('label[for=stacktoggle]').removeAttribute('hidden');
            document.getElementById('stacktoggle').removeAttribute('hidden');
            drawChart(view, index, data);
        }
    }
    );
}
function statsreload() {
    var params = new URLSearchParams();
    url = '/stats/?';
    var foumchild = document.getElementById('stats-from').childNodes;
    for (let kid of foumchild) {
        if (typeof (kid.name) !== 'undefined' && typeof (kid.value) !== 'undefined') {
            params.append(kid.name, kid.value);
        }
    }
    url += params.toString();
    window.history.pushState({}, '', url);
}
function customreload() {
    loadchartable(Object.keys(datalist).length === 0);
}
addEventListener('DOMContentLoaded', (event) => {
    var foumchild = document.getElementById('stats-from').childNodes;
    for (let kidd of foumchild) {
        if (kidd == document.getElementById('viewtoggle') || kidd == document.getElementById('stacktoggle') || kidd == document.getElementById('filptoggle')) {
            kidd.addEventListener('change', (e) => {
                statsreload(false);
                loadchartable();
            }
            );
        } else {
            kidd.addEventListener('change', (e) => {
                statsreload();
                loadchartable(true);
            }
            );
        }
    }
    var tabtuwu = document.getElementsByClassName('tabtu');
    for (let btuwu of tabtuwu) {
        btuwu.addEventListener('click', (e) => {
            let id = e.target.getAttribute('data-tabid');
            if (document.querySelector('#' + id + 'tab[open]') === null) {
                document.getElementById(id + 'tab').toggleAttribute('open');
            }
            document.getElementById('tabid-input').value = id;
            statsreload();
        }
        , false);
    }
    var tabpages = document.getElementsByClassName('tabpage');
    for (let tab of tabpages) {
        tab.addEventListener('toggle', (event) => {
            if (event.target.open) {
                var tabtus = document.getElementsByClassName('tabtu');
                for (let btu of tabtus) {
                    if (btu.getAttribute('data-tabid') === event.target.getAttribute('data-tabid')) {
                        btu.setAttribute('data-tabselected', '');
                    } else {
                        btu.removeAttribute('data-tabselected');
                    }
                }
            }
        }
        );
    }
}
);
;
