<?php
class DB {
    private static function connect() {
        $pdo = new PDO('mysql:host127.0.0.1;dbname=camagru;charset=utf8', 'root', '123456');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
        
    }

    public static function query($query, $params = array()) {
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);
        // $data = $statement->fetchAll();
        // return $data;
    }
}