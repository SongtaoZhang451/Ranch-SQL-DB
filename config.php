<?php
// ---------- database credentials ----------
define('DB_HOST', 'localhost');
define('DB_NAME', 'cbase');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ---------- session ----------
session_start();
// generate one CSRF token per session
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}
?>
