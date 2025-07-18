<?php
namespace App\Controller;

use App\Abstract\AbstractController;

class CompteController extends AbstractController{
    public function __construct(){
$this->layout='base';        
    }

     public function create(){}
     public function store(){}
     public function show(){
        $this->renderHtml('compte/compte');

     }
     public function index(){}
     public function edit(){}
     public function destroy(){}
    
}
