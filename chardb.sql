-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< HEAD
-- Gegenereerd op: 27 jan 2018 om 17:52
=======
-- Gegenereerd op: 25 jan 2018 om 01:29
>>>>>>> f6ecf7c985e6fb5617e15f20b9d5548c8da0f1a4
-- Serverversie: 10.1.26-MariaDB
-- PHP-versie: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chardb`
--
<<<<<<< HEAD
=======
CREATE DATABASE IF NOT EXISTS `chardb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `chardb`;
>>>>>>> f6ecf7c985e6fb5617e15f20b9d5548c8da0f1a4

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `characters`
--

DROP TABLE IF EXISTS `characters`;
CREATE TABLE `characters` (
  `characterID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `character_name` varchar(100) NOT NULL,
  `oc_name` varchar(75) NOT NULL,
  `faction` varchar(25) NOT NULL,
<<<<<<< HEAD
  `aantal_events` int(11) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'design'
=======
  `aantal_events` int(11) NOT NULL DEFAULT '0'
>>>>>>> f6ecf7c985e6fb5617e15f20b9d5548c8da0f1a4
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `characters`
--

<<<<<<< HEAD
INSERT INTO `characters` (`characterID`, `accountID`, `character_name`, `oc_name`, `faction`, `aantal_events`, `status`) VALUES
(1, 451, 'Maati Infor Danam', 'Thijs Test', 'Dugo', 5, 'in design'),
(2, 451, 'Bakal Duguan Tulos', 'Thijs Boerma', 'Dugo', 4, 'deceased'),
(3, 451, 'Kadh Rusks', 'Thijs Boerma', 'Aquila', 1, 'inactive');
=======
INSERT INTO `characters` (`characterID`, `accountID`, `character_name`, `oc_name`, `faction`, `aantal_events`) VALUES
(1, 451, 'Maati Infor Danam', 'Thijs Test', 'Dugo', 5);
>>>>>>> f6ecf7c985e6fb5617e15f20b9d5548c8da0f1a4

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `char_sheet`
--

DROP TABLE IF EXISTS `char_sheet`;
CREATE TABLE `char_sheet` (
  `charSheetID` int(11) NOT NULL,
  `characterID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'ontwerp',
  `eventName` varchar(25) DEFAULT NULL,
  `versionNumber` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `char_sheet`
--

INSERT INTO `char_sheet` (`charSheetID`, `characterID`, `accountID`, `status`, `eventName`, `versionNumber`) VALUES
(1, 1, 451, 'ontwerp', 'Frontier9', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `skills_details`
--

DROP TABLE IF EXISTS `skills_details`;
CREATE TABLE `skills_details` (
  `skills_id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `skill_index` varchar(15) NOT NULL,
  `parent` varchar(15) NOT NULL,
  `level` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `skills_primair`
--

DROP TABLE IF EXISTS `skills_primair`;
CREATE TABLE `skills_primair` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `siteindex` varchar(15) NOT NULL,
  `parent` varchar(15) DEFAULT 'none',
  `status` varchar(15) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `skills_primair`
--

INSERT INTO `skills_primair` (`id`, `name`, `siteindex`, `parent`, `status`) VALUES
(12000, 'Ballistiek', 'guns', 'none', 'active'),
(12001, 'Melee', 'melee', 'none', 'active'),
(12002, 'Bescherming', 'besch', 'none', 'active'),
(12003, 'Wilskracht', 'will', 'none', 'active'),
(12004, 'Conditie', 'cond', 'none', 'active'),
(12005, 'Ingenieur', 'engi', 'none', 'active'),
(12006, 'Informatica', 'it', 'none', 'active'),
(12007, 'Gewondenhulp', 'firstaid', 'none', 'active'),
(12008, 'Geneeskunde', 'surgery', 'none', 'active'),
(12009, 'Telepsychica', 'tele', 'none', 'active'),
(12010, 'Informatie-analyse', 'intel', 'none', 'active'),
(12011, 'Politicologie', 'politic', 'none', 'active'),
(12012, 'Economie', 'eco', 'none', 'active'),
(12013, 'Geologie', 'geo', 'none', 'active'),
(12014, 'Chemie', 'chem', 'none', 'active'),
(12015, 'Genie', 'genie', 'guns', 'active'),
(12016, 'Tacticus', 'tacticus', 'guns', 'active'),
(12017, 'Sluipschutter', 'sniper', 'guns', 'active'),
(12018, 'CQB', 'cqb', 'melee', 'active'),
(12019, 'eskrima', 'eskrima', 'melee', 'active'),
(12020, 'Aegis', 'aegis', 'besch', 'active'),
(12021, 'Powerarmour', 'powarm', 'besch', 'active'),
(12022, 'CBRN', 'cbrn', 'besch', 'active'),
(12023, 'Psy-Ops', 'will', 'none', 'active'),
(12024, 'Synergist', 'synerg', 'will', 'active'),
(12025, 'Onverzettelijk', 'onverz', 'will', 'active'),
(12026, 'Ijzervreter', 'ijzvreter', 'cond', 'active'),
(12027, 'Cyborg', 'cyborg', 'cond', 'active'),
(12028, 'Behendigheid', 'behendi', 'none', 'active'),
(12029, 'Infiltratie-specialist', 'infiltr', 'behendi', 'active'),
(12030, 'Gevechtspiloot', 'pilot', 'behendi', 'active'),
(12031, 'Portaal-Technicus', 'portal', 'engi', 'active'),
(12032, 'Geo-Tech', 'geotech', 'engi', 'active'),
(12033, 'Stimm-Specialist', 'stimm', 'firstaid', 'active'),
(12034, 'Med-Evac specialist', 'medevac', 'firstaid', 'active'),
(12035, 'Trauma-chirgurgie', 'traumsurg', 'surgeon', 'active'),
(12036, 'Forensisch expert', 'forensi', 'surgeon', 'active'),
(12037, 'Spiritualist', 'spirit', 'tele', 'active'),
(12038, 'Waker', 'waker', 'tele', 'active'),
(12039, 'Evangelist', 'evangel', 'tele', 'active'),
(12040, 'Strijder', 'strijd', 'tele', 'active'),
(12041, 'New Age', 'newage', 'tele', 'active'),
(12042, 'Douane beampte', 'doaune', 'intel', 'active'),
(12043, 'The Operative', 'operative', 'intel', 'active'),
(12044, 'Journalist', 'journal', 'intel', 'active'),
(12045, 'Oud geld', 'oudgeld', 'eco', 'active'),
(12046, 'Sjacheraar', 'sjach', 'eco', 'active'),
(12047, 'Dealmaker', 'dealmk', 'eco', 'active'),
(12048, 'Xeno-Botanist', 'xeno', 'chem', 'active'),
(12049, 'Superkritische extractie', 'superextr', 'chem', 'active'),
(12050, 'Magneto-Tellurische exploitatie', 'mtexpl', 'geo', 'active'),
(12051, 'Bot-jockey', 'botjock', 'geo', 'active'),
(12052, 'Deep space mining', 'spacemine', 'geo', 'active'),
(12053, 'Factiepoliticus', 'factiepoli', 'politic', 'active'),
(12054, 'ICC lobbyist', 'icclobby', 'politic', 'active'),
(12055, 'Generalist', 'polgener', 'politic', 'active');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`characterID`);

--
-- Indexen voor tabel `char_sheet`
--
ALTER TABLE `char_sheet`
  ADD PRIMARY KEY (`charSheetID`),
  ADD KEY `characterID` (`characterID`);

--
-- Indexen voor tabel `skills_details`
--
ALTER TABLE `skills_details`
  ADD PRIMARY KEY (`skills_id`);

--
-- Indexen voor tabel `skills_primair`
--
ALTER TABLE `skills_primair`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `characters`
--
ALTER TABLE `characters`
<<<<<<< HEAD
  MODIFY `characterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
=======
  MODIFY `characterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> f6ecf7c985e6fb5617e15f20b9d5548c8da0f1a4
--
-- AUTO_INCREMENT voor een tabel `char_sheet`
--
ALTER TABLE `char_sheet`
  MODIFY `charSheetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `skills_details`
--
ALTER TABLE `skills_details`
  MODIFY `skills_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `skills_primair`
--
ALTER TABLE `skills_primair`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12056;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
