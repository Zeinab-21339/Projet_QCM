<?php
// ============================================================
//  results.php  –  Résultats d'une tentative
//  Page frontend de référence : results.html
//  Paramètre GET attendu : tentative (id de la tentative)
// ============================================================

require_once 'auth_check.php';
require_once 'config.php';

$tentative_id = isset($_GET['tentative']) ? (int)$_GET['tentative'] : 0;

if (!$tentative_id) {
    header('Location: history.php');
    exit;
}

// --- Récupérer la tentative (appartenant bien à l'utilisateur connecté) ---
$stmt = $pdo->prepare(
    'SELECT * FROM tentatives WHERE id = ? AND utilisateur_id = ?'
);
$stmt->execute([$tentative_id, $_SESSION['user_id']]);
$tentative = $stmt->fetch();

if (!$tentative) {
    header('Location: history.php');
    exit;
}

// --- Récupérer les réponses avec le détail des questions ---
$stmt = $pdo->prepare(
    'SELECT r.*, q.question, q.reponse1, q.reponse2, q.reponse3, q.reponse4, q.bonne_reponse
     FROM reponses r
     JOIN questions q ON r.question_id = q.id
     WHERE r.tentative_id = ?
     ORDER BY r.id ASC'
);
$stmt->execute([$tentative_id]);
$reponses = $stmt->fetchAll();

// --- Calculs affichage ---
$nb_total    = count($reponses);
$nb_correct  = array_sum(array_column($reponses, 'correcte'));
$nb_faux     = $nb_total - $nb_correct;
$note        = $tentative['score']; // déjà sur 20

// Fonction utilitaire : texte d'une réponse selon son numéro
function texte_reponse(array $q, int $num): string {
    return match($num) {
        1 => $q['reponse1'],
        2 => $q['reponse2'],
        3 => $q['reponse3'],
        4 => $q['reponse4'],
        default => '—'
    };
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
        <a href="history.php"><i class="bi bi-clock-history"></i> Historique</a>
        <a href="quiz.php" class="btn-publish btn">Recommencer</a>
      </div>
    </div>
  </nav>

  <div class="page-wrap fade-up">
    <h1 class="section-title"><i class="bi bi-award"></i> Résultats du QCM</h1>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="value"><?= $note ?>/20</div>
        <div class="label">Note finale</div>
      </div>
      <div class="stat-card">
        <div class="value"><?= $nb_correct ?></div>
        <div class="label">Bonnes réponses</div>
      </div>
      <div class="stat-card">
        <div class="value"><?= $nb_faux ?></div>
        <div class="label">Réponses incorrectes</div>
      </div>
    </div>

    <?php if ($nb_faux > 0): ?>
    <section class="result-card">
      <h2 class="form-title">Correction des erreurs</h2>

      <?php foreach ($reponses as $r):
        if ($r['correcte']) continue; // n'afficher que les erreurs
        $rep_user   = texte_reponse($r, (int)$r['reponse_utilisateur']);
        $rep_bonne  = texte_reponse($r, (int)$r['bonne_reponse']);
      ?>
      <div class="review-item review-wrong">
        <div class="review-question"><?= htmlspecialchars($r['question']) ?></div>
        <div class="review-line">Votre réponse : <?= htmlspecialchars($rep_user) ?></div>
        <div class="review-line good">Bonne réponse : <?= htmlspecialchars($rep_bonne) ?></div>
      </div>
      <?php endforeach; ?>

    </section>
    <?php else: ?>
    <section class="result-card">
      <div class="flash flash-success"><i class="bi bi-check-circle"></i> Félicitations, toutes vos réponses sont correctes !</div>
    </section>
    <?php endif; ?>

  </div>

  <script src="js/main.js"></script>
</body>
</html>
