<?php

namespace App\Controller;

use App\Abstract\AbstractController;
use App\Core\Validate;
use App\Core\Validator;
use App\Service\UserService;

class SecurityController extends AbstractController
{
    private UserService $user_service;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'security';
        $this->user_service = new UserService();
    }

    public function create() {}

    public function store()
    {
        $password = $_POST['password'];
        $login = $_POST['login'];
        $donne = [
            'login' => $login,
            'password' => $password
        ];
        $regle = [
            'login' => [Validate::IS_EMAIL, Validate::IS_EMPTY],
            'password' => [Validate::IS_EMPTY]
        ];

        Validator::validate($donne, $regle);

        if (Validator::is_valide()) {
            $user = $this->user_service->se_connecter($login, $password);
            var_dump($user);
            die;

            if (!$user) {
                $this->session->set(Validator::getErrors(), 'errors');
                $this->session->set($_POST, 'old');
                $this->headerLocation('/');
                exit;
            } else {
                $this->session->set($user->toArray(), 'user');
                $this->headerLocation('/show');
            }
        } else {
            $this->headerLocation('/');
        }
    }
    public function show() {}

    public function index()
    {
        $this->renderHtml('security/login');
    }
    public function edit() {}
    public function destroy() {}
}
