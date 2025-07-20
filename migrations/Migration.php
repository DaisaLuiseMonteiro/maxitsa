<?php

require_once __DIR__ . '/../vendor/autoload.php';

function prompt(string $message): string {
    echo $message;
    return trim(fgets(STDIN));
}

function writeEnvIfNotExists(array $config): void {
    $envPath = __DIR__ . '/../.env';
    if (!file_exists($envPath)) {
        $env = <<<ENV
DB_PASSWORD={$config['pass']}
DB_USER={$config['user']}
ROUTE_WEB=http://localhost:8000/
DB_DRIVER={$config['driver']}
DB_HOST={$config['host']}
DB_PORT={$config['port']}
DB_NAME={$config['dbname']}

dns = "{$config['driver']}:host={$config['host']}; dbname={$config['dbname']};port={$config['port']}"
ENV;
        file_put_contents($envPath, $env);
        echo ".env généré avec succès à la racine du projet.\n";
    } else {
        echo "Le fichier .env existe déjà, aucune modification.\n";
    }
}

$driver = strtolower(prompt("Quel SGBD utiliser ? (mysql / pgsql) : "));
$host = prompt("Hôte (default: 127.0.0.1) : ") ?: "127.0.0.1";
$port = prompt("Port (default: 3306 ou 5432) : ") ?: ($driver === 'pgsql' ? "5432" : "3306");
$user = prompt("Utilisateur (default: root) : ") ?: "root";
$pass = prompt("Mot de passe : ");
$dbName = prompt("Nom de la base à créer : ");

try {
    $dsn = "$driver:host=$host;port=$port";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($driver === 'mysql') {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Base MySQL `$dbName` créée avec succès.\n";
        $pdo->exec("USE `$dbName`");
    } elseif ($driver === 'pgsql') {
        $check = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$dbName'")->fetch();
        if (!$check) {
            $pdo->exec("CREATE DATABASE \"$dbName\"");
            echo "Base PostgreSQL `$dbName` créée.\nRelancez la migration pour créer les tables.\n";
            writeEnvIfNotExists([
                'driver' => $driver,
                'host' => $host,
                'port' => $port,
                'user' => $user,
                'pass' => $pass,
                'dbname' => $dbName
            ]);
        } else {
            echo "ℹ Base PostgreSQL `$dbName` déjà existante.\n";
        }
    }

    $dsn = "$driver:host=$host;port=$port;dbname=$dbName";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($driver === 'pgsql') {
        $pdo->exec("DO $$
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_compte_enum') THEN
                CREATE TYPE type_compte_enum AS ENUM ('compte_principal', 'compte_secondaire');
            END IF;
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_transaction_enum') THEN
                CREATE TYPE type_transaction_enum AS ENUM ('depot', 'retrait', 'transfert');
            END IF;
        END$$;");

        $tables = [
            "CREATE TABLE IF NOT EXISTS user_type (
                id SERIAL PRIMARY KEY,
                libelle VARCHAR(100) NOT NULL
            );",
            "CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                telephone VARCHAR(11) NOT NULL,
                login VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(50),
                adresse VARCHAR(100) NOT NULL,
                cni VARCHAR(50),
                photo_cni_recto VARCHAR(255),
                photo_cni_verso VARCHAR(255),
                type_user INTEGER,
                FOREIGN KEY (type_user) REFERENCES user_type(id) ON DELETE SET NULL
            );",
            "CREATE TABLE IF NOT EXISTS compte (
                id SERIAL PRIMARY KEY,
                numero VARCHAR(11) NOT NULL,
                solde NUMERIC(12,2) DEFAULT 0,
                type_compte type_compte_enum NOT NULL,
                user_id INTEGER,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
            );",
            "CREATE TABLE IF NOT EXISTS transaction (
                id SERIAL PRIMARY KEY,
                type_transaction type_transaction_enum NOT NULL,
                montant NUMERIC(12,2) NOT NULL CHECK (montant > 0),
                compte_id INTEGER,
                FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE SET NULL
            );"
        ];
    } else {
        $pdo->exec("DROP TYPE IF EXISTS type_compte_enum;");
        $pdo->exec("DROP TYPE IF EXISTS type_transaction_enum;");

        $tables = [
            "CREATE TABLE IF NOT EXISTS user_type (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                libelle VARCHAR(100) NOT NULL
            );",
            "CREATE TABLE IF NOT EXISTS users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                telephone VARCHAR(11) NOT NULL,
                login VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(50),
                adresse VARCHAR(100) NOT NULL,
                cni VARCHAR(50),
                photo_cni_recto VARCHAR(255),
                photo_cni_verso VARCHAR(255),
                type_user INT UNSIGNED,
                FOREIGN KEY (type_user) REFERENCES user_type(id) ON DELETE SET NULL
            );",
            "CREATE TABLE IF NOT EXISTS compte (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                numero VARCHAR(11) NOT NULL,
                solde DECIMAL(12,2) DEFAULT 0,
                type_compte ENUM('compte_principal', 'compte_secondaire') NOT NULL,
                user_id INT UNSIGNED,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
            );",
            "CREATE TABLE IF NOT EXISTS transaction (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                type_transaction ENUM('depot', 'retrait', 'transfert') NOT NULL,
                montant DECIMAL(12,2) NOT NULL CHECK (montant > 0),
                compte_id INT UNSIGNED,
                FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE SET NULL
            );"
        ];
    }

    foreach ($tables as $sql) {
        $pdo->exec($sql);
    }

    echo "Toutes les tables ont été créées avec succès dans `$dbName`.\n";

    writeEnvIfNotExists([
        'driver' => $driver,
        'host' => $host,
        'port' => $port,
        'user' => $user,
        'pass' => $pass,
        'dbname' => $dbName
    ]);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
