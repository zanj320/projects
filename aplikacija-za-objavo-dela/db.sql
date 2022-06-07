--DODATNO--
drop database if exists NajdiDelo;
create database NajdiDelo;
use NajdiDelo;

drop table if exists Delo;

drop table if exists Lastnik;

drop table if exists Podjetje;

drop table if exists Prosnja;

drop table if exists Uporabnik;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 28. maj 2022 ob 21.33
-- Različica strežnika: 10.4.21-MariaDB
-- Različica PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `najdidelo`
--

-- --------------------------------------------------------

--
-- Struktura tabele `delo`
--

CREATE TABLE `delo` (
  `id_delo` int(11) NOT NULL,
  `id_podjetje` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `opis` text DEFAULT NULL,
  `placa` float NOT NULL,
  `datum_objave` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `delo`
--

INSERT INTO `delo` (`id_delo`, `id_podjetje`, `naziv`, `opis`, `placa`, `datum_objave`) VALUES
(1, 3, 'Popravilo harmonik', 'Iščem delovnega človeka z izkušnjami za popravilo harmonik.\r\n\r\nPriporočljivo 20 let izkušenj saj  je podjetje profesionalno ocenjeno s desetimi zvezdicami.\r\n\r\nJavite se mi na 909 223 111.\r\nLE RESNI!', 20.5, '2022-05-27'),
(2, 4, 'Upravljalec bagra', 'Iščem radovednega in izkušenega operatorja\r\n\r\nPogoj je potreben izpit TGM, upravljanje z težkimi bagri (nad 25ton).\r\n\r\nPišite na lojze.slak@gmail.com. Brez zaje*ncij.\r\n\r\nPišite resni.\r\nPišite resni.', 12, '2022-05-27'),
(3, 4, 'Traktorist na gradbišču', 'kdorkoli', 4.8, '2022-05-27'),
(4, 3, 'izbriši me', 'izbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši me\r\n\r\nizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši me\r\nizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši me', 900, '2022-05-27'),
(5, 5, 'Programer', 'Podjetje išče programerja/ko z znanjem in izkušnjami s področja programiranja za mobilno platformo Android (Kotlin, Jetpack). Višja urna postavka za uspešno in hitro rešeno delo.\r\n\r\nPrijavo pošljete na email brankokozjek@posek.si.\r\n\r\n\r\nblab blab bla', 16, '2022-05-28');

-- --------------------------------------------------------

--
-- Struktura tabele `lastnik`
--

CREATE TABLE `lastnik` (
  `id_lastnik` int(11) NOT NULL,
  `ime` varchar(255) NOT NULL,
  `priimek` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `geslo` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `telefon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `lastnik`
--

INSERT INTO `lastnik` (`id_lastnik`, `ime`, `priimek`, `email`, `geslo`, `role`, `telefon`) VALUES
(2, 'Branko', 'Kozjek', 'brankokozjek@posek.si', '$2y$10$HQ8NzMT1GSejadvVtKq1lOPzYUap0Y9kblVCp59wz2eHvR1aYOIG2', 'company', '051909313'),
(3, 'Lojze', 'Slak', 'lojze.slak@gmail.com', '$2y$10$LwOmpwsSbWCEp3xroo6L5.uHs82Jn4v6r9r0VAnFELRe5SfR67r9S', 'company', '031222545');

-- --------------------------------------------------------

--
-- Struktura tabele `podjetje`
--

CREATE TABLE `podjetje` (
  `id_podjetje` int(11) NOT NULL,
  `id_lastnik` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `naslov` varchar(255) NOT NULL,
  `postna_st` int(11) NOT NULL,
  `davcna` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `podjetje`
--

INSERT INTO `podjetje` (`id_podjetje`, `id_lastnik`, `naziv`, `naslov`, `postna_st`, `davcna`) VALUES
(2, 2, 'Posek in spravilo lesa s.p.', 'Polhov gradec 12', 1355, '85218521'),
(3, 3, 'Popravilo harmonik s.p.', 'Kotnikova 17', 1000, '12349999'),
(4, 3, 'TGM storitve Slak d.o.o.', 'Potrebuježeva 19a', 3000, '42191209'),
(5, 2, 'Podjetje za izbris', 'Kraberjeva ulica 11', 1355, '11111111');

-- --------------------------------------------------------

--
-- Struktura tabele `prosnja`
--

CREATE TABLE `prosnja` (
  `id_uporabnik` int(11) NOT NULL,
  `id_delo` int(11) NOT NULL,
  `besedilo` text DEFAULT NULL,
  `obravnava` varchar(255) DEFAULT NULL,
  `datum_izdaje` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `prosnja`
--

INSERT INTO `prosnja` (`id_uporabnik`, `id_delo`, `besedilo`, `obravnava`, `datum_izdaje`) VALUES
(2, 2, 'Pozdravljeni,\r\n\r\nrad bi se prijavil na vaše delo (iskanje izkušenega operaterja), imam 25 let izkušenj na 20 tonskem bagru\r\n\r\nPogoj: izvišanje plače po prvem mesecu na 15€/h.\r\n\r\nLP,\r\nGašper Kadivec', NULL, '2022-05-27'),
(2, 4, 'Ponesreči prijava,\r\n\r\nizbriši me izbriši meizbriši meizbriši meizbriši meizbriši me izbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši meizbriši me\r\n\r\nizbriši me, izbriši me', NULL, '2022-05-27'),
(3, 3, 'Pozdravljeni,\r\n\r\nprijavil vas bom, da za tako majhno ceno objavljate fizična dela. Res ogabno\r\n\r\nUpam da posodobite to delo!!!!!!!!!!!!\r\n\r\nLP,\r\nMatej', NULL, '2022-05-27');

-- --------------------------------------------------------

--
-- Struktura tabele `uporabnik`
--

CREATE TABLE `uporabnik` (
  `id_uporabnik` int(11) NOT NULL,
  `ime` varchar(255) NOT NULL,
  `priimek` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `geslo` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `telefon` varchar(255) NOT NULL,
  `datum_rojstva` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Odloži podatke za tabelo `uporabnik`
--

INSERT INTO `uporabnik` (`id_uporabnik`, `ime`, `priimek`, `email`, `geslo`, `role`, `telefon`, `datum_rojstva`) VALUES
(2, 'Gašper', 'Kadivec', 'gasper.kadivec@gmail.com', '$2y$10$y/.BbVDN/IlVrHs1hRO1kutGYcH3QZ15heIUfuVIAedZcXQ3pVrg2', 'user', '051400770', '2001-08-27'),
(3, 'Matej', 'Struna', 'matej.struna@hotmail.si', '$2y$10$uLdMthcbjKVvJ3738zfLB.z4KXYmQEzGz66k86mKiJve2cgmMIjfW', 'user', '041994213', '1996-02-27'),
(4, 'Jošt', 'Kunk', 'jost@gmail.com', '$2y$10$qev9m0QArmUYz2h4DraFBu3lXkJTHwvqOhSEvwfoGCYp.g5zhhr/m', 'user', '041556423', '1982-01-27');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `delo`
--
ALTER TABLE `delo`
  ADD PRIMARY KEY (`id_delo`),
  ADD KEY `FK_Relationship_2` (`id_podjetje`);

--
-- Indeksi tabele `lastnik`
--
ALTER TABLE `lastnik`
  ADD PRIMARY KEY (`id_lastnik`),
  ADD UNIQUE KEY `Unique_email_2` (`email`);

--
-- Indeksi tabele `podjetje`
--
ALTER TABLE `podjetje`
  ADD PRIMARY KEY (`id_podjetje`),
  ADD UNIQUE KEY `Unique_davcna_1` (`davcna`),
  ADD KEY `FK_Relationship_4` (`id_lastnik`);

--
-- Indeksi tabele `prosnja`
--
ALTER TABLE `prosnja`
  ADD PRIMARY KEY (`id_uporabnik`,`id_delo`),
  ADD KEY `FK_Relationship_3` (`id_delo`);

--
-- Indeksi tabele `uporabnik`
--
ALTER TABLE `uporabnik`
  ADD PRIMARY KEY (`id_uporabnik`),
  ADD UNIQUE KEY `Unique_email_1` (`email`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `delo`
--
ALTER TABLE `delo`
  MODIFY `id_delo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT tabele `lastnik`
--
ALTER TABLE `lastnik`
  MODIFY `id_lastnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT tabele `podjetje`
--
ALTER TABLE `podjetje`
  MODIFY `id_podjetje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT tabele `uporabnik`
--
ALTER TABLE `uporabnik`
  MODIFY `id_uporabnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `delo`
--
ALTER TABLE `delo`
  ADD CONSTRAINT `FK_Relationship_2` FOREIGN KEY (`id_podjetje`) REFERENCES `podjetje` (`id_podjetje`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omejitve za tabelo `podjetje`
--
ALTER TABLE `podjetje`
  ADD CONSTRAINT `FK_Relationship_4` FOREIGN KEY (`id_lastnik`) REFERENCES `lastnik` (`id_lastnik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omejitve za tabelo `prosnja`
--
ALTER TABLE `prosnja`
  ADD CONSTRAINT `FK_Relationship_1` FOREIGN KEY (`id_uporabnik`) REFERENCES `uporabnik` (`id_uporabnik`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Relationship_3` FOREIGN KEY (`id_delo`) REFERENCES `delo` (`id_delo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
