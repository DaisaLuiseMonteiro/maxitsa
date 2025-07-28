<?php

require_once  __DIR__ .  '/../vendor/autoload.php';
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Seeder
{
    private static ?\PDO $pdo = null;

    private static function connect()
    {
        if (self::$pdo === null) {
          
            self::$pdo = new \PDO($_ENV['dsn'],
            $_ENV['DB_USER'],
              $_ENV['DB_PASSWORD']);
            
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public static function run()
    {
        self::connect();

        try {
            self::$pdo->exec("INSERT INTO typeUser (libelle) VALUES 
                ('client'),
                ('serviceCommercial')");
            echo "Types d'utilisateurs insérés.\n";

            self::$pdo->exec("INSERT INTO users (nom, prenom, login, password, typeUserId, adresse, numeroCNI, photoIdentite) VALUES 
                ('Diop', 'sigi', 'sidi@gmail.com', 'Sidi@2024', 1, 'Dakar', '1234567890123', 'photo_identite.jpg')");
            echo " Utilisateur inséré.\n";

            self::$pdo->exec("INSERT INTO compte (numero, datecreation, solde, typecompte) VALUES 
                ('1234567890', '2023-01-01', 1000.00, 'principal')");
            echo "Compte inséré.\n";

            self::$pdo->exec("INSERT INTO numeroTelephone (numero, user_id, compte_id) VALUES 
                ('771234567', 1, 1)");
            echo "Numéro de téléphone inséré.\n";

            self::$pdo->exec("INSERT INTO transactions (dateTransaction, typeTransaction, montant, libelle, client_id, compte_id) VALUES 
                ('2023-01-01', 'depot', 500.00, 'Dépôt initial', 1, 1)");
            echo "Transaction insérée.\n";

            echo "Toutes les données de test ont été insérées avec succès.\n";

        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion des données: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}

Seeder::run();