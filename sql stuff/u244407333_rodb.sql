-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 18, 2026 at 11:44 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u244407333_rodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `grade_code` varchar(8) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `grade_code`, `name`, `description`, `created_at`) VALUES
(1, '', '7 eme A', '', '2026-02-23 12:27:59'),
(8, '1ere B', '7 eme B', '', '2026-02-23 12:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(32) NOT NULL,
  `role` varchar(64) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(32) NOT NULL,
  `emergency_name` varchar(128) NOT NULL,
  `emergency_phone` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(32) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `dob` date NOT NULL,
  `place_of_birth` varchar(128) NOT NULL,
  `nationality` varchar(64) NOT NULL,
  `guardian_name` varchar(128) NOT NULL,
  `relationship` varchar(64) NOT NULL,
  `guardian_phone` varchar(32) NOT NULL,
  `guardian_occupation` varchar(64) NOT NULL,
  `address` text DEFAULT NULL,
  `emergency_name` varchar(128) NOT NULL,
  `emergency_phone` varchar(32) NOT NULL,
  `medical_conditions` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `full_name`, `gender`, `dob`, `place_of_birth`, `nationality`, `guardian_name`, `relationship`, `guardian_phone`, `guardian_occupation`, `address`, `emergency_name`, `emergency_phone`, `medical_conditions`, `created_at`) VALUES
(1, 'STU2026202300001', 'Tresor Kalembo Tshibangu', 'male', '2023-03-01', 'Fiontonton', 'Congolese', 'Tresor Kalembo Tshibangu', 'older sister', '+601137923985', 'Fiontonton', 'C-08-09 Tower C, Utropolis Suites, 2, Jalan Kontraktor U1/14, 40150 S', 'dddddd', '+601137923986', 'N/A', '2026-03-16 12:43:51'),
(2, 'STU2026202300002', 'Tresor Kalembo Tshibangu', 'male', '2023-03-01', 'Fiontonton', 'Congolese', 'Tresor Kalembo Tshibangu', 'older sister', '+601137923985', 'Fiontonton', 'C-08-09 Tower C, Utropolis Suites, 2, Jalan Kontraktor U1/14, 40150 S', 'dddddd', '+601137923986', 'N/A', '2026-03-16 12:44:37'),
(3, 'STU2026202300003', 'Tresor Kalembo Tshibangu', 'male', '2023-03-01', 'Fiontonton', 'Congolese', 'Tresor Kalembo Tshibangu', 'older sister', '+601137923985', 'Fiontonton', 'C-08-09 Tower C, Utropolis Suites, 2, Jalan Kontraktor U1/14, 40150 S', 'dddddd', '+601137923986', 'N/A', '2026-03-16 12:50:34'),
(4, 'STU2026200100004', 'Kabongo silvie ', 'female', '2001-01-13', 'Brondo', 'Congolese ', 'Guelord kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-16 14:31:44'),
(5, 'STU2026200100005', 'Lubamba ilunga Placide ', 'male', '2001-04-11', 'Lubumbashi ', 'Congolaise ', 'Ilunga matthieu ', 'father', '+243854683210', 'Avocat ', 'Numéro 8 avenue Dr lugoma quartier kisanga', 'Papa', '+243854683210', 'Aucun ', '2026-03-16 14:39:12'),
(6, 'STU2026200100006', 'Lubamba ilunga Placide ', 'male', '2001-04-11', 'Lubumbashi ', 'Congolaise ', 'Ilunga matthieu ', 'father', '+243854683210', 'Avocat ', 'Numéro 8 avenue Dr lugoma quartier kisanga', 'Papa', '+243854683210', 'Aucun ', '2026-03-16 14:39:18'),
(7, 'STU2026200100007', 'Lubamba ilunga Placide ', 'male', '2001-04-11', 'Lubumbashi ', 'Congolaise ', 'Ilunga matthieu ', 'father', '+243854683210', 'Avocat ', 'Numéro 8 avenue Dr lugoma quartier kisanga', 'Papa', '+243854683210', 'Aucun ', '2026-03-16 14:39:20'),
(8, 'STU2026200200008', 'Kayembe kabeya asaph', 'male', '2002-04-26', 'Likasi ', 'Congolaise ', 'Kabeya Leonard ', 'older brother', '+243996742601', 'Banquier ', 'Numéro 145 avenue des oliviers quartier belair', 'Grand frère ', '+243996742601', 'Aucun ', '2026-03-16 14:44:39'),
(9, 'STU2026200100009', 'Tshala tambue jimmy ', 'male', '2001-05-05', 'Lubumbashi ', 'Congolaise ', 'Tambue viviane ', 'mother', '+243814142393', 'Commerçante', 'Numéro 12 avenue tulipier quartier belair ', 'Maman', '+243814142393', 'Allergie au Paracetamol ', '2026-03-16 14:50:22'),
(10, 'STU2026202300010', 'Kabasele kabasele Joelle ', 'female', '2023-03-16', 'Lubumbashi ', 'Congolaise', 'Kabasele Sylvain ', 'father', '0999658613', 'Fonctionnaire ', '1853 av Kasavubu ', 'Kabasele Sylvain ', '0999658653', 'Allergique aux crustacés ', '2026-03-16 15:00:08'),
(11, 'STU2026200400011', 'NGOYA KADIEDIEMU ANAÏS ', 'female', '2004-03-12', 'LUBUMBASHI ', 'Congolese ', 'Ilunga Kadiediemu ', 'father', '+243992087723', '', '', '', '', '', '2026-03-16 15:01:00'),
(12, 'STU2026200500012', 'Placide Lubamba', 'male', '2005-11-02', 'Lubumbashi ', 'Congolaise ', 'Placide Lubamba', 'father', '', '', '', '', '', '', '2026-03-16 15:01:32'),
(13, 'STU2026200500013', 'Placide Lubamba', 'male', '2005-11-02', 'Lubumbashi ', 'Congolaise ', 'Placide Lubamba', 'father', '', '', '', '', '', '', '2026-03-16 15:01:33'),
(14, 'STU2026199500014', 'Felly kanongo', 'male', '1995-02-16', 'DRC', 'Congolaise', 'Jean kabongo ', 'father', '+243992141900', '', 'Lubumbashi rwashi n23', '', '', '', '2026-03-16 15:05:33'),
(15, 'STU2026199600015', 'Dode banza', 'male', '1996-04-12', 'DRC', 'Congolaise ', 'Charl banza ', 'father', '+243815644921', '', 'Lubumbashi golf n45', '', '', '', '2026-03-16 15:19:33'),
(16, 'STU2026200100016', 'Kabongo jean Charles ', 'female', '2001-01-13', 'Brondo', 'Congolese ', 'Guelord kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-16 15:29:24'),
(17, 'STU2026200200017', 'Junior kalele ', 'male', '2002-01-13', 'Brondo', 'Congolese ', 'Guelord kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-16 15:30:24'),
(18, 'STU2026200200018', 'Jean Jacques Kasongo ', 'male', '2002-11-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-16 15:39:18'),
(19, 'STU2026199500019', 'Keren Kalembo ', 'female', '1995-03-16', 'Lubumbashi ', 'Congolese', 'Thomas Kalembo ', 'father', '+243908542425', 'Lawyer', 'Avenue des Acacias n°27 Quartier Golf Commune de Lubumbashi', 'Kalembo', '+243907178940', '', '2026-03-16 15:47:07'),
(20, 'STU2026199500020', 'Keren Kalembo ', 'female', '1995-03-16', 'Lubumbashi ', 'Congolese', 'Thomas Kalembo ', 'father', '+243908542425', 'Lawyer', 'Avenue des Acacias n°27 Quartier Golf Commune de Lubumbashi', 'Kalembo', '+243907178940', '', '2026-03-16 15:47:12'),
(21, 'STU2026200500021', 'Ignace Tresor', 'male', '2005-03-17', 'Fiontonton ', 'Fioro', 'Tresor', 'older sister', '011 3792 3985', 'Katako', 'Treskksg, gksishsb', 'Hshshsv', '1236547890', '', '2026-03-16 16:35:38'),
(22, 'STU2026200100022', 'KALEMBO LUBO RABBI ', 'male', '2001-04-12', 'Lubumbashi ', 'Congolese', 'Lubo Daniel ', 'father', '+243997036195', 'Liberal', 'Kipopo avenue, number: 139 B', 'Marie ', '+243852522669', '', '2026-03-16 17:01:16'),
(23, 'STU2026200200023', 'Jean Jacques sompo ', 'male', '2002-11-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-16 17:26:50'),
(24, 'STU2026200400024', 'Lubo kimwanga ', 'male', '2004-08-16', 'Lubumbashi ', 'Congolaise ', 'Placide Lubamba', 'older brother', '', 'Aviculteur', '', '', '', '', '2026-03-16 17:37:29'),
(25, 'STU2026200300025', 'Andy kahenga', 'male', '2003-01-16', 'Lubumbashi ', 'Congolaise ', 'Placide Lubamba', '', '', '', '', '', '', '', '2026-03-16 17:38:55'),
(26, 'STU2026200300026', 'Sephora mpiana', 'male', '2003-02-16', 'Kolwezi ', 'Congolaise ', 'Lubo kimwanga ', 'father', '', '', '', '', '', '', '2026-03-16 17:40:21'),
(27, 'STU2026200100027', 'Daniella kalongi', 'female', '2001-03-16', 'Likasi', 'Zambienne ', 'Papi marco', 'older sister', '', '', '', '', '', '', '2026-03-16 17:43:06'),
(28, 'STU2026200300028', 'Francis Menda ', 'male', '2003-02-13', 'Lubumbashi ', 'Congolaise ', 'Medard menda ', 'father', '+243999099239', 'Université ', 'Kilobelobe /33B/tshipeng', '', '999099239', 'Bouton ', '2026-03-16 17:43:32'),
(29, 'STU2026200300029', 'Francis Menda ', 'male', '2003-02-13', 'Lubumbashi ', 'Congolaise ', 'Medard menda ', 'father', '+243999099239', 'Université ', 'Kilobelobe /33B/tshipeng', '', '999099239', 'Bouton ', '2026-03-16 17:43:35'),
(30, 'STU2026200200030', 'Jonathan muzela', 'male', '2002-03-16', 'Goma', 'Congolaise ', '', '', '', '', '', '', '', '', '2026-03-16 17:44:22'),
(31, 'STU2026200100031', 'Kalenga', 'male', '2001-10-18', 'Lubumbashi ', 'Congolaise ', 'Kalenga Mbayo Patrice', 'father', '+243996527118', 'Chômeur', 'Q.Bel-air,C. Kampemba av. De l\'église n°23b', 'Kalenga Mbayo Patrice', '+243995861350', '', '2026-03-16 18:05:07'),
(32, 'STU2026200100032', 'Kalenga', 'male', '2001-10-18', 'Lubumbashi ', 'Congolaise ', 'Kalenga Mbayo Patrice', 'father', '+243996527118', 'Chômeur', 'Q.Bel-air,C. Kampemba av. De l\'église n°23b', 'Kalenga Mbayo Patrice', '+243995861350', '', '2026-03-16 18:05:09'),
(33, 'STU2026200100033', 'Kalenga', 'male', '2001-10-18', 'Lubumbashi ', 'Congolaise ', 'Kalenga Mbayo Patrice', 'father', '+243996527118', 'Chômeur', 'Q.Bel-air,C. Kampemba av. De l\'église n°23b', 'Kalenga Mbayo Patrice', '+243995861350', '', '2026-03-16 18:05:14'),
(34, 'STU2026200600034', 'Mutombo Divine', 'female', '2006-10-20', 'Lubumbashi ', 'Congolaise ', 'Mutombo Muleka jean pierre ', 'father', '+243816539800', 'Liberale', '', 'Mutombo Muleka jean pierre', '+243816539800', '', '2026-03-16 18:09:52'),
(35, 'STU2026200600035', 'Mutombo Divine', 'female', '2006-10-20', 'Lubumbashi ', 'Congolaise ', 'Mutombo Muleka jean pierre ', 'father', '+243816539800', 'Liberale', '', 'Mutombo Muleka jean pierre', '+243816539800', '', '2026-03-16 18:09:59'),
(36, 'STU2026200600036', 'Mutombo Divine', 'female', '2006-10-20', 'Lubumbashi ', 'Congolaise ', 'Mutombo Muleka jean pierre ', 'father', '+243816539800', 'Liberale', '', 'Mutombo Muleka jean pierre', '+243816539800', '', '2026-03-16 18:10:01'),
(37, 'STU2026200600037', 'Mutombo Divine', 'female', '2006-10-20', 'Lubumbashi ', 'Congolaise ', 'Mutombo Muleka jean pierre ', 'father', '+243816539800', 'Liberale', '', 'Mutombo Muleka jean pierre', '+243816539800', '', '2026-03-16 18:10:02'),
(38, 'STU2026200200038', 'Ilunga zingiti', 'male', '2002-09-28', 'Lubumbashi ', 'Congolaise ', 'Ngoy malala jeanne', 'mother', '+243856418006', 'Ménagère ', '', 'Ngoy malala jeanne', '+243856418006', '', '2026-03-16 18:13:07'),
(39, 'STU2026200400039', 'Alubati simbi Aaron', 'male', '2004-04-03', 'Lubumbashi ', 'Congolaise ', 'Alubati simbi Léonard ', 'father', '+243846697258', 'Professeur ', '', 'Alubati simbi Léonard ', '243846697258', '', '2026-03-16 18:17:24'),
(40, 'STU2026200200040', 'Papy kyungu ', 'male', '2002-11-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-16 18:17:28'),
(41, 'STU2026200200041', 'Papy kyungu ', 'male', '2002-11-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-16 18:17:59'),
(42, 'STU2026200300042', 'Tsypu ', 'male', '2003-05-20', '', 'Congolais ', 'Gardoiun', 'brother in law', '+243891870201', 'Travailleur', '', '', '', '', '2026-03-16 18:21:07'),
(43, 'STU2026200600043', 'Kasongo Tshala Sandra', 'female', '2006-05-18', 'Lubumbashi ', 'Congolaise ', 'Tshala nsenga Marie', 'mother', '+243856211147', 'Liberale ', '', 'Tshala nsenga Marie', '+243856211147', '', '2026-03-16 18:21:36'),
(44, 'STU2026200600044', 'Kasongo Tshala Sandra', 'female', '2006-05-18', 'Lubumbashi ', 'Congolaise ', 'Tshala nsenga Marie', 'mother', '+243856211147', 'Liberale ', '', 'Tshala nsenga Marie', '+243856211147', '', '2026-03-16 18:21:37'),
(45, 'STU2026200500045', 'Franck Kasongo ', 'male', '2005-03-16', 'Lubumbashi ', 'Congolaise ', 'Francis M', 'father', '090261566', 'Université ', '', 'Francis M', '090261566', 'Bouton ', '2026-03-16 18:28:22'),
(46, 'STU2026202300046', 'David MULAMBA', 'male', '2023-03-02', 'Lubumbashi ', 'Congolaise ', 'Annie mwanza', 'mother', '0853136935', 'Professeur ', 'Kassapa13', 'David MULAMBA', '0842197828', '', '2026-03-16 18:29:08'),
(47, 'STU2026202300047', 'David MULAMBA', 'male', '2023-03-02', 'Lubumbashi ', 'Congolaise ', 'Annie mwanza', 'mother', '0853136935', 'Professeur ', 'Kassapa13', 'David MULAMBA', '0842197828', '', '2026-03-16 18:29:10'),
(48, 'STU2026200200048', 'Aloka mulamba ', 'female', '2002-09-02', 'Lubumbashi ', 'Congolaise ', 'Mulopwe', 'mother', '0842136732', 'Avocate ', 'Kassapa', '', '', '', '2026-03-16 18:33:57'),
(49, 'STU2026202300049', 'Jean Nkulu jean ', 'male', '2023-03-14', 'Lubumbashi ', 'Congolaise ', 'Menda wa tshabu ', 'father', '0842791718', 'Travail ', 'Golf ', 'Clinic ', '0852586963', 'Soyez gentil avec mon enfant ', '2026-03-16 18:34:20'),
(50, 'STU2026200400050', 'Charles mambaz ', 'male', '2004-09-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-16 18:38:47'),
(51, 'STU2026199900051', 'James ngoy', 'male', '1999-02-11', 'Kolwezi', 'Congolaise ', '', 'father', '', '', '', '', '', '', '2026-03-16 18:39:05'),
(52, 'STU2026199900052', 'James ngoy', 'male', '1999-02-11', 'Kolwezi', 'Congolaise ', '', 'father', '', '', '', '', '', '', '2026-03-16 18:39:08'),
(53, 'STU2026201700053', 'Tresor Kalembo Tshibang', 'male', '2017-02-01', 'Fiontonton State', 'Congolese', 'Tresor Kalembo Tshibangu', 'cousin', '+601137923985', 'Fiontonton', 'C-08-09 Tower C, Utropolis Suites, 2, Jalan Kontraktor U1/14, 40150 S', 'Tresor Kalembo Tshibangu', '+601137923985', '', '2026-03-17 11:08:10'),
(54, 'STU2026200400054', 'Charles mambaz ', 'male', '2004-09-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-17 12:18:29'),
(55, 'STU2026200400055', 'Suzanne ngandu ', 'female', '2004-09-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-17 12:19:28'),
(56, 'STU2026200400056', 'Stéphanie mwenze ', 'female', '2004-09-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-17 12:20:10'),
(57, 'STU2026200400057', 'Alain  mwenze', 'male', '2004-09-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-17 12:22:43'),
(58, 'STU2026200400058', 'Albert kyungu ', 'male', '2004-09-15', 'Brondo', 'Congolese ', 'Pierrot  kalonji ', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord ', '+243971161923', '', '2026-03-17 12:23:10'),
(59, 'STU2026200500059', 'Matthieu Ilunga', 'male', '2005-03-29', 'Lubumbashi', 'Congolese', 'Matthieu', 'father', '+243971161923', 'Guardian', 'Av lugoma 4', 'Matthieu Ilunga', '971161923', '', '2026-03-17 14:25:11'),
(60, 'STU2026200500060', 'Matthieu Ilunga', 'male', '2005-03-29', 'Lubumbashi', 'Congolese', 'Matthieu', 'father', '+243971161923', 'Guardian', 'Av lugoma 4', 'Matthieu Ilunga', '971161923', '', '2026-03-17 14:25:12'),
(61, 'STU2026200500061', 'Junior kabengele', 'male', '2005-03-29', 'Lubumbashi', 'Congolese', 'Matthieu', 'father', '+243971161923', 'Guardian', 'Av lugoma 4', 'Matthieu Ilunga', '971161923', '', '2026-03-17 14:25:34'),
(62, 'STU2026200600062', 'Bwanga Mopao', 'male', '2006-03-17', 'Kinshasa', 'Congolese', 'Bongo Sana', 'older brother', '+243815923841', 'Engineer', '10 Avenue Kasai', 'Mambo Mingi', '+243997126673', '', '2026-03-17 17:50:27'),
(63, 'STU2026201000063', 'Matamba Debach', 'male', '2010-03-17', 'Kinshasa', 'Congolese', 'Bongo Sana', 'mother', '+243998181712', 'Engineer', '18 Avenue Kasai', 'Kitshwa Nguvu', '+243845569813', '', '2026-03-17 17:54:43'),
(64, 'STU2026199800064', 'Henry kaputo', 'male', '1998-07-26', 'DRC', 'Congolaise', 'Jean kaputo', 'cousin', '+2438566412579', 'Rien', 'Lubumbashi Bel-Air n35', 'Lyly kaputo', '+2438597142358', '', '2026-03-17 18:23:48'),
(65, 'STU2026200000065', 'Dicobu kakuta', 'female', '2000-07-11', 'Lubumbashi', 'Congolaise', 'Manue kakuta', 'cousin', '+243859123407', 'Stage professionnel', '15,météo lubumbashi', 'Pedri Gonzalez', '+243888215736', '', '2026-03-17 18:30:37'),
(66, 'STU2026200400066', 'Albert Kasongo', 'male', '2004-09-15', 'Brondo', 'Congolese', 'Pierrot  kalonji', 'father', '+243971161923', 'Guardian', '4 av mulonge', 'Guelord', '+243971161923', '', '2026-03-18 09:06:13');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `emergency_name` varchar(100) NOT NULL,
  `emergency_phone` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `first_name`, `middle_name`, `last_name`, `gender`, `dob`, `address`, `phone`, `qualification`, `emergency_name`, `emergency_phone`, `password_hash`, `created_at`) VALUES
('TEA20260001', 'Tresor Kalembo', '', 'Tshibangu', 'male', '2006-02-28', 'C-08-09 Tower C, Utropolis Suites, 2, Jalan Kontraktor U1/14, 40150 S', '+601-137-923985', 'n/a', 'n/a', '+601-137-923985', '$2y$10$k91fZOyGMlsXkov/3uK1xuHBEe.uST29h12o7/0M9U6.VfbIRNNLC', '2026-03-13 12:08:46'),
('TEA20260002', 'Tresor Kalembo', '', 'Tshibangu', 'male', '2004-01-18', 'C-08-09 Tower C, Utropolis Suites, 2, Jalan Kontraktor U1/14, 40150 S', '+601-137-923985', '', '', '', '$2y$10$qBL3eweh1SLaOxBxd3VdbO5GypX7zDkkbNIoc47KitMZh9zBf6Tw2', '2026-03-18 11:05:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grade_code` (`grade_code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
