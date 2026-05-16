<?php
// ============================================================
//  history.php  –  Historique et moyenne de l'utilisateur
//  Page frontend de référence : history.html
// ============================================================

require_once 'auth_check.php';
require_once 'config.php';

// --- Toutes les tentatives de l'utilisateur (plus récentes en premier) ---
$stmt = $pdo->prepare(
    'SELECT * FROM tentatives WHERE utilisateur_id = ? ORDER BY date DESC'
);
$stmt->execute([$_SESSION['user_id']]);
$tentatives = $stmt->fetchAll();

// --- Calcul de la moyenne ---
$nb_tentatives = count($tentatives);
$moyenne = 0;
if ($nb_tentatives > 0) {
    $total_scores = array_sum(array_column($tentatives, 'score'));
    $moyenne      = round($total_scores / $nb_tentatives, 2);
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
  <nav class="the_legacy_house-nav">
    <div class="nav-inner">
      <a href="index.php" class="nav-brand"><span>The Legacy</span> QCM</a>
      <div class="nav-links">
        <a href="quiz.php" class="btn-publish btn">Lancer un QCM</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
      </div>
    </div>
  </nav>

  <div class="page-wrap fade-up">
    <h1 class="section-title"><i class="bi bi-clock-history"></i> Mon historique</h1>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="value"><?= $moyenne ?>/20</div>
        <div class="label">Moyenne générale</div>
      </div>
      <div class="stat-card">
        <div class="value"><?= $nb_tentatives ?></div>
        <div class="label">Tentatives</div>
      </div>
    </div>

    <section class="history-card">
      <?php if ($nb_tentatives === 0): ?>
        <div class="flash flash-info"><i class="bi bi-info-circle"></i> Vous n'avez pas encore passé de QCM. <a href="quiz.php">Commencer maintenant</a></div>
      <?php else: ?>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Tentative</th>
            <th>Date</th>
            <th>Score</th>
            <th>Statut</th>
            <th>Détail</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tentatives as $i => $t): ?>
          <tr>
            <td><?= $nb_tentatives - $i ?></td>
            <td><?= date('d/m/Y H:i', strtotime($t['date'])) ?></td>
            <td><?= $t['score'] ?>/20</td>
            <td><span class="role-badge role-member">Terminée</span></td>
            <td><a href="results.php?tentative=<?= $t['id'] ?>">Voir</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </section>
  </div>

  <script src="js/main.js"></script>
</body>
</html>
