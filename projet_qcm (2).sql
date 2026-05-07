-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 07 mai 2026 à 10:29
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_qcm`
--

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `reponse1` varchar(255) NOT NULL,
  `reponse2` varchar(255) NOT NULL,
  `reponse3` varchar(255) NOT NULL,
  `reponse4` varchar(255) NOT NULL,
  `bonne_reponse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `question`, `reponse1`, `reponse2`, `reponse3`, `reponse4`, `bonne_reponse`) VALUES
(1, 'Que signifie HTML ?', 'HyperText Markup Language', 'High Text Machine Language', 'HyperText Machine Link', 'High Transfer Markup Language', 1),
(2, 'Que signifie CSS ?', 'Cascading Style Sheets', 'Computer Style System', 'Cascading System Sheets', 'Color Style Sheets', 1),
(3, 'Que signifie PHP ?', 'Hypertext Preprocessor', 'Personal Home Page', 'Private Hypertext Processor', 'Public Home Page', 1),
(4, 'Que signifie SQL ?', 'Structured Query Language', 'Simple Query Language', 'Structured Question Logic', 'System Query Language', 1),
(5, 'Que signifie HTTP ?', 'HyperText Transfer Protocol', 'High Transfer Text Protocol', 'Hyper Technology Process', 'HyperText Technology Protocol', 1),
(6, 'Quel tag HTML crée un lien ?', '<a>', '<link>', '<href>', '<url>', 1),
(7, 'Quel tag HTML crée un titre principal ?', '<h1>', '<title>', '<header>', '<t1>', 1),
(8, 'Quelle propriété CSS change la couleur du texte ?', 'color', 'text-color', 'font-color', 'background-color', 1),
(9, 'Quelle propriété CSS change la taille du texte ?', 'font-size', 'text-size', 'font-weight', 'size', 1),
(10, 'Comment appelle-t-on le langage côté serveur dans ce projet ?', 'PHP', 'JavaScript', 'Python', 'Ruby', 1),
(11, 'Quel logiciel permet de gérer une base de données MySQL visuellement ?', 'phpMyAdmin', 'Visual Studio Code', 'Notepad++', 'FileZilla', 1),
(12, 'Qu\'est-ce qu\'une clé primaire en SQL ?', 'Un identifiant unique pour chaque ligne', 'Le premier champ d\'une table', 'Un mot de passe', 'Une clé de chiffrement', 1),
(13, 'Qu\'est-ce qu\'une clé étrangère en SQL ?', 'Un champ qui fait référence à une autre table', 'Un champ chiffré', 'Un identifiant unique', 'Un champ obligatoire', 1),
(14, 'Quelle commande SQL récupère des données ?', 'SELECT', 'GET', 'FETCH', 'READ', 1),
(15, 'Quelle commande SQL insère des données ?', 'INSERT INTO', 'ADD INTO', 'PUT INTO', 'PUSH INTO', 1),
(16, 'Quelle commande SQL modifie des données ?', 'UPDATE', 'MODIFY', 'CHANGE', 'EDIT', 1),
(17, 'Quelle commande SQL supprime des données ?', 'DELETE', 'REMOVE', 'DROP', 'ERASE', 1),
(18, 'Que signifie RAND() en SQL ?', 'Retourner un ordre aléatoire', 'Retourner la première ligne', 'Calculer une moyenne', 'Compter les lignes', 1),
(19, 'Comment limiter les résultats d\'une requête SQL ?', 'LIMIT', 'MAX', 'TOP', 'STOP', 1),
(20, 'Quelle est l\'extension d\'un fichier PHP ?', '.php', '.html', '.js', '.py', 1),
(21, 'Comment démarre un script PHP ?', '<?php', '<php>', '<?', '<script php>', 1),
(22, 'Comment afficher du texte en PHP ?', 'echo', 'print_text', 'display', 'show', 1),
(23, 'Que signifie $_SESSION en PHP ?', 'Une variable de session côté serveur', 'Une variable globale', 'Un cookie', 'Un tableau vide', 1),
(24, 'Que fait la fonction password_hash() en PHP ?', 'Chiffrer un mot de passe', 'Vérifier un mot de passe', 'Afficher un mot de passe', 'Supprimer un mot de passe', 1),
(25, 'Quel port utilise MySQL par défaut ?', '3306', '8080', '3000', '5432', 1),
(26, 'Que signifie AUTO_INCREMENT en SQL ?', 'Incrémenter automatiquement la valeur d\'un champ', 'Remplir automatiquement tous les champs', 'Créer une table automatiquement', 'Supprimer les doublons', 1),
(27, 'Quelle balise HTML crée un tableau ?', '<table>', '<grid>', '<tab>', '<array>', 1),
(28, 'Quelle balise HTML crée un formulaire ?', '<form>', '<input>', '<submit>', '<field>', 1),
(29, 'Que signifie URL ?', 'Uniform Resource Locator', 'Universal Resource Link', 'Unified Resource Locator', 'Uniform Remote Link', 1),
(30, 'Que signifie IP dans réseau informatique ?', 'Internet Protocol', 'Internet Process', 'Internal Protocol', 'Internet Port', 1),
(31, 'Qu\'est-ce qu\'un serveur web ?', 'Un ordinateur qui héberge des sites web', 'Un navigateur internet', 'Un câble réseau', 'Un logiciel de sécurité', 1),
(32, 'Quel navigateur web est développé par Google ?', 'Chrome', 'Firefox', 'Safari', 'Edge', 1),
(33, 'Que signifie FTP ?', 'File Transfer Protocol', 'Fast Transfer Protocol', 'File Technology Process', 'Full Transfer Protocol', 1),
(34, 'Qu\'est-ce que le responsive design ?', 'Un design qui s\'adapte à tous les écrans', 'Un design animé', 'Un design en noir et blanc', 'Un design fixe', 1),
(35, 'Que fait la balise <br> en HTML ?', 'Créer un saut de ligne', 'Mettre le texte en gras', 'Créer un lien', 'Souligner le texte', 1),
(36, 'Quelle propriété CSS centre un texte ?', 'text-align: center', 'align: center', 'center: true', 'text-center: yes', 1),
(37, 'Que signifie DOM ?', 'Document Object Model', 'Data Object Model', 'Document Open Model', 'Dynamic Object Model', 1),
(38, 'Quel langage est principalement utilisé pour rendre les pages web interactives ?', 'JavaScript', 'PHP', 'Python', 'Ruby', 1),
(39, 'Que signifie API ?', 'Application Programming Interface', 'Automatic Program Interface', 'Application Process Integration', 'Advanced Programming Interface', 1),
(40, 'Qu\'est-ce qu\'un cookie ?', 'Un petit fichier stocké dans le navigateur', 'Un type de requête SQL', 'Un élément HTML', 'Un protocole réseau', 1),
(41, 'Quelle commande SQL crée une table ?', 'CREATE TABLE', 'NEW TABLE', 'MAKE TABLE', 'BUILD TABLE', 1),
(42, 'Quelle commande SQL supprime une table ?', 'DROP TABLE', 'DELETE TABLE', 'REMOVE TABLE', 'ERASE TABLE', 1),
(43, 'Quel type SQL stocke du texte long ?', 'TEXT', 'STRING', 'LONGCHAR', 'BIGVARCHAR', 1),
(44, 'Quel type SQL stocke un nombre entier ?', 'INT', 'NUMBER', 'INTEGER', 'WHOLE', 1),
(45, 'Que signifie NOT NULL en SQL ?', 'Le champ ne peut pas être vide', 'Le champ doit être nul', 'Le champ est optionnel', 'Le champ est unique', 1),
(46, 'Quel attribut HTML rend un champ de formulaire obligatoire ?', 'required', 'mandatory', 'needed', 'obligatory', 1),
(47, 'Quelle propriété CSS change la couleur de fond ?', 'background-color', 'bg-color', 'color-bg', 'back-color', 1),
(48, 'Que signifie HTTPS ?', 'HTTP Secure', 'High Transfer Protocol Secure', 'HyperText Transfer Protocol System', 'HTTP System', 1),
(49, 'Quel symbole commence un commentaire en SQL ?', '--', '//', '##', '**', 1),
(50, 'Que fait ORDER BY en SQL ?', 'Trier les résultats', 'Filtrer les résultats', 'Grouper les résultats', 'Compter les résultats', 1),
(51, 'Quelle est la capitale de la France ?', 'Paris', 'Lyon', 'Marseille', 'Bordeaux', 1),
(52, 'Combien de jours compte une année ordinaire ?', '365', '366', '364', '360', 1),
(53, 'Quelle est la planète la plus proche du Soleil ?', 'Mercure', 'Vénus', 'Mars', 'Terre', 1),
(54, 'Combien font 15 x 15 ?', '225', '215', '235', '245', 1),
(55, 'Quelle est la langue la plus parlée dans le monde ?', 'Mandarin', 'Anglais', 'Espagnol', 'Hindi', 1),
(56, 'Quel est le plus grand océan du monde ?', 'Pacifique', 'Atlantique', 'Indien', 'Arctique', 1),
(57, 'Combien de côtés a un hexagone ?', '6', '5', '7', '8', 1),
(58, 'Quelle est la formule chimique de l\'eau ?', 'H2O', 'CO2', 'O2', 'H2O2', 1),
(59, 'Quel pays a la plus grande superficie du monde ?', 'Russie', 'Canada', 'États-Unis', 'Chine', 1),
(60, 'Combien d\'heures compte une journée ?', '24', '12', '48', '36', 1),
(61, 'Quel est le plus long fleuve du monde ?', 'Le Nil', 'L\'Amazone', 'Le Yang-Tsé', 'Le Mississippi', 1),
(62, 'Quelle est la couleur du ciel par temps clair ?', 'Bleu', 'Blanc', 'Gris', 'Jaune', 1),
(63, 'Combien de mois compte une année ?', '12', '10', '11', '13', 1),
(64, 'Quel animal est le symbole de la France ?', 'Le coq', 'Le lion', 'L\'aigle', 'Le loup', 1),
(65, 'Quelle est la vitesse de la lumière (environ) ?', '300 000 km/s', '150 000 km/s', '500 000 km/s', '100 000 km/s', 1),
(66, 'Quelle est la capitale de l\'Espagne ?', 'Madrid', 'Barcelone', 'Séville', 'Valence', 1),
(67, 'Combien font 100 divisé par 4 ?', '25', '20', '30', '40', 1),
(68, 'Quel est le métal le plus léger ?', 'Lithium', 'Aluminium', 'Fer', 'Cuivre', 1),
(69, 'Combien de continents y a-t-il sur Terre ?', '7', '5', '6', '8', 1),
(70, 'Quel est le plus petit pays du monde ?', 'Vatican', 'Monaco', 'Saint-Marin', 'Liechtenstein', 1),
(71, 'Quelle planète est connue comme la planète rouge ?', 'Mars', 'Jupiter', 'Saturne', 'Vénus', 1),
(72, 'Combien de secondes dans une minute ?', '60', '100', '30', '120', 1),
(73, 'Quelle est la capitale de l\'Allemagne ?', 'Berlin', 'Munich', 'Hambourg', 'Francfort', 1),
(74, 'Quel est le plus haut sommet du monde ?', 'L\'Everest', 'Le K2', 'Le Mont-Blanc', 'Le Kilimandjaro', 1),
(75, 'Combien font 7 x 8 ?', '56', '54', '58', '48', 1),
(76, 'Quelle est la capitale du Japon ?', 'Tokyo', 'Osaka', 'Kyoto', 'Hiroshima', 1),
(77, 'Quel gaz respirons-nous principalement ?', 'Azote', 'Oxygène', 'Dioxyde de carbone', 'Hydrogène', 1),
(78, 'Combien de faces a un cube ?', '6', '4', '8', '12', 1),
(79, 'Quelle est la monnaie utilisée en France ?', 'Euro', 'Franc', 'Dollar', 'Livre', 1),
(80, 'Quel est le sens de circulation en France ?', 'À droite', 'À gauche', 'Au centre', 'Variable', 1),
(81, 'Combien de joueurs dans une équipe de football ?', '11', '10', '12', '9', 1),
(82, 'Quelle est la capitale du Royaume-Uni ?', 'Londres', 'Manchester', 'Birmingham', 'Liverpool', 1),
(83, 'Quel instrument mesure la température ?', 'Thermomètre', 'Baromètre', 'Hygromètre', 'Altimètre', 1),
(84, 'Combien font 9 x 9 ?', '81', '72', '90', '63', 1),
(85, 'Quel est le continent le plus chaud ?', 'Afrique', 'Asie', 'Amérique du Sud', 'Océanie', 1),
(86, 'Quelle est la capitale de l\'Italie ?', 'Rome', 'Milan', 'Naples', 'Florence', 1),
(87, 'Combien de grammes dans un kilogramme ?', '1000', '100', '500', '10000', 1),
(88, 'Quel est le contraire de jour ?', 'Nuit', 'Matin', 'Soir', 'Midi', 1),
(89, 'Combien de minutes dans une heure ?', '60', '100', '90', '45', 1),
(90, 'Quel est l\'organe principal qui pompe le sang ?', 'Le coeur', 'Le foie', 'Les poumons', 'Le cerveau', 1),
(91, 'Quelle est la capitale du Maroc ?', 'Rabat', 'Casablanca', 'Marrakech', 'Fès', 1),
(92, 'Combien de couleurs dans un arc-en-ciel ?', '7', '6', '5', '8', 1),
(93, 'Quel est le plus grand désert du monde ?', 'Sahara', 'Gobi', 'Atacama', 'Kalahari', 1),
(94, 'Combien font 50 + 50 ?', '100', '90', '110', '150', 1),
(95, 'Quelle est la capitale du Brésil ?', 'Brasilia', 'Rio de Janeiro', 'São Paulo', 'Salvador', 1),
(96, 'Quel est le symbole chimique de l\'or ?', 'Au', 'Or', 'Go', 'Ag', 1),
(97, 'Combien de doigts a une main humaine ?', '5', '4', '6', '10', 1),
(98, 'Quelle est la capitale de la Chine ?', 'Pékin', 'Shanghai', 'Hong Kong', 'Canton', 1),
(99, 'Quel sport se joue avec une raquette et un volant ?', 'Badminton', 'Tennis', 'Squash', 'Ping-pong', 1),
(100, 'Combien de jours en février lors d\'une année bissextile ?', '29', '28', '30', '31', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

CREATE TABLE `reponses` (
  `id` int(11) NOT NULL,
  `tentative_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `reponse_utilisateur` int(11) NOT NULL,
  `correcte` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tentatives`
--

CREATE TABLE `tentatives` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `score` float NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tentatives`
--

INSERT INTO `tentatives` (`id`, `utilisateur_id`, `score`, `date`) VALUES
(1, 2, 14, '2026-05-07 11:52:57');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `bloque` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `bloque`) VALUES
(1, 'legran', 'Eloundou', 'legrand@gmail.com', 'legran123', 'admin', 0),
(2, 'lesli', 'Kemajou', 'lesli@gmail.com', 'lesli123', 'user', 0),
(3, 'berdina', 'sita', 'berdina@gmail.com', 'berdina123', 'user', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tentative_id` (`tentative_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Index pour la table `tentatives`
--
ALTER TABLE `tentatives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tentatives_ibfk_1` (`utilisateur_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT pour la table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tentatives`
--
ALTER TABLE `tentatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_ibfk_1` FOREIGN KEY (`tentative_id`) REFERENCES `tentatives` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reponses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tentatives`
--
ALTER TABLE `tentatives`
  ADD CONSTRAINT `tentatives_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
