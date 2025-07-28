<?php

namespace App\Repository;
use App\Entity\User;
use App\Core\Abstract\AbstractRepository;

use PDO;

class UsersRepository extends AbstractRepository{
    private static UsersRepository|null $instance = null;

    public static function getInstance():UsersRepository{
        if(self::$instance == null){
            self::$instance = new UsersRepository();
        }
        return self::$instance;
    }

    public function __construct(){
        parent::__construct();
    }

    private string $table = 'users';

    public function selectAll(){}

     public function insert(array $userData){
        $sql = "INSERT INTO $this->table (nom, prenom,login, password, typeuserid, adresse, numerocni, photoidentite) values (:nom, :prenom, :login, :password, :typeuserid, :adresse, :numerocni, :photoidentite)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($userData);
        
        if($result){
            return $this->pdo->lastInsertId();
        }else{
            return false;
        }
     }

     public function selectByLoginAndPassword(string $login, string $passwors): null|User{
        $query = "SELECT * FROM $this->table WHERE login = :login AND password = :password";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'login' => $login,
            'password' => $passwors
        ]);
        $result = $stmt->fetch();
        if($result){
            return User::toObject($result);
        }
        return null;
        
    }

    public function selectByLogin(string $login): ?User {
    $query = "SELECT * FROM $this->table WHERE login = :login";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['login' => $login]);
    $result = $stmt->fetch();
    // var_dump(User::toObject($result));  
    return $result ? User::toObject($result) : null;
}



     public function update(){}
     public function delete(){}
     public function selectById($id){
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
     }
     public function selectBy(array $filter){}

}