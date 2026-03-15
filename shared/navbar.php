<?php
// Start the session
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['discord_access_token']);
?>
        <link rel="icon" type="image/png" href="novymap-qvh.png">
<div class="nav">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
        <div class="nav-title">
            novymap
        </div>
    </div>
    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>
    <div class="nav-links">
        <a href="/">Home</a>
        <a href="https://novymap.daktoinc.co.uk">Map</a>
        <?php if ($isLoggedIn): ?>
            <a href="https://discord.gg/NSdnxsjA8y">Discord</a>
            <a href="https://novyapi.daktoinc.co.uk">API</a>
            <a href="#">Logout</a>
        <?php else: ?>
            <a href="#">Login</a>
        <?php endif; ?>
        <a href="javascript:void(0);" onclick="toggleTheme()">Toggle Theme</a>
    </div>
</div>
<script>
  // Check the system's default theme
  const prefersDarkMode = window.matchMedia("(prefers-color-scheme: dark)").matches;

  // Get the current theme from cookies or default to system preference
  const currentTheme = document.cookie.replace(/(?:(?:^|.*;\s*)theme\s*\=\s*([^;]*).*$)|^.*$/, "$1") || (prefersDarkMode ? 'dark' : 'light');

  // Apply the current theme
  document.documentElement.setAttribute('data-theme', currentTheme);

  // Toggle function
  function toggleTheme() {
    const newTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', newTheme);
    // Store the user's preference in a cookie
    document.cookie = `theme=${newTheme}; path=/; max-age=31536000`; // 1 year expiry
  }
</script>