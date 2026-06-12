<?php
/** -----------------------------------------------------------------
 *  edit.php  –  insert or update one row
 *  ----------------------------------------------------------------- */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

$table  = $_GET['table'] ?? $_POST['table'] ?? '';
if ($table === '') {
    exit('Missing table parameter');
}

requireRole('manager');      // viewer cannot reach this page
verifyCSRF();                // on every POST

$pdo   = DB::conn();
$cols  = $pdo->query("DESCRIBE `$table`")->fetchAll(PDO::FETCH_ASSOC);
$pkCol = $cols[0]['Field'];

/* ------------------------------------------------------------------
 *  Handle form submission
 * ------------------------------------------------------------------ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isUpdate = isset($_POST['pk']) && $_POST['pk'] !== '';

    // build SQL
    if ($isUpdate) {                           // UPDATE
        $set  = implode(',', array_map(fn($c)=>"`{$c['Field']}`=?", $cols));
        $sql  = "UPDATE `$table` SET $set WHERE `$pkCol`=?";
        $vals = array_map(fn($c)=>$_POST[$c['Field']] ?? null, $cols);
        $vals[] = $_POST['pk'];
    } else {                                   // INSERT
        $fields = implode(',', array_map(fn($c)=>"`{$c['Field']}`", $cols));
        $place  = rtrim(str_repeat('?,', count($cols)), ',');
        $sql    = "INSERT INTO `$table` ($fields) VALUES ($place)";
        $vals   = array_map(fn($c)=>$_POST[$c['Field']] ?? null, $cols);
    }

    /* --- NEW: catch DB errors and report instead of blank page --- */
    try {
        $pdo->prepare($sql)->execute($vals);
        header("Location: view.php?table=$table");
        exit;
    } catch (PDOException $e) {
        $errMsg = $e->getMessage();   // fall through to form with error
    }
}

/* ------------------------------------------------------------------
 *  If GET, fetch existing record for editing
 * ------------------------------------------------------------------ */
$record = [];
if (isset($_GET['pk'])) {
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `$pkCol`=?");
    $stmt->execute([$_GET['pk']]);
    $record = $stmt->fetch() ?: [];
}

include 'header.php';
?>
<h2><?= $record ? 'Edit' : 'Add' ?> <?= htmlspecialchars($table) ?></h2>

<?php
if (!empty($errMsg)) {
    echo "<p style='color:red'>DB error: " . htmlspecialchars($errMsg) . "</p>";
}
?>

<form method="post">
  <input type="hidden" name="csrf"  value="<?= $_SESSION['csrf'] ?>">
  <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
  <?php if ($record): ?>
      <input type="hidden" name="pk" value="<?= htmlspecialchars($record[$pkCol]) ?>">
  <?php endif; ?>

  <table>
    <?php foreach ($cols as $c):
        $f = $c['Field'];
        $v = $record[$f] ?? ''; ?>
        <tr>
          <td><?= htmlspecialchars($f) ?></td>
          <td><input name="<?= htmlspecialchars($f) ?>" value="<?= htmlspecialchars($v) ?>"></td>
        </tr>
    <?php endforeach; ?>
  </table>

  <button>Save</button>
</form>

<?php include 'footer.php'; ?>
