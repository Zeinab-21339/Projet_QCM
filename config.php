<?php
// ============================================================
//  config.php  –  Connexion à la base de données (PDO)
//  À inclure en tête de chaque fichier PHP backend.
// ============================================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'projet_qcm');
define('DB_USER', 'root');       // ← à adapter selon votre config XAMPP/WAMP
define('DB_PASS', '');           // ← idem

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // En production, ne jamais afficher le message d'erreur brut
    die(json_encode(['erreur' => 'Connexion à la base de données impossible.']));
}
