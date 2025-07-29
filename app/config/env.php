<?php

use Dotenv\Dotenv;

// Charger .env seulement si les variables d'environnement système ne sont pas définies
if (!getenv('DSN') && file_exists(__DIR__ . '/../../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
}

// Utiliser les variables d'environnement système en priorité, puis .env
define('DB_USER', getenv('DB_USER') ?: $_ENV['DB_USER'] ?? '');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'] ?? '');
define('APP_URL', getenv('APP_URL') ?: $_ENV['APP_URL'] ?? '');
define('DSN', getenv('DSN') ?: $_ENV['DSN'] ?? '');
define('TWILIO_SID', getenv('TWILIO_SID') ?: $_ENV['TWILIO_SID'] ?? '');
define('TWILIO_TOKEN', getenv('TWILIO_TOKEN') ?: $_ENV['TWILIO_TOKEN'] ?? '');
define('TWILIO_FROM', getenv('TWILIO_FROM') ?: $_ENV['TWILIO_FROM'] ?? '');
define('IMG_DIR', getenv('IMG_DIR') ?: $_ENV['IMG_DIR'] ?? '');


