<?php
// ============================================================
//  auth_check.php  –  Vérification de session
//  À inclure en tête de toute page réservée aux utilisateurs
//  connectés (quiz, résultats, historique).
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Vérification supplémentaire : compte bloqué par l'admin
if (!empty($_SESSION['bloque'])) {
    session_destroy();
    header('Location: login.php?erreur=compte_bloque');
    exit;
}
