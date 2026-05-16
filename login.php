<?php
// ============================================================
//  login.php  –  Connexion utilisateur
//  Formulaire frontend : login.html (action="login.php")
//  Champs POST attendus : email, mot_de_passe
// ============================================================

session_start();
require_once 'config.php';

// Si déjà connecté → rediriger
if (!empty($_SESSION['user_id'])) {
    header('Location: quiz.php');
    exit;
}

$erreur = '';

// Message éventuel transmis par d'autres pages (ex: compte bloqué)
if (isset($_GET['erreur'])) {
    $erreur = match($_GET['erreur']) {
        'compte_bloque' => 'Votre compte a été bloqué par un administrateur.',
        default         => ''
    };
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email        = trim($_POST['email']        ?? '');
    $mot_de_passe = trim($_POST['mot_de_passe'] ?? '');

    if (empty($email) || empty($mot_de_passe)) {
        $erreur = 'Veuillez remplir tous les champs.';
    } else {
        // --- Récupération de l'utilisateur par email ---
        $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $erreur = 'Email ou mot de passe incorrect.';

        } elseif ($user['bloque']) {
            $erreur = 'Votre compte a été bloqué par un administrateur.';

        } else {
            // --- Démarrage de session ---
            session_regenerate_id(true); // protection fixation de session

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nom']     = $user['nom'];
            $_SESSION['prenom']  = $user['prenom'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['bloque']  = $user['bloque'];

            // Redirection selon le rôle
            if ($user['role'] === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: quiz.php');
            }
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Legacy QCM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <nav class="the_legacy_house-nav"><div class="nav-inner"><a href="index.php" class="nav-brand"><span>The Legacy</span> QCM</a><div class="nav-links"><a href="register.php" class="btn-publish btn">Inscription</a></div></div></nav>

  <div class="page-wrap fade-up">
    <form class="form-card" action="login.php" method="post">
      <h1 class="form-title">Connexion</h1>
      <p class="form-subtitle">Connectez-vous pour lancer votre tentative de QCM.</p>

      <?php if ($erreur): ?>
        <div class="flash flash-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($erreur) ?></div>
      <?php endif; ?>

      <div class="form-group">
        <label>Email</label>
        <input class="form-control" type="email" name="email" placeholder="etudiant@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input class="form-control" type="password" name="mot_de_passe" placeholder="••••••••" required>
      </div>
      <button class="btn btn-gold btn-block" type="submit"><i class="bi bi-box-arrow-in-right"></i> Se connecter</button>
      <p class="small-center">Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
    </form>
  </div>

  <script src="js/main.js"></script>
</body>
</html>
