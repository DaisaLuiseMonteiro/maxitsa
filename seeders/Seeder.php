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
          
            self::$pdo = new \PDO($_ENV['DSN'],
            $_ENV['DB_USER'],
              $_ENV['DB_PASSWORD']);
            
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public static function run()
    {
        self::connect();

        try {
            // Insert typeUser avec vérification
            $stmt = self::$pdo->prepare("SELECT COUNT(*) FROM typeUser WHERE libelle IN ('client', 'serviceCommercial')");
            $stmt->execute();
            if ($stmt->fetchColumn() < 2) {
                self::$pdo->exec("INSERT INTO typeUser (libelle) 
                    SELECT 'client' WHERE NOT EXISTS (SELECT 1 FROM typeUser WHERE libelle = 'client')
                    UNION ALL
                    SELECT 'serviceCommercial' WHERE NOT EXISTS (SELECT 1 FROM typeUser WHERE libelle = 'serviceCommercial')");
                echo "Types d'utilisateurs insérés.\n";
            } else {
                echo "Types d'utilisateurs déjà existants.\n";
            }

            // Insert user with conflict handling
            self::$pdo->exec("INSERT INTO users (nom, prenom, login, password, typeUserId, adresse, numeroCNI, photoIdentite) VALUES 
                ('Diop', 'sigi', 'sidi@gmail.com', 'Sidi@2024', 1, 'Dakar', '1234567890123', 'photo_identite.jpg')
                ON CONFLICT (login) DO NOTHING");
            echo " Utilisateur inséré.\n";

            // Insert compte with conflict handling
            self::$pdo->exec("INSERT INTO compte (numero, datecreation, solde, typecompte) VALUES 
                ('1234567890', '2023-01-01', 1000.00, 'principal')
                ON CONFLICT (numero) DO NOTHING");
            echo "Compte inséré.\n";

            // Insert numeroTelephone with conflict handling
            self::$pdo->exec("INSERT INTO numeroTelephone (numero, user_id, compte_id) VALUES 
                ('771234567', 1, 1)
                ON CONFLICT (numero) DO NOTHING");
            echo "Numéro de téléphone inséré.\n";

            // Insert transaction (no unique constraint, check manually)
            $stmt = self::$pdo->prepare("SELECT COUNT(*) FROM transactions WHERE client_id = 1 AND montant = 500.00 AND typeTransaction = 'depot'");
            $stmt->execute();
            if ($stmt->fetchColumn() == 0) {
                self::$pdo->exec("INSERT INTO transactions (dateTransaction, typeTransaction, montant, libelle, client_id, compte_id) VALUES 
                    ('2023-01-01', 'depot', 500.00, 'Dépôt initial', 1, 1)");
                echo "Transaction insérée.\n";
            } else {
                echo "Transaction déjà existante.\n";
            }

            echo "Toutes les données de test ont été traitées avec succès.\n";

        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion des données: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}

Seeder::run();