<?php

namespace App\Controller;

use App\Core\App;
use App\Core\Session;


use App\Core\Validator;
use App\Service\TwilioService;
use App\Service\SecurityService;
use App\Core\Abstract\AbstractController;




class SecurityController extends AbstractController
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
        $this->layout = 'security';
        $this->securityService =   $securityService;
        $this->validator = $validator;
    }
    public function index()
    {
        $this->unset('errors');
        $this->render("login/login.php");
    }

    public function show() {}
    public function create() {}

    public function store() {}

    public function edit() {}
    public function buy(){}

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . "/../../app/config/rules.php";

            $loginData = $_POST;

            // Vérifier que les champs requis sont présents
            if (!isset($loginData['login']) || !isset($loginData['password'])) {
                $this->validator->addError('login', "Login et mot de passe requis");
                $this->session->set('errors', $this->validator->getErrors());
                $this->render("login/login.php");
                return;
            }

            if ($this->validator->validate($loginData,  $rules)) {
                $user = $this->securityService->seConnecter($loginData['login'], $loginData['password']);
                if ($user) {
                    $this->session->set("user", $user->toArray());
                    header("Location:" . APP_URL . "/compte");
                    exit();
                } else {
                    $this->validator->addError('password', "Identifiant incorrect");
                    $this->session->set('errors', $this->validator->getErrors());
                    $this->render("login/login.php");
                }
            } else {
                $this->session->set('errors', $this->validator->getErrors());
                $this->render("login/login.php");
            }
        } else {
            // Si c'est une requête GET, afficher le formulaire
            $this->render("login/login.php");
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location:" . APP_URL);
    }

    private function validateForm(array &$data): array
    {
        require_once __DIR__ . "/../../app/config/rules.php";
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
