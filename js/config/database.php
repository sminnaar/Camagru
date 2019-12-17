<?php

    // $DB_DSN = 'mysql:hostname=127.0.0.1;dbname=camagru;unix_socket=/opt/lampp/var/mysql/mysql.sock';
    $DB_DSN = 'mysql:hostname=127.0.0.1;dbname=camagru';
    $DB_USER = 'root';
    // $DB_PASSWORD = '';
    $DB_PASSWORD = '1234567';

require_once("tables.php");

try {
    $pdo = new PDO('mysql:hostname=127.0.0.1', $DB_USER, $DB_PASSWORD);

    $db = $pdo->prepare($drop_database);
    $db->execute();
    $db = $pdo->prepare($create_database);
    $db->execute();

    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    echo 'Connection to database failed: ' . $e->getMessage();
}