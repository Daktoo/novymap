<?php
$admpagetitle="Home Page";
include 'adm.phphidden';
pageView("Admin Panels Home Page :wrench::triangular_flag_on_post::book:");
	echo(admin_head($admpagetitle));
	echo(admin_navbar());
?>
	<body>

<div class="center"
<link rel="icon" type="image/x-icon" href="../shared/novymap-qvh.png">>
<div class="settings-container-top">
<?php
echo "<h1 class=\"qvhtile\">Admin Panel</h1><h1 class=\"qvhtilesmall\">Welcome, $fuckinguserinfo[name]</h1>";
?>
<div class="feature-grid">
         
            <div onclick="window.location.assign(&quot;/admin_poi&quot;)" class="feature-card">
                    <h3>POI Admin Panel</h3>
            </div>
           
            <div onclick="window.location.assign(&quot;/admin_lines&quot;)" class="feature-card">
                    <h3>Rail Line Admin Panel</h3>
            </div>
<div onclick="window.location.assign(&quot;/admin_marker&quot;)" class="feature-card">
                    <h3>Marker Admin Panel</h3>
            </div>
<div onclick="window.location.assign(&quot;/phpinfo&quot;)" class="feature-card">
                    <h3>Server Info</h3>
            </div>
<div onclick="window.location.assign(&quot;/stats/&quot;)"  class="feature-card">
                        <h3>Stats</h3>
                    </div>
<div onclick="window.location.assign(&quot;/webhooktester&quot;)"  class="feature-card">
                        <h3>WebHook Tester</h3>
                    </div>

</div>
</div>
</div>
    <?php include '../shared/footer.php'; ?>
	</body>
</html>

