-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 30 jan 2018 om 16:01
-- Serverversie: 5.4.3-beta-community-log
-- PHP-versie: 7.0.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `thijsboerma_chardb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_characters`
--

DROP TABLE IF EXISTS `ecc_characters`;
CREATE TABLE IF NOT EXISTS `ecc_characters` (
  `characterID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `character_name` varchar(100) DEFAULT NULL,
  `oc_name` varchar(75) DEFAULT NULL,
  `faction` varchar(25) NOT NULL,
  `aantal_events` int(11) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'in design',
  `ic_age` int(11) NOT NULL DEFAULT '0',
  `birthplanet` varchar(25) DEFAULT NULL,
  `homeplanet` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`characterID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Gegevens worden uitgevoerd voor tabel `ecc_characters`
--

INSERT INTO `ecc_characters` (`characterID`, `accountID`, `character_name`, `oc_name`, `faction`, `aantal_events`, `status`, `ic_age`, `birthplanet`, `homeplanet`) VALUES
(1, 451, 'Maati Infor Danam', 'Thijs Test', 'Dugo', 5, 'in design', 0, NULL, NULL),
(2, 451, 'Bakal Duguan Tulos', 'Thijs Boerma', 'Dugo', 4, 'deceased', 0, NULL, NULL),
(3, 451, 'Kadh Rusks', 'Thijs Boerma', 'Aquila', 1, 'inactive', 0, NULL, NULL),
(21, 451, NULL, NULL, 'ekanesh', 0, 'in design', 0, NULL, NULL),
(22, 452, NULL, NULL, 'sona', 0, 'in design', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_char_implants`
--

DROP TABLE IF EXISTS `ecc_char_implants`;
CREATE TABLE IF NOT EXISTS `ecc_char_implants` (
  `modifierID` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `type` varchar(25) NOT NULL DEFAULT 'cybernetic',
  `skillgroup_level` int(11) NOT NULL DEFAULT '0',
  `skillgroup_siteindex` varchar(15) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`modifierID`),
  KEY `characterID` (`characterID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_char_sheet`
--

DROP TABLE IF EXISTS `ecc_char_sheet`;
CREATE TABLE IF NOT EXISTS `ecc_char_sheet` (
  `charSheetID` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'ontwerp',
  `eventName` varchar(25) DEFAULT NULL,
  `versionNumber` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`charSheetID`),
  KEY `characterID` (`characterID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Gegevens worden uitgevoerd voor tabel `ecc_char_sheet`
--

INSERT INTO `ecc_char_sheet` (`charSheetID`, `characterID`, `accountID`, `status`, `eventName`, `versionNumber`) VALUES
(1, 1, 451, 'ontwerp', 'Frontier9', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_factionmodifiers`
--

DROP TABLE IF EXISTS `ecc_factionmodifiers`;
CREATE TABLE IF NOT EXISTS `ecc_factionmodifiers` (
  `factionID` int(11) NOT NULL,
  `faction_siteindex` varchar(20) NOT NULL DEFAULT 'aquila',
  `type` varchar(15) NOT NULL DEFAULT 'weakness',
  `skillgroup_siteindex` varchar(15) NOT NULL,
  `cost_modifier` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_skills_allskills`
--

DROP TABLE IF EXISTS `ecc_skills_allskills`;
CREATE TABLE IF NOT EXISTS `ecc_skills_allskills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `skill_index` varchar(15) NOT NULL,
  `parent` varchar(15) NOT NULL,
  `level` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_skills_groups`
--

DROP TABLE IF EXISTS `ecc_skills_groups`;
CREATE TABLE IF NOT EXISTS `ecc_skills_groups` (
  `primaryskill_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `siteindex` varchar(15) NOT NULL,
  `parent` varchar(15) DEFAULT 'none',
  `status` varchar(15) DEFAULT 'active',
  PRIMARY KEY (`primaryskill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12056 ;

--
-- Gegevens worden uitgevoerd voor tabel `ecc_skills_groups`
--

INSERT INTO `ecc_skills_groups` (`primaryskill_id`, `name`, `siteindex`, `parent`, `status`) VALUES
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
