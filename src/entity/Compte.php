<?php
namespace App\Entity;

use App\Enums\TypeCompte;
use DateTime;

class Compte {
    private int $id ; 
    private int $solde ; 
    private string $numero  ; 
    private string $datecreation ; 
    private int $typecompte ; 
    private array $transactions ;
    private NumeroTelephone $num ; 

    public function __construct (int $id =0 , int $solde = 0, $numero = "",string $datecreation = '', $typecompte=TypeCompte::PRINCIPAL){

        $this->id = $id ;
        $this->solde = $solde ;
        $this->numero = $numero ; 
        $this->datecreation = $datecreation;
        $this->typecompte = $typecompte ; 
        $this->transactions = [];
        $this->num = new NumeroTelephone();
    }

    

     public  function toArray():array{

        return [
            'id'       => $this->id,
            'solde'      => $this->solde,
            'numero'   => $this->numero,
            'date'  => $this->datecreation ,
            'type_id'      => $this->typecompte,
            'num_id'    => $this->num 
/*             'profil'   => $this->profil->toArray() ,
          'transactions'  => array_map(fn ($num) => $num->toArray() , $this->transactions)*/

        ];
    }
    public static function toObject (array $array) : static {
       return  new static( 
        isset($array['id']) ? (int)$array['id'] : 1,
        isset($array['solde']) ? (int)$array['solde'] : 0,
        $array['numero'] ?? "",
        $array['datecreation' ] ?? "",
        isset($array['type_id']) ? (int)$array['typetypecompte'] : 1,
           /*  $array['adresse'] ?? "",
            $array['cni'] ?? "",
            $array['recto'] ?? "",
            $array['verso'] ?? "" */
            // Les champs 'profil' et 'numeros' sont gérés par le constructeur
         ) ;

    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of solde
     */ 
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set the value of solde
     *
     * @return  self
     */ 
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get the value of numero
     */ 
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */ 
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getTypecompte()
    {
        return $this->typecompte;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setTypecompte($typecompte)
    {
        $this->typecompte = $typecompte;

        return $this;
    }

    /**
     * Get the value of transactions
     */ 
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Set the value of transactions
     *
     * @return  self
     */ 
    public function AddTransactions(Transaction $transaction)
    {
        $this->transactions [] = $transaction;

        return $this;
    }

    /**
     * Get the value of num
     */ 
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set the value of num
     *
     * @return  self
     */ 
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }
}