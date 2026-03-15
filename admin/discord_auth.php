<?php
define('DISCORD_CLIENT_ID', '1482187978712420574');
define('DISCORD_CLIENT_SECRET', '55fo6fnaGann7I5fToNZijKFBQudAEee');
define('DISCORD_REDIRECT_URI', 'https://novyadmin.daktoinc.co.uk/discord_callback');
define('DISCORD_API', 'https://discord.com/api/v10');

$allowed_ids = [
    '772430494633033740',
    '1199506443762663535',
    '552492688381968397',
    '745943962191396875',
    '875574646924255262',
    '899289713339424819',
    '1347956697666424976'
];

session_start();

$action = $_GET['action'] ?? '';

if ($action === 'login') {
    $state = bin2hex(random_bytes(16));
    $_SESSION['oauth2_state'] = $state;
    $params = http_build_query([
        'client_id' => DISCORD_CLIENT_ID,
        'redirect_uri' => DISCORD_REDIRECT_URI,
        'response_type' => 'code',
        'scope' => 'identify',
        'state' => $state
    ]);
    header('Location: https://discord.com/oauth2/authorize?' . $params);
    exit;
}

if ($action === 'callback') {
    if (!isset($_GET['code']) || !isset($_GET['state'])) {
        die('Invalid callback.');
    }
    if ($_GET['state'] !== $_SESSION['oauth2_state']) {
        die('Invalid state.');
    }

    $ch = curl_init(DISCORD_API . '/oauth2/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'client_id' => DISCORD_CLIENT_ID,
        'client_secret' => DISCORD_CLIENT_SECRET,
        'grant_type' => 'authorization_code',
        'code' => $_GET['code'],
        'redirect_uri' => DISCORD_REDIRECT_URI
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (!isset($response['access_token'])) {
        die('Failed to get access token.');
    }

    $ch = curl_init(DISCORD_API . '/users/@me');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
    $user = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (!isset($user['id'])) {
        die('Failed to get user info.');
    }

    global $allowed_ids;
    if (!in_array($user['id'], $allowed_ids)) {
        http_response_code(403);
        die('You are not allowed to access this panel.');
    }

    $_SESSION['discord_user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'avatar' => isset($user['avatar'])
            ? 'https://cdn.discordapp.com/avatars/' . $user['id'] . '/' . $user['avatar'] . '.png'
            : 'https://cdn.discordapp.com/embed/avatars/0.png',
        'global_name' => $user['global_name'] ?? $user['username']
    ];

    header('Location: /');
    exit;
}

if ($action === 'logout') {
    session_destroy();
    header('Location: /discord_auth?action=login');
    exit;
}

header('Location: /discord_auth?action=login');
exit;
