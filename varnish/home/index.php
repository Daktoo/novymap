<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Novymap</title>
    <link rel="stylesheet" href="../shared/nav.css">
    <link rel="stylesheet" href="css/sitewide.css">
    <link rel="icon" type="image/png" href="../shared/novymap-qvh.png">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Novymap Home">
    <meta name="twitter:description" content="Explore Novymap - discover points of interest on our interactive map.">
</head>
<body>

    <?php include '../shared/navbar.php'; ?>
    <?php include '../shared/discord.php'; ?>
    <?php include '../shared/db.php'; ?>
    <main class="center">
        <section class="settings-container-top">
            <h2>Explore Novymap</h2>
            <div class="feature-grid">
                <a href="https://novymap.daktoinc.co.uk" class="feature-card">
                    <h3>Interactive Map</h3>
                    <p>Discover and explore points of interest on our interactive map.</p>
                </a>
                <a href="https://discord.com/invite/NSdnxsjA8y" class="feature-card">
                    <h3>Discord</h3>
                    <p>Did we miss any dials? Contact us on our Discord server!</p>
                </a>
                <a href="https://novyadmin.daktoinc.co.uk" class="feature-card">
                    <h3>Admin Panel</h3>
                    <p>Join our Discord to apply for Admin.</p>
                </a>
                <a href="https://novyapi.daktoinc.co.uk" class="feature-card">
                    <h3>API Documentation</h3>
                    <p>Access our API documentation to integrate with Novymap.</p>
                </a>
                <a href="/credits" class="feature-card">
                    <h3>Credits</h3>
                    <p>Learn about the mediocre people behind Novymap.</p>
                </a>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
