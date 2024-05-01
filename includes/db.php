<?php

class Database
{
    private static $pdo;

    // Método para obtener la conexión a la base de datos utilizando PDO
    public static function getConnection()
    {
        try {
            if (!isset(self::$pdo)) {
                $dsn = 'mysql:host=monorail.proxy.rlwy.net;port=36225;dbname=railway';
                $username = 'root';
                $password = 'xCPZHKtQijuNOvSwXNYUSTYBHiuJpCQO';

                self::$pdo = new PDO($dsn, $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$pdo;
        } catch (\Throwable $th) {
            return json_encode(['error' => $th->getMessage()]);
        }
    }
}
