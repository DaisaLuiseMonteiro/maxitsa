<?php

namespace App\Controller;

use App\Core\App;
use App\Core\Session;
use App\Service\CompteService;
use App\Service\TransactionService;
use App\Core\Abstract\AbstractController;

class TransactionController extends AbstractController{

    private TransactionService $transactionService;
    private CompteService $compteService;
    public function __construct(

        Session $session,
        TransactionService $transactionService,
        CompteService $compteService
    ){
        parent::__construct(

            $this->session = $session
        );
    
        $this->transactionService = $transactionService;
        $this->compteService = $compteService;

    }
  
    public function create(){
        $comptesClient = $this->compteService->comptesClient($this->session->get('user', 'id'));
        $allComptes = $this->compteService->allComptes();
        $this->render('transaction/form.php', [
            'comptesClient' => $comptesClient,
            'allComptes' => $allComptes,
        ]);
    }



public function store(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $data = $_POST;
            
            $compteExpediteurId = (int) $data['compte_expediteur_id'];
            $compteDestinataireId = (int) $data['compte_destinataire_id'];
            $montant = (float) $data['montant'];
            $libelle = $data['libelle'] ?? 'depot compte';

            if ($compteExpediteurId <= 0) {
                throw new \Exception("Compte expéditeur invalide");
            }
            
            if ($compteDestinataireId <= 0) {
                throw new \Exception("Compte destinataire invalide");
            }
            
            if ($montant <= 0) {
                throw new \Exception("Le montant doit être supérieur à 0");
            }
            
            if ($compteExpediteurId === $compteDestinataireId) {
                throw new \Exception("Les comptes expéditeur et destinataire doivent être différents");
            }

            $result = $this->transactionService->depotTransaction(
                $compteExpediteurId,
                $compteDestinataireId,
                $montant,
                $libelle
            );

            if ($result['success']) {
                $data = $result['data'];
                $message = "Transfert de " . number_format($data['montant_transfere'], 0, ',', ' ') . " FCFA effectué avec succès";
                
                if ($data['frais'] > 0) {
                    $message .= " (Frais: " . number_format($data['frais'], 0, ',', ' ') . " FCFA)";
                }
                
                $_SESSION['success_message'] = $message;
                header('Location: /listTransactions');
                exit;
            } else {
                throw new \Exception($result['message']);
            }

        } catch (\Exception $e) {
            error_log("Erreur transaction: " . $e->getMessage());
            $this->session->set('error_message', $e->getMessage());
            $this->session->set('form_data', $data ?? []);
        }
    }
    
    header('Location: /transactionForm');
    exit;
}

public function calculerFrais() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $compteExpediteurId = (int) ($_POST['compte_expediteur_id'] ?? 0);
        $compteDestinataireId = (int) ($_POST['compte_destinataire_id'] ?? 0);
        $montant = (float) ($_POST['montant'] ?? 0);
        
        $preview = $this->transactionService->calculerFraisPreview($compteExpediteurId, $compteDestinataireId, $montant);
        
        header('Content-Type: application/json');
        echo json_encode($preview);
        exit;
    }
}



public function edit(){
    }
    public function show(){
    }
      public function buy(){
    }

    public function index() {
    try {
        $userId = $this->session->get('user', 'id');
        
        if (!$userId) {
            throw new \Exception("Utilisateur non connecté");
        }
        
        $dateFilter = !empty($_POST['date_filter']) ? $_POST['date_filter'] : null;
        $typeFilter = !empty($_POST['type_filter']) ? $_POST['type_filter'] : null;
        
        
        $transactions = $this->transactionService->rechercherTransactions($userId, $dateFilter, $typeFilter);
        
        $typesDisponibles = $this->transactionService->getTypesTransactionDisponibles($userId);
        
        
        $this->render('transaction/index.php', [
            'transactions' => $transactions,
            'typesDisponibles' => $typesDisponibles,
            'dateFilter' => $dateFilter,
            'typeFilter' => $typeFilter
        ]);
        
    } catch (\Exception $e) {
        error_log("Erreur TransactionController::index: " . $e->getMessage());
        echo "Erreur: " . $e->getMessage(); 
        exit;
    }
}



private function isValidDate($date): bool {
    $d = \DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

public function annuler() {
    try {
        $transactionId = (int) ($_GET['id'] ?? 0);
        $userId = $this->session->get('user', 'id');
        
        if ($transactionId <= 0) {
            $this->session->set('error_message','Id introuvable');    
            header('Location: /listTransactions');
            exit;
        }
        
        if (!$userId) {
            $this->session->set('error_message','message');
            header('Location: /listTransactions');
            exit;
        }
        
        $result = $this->transactionService->annulerTransaction($transactionId, $userId);
        
        if ($result['success']) {
            $this->session->set('success_message','message');
        } else {
            $this->session->set('error_message','message');
        }
        
    } catch (\Exception $e) {
        error_log("Erreur annulation transaction: " . $e->getMessage());
        $_SESSION['error_message'] = "Erreur: " . $e->getMessage();
    }
    
    header('Location: /listTransactions');
    exit;
}


}