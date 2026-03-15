<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Novymap</title>
    <link rel="stylesheet" href="../shared/nav.css">
    <link rel="stylesheet" href="css/sitewide.css">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Novymap Home">
    <meta name="twitter:description" content="This is the home page of Novymap, where you can do stuffs..">
</head>
<body>
  
    <?php include '../shared/navbar.php'; ?>
    <?php include '../shared/db.php'; ?>
    <main class="center">
        <section class="settings-container-top">
            <?php if (!$userData): ?>
                <h1>You need to log in to use some features</h1>
                <p><a href="/auth/login">Click here to log in</a>.</p>
                <h2>Explore Novymap</h2>
                <div class="feature-grid">
                    <a href="https://novymap.daktoinc.co.uk3" class="feature-card">
                        <h3>Interactive Map</h3>
                        <p>Discover and explore points of interest on our interactive map.</p>
                    </a>
                    <a href="https://discord.com/invite/NSdnxsjA8y" class="feature-card">
                        <h3>Discord</h3>
                        <p>Did we miss any dials? Contact us on our Discord server!</p>
                    </a>
                    <a href="#" class="feature-card disabled">
                        <h3>Coming soon</h3>
                        <p>Coming soon.</p>
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
            <?php else: ?>
                <h1>Welcome, <?php echo htmlspecialchars($userData['username']); ?>!</h1>
                <h2>Explore Novymap</h2>
                <div class="feature-grid">
                    <a href="https://novymap.daktoinc.co.uk3" class="feature-card">
                        <h3>Interactive Map</h3>
                        <p>Discover and explore points of interest on our interactive map.</p>
                    </a>
                    <a href="https://discord.com/invite/NSdnxsjA8y" class="feature-card">
                        <h3>Discord</h3>
                        <p>Did we miss any dials? Contact us on our Discord server!</p>
                    </a>
                    <a href="#" class="feature-card disabled">
                        <h3>Coming soon</h3>
                        <p>Coming soon.</p>
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
            <?php endif; ?>
        </section>
            <style>
                .team-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 20px;
                    margin-top: 20px;
                }
                .team-card {
                    text-align: center;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                    background-color: #f9f9f9;
                }
                .team-image {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    object-fit: cover;
                    margin-bottom: 10px;
                }
            </style>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
