<?php

class Database {
    private static $pdo;

    // Método para obtener la conexión a la base de datos utilizando PDO
    public static function getConnection() {
        if (!isset(self::$pdo)) {
            $dsn = 'mysql:host=localhost;dbname=terpel';
            $username = 'root';
            $password = 'root';

            self::$pdo = new PDO($dsn, $username, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
}


