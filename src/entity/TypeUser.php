<?php

namespace App\Entity;

use App\Core\AbstractEntity;

class TypeUser extends AbstractEntity{
    private int $id;
    private string $libelle;

    public function __construct($id = 0, $libelle = ''){
        $this->id = $id;
        $this->libelle = $libelle;
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
     * Get the value of libelle
     */ 
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set the value of libelle
     *
     * @return  self
     */ 
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    public static function toObject(array $data):static{
        return new self(
            $data['id'],
            $data['libelle']
        );
    }

    public  function toArray(){
        return [
            'id' => $this->id,
            'libelle' => $this->libelle
        ];
    }
}