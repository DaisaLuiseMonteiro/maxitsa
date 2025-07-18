<?php
namespace App\Core;


class Singleton {
    private static mixed  $instance = null;
    public static function getInstance(): static{
        if (self::$instance===null){
            self::$instance= new static();
        }
        return self::$instance;
    }
}