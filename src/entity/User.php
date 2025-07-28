<?php

namespace App\Entity;

use App\Core\Abstract\AbstractEntity;

class User extends AbstractEntity{
    private int $id;
    private string $nom;
    private string $prenom;
    private string  $login;
    private string  $password;
    private string  $adresse;


    private string $numeroCNI;
    private string $photoIdentite;

    private TypeUser|null $typeUser = null;

    public function __construct($id = 0, $nom = '', $prenom= '', $login= '', $password= '', $adresse = '', $numeroCNI = '', $photoIdentite = ''){
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        $this->password = $password;
        $this->adresse = $adresse;
        $this->numeroCNI = $numeroCNI;
        $this->photoIdentite = $photoIdentite;

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
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of login
     */ 
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    

    /**
     * Get the value of numeroCNI
     */ 
    public function getNumeroCNI()
    {
        return $this->numeroCNI;
    }

    /**
     * Set the value of numeroCNI
     *
     * @return  self
     */ 
    public function setNumeroCNI($numeroCNI)
    {
        $this->numeroCNI = $numeroCNI;

        return $this;
    }

    /**
     * Get the value of photoIdentite
     */ 
    public function getPhotoIdentite()
    {
        return $this->photoIdentite;
    }

    /**
     * Set the value of photoIdentite
     *
     * @return  self
     */ 
    public function setPhotoIdentite($photoIdentite)
    {
        $this->photoIdentite = $photoIdentite;

        return $this;
    }

    /**
     * Get the value of typeUser
     */ 
    public function getTypeUser()
    {
        return $this->typeUser;
    }

    /**
     * Set the value of typeUser
     *
     * @return  self
     */ 
    public function setTypeUser($typeUser)
    {
        $this->typeUser = $typeUser;

        return $this;
    }

    public static function toObject(array $data):static{
        $data['numeroCNI'] = $data['numeroCNI'] ?? '';
         $data['photoIdentite'] = $data['photoIdentite'] ?? '';
        $User =  new static(
            $data['id'],
            $data['nom'],
            $data['prenom'],
            $data['login'],
            $data['password'],
            $data['adresse'],
            $data['numeroCNI'],
            $data['photoIdentite']
        );
        if(isset($data['typeUser'])){
            $typeUser = new TypeUser();
            $typeUser->setid($data['user_type__id']);
            
        }

        return $User;   

    }

    public function toArray(){
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'login' => $this->login,
            'password' => $this->password,
            'adresse' => $this->adresse,
            'numeroCNI' => $this->numeroCNI,
            'photoIdentite' => $this->photoIdentite,
            'user_type__id' => $this->typeUser ?? '',
        ];
    }
}