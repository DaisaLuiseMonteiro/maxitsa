<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('../');

$dotenv->load();

define('DSN', $_ENV['DSN']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_USER', $_ENV['DB_USER']);
define('URL', $_ENV['URL']);

