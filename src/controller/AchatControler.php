<?php

namespace App\Controller;

use App\Core\App;
use App\Core\Session;
use App\Core\Validator;
use App\Service\TwilioService;
use App\Service\SecurityService;
use App\Core\Abstract\AbstractController;




class AchatControler extends AbstractController
{

    private SecurityService $securityService;
    private Validator $validator;


    public function __construct(
        Session $session,
        SecurityService $securityService,
        Validator $validator
    ) {
        parent::__construct(
            $this->session = $session
        );
        $this->layout = 'blanc';
        $this->securityService =   $securityService;
        $this->validator = $validator;
    }
    public function index() {}

    public function show() {}
    public function create() {}

    public function store() {}

    public function edit() {}
    public function login() {}

    public function logout() {}
    public function buy()
    {
        require_once __DIR__ . '/../../templates/compte/woyofal.php';
    }

    private function validateForm(array &$data): array
    {
        require_once "../app/config/rules.php";
        $this->validator->validate($data, $rules);
        return $this->validator->getErrors();
    }



    private function buildUserData(array $data, string $photoPath): array
    {
        return [
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'login' => $data['login'],
            'password' => $data['password'],
            'adresse' => $data['adresse'],
            'numerocni' => $data['numeroCNI'],
            'photoidentite' => $photoPath,
            'typeuserid' => 1
        ];
    }




    public function createComptePrincipal()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $numeroTelephone = $data['telephone'];
            $errors = $this->validateForm($data);
            $this->session->set('errors', []);



            if (empty($errors)) {
                $photoPath = $this->uploadPhotos($_FILES);
                if (!$photoPath) {
                    $this->session->set('errors', ['photoIdentite' => "Erreur lors de l'envoi des photos."]);
                } else {
                    $userData = $this->buildUserData($data, $photoPath);
                    $result = $this->securityService->creerComptePrincipal($userData, $numeroTelephone);
                    if ($result === true) {
                        header("Location: " . APP_URL . "/");

                        $twilioService = new TwilioService();
                        $message = "Bonjour {$userData['prenom']} {$userData['nom']}, votre compte principal a été  créé avec succès sur Maxit SA}.";
                        $smsResult = $twilioService->sendSMS($numeroTelephone, $message);

                        if ($smsResult !== true) {
                            error_log("Erreur SMS Twilio : " . $smsResult);
                        }
                        exit;
                    } else {
                        $this->session->set('errors', ['compte' => $result]);
                    }
                }
            } else {
                $this->session->set('errors', $errors);
            }
        }

        $this->layout = 'security';
        $this->render("compte/form.principal.php");
    }
}
