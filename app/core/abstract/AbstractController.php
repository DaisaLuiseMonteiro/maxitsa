<?php

namespace App\Abstract;

use App\Core\Session;
use App\Core\Singleton;

abstract class AbstractController extends Singleton
{
    protected  Session $session;
    protected string $layout = 'base';

    public function __construct()
    {
        $this->session = new Session();
    }

    abstract public function create();
    abstract public function store();
    abstract public function show();
    abstract public function index();
    abstract public function edit();
    abstract public function destroy();

    public function renderHtml($views)
    {
        ob_start();

        require_once '../templates/' . $views . '.html.php';

        $ContentForLayout = ob_get_clean();

        require_once '../templates/layout/' . $this->layout . '.layout.html.php';
        exit;
    }
    public function headerLocation($location): void
    {
        header('Location: ' . $location);
    }
}
