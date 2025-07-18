<?php

namespace App\Repository;

use App\Core\Database;
use App\Entity\User;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnexion();
    }

    public function selectByLoginAndPassword(string $login, string $password): ?User
    {
        $query = "SELECT * FROM users WHERE login = :login AND password = :password ";

        $stmt = $this->pdo->prepare($query);

        $stmt->execute([
            'login' => $login,
            'password' => $password
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            return null;
        }

        return User::toObject($result);
    }
}
