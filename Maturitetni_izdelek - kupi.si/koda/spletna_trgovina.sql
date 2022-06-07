-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 16. apr 2020 ob 14.23
-- Različica strežnika: 10.4.11-MariaDB
-- Različica PHP: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `spletna_trgovina`
--

-- --------------------------------------------------------

--
-- Struktura tabele `ocene_uporabnikov`
--

CREATE TABLE `ocene_uporabnikov` (
  `id_uporabnika` int(11) NOT NULL,
  `vrednost` float NOT NULL DEFAULT 0,
  `st_ocen` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `ocene_uporabnikov`
--

INSERT INTO `ocene_uporabnikov` (`id_uporabnika`, `vrednost`, `st_ocen`) VALUES
(1, 4, 1),
(3, 0, 0),
(4, 0, 0),
(5, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabele `oglasi`
--

CREATE TABLE `oglasi` (
  `id` int(11) NOT NULL,
  `id_uporabnika` int(11) NOT NULL,
  `naziv` varchar(30) NOT NULL,
  `opcija` varchar(10) NOT NULL,
  `kategorija` varchar(30) NOT NULL,
  `opis` text DEFAULT NULL,
  `cena` float NOT NULL,
  `stanje` varchar(30) NOT NULL,
  `datum_objave` date NOT NULL,
  `datum_poteka` date NOT NULL,
  `aktivnost` enum('DA','NE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `oglasi`
--

INSERT INTO `oglasi` (`id`, `id_uporabnika`, `naziv`, `opcija`, `kategorija`, `opis`, `cena`, `stanje`, `datum_objave`, `datum_poteka`, `aktivnost`) VALUES
(2, 1, 'frnikule', 'Prodam', 'Zbirateljstvo', 'Dobro ohranjene stare redke frnikule za zbiratelje.\r\nKontakt tudi na: 01 223 3333', 100, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(3, 1, 'Lego kocke', 'Prodam', 'Igrače', 'Dobro ohranjene lego kocke, dodane tudi lego technic za 20€.', 20, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(4, 1, 'samsung galaxy j3', 'Kupim', 'Telefonija', 'Kupim samsung galaxy j3 za dele (zaradi eksperimentov).', 30, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(5, 1, 'nog. žoga', 'Prodam', 'Šport', 'Čisto nova nogometna žoga.', 20, 'novo', '2020-04-15', '2020-04-16', 'DA'),
(6, 1, 'test1', 'Prodam', 'Literatura', 'test1', 10, 'novo', '2020-04-15', '2020-05-15', 'DA'),
(7, 1, 'test2', 'Prodam', 'Literatura', 'test2', 33, 'poškodovano/pokvarjeno', '2020-04-15', '2020-05-15', 'DA'),
(8, 1, 'test3', 'Prodam', 'Literatura', 'test3', 44, 'poškodovano/pokvarjeno', '2020-04-15', '2020-05-15', 'DA'),
(9, 1, 'test4', 'Prodam', 'Literatura', 'test4', 120, 'novo', '2020-04-15', '2020-05-15', 'DA'),
(10, 1, 'test5', 'Prodam', 'Literatura', 'test5', 300, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(11, 1, 'test7', 'Kupim', 'Literatura', 'test7', 300, 'poškodovano/pokvarjeno', '2020-04-15', '2020-05-15', 'DA'),
(12, 1, 'test8', 'Kupim', 'Literatura', 'test8', 500, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(13, 1, 'test9', 'Kupim', 'Literatura', 'test9', 700, 'poškodovano/pokvarjeno', '2020-04-15', '2020-05-15', 'DA'),
(14, 1, 'test10', 'Prodam', 'Literatura', 'test10', 800, 'poškodovano/pokvarjeno', '2020-04-15', '2020-05-15', 'DA'),
(15, 1, 'test11', 'Prodam', 'Literatura', 'test11', 840, 'poškodovano/pokvarjeno', '2020-04-15', '2020-05-15', 'DA'),
(16, 1, 'test12', 'Prodam', 'Literatura', 'test12', 900, 'poškodovano/pokvarjeno', '2020-04-15', '2020-05-15', 'DA'),
(17, 1, 'test13', 'Prodam', 'Literatura', 'test13', 1300, 'poškodovano/pokvarjeno', '2020-04-15', '2020-05-15', 'DA'),
(18, 1, 'test14', 'Prodam', 'Literatura', 'test14', 1600, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(19, 3, 'test15', 'Prodam', 'Literatura', '', 500, 'novo', '2020-04-15', '2020-05-15', 'DA'),
(20, 3, 'test16', 'Prodam', 'Literatura', '', 700, 'novo', '2020-04-15', '2020-05-15', 'DA'),
(21, 3, 'test17', 'Prodam', 'Literatura', '', 700, 'novo', '2020-04-15', '2020-05-15', 'DA'),
(22, 3, 'test20', 'Prodam', 'Literatura', '', 1200, 'novo', '2020-04-15', '2020-05-15', 'DA'),
(23, 3, 'test21', 'Kupim', 'Literatura', '', 1300, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(24, 3, 'test22', 'Kupim', 'Literatura', '', 1322, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(25, 3, 'test23', 'Kupim', 'Literatura', '', 1333, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(26, 3, 'test24', 'Kupim', 'Literatura', '', 1444, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(27, 3, 'test25', 'Kupim', 'Literatura', '', 1900, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(28, 3, 'test26', 'Kupim', 'Literatura', '', 2100, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(29, 3, 'test26', 'Kupim', 'Literatura', '', 2300, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(30, 3, 'test27', 'Kupim', 'Literatura', 'test27', 3000, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(31, 3, 'test28', 'Prodam', 'Literatura', 'test28', 3900, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(32, 3, 'test29', 'Prodam', 'Literatura', 'test29', 9900, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(33, 3, 'test30', 'Prodam', 'Literatura', 'test30', 10900, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(34, 3, 'test31', 'Prodam', 'Literatura', '', 11100, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(35, 3, 'test32', 'Prodam', 'Literatura', '', 12100, 'rabljeno', '2020-04-15', '2020-05-15', 'DA'),
(36, 4, 'honda crf 250', 'Prodam', 'Motociklizem', 'Prodajam čisto novo hondo.\r\nPeljana le za sprobo.\r\nKontak tudi na neki.neki@gmail.com.', 5000, 'novo', '2020-04-16', '2020-05-16', 'DA'),
(37, 4, 'ninja h2 ', 'Kupim', 'Šport', 'Kupim novo kawasaki ninja h2, lahko menjam in doplačam z hondo crf 250.\r\n\r\nLP,\r\nJure Vojska', 60000, 'novo', '2020-04-16', '2020-05-16', 'DA');

-- --------------------------------------------------------

--
-- Struktura tabele `povezava_ocen`
--

CREATE TABLE `povezava_ocen` (
  `id_ocenjevalca` int(11) DEFAULT NULL,
  `id_ocenjenega` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabele `slike_oglasov`
--

CREATE TABLE `slike_oglasov` (
  `id_oglasa` int(11) NOT NULL,
  `slika1` varchar(255) DEFAULT NULL,
  `slika2` varchar(255) DEFAULT NULL,
  `slika3` varchar(255) DEFAULT NULL,
  `slika4` varchar(255) DEFAULT NULL,
  `slika5` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `slike_oglasov`
--

INSERT INTO `slike_oglasov` (`id_oglasa`, `slika1`, `slika2`, `slika3`, `slika4`, `slika5`) VALUES
(2, '1_1586978030_frnikule3.jpg', NULL, NULL, NULL, NULL),
(3, '1_1586978086_1f359750c97a2c34c2ff.jpeg', '1_1586978086_d3f870f8f69b304fd338-planet-kock-kreacije-iz-lego-kock.jpeg', '1_1586978086_lego-inter.jpg', '1_1586978086_lego-kocke.jpg', NULL),
(4, '1_1586978589_j3.jpg', NULL, NULL, NULL, NULL),
(5, '1_1586978788_Football_Pallo_valmiina-cropped.jpg', '1_1586978788_images.jpg', '1_1586978788_soccer-ball.jpg', NULL, NULL),
(6, NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, NULL, NULL),
(8, NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL),
(11, NULL, NULL, NULL, NULL, NULL),
(12, NULL, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, NULL, NULL),
(14, NULL, NULL, NULL, NULL, NULL),
(15, NULL, NULL, NULL, NULL, NULL),
(16, NULL, NULL, NULL, NULL, NULL),
(17, NULL, NULL, NULL, NULL, NULL),
(18, NULL, NULL, NULL, NULL, NULL),
(19, NULL, NULL, NULL, NULL, NULL),
(20, NULL, NULL, NULL, NULL, NULL),
(21, NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL),
(23, NULL, NULL, NULL, NULL, NULL),
(24, NULL, NULL, NULL, NULL, NULL),
(25, NULL, NULL, NULL, NULL, NULL),
(26, NULL, NULL, NULL, NULL, NULL),
(27, NULL, NULL, NULL, NULL, NULL),
(28, NULL, NULL, NULL, NULL, NULL),
(29, NULL, NULL, NULL, NULL, NULL),
(30, NULL, NULL, NULL, NULL, NULL),
(31, NULL, NULL, NULL, NULL, NULL),
(32, NULL, NULL, NULL, NULL, NULL),
(33, NULL, NULL, NULL, NULL, NULL),
(34, NULL, NULL, NULL, NULL, NULL),
(35, NULL, NULL, NULL, NULL, NULL),
(36, '4_1587039679_crf250.jpg', '4_1587039679_crf2501.jpg', NULL, NULL, NULL),
(37, '4_1587039737_ninjah2.png', '4_1587039737_ninjah22.jpg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabele `uporabniki`
--

CREATE TABLE `uporabniki` (
  `id` int(11) NOT NULL,
  `up_ime` varchar(25) NOT NULL,
  `geslo` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefonska` varchar(15) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `priimek` varchar(50) NOT NULL,
  `profilna_slika` varchar(255) DEFAULT NULL,
  `datum_nastanka` date NOT NULL,
  `g_datum` date DEFAULT NULL,
  `s_datum` date DEFAULT NULL,
  `i_datum` date DEFAULT NULL,
  `t_datum` date DEFAULT NULL,
  `cas_prve_objave` bigint(20) DEFAULT NULL,
  `stevec_objav` tinyint(4) NOT NULL DEFAULT 0,
  `st_vseh_objav` tinyint(4) NOT NULL DEFAULT 0,
  `aktivnost` enum('DA','NE') NOT NULL,
  `pravice` enum('DA','NE') NOT NULL,
  `token` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `uporabniki`
--

INSERT INTO `uporabniki` (`id`, `up_ime`, `geslo`, `email`, `telefonska`, `ime`, `priimek`, `profilna_slika`, `datum_nastanka`, `g_datum`, `s_datum`, `i_datum`, `t_datum`, `cas_prve_objave`, `stevec_objav`, `st_vseh_objav`, `aktivnost`, `pravice`, `token`) VALUES
(1, 'heromaster', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'adam.mark@gmail.com', '909-909-909', 'Mark', 'Adam', 'uporabnik.png', '2020-04-15', NULL, NULL, NULL, NULL, 1586984859, 3, 16, 'DA', 'NE', NULL),
(3, 'zagarca', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'tilen.zagar@gmail.com', '909-443-900', 'Tilen', 'Žagar', 'uporabnik.png', '2020-04-15', NULL, NULL, NULL, NULL, 1586990262, 2, 17, 'DA', 'NE', NULL),
(4, 'DGVoJu', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'jur.voj@gmail.com', '887-666-099', 'Jure', 'Vojska', 'uporabnik.png', '2020-04-15', NULL, NULL, NULL, NULL, 1587050479, 2, 2, 'DA', 'NE', NULL),
(5, 'Administrator', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'jankovec.zan@gmail.com', '909-909-909', 'Žan', 'Jankovec', 'uporabnik.png', '2020-04-15', NULL, NULL, NULL, NULL, NULL, 0, 0, 'DA', 'DA', NULL);

--
-- Sprožilci `uporabniki`
--
DELIMITER $$
CREATE TRIGGER `v_zacetnica_insert` BEFORE INSERT ON `uporabniki` FOR EACH ROW BEGIN
SET new.ime = concat(upper(substring(new.ime FROM 1 for 1)),lower(substring(new.ime FROM 2 for char_length(new.ime)-1)));
SET new.priimek = concat(upper(substring(new.priimek FROM 1 for 1)),lower(substring(new.priimek FROM 2 for char_length(new.priimek)-1)));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `v_zacetnica_update` BEFORE UPDATE ON `uporabniki` FOR EACH ROW BEGIN
SET new.ime = concat(upper(substring(new.ime FROM 1 for 1)),lower(substring(new.ime FROM 2 for char_length(new.ime)-1)));
SET new.priimek = concat(upper(substring(new.priimek FROM 1 for 1)),lower(substring(new.priimek FROM 2 for char_length(new.priimek)-1)));
END
$$
DELIMITER ;

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `ocene_uporabnikov`
--
ALTER TABLE `ocene_uporabnikov`
  ADD PRIMARY KEY (`id_uporabnika`);

--
-- Indeksi tabele `oglasi`
--
ALTER TABLE `oglasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uporabnika` (`id_uporabnika`);

--
-- Indeksi tabele `povezava_ocen`
--
ALTER TABLE `povezava_ocen`
  ADD KEY `id_ocenjevalca` (`id_ocenjevalca`),
  ADD KEY `id_ocenjenega` (`id_ocenjenega`);

--
-- Indeksi tabele `slike_oglasov`
--
ALTER TABLE `slike_oglasov`
  ADD PRIMARY KEY (`id_oglasa`);

--
-- Indeksi tabele `uporabniki`
--
ALTER TABLE `uporabniki`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_up_ime` (`up_ime`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `oglasi`
--
ALTER TABLE `oglasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT tabele `uporabniki`
--
ALTER TABLE `uporabniki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `ocene_uporabnikov`
--
ALTER TABLE `ocene_uporabnikov`
  ADD CONSTRAINT `ocene_uporabnikov_ibfk_1` FOREIGN KEY (`id_uporabnika`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `oglasi`
--
ALTER TABLE `oglasi`
  ADD CONSTRAINT `oglasi_ibfk_1` FOREIGN KEY (`id_uporabnika`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `povezava_ocen`
--
ALTER TABLE `povezava_ocen`
  ADD CONSTRAINT `povezava_ocen_ibfk_1` FOREIGN KEY (`id_ocenjevalca`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `povezava_ocen_ibfk_2` FOREIGN KEY (`id_ocenjenega`) REFERENCES `ocene_uporabnikov` (`id_uporabnika`) ON DELETE CASCADE;

--
-- Omejitve za tabelo `slike_oglasov`
--
ALTER TABLE `slike_oglasov`
  ADD CONSTRAINT `slike_oglasov_ibfk_1` FOREIGN KEY (`id_oglasa`) REFERENCES `oglasi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
