<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private UserRepository $user_repository;

    public function __construct()
    {
        $this->user_repository = new UserRepository();
    }

    function se_connecter(string $login, string $password): ?User
    {
        return $this->user_repository->selectByLoginAndPassword($login, $password);
    }
}
