<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ ."/app/config/env.php";
echo "DSN: ".DSN;
echo "DB_USER: ".DB_USER; 
ECHO "DB_PASSWORD: ".DB_PASSWORD;

$pdo=new PDO(
              DSN,
              DB_USER,
              DB_PASSWORD,
              [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
              ]
              );

$var=$pdo->exec("select version()");
echo $var;
// DSN=pgsql:host=dpg-d1vrst6r433s7380bb7g-a.oregon-postgres.render.com;port=5432;dbname=daisa_db;sslmode=require
// DB_USER=appdaf_user
// DB_PASSWORD=PitH91FyeVXdrv9Gzr33W46EeEV4c1T2