<?php

use App\Core\Abstract\AbstractEntity;


class NumeroTelephone {
    private int $id;
    private string $numero;
    private Compte $compte;
    private User $user;
    public function __construct(int $id = 0, string $numero = ""){
        $this->id = $id;
        $this->numero = $numero;
        $this->compte = new Compte();
        $this->user = new User();
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
     * Get the value of compte
     */ 
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set the value of compte
     *
     * @return  self
     */ 
    public function setCompte($compte)
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    // public static function toObject(array $data): static{
    //     $tel = new static(
    //         $data['id'],
    //         $data['numero'],
    //     );
    //     $compte = ()->getId();
    // }
}