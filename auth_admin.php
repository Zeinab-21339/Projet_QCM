<?php
// ============================================================
//  auth_admin.php  –  Vérification de session ADMIN
//  À inclure en tête des pages réservées à l'administrateur.
// ============================================================

require_once 'auth_check.php'; // déjà vérifie la connexion

if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
