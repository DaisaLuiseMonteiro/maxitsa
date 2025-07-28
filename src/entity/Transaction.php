<?php

namespace App\Entity;

class Transaction{
    private int $id;
    private string $libelle;
    private float $montant;
    private string $date;
    private Compte $compte;
    private TypeTransaction $typeTransaction;
    private User  $user; 
}