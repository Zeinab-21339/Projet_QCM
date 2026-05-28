<?php
// ============================================================
//  quiz.php  –  Passage du QCM
//  Page frontend de référence : quiz.html
//  - GET  : affiche les 10 questions aléatoires
//  - POST : reçoit les réponses et redirige vers results.php
// ============================================================

require_once 'auth_check.php';
require_once 'config.php';

// ── POST : soumission des réponses ──────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reponses_user = $_POST['reponses'] ?? []; // tableau [question_id => valeur_radio]

    if (empty($_SESSION['quiz_questions'])) {
        header('Location: quiz.php');
        exit;
    }

    $questions = $_SESSION['quiz_questions'];
    $score_brut = 0;
    $nb_questions = count($questions);

    // --- Créer la tentative ---
    $stmt = $pdo->prepare(
        'INSERT INTO tentatives (utilisateur_id, score, date) VALUES (?, 0, NOW())'
    );
    $stmt->execute([$_SESSION['user_id']]);
    $tentative_id = $pdo->lastInsertId();

    // --- Enregistrer chaque réponse ---
    $insert_rep = $pdo->prepare(
        'INSERT INTO reponses (tentative_id, question_id, reponse_utilisateur, correcte)
         VALUES (?, ?, ?, ?)'
    );

    foreach ($questions as $q) {
        $qid           = $q['id'];
        $rep_user      = isset($reponses_user[$qid]) ? (int)$reponses_user[$qid] : 0;
        $correcte      = ($rep_user === (int)$q['bonne_reponse']) ? 1 : 0;
        $score_brut   += $correcte;

        $insert_rep->execute([$tentative_id, $qid, $rep_user, $correcte]);
    }

    // --- Calculer la note sur 20 ---
    $note = round(($score_brut / $nb_questions) * 20, 2);

    // --- Mettre à jour le score dans tentatives ---
    $pdo->prepare('UPDATE tentatives SET score = ? WHERE id = ?')
        ->execute([$note, $tentative_id]);

    // --- Nettoyer la session quiz ---
    unset($_SESSION['quiz_questions']);

    // --- Rediriger vers les résultats ---
    header('Location: results.php?tentative=' . $tentative_id);
    exit;
}

// ── GET : démarrage d'un nouveau QCM ───────────────────────

// Sélection de 10 questions aléatoires
$stmt = $pdo->query('SELECT * FROM questions ORDER BY RAND() LIMIT 10');
$questions = $stmt->fetchAll();

// Stockage en session pour valider les réponses au POST
$_SESSION['quiz_questions'] = $questions;
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
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
      </div>
    </div>
  </nav>

  <div class="page-wrap fade-up">
    <div class="flash flash-info"><i class="bi bi-info-circle"></i> Le QCM doit rester en plein écran. Quitter la page ou changer d'onglet peut annuler la tentative.</div>

    <div class="qcm-layout">
      <main class="quiz-card">

        <form class="answer-list" action="quiz.php" method="post" id="quizForm">

          <?php foreach ($questions as $index => $q):
            $num = $index + 1;
            $reponses = [
              1 => $q['reponse1'],
              2 => $q['reponse2'],
              3 => $q['reponse3'],
              4 => $q['reponse4'],
            ];
          ?>
          <div class="quiz-question-block" id="question-<?= $num ?>" style="<?= $num > 1 ? 'display:none' : '' ?>">

            <div class="quiz-topbar">
              <span class="tag tag-gold">Question <?= $num ?> sur <?= count($questions) ?></span>
            </div>
            <div class="quiz-progress"><span style="width: <?= round($num / count($questions) * 100) ?>%"></span></div>

            <h1 class="quiz-question"><?= htmlspecialchars($q['question']) ?></h1>

            <?php foreach ($reponses as $val => $texte): ?>
              <label class="answer-option">
                <input type="radio" name="reponses[<?= $q['id'] ?>]" value="<?= $val ?>" required>
                <span><?= htmlspecialchars($texte) ?></span>
              </label>
            <?php endforeach; ?>

          </div>
          <?php endforeach; ?>

          <div class="quiz-actions">
            <button class="btn btn-outline" type="button" id="fullscreenBtn">
              <i class="bi bi-arrows-fullscreen"></i> Plein écran
            </button>
            <button class="btn btn-outline" type="button" id="prevBtn" style="display:none">
              <i class="bi bi-arrow-left"></i> Précédent
            </button>
            <button class="btn btn-gold" type="button" id="nextBtn">
              Suivant <i class="bi bi-arrow-right"></i>
            </button>
            <button class="btn btn-gold" type="submit" id="submitBtn" style="display:none">
              <i class="bi bi-check2-circle"></i> Valider mes réponses
            </button>
          </div>

        </form>
      </main>

      <aside class="side-panel">
        <h2>Surveillance</h2>
        <p><strong>Temps restant :</strong> <span id="timer">10:00</span></p>
        <p><strong>Avertissements :</strong> <span id="warningCount">0</span></p>
        <ul>
          <li>10 questions différentes</li>
          <li>1 seule bonne réponse par question</li>
          <li>Score final calculé sur 20</li>
        </ul>
        <p><strong>Connecté :</strong> <?= htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']) ?></p>
      </aside>
    </div>
  </div>

  <script src="js/main.js"></script>
  <script>
    // Navigation entre questions
    let current = 1;
    const total = <?= count($questions) ?>;

    function showQuestion(n) {
      document.querySelectorAll('.quiz-question-block').forEach(el => el.style.display = 'none');
      document.getElementById('question-' + n).style.display = '';
      document.getElementById('prevBtn').style.display = n > 1 ? '' : 'none';
      document.getElementById('nextBtn').style.display = n < total ? '' : 'none';
      document.getElementById('submitBtn').style.display = n === total ? '' : 'none';
    }

    document.getElementById('nextBtn').addEventListener('click', () => {
      // Vérifier qu'une réponse est cochée pour la question courante
      const qBlock = document.getElementById('question-' + current);
      const checked = qBlock.querySelector('input[type="radio"]:checked');
      if (!checked) { alert('Veuillez sélectionner une réponse avant de continuer.'); return; }
      if (current < total) { current++; showQuestion(current); }
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
      if (current > 1) { current--; showQuestion(current); }
    });

    // Soumission finale : vérifier toutes les réponses
    document.getElementById('quizForm').addEventListener('submit', function(e) {
      for (let i = 1; i <= total; i++) {
        const qBlock = document.getElementById('question-' + i);
        if (!qBlock.querySelector('input[type="radio"]:checked')) {
          e.preventDefault();
          alert('Question ' + i + ' : aucune réponse sélectionnée.');
          current = i;
          showQuestion(i);
          return;
        }
      }
    });
  </script>
</body>
</html>
