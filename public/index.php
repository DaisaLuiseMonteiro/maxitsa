<?php
require_once '../app/config/bootstrap.php';

use App\Core\Router;

Router::setRoute($routes);
Router::resolve();