<?php
namespace App\Service;
use app\core\Singleton;
use App\Repository\CompteRepository;
use App\Repository\TelephoneRepository;
use App\Repository\TransactionRepository;
use App\Repository\UsersRepository;
use App\Core\App;
use \PDO;
use \Exception;

class CompteService extends Singleton{
    private CompteRepository $compteRepository;
    private UsersRepository $userRepository;

    private PDO $pdo;

    private TelephoneRepository $telephoneRepository;
    private TransactionRepository $transactionRepository;

    

    public function __construct(
        CompteRepository $compteRepository,
        UsersRepository $userRepository,
        TelephoneRepository $telephoneRepository,
        TransactionRepository $transactionRepository,

    ){
        $this->compteRepository = $compteRepository;
        $this->userRepository = $userRepository;
        $this->telephoneRepository = $telephoneRepository;
        $this->transactionRepository = $transactionRepository;
    

    }
     
    public function creerCompteSecondaire($user_id, $tel, $solde){
        $user = $this->userRepository->selectById($user_id);
        if (!$user) {
            return "Utilisateur non trouvé.";
        }
        $existingNumero = $this->telephoneRepository->findByNumero($tel);
        if ($existingNumero) {
            return "Ce numéro de téléphone est déjà associé à un compte.";
        }
        $comptePrincipal = $this->compteRepository->findPrincipalByUserId($user_id);
        if (!$comptePrincipal) {
            return "Vous devez d'abord créer un compte principal.";
        }

        return $this->telephoneRepository->insertSecondaire($user_id, $tel, $solde);
        
    }

    public function comptePrincipalClient($user_id){
        return $this->compteRepository->findPrincipalByUserId($user_id);
    }

    public function comptesClient($user_id){
        return $this->compteRepository->selectByClient($user_id);
    }

    public function comptesSecondairesClient($user_id){
        return $this->compteRepository->selectSecondaireCompte($user_id);
    }

    public function allComptes(){
        return $this->compteRepository->selectAll();
    }
    

    public function getComptesByUserId($userId): array {
        return $this->telephoneRepository->findByUserId($userId);
    }

    public function rechercherCompteParNumero($numeroTelephone): ?array {
        return $this->telephoneRepository->findByNumero($numeroTelephone);
    }

    
 public function getCompteById($compteId) {
    return $this->compteRepository->findById($compteId);
}

public function verifierProprietaireCompte($compteId, $userId) {
    return $this->compteRepository->verifierProprietaire($compteId, $userId);
}

public function changerTypeCompte($oldCompteId, $newCompteId) {
    try {
        return $this->compteRepository->updateTypeCompte($oldCompteId, $newCompteId);
    } catch (Exception $e) {
        throw $e;
    }
}
    







}