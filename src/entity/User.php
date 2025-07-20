<?php
namespace App\Entity;
use App\Abstract\AbstractEntity;


class User extends AbstractEntity {
private int $id ;
private string $nom ;
private string $prenom ;
private string $telephone ;
private string $login ;
private string $adresse ;
private string $password ;
private string $cni ;
private string $photoIdentiteRecto ;
private string $photoIdentiteverso ;
private UserType $Usertype ;


public function __construct($id=0,$nom='',$prenom='',$telephone='',$login='',$adresse='',$password='',$cni='',$photoIdentiteRecto='',$photoIdentiteverso=''){
   $this->id=$id;
   $this->nom=$nom;
   $this->prenom=$prenom;
   $this->telephone=$telephone;
   $this->login =$login;
   $this->adresse=$adresse;
   $this->password=$password;
   $this->cni=$cni;
   $this->photoIdentiteRecto=$photoIdentiteRecto;
   $this->photoIdentiteverso=$photoIdentiteverso;
   $this->Usertype = new UserType();
}
public static function toObject(array $data):static{


 return new static(
   $data['id'],
   $data['nom'],
   $data['prenom'],
   $data['telephone'],
   $data['login'],
   $data['adresse'],
   $data['password'],
   $data['cni'],
   $data['photo_cni_recto'],
   $data['photo_cni_verso'],
   UserType::toObject([
       'id' => $data['type_user'],
       'libelle'=>$data['libelle'] ?? ''
   ])
 );
 }


public function toArray(){
   return[
           'id'=>$this->id,
           'nom'=>$this->nom,
           'prenom'=>$this->prenom,
           'telephone'=>$this->telephone,
           'login'=>$this->login,
           'adresse'=>$this->adresse,
           'password'=>$this->password,
           'cni'=>$this->cni,
           'photoIdentiteRecto'=>$this->photoIdentiteRecto,
           'photoIdentiteverso'=>$this->photoIdentiteverso,
           'userType'=>$this->Usertype->toArray()


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


public function getNom()
{
return $this->nom;
}




public function setNom($nom)
{
$this->nom = $nom;


return $this;
}


public function getPrenom()
{
return $this->prenom;
}




public function setPrenom($prenom)
{
$this->prenom = $prenom;


return $this;
}
public function getTelephone()
{
return $this->telephone;
}




public function setTelephone($telephone)
{
$this->telephone = $telephone;


return $this;
}


public function getLogin()
{
return $this->login;
}


public function setLogin($login)
{
$this->login = $login;


return $this;
}




public function getAdresse()
{
return $this->adresse;
}
public function setAdresse($adresse)
{
$this->adresse = $adresse;


return $this;
}


public function getPassword()
{
return $this->password;
}




public function setPassword($password)
{
$this->password = $password;


return $this;
}
public function getCni()
{
return $this->cni;
}


public function setCni($cni)
{
$this->cni = $cni;


return $this;
}




public function getPhotoIdentiteRecto()
{
return $this->photoIdentiteRecto;
}




public function setPhotoIdentiteRecto($photoIdentiteRecto)
{
$this->photoIdentiteRecto = $photoIdentiteRecto;


return $this;
}
public function getPhotoIdentiteverso()
{
return $this->photoIdentiteverso;
}




public function setPhotoIdentiteverso($photoIdentiteverso)
{
$this->photoIdentiteverso = $photoIdentiteverso;


return $this;
}




public function getUsertype()
{
return $this->Usertype;
}




public function setUsertype($Usertype)
{
$this->Usertype = $Usertype;


return $this;
}
}

