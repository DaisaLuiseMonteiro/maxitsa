<?php

namespace App\Core;

class Session
{
    public function set($valeur, $cle)
    {
        $this->start();
        $_SESSION[$cle] = $valeur;
    }
    public function get($cle)
    {
        $this->start();
        return $_SESSION[$cle];
    }

    public function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function destroy() {}
    public function unset() {}
    public function isset() {}
}
$session = new Session();
$valeur = [];
$session->set($valeur, "valeur");

