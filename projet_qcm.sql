-- ============================================================
--  projet_qcm.sql  –  Import complet pour phpMyAdmin
--  Crée la base, les tables, les contraintes et les données.
--
--  IMPORT : dans phpMyAdmin, onglet "Importer" → choisir ce
--  fichier → "Exécuter". (Inutile de créer la base à la main,
--  ce script s'en charge.)
--
--  Comptes de test :
--    admin : legrand@gmail.com / legran123
--    user  : lesli@gmail.com   / lesli123
--    user  : berdina@gmail.com / berdina123
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --- Base de données ---------------------------------------
CREATE DATABASE IF NOT EXISTS `projet_qcm`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `projet_qcm`;

-- On repart proprement (utile si on réimporte)
DROP TABLE IF EXISTS `reponses`;
DROP TABLE IF EXISTS `tentatives`;
DROP TABLE IF EXISTS `questions`;
DROP TABLE IF EXISTS `utilisateurs`;

-- ============================================================
--  Table : utilisateurs
-- ============================================================
CREATE TABLE `utilisateurs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `mot_de_passe` VARCHAR(255) NOT NULL,
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  `bloque` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `bloque`) VALUES
(1, 'Eloundou', 'legran', 'legrand@gmail.com', '$2y$10$xuROylju4ljcFIaKtzIqked9kVf0SLastW2BspSd2U7rOOfDhIk.e', 'admin', 0),
(2, 'Kemajou', 'lesli', 'lesli@gmail.com', '$2y$10$8/mHGj1JQHRGaS3/nUdbD.IqLtwEPEN8IAWVTZAugPQq9unstufPq', 'user', 0),
(3, 'sita', 'berdina', 'berdina@gmail.com', '$2y$10$3LudsYJ24TDgrhQL/5kdJemQ8UruHf7.sf4G5alv6nSKRAhXbg7Ae', 'user', 0);

-- ============================================================
--  Table : questions
-- ============================================================
CREATE TABLE `questions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `question` TEXT NOT NULL,
  `reponse1` VARCHAR(255) NOT NULL,
  `reponse2` VARCHAR(255) NOT NULL,
  `reponse3` VARCHAR(255) NOT NULL,
  `reponse4` VARCHAR(255) NOT NULL,
  `bonne_reponse` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `questions` (`id`, `question`, `reponse1`, `reponse2`, `reponse3`, `reponse4`, `bonne_reponse`) VALUES
(1, 'Que signifie HTML ?', 'HyperText Machine Link', 'High Text Machine Language', 'High Transfer Markup Language', 'HyperText Markup Language', 4),
(2, 'Que signifie CSS ?', 'Color Style Sheets', 'Cascading System Sheets', 'Cascading Style Sheets', 'Computer Style System', 3),
(3, 'Que signifie PHP ?', 'Personal Home Page', 'Public Home Page', 'Private Hypertext Processor', 'Hypertext Preprocessor', 4),
(4, 'Que signifie SQL ?', 'Simple Query Language', 'Structured Question Logic', 'Structured Query Language', 'System Query Language', 3),
(5, 'Que signifie HTTP ?', 'High Transfer Text Protocol', 'Hyper Technology Process', 'HyperText Technology Protocol', 'HyperText Transfer Protocol', 4),
(6, 'Quel tag HTML crée un lien ?', '<link>', '<url>', '<href>', '<a>', 4),
(7, 'Quel tag HTML crée un titre principal ?', '<header>', '<title>', '<h1>', '<t1>', 3),
(8, 'Quelle propriété CSS change la couleur du texte ?', 'text-color', 'background-color', 'color', 'font-color', 3),
(9, 'Quelle propriété CSS change la taille du texte ?', 'font-size', 'font-weight', 'text-size', 'size', 1),
(10, 'Comment appelle-t-on le langage côté serveur dans ce projet ?', 'Python', 'Ruby', 'PHP', 'JavaScript', 3),
(11, 'Quel logiciel permet de gérer une base de données MySQL visuellement ?', 'Notepad++', 'Visual Studio Code', 'FileZilla', 'phpMyAdmin', 4),
(12, 'Qu\\\'est-ce qu\\\'une clé primaire en SQL ?', 'Une clé de chiffrement', 'Un mot de passe', 'Le premier champ d\\\'une table', 'Un identifiant unique pour chaque ligne', 4),
(13, 'Qu\\\'est-ce qu\\\'une clé étrangère en SQL ?', 'Un champ obligatoire', 'Un champ chiffré', 'Un champ qui fait référence à une autre table', 'Un identifiant unique', 3),
(14, 'Quelle commande SQL récupère des données ?', 'FETCH', 'READ', 'GET', 'SELECT', 4),
(15, 'Quelle commande SQL insère des données ?', 'INSERT INTO', 'ADD INTO', 'PUSH INTO', 'PUT INTO', 1),
(16, 'Quelle commande SQL modifie des données ?', 'EDIT', 'UPDATE', 'CHANGE', 'MODIFY', 2),
(17, 'Quelle commande SQL supprime des données ?', 'REMOVE', 'ERASE', 'DROP', 'DELETE', 4),
(18, 'Que signifie RAND() en SQL ?', 'Retourner la première ligne', 'Compter les lignes', 'Retourner un ordre aléatoire', 'Calculer une moyenne', 3),
(19, 'Comment limiter les résultats d\\\'une requête SQL ?', 'STOP', 'TOP', 'MAX', 'LIMIT', 4),
(20, 'Quelle est l\\\'extension d\\\'un fichier PHP ?', '.php', '.html', '.js', '.py', 1),
(21, 'Comment démarre un script PHP ?', '<?php', '<?', '<script php>', '<php>', 1),
(22, 'Comment afficher du texte en PHP ?', 'echo', 'show', 'display', 'print_text', 1),
(23, 'Que signifie $_SESSION en PHP ?', 'Une variable globale', 'Un tableau vide', 'Un cookie', 'Une variable de session côté serveur', 4),
(24, 'Que fait la fonction password_hash() en PHP ?', 'Afficher un mot de passe', 'Supprimer un mot de passe', 'Chiffrer un mot de passe', 'Vérifier un mot de passe', 3),
(25, 'Quel port utilise MySQL par défaut ?', '3000', '3306', '8080', '5432', 2),
(26, 'Que signifie AUTO_INCREMENT en SQL ?', 'Remplir automatiquement tous les champs', 'Supprimer les doublons', 'Incrémenter automatiquement la valeur d\\\'un champ', 'Créer une table automatiquement', 3),
(27, 'Quelle balise HTML crée un tableau ?', '<array>', '<tab>', '<grid>', '<table>', 4),
(28, 'Quelle balise HTML crée un formulaire ?', '<input>', '<field>', '<form>', '<submit>', 3),
(29, 'Que signifie URL ?', 'Uniform Remote Link', 'Universal Resource Link', 'Uniform Resource Locator', 'Unified Resource Locator', 3),
(30, 'Que signifie IP dans réseau informatique ?', 'Internet Protocol', 'Internet Process', 'Internal Protocol', 'Internet Port', 1),
(31, 'Qu\\\'est-ce qu\\\'un serveur web ?', 'Un câble réseau', 'Un ordinateur qui héberge des sites web', 'Un logiciel de sécurité', 'Un navigateur internet', 2),
(32, 'Quel navigateur web est développé par Google ?', 'Chrome', 'Edge', 'Safari', 'Firefox', 1),
(33, 'Que signifie FTP ?', 'File Transfer Protocol', 'Fast Transfer Protocol', 'File Technology Process', 'Full Transfer Protocol', 1),
(34, 'Qu\\\'est-ce que le responsive design ?', 'Un design animé', 'Un design fixe', 'Un design qui s\\\'adapte à tous les écrans', 'Un design en noir et blanc', 3),
(35, 'Que fait la balise <br> en HTML ?', 'Mettre le texte en gras', 'Créer un lien', 'Créer un saut de ligne', 'Souligner le texte', 3),
(36, 'Quelle propriété CSS centre un texte ?', 'align: center', 'center: true', 'text-center: yes', 'text-align: center', 4),
(37, 'Que signifie DOM ?', 'Data Object Model', 'Document Object Model', 'Document Open Model', 'Dynamic Object Model', 2),
(38, 'Quel langage est principalement utilisé pour rendre les pages web interactives ?', 'JavaScript', 'Python', 'PHP', 'Ruby', 1),
(39, 'Que signifie API ?', 'Automatic Program Interface', 'Application Programming Interface', 'Advanced Programming Interface', 'Application Process Integration', 2),
(40, 'Qu\\\'est-ce qu\\\'un cookie ?', 'Un protocole réseau', 'Un type de requête SQL', 'Un élément HTML', 'Un petit fichier stocké dans le navigateur', 4),
(41, 'Quelle commande SQL crée une table ?', 'BUILD TABLE', 'NEW TABLE', 'CREATE TABLE', 'MAKE TABLE', 3),
(42, 'Quelle commande SQL supprime une table ?', 'REMOVE TABLE', 'DELETE TABLE', 'DROP TABLE', 'ERASE TABLE', 3),
(43, 'Quel type SQL stocke du texte long ?', 'BIGVARCHAR', 'STRING', 'LONGCHAR', 'TEXT', 4),
(44, 'Quel type SQL stocke un nombre entier ?', 'WHOLE', 'INT', 'INTEGER', 'NUMBER', 2),
(45, 'Que signifie NOT NULL en SQL ?', 'Le champ doit être nul', 'Le champ ne peut pas être vide', 'Le champ est unique', 'Le champ est optionnel', 2),
(46, 'Quel attribut HTML rend un champ de formulaire obligatoire ?', 'needed', 'required', 'obligatory', 'mandatory', 2),
(47, 'Quelle propriété CSS change la couleur de fond ?', 'back-color', 'bg-color', 'color-bg', 'background-color', 4),
(48, 'Que signifie HTTPS ?', 'High Transfer Protocol Secure', 'HyperText Transfer Protocol System', 'HTTP Secure', 'HTTP System', 3),
(49, 'Quel symbole commence un commentaire en SQL ?', '**', '--', '//', '##', 2),
(50, 'Que fait ORDER BY en SQL ?', 'Filtrer les résultats', 'Grouper les résultats', 'Compter les résultats', 'Trier les résultats', 4),
(51, 'Quelle est la capitale de la France ?', 'Bordeaux', 'Lyon', 'Marseille', 'Paris', 4),
(52, 'Combien de jours compte une année ordinaire ?', '366', '360', '364', '365', 4),
(53, 'Quelle est la planète la plus proche du Soleil ?', 'Mercure', 'Terre', 'Mars', 'Vénus', 1),
(54, 'Combien font 15 x 15 ?', '225', '235', '245', '215', 1),
(55, 'Quelle est la langue la plus parlée dans le monde ?', 'Hindi', 'Mandarin', 'Espagnol', 'Anglais', 2),
(56, 'Quel est le plus grand océan du monde ?', 'Pacifique', 'Arctique', 'Atlantique', 'Indien', 1),
(57, 'Combien de côtés a un hexagone ?', '6', '5', '7', '8', 1),
(58, 'Quelle est la formule chimique de l\\\'eau ?', 'CO2', 'O2', 'H2O2', 'H2O', 4),
(59, 'Quel pays a la plus grande superficie du monde ?', 'États-Unis', 'Chine', 'Canada', 'Russie', 4),
(60, 'Combien d\\\'heures compte une journée ?', '36', '24', '48', '12', 2),
(61, 'Quel est le plus long fleuve du monde ?', 'L\\\'Amazone', 'Le Yang-Tsé', 'Le Mississippi', 'Le Nil', 4),
(62, 'Quelle est la couleur du ciel par temps clair ?', 'Jaune', 'Gris', 'Bleu', 'Blanc', 3),
(63, 'Combien de mois compte une année ?', '10', '13', '12', '11', 3),
(64, 'Quel animal est le symbole de la France ?', 'Le coq', 'Le lion', 'Le loup', 'L\\\'aigle', 1),
(65, 'Quelle est la vitesse de la lumière (environ) ?', '100 000 km/s', '300 000 km/s', '500 000 km/s', '150 000 km/s', 2),
(66, 'Quelle est la capitale de l\\\'Espagne ?', 'Séville', 'Barcelone', 'Madrid', 'Valence', 3),
(67, 'Combien font 100 divisé par 4 ?', '20', '30', '25', '40', 3),
(68, 'Quel est le métal le plus léger ?', 'Cuivre', 'Aluminium', 'Fer', 'Lithium', 4),
(69, 'Combien de continents y a-t-il sur Terre ?', '7', '8', '5', '6', 1),
(70, 'Quel est le plus petit pays du monde ?', 'Monaco', 'Vatican', 'Saint-Marin', 'Liechtenstein', 2),
(71, 'Quelle planète est connue comme la planète rouge ?', 'Saturne', 'Jupiter', 'Vénus', 'Mars', 4),
(72, 'Combien de secondes dans une minute ?', '100', '120', '60', '30', 3),
(73, 'Quelle est la capitale de l\\\'Allemagne ?', 'Hambourg', 'Francfort', 'Berlin', 'Munich', 3),
(74, 'Quel est le plus haut sommet du monde ?', 'Le Mont-Blanc', 'L\\\'Everest', 'Le Kilimandjaro', 'Le K2', 2),
(75, 'Combien font 7 x 8 ?', '48', '56', '54', '58', 2),
(76, 'Quelle est la capitale du Japon ?', 'Kyoto', 'Hiroshima', 'Osaka', 'Tokyo', 4),
(77, 'Quel gaz respirons-nous principalement ?', 'Oxygène', 'Hydrogène', 'Dioxyde de carbone', 'Azote', 4),
(78, 'Combien de faces a un cube ?', '4', '8', '12', '6', 4),
(79, 'Quelle est la monnaie utilisée en France ?', 'Euro', 'Dollar', 'Franc', 'Livre', 1),
(80, 'Quel est le sens de circulation en France ?', 'Au centre', 'À droite', 'Variable', 'À gauche', 2),
(81, 'Combien de joueurs dans une équipe de football ?', '12', '11', '9', '10', 2),
(82, 'Quelle est la capitale du Royaume-Uni ?', 'Londres', 'Birmingham', 'Manchester', 'Liverpool', 1),
(83, 'Quel instrument mesure la température ?', 'Thermomètre', 'Altimètre', 'Baromètre', 'Hygromètre', 1),
(84, 'Combien font 9 x 9 ?', '90', '63', '81', '72', 3),
(85, 'Quel est le continent le plus chaud ?', 'Océanie', 'Amérique du Sud', 'Afrique', 'Asie', 3),
(86, 'Quelle est la capitale de l\\\'Italie ?', 'Milan', 'Florence', 'Rome', 'Naples', 3),
(87, 'Combien de grammes dans un kilogramme ?', '100', '1000', '500', '10000', 2),
(88, 'Quel est le contraire de jour ?', 'Matin', 'Midi', 'Soir', 'Nuit', 4),
(89, 'Combien de minutes dans une heure ?', '45', '90', '60', '100', 3),
(90, 'Quel est l\\\'organe principal qui pompe le sang ?', 'Les poumons', 'Le coeur', 'Le cerveau', 'Le foie', 2),
(91, 'Quelle est la capitale du Maroc ?', 'Fès', 'Rabat', 'Marrakech', 'Casablanca', 2),
(92, 'Combien de couleurs dans un arc-en-ciel ?', '8', '5', '6', '7', 4),
(93, 'Quel est le plus grand désert du monde ?', 'Kalahari', 'Gobi', 'Sahara', 'Atacama', 3),
(94, 'Combien font 50 + 50 ?', '100', '110', '150', '90', 1),
(95, 'Quelle est la capitale du Brésil ?', 'Brasilia', 'Salvador', 'São Paulo', 'Rio de Janeiro', 1),
(96, 'Quel est le symbole chimique de l\\\'or ?', 'Go', 'Au', 'Or', 'Ag', 2),
(97, 'Combien de doigts a une main humaine ?', '6', '10', '4', '5', 4),
(98, 'Quelle est la capitale de la Chine ?', 'Shanghai', 'Canton', 'Hong Kong', 'Pékin', 4),
(99, 'Quel sport se joue avec une raquette et un volant ?', 'Ping-pong', 'Tennis', 'Badminton', 'Squash', 3),
(100, 'Combien de jours en février lors d\\\'une année bissextile ?', '30', '28', '31', '29', 4);

-- ============================================================
--  Table : tentatives
-- ============================================================
CREATE TABLE `tentatives` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` INT(11) NOT NULL,
  `score` FLOAT NOT NULL,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  CONSTRAINT `fk_tentatives_user`
    FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  Table : reponses
-- ============================================================
CREATE TABLE `reponses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tentative_id` INT(11) NOT NULL,
  `question_id` INT(11) NOT NULL,
  `reponse_utilisateur` INT(11) NOT NULL,
  `correcte` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tentative_id` (`tentative_id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `fk_reponses_tentative`
    FOREIGN KEY (`tentative_id`) REFERENCES `tentatives` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_reponses_question`
    FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
-- Fin du script
