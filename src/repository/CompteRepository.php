<?php

namespace App\Repository;
use App\Core\Abstract\AbstractRepository;

class CompteRepository extends AbstractRepository{

    private string $table = 'compte';

    // private static CompteRepository|null $instance = null;

    // public static function getInstance():CompteRepository{
    //     if(self::$instance == null){
    //         self::$instance = new CompteRepository();
    //     }
    //     return self::$instance;
    // }

    public function __construct(){
        parent::__construct();
    }

     public function selectAll(){
        $sql = "select * , compte.numero as numerocompte , nt.numero as telephone from $this->table  join numeroTelephone nt on nt.compte_id = compte.id join users u on nt.user_id = u.id where compte.id in (select compte_id from numeroTelephone )";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        if($result){
            return $stmt->fetchAll();
        }
        return null;
     }
   

     public function insert(array $data): bool|int {
    $query = "INSERT INTO compte (numero, typeCompte, solde, dateCreation, id_user) 
              VALUES (:numero, :typeCompte, :solde, :dateCreation, :id_user)";
    $stmt = $this->pdo->prepare($query);
    if ($stmt->execute($data)) {
        return $this->pdo->lastInsertId();      
    }
    return false;
    }

    public function insertComptePrincipal():?string{
        $query = "INSERT INTO $this->table (numero,datecreation,solde, typecompte) 
              VALUES (:numero, :dateCreation, :solde, :typeCompte)";
    $stmt = $this->pdo->prepare($query);

    $genererNum = "CPT" . rand(1000000000, 9999999999);
    if ($stmt->execute([
        'numero' => $genererNum,
        'dateCreation' => date('Y-m-d'),
        'solde' => 50000,
        'typeCompte' => 'principal'
    ])) {
        return $this->pdo->lastInsertId();      
    }
    return null;
    }

    public function insertSecondaire($solde){
        $query = "INSERT INTO $this->table (numero,datecreation,solde, typecompte) 
              VALUES (:numero, :dateCreation, :solde, :typeCompte)";
    $stmt = $this->pdo->prepare($query);

    $genererNum = "CPT" . rand(1000000000, 9999999999);
    if ($stmt->execute([
        'numero' => $genererNum,
        'dateCreation' => date('Y-m-d'),
        'solde' => $solde ?? 0,
        'typeCompte' => 'secondaire'
    ])) {
        
        return $this->pdo->lastInsertId();      
    }
    return null;
    }


    public function findPrincipalByUserId($userId): ?array {
    $sql = "select * , compte.numero as numerocompte , nt.numero as telephone from $this->table  join numeroTelephone nt on nt.compte_id = compte.id join users u on nt.user_id = u.id where compte.id in (select compte_id from numeroTelephone where user_id = :user_id ) and compte.typecompte = 'principal' ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetch() ?: null;
    }

    


   
    

     public function selectByClient($user_id){
        $sql = "select * , compte.numero as numerocompte , nt.numero as telephone from $this->table  join numeroTelephone nt on nt.compte_id = compte.id join users u on nt.user_id = u.id where compte.id in (select compte_id from numeroTelephone where user_id = :user_id  )";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(['user_id' => $user_id]);
        if($result){
            return $stmt->fetchAll();
        }
        return null;
     }

    


    public function updateSolde($compteId, $newSolde): bool {
        $query = "UPDATE {$this->table} SET solde = :solde WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        
        $result = $stmt->execute([
            'solde' => $newSolde,
            'id' => $compteId
        ]);
        $rowsAffected = $stmt->rowCount();
        return $result && $rowsAffected > 0;
    }



public function selectSecondaireCompte($user_id): array {
    $sql = "SELECT * ,c.numero as numerocompte, t.numero as telephone FROM {$this->table} c 
            LEFT JOIN numeroTelephone t ON c.id = t.compte_id 
            WHERE t.user_id = :user_id AND c.typecompte = 'secondaire'";
    $stmt = $this->pdo->prepare($sql);
    $result = $stmt->execute(['user_id' => $user_id]);
    if($result){
        return $stmt->fetchAll();
    }
    return [];
}


public function selectById($id): array|null {
    $sql = "SELECT * FROM {$this->table} WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
}



public function findById($id) {
    $query = "SELECT * FROM {$this->table} WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

public function verifierProprietaire($compteId, $userId) {
    $query = "SELECT COUNT(*) as count FROM numeroTelephone nt 
              WHERE nt.compte_id = :compte_id AND nt.user_id = :user_id";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['compte_id' => $compteId, 'user_id' => $userId]);
    $result = $stmt->fetch();
    return $result['count'] > 0;
}

public function updateTypeCompte($ancienPrincipalId, $nouveauPrincipalId): bool {
    try {
        $this->pdo->beginTransaction();
        
        
        $checkQuery = "SELECT user_id FROM numeroTelephone WHERE compte_id IN (:ancien, :nouveau)";
        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->execute(['ancien' => $ancienPrincipalId, 'nouveau' => $nouveauPrincipalId]);
        $users = $checkStmt->fetchAll();
        
        error_log("Users trouvés: " . json_encode($users));
        
        if (count($users) !== 2 || $users[0]['user_id'] !== $users[1]['user_id']) {
            throw new \Exception("Les comptes ne sont pas valides ou n'appartiennent pas au même utilisateur");
        }
        
        $query1 = "UPDATE {$this->table} SET typecompte = 'secondaire' WHERE id = :id";
        $stmt1 = $this->pdo->prepare($query1);
        $result1 = $stmt1->execute(['id' => $ancienPrincipalId]);
        
        error_log("Résultat update ancien: " . ($result1 ? 'success' : 'failed'));
        
        $query2 = "UPDATE {$this->table} SET typecompte = 'principal' WHERE id = :id";
        $stmt2 = $this->pdo->prepare($query2);
        $result2 = $stmt2->execute(['id' => $nouveauPrincipalId]);
        
        error_log("Résultat update nouveau: " . ($result2 ? 'success' : 'failed'));
        
        if ($result1 && $result2) {
            $this->pdo->commit();
            error_log("Transaction committée avec succès");
            return true;
        } else {
            $this->pdo->rollBack();
            error_log("Rollback de la transaction");
            return false;
        }
    } catch (Exception $e) {
        $this->pdo->rollBack();
        error_log("Erreur dans updateTypeCompte: " . $e->getMessage());
        throw $e;
    }
}

}


