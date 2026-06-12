<?php
/* --------------------------------------------------------------------
 *  db.php  –  singleton PDO + utility helpers
 * ------------------------------------------------------------------ */
require_once __DIR__ . '/config.php';

class DB {
    private static ?PDO $pdo = null;

    /** singleton PDO connection */
    public static function conn(): PDO {
        if (!self::$pdo) {
            $dsn = "mysql:host=" . DB_HOST .
                   ";dbname="      . DB_NAME .
                   ";charset="     . DB_CHARSET;
            self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$pdo;
    }

    /** Return the whole table, or a LIKE-search across *every* column. */
    public static function fetchAll(string $table, string $q = ''): array {
        /* 1) build base SQL */
        $sql    = "SELECT * FROM `$table`";
        $params = [];

        /* 2) add broad LIKE filter if $q given */
        if ($q !== '') {
            $cols = self::allColumns($table);
            // CONCAT_WS converts every column to CHAR, so INT works too
            $concat = "CONCAT_WS('|', " . implode(',', array_map(fn($c)=>"`$c`", $cols)) . ")";
            $sql   .= " WHERE $concat LIKE ?";
            $params = ["%$q%"];
        }

        $st = self::conn()->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    /** helper: return list of column names (all data types) */
    private static function allColumns(string $table): array {
        $st = self::conn()->prepare(
            "SHOW COLUMNS FROM `$table`"
        );
        $st->execute();
        return $st->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>