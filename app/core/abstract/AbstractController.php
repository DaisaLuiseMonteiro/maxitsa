<?php

namespace App\Core\Abstract;

use App\Core\App;
use App\Core\Session;
use App\Core\ImageService;

abstract class AbstractController extends Session
{


    protected   $layout = 'base';

    protected $session;

    private static AbstractController|null $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    abstract public function index();
    abstract public function create();
    abstract public function store();
    abstract public function edit();
    abstract public function buy();

    // abstract public function destroy();
    abstract public function show();




    public function render(string $views, array $data = [])
    {
        extract($data);
        ob_start();
        require_once '../templates/' . $views;
        $contentForLayout = ob_get_clean();
        require_once '../templates/layout/' . $this->layout . '.layout.php';
    }

    public function uploadPhotos(array $files): string|false
    {
        try {
            $uploads = ImageService::uploadMultipleImages([
                'photoRecto' => $files['photoRecto'] ?? null,
                'photoVerso' => $files['photoVerso'] ?? null
            ], __DIR__ . '/../../public/images/uploads/');

            return json_encode([
                'recto' => $uploads['photoRecto']['url'],
                'verso' => $uploads['photoVerso']['url']
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }


    public  function fetchAPI($url)
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],
                'timeout' => 30
            ]
        ]);

        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new \Exception('Erreur lors de la récupération des données');
        }

        return json_decode($response, true);
    }
}
