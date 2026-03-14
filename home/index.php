<?php 
include '../shared/navbar.php'; 
include '../shared/neofetch.php';
include '../shared/db.php';
echo(htmlhead("Novymap"));
echo(navbar());
?>
<body>
    <div class="center">
        <div class="settings-container-top">
                <h1 class="qvhtile">Novymap project</h1><h1 class="qvhtilesmall">  Forked from QVH by Dakto.</h1>
                <div class="feature-grid">
                    <div onclick="window.location.assign(&quot;https://map.novymap-qvh.top/&quot;)" href="https://novymap.daktoinc.co.uk/" class="feature-card">
                        <h3>Interactive Map</h3>
                        <p>Discover and explore points of interest on our interactive map.</p>
                    </div>
                    <div onclick="window.location.assign(&quot;/credits&quot;)"  class="feature-card">
                        <h3>Credits</h3>
                        <p>Learn about the mediocre people behind Novymap-qvh.</p>
                    </div>
 <div onclick="window.location.assign(&quot;https://novyadmin.daktoinc.co.uk/&quot;)" class="feature-card">
                        <h3><del>Admin Panel</del></h3>
                        <p>Admin stuffs</p>
                    </div>
<div onclick="window.location.assign(&quot;https://discord.gg/NSdnxsjA8y&quot;)"  class="feature-card">
                        <h3>Discord</h3>
                        <p>Do we miss any dail?Let us know in discord.</p>
                    </div>

<div onclick="window.location.assign(&quot;https://discord.com/oauth2/authorize?client_id=1413462775581114468&quot;)"  class="feature-card">
                        <h3>Discord Bot</h3>
                        <p>Offical Discord Bot</p>
                    </div>


<div onclick="window.location.assign(&quot;https://novyapi.daktoinc.co.uk/&quot;)"  class="feature-card">
                        <h3>Map API</h3>
                        <p>Map API Stuff</p>
                    </div>


<div onclick="window.location.assign(&quot;https://novyauth.daktoinc.co.uk/api/swagger/&quot;)"  class="feature-card">
                        <h3>Auth API</h3>
                        <p>Auth API Stuff</p>
                    </div>

                </div>
                </div>


  <div class="settings-container-top">
                <h1 class="qvhtile">BTW I use Arch :3</h1>
<h1 class="qvhtilesmall">Also PHP and Nginx :3</h1>

<?php echo(neofetch(true,$conn));?>
              </div>
              </div>

    <?php include '../shared/footer.php'; ?>
</body>
</html>
