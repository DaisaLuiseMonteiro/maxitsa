<?php
namespace App\Repository;

use App\Core\App;
use AppendIterator;
use App\Repository\UsersRepository;
use App\Repository\CompteRepository;
use App\Core\Abstract\AbstractRepository;

class TelephoneRepository extends AbstractRepository{

    private string $table = 'numeroTelephone';

    private UsersRepository  $usersRepository;
    private CompteRepository $compteRepository;

    private static TelephoneRepository|null $instance = null;

    public static function getInstance():TelephoneRepository{
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(
        UsersRepository $usersRepository ,
        CompteRepository $compteRepository 
   ){
        parent::__construct();
        $this->usersRepository = $usersRepository;
        $this->compteRepository = $compteRepository;

        // $this->usersRepository = App::getDependency('usersRepo');
        // $this->compteRepository = App::getDependency('compteRepo');
    }

    public function selectAll(){}

    public function insert(array $data): bool {
        $query = "INSERT INTO {$this->table} (numero, user_id, compte_id)
                  VALUES (:numero, :user_id, :compte_id)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }
    

     public function update(){}
     public function delete(){}
     public function selectById($id){}
     public function selectBy(array $filter){}

     public function insertPrincipale($user, $tel){
        $this->pdo->beginTransaction();
        try{
            $user_id = $this->usersRepository->insert($user);
            $compte_id = $this->compteRepository->insertComptePrincipal();

            $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (numero, user_id, compte_id) VALUES (:numero, :user_id, :compte_id)");
            $stmt->execute(['numero' => $tel, 'user_id' => $user_id, 'compte_id' => $compte_id]);

            $this->pdo->commit();
            return true;

        }catch (\Exception $e) {
        $this->pdo->rollBack();
        return "Erreur : " . $e->getMessage();
    }
     }

     


     public function insertSecondaire($user_id, $tel, $solde){
        $this->pdo->beginTransaction();
        try{
            $compte_id = $this->compteRepository->insertSecondaire($solde);
            $sql = "INSERT INTO {$this->table} (numero, user_id, compte_id) VALUES (:numero, :user_id, :compte_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['numero' => $tel, 'user_id' => $user_id, 'compte_id' => $compte_id]);
            $comptePrincipal = $this->compteRepository->findPrincipalByUserId($user_id);
            $soldePrincipal = $comptePrincipal['solde'];
            var_dump($comptePrincipal);

            if($solde > 0 && $solde < $soldePrincipal){
                $newSolde = $soldePrincipal - $solde;
                $this->compteRepository->updateSolde($comptePrincipal['compte_id'], $newSolde);
                var_dump($soldePrincipal);
                $this->pdo->commit();
                return true;
            }else{
                throw new \Exception("Solde insuffisant");
            }

            

        }catch (\Exception $e) {
        $this->pdo->rollBack();
        return "Erreur : " . $e->getMessage();
    }
     }

        public function findByNumero($numero): ?array {
        $query = "SELECT nt.*, c.*, u.nom, u.prenom FROM {$this->table} nt
                  JOIN compte c ON nt.compte_id = c.id
                  JOIN users u ON nt.user_id = u.id
                  WHERE nt.numero = :numero";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['numero' => $numero]);
        return $stmt->fetch() ?: null;
    }

    public function findByUserId($userId): array {
        $query = "SELECT nt.*, c.numero as numero_compte, c.typecompte, c.solde, c.datecreation
                  FROM {$this->table} nt
                  JOIN comptes c ON nt.compte_id = c.id
                  WHERE nt.user_id = :id_user
                  ORDER BY c.typecompte DESC, c.datecreation ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_user' => $userId]);
        return $stmt->fetchAll();
    }

    public function findUserIdByCompteId($compteId): int {
    $query = "SELECT user_id FROM numeroTelephone WHERE compte_id = :compte_id";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['compte_id' => $compteId]);
    $result = $stmt->fetch();
    return $result ? $result['user_id'] : 0;
}

    public function findByCompteId($compteId): ?array {
        $query = "SELECT * FROM {$this->table} WHERE compte_id = :id_compte";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_compte' => $compteId]);
        return $stmt->fetch() ?: null;
    }

}