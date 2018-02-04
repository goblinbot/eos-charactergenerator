-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 04 feb 2018 om 16:15
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

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_characters`
--

DROP TABLE IF EXISTS `ecc_characters`;
CREATE TABLE `ecc_characters` (
  `characterID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `character_name` varchar(100) DEFAULT NULL,
  `ICC_number` int(15) NOT NULL DEFAULT '0',
  `oc_name` varchar(75) DEFAULT NULL,
  `faction` varchar(25) NOT NULL,
  `aantal_events` int(11) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'in design',
  `ic_birthday` varchar(25) DEFAULT NULL,
  `birthplanet` varchar(25) DEFAULT NULL,
  `homeplanet` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_characters`
--

INSERT INTO `ecc_characters` (`characterID`, `accountID`, `character_name`, `ICC_number`, `oc_name`, `faction`, `aantal_events`, `status`, `ic_birthday`, `birthplanet`, `homeplanet`) VALUES
(1, 451, 'Maati Infor Danam', 0, 'Thijs Test', 'Dugo', 5, 'in design', '0', 'Kaito', 'Eos'),
(2, 451, 'Bakal Duguan Tulos', 0, 'Thijs Boerma', 'Dugo', 4, 'deceased', '0', 'Kaito', 'Noboru'),
(3, 451, 'Kadh Rusks', 0, 'Thijs Boerma', 'Aquila', 1, 'inactive', '0', 'Nadz', 'Sturnus'),
(21, 451, 'Maati Priscus Testus', 0, NULL, 'ekanesh', 1, 'in design', '12-12-240NT', 'Test2', 'Test12'),
(22, 452, NULL, 0, NULL, 'sona', 0, 'in design', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_char_implants`
--

DROP TABLE IF EXISTS `ecc_char_implants`;
CREATE TABLE `ecc_char_implants` (
  `modifierID` int(11) NOT NULL,
  `characterID` int(11) NOT NULL,
  `type` varchar(25) NOT NULL DEFAULT 'cybernetic',
  `skillgroup_level` int(11) NOT NULL DEFAULT '0',
  `skillgroup_siteindex` varchar(15) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_char_sheet`
--

DROP TABLE IF EXISTS `ecc_char_sheet`;
CREATE TABLE `ecc_char_sheet` (
  `charSheetID` int(11) NOT NULL,
  `characterID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'ontwerp',
  `eventName` varchar(25) DEFAULT NULL,
  `versionNumber` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_char_sheet`
--

INSERT INTO `ecc_char_sheet` (`charSheetID`, `characterID`, `accountID`, `status`, `eventName`, `versionNumber`) VALUES
(1, 1, 451, 'ontwerp', 'Frontier9', 2),
(4, 2, 451, 'ontwerp', 'Frontier9', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_char_skills`
--

DROP TABLE IF EXISTS `ecc_char_skills`;
CREATE TABLE `ecc_char_skills` (
  `id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `char_sheet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_char_skills`
--

INSERT INTO `ecc_char_skills` (`id`, `skill_id`, `char_sheet_id`) VALUES
(8, 31012, 1),
(9, 31013, 1),
(10, 31014, 1),
(11, 31017, 1),
(12, 31022, 1),
(13, 31023, 1),
(14, 31027, 1),
(15, 31028, 1),
(16, 31029, 1),
(17, 31032, 1),
(18, 31033, 1),
(19, 31034, 1),
(20, 31042, 1),
(21, 31043, 1),
(22, 31044, 1),
(23, 31045, 1),
(24, 31046, 1),
(25, 31297, 1),
(26, 31298, 1),
(27, 31299, 1),
(28, 31300, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_factionmodifiers`
--

DROP TABLE IF EXISTS `ecc_factionmodifiers`;
CREATE TABLE `ecc_factionmodifiers` (
  `factionID` int(11) NOT NULL,
  `faction_siteindex` varchar(20) NOT NULL DEFAULT 'aquila',
  `type` varchar(10) NOT NULL DEFAULT 'strong',
  `skill_id` int(11) NOT NULL,
  `cost_modifier` int(5) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_factionmodifiers`
--

INSERT INTO `ecc_factionmodifiers` (`factionID`, `faction_siteindex`, `type`, `skill_id`, `cost_modifier`) VALUES
(1, 'aquila', 'strong', 12002, -1),
(2, 'aquila', 'strong', 12007, -1),
(3, 'aquila', 'weak', 12012, 5),
(4, 'dugo', 'strong', 12001, -1),
(5, 'dugo', 'strong', 12003, -1),
(6, 'dugo', 'weak', 12007, 5),
(7, 'ekanesh', 'enable', 12009, 1),
(8, 'ekanesh', 'weak', 12000, 5),
(9, 'pendzal', 'strong', 12004, -1),
(10, 'pendzal', 'strong', 12005, -1),
(11, 'pendzal', 'weak', 12010, 5),
(12, 'sona', 'strong', 12012, -1),
(13, 'sona', 'strong', 12010, -1),
(14, 'sona', 'weak', 12003, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_skills_allskills`
--

DROP TABLE IF EXISTS `ecc_skills_allskills`;
CREATE TABLE `ecc_skills_allskills` (
  `skill_id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `skill_index` varchar(15) NOT NULL,
  `parent` varchar(15) NOT NULL,
  `level` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_skills_allskills`
--

INSERT INTO `ecc_skills_allskills` (`skill_id`, `label`, `skill_index`, `parent`, `level`, `version`, `description`) VALUES
(31012, 'Skill guns 1', 'guns_1', 'guns', 1, 1, 'Skill description'),
(31013, 'Skill guns 2', 'guns_2', 'guns', 2, 1, 'Skill description'),
(31014, 'Skill guns 3', 'guns_3', 'guns', 3, 1, 'Skill description'),
(31015, 'Skill guns 4', 'guns_4', 'guns', 4, 1, 'Skill description'),
(31016, 'Skill guns 5', 'guns_5', 'guns', 5, 1, 'Skill description'),
(31017, 'Skill melee 1', 'melee_1', 'melee', 1, 1, 'Skill description'),
(31018, 'Skill melee 2', 'melee_2', 'melee', 2, 1, 'Skill description'),
(31019, 'Skill melee 3', 'melee_3', 'melee', 3, 1, 'Skill description'),
(31020, 'Skill melee 4', 'melee_4', 'melee', 4, 1, 'Skill description'),
(31021, 'Skill melee 5', 'melee_5', 'melee', 5, 1, 'Skill description'),
(31022, 'Skill besch 1', 'besch_1', 'besch', 1, 1, 'Skill description'),
(31023, 'Skill besch 2', 'besch_2', 'besch', 2, 1, 'Skill description'),
(31024, 'Skill besch 3', 'besch_3', 'besch', 3, 1, 'Skill description'),
(31025, 'Skill besch 4', 'besch_4', 'besch', 4, 1, 'Skill description'),
(31026, 'Skill besch 5', 'besch_5', 'besch', 5, 1, 'Skill description'),
(31027, 'Skill will 1', 'will_1', 'will', 1, 1, 'Skill description'),
(31028, 'Skill will 2', 'will_2', 'will', 2, 1, 'Skill description'),
(31029, 'Skill will 3', 'will_3', 'will', 3, 1, 'Skill description'),
(31030, 'Skill will 4', 'will_4', 'will', 4, 1, 'Skill description'),
(31031, 'Skill will 5', 'will_5', 'will', 5, 1, 'Skill description'),
(31032, 'Skill cond 1', 'cond_1', 'cond', 1, 1, 'Skill description'),
(31033, 'Skill cond 2', 'cond_2', 'cond', 2, 1, 'Skill description'),
(31034, 'Skill cond 3', 'cond_3', 'cond', 3, 1, 'Skill description'),
(31035, 'Skill cond 4', 'cond_4', 'cond', 4, 1, 'Skill description'),
(31036, 'Skill cond 5', 'cond_5', 'cond', 5, 1, 'Skill description'),
(31037, 'Skill engi 1', 'engi_1', 'engi', 1, 1, 'Skill description'),
(31038, 'Skill engi 2', 'engi_2', 'engi', 2, 1, 'Skill description'),
(31039, 'Skill engi 3', 'engi_3', 'engi', 3, 1, 'Skill description'),
(31040, 'Skill engi 4', 'engi_4', 'engi', 4, 1, 'Skill description'),
(31041, 'Skill engi 5', 'engi_5', 'engi', 5, 1, 'Skill description'),
(31042, 'Skill it 1', 'it_1', 'it', 1, 1, 'Skill description'),
(31043, 'Skill it 2', 'it_2', 'it', 2, 1, 'Skill description'),
(31044, 'Skill it 3', 'it_3', 'it', 3, 1, 'Skill description'),
(31045, 'Skill it 4', 'it_4', 'it', 4, 1, 'Skill description'),
(31046, 'Skill it 5', 'it_5', 'it', 5, 1, 'Skill description'),
(31047, 'Skill firstaid 1', 'firstaid_1', 'firstaid', 1, 1, 'Skill description'),
(31048, 'Skill firstaid 2', 'firstaid_2', 'firstaid', 2, 1, 'Skill description'),
(31049, 'Skill firstaid 3', 'firstaid_3', 'firstaid', 3, 1, 'Skill description'),
(31050, 'Skill firstaid 4', 'firstaid_4', 'firstaid', 4, 1, 'Skill description'),
(31051, 'Skill firstaid 5', 'firstaid_5', 'firstaid', 5, 1, 'Skill description'),
(31052, 'Skill surgery 1', 'surgery_1', 'surgery', 1, 1, 'Skill description'),
(31053, 'Skill surgery 2', 'surgery_2', 'surgery', 2, 1, 'Skill description'),
(31054, 'Skill surgery 3', 'surgery_3', 'surgery', 3, 1, 'Skill description'),
(31055, 'Skill surgery 4', 'surgery_4', 'surgery', 4, 1, 'Skill description'),
(31056, 'Skill surgery 5', 'surgery_5', 'surgery', 5, 1, 'Skill description'),
(31057, 'Skill tele 1', 'tele_1', 'tele', 1, 1, 'Skill description'),
(31058, 'Skill tele 2', 'tele_2', 'tele', 2, 1, 'Skill description'),
(31059, 'Skill tele 3', 'tele_3', 'tele', 3, 1, 'Skill description'),
(31060, 'Skill tele 4', 'tele_4', 'tele', 4, 1, 'Skill description'),
(31061, 'Skill tele 5', 'tele_5', 'tele', 5, 1, 'Skill description'),
(31062, 'Skill intel 1', 'intel_1', 'intel', 1, 1, 'Skill description'),
(31063, 'Skill intel 2', 'intel_2', 'intel', 2, 1, 'Skill description'),
(31064, 'Skill intel 3', 'intel_3', 'intel', 3, 1, 'Skill description'),
(31065, 'Skill intel 4', 'intel_4', 'intel', 4, 1, 'Skill description'),
(31066, 'Skill intel 5', 'intel_5', 'intel', 5, 1, 'Skill description'),
(31067, 'Skill politic 1', 'politic_1', 'politic', 1, 1, 'Skill description'),
(31068, 'Skill politic 2', 'politic_2', 'politic', 2, 1, 'Skill description'),
(31069, 'Skill politic 3', 'politic_3', 'politic', 3, 1, 'Skill description'),
(31070, 'Skill politic 4', 'politic_4', 'politic', 4, 1, 'Skill description'),
(31071, 'Skill politic 5', 'politic_5', 'politic', 5, 1, 'Skill description'),
(31072, 'Skill eco 1', 'eco_1', 'eco', 1, 1, 'Skill description'),
(31073, 'Skill eco 2', 'eco_2', 'eco', 2, 1, 'Skill description'),
(31074, 'Skill eco 3', 'eco_3', 'eco', 3, 1, 'Skill description'),
(31075, 'Skill eco 4', 'eco_4', 'eco', 4, 1, 'Skill description'),
(31076, 'Skill eco 5', 'eco_5', 'eco', 5, 1, 'Skill description'),
(31077, 'Skill geo 1', 'geo_1', 'geo', 1, 1, 'Skill description'),
(31078, 'Skill geo 2', 'geo_2', 'geo', 2, 1, 'Skill description'),
(31079, 'Skill geo 3', 'geo_3', 'geo', 3, 1, 'Skill description'),
(31080, 'Skill geo 4', 'geo_4', 'geo', 4, 1, 'Skill description'),
(31081, 'Skill geo 5', 'geo_5', 'geo', 5, 1, 'Skill description'),
(31082, 'Skill chem 1', 'chem_1', 'chem', 1, 1, 'Skill description'),
(31083, 'Skill chem 2', 'chem_2', 'chem', 2, 1, 'Skill description'),
(31084, 'Skill chem 3', 'chem_3', 'chem', 3, 1, 'Skill description'),
(31085, 'Skill chem 4', 'chem_4', 'chem', 4, 1, 'Skill description'),
(31086, 'Skill chem 5', 'chem_5', 'chem', 5, 1, 'Skill description'),
(31087, 'Skill genie 6', 'genie_6', 'genie', 6, 1, 'Skill description'),
(31088, 'Skill genie 7', 'genie_7', 'genie', 7, 1, 'Skill description'),
(31089, 'Skill genie 8', 'genie_8', 'genie', 8, 1, 'Skill description'),
(31090, 'Skill genie 9', 'genie_9', 'genie', 9, 1, 'Skill description'),
(31091, 'Skill genie 10', 'genie_10', 'genie', 10, 1, 'Skill description'),
(31092, 'Skill tacticus 6', 'tacticus_6', 'tacticus', 6, 1, 'Skill description'),
(31093, 'Skill tacticus 7', 'tacticus_7', 'tacticus', 7, 1, 'Skill description'),
(31094, 'Skill tacticus 8', 'tacticus_8', 'tacticus', 8, 1, 'Skill description'),
(31095, 'Skill tacticus 9', 'tacticus_9', 'tacticus', 9, 1, 'Skill description'),
(31096, 'Skill tacticus 10', 'tacticus_10', 'tacticus', 10, 1, 'Skill description'),
(31097, 'Skill sniper 6', 'sniper_6', 'sniper', 6, 1, 'Skill description'),
(31098, 'Skill sniper 7', 'sniper_7', 'sniper', 7, 1, 'Skill description'),
(31099, 'Skill sniper 8', 'sniper_8', 'sniper', 8, 1, 'Skill description'),
(31100, 'Skill sniper 9', 'sniper_9', 'sniper', 9, 1, 'Skill description'),
(31101, 'Skill sniper 10', 'sniper_10', 'sniper', 10, 1, 'Skill description'),
(31102, 'Skill cqb 6', 'cqb_6', 'cqb', 6, 1, 'Skill description'),
(31103, 'Skill cqb 7', 'cqb_7', 'cqb', 7, 1, 'Skill description'),
(31104, 'Skill cqb 8', 'cqb_8', 'cqb', 8, 1, 'Skill description'),
(31105, 'Skill cqb 9', 'cqb_9', 'cqb', 9, 1, 'Skill description'),
(31106, 'Skill cqb 10', 'cqb_10', 'cqb', 10, 1, 'Skill description'),
(31107, 'Skill eskrima 6', 'eskrima_6', 'eskrima', 6, 1, 'Skill description'),
(31108, 'Skill eskrima 7', 'eskrima_7', 'eskrima', 7, 1, 'Skill description'),
(31109, 'Skill eskrima 8', 'eskrima_8', 'eskrima', 8, 1, 'Skill description'),
(31110, 'Skill eskrima 9', 'eskrima_9', 'eskrima', 9, 1, 'Skill description'),
(31111, 'Skill eskrima 10', 'eskrima_10', 'eskrima', 10, 1, 'Skill description'),
(31112, 'Skill aegis 6', 'aegis_6', 'aegis', 6, 1, 'Skill description'),
(31113, 'Skill aegis 7', 'aegis_7', 'aegis', 7, 1, 'Skill description'),
(31114, 'Skill aegis 8', 'aegis_8', 'aegis', 8, 1, 'Skill description'),
(31115, 'Skill aegis 9', 'aegis_9', 'aegis', 9, 1, 'Skill description'),
(31116, 'Skill aegis 10', 'aegis_10', 'aegis', 10, 1, 'Skill description'),
(31117, 'Skill powarm 6', 'powarm_6', 'powarm', 6, 1, 'Skill description'),
(31118, 'Skill powarm 7', 'powarm_7', 'powarm', 7, 1, 'Skill description'),
(31119, 'Skill powarm 8', 'powarm_8', 'powarm', 8, 1, 'Skill description'),
(31120, 'Skill powarm 9', 'powarm_9', 'powarm', 9, 1, 'Skill description'),
(31121, 'Skill powarm 10', 'powarm_10', 'powarm', 10, 1, 'Skill description'),
(31122, 'Skill cbrn 6', 'cbrn_6', 'cbrn', 6, 1, 'Skill description'),
(31123, 'Skill cbrn 7', 'cbrn_7', 'cbrn', 7, 1, 'Skill description'),
(31124, 'Skill cbrn 8', 'cbrn_8', 'cbrn', 8, 1, 'Skill description'),
(31125, 'Skill cbrn 9', 'cbrn_9', 'cbrn', 9, 1, 'Skill description'),
(31126, 'Skill cbrn 10', 'cbrn_10', 'cbrn', 10, 1, 'Skill description'),
(31127, 'Skill will 1', 'will_1', 'will', 1, 1, 'Skill description'),
(31128, 'Skill will 2', 'will_2', 'will', 2, 1, 'Skill description'),
(31129, 'Skill will 3', 'will_3', 'will', 3, 1, 'Skill description'),
(31130, 'Skill will 4', 'will_4', 'will', 4, 1, 'Skill description'),
(31131, 'Skill will 5', 'will_5', 'will', 5, 1, 'Skill description'),
(31132, 'Skill synerg 6', 'synerg_6', 'synerg', 6, 1, 'Skill description'),
(31133, 'Skill synerg 7', 'synerg_7', 'synerg', 7, 1, 'Skill description'),
(31134, 'Skill synerg 8', 'synerg_8', 'synerg', 8, 1, 'Skill description'),
(31135, 'Skill synerg 9', 'synerg_9', 'synerg', 9, 1, 'Skill description'),
(31136, 'Skill synerg 10', 'synerg_10', 'synerg', 10, 1, 'Skill description'),
(31137, 'Skill onverz 6', 'onverz_6', 'onverz', 6, 1, 'Skill description'),
(31138, 'Skill onverz 7', 'onverz_7', 'onverz', 7, 1, 'Skill description'),
(31139, 'Skill onverz 8', 'onverz_8', 'onverz', 8, 1, 'Skill description'),
(31140, 'Skill onverz 9', 'onverz_9', 'onverz', 9, 1, 'Skill description'),
(31141, 'Skill onverz 10', 'onverz_10', 'onverz', 10, 1, 'Skill description'),
(31142, 'Skill ijzvreter 6', 'ijzvreter_6', 'ijzvreter', 6, 1, 'Skill description'),
(31143, 'Skill ijzvreter 7', 'ijzvreter_7', 'ijzvreter', 7, 1, 'Skill description'),
(31144, 'Skill ijzvreter 8', 'ijzvreter_8', 'ijzvreter', 8, 1, 'Skill description'),
(31145, 'Skill ijzvreter 9', 'ijzvreter_9', 'ijzvreter', 9, 1, 'Skill description'),
(31146, 'Skill ijzvreter 10', 'ijzvreter_10', 'ijzvreter', 10, 1, 'Skill description'),
(31147, 'Skill cyborg 6', 'cyborg_6', 'cyborg', 6, 1, 'Skill description'),
(31148, 'Skill cyborg 7', 'cyborg_7', 'cyborg', 7, 1, 'Skill description'),
(31149, 'Skill cyborg 8', 'cyborg_8', 'cyborg', 8, 1, 'Skill description'),
(31150, 'Skill cyborg 9', 'cyborg_9', 'cyborg', 9, 1, 'Skill description'),
(31151, 'Skill cyborg 10', 'cyborg_10', 'cyborg', 10, 1, 'Skill description'),
(31152, 'Skill dex 1', 'dex_1', 'dex', 1, 1, 'Skill description'),
(31153, 'Skill dex 2', 'dex_2', 'dex', 2, 1, 'Skill description'),
(31154, 'Skill dex 3', 'dex_3', 'dex', 3, 1, 'Skill description'),
(31155, 'Skill dex 4', 'dex_4', 'dex', 4, 1, 'Skill description'),
(31156, 'Skill dex 5', 'dex_5', 'dex', 5, 1, 'Skill description'),
(31157, 'Skill infiltr 6', 'infiltr_6', 'infiltr', 6, 1, 'Skill description'),
(31158, 'Skill infiltr 7', 'infiltr_7', 'infiltr', 7, 1, 'Skill description'),
(31159, 'Skill infiltr 8', 'infiltr_8', 'infiltr', 8, 1, 'Skill description'),
(31160, 'Skill infiltr 9', 'infiltr_9', 'infiltr', 9, 1, 'Skill description'),
(31161, 'Skill infiltr 10', 'infiltr_10', 'infiltr', 10, 1, 'Skill description'),
(31162, 'Skill pilot 6', 'pilot_6', 'pilot', 6, 1, 'Skill description'),
(31163, 'Skill pilot 7', 'pilot_7', 'pilot', 7, 1, 'Skill description'),
(31164, 'Skill pilot 8', 'pilot_8', 'pilot', 8, 1, 'Skill description'),
(31165, 'Skill pilot 9', 'pilot_9', 'pilot', 9, 1, 'Skill description'),
(31166, 'Skill pilot 10', 'pilot_10', 'pilot', 10, 1, 'Skill description'),
(31167, 'Skill portal 6', 'portal_6', 'portal', 6, 1, 'Skill description'),
(31168, 'Skill portal 7', 'portal_7', 'portal', 7, 1, 'Skill description'),
(31169, 'Skill portal 8', 'portal_8', 'portal', 8, 1, 'Skill description'),
(31170, 'Skill portal 9', 'portal_9', 'portal', 9, 1, 'Skill description'),
(31171, 'Skill portal 10', 'portal_10', 'portal', 10, 1, 'Skill description'),
(31172, 'Skill geotech 6', 'geotech_6', 'geotech', 6, 1, 'Skill description'),
(31173, 'Skill geotech 7', 'geotech_7', 'geotech', 7, 1, 'Skill description'),
(31174, 'Skill geotech 8', 'geotech_8', 'geotech', 8, 1, 'Skill description'),
(31175, 'Skill geotech 9', 'geotech_9', 'geotech', 9, 1, 'Skill description'),
(31176, 'Skill geotech 10', 'geotech_10', 'geotech', 10, 1, 'Skill description'),
(31177, 'Skill stimm 6', 'stimm_6', 'stimm', 6, 1, 'Skill description'),
(31178, 'Skill stimm 7', 'stimm_7', 'stimm', 7, 1, 'Skill description'),
(31179, 'Skill stimm 8', 'stimm_8', 'stimm', 8, 1, 'Skill description'),
(31180, 'Skill stimm 9', 'stimm_9', 'stimm', 9, 1, 'Skill description'),
(31181, 'Skill stimm 10', 'stimm_10', 'stimm', 10, 1, 'Skill description'),
(31182, 'Skill medevac 6', 'medevac_6', 'medevac', 6, 1, 'Skill description'),
(31183, 'Skill medevac 7', 'medevac_7', 'medevac', 7, 1, 'Skill description'),
(31184, 'Skill medevac 8', 'medevac_8', 'medevac', 8, 1, 'Skill description'),
(31185, 'Skill medevac 9', 'medevac_9', 'medevac', 9, 1, 'Skill description'),
(31186, 'Skill medevac 10', 'medevac_10', 'medevac', 10, 1, 'Skill description'),
(31187, 'Skill traumsurg 6', 'traumsurg_6', 'traumsurg', 6, 1, 'Skill description'),
(31188, 'Skill traumsurg 7', 'traumsurg_7', 'traumsurg', 7, 1, 'Skill description'),
(31189, 'Skill traumsurg 8', 'traumsurg_8', 'traumsurg', 8, 1, 'Skill description'),
(31190, 'Skill traumsurg 9', 'traumsurg_9', 'traumsurg', 9, 1, 'Skill description'),
(31191, 'Skill traumsurg 10', 'traumsurg_10', 'traumsurg', 10, 1, 'Skill description'),
(31192, 'Skill forensi 6', 'forensi_6', 'forensi', 6, 1, 'Skill description'),
(31193, 'Skill forensi 7', 'forensi_7', 'forensi', 7, 1, 'Skill description'),
(31194, 'Skill forensi 8', 'forensi_8', 'forensi', 8, 1, 'Skill description'),
(31195, 'Skill forensi 9', 'forensi_9', 'forensi', 9, 1, 'Skill description'),
(31196, 'Skill forensi 10', 'forensi_10', 'forensi', 10, 1, 'Skill description'),
(31197, 'Skill spirit 6', 'spirit_6', 'spirit', 6, 1, 'Skill description'),
(31198, 'Skill spirit 7', 'spirit_7', 'spirit', 7, 1, 'Skill description'),
(31199, 'Skill spirit 8', 'spirit_8', 'spirit', 8, 1, 'Skill description'),
(31200, 'Skill spirit 9', 'spirit_9', 'spirit', 9, 1, 'Skill description'),
(31201, 'Skill spirit 10', 'spirit_10', 'spirit', 10, 1, 'Skill description'),
(31202, 'Skill waker 6', 'waker_6', 'waker', 6, 1, 'Skill description'),
(31203, 'Skill waker 7', 'waker_7', 'waker', 7, 1, 'Skill description'),
(31204, 'Skill waker 8', 'waker_8', 'waker', 8, 1, 'Skill description'),
(31205, 'Skill waker 9', 'waker_9', 'waker', 9, 1, 'Skill description'),
(31206, 'Skill waker 10', 'waker_10', 'waker', 10, 1, 'Skill description'),
(31207, 'Skill evangel 6', 'evangel_6', 'evangel', 6, 1, 'Skill description'),
(31208, 'Skill evangel 7', 'evangel_7', 'evangel', 7, 1, 'Skill description'),
(31209, 'Skill evangel 8', 'evangel_8', 'evangel', 8, 1, 'Skill description'),
(31210, 'Skill evangel 9', 'evangel_9', 'evangel', 9, 1, 'Skill description'),
(31211, 'Skill evangel 10', 'evangel_10', 'evangel', 10, 1, 'Skill description'),
(31212, 'Skill strijd 6', 'strijd_6', 'strijd', 6, 1, 'Skill description'),
(31213, 'Skill strijd 7', 'strijd_7', 'strijd', 7, 1, 'Skill description'),
(31214, 'Skill strijd 8', 'strijd_8', 'strijd', 8, 1, 'Skill description'),
(31215, 'Skill strijd 9', 'strijd_9', 'strijd', 9, 1, 'Skill description'),
(31216, 'Skill strijd 10', 'strijd_10', 'strijd', 10, 1, 'Skill description'),
(31217, 'Skill newage 6', 'newage_6', 'newage', 6, 1, 'Skill description'),
(31218, 'Skill newage 7', 'newage_7', 'newage', 7, 1, 'Skill description'),
(31219, 'Skill newage 8', 'newage_8', 'newage', 8, 1, 'Skill description'),
(31220, 'Skill newage 9', 'newage_9', 'newage', 9, 1, 'Skill description'),
(31221, 'Skill newage 10', 'newage_10', 'newage', 10, 1, 'Skill description'),
(31222, 'Skill doaune 6', 'doaune_6', 'doaune', 6, 1, 'Skill description'),
(31223, 'Skill doaune 7', 'doaune_7', 'doaune', 7, 1, 'Skill description'),
(31224, 'Skill doaune 8', 'doaune_8', 'doaune', 8, 1, 'Skill description'),
(31225, 'Skill doaune 9', 'doaune_9', 'doaune', 9, 1, 'Skill description'),
(31226, 'Skill doaune 10', 'doaune_10', 'doaune', 10, 1, 'Skill description'),
(31227, 'Skill operative 6', 'operative_6', 'operative', 6, 1, 'Skill description'),
(31228, 'Skill operative 7', 'operative_7', 'operative', 7, 1, 'Skill description'),
(31229, 'Skill operative 8', 'operative_8', 'operative', 8, 1, 'Skill description'),
(31230, 'Skill operative 9', 'operative_9', 'operative', 9, 1, 'Skill description'),
(31231, 'Skill operative 10', 'operative_10', 'operative', 10, 1, 'Skill description'),
(31232, 'Skill journal 6', 'journal_6', 'journal', 6, 1, 'Skill description'),
(31233, 'Skill journal 7', 'journal_7', 'journal', 7, 1, 'Skill description'),
(31234, 'Skill journal 8', 'journal_8', 'journal', 8, 1, 'Skill description'),
(31235, 'Skill journal 9', 'journal_9', 'journal', 9, 1, 'Skill description'),
(31236, 'Skill journal 10', 'journal_10', 'journal', 10, 1, 'Skill description'),
(31237, 'Skill oudgeld 6', 'oudgeld_6', 'oudgeld', 6, 1, 'Skill description'),
(31238, 'Skill oudgeld 7', 'oudgeld_7', 'oudgeld', 7, 1, 'Skill description'),
(31239, 'Skill oudgeld 8', 'oudgeld_8', 'oudgeld', 8, 1, 'Skill description'),
(31240, 'Skill oudgeld 9', 'oudgeld_9', 'oudgeld', 9, 1, 'Skill description'),
(31241, 'Skill oudgeld 10', 'oudgeld_10', 'oudgeld', 10, 1, 'Skill description'),
(31242, 'Skill sjach 6', 'sjach_6', 'sjach', 6, 1, 'Skill description'),
(31243, 'Skill sjach 7', 'sjach_7', 'sjach', 7, 1, 'Skill description'),
(31244, 'Skill sjach 8', 'sjach_8', 'sjach', 8, 1, 'Skill description'),
(31245, 'Skill sjach 9', 'sjach_9', 'sjach', 9, 1, 'Skill description'),
(31246, 'Skill sjach 10', 'sjach_10', 'sjach', 10, 1, 'Skill description'),
(31247, 'Skill dealmk 6', 'dealmk_6', 'dealmk', 6, 1, 'Skill description'),
(31248, 'Skill dealmk 7', 'dealmk_7', 'dealmk', 7, 1, 'Skill description'),
(31249, 'Skill dealmk 8', 'dealmk_8', 'dealmk', 8, 1, 'Skill description'),
(31250, 'Skill dealmk 9', 'dealmk_9', 'dealmk', 9, 1, 'Skill description'),
(31251, 'Skill dealmk 10', 'dealmk_10', 'dealmk', 10, 1, 'Skill description'),
(31252, 'Skill xeno 6', 'xeno_6', 'xeno', 6, 1, 'Skill description'),
(31253, 'Skill xeno 7', 'xeno_7', 'xeno', 7, 1, 'Skill description'),
(31254, 'Skill xeno 8', 'xeno_8', 'xeno', 8, 1, 'Skill description'),
(31255, 'Skill xeno 9', 'xeno_9', 'xeno', 9, 1, 'Skill description'),
(31256, 'Skill xeno 10', 'xeno_10', 'xeno', 10, 1, 'Skill description'),
(31257, 'Skill superextr 6', 'superextr_6', 'superextr', 6, 1, 'Skill description'),
(31258, 'Skill superextr 7', 'superextr_7', 'superextr', 7, 1, 'Skill description'),
(31259, 'Skill superextr 8', 'superextr_8', 'superextr', 8, 1, 'Skill description'),
(31260, 'Skill superextr 9', 'superextr_9', 'superextr', 9, 1, 'Skill description'),
(31261, 'Skill superextr 10', 'superextr_10', 'superextr', 10, 1, 'Skill description'),
(31262, 'Skill mtexpl 6', 'mtexpl_6', 'mtexpl', 6, 1, 'Skill description'),
(31263, 'Skill mtexpl 7', 'mtexpl_7', 'mtexpl', 7, 1, 'Skill description'),
(31264, 'Skill mtexpl 8', 'mtexpl_8', 'mtexpl', 8, 1, 'Skill description'),
(31265, 'Skill mtexpl 9', 'mtexpl_9', 'mtexpl', 9, 1, 'Skill description'),
(31266, 'Skill mtexpl 10', 'mtexpl_10', 'mtexpl', 10, 1, 'Skill description'),
(31267, 'Skill botjock 6', 'botjock_6', 'botjock', 6, 1, 'Skill description'),
(31268, 'Skill botjock 7', 'botjock_7', 'botjock', 7, 1, 'Skill description'),
(31269, 'Skill botjock 8', 'botjock_8', 'botjock', 8, 1, 'Skill description'),
(31270, 'Skill botjock 9', 'botjock_9', 'botjock', 9, 1, 'Skill description'),
(31271, 'Skill botjock 10', 'botjock_10', 'botjock', 10, 1, 'Skill description'),
(31272, 'Skill spacemine 6', 'spacemine_6', 'spacemine', 6, 1, 'Skill description'),
(31273, 'Skill spacemine 7', 'spacemine_7', 'spacemine', 7, 1, 'Skill description'),
(31274, 'Skill spacemine 8', 'spacemine_8', 'spacemine', 8, 1, 'Skill description'),
(31275, 'Skill spacemine 9', 'spacemine_9', 'spacemine', 9, 1, 'Skill description'),
(31276, 'Skill spacemine 10', 'spacemine_10', 'spacemine', 10, 1, 'Skill description'),
(31277, 'Skill factiepoli 6', 'factiepoli_6', 'factiepoli', 6, 1, 'Skill description'),
(31278, 'Skill factiepoli 7', 'factiepoli_7', 'factiepoli', 7, 1, 'Skill description'),
(31279, 'Skill factiepoli 8', 'factiepoli_8', 'factiepoli', 8, 1, 'Skill description'),
(31280, 'Skill factiepoli 9', 'factiepoli_9', 'factiepoli', 9, 1, 'Skill description'),
(31281, 'Skill factiepoli 10', 'factiepoli_10', 'factiepoli', 10, 1, 'Skill description'),
(31282, 'Skill icclobby 6', 'icclobby_6', 'icclobby', 6, 1, 'Skill description'),
(31283, 'Skill icclobby 7', 'icclobby_7', 'icclobby', 7, 1, 'Skill description'),
(31284, 'Skill icclobby 8', 'icclobby_8', 'icclobby', 8, 1, 'Skill description'),
(31285, 'Skill icclobby 9', 'icclobby_9', 'icclobby', 9, 1, 'Skill description'),
(31286, 'Skill icclobby 10', 'icclobby_10', 'icclobby', 10, 1, 'Skill description'),
(31287, 'Skill polgener 6', 'polgener_6', 'polgener', 6, 1, 'Skill description'),
(31288, 'Skill polgener 7', 'polgener_7', 'polgener', 7, 1, 'Skill description'),
(31289, 'Skill polgener 8', 'polgener_8', 'polgener', 8, 1, 'Skill description'),
(31290, 'Skill polgener 9', 'polgener_9', 'polgener', 9, 1, 'Skill description'),
(31291, 'Skill polgener 10', 'polgener_10', 'polgener', 10, 1, 'Skill description'),
(31292, 'Skill itelite 6', 'itelite_6', 'itelite', 6, 1, 'Skill description'),
(31293, 'Skill itelite 7', 'itelite_7', 'itelite', 7, 1, 'Skill description'),
(31294, 'Skill itelite 8', 'itelite_8', 'itelite', 8, 1, 'Skill description'),
(31295, 'Skill itelite 9', 'itelite_9', 'itelite', 9, 1, 'Skill description'),
(31296, 'Skill itelite 10', 'itelite_10', 'itelite', 10, 1, 'Skill description'),
(31297, 'Skill itarchi 6', 'itarchi_6', 'itarchi', 6, 1, 'Skill description'),
(31298, 'Skill itarchi 7', 'itarchi_7', 'itarchi', 7, 1, 'Skill description'),
(31299, 'Skill itarchi 8', 'itarchi_8', 'itarchi', 8, 1, 'Skill description'),
(31300, 'Skill itarchi 9', 'itarchi_9', 'itarchi', 9, 1, 'Skill description'),
(31301, 'Skill itarchi 10', 'itarchi_10', 'itarchi', 10, 1, 'Skill description'),
(31302, 'Skill savant 6', 'savant_6', 'savant', 6, 1, 'Skill description'),
(31303, 'Skill savant 7', 'savant_7', 'savant', 7, 1, 'Skill description'),
(31304, 'Skill savant 8', 'savant_8', 'savant', 8, 1, 'Skill description'),
(31305, 'Skill savant 9', 'savant_9', 'savant', 9, 1, 'Skill description'),
(31306, 'Skill savant 10', 'savant_10', 'savant', 10, 1, 'Skill description'),
(31307, 'Skill academy 6', 'academy_6', 'academy', 6, 1, 'Skill description'),
(31308, 'Skill academy 7', 'academy_7', 'academy', 7, 1, 'Skill description'),
(31309, 'Skill academy 8', 'academy_8', 'academy', 8, 1, 'Skill description'),
(31310, 'Skill academy 9', 'academy_9', 'academy', 9, 1, 'Skill description'),
(31311, 'Skill academy 10', 'academy_10', 'academy', 10, 1, 'Skill description'),
(31312, 'Skill stratcom 6', 'stratcom_6', 'stratcom', 6, 1, 'Skill description'),
(31313, 'Skill stratcom 7', 'stratcom_7', 'stratcom', 7, 1, 'Skill description'),
(31314, 'Skill stratcom 8', 'stratcom_8', 'stratcom', 8, 1, 'Skill description'),
(31315, 'Skill stratcom 9', 'stratcom_9', 'stratcom', 9, 1, 'Skill description'),
(31316, 'Skill stratcom 10', 'stratcom_10', 'stratcom', 10, 1, 'Skill description'),
(31317, 'Skill account 6', 'account_6', 'account', 6, 1, 'Skill description'),
(31318, 'Skill account 7', 'account_7', 'account', 7, 1, 'Skill description'),
(31319, 'Skill account 8', 'account_8', 'account', 8, 1, 'Skill description'),
(31320, 'Skill account 9', 'account_9', 'account', 9, 1, 'Skill description'),
(31321, 'Skill account 10', 'account_10', 'account', 10, 1, 'Skill description'),
(31322, 'Skill interro 6', 'interro_6', 'interro', 6, 1, 'Skill description'),
(31323, 'Skill interro 7', 'interro_7', 'interro', 7, 1, 'Skill description'),
(31324, 'Skill interro 8', 'interro_8', 'interro', 8, 1, 'Skill description'),
(31325, 'Skill interro 9', 'interro_9', 'interro', 9, 1, 'Skill description'),
(31326, 'Skill interro 10', 'interro_10', 'interro', 10, 1, 'Skill description'),
(31327, 'Skill bodyguard 6', 'bodyguard_6', 'bodyguard', 6, 1, 'Skill description'),
(31328, 'Skill bodyguard 7', 'bodyguard_7', 'bodyguard', 7, 1, 'Skill description'),
(31329, 'Skill bodyguard 8', 'bodyguard_8', 'bodyguard', 8, 1, 'Skill description'),
(31330, 'Skill bodyguard 9', 'bodyguard_9', 'bodyguard', 9, 1, 'Skill description'),
(31331, 'Skill bodyguard 10', 'bodyguard_10', 'bodyguard', 10, 1, 'Skill description'),
(31332, 'Skill flash 6', 'flash_6', 'flash', 6, 1, 'Skill description'),
(31333, 'Skill flash 7', 'flash_7', 'flash', 7, 1, 'Skill description'),
(31334, 'Skill flash 8', 'flash_8', 'flash', 8, 1, 'Skill description'),
(31335, 'Skill flash 9', 'flash_9', 'flash', 9, 1, 'Skill description'),
(31336, 'Skill flash 10', 'flash_10', 'flash', 10, 1, 'Skill description'),
(31337, 'Skill shishaper 6', 'shishaper_6', 'shishaper', 6, 1, 'Skill description'),
(31338, 'Skill shishaper 7', 'shishaper_7', 'shishaper', 7, 1, 'Skill description'),
(31339, 'Skill shishaper 8', 'shishaper_8', 'shishaper', 8, 1, 'Skill description'),
(31340, 'Skill shishaper 9', 'shishaper_9', 'shishaper', 9, 1, 'Skill description'),
(31341, 'Skill shishaper 10', 'shishaper_10', 'shishaper', 10, 1, 'Skill description');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_skills_groups`
--

DROP TABLE IF EXISTS `ecc_skills_groups`;
CREATE TABLE `ecc_skills_groups` (
  `primaryskill_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `siteindex` varchar(15) NOT NULL,
  `psychic` varchar(6) NOT NULL DEFAULT 'false',
  `parents` varchar(100) DEFAULT 'none',
  `status` varchar(15) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_skills_groups`
--

INSERT INTO `ecc_skills_groups` (`primaryskill_id`, `name`, `siteindex`, `psychic`, `parents`, `status`) VALUES
(12000, 'Ballistiek', 'guns', 'false', 'none', 'active'),
(12001, 'Melee', 'melee', 'false', 'none', 'active'),
(12002, 'Bescherming', 'besch', 'false', 'none', 'active'),
(12003, 'Wilskracht', 'will', 'false', 'none', 'active'),
(12004, 'Conditie', 'cond', 'false', 'none', 'active'),
(12005, 'Ingenieur', 'engi', 'false', 'none', 'active'),
(12006, 'Informatica', 'it', 'false', 'none', 'active'),
(12007, 'Gewondenhulp', 'firstaid', 'false', 'none', 'active'),
(12008, 'Geneeskunde', 'surgery', 'false', 'none', 'active'),
(12009, 'Telepsychica', 'tele', 'true', 'none', 'active'),
(12010, 'Informatie-analyse', 'intel', 'false', 'none', 'active'),
(12011, 'Politicologie', 'politic', 'false', 'none', 'active'),
(12012, 'Economie', 'eco', 'false', 'none', 'active'),
(12013, 'Geologie', 'geo', 'false', 'none', 'active'),
(12014, 'Chemie', 'chem', 'false', 'none', 'active'),
(12015, 'Genie', 'genie', 'false', 'guns', 'active'),
(12016, 'Tacticus', 'tacticus', 'false', 'guns', 'active'),
(12017, 'Sluipschutter', 'sniper', 'false', 'guns', 'active'),
(12018, 'CQB', 'cqb', 'false', 'melee', 'active'),
(12019, 'eskrima', 'eskrima', 'false', 'melee', 'active'),
(12020, 'Aegis', 'aegis', 'false', 'besch', 'active'),
(12021, 'Powerarmour', 'powarm', 'false', 'besch', 'active'),
(12022, 'CBRN', 'cbrn', 'false', 'besch', 'active'),
(12023, 'Psy-Ops', 'will', 'false', 'none', 'active'),
(12024, 'Synergist', 'synerg', 'false', 'will', 'active'),
(12025, 'Onverzettelijk', 'onverz', 'false', 'will', 'active'),
(12026, 'Ijzervreter', 'ijzvreter', 'false', 'cond', 'active'),
(12027, 'Cyborg', 'cyborg', 'false', 'cond', 'active'),
(12028, 'Behendigheid', 'dex', 'false', 'none', 'active'),
(12029, 'Infiltratie-specialist', 'infiltr', 'false', 'behendi', 'active'),
(12030, 'Gevechtspiloot', 'pilot', 'false', 'behendi', 'active'),
(12031, 'Portaal-Technicus', 'portal', 'false', 'engi', 'active'),
(12032, 'Geo-Tech', 'geotech', 'false', 'engi', 'active'),
(12033, 'Stimm-Specialist', 'stimm', 'false', 'firstaid', 'active'),
(12034, 'Med-Evac specialist', 'medevac', 'false', 'firstaid', 'active'),
(12035, 'Trauma-chirgurgie', 'traumsurg', 'false', 'surgeon', 'active'),
(12036, 'Forensisch expert', 'forensi', 'false', 'surgeon', 'active'),
(12037, 'Spiritualist', 'spirit', 'true', 'tele', 'active'),
(12038, 'Waker', 'waker', 'true', 'tele', 'active'),
(12039, 'Evangelist', 'evangel', 'true', 'tele', 'active'),
(12040, 'Strijder', 'strijd', 'true', 'tele', 'active'),
(12041, 'New Age', 'newage', 'true', 'tele', 'active'),
(12042, 'Douane beampte', 'doaune', 'false', 'intel', 'active'),
(12043, 'The Operative', 'operative', 'false', 'intel', 'active'),
(12044, 'Journalist', 'journal', 'false', 'intel', 'active'),
(12045, 'Oud geld', 'oudgeld', 'false', 'eco', 'active'),
(12046, 'Sjacheraar', 'sjach', 'false', 'eco', 'active'),
(12047, 'Dealmaker', 'dealmk', 'false', 'eco', 'active'),
(12048, 'Xeno-Botanist', 'xeno', 'false', 'chem', 'active'),
(12049, 'Superkritische extractie', 'superextr', 'false', 'chem', 'active'),
(12050, 'Magneto-Tellurische exploitatie', 'mtexpl', 'false', 'geo', 'active'),
(12051, 'Bot-jockey', 'botjock', 'false', 'geo', 'active'),
(12052, 'Deep space mining', 'spacemine', 'false', 'geo', 'active'),
(12053, 'Factiepoliticus', 'factiepoli', 'false', 'politic', 'active'),
(12054, 'ICC lobbyist', 'icclobby', 'false', 'politic', 'active'),
(12055, 'Generalist', 'polgener', 'false', 'politic', 'active'),
(12056, 'Elite', 'itelite', 'false', 'it', 'active'),
(12057, 'Architect', 'itarchi', 'false', 'it', 'active'),
(12058, 'Savant', 'savant', 'false', 'chem,it,geo,engi,eco,surgery,intel,politic', 'beta'),
(12059, 'Academicus', 'academy', 'false', 'chem,it,geo,engi,eco,surgery,intel,politic', 'beta'),
(12060, 'Strateeg', 'stratcom', 'false', 'intel', 'alpha'),
(12061, 'Accountant', 'account', 'false', 'eco', 'beta'),
(12062, 'Interrogator', 'interro', 'false', 'intel', 'beta'),
(12063, 'Bodyguard', 'bodyguard', 'false', 'dex', 'beta'),
(12064, 'Flash Fighter', 'flash', 'false', 'melee', 'beta'),
(12065, 'Shield shaper', 'shishaper', 'false', 'besch', 'beta');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `ecc_characters`
--
ALTER TABLE `ecc_characters`
  ADD PRIMARY KEY (`characterID`);

--
-- Indexen voor tabel `ecc_char_implants`
--
ALTER TABLE `ecc_char_implants`
  ADD PRIMARY KEY (`modifierID`),
  ADD KEY `characterID` (`characterID`);

--
-- Indexen voor tabel `ecc_char_sheet`
--
ALTER TABLE `ecc_char_sheet`
  ADD PRIMARY KEY (`charSheetID`),
  ADD KEY `characterID` (`characterID`);

--
-- Indexen voor tabel `ecc_char_skills`
--
ALTER TABLE `ecc_char_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `ecc_factionmodifiers`
--
ALTER TABLE `ecc_factionmodifiers`
  ADD PRIMARY KEY (`factionID`);

--
-- Indexen voor tabel `ecc_skills_allskills`
--
ALTER TABLE `ecc_skills_allskills`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexen voor tabel `ecc_skills_groups`
--
ALTER TABLE `ecc_skills_groups`
  ADD PRIMARY KEY (`primaryskill_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `ecc_characters`
--
ALTER TABLE `ecc_characters`
  MODIFY `characterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT voor een tabel `ecc_char_implants`
--
ALTER TABLE `ecc_char_implants`
  MODIFY `modifierID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `ecc_char_sheet`
--
ALTER TABLE `ecc_char_sheet`
  MODIFY `charSheetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT voor een tabel `ecc_char_skills`
--
ALTER TABLE `ecc_char_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT voor een tabel `ecc_factionmodifiers`
--
ALTER TABLE `ecc_factionmodifiers`
  MODIFY `factionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT voor een tabel `ecc_skills_allskills`
--
ALTER TABLE `ecc_skills_allskills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;
--
-- AUTO_INCREMENT voor een tabel `ecc_skills_groups`
--
ALTER TABLE `ecc_skills_groups`
  MODIFY `primaryskill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12066;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
