<?php
// ============================================================
//  register.php  –  Inscription d'un nouvel utilisateur
//  Formulaire frontend : register.html (action="register.php")
//  Champs POST attendus : nom, prenom, email, mot_de_passe
// ============================================================

session_start();
require_once 'config.php';

// Si déjà connecté → rediriger
if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$erreur  = '';
$succes  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- 1. Récupération et nettoyage des données ---
    $nom          = trim($_POST['nom']          ?? '');
    $prenom       = trim($_POST['prenom']        ?? '');
    $email        = trim($_POST['email']         ?? '');
    $mot_de_passe = trim($_POST['mot_de_passe']  ?? '');

    // --- 2. Validation ---
    if (empty($nom) || empty($prenom) || empty($email) || empty($mot_de_passe)) {
        $erreur = 'Tous les champs sont obligatoires.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = 'Adresse email invalide.';

    } elseif (strlen($mot_de_passe) < 8) {
        $erreur = 'Le mot de passe doit contenir au moins 8 caractères.';

    } else {
        // --- 3. Vérification unicité de l'email ---
        $stmt = $pdo->prepare('SELECT id FROM utilisateurs WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $erreur = 'Cette adresse email est déjà utilisée.';
        } else {
            // --- 4. Hachage du mot de passe ---
            $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

            // --- 5. Insertion en base ---
            $insert = $pdo->prepare(
                'INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role, bloque)
                 VALUES (?, ?, ?, ?, \'user\', 0)'
            );
            $insert->execute([$nom, $prenom, $email, $hash]);

            // --- 6. Connexion automatique après inscription ---
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['nom']     = $nom;
            $_SESSION['prenom']  = $prenom;
            $_SESSION['role']    = 'user';
            $_SESSION['bloque']  = 0;

            header('Location: quiz.php');
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
  <nav class="the_legacy_house-nav"><div class="nav-inner"><a href="index.php" class="nav-brand"><span>The Legacy</span> QCM</a><div class="nav-links"><a href="login.php"><i class="bi bi-person"></i> Connexion</a><a href="index.php"><i class="bi bi-house"></i> Accueil</a></div></div></nav>

  <div class="page-wrap fade-up">
    <form class="form-card" action="register.php" method="post">
      <h1 class="form-title">Inscription</h1>
      <p class="form-subtitle">Créez votre compte avant de passer le QCM.</p>

      <?php if ($erreur): ?>
        <div class="flash flash-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($erreur) ?></div>
      <?php endif; ?>

      <div class="form-grid-2">
        <div class="form-group">
          <label>Nom</label>
          <input class="form-control" type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label>Prénom</label>
          <input class="form-control" type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
        </div>
      </div>
      <div class="form-group">
        <label>Email unique</label>
        <input class="form-control" type="email" name="email" placeholder="etudiant@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>Mot de passe sécurisé</label>
        <input class="form-control" type="password" name="mot_de_passe" placeholder="Minimum 8 caractères" required>
      </div>
      <button class="btn btn-gold btn-block" type="submit"><i class="bi bi-person-plus"></i> Créer mon compte</button>
      <p class="small-center">Déjà inscrit ? <a href="login.php">Se connecter</a></p>
    </form>
  </div>

  <script src="js/main.js"></script>
</body>
</html>
