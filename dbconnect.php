<?php
try {
    $db = new PDO('mysql:dbname=thread;host=133.167.72.97;charset=utf8mb4', 'root', 'SXZRKaa2');
}   catch (PDOException $e) {
    echo "データベース接続エラー　：".$e->getMessage();
}
?>