<?php
// ============================================================
//  index.php  –  Page d'accueil
//  Adapte la navigation selon que l'utilisateur est connecté.
// ============================================================

session_start();

// Si compte bloqué → déconnecter proprement
if (!empty($_SESSION['bloque'])) {
    session_destroy();
    header('Location: login.php?erreur=compte_bloque');
    exit;
}

$connecte  = !empty($_SESSION['user_id']);
$est_admin = $connecte && $_SESSION['role'] === 'admin';
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
  <nav class="the_legacy_house-nav">
    <div class="nav-inner">
      <a href="index.php" class="nav-brand"><span>The Legacy</span> QCM</a>
      <div class="nav-search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="search" placeholder="Rechercher un thème…" />
      </div>
      <div class="nav-links">
        <?php if ($connecte): ?>
          <?php if ($est_admin): ?>
            <a href="admin.php"><i class="bi bi-shield-check"></i> Admin</a>
          <?php endif; ?>
          <a href="history.php"><i class="bi bi-clock-history"></i> Historique</a>
          <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        <?php else: ?>
          <a href="login.php"><i class="bi bi-person"></i> Connexion</a>
          <a href="register.php" class="btn-publish btn">Inscription</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <section class="hero fade-up">
    <div class="hero-kicker">Projet de développement web</div>
    <h1>Générez et passez vos QCM<br><em>avec suivi des résultats.</em></h1>
    <p>Une application claire et responsive pour l'inscription, la connexion, le passage d'un QCM de 10 questions, la note sur 20, l'historique et l'administration.</p>
    <div class="hero-actions">
      <a href="<?= $connecte ? 'quiz.php' : 'login.php' ?>" class="btn btn-gold">
        <i class="bi bi-play-circle"></i> Lancer le QCM
      </a>
      <a href="history.php" class="btn btn-outline">
        <i class="bi bi-clock-history"></i> Voir l'historique
      </a>
    </div>
  </section>

  <main class="page-wrap">
    <section class="feature-grid">
      <article class="feature-card">
        <i class="bi bi-person-check"></i>
        <h3>Compte utilisateur</h3>
        <p>Inscription avec nom, prénom, email unique et mot de passe sécurisé.</p>
      </article>
      <article class="feature-card">
        <i class="bi bi-shuffle"></i>
        <h3>10 questions aléatoires</h3>
        <p>Le QCM tire 10 questions différentes depuis une base d'environ 100 questions.</p>
      </article>
      <article class="feature-card">
        <i class="bi bi-award"></i>
        <h3>Résultat sur 20</h3>
        <p>Affichage de la note, du nombre de bonnes réponses et de la correction des erreurs.</p>
      </article>
      <article class="feature-card">
        <i class="bi bi-shield-lock"></i>
        <h3>Anti-triche</h3>
        <p>Plein écran, détection de changement d'onglet, minuterie et avertissements.</p>
      </article>
    </section>
  </main>

  <script src="js/main.js"></script>
</body>
</html>
