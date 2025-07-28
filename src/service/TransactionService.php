<?php

namespace App\Service;

use App\Core\App;
use App\Repository\CompteRepository;
use App\Repository\TransactionRepository;
use App\Core\Singleton;

class TransactionService extends Singleton{

    private TransactionRepository $transactionRepository;
    private CompteRepository $compteRepository;


    public function __construct(
        TransactionRepository $transactionRepository,
        CompteRepository $compteRepository
    ){

        $this->transactionRepository = $transactionRepository;
        $this->compteRepository = $compteRepository;
        // $this->transactionRepository = App::getDependency('transactionRepo');
        // $this->compteRepository = App::getDependency('compteRepo');
        
        

    }

    public function getTransactionByClient($client_id){
        return $this->transactionRepository->selectByClient($client_id);
    }

//   public function depotTransaction($compteExpediteurId, $compteDestinataireId, $montant, $libelle){
//     try {
//         return $this->transactionRepository->depotEntreComptes($compteExpediteurId, $compteDestinataireId, $montant, $libelle);
//     } catch (\Exception $e) {
//         error_log("Erreur dans depotTransaction: " . $e->getMessage());
//         throw $e; // Relancer l'exception
//     }
// }

public function depotTransaction($compteExpediteurId, $compteDestinataireId, $montant, $libelle){
    try {
        $result = $this->transactionRepository->depotEntreComptes($compteExpediteurId, $compteDestinataireId, $montant, $libelle);
        
        if ($result['success']) {
            return [
                'success' => true,
                'data' => $result
            ];
        }
        
        return ['success' => false, 'message' => 'Erreur lors du transfert'];
        
    } catch (\Exception $e) {
        error_log("Erreur dans depotTransaction: " . $e->getMessage());
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

public function calculerFraisPreview($compteExpediteurId, $compteDestinataireId, $montant): array {
    try {
        $compteExpediteur = $this->compteRepository->selectById($compteExpediteurId);
        $compteDestinataire = $this->compteRepository->selectById($compteDestinataireId);
        
        if (!$compteExpediteur || !$compteDestinataire) {
            throw new \Exception("Comptes introuvables");
        }
        
        $frais = 0;
        if ($compteExpediteur['typecompte'] === 'principal' && $compteDestinataire['typecompte'] === 'principal') {
            $frais = min($montant * 0.08, 5000);
        }
        
        return [
            'montant' => $montant,
            'frais' => $frais,
            'total' => $montant + $frais,
            'type_transfert' => $compteExpediteur['typecompte'] . '_vers_' . $compteDestinataire['typecompte']
        ];
        
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage()
        ];
    }
}

public function rechercherTransactions($userId, $dateFilter = null, $typeFilter = null): array {
    try {
        if (empty($dateFilter) && empty($typeFilter)) {
            return $this->transactionRepository->getTransactionsByUserId($userId);
        }
        
        return $this->transactionRepository->searchByFilters($userId, $dateFilter, $typeFilter);
        
    } catch (\Exception $e) {
        error_log("Erreur recherche transactions: " . $e->getMessage());
        return [];
    }
}

public function getTypesTransactionDisponibles($userId): array {
    try {
        return $this->transactionRepository->getTransactionTypes($userId);
    } catch (\Exception $e) {
        error_log("Erreur récupération types: " . $e->getMessage());
        return [];
    }
}

public function getTransactionsUtilisateur($userId): array {
    try {
        return $this->transactionRepository->getTransactionsByUserId($userId);
    } catch (\Exception $e) {
        error_log("Erreur récupération transactions: " . $e->getMessage());
        return [];
    }
}

public function annulerTransaction($transactionId, $userId): array {
    try {
        // Vérifier que l'utilisateur est propriétaire de la transaction
        $transaction = $this->transactionRepository->getTransactionForCancellation($transactionId, $userId);
        
        if (!$transaction) {
            return [
                'success' => false,
                'message' => 'Transaction non trouvée ou vous n\'êtes pas autorisé à l\'annuler'
            ];
        }
        
        // Effectuer l'annulation (juste changer le statut)
        $result = $this->transactionRepository->annulerTransaction($transactionId, $userId);
        
        if ($result) {
            return [
                'success' => true,
                'message' => 'Transaction annulée avec succès'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Erreur lors de l\'annulation de la transaction'
        ];
        
    } catch (\Exception $e) {
        error_log("Erreur annulation transaction: " . $e->getMessage());
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}



}