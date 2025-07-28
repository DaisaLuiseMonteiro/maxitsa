<?php


interface ICompteRepository{
    public function insertComptePrincipal();
    public function insertSecondaire();
    public function findPrincipalByUserId();
    public function updateSolde();

    public function selectSecondaireCompte();

    public function verifierProprietaire();

}