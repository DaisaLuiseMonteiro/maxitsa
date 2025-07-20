<?php

use App\Controller\CompteController;
use App\Controller\SecurityController;

$routes = [
    '/' => [
        'controller' => SecurityController::class,
        'methode' => 'index'
    ],
    '/auth' => [
        'controller' => SecurityController::class,
        'methode' => 'store'
    ],
     '/show' => [
        'controller' => CompteController::class,
        'methode' => 'show'
    ],
];