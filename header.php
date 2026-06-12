<!-- header.php -->
<?php require_once __DIR__.'/auth.php'; verifyCSRF(); ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8"><title>Ranch DB</title>
<link rel="stylesheet" href="assets/style.css">
</head><body>
<nav>
  <a href="index.php">Home</a>
  <?php if (isset($_SESSION['role'])): ?>
    | Role: <?= htmlspecialchars($_SESSION['role']) ?>
    | <a href="logout.php">Logout</a>
  <?php endif; ?>
</nav>
<hr>
