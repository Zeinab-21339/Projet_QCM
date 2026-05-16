<?php
// ============================================================
//  admin.php  –  Interface administrateur
//  Page frontend de référence : admin.html
//  Actions POST gérées :
//    - ajouter_question
//    - modifier_question
//    - supprimer_question
//    - bloquer_utilisateur
//    - supprimer_utilisateur
// ============================================================

require_once 'auth_admin.php';
require_once 'config.php';

$erreur = '';
$succes = '';

// ── Traitement des actions POST ─────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // --- Ajouter une question ---
    if ($action === 'ajouter_question') {
        $question     = trim($_POST['question']     ?? '');
        $reponse1     = trim($_POST['reponse1']     ?? '');
        $reponse2     = trim($_POST['reponse2']     ?? '');
        $reponse3     = trim($_POST['reponse3']     ?? '');
        $reponse4     = trim($_POST['reponse4']     ?? '');
        $bonne_reponse = (int)($_POST['bonne_reponse'] ?? 0);

        if (!$question || !$reponse1 || !$reponse2 || !$reponse3 || !$reponse4 || $bonne_reponse < 1 || $bonne_reponse > 4) {
            $erreur = 'Tous les champs de la question sont obligatoires.';
        } else {
            $pdo->prepare(
                'INSERT INTO questions (question, reponse1, reponse2, reponse3, reponse4, bonne_reponse)
                 VALUES (?, ?, ?, ?, ?, ?)'
            )->execute([$question, $reponse1, $reponse2, $reponse3, $reponse4, $bonne_reponse]);
            $succes = 'Question ajoutée avec succès.';
        }
    }

    // --- Supprimer une question ---
    elseif ($action === 'supprimer_question') {
        $id = (int)($_POST['question_id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare('DELETE FROM questions WHERE id = ?')->execute([$id]);
            $succes = 'Question supprimée.';
        }
    }

    // --- Modifier une question ---
    elseif ($action === 'modifier_question') {
        $id           = (int)($_POST['question_id'] ?? 0);
        $question     = trim($_POST['question']     ?? '');
        $reponse1     = trim($_POST['reponse1']     ?? '');
        $reponse2     = trim($_POST['reponse2']     ?? '');
        $reponse3     = trim($_POST['reponse3']     ?? '');
        $reponse4     = trim($_POST['reponse4']     ?? '');
        $bonne_reponse = (int)($_POST['bonne_reponse'] ?? 0);

        if ($id > 0 && $question && $bonne_reponse >= 1 && $bonne_reponse <= 4) {
            $pdo->prepare(
                'UPDATE questions SET question=?, reponse1=?, reponse2=?, reponse3=?, reponse4=?, bonne_reponse=?
                 WHERE id=?'
            )->execute([$question, $reponse1, $reponse2, $reponse3, $reponse4, $bonne_reponse, $id]);
            $succes = 'Question modifiée avec succès.';
        }
    }

    // --- Bloquer / débloquer un utilisateur ---
    elseif ($action === 'bloquer_utilisateur') {
        $id = (int)($_POST['user_id'] ?? 0);
        if ($id > 0 && $id !== (int)$_SESSION['user_id']) {
            // Inverser le statut bloqué
            $pdo->prepare('UPDATE utilisateurs SET bloque = 1 - bloque WHERE id = ?')->execute([$id]);
            $succes = 'Statut de l\'utilisateur mis à jour.';
        }
    }

    // --- Supprimer un utilisateur ---
    elseif ($action === 'supprimer_utilisateur') {
        $id = (int)($_POST['user_id'] ?? 0);
        if ($id > 0 && $id !== (int)$_SESSION['user_id']) {
            $pdo->prepare('DELETE FROM utilisateurs WHERE id = ?')->execute([$id]);
            $succes = 'Utilisateur supprimé.';
        }
    }

    header('Location: admin.php' . ($succes ? '?succes=1' : '?erreur=1'));
    exit;
}

// Lire les messages de la redirection
if (isset($_GET['succes'])) $succes = 'Opération effectuée avec succès.';
if (isset($_GET['erreur'])) $erreur = 'Une erreur est survenue.';

// ── Données pour l'affichage ────────────────────────────────
$questions    = $pdo->query('SELECT * FROM questions ORDER BY id ASC')->fetchAll();
$utilisateurs = $pdo->query('SELECT * FROM utilisateurs ORDER BY id ASC')->fetchAll();

$nb_utilisateurs = count($utilisateurs);
$nb_questions    = count($questions);
$nb_tentatives   = $pdo->query('SELECT COUNT(*) FROM tentatives')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Legacy QCM – Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <nav class="the_legacy_house-nav">
    <div class="nav-inner">
      <a href="index.php" class="nav-brand"><span>The Legacy</span> QCM</a>
      <div class="nav-links">
        <a href="quiz.php">QCM</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
      </div>
    </div>
  </nav>

  <div class="page-wrap fade-up">
    <h1 class="section-title"><i class="bi bi-shield-check"></i> Interface administrateur</h1>

    <?php if ($erreur): ?>
      <div class="flash flash-error"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>
    <?php if ($succes): ?>
      <div class="flash flash-success"><i class="bi bi-check-circle"></i> <?= htmlspecialchars($succes) ?></div>
    <?php endif; ?>

    <div class="dashboard-grid">
      <div class="stat-card"><div class="value"><?= $nb_utilisateurs ?></div><div class="label">Utilisateurs</div></div>
      <div class="stat-card"><div class="value"><?= $nb_questions ?></div><div class="label">Questions</div></div>
      <div class="stat-card"><div class="value"><?= $nb_tentatives ?></div><div class="label">Tentatives</div></div>
    </div>

    <!-- ── GESTION DES QUESTIONS ── -->
    <section class="admin-card">
      <div class="quiz-topbar">
        <h2 class="form-title">Gestion des questions</h2>
        <button class="btn btn-gold" onclick="document.getElementById('formAjouterQuestion').style.display='block'">
          <i class="bi bi-plus-lg"></i> Ajouter une question
        </button>
      </div>

      <!-- Formulaire d'ajout (caché par défaut) -->
      <div id="formAjouterQuestion" style="display:none; margin-bottom:1.5rem;">
        <form class="form-card" action="admin.php" method="post">
          <input type="hidden" name="action" value="ajouter_question">
          <h3 class="form-title">Nouvelle question</h3>
          <div class="form-group">
            <label>Question</label>
            <input class="form-control" type="text" name="question" required>
          </div>
          <div class="form-grid-2">
            <div class="form-group"><label>Réponse 1</label><input class="form-control" type="text" name="reponse1" required></div>
            <div class="form-group"><label>Réponse 2</label><input class="form-control" type="text" name="reponse2" required></div>
            <div class="form-group"><label>Réponse 3</label><input class="form-control" type="text" name="reponse3" required></div>
            <div class="form-group"><label>Réponse 4</label><input class="form-control" type="text" name="reponse4" required></div>
          </div>
          <div class="form-group">
            <label>Bonne réponse (1 à 4)</label>
            <select class="form-control" name="bonne_reponse" required>
              <option value="1">Réponse 1</option>
              <option value="2">Réponse 2</option>
              <option value="3">Réponse 3</option>
              <option value="4">Réponse 4</option>
            </select>
          </div>
          <div class="quiz-actions">
            <button class="btn btn-outline" type="button" onclick="document.getElementById('formAjouterQuestion').style.display='none'">Annuler</button>
            <button class="btn btn-gold" type="submit">Enregistrer</button>
          </div>
        </form>
      </div>

      <table class="admin-table">
        <thead><tr><th>ID</th><th>Question</th><th>Bonne réponse</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($questions as $q): ?>
          <tr>
            <td><?= $q['id'] ?></td>
            <td><?= htmlspecialchars(mb_strimwidth($q['question'], 0, 60, '…')) ?></td>
            <td>Réponse <?= $q['bonne_reponse'] ?></td>
            <td>
              <!-- Supprimer -->
              <form action="admin.php" method="post" style="display:inline" onsubmit="return confirm('Supprimer cette question ?')">
                <input type="hidden" name="action" value="supprimer_question">
                <input type="hidden" name="question_id" value="<?= $q['id'] ?>">
                <button class="btn-link" type="submit">Supprimer</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <!-- ── GESTION DES UTILISATEURS ── -->
    <section class="admin-card">
      <div class="quiz-topbar">
        <h2 class="form-title">Gestion des utilisateurs</h2>
      </div>
      <table class="admin-table">
        <thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($utilisateurs as $u): ?>
          <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['prenom'] . ' ' . $u['nom']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><span class="role-badge role-<?= $u['role'] === 'admin' ? 'admin' : 'member' ?>"><?= $u['role'] ?></span></td>
            <td><?= $u['bloque'] ? '<span class="role-badge" style="background:#c0392b">Bloqué</span>' : '<span class="role-badge role-member">Actif</span>' ?></td>
            <td>
              <?php if ($u['id'] !== (int)$_SESSION['user_id']): ?>
              <!-- Bloquer / Débloquer -->
              <form action="admin.php" method="post" style="display:inline">
                <input type="hidden" name="action" value="bloquer_utilisateur">
                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                <button class="btn-link" type="submit"><?= $u['bloque'] ? 'Débloquer' : 'Bloquer' ?></button>
              </form>
              ·
              <!-- Supprimer -->
              <form action="admin.php" method="post" style="display:inline" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                <input type="hidden" name="action" value="supprimer_utilisateur">
                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                <button class="btn-link" type="submit">Supprimer</button>
              </form>
              <?php else: ?>
                <span class="muted">Vous</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

  </div>

  <script src="js/main.js"></script>
</body>
</html>
