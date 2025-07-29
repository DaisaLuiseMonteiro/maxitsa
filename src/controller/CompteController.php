<?php

namespace App\Controller;
use App\Core\App;
use App\Core\Session;
use App\Core\Validator;
use App\Core\ImageService;
use App\Service\CompteService;
use App\Service\TwilioService;
use App\Service\SecurityService;
use App\Service\TransactionService;
use App\Core\Abstract\AbstractController;

class CompteController extends AbstractController{
    private Validator $validator;
    private SecurityService $securityService;
    private ImageService $imageService;
    private CompteService $compteService;
    private TransactionService $transactionService;
    

    public function __construct(
        Session $session,
        Validator $validator, 
        SecurityService $serviceService,
        ImageService $imageService, 
        CompteService $compteService,
        TransactionService $transactionService
    ){
           parent::__construct( 
            $this->session = $session
           );
          $this->validator = $validator;
          $this->securityService = $serviceService;
          $this->imageService = $imageService;
          $this->compteService = $compteService;
          $this->transactionService = $transactionService;
    }


     public function index(){
        $comptes = $this->compteService->comptePrincipalClient($this->session->get('user', 'id'));
        $this->session->set('comptes', $comptes);
        $transactions = $this->transactionService->getTransactionByClient($this->session->get('user', 'id'));
        $this->render('compte/home.php', [
            'transactions' => $transactions,
            'comptes' => $comptes, ]);
     }
     public function create(){
    //    $citoyens = $this->fetchAPI('https://appdafapi.onrender.com/api/citoyens');
        $this->layout = 'security';
        $this->render('compte/form.principal.php');
     }
     public function store(){
          $comptes = $this->compteService->comptePrincipalClient($this->session->get('user', 'id'));
        $this->render('compte/form.secondaire.php', [
            'comptes' => $comptes, ]);
     }
     public function edit(){}
     
     public function show(){
        $comptes = $this->compteService->comptesSecondairesClient($this->session->get('user', 'id'));
        $this->render('compte/liste.compte.php', [
            'comptes' => $comptes]);
     }
        public function buy(){
        // $comptes = $this->compteService->comptesSecondairesClient($this->session->get('user','id'));
        // $this->render('woyofal.php', [
        //     'comptes' => $comptes]);
     }

     private function validateForm(array &$data): array {
      require_once __DIR__ . "/../../app/config/rules.php";
      $this->validator->validate($data, $rules);
      return $this->validator->getErrors();
}

private function buildUserData(array $data, string $photoPath): array {
    return [
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'login' => $data['login'],
        'password' => $data['password'],
        'adresse' => $data['adresse'],
        'numeroCNI' => $data['numeroCNI'],
        'photoIdentite' => $photoPath,
        'type_user_id' => 3
    ];
}
public function createCompteSecondaire() { 
    require_once __DIR__ . "/../../app/config/rules.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $this->session->unset('errors');
            $data = $_POST;
            $errors = $this->validator->validate($data, $rules);
            if ($errors) {
                $this->session->set('errors', $errors);
                header("Location: " . APP_URL . "/compteSecondaire");
                exit;
            }

            $userId = $this->session->get('user', 'id');
            if (!$userId) {
                $this->session->set('errors', ['general' => 'Utilisateur non connecté']);
                header("Location: " . APP_URL . "/compteSecondaire");
                exit;
            }
            $numeroTel = trim($data['telephone']);
            $soldeInitial = isset($data['solde']) && $data['solde'] !== '' ? (float)$data['solde'] : 0;

            $result = $this->compteService->creerCompteSecondaire($userId, $numeroTel, $soldeInitial);
            if ($result) {
                $this->session->set('success', 'Compte secondaire créé avec succès !');
                header("Location: " . APP_URL . "/compte");
                exit;
            } else {
                $this->session->set('errors', ['general' => $result]);
                header("Location: " . APP_URL . "/compteSecondaire");
                exit;
            }
        } catch (\Exception $e) {
            $this->session->set('errors', ['general' => 'Erreur interne: ' . $e->getMessage()]);
            header("Location: " . APP_URL . "/compteSecondaire");
            exit;
        }
    }
    header("Location: " . APP_URL . "/compteSecondaire");
    exit;
}

public function changerTypeCompte() {
    
    try {
        $newCompteId = $_REQUEST['compte_id'] ?? null;
        $userId = $this->session->get('user', 'id');
        $ancienComptePrincipal = $this->compteService->comptePrincipalClient($userId);        
        $oldCompteId = $ancienComptePrincipal['compte_id'];        

        $result = $this->compteService->changerTypeCompte($oldCompteId, $newCompteId);
        
        if ($result) {
            $this->session->set('success', "Type de compte changé avec succès");
        } else {
            $this->session->set('error', "Erreur lors du changement de type de compte");
        }
    } catch (\Exception $e) {
        $this->session->set('error', "Erreur système: " . $e->getMessage());
    }

    header('Location: /listComptes');
    exit;
}



}