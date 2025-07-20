<?php
namespace App;

use Symfony\Component\Yaml\Yaml;

class App {
    private array $services = [];

    public function __construct() {
        $this->loadServices();
    }

    private function loadServices() {
        $config = Yaml::parseFile(__DIR__ . '/../config/services.yml');
        foreach ($config['services'] as $key => $class) {
            $this->services[$key] = new $class();
        }
    }

    public function get(string $name) {
        return $this->services[$name] ?? null;
    }
}