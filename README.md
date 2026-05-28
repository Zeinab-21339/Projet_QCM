# The Legacy QCM

Application web de génération et de passage de QCM, avec mécanismes anti-triche, historique des tentatives et interface d'administration.

Projet réalisé dans le cadre du module de développement web par l'équipe **The Legacy House** (groupe de 4 étudiants).

---

## Présentation

The Legacy QCM permet à des utilisateurs inscrits de passer un QCM de 10 questions tirées aléatoirement parmi une base d'environ 100 questions. À la fin du test, l'utilisateur reçoit une note sur 20, peut consulter ses erreurs et son historique de tentatives.

Un mode administrateur permet de gérer les questions et les utilisateurs (ajout, modification, suppression, blocage).

L'application met l'accent sur la lutte contre la triche : passage en plein écran obligatoire, détection de changement d'onglet, désactivation du clic droit et des raccourcis sensibles, minuterie globale.

---

## Fonctionnalités

### Utilisateur

- Inscription avec nom, prénom, email unique et mot de passe sécurisé
- Connexion / déconnexion via sessions PHP
- Tirage aléatoire de 10 questions parmi environ 100 en base
- QCM avec 4 réponses possibles et une seule bonne réponse par question
- Calcul automatique d'une note sur 20
- Affichage des erreurs avec la bonne réponse pour chaque question ratée
- Historique des tentatives et moyenne générale

### Anti-triche

- Plein écran obligatoire pendant le QCM
- Détection de sortie de plein écran et de changement d'onglet
- Système d'avertissements (2 max) avant invalidation
- Minuterie de 10 minutes maximum
- Désactivation du clic droit, des raccourcis (Ctrl+C, Ctrl+V, F12, etc.) et de la sélection de texte

### Administrateur

- Gestion des questions : ajouter, modifier, supprimer
- Gestion des utilisateurs : voir la liste, bloquer, supprimer
- Vue d'ensemble des tentatives

---

## Technologies

| Couche       | Technologies                                |
| ------------ | ------------------------------------------- |
| Frontend     | HTML5, CSS3, JavaScript (Vanilla), Bootstrap Icons |
| Backend      | PHP 8 (sans framework)                      |
| Base de données | MySQL / MariaDB (via PDO)                |
| Serveur      | Apache (XAMPP / WAMP / LAMP)                |

Conformément au cahier des charges, aucun framework PHP (Laravel, Symfony, etc.) ni CMS n'a été utilisé.

---

## Structure du projet

```
Projet_QCM_final/
│
├── index.php              Page d'accueil
├── register.php           Formulaire d'inscription
├── login.php              Formulaire de connexion
├── logout.php             Déconnexion (destruction de session)
├── quiz.php               Passage du QCM (10 questions aléatoires)
├── results.php            Affichage des résultats (note /20 + correction)
├── history.php            Historique des tentatives + moyenne
├── admin.php              Interface d'administration
│
├── config.php             Connexion PDO à la base de données
├── auth_check.php         Middleware : utilisateur connecté ?
├── auth_admin.php         Middleware : utilisateur admin ?
│
├── anticheat.js           Logique anti-triche (plein écran, timer, onglet)
│
├── css/
│   └── style.css          Feuille de style globale
│
├── js/
│   └── main.js            Scripts frontend (animations, UX)
│
├── projet_qcm.sql         Dump SQL de la base de données
│
└── README.md              Ce fichier
```

---

## Installation

### Prérequis

- PHP 8.0 ou supérieur
- MySQL 5.7 ou MariaDB
- Apache MAMP
- Un navigateur récent (Chrome ou Edge)

### Étapes

1. Copier le projet dans le dossier web de votre serveur local :

   ```
   # Sous Windows (MAMP)
   C:\mamp\htdocs\Projet_QCM_final

   # Sous Linux (LAMP)
   /var/www/html/Projet_QCM_final
   ```

2. Démarrer Apache et MySQL depuis le panneau XAMPP / WAMP.

3. Créer la base de données :
   - Ouvrir phpMyAdmin (http://localhost/phpmyadmin)
   - Créer une nouvelle base nommée `projet_qcm`
   - Importer le fichier `projet_qcm.sql` fourni à la racine du projet

4. Configurer la connexion dans `config.php` si nécessaire :

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'projet_qcm');
   define('DB_USER', 'root');     // À adapter
   define('DB_PASS', 'root');     // À adapter
   ```

5. Accéder à l'application dans le navigateur :

   ```
   http://localhost/Projet_QCM_final/index.php
   ```

---

## Utilisation

### Comptes de démonstration

Le dump SQL contient déjà quelques comptes pour tester (C'est juste des example) :

| Rôle   | Email                  | Mot de passe |
| ------ | ---------------------- | ------------ |
| Admin  | legrand@gmail.com      | legran123    |
| User   | lesli@gmail.com        | lesli123     |
| User   | berdina@gmail.com      | berdina123   |

Pour les nouveaux comptes créés via le formulaire d'inscription, les mots de passe sont hachés via `password_hash()` (bcrypt). Les comptes de démo ci-dessus sont en clair uniquement pour la phase de test.

### Parcours utilisateur

1. S'inscrire depuis la page d'accueil (`register.php`)
2. Se connecter avec ses identifiants
3. Lancer le QCM (passage automatique en plein écran)
4. Répondre aux 10 questions dans la limite des 10 minutes
5. Valider, puis consulter la page de résultats (note /20 et correction)
6. Consulter son historique et sa moyenne

### Parcours administrateur

Se connecter avec le compte admin pour accéder à l'onglet Admin dans la navbar :

- Gestion des questions : ajouter, modifier, supprimer
- Gestion des utilisateurs : bloquer, débloquer, supprimer

---

## Base de données

### Tables

| Table          | Rôle                                                                |
| -------------- | ------------------------------------------------------------------- |
| `utilisateurs` | Comptes (nom, prénom, email, mot de passe haché, rôle, statut)      |
| `questions`    | Pool de questions avec 4 réponses et l'indice de la bonne réponse   |
| `tentatives`   | Chaque passage de QCM (utilisateur, score /20, date)                |
| `reponses`     | Détail des réponses données par tentative (pour la correction)      |

### Relations

- `tentatives.utilisateur_id` référence `utilisateurs.id`
- `reponses.tentative_id` référence `tentatives.id`
- `reponses.question_id` référence `questions.id`

Toutes les contraintes utilisent `ON DELETE CASCADE` pour garantir l'intégrité référentielle.

---

## Sécurité

L'application implémente plusieurs couches de sécurité :

- Hachage des mots de passe avec `password_hash()` (bcrypt) et vérification via `password_verify()`
- Protection contre l'injection SQL : toutes les requêtes utilisent des requêtes préparées PDO avec paramètres liés
- Gestion sécurisée des sessions PHP (`session_start()`, vérification de `$_SESSION['user_id']`)
- Middlewares d'authentification (`auth_check.php`, `auth_admin.php`) pour restreindre l'accès aux pages protégées
- Validation des emails côté serveur via `filter_var()` et contrainte d'unicité en base
- Mot de passe minimum 8 caractères à l'inscription
- Compte blocable par un admin (champ `bloque` dans `utilisateurs`)

---

## Équipe - The Legacy House

Projet réalisé par un groupe de 4 étudiants, avec la répartition suivante :

| Rôle                            | Responsabilités                                                  |
| ------------------------------- | ---------------------------------------------------------------- |
| Frontend Developer (UI/UX)      | HTML, CSS, design responsive de toutes les pages                 |
| Backend Developer (PHP)         | Logique serveur, sessions, inscription, connexion, traitement du QCM |
| Database Developer (MySQL)      | Conception du schéma, tables, intégrité référentielle            |
| Security & Admin Developer      | Anti-triche, panneau admin, injection SQL, sécurité des sessions |

---

## Licence

Projet académique réalisé dans le cadre d'un module universitaire. Libre d'utilisation à des fins pédagogiques.
