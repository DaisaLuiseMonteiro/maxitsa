<?php

namespace App\Entity;

use App\Abstract\AbstractEntity;

class UserType extends AbstractEntity
{

    private int $id;
    private string $libelle;

    public function __construct($id = 0, $libelle = '')
    {
        $this->id = $id;
        $this->libelle = $libelle;
    }


    public static function toObject(array $data): static
    {
        return new static(
            $data['id'],
            $data['libelle']
        );
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle

        ];
    }


    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }
}
