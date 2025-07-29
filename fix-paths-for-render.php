<?php

// Script pour corriger les chemins relatifs pour le déploiement sur Render

$files_to_fix = [
    'public/index.php' => [
        'require_once "../vendor/autoload.php";' => 'require_once __DIR__ . "/../vendor/autoload.php";',
        'require_once "../app/config/bootstrap.php";' => 'require_once __DIR__ . "/../app/config/bootstrap.php";',
        'require_once \'../routes/route.web.php\';' => 'require_once __DIR__ . \'/../routes/route.web.php\';'
    ],
    'app/config/bootstrap.php' => [
        'require_once "../app/config/middlewares.php";' => 'require_once __DIR__ . "/middlewares.php";',
        'require_once "../app/config/env.php";' => 'require_once __DIR__ . "/env.php";'
    ],
    'src/controller/CompteController.php' => [
        'require_once "../app/config/rules.php";' => 'require_once __DIR__ . "/../../app/config/rules.php";'
    ],
    'src/controller/SecurityController.php' => [
        'require_once "../app/config/rules.php";' => 'require_once __DIR__ . "/../../app/config/rules.php";'
    ],
    'src/controller/AchatControler.php' => [
        'require_once "../app/config/rules.php";' => 'require_once __DIR__ . "/../../app/config/rules.php";'
    ],
    'app/core/abstract/AbstractController.php' => [
        'require_once \'../templates/\' . $views;' => 'require_once __DIR__ . \'/../../templates/\' . $views;',
        'require_once \'../templates/layout/\' . $this->layout . \'.layout.php\';' => 'require_once __DIR__ . \'/../../templates/layout/\' . $this->layout . \'.layout.php\';'
    ],
    'templates/layout/base.layout.php' => [
        'require_once \'../templates/layout/partial/leftbar.php\';' => 'require_once __DIR__ . \'/partial/leftbar.php\';',
        'require_once \'../templates/layout/partial/header.html.php\';' => 'require_once __DIR__ . \'/partial/header.html.php\';'
    ]
];

foreach ($files_to_fix as $file => $replacements) {
    $filepath = __DIR__ . '/' . $file;
    
    if (!file_exists($filepath)) {
        echo "Fichier non trouvé: $filepath\n";
        continue;
    }
    
    $content = file_get_contents($filepath);
    $original_content = $content;
    
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    if ($content !== $original_content) {
        file_put_contents($filepath, $content);
        echo "Corrigé: $file\n";
    } else {
        echo "Aucun changement: $file\n";
    }
}

echo "Correction des chemins terminée.\n";
