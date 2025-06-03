<?php

namespace App\Core;

use PDO;

class Database {
    public static function connect(): PDO {
        return new PDO('mysql:host=localhost;dbname=web_final', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
