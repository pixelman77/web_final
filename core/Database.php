<?php

namespace App\Core;

use PDO;

class Database {
    public static function connect(): PDO {
        return new PDO('mysql:host=127.0.0.1;port=3306;dbname=web_final', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
