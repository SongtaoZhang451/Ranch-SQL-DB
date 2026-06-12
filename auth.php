<?php
require_once __DIR__.'/config.php';

// --- simple role system: viewer < manager < admin ---
function requireRole(string $needed): void {
    $have  = $_SESSION['role'] ?? 'viewer';
    $rank  = ['viewer'=>0,'manager'=>1,'admin'=>2];
    if ($rank[$have] < $rank[$needed]) {
        http_response_code(403);
        exit('403 Forbidden – insufficient privileges');
    }
}

// helper to check CSRF on every POST
function verifyCSRF(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
            http_response_code(400);
            exit('Bad CSRF token');
        }
    }
}
?>
