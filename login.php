<?php /* login.php */
require_once __DIR__.'/config.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $u = $_POST['user'] ?? '';
    $p = $_POST['pass'] ?? '';
    // demo users hard-coded; in production请查 DB
    $demo = ['admin'=>'adminpwd','manager'=>'managerpwd','viewer'=>'viewerpwd'];
    if (isset($demo[$u]) && $demo[$u] === $p) {
        $_SESSION['role'] = $u;
        header('Location: index.php'); exit;
    }
    $err = "Invalid credentials";
}
?>
<?php include 'header.php'; ?>
<h2>Login</h2>
<?php if (!empty($err)) echo "<p style='color:red'>$err</p>"; ?>
<form method="post">
  <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
  <label>User <input name="user" required></label><br>
  <label>Pass <input type="password" name="pass" required></label><br>
  <button>Login</button>
</form>
<?php include 'footer.php'; ?>
