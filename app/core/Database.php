<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private PDO $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(DSN,DB_USER,DB_PASSWORD);
        } catch (PDOException $pdoException) {
            echo 'error => '.$pdoException;
        }
    }

    public function getConnexion() : PDO {
        return $this->pdo;
    }
}
