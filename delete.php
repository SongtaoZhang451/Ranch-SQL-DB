<?php
/** -----------------------------------------------------------------
 *  delete.php  –  hard-delete one row
 *  Only role = admin may call
 *  ----------------------------------------------------------------- */
require_once __DIR__ . '/auth.php';   
require_once __DIR__ . '/db.php';

requireRole('admin');   // must be admin
verifyCSRF();           

$table = $_POST['table'] ?? '';
$pk    = $_POST['pk']    ?? '';

if ($table === '' || $pk === '') {
    http_response_code(400);
    exit('Bad request');
}

$pkCol = DB::conn()->query("DESCRIBE `$table`")
                   ->fetch(PDO::FETCH_NUM)[0];

$stmt = DB::conn()->prepare(
    "DELETE FROM `$table` WHERE `$pkCol` = ?"
);
$stmt->execute([$pk]);

header("Location: view.php?table=$table");
exit;
?>
