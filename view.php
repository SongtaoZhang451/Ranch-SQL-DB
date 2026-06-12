<?php
/** -----------------------------------------------------------------
 *  view.php  –  list + search + link to Add / Edit / Delete
 *  Roles:
 *    viewer   – read-only
 *    manager  – read / add / update
 *    admin    – full CRUD
 *  ----------------------------------------------------------------- */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';

$table = $_GET['table'] ?? '';
if ($table === '') {
    exit('Missing ?table= parameter');
}

$q    = $_GET['q'] ?? '';
$data = DB::fetchAll($table, $q);

include 'header.php';
?>
<h2><?= htmlspecialchars($table) ?></h2>

<!-- search box -->
<form>
  <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
  <input name="q" placeholder="search" value="<?= htmlspecialchars($q) ?>">
  <button>Search</button>
</form>

<?php
/* ==== NEW: “Add” button for manager/admin ==== */
if (in_array($_SESSION['role'] ?? '', ['manager', 'admin'])) {
    echo "<p><a class='btn' href='edit.php?table=" .
         urlencode($table) .
         "'>+ New " . htmlspecialchars($table) . "</a></p>";
}

/* ==== table body ==== */
if (!$data) {
    echo "<p>No records found.</p>";
    include 'footer.php';
    exit;
}

echo "<table><thead><tr>";
foreach (array_keys($data[0]) as $col) {
    echo "<th>" . htmlspecialchars($col) . "</th>";
}
echo "<th>Actions</th></tr></thead><tbody>";

foreach ($data as $row) {
    echo "<tr>";
    foreach ($row as $v) {
        echo "<td>" . htmlspecialchars($v) . "</td>";
    }

    $pk = array_values($row)[0]; // assumes first column = PK

    echo "<td><a href='edit.php?table=$table&amp;pk=$pk'>edit</a>";

    if (($_SESSION['role'] ?? '') === 'admin') {
        echo " <form style='display:inline' method='post' action='delete.php'>
                 <input type='hidden' name='csrf'  value='{$_SESSION['csrf']}'>
                 <input type='hidden' name='table' value='$table'>
                 <input type='hidden' name='pk'    value='$pk'>
                 <button onclick=\"return confirm('Delete this record?')\">del</button>
               </form>";
    }

    echo "</td></tr>";
}
echo "</tbody></table>";

include 'footer.php';
?>
