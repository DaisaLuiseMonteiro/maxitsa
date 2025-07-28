<?php

namespace App\Repository;

use \PDO;
use App\Core\App;
use NumeroTelephone;
use App\Core\Abstract\AbstractRepository;

class TransactionRepository extends AbstractRepository{
    private string $table = 'transactions';

    private CompteRepository $compteRepository;
    private TelephoneRepository $telephoneRepository;

    private static TransactionRepository|null $instance = null;

    public function __construct(
        CompteRepository $compteRepository ,
        TelephoneRepository $telephoneRepository
    ){
        parent::__construct();
        $this->compteRepository = $compteRepository;
        $this->telephoneRepository = $telephoneRepository;
        // $this->compteRepository = App::getDependency('compteRepo');
        // $this->telephoneRepository = App::getDependency('telephoneRepo');
    }

    public static function getInstance():TransactionRepository{
        if(self::$instance == null){
            self::$instance = new TransactionRepository();
        }
        return self::$instance;
    }



      public function selectAll(){
        $query = "SELECT * FROM $this->table ";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll();
      }
     public function insert(array $data){
        $query = "INSERT INTO $this->table (datetransaction, typetransaction, montant, client_id, compte_id, status, libelle) VALUES (:datetransaction, :typetransaction, :montant, :client_id, :compte_id, :status, :libelle)";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute($data);
        return $result;
     }


private function verifierContraintesDepot($compteExpediteurId, $compteDestinataireId): bool {
    $compteExpediteur = $this->compteRepository->selectById($compteExpediteurId);
    $compteDestinataire = $this->compteRepository->selectById($compteDestinataireId);

    if (!$compteExpediteur || !$compteDestinataire) {
        return false;
    }

    return $compteExpediteur['typecompte'] === 'principal';
}


      public function getLastTransactions($compteId, $limit = 10): array {
        $query = "SELECT * FROM {$this->table} 
                  WHERE compte_id = :id_compte 
                  ORDER BY datetransaction DESC 
                  LIMIT :limit";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_compte', $compteId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
     public function update(){}
     public function delete(){}
     public function selectById($id){}
     public function selectBy(array $filter){}

     public function selectByClient(string $id_client){ 
        $sql = "SELECT * from $this->table where client_id = :id_client limit 10";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(['id_client' => $id_client]);
        if($result){
            return $stmt->fetchAll();
        }
        return [];
     }



 public function depotEntreComptes($compteExpediteurId, $compteDestinataireId, $montant, $libelle = 'Dépôt entre comptes') {
    error_log("Début depotEntreComptes - Exp: $compteExpediteurId, Dest: $compteDestinataireId, Montant: $montant");
    
    $this->pdo->beginTransaction();
    
    try {
        if (!$this->verifierContraintesDepot($compteExpediteurId, $compteDestinataireId)) {
            throw new \Exception("Dépôt non autorisé entre ces types de comptes");
        }

        $compteExpediteur = $this->compteRepository->selectById($compteExpediteurId);
        $compteDestinataire = $this->compteRepository->selectById($compteDestinataireId);
        
        $frais = $this->calculerFraisTransfert($compteExpediteur['typecompte'], $compteDestinataire['typecompte'], $montant);
        $montantTotal = $montant + $frais;
        
        if (!$compteExpediteur || $compteExpediteur['solde'] < $montantTotal) {
            $message = $frais > 0 ? 
                "Solde insuffisant. Montant requis: " . number_format($montantTotal, 0, ',', ' ') . " FCFA (dont " . number_format($frais, 0, ',', ' ') . " FCFA de frais)" :
                "Solde insuffisant";
            throw new \Exception($message);
        }

        $nouveauSoldeExpediteur = $compteExpediteur['solde'] - $montantTotal;
        $this->compteRepository->updateSolde($compteExpediteurId, $nouveauSoldeExpediteur);

        $nouveauSoldeDestinataire = $compteDestinataire['solde'] + $montant;
        $this->compteRepository->updateSolde($compteDestinataireId, $nouveauSoldeDestinataire);

        $userIdExp = $this->telephoneRepository->findUserIdByCompteId($compteExpediteurId);
        $userIdDest = $this->telephoneRepository->findUserIdByCompteId($compteDestinataireId);
        
        if (!$userIdExp || !$userIdDest) {
            throw new \Exception("Impossible de trouver les utilisateurs associés aux comptes");
        }

        $insertExp = $this->insert([
            'datetransaction' => date('Y-m-d H:i:s'),
            'typetransaction' => 'depot',
            'montant' => $montant,
            'client_id' => $userIdExp,
            'compte_id' => $compteExpediteurId,
            'status' => 'false',
            'libelle' => $libelle . ' - Envoyé'
        ]);

        $insertDest = $this->insert([
            'datetransaction' => date('Y-m-d H:i:s'),
            'typetransaction' => 'depot',
            'montant' => $montant,
            'client_id' => $userIdDest,
            'compte_id' => $compteDestinataireId,
            'status' => 'false',
            'libelle' => $libelle . ' - Reçu'
        ]);

        if ($frais > 0) {
            $this->insert([
                'datetransaction' => date('Y-m-d H:i:s'),
                'typetransaction' => 'frais_transfert',
                'montant' => $frais,
                'client_id' => $userIdExp,
                'compte_id' => $compteExpediteurId,
                'status' => 'false',
                'libelle' => 'Frais de transfert entre comptes principaux'
            ]);
        }

        $this->pdo->commit();
        return [
            'success' => true,
            'montant_transfere' => $montant,
            'frais' => $frais,
            'montant_total' => $montantTotal
        ];

    } catch (\Exception $e) {
        $this->pdo->rollBack();
        throw $e;
    }
}

private function calculerFraisTransfert($typeExpediteur, $typeDestinataire, $montant): float {
    if ($typeExpediteur === 'principal' && $typeDestinataire === 'principal') {
        $frais = $montant * 0.08; 
        return min($frais, 5000); 
    }
    
    return 0;
}

public function searchByFilters($userId, $dateFilter = null, $typeFilter = null): array {
    $query = "SELECT * FROM {$this->table} WHERE client_id = :client_id";
    $params = ['client_id' => $userId];
    
    if (!empty($dateFilter)) {
        $query .= " AND DATE(datetransaction) = :date_filter";
        $params['date_filter'] = $dateFilter;
    }
    
    if (!empty($typeFilter)) {
        $query .= " AND typetransaction ILIKE :type_filter";
        $params['type_filter'] = '%' . $typeFilter . '%';
    }
    
    $query .= " ORDER BY datetransaction DESC";
    
    $stmt = $this->pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

public function getTransactionTypes($userId): array {
    $query = "SELECT DISTINCT typetransaction FROM {$this->table} WHERE client_id = :client_id ORDER BY typetransaction";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['client_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function getTransactionsByUserId($userId): array {
    $query = "SELECT * FROM {$this->table} WHERE client_id = :client_id ORDER BY datetransaction DESC";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['client_id' => $userId]);
    return $stmt->fetchAll();
}


public function annulerTransaction($transactionId, $userId): bool {
    $this->pdo->beginTransaction();
    
    try {
        // Récupérer la transaction à annuler
        $transaction = $this->getTransactionForCancellation($transactionId, $userId);
        
        if (!$transaction) {
            throw new \Exception("Transaction non trouvée ou non autorisée");
        }
        
        // Vérifier si la transaction peut être annulée
        if (!$this->peutEtreAnnulee($transaction)) {
            throw new \Exception("Cette transaction ne peut pas être annulée");
        }
        
        // Simplement marquer comme annulée
        $this->marquerCommeAnnulee($transactionId);
        
        $this->pdo->commit();
        return true;
        
    } catch (\Exception $e) {
        $this->pdo->rollBack();
        throw $e;
    }
}

public function getTransactionForCancellation($transactionId, $userId): ?array {
    $query = "SELECT * FROM {$this->table} 
              WHERE id = :id AND client_id = :client_id";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([
        'id' => $transactionId,
        'client_id' => $userId
    ]);
    return $stmt->fetch() ?: null;
}

private function peutEtreAnnulee($transaction): bool {
    // Vérifier si c'est un dépôt
    if (!in_array($transaction['typetransaction'], ['depot', 'depot_entrant', 'depot_sortant'])) {
        return false;
    }
    
    // Vérifier si le status permet l'annulation
    if ($transaction['status'] === true || $transaction['status'] === 't' || $transaction['status'] === 'annulee') {
        return false;
    }
    
    // Vérifier si la transaction n'est pas trop ancienne (24h)
    $dateTransaction = new \DateTime($transaction['datetransaction']);
    $maintenant = new \DateTime();
    $diff = $maintenant->diff($dateTransaction);
    
    if ($diff->days >= 1) {
        return false;
    }
    
    return true;
}

private function marquerCommeAnnulee($transactionId): bool {
    $query = "UPDATE {$this->table} SET status = 'annulee' WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    return $stmt->execute(['id' => $transactionId]);
}



}