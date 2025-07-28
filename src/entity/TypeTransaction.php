<?php 

namespace  App\Entity;

enum TypeTransaction : string {
    case DEPOT = 'depot';
    case PAIEMENT = 'paiement';
    case TRANSFERT = 'transfert';
}