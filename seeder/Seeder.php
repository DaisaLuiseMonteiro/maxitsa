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
$dbName = prompt("Nom de la base dans laquelle insérer les données : ");

try {
    $dsn = "$driver:host=$host;port=$port;dbname=$dbName";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("
        INSERT INTO user_type (libelle) VALUES
        ('Administrateur'),
        ('Client');
    ");

    $pdo->exec("
        INSERT INTO users (nom, prenom, telephone, login, password, adresse, cni, photo_cni_recto, photo_cni_verso, type_user) VALUES
        ('Diop', 'Awa', '770000001', 'awa', 'awa123', 'Dakar Liberté 6', 'CNI123', 'recto1.jpg', 'verso1.jpg', 2),
        ('Sow', 'Mamadou', '770000002', 'mamadou', 'pass123', 'Pikine Rue 10', 'CNI124', 'recto2.jpg', 'verso2.jpg', 2);
    ");

    if ($driver === 'mysql') {
        $typePrincipal = "'compte_principal'";
        $typeSecondaire = "'compte_secondaire'";
        $typeDepot = "'depot'";
        $typeRetrait = "'retrait'";
    } else {
        $typePrincipal = "'compte_principal'";
        $typeSecondaire = "'compte_secondaire'";
        $typeDepot = "'depot'";
        $typeRetrait = "'retrait'";
    }

    $pdo->exec("
        INSERT INTO compte (numero, solde, type_compte, user_id) VALUES
        ('CPT001', 50000.00, $typePrincipal, 1),
        ('CPT002', 25000.00, $typeSecondaire, 2);
    ");

    $pdo->exec("
        INSERT INTO transaction (type_transaction, montant, compte_id) VALUES
        ($typeDepot, 10000.00, 1),
        ($typeRetrait, 5000.00, 2);
    ");

    echo "Données insérées avec succès dans la base `$dbName`.\n";

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


// require_once 'vendor/autoload.php';

// $pdo = new \PDO("pgsql:host=localhost;port=5432;dbname=maxit_sa","postgres","Root.123");
// $query='SELECT * FROM users ';
//avec prepare
// $stmt = $pdo->prepare($query); 

// $stmt->execute();

// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// //sans prepare
// $query='SELECT * FROM users';


// $stmt = $pdo->query($query);

// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($result);

// require_once 'vendor/autoload.php';

// $pdo = new \PDO("pgsql:host=localhost;port=5432;dbname=maxit_sa","postgres","Root.123");
// $query='SELECT * FROM users WHERE id = :id_de_l_utilisateur OR id = :nom_cle';
// //avec prepare
// $stmt = $pdo->prepare($query); 

// $stmt->execute([
//     'id_de_l_utilisateur' => 1,
//     'nom_cle'=> 3
// ]);

// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($result);

// //sans prepare
// $query='SELECT * FROM users';


// $stmt = $pdo->query($query);

// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($result);


// $pdo = new \PDO("pgsql:host=localhost;port=5432;dbname=maxit_sa","postgres","Root.123");
// $query="insert into users (nom,prenom,telephone,adresse,cni,photo_recto,photo_verso,password,role_id)
// values (:nom,:prenom,:telephone,:adresse,:cni,:photo_recto,:photo_verso,:password,:role_id)";
// $stmt=$pdo->prepare($query);
// $param=[
// 'nom'=>$user->getNom(),
// ];
// $stmt->execute($params); -->