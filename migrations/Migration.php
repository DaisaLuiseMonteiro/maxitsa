<?php

require_once  __DIR__ .  '/../vendor/autoload.php';
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


class Migration
{
    private static ?\PDO $pdo = null;

    private static function connect()
    {
        if (self::$pdo === null) {
          
            self::$pdo = new \PDO($_ENV['dsn'],
            $_ENV['DB_USER'],
              $_ENV['DB_PASSWORD']);
        }
    }

    private static function getQueries(): array {
    $driver = self::$pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

    if ($driver === 'mysql') {
        return [
            "CREATE TABLE IF NOT EXISTS typeUser (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                libelle VARCHAR(50) NOT NULL
            )",

            "CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(100) NOT NULL,
            prenom VARCHAR(100) NOT NULL,
            login VARCHAR(100) UNIQUE NOT NULL,
            password TEXT NOT NULL,
            typeUserId INT UNSIGNED NOT NULL,
            adresse TEXT,
            numeroCNI VARCHAR(20) UNIQUE,
            photoIdentite TEXT,
            FOREIGN KEY (typeUserId) REFERENCES typeUser(id) ON DELETE RESTRICT ON UPDATE CASCADE
        )",
            "CREATE TABLE IF NOT EXISTS compte (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                numero VARCHAR(20) NOT NULL UNIQUE,
                datecreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                solde DECIMAL(15, 2) DEFAULT 0.00,
                typecompte ENUM('principal', 'secondaire') NOT NULL
            )",
            "CREATE TABLE IF NOT EXISTS numeroTelephone (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                numero VARCHAR(20) NOT NULL UNIQUE,
                user_id INT UNSIGNED NOT NULL,
                compte_id INT UNSIGNED NOT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS transactions (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                dateTransaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                typeTransaction ENUM('depot', 'retrait', 'paiement') NOT NULL,
                montant DECIMAL(15,2) NOT NULL,
                libelle TEXT NULL,
                status BOOLEAN DEFAULT NULL,
                client_id INT UNSIGNED NOT NULL,
                compte_id INT UNSIGNED NOT NULL,
                FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE
            )"
        ];
    } else {
        return [
            "CREATE TABLE IF NOT EXISTS typeUser (
                id SERIAL PRIMARY KEY,
                libelle VARCHAR(50) NOT NULL
            )",
            "CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                login VARCHAR(100) UNIQUE NOT NULL,
                password TEXT NOT NULL,
                typeUserId INTEGER NOT NULL,
                adresse TEXT,
                numeroCNI VARCHAR(20) UNIQUE,
                photoIdentite TEXT,
                FOREIGN KEY (typeUserId) REFERENCES typeUser(id) ON DELETE RESTRICT ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS compte (
                id SERIAL PRIMARY KEY,
                numero VARCHAR(20) NOT NULL UNIQUE,
                datecreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                solde DECIMAL(15, 2) DEFAULT 0.00,
                typecompte VARCHAR(20) NOT NULL CHECK (typecompte IN ('principal', 'secondaire'))
            )",
            "CREATE TABLE IF NOT EXISTS numeroTelephone (
                id SERIAL PRIMARY KEY,
                numero VARCHAR(20) NOT NULL UNIQUE,
                user_id INTEGER NOT NULL,
                compte_id INTEGER NOT NULL,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS transactions (
                id SERIAL PRIMARY KEY,
                dateTransaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                typeTransaction VARCHAR(50) NOT NULL CHECK (typeTransaction IN ('depot', 'retrait', 'paiement')),
                montant NUMERIC(15,2) NOT NULL CHECK (montant >= 0),
                libelle TEXT,
                status BOOLEAN DEFAULT NULL,
                client_id INTEGER NOT NULL,
                compte_id INTEGER NOT NULL,
                FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE
            )"
        ];
    }
}


    public static function up()
{
    self::connect();
    $queries = self::getQueries();

    foreach ($queries as $sql) {
        try {
            self::$pdo->exec($sql);
            echo "Requête exécutée avec succès.\n";
        } catch (PDOException $e) {
            echo "Erreur lors de l'exécution de la requête: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    echo "Migration terminée avec succès.\n";
}

}

Migration::up();