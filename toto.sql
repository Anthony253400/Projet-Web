-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2025 at 08:15 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toto`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id_art` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` float NOT NULL,
  `url_photo` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `id_stripe` varchar(100) NOT NULL,
  `id_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id_art`, `nom`, `quantite`, `prix`, `url_photo`, `description`, `id_stripe`, `id_price`) VALUES
(1, 'T-shirt', 0, 19.99, 'images/T-shirt/gray.png', 'T-shirt moderne et confortable, conçu en coton doux pour un style décontracté au quotidien. Conçue en France', 'prod_TNaA8wkqj15QrX', 'price_1SQoziG6nN7oEHxoB7yRNyeE'),
(2, 'Tasse', 0, 10.99, 'images/Tasse/red.png', 'Tasse élégante et pratique, idéale pour savourer café, thé ou chocolat chaud à tout moment.', 'prod_TNaF588x3t7s85', 'price_1SQp4dG6nN7oEHxoKVoSO80I'),
(3, 'USB', 0, 5.99, 'images/USB/green.png', 'Clé USB compacte et fiable, idéale pour stocker et transporter vos fichiers en toute sécurité (4GB de stockage).', 'prod_TNaFsF2hnehKip', 'price_1SQp58G6nN7oEHxo71iBBRit'),
(4, 'Gourde', 50, 14.99, 'images/Gourde/gray.png', 'Gourde en acier inoxydable isotherme - 750 ml', 'prod_TNaG7hT9njBTtK', 'price_1SQp5lG6nN7oEHxoDyyrlz5G'),
(5, 'casquette', 10, 10, 'images/Casquette/gray.png', 'Casquette personalisée TOTO !! ', 'prod_TNaGreUg5jGQlg', 'price_1SQp6BG6nN7oEHxofGA1Qvq2'),
(6, 'Autocollant', 487, 1.9, 'images/Autocolant/Autocollant.png', 'wow', 'prod_TS5Nns5PqxDHTL', 'price_1SVBCsG6nN7oEHxo5VbkWZZr'),
(7, 'Image suspecte', 1, 1, 'images/image_suspecte/image_suspecte.png', 'Cette image semble suspecte ??', 'prod_TRqx17zPtzxNN4', 'price_1SUxFFG6nN7oEHxo55wE0D76'),
(8, 'Coque de téléphone', 29, 10, 'images/coque/coque.png', 'coque résistante', 'prod_TbYlatYihijrs0', 'price_1SeLePG6nN7oEHxoVkC8k31A');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` text NOT NULL,
  `numero` varchar(15) DEFAULT NULL,
  `mail` varchar(100) NOT NULL,
  `mdp` varchar(200) NOT NULL,
  `id_client_stripe` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `prenom`, `adresse`, `numero`, `mail`, `mdp`, `id_client_stripe`) VALUES
(6, 'valentin', 'nina', '90 chemin de Sommières', '64705', 'ndavalentin', '$2y$10$jrLHskujCYzTGPKHAR8CFO2lIxqaJZ3rr.MpPntixwMHVwM99uEYi', ''),
(7, 'atk', 'zakut', 'azkut', '0', 'az:oy', '$2y$10$hTYyrhWzqjwFIFwMEz6axeGZ3RmvY7fCxRKzjjH3m0eO6ywBonQHa', ''),
(8, 'a', 'a', 'a', '2', 'a', '$2y$10$hXbPYVYf2GZxJZjgmfgukOEghRJoJ3vaWyqKEaMKbHlA3cvC9Vzf.', 'cus_TNaJzdCBpBa1d6'),
(10, 'CROENNE', 'Victor', '120 rue du Général de Gaulle', '647258956', 'victor.croenne16@gmail.com', '$2y$10$0ywZsmkH3kEqDyEYrYLsBeypAlVE8n/YwoSByvQ.IcsQwmB0olwyC', ''),
(11, 'dachez', 'sidney', 'Montpellier', '768410047', 'sidsmog@gmail.com', '$2y$10$RrvyKOtmr.i4ZaE.jkllBuPiMuGPbzTcPXy5XqXH.FSVwLS7z.1a.', ''),
(16, 'null', 'null', 'null', '1', 'null', '$2y$10$IERb57F0SP8UGAuWB.feuOPJ8XczHOzLW5AqkfEaXBINh.EkghNDa', ''),
(18, 'a', 'a', 'a', '0', 'a@a.a', '$2y$10$WGiQDY5pd91yBb7M1l4cVuVnrzDg2dXWsq7znuc.W6C4pEsupTTmm', ''),
(19, 'a', 'a', 'a', '7777777777', 'a@z.fr', '$2y$10$SjxNM5mB35S/XbnVFMooGupnJW9DwDcn/IO7ZOIRof7uJs9gFKyRi', ''),
(20, 'a', 'a', 'a', '0123456789', 'a@pp.fr', '$2y$10$85J0/GVfscoA5WogvMHx0.QPibQiIJ.zKPwuXjZ4cX6B4fInfHJY2', ''),
(21, 'a', 'a', 'a', '7777777777', 'a@a.aa', '$2y$10$nzowx2sTC9WqLIFAnUo/lu0SFl33FfuGzigPfRQMexEec4R9YHMd6', ''),
(22, 'a', 'a', 'a', '0000000000', 'a@p.fezs', '$2y$10$lozfM.lbVHcxpdEURNFEYe8w0eJDC6to9cwx25NC7/5fIP3VCGpli', ''),
(23, 'a', 'a', 'a', '0000000000', 'a@p.fezss', '$2y$10$LRJ1m6CPCtBqABW1RpEMIuOqnycm830gpuOKdwC/C2N6kEtLgzAOO', ''),
(24, 'a', 'a', 'a', '7777777777', 'ss@ezs.fr', '$2y$10$tPChNA0/kb/iipdsTuYiseSyWpsxUk7denmZFNLebYYKlF/Hb2bzu', ''),
(25, 'a', 'a', 'a', '7777777777', 'ss@ezs.frf', '$2y$10$zYsYP3P6sYN239oa66U6h.2v5KNIDCNVhP/jUvlS6N207aDL0AOaO', ''),
(26, 'a', 'a', 'a', '7777777777', 'ss@ezs.frfa', '$2y$10$H/pRhcJpNPkkjUjYBWX6Ceo5UMqycW64KmD2V68naC4d8lMbXZgX6', ''),
(27, 'a', 'a', 'a', '7878787877', 'az@zasd.zsq', '$2y$10$Xmfd5v/USvoRBH/FdKejduqPZrhmA25oBaSpKuaH0oND8YYWdoDAC', ''),
(28, 'a', 'a', 'a', '4541653230', 'a@zadqs.az', '$2y$10$VRZIVdrRwAoIPRK4UmGX1etw5epgZkJiMN7CdBMryR.0Z7XL6om2S', ''),
(29, 'a', 'a', 'a', '7777777777', 'azeds@zza:.az', '$2y$10$Tysv/NTjsZJwRWExdFn6seod2BepoRLMuHkt9FCzbhgzElQxftEf6', ''),
(30, 'a', 'a', 'a', '7777777552', 'azd@fsk.ez', '$2y$10$GKXifp7v7vNql9u5rPTYnerUnvmUiC5qsl1KinS5FI2YUvFsO43Ne', ''),
(31, 'a', 'a', 'a', '4441411415', 'azd@dza/.l', '$2y$10$5y6f1pr50VK4azdYZ21Cae1EEIZ4YvQrj0ekAYk3AgQB1gqHy2bZS', ''),
(32, 'a', 'a', 'a', '4444444455', 'za@ez.g', '$2y$10$2uYQQYPA.9mLsTKek6KvSeoZfwo6ova9fs1SNd35Z1a9mB9EmIode', ''),
(33, 'za', 'a', 'ea', '4561203451', 'zr,@fez./ez', '$2y$10$7TbKbyq1.khVtxOTTdTlHeCJ8IDY7yx9yuZF6nUBMMbfu0I4I65.m', NULL),
(34, 'a', 'a', 'a', '4512451154', 'a;à@z.z', '$2y$10$7VoPIKHnh4mSqSsNCY8BOe9C0m3i/tJqCtsB74f/X2yS1SwHPY0gu', NULL),
(35, 'a', 'a', 'a', '5102563206', 'azea@aze.fr', '$2y$10$K8DkjTriV.2rrjl7k78uv.y0L8LZ9.YDuI43x/9NVjKyHs8hNEabe', NULL),
(36, 'a', 'a', 'a', '7845210558', 'mza@fez.fe', '$2y$10$ETX779p828oJdYDSwjicpu6bBMWBg9ovBwsoZBsnHC3g9jCfJlDAW', NULL),
(37, 'a', 'a', 'a', '2511211111', 'az@za/Defe/F.fe', '$2y$10$pyiRHWBFiAk6ucgfvATVnehpb6XaSfdMqzFgcV0cqKDT5Q3K1pZ9S', NULL),
(38, 'a', 'a', 'a', '4845454565', 'dz@dz.de', '$2y$10$M98JgMepF03icDRVrc1S1u1L23nLLbjmeUazsumWJmgCaRZP3.Ftu', NULL),
(39, 'a', 'aa', 'a', '5200232255', 'mieazdsq@dzaFE.Z', '$2y$10$jnfZ2Du.U99BmS9KcXcDUuHNiqeLJjOa05dMbXfc/TU7.JsC84yOm', NULL),
(40, 'a', 'a', 'a', '1521328989', 'zade@eza.edaz', '$2y$10$ut2/gYG4/X.vr2wIRE9rt.IXA3HqQY1LK7dTI9qGIQF2wIAudBvCu', NULL),
(41, 'a', 'a', 'a', '4751245125', 'az@az.Daz', '$2y$10$Fgj60cAPskTI4HfGyKiAC.l4q.YB8p/8RlW2RI525SqoCX3aYNMNO', NULL),
(42, 'a', 'a', 'a', '4854854878', 'aemiraza€za@ez:za/Ea/ea.a', '$2y$10$rAe6Eq7PtsR1tznUcgg0E.qkAffFuYVZZdZ2UmXd5MmK/3CQUiHY2', 'cus_TOf6fO1BbG1T3n'),
(43, 't', 't', 't', 't', 'zadazhjdhqksj@az.fz', '$2y$10$uJMxWPojZLn1diuDzgw8IejD0GIhU1zVTapVnUEgnGu9rVOS8aywy', 'cus_TOfDdefyhLsnl4'),
(44, 'a', 'a', 'a', '4105204102', 'daz@azqs.fazqssdqdqsdsqdqsdqsdsq', '$2y$10$iCn/.o0N1fhxiD7BuxgQxOtk6kETW8tjoe/YmfshZiNZ8UeqPpHQS', 'cus_TOfIHT6kmQ9kK2'),
(45, 'a', 'a', 'a', '5623051244', 'zmaed@za/fa/azd.Fa', '$2y$10$1UrPeriliZR9QGe3mF6zdezAtB6m8WQAVfSK0orgL.6wYqKGruWHa', 'cus_TOfKQLj9OeRdaM'),
(46, 'a', 'a', 'a', '0745246568', 'miazdq@daz.fe', '$2y$10$ux1iWPcHN4EE/twKyjCyAOy1/nfqpadhAnIcDb1TazKGUUayDPxJm', 'cus_TOfLZwaNmyzDMa'),
(47, 'a', 'a', 'a', '4150250100', 'azeq@qas.fr', '$2y$10$mFAxVMwTBJLoOduYzf7iz.IbjUCYCuU0Ge4/pXgcbgXrEn37XLj0a', 'cus_TRqNu4X5hmzaLx'),
(48, 'a', 'a', 'a', '5613205412', 'dsq@zaq.DZqs', '$2y$10$xeynk2X5S3i5IQ9M0Vig9.h/QKH5w2uJ7rbRm6aQ4qU/SbF92XYUu', 'cus_TSRvD6V1PlwT5u'),
(49, 'Miranda', 'anthony', 'dza', '1111111111', 'eza@za.Fr', '$2y$10$seHRTBcgKRSRJ8x.gqjO/ujdy1eqM9Egs6V298TnfLHWnfQODanmK', 'cus_TSt5tLT2JN8BGK');

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE `commandes` (
  `id_commande` int(11) NOT NULL,
  `id_art` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `envoi` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `id_art`, `id_client`, `quantite`, `envoi`) VALUES
(2, 1, 8, 1, 0),
(3, 3, 8, 1, 0),
(6, 4, 8, 1, 0),
(7, 4, 8, 1, 0),
(8, 3, 8, 1, 0),
(9, 1, 8, 1, 0),
(10, 2, 8, 55, 0),
(11, 3, 8, 1, 1),
(12, 2, 8, 1000, 0),
(13, 1, 8, 75, 0),
(14, 1, 8, 74, 0),
(15, 1, 8, 74, 0),
(16, 3, 8, 1, 0),
(17, 4, 8, 1, 0),
(18, 3, 8, 1, 0),
(19, 4, 8, 1, 0),
(22, 4, 8, 1, 0),
(23, 1, 8, 1, 0),
(26, 4, 8, 1, 0),
(27, 3, 8, 96, 0),
(28, 4, 8, 1, 0),
(29, 4, 8, 1, 0),
(30, 4, 8, 1, 0),
(31, 4, 37, 1, 0),
(32, 4, 37, 1, 0),
(33, 4, 8, 1, 0),
(34, 4, 8, 1, 0),
(35, 4, 8, 1, 0),
(36, 1, 8, 1, 0),
(37, 1, 8, 1, 0),
(38, 1, 8, 1, 0),
(39, 1, 8, 1, 0),
(40, 4, 8, 1, 0),
(41, 5, 8, 1, 0),
(42, 1, 8, 1, 0),
(43, 2, 8, 1, 0),
(44, 2, 8, 1, 0),
(45, 5, 46, 1, 0),
(46, 2, 46, 54, 0),
(47, 1, 8, 100, 0),
(48, 1, 46, 94, 0),
(49, 4, 46, 21, 0),
(50, 4, 8, 1, 0),
(51, 5, 8, 1, 0),
(52, 5, 8, 47, 0),
(53, 2, 47, 44, 0),
(54, 4, 8, 1, 0),
(55, 4, 8, 1, 0),
(56, 6, 8, 1, 0),
(57, 6, 8, 1, 0),
(58, 4, 8, 1, 0),
(59, 6, 8, 1, 0),
(60, 4, 8, 1, 0),
(61, 4, 8, 1, 0),
(62, 4, 8, 1, 0),
(63, 4, 8, 1, 0),
(64, 4, 8, 1, 0),
(65, 4, 8, 5, 0),
(66, 6, 8, 10, 0),
(67, 8, 8, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `commandes_tampon`
--

CREATE TABLE `commandes_tampon` (
  `id_commande` int(11) NOT NULL,
  `id_art` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `envoi` tinyint(1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_art` int(11) NOT NULL,
  `date_com` datetime NOT NULL,
  `contenue` varchar(255) NOT NULL,
  `note` float NOT NULL,
  `nb_like` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `id_client`, `id_art`, `date_com`, `contenue`, `note`, `nb_like`) VALUES
(4, 8, 2, '2025-12-14 20:16:47', 'cool', 4, 0),
(5, 8, 3, '2025-12-14 20:17:13', 'null', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `contenu` varchar(256) NOT NULL,
  `heure_envoie` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id_question` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_art` int(11) NOT NULL,
  `id_question_mere` int(11) NOT NULL,
  `contenue` varchar(255) NOT NULL,
  `date_question` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id_question`, `id_client`, `id_art`, `id_question_mere`, `contenue`, `date_question`) VALUES
(2, 8, 1, -1, 'za', '2025-12-14 16:03:09'),
(3, 8, 1, -1, 'za', '2025-12-14 16:09:45'),
(4, 8, 1, -1, 'azfqsd', '2025-12-14 16:09:49'),
(5, 8, 1, -1, 'dispo?\r\n', '2025-12-14 16:10:48'),
(7, 8, 1, 6, 'za', '2025-12-14 16:43:36'),
(8, 8, 1, 6, 'ok\r\n', '2025-12-14 16:43:46'),
(9, 8, 1, 8, 'lol\r\n', '2025-12-14 16:44:01'),
(10, 8, 1, 8, 'lol', '2025-12-14 16:44:08'),
(11, 8, 1, 10, 'nice\r\n', '2025-12-14 16:47:16'),
(13, 8, 1, 12, 'ok\r\n', '2025-12-14 20:00:13'),
(14, 8, 6, -1, 'en stock?', '2025-12-14 20:31:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_art`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `articles` (`id_art`),
  ADD KEY `clients` (`id_client`);

--
-- Indexes for table `commandes_tampon`
--
ALTER TABLE `commandes_tampon`
  ADD PRIMARY KEY (`id_commande`);

--
-- Indexes for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id_question`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_art` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `commandes_tampon`
--
ALTER TABLE `commandes_tampon`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
