-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 07 nov. 2022 à 07:20
-- Version du serveur : 8.0.27
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `api-bilemo`
--

-- --------------------------------------------------------

--
-- Structure de la table `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Google');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C7440455E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `email`, `roles`, `password`, `created_at`) VALUES
(1, 'employee@company.com', '[\"ROLE_USER\"]', '$2y$13$bPqlP9xKtTHuq8vNgQvLHO/4xZcpXhVtZJUCrDtSCpOOiQjiNkiqS', '2020-04-30 13:38:26'),
(2, 'another-client@company.com', '[\"ROLE_USER\"]', '$2y$13$58nQ3g7hzrGijYWaDs5vauUGuvGgFKX3iM1NzcIVOmamJO1DGghZW', '2022-08-23 19:30:18'),
(3, 'admin@company.com', '[\"ROLE_ADMIN\"]', '$2y$13$9q2HTIfC5MtDjHjWUFvuSuiwG52j6gPquGFacwctVaGNqZDmTyA3a', '2020-09-04 21:42:39');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand_id` int NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD44F5D008` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `brand_id`, `model`, `price`, `description`, `image_path`) VALUES
(1, 1, 'Iphone11', 115900, 'Tempore molestiae iste impedit aperiam hic fugiat. Omnis dolores exercitationem eveniet omnis culpa id consectetur doloremque. Vitae vitae laborum est quaerat beatae ratione veritatis.\n\nA aut nulla voluptatem animi id sint. Dicta dolores sunt sit omnis quaerat sed. Nostrum ab est numquam et molestias autem.', 'https://place-hold.it/300x500?text=Iphone11&fontsize=23'),
(2, 1, 'Iphone12', 115900, 'Architecto laudantium sint aut maxime sit. Minima nemo sequi repudiandae quia sit ipsum occaecati. Saepe tenetur inventore et eaque.\n\nAut ut officiis vel. Corporis reprehenderit enim sunt et qui voluptatibus. Ut aut cupiditate quo dolor debitis voluptate itaque aperiam.', 'https://place-hold.it/300x500?text=Iphone12&fontsize=23'),
(3, 1, 'Iphone13', 115900, 'Magni sit dolorem consequuntur itaque sit. Sint excepturi quam similique adipisci. Nesciunt tenetur cumque eius veniam dignissimos.\n\nModi incidunt nostrum voluptas corrupti enim. Illo aliquam aspernatur consequatur facilis. Iure laboriosam autem animi nostrum atque est.', 'https://place-hold.it/300x500?text=Iphone13&fontsize=23'),
(4, 1, 'Iphone14', 115900, 'Molestiae voluptatum occaecati ratione et est rem dolorem. Eum libero sunt quia voluptas. Qui voluptate eum distinctio quia.\n\nAmet laboriosam sed tempore cupiditate consequatur omnis. Et accusamus quia est. Unde voluptas aliquam perferendis aut et voluptas fugiat.', 'https://place-hold.it/300x500?text=Iphone14&fontsize=23'),
(5, 3, 'Pixel 6a', 115900, 'Impedit quasi molestias aspernatur sit excepturi. Accusamus autem dolores voluptatem corrupti odio quis sit. Quia commodi atque sed explicabo.\n\nAut quae quo temporibus est enim reprehenderit perferendis. Doloribus labore modi animi iure itaque inventore. Consequuntur expedita omnis dignissimos ad.', 'https://place-hold.it/300x500?text=Pixel 6a&fontsize=23'),
(6, 3, 'Pixel 7', 115900, 'Error aut placeat et. Inventore quis voluptate voluptatem itaque aliquid blanditiis.\n\nLabore libero voluptatem quasi explicabo dolor vel dignissimos. Voluptas voluptatem a sit aut earum quae. Quos est distinctio in omnis est ea veritatis. Vitae ut numquam repudiandae culpa illum.', 'https://place-hold.it/300x500?text=Pixel 7&fontsize=23'),
(7, 3, 'Pixel 7Pro', 115900, 'At omnis nam quae neque enim qui. Assumenda dolores et ut molestias. Dolores optio tempora deserunt id quia labore deleniti eum. Amet accusantium dolorum a at voluptatibus maxime.\n\nPlaceat voluptatem quam omnis eveniet non laborum ex. Rerum atque ipsa perspiciatis quia ut aut recusandae. Et ipsam quos exercitationem dolorem minima eum ducimus quasi.', 'https://place-hold.it/300x500?text=Pixel 7Pro&fontsize=23'),
(8, 2, 'GalaxyS22', 115900, 'Ex nihil at voluptas corrupti aut. Eos eaque veritatis est similique. Ducimus sit quos ut eaque voluptatem. Dolor expedita hic dicta laborum dignissimos et. Quibusdam ut nihil id dolores aut blanditiis.\n\nSaepe autem rerum iure dolore temporibus odio. Eveniet quia blanditiis in recusandae ut. Placeat quasi necessitatibus beatae omnis molestias qui.', 'https://place-hold.it/300x500?text=GalaxyS22&fontsize=23');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_8D93D64919EB6921` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `client_id`, `username`, `email`, `created_at`) VALUES
(1, 1, 'Étienne Gregoire-Hamon', 'frederic.aubry@blanc.com', '2021-04-05 06:29:54'),
(2, 1, 'Océane Pages', 'marthe23@ferrand.com', '2021-06-11 05:34:21'),
(3, 1, 'Paulette Le Colas', 'rocher.suzanne@pottier.fr', '2020-10-14 06:43:16'),
(4, 1, 'Élisabeth Remy', 'leroux.zacharie@lebon.fr', '2020-12-03 05:33:19'),
(5, 1, 'Audrey Berger', 'monique.maillard@reynaud.org', '2022-06-30 05:48:15'),
(6, 1, 'Thibaut Auger-Dumont', 'therese.perez@benard.com', '2020-11-22 05:14:43'),
(7, 1, 'Caroline Labbe', 'gomez.elodie@devaux.fr', '2020-04-29 08:43:47'),
(8, 1, 'Tristan De Oliveira-Barthelemy', 'thomas87@weiss.com', '2021-01-10 07:53:55'),
(9, 1, 'Laurent Le Gall', 'maillot.susan@faure.com', '2020-12-31 00:33:23'),
(10, 1, 'Timothée Techer', 'david.lombard@duhamel.com', '2022-06-17 01:17:20'),
(11, 1, 'Dominique-Dorothée Baudry', 'monique.humbert@guibert.fr', '2021-02-10 09:35:45'),
(12, 1, 'Maurice Bazin', 'dominique21@buisson.fr', '2020-03-21 11:18:08'),
(13, 1, 'Michelle Bailly', 'rdufour@pinto.org', '2022-02-20 07:13:22'),
(14, 1, 'Marguerite Neveu-Guillot', 'samson.camille@laroche.com', '2020-01-10 19:11:00'),
(15, 1, 'Marguerite Le Gall', 'susanne.bertrand@goncalves.com', '2022-11-04 00:53:43'),
(16, 1, 'Roger Pichon', 'gomes.aurore@martineau.net', '2020-11-01 09:44:55'),
(17, 1, 'Frédérique Girard', 'colas.josephine@daniel.com', '2020-01-12 08:19:30'),
(18, 1, 'Adélaïde Coulon-Laroche', 'pmoreau@marechal.com', '2022-07-14 06:27:28'),
(19, 1, 'Adrienne Blanchard', 'josephine01@rousset.com', '2021-01-12 23:54:32'),
(20, 1, 'Marianne Colas', 'nicolas07@petit.fr', '2022-01-11 09:14:53'),
(21, 1, 'Valérie Bigot', 'alexandria72@bailly.com', '2022-03-22 21:11:01'),
(22, 1, 'Adélaïde Roche', 'cregnier@fernandes.com', '2021-02-06 08:49:05'),
(23, 1, 'Valentine Camus', 'philippe22@fouquet.org', '2020-11-29 16:55:15'),
(24, 1, 'Maryse Michaud', 'stephane34@guillet.net', '2021-01-11 08:37:07'),
(25, 1, 'Gilbert Alexandre', 'honore60@masson.fr', '2021-04-06 19:31:40'),
(26, 1, 'Margaud Vincent', 'rsimon@lebreton.com', '2022-12-18 02:52:03'),
(27, 1, 'Luc Salmon', 'gvallee@joseph.com', '2021-07-12 16:54:54'),
(28, 1, 'Luc Wagner', 'emmanuelle.moulin@delannoy.net', '2021-09-07 19:07:59'),
(29, 1, 'Roland Launay', 'virginie.albert@renault.com', '2022-10-03 19:24:46'),
(30, 1, 'Michelle Julien', 'mguerin@hardy.fr', '2020-01-03 20:20:40'),
(31, 1, 'Jeannine Rousset', 'auguste.merle@dupuy.com', '2020-07-30 13:22:18'),
(32, 1, 'Agnès Perez', 'rtoussaint@thomas.fr', '2022-06-17 21:13:34'),
(33, 1, 'Frédéric Hubert', 'nmonnier@boulanger.com', '2021-05-10 03:21:38'),
(34, 1, 'Alexandrie Duval', 'richard77@chretien.fr', '2021-09-26 09:06:36'),
(35, 1, 'François Boucher', 'louis94@charrier.org', '2021-12-02 16:57:00'),
(36, 1, 'Margaret Etienne', 'antoinette.gillet@laine.fr', '2022-01-18 16:10:32'),
(37, 1, 'Hortense-Nicole Moulin', 'claude01@barre.com', '2021-05-30 18:24:25'),
(38, 1, 'Maurice Martin', 'josette01@perez.fr', '2020-11-28 03:39:19'),
(39, 1, 'Maurice Morel', 'georges.pruvost@pruvost.com', '2021-07-24 16:54:54'),
(40, 1, 'Laurent Goncalves', 'pottier.olivier@fouquet.fr', '2020-06-29 07:07:19');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD44F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64919EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
