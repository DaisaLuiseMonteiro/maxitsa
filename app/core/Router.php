<?php

namespace App\Core;

class Router
{

    private static array $routes = [];

    public static function setRoute(array $routes){
        if (!is_array($routes)) {
            throw new \Exception("Votre uri est vide !");
        }
        self::$routes = $routes;
    }

    public static function resolve() {
        $uri = $_SERVER['REQUEST_URI'];

        if (array_key_exists($uri,self::$routes)){
            $valeur= self::$routes[$uri];
            $controllerName = $valeur['controller'];
            $methode = $valeur['methode'];
            $controller = new $controllerName();
            $controller->$methode();
        }

        die;
    }
}
