<?php
// ============================================================
//  logout.php  –  Déconnexion
//  Appelé par le lien "Déconnexion" dans la nav du frontend.
// ============================================================

session_start();
session_unset();
session_destroy();

header('Location: login.php');
exit;
