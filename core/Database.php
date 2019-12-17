<?php

class Database {

  // public static $DB_DSN = 'mysql:hostname=127.0.0.1;dbname=camagru;unix_socket=/opt/lampp/var/mysql/mysql.sock';
  public static $DB_DSN = 'mysql:hostname=127.0.0.1;dbname=camagru';
  public static $DB_USER = 'root';
  // public static $DB_PASSWORD = '';
  public static $DB_PASSWORD = '1234567';

  private static function connect() {
    $pdo = new PDO(self::$DB_DSN, self::$DB_USER, self::$DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }

  public static function query($query, $params = array()) {
    $stmt = self::connect()->prepare($query);
    $stmt->execute($params);
    if (explode(' ', $query)[0] == 'SELECT') {
      $data = $stmt->fetchAll();
      return $data;
    }
  }
}
