-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 feb 2018 om 00:58
-- Serverversie: 10.1.26-MariaDB
-- PHP-versie: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



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
(21, 451, 'Maati Priscus Testus', 0, NULL, 'ekanesh', 1, 'in design', '12-12-240NT', 'Test2', 'Test12');

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
  `aantal_events` int(11) NOT NULL DEFAULT '0',
  `versionNumber` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_char_sheet`
--

INSERT INTO `ecc_char_sheet` (`charSheetID`, `characterID`, `accountID`, `status`, `aantal_events`, `versionNumber`) VALUES
(1, 1, 451, 'ontwerp', 5, 2),
(4, 2, 451, 'ontwerp', 0, 0),
(5, 23, 808, 'ontwerp', 0, 0);

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
(7, 'ekanesh', 'enable', 12009, 0),
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
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_skills_allskills`
--

INSERT INTO `ecc_skills_allskills` (`skill_id`, `label`, `skill_index`, `parent`, `level`, `version`, `description`) VALUES
(31012, 'Skill guns 1', 'guns_1', 12000, 1, 1, 'Skill description'),
(31013, 'Skill guns 2', 'guns_2', 12000, 2, 1, 'Skill description'),
(31014, 'Skill guns 3', 'guns_3', 12000, 3, 1, 'Skill description'),
(31015, 'Skill guns 4', 'guns_4', 12000, 4, 1, 'Skill description'),
(31016, 'Skill guns 5', 'guns_5', 12000, 5, 1, 'Skill description'),
(31017, 'Skill melee 1', 'melee_1', 12001, 1, 1, 'Skill description'),
(31018, 'Skill melee 2', 'melee_2', 12001, 2, 1, 'Skill description'),
(31019, 'Skill melee 3', 'melee_3', 12001, 3, 1, 'Skill description'),
(31020, 'Skill melee 4', 'melee_4', 12001, 4, 1, 'Skill description'),
(31021, 'Skill melee 5', 'melee_5', 12001, 5, 1, 'Skill description'),
(31022, 'Skill besch 1', 'besch_1', 12002, 1, 1, 'Skill description'),
(31023, 'Skill besch 2', 'besch_2', 12002, 2, 1, 'Skill description'),
(31024, 'Skill besch 3', 'besch_3', 12002, 3, 1, 'Skill description'),
(31025, 'Skill besch 4', 'besch_4', 12002, 4, 1, 'Skill description'),
(31026, 'Skill besch 5', 'besch_5', 12002, 5, 1, 'Skill description'),
(31027, 'Skill will 1', 'will_1', 12003, 1, 1, 'Skill description'),
(31028, 'Skill will 2', 'will_2', 12003, 2, 1, 'Skill description'),
(31029, 'Skill will 3', 'will_3', 12003, 3, 1, 'Skill description'),
(31030, 'Skill will 4', 'will_4', 12003, 4, 1, 'Skill description'),
(31031, 'Skill will 5', 'will_5', 12003, 5, 1, 'Skill description'),
(31032, 'Skill cond 1', 'cond_1', 12004, 1, 1, 'Skill description'),
(31033, 'Skill cond 2', 'cond_2', 12004, 2, 1, 'Skill description'),
(31034, 'Skill cond 3', 'cond_3', 12004, 3, 1, 'Skill description'),
(31035, 'Skill cond 4', 'cond_4', 12004, 4, 1, 'Skill description'),
(31036, 'Skill cond 5', 'cond_5', 12004, 5, 1, 'Skill description'),
(31037, 'Skill engi 1', 'engi_1', 12005, 1, 1, 'Skill description'),
(31038, 'Skill engi 2', 'engi_2', 12005, 2, 1, 'Skill description'),
(31039, 'Skill engi 3', 'engi_3', 12005, 3, 1, 'Skill description'),
(31040, 'Skill engi 4', 'engi_4', 12005, 4, 1, 'Skill description'),
(31041, 'Skill engi 5', 'engi_5', 12005, 5, 1, 'Skill description'),
(31042, 'Skill it 1', 'it_1', 12006, 1, 1, 'Skill description'),
(31043, 'Skill it 2', 'it_2', 12006, 2, 1, 'Skill description'),
(31044, 'Skill it 3', 'it_3', 12006, 3, 1, 'Skill description'),
(31045, 'Skill it 4', 'it_4', 12006, 4, 1, 'Skill description'),
(31046, 'Skill it 5', 'it_5', 12006, 5, 1, 'Skill description'),
(31047, 'Skill firstaid 1', 'firstaid_1', 12007, 1, 1, 'Skill description'),
(31048, 'Skill firstaid 2', 'firstaid_2', 12007, 2, 1, 'Skill description'),
(31049, 'Skill firstaid 3', 'firstaid_3', 12007, 3, 1, 'Skill description'),
(31050, 'Skill firstaid 4', 'firstaid_4', 12007, 4, 1, 'Skill description'),
(31051, 'Skill firstaid 5', 'firstaid_5', 12007, 5, 1, 'Skill description'),
(31052, 'Skill surgery 1', 'surgery_1', 12008, 1, 1, 'Skill description'),
(31053, 'Skill surgery 2', 'surgery_2', 12008, 2, 1, 'Skill description'),
(31054, 'Skill surgery 3', 'surgery_3', 12008, 3, 1, 'Skill description'),
(31055, 'Skill surgery 4', 'surgery_4', 12008, 4, 1, 'Skill description'),
(31056, 'Skill surgery 5', 'surgery_5', 12008, 5, 1, 'Skill description'),
(31057, 'Skill tele 1', 'tele_1', 12009, 1, 1, 'Skill description'),
(31058, 'Skill tele 2', 'tele_2', 12009, 2, 1, 'Skill description'),
(31059, 'Skill tele 3', 'tele_3', 12009, 3, 1, 'Skill description'),
(31060, 'Skill tele 4', 'tele_4', 12009, 4, 1, 'Skill description'),
(31061, 'Skill tele 5', 'tele_5', 12009, 5, 1, 'Skill description'),
(31062, 'Skill intel 1', 'intel_1', 12010, 1, 1, 'Skill description'),
(31063, 'Skill intel 2', 'intel_2', 12010, 2, 1, 'Skill description'),
(31064, 'Skill intel 3', 'intel_3', 12010, 3, 1, 'Skill description'),
(31065, 'Skill intel 4', 'intel_4', 12010, 4, 1, 'Skill description'),
(31066, 'Skill intel 5', 'intel_5', 12010, 5, 1, 'Skill description'),
(31067, 'Skill politic 1', 'politic_1', 12011, 1, 1, 'Skill description'),
(31068, 'Skill politic 2', 'politic_2', 12011, 2, 1, 'Skill description'),
(31069, 'Skill politic 3', 'politic_3', 12011, 3, 1, 'Skill description'),
(31070, 'Skill politic 4', 'politic_4', 12011, 4, 1, 'Skill description'),
(31071, 'Skill politic 5', 'politic_5', 12011, 5, 1, 'Skill description'),
(31072, 'Skill eco 1', 'eco_1', 12012, 1, 1, 'Skill description'),
(31073, 'Skill eco 2', 'eco_2', 12012, 2, 1, 'Skill description'),
(31074, 'Skill eco 3', 'eco_3', 12012, 3, 1, 'Skill description'),
(31075, 'Skill eco 4', 'eco_4', 12012, 4, 1, 'Skill description'),
(31076, 'Skill eco 5', 'eco_5', 12012, 5, 1, 'Skill description'),
(31077, 'Skill geo 1', 'geo_1', 12013, 1, 1, 'Skill description'),
(31078, 'Skill geo 2', 'geo_2', 12013, 2, 1, 'Skill description'),
(31079, 'Skill geo 3', 'geo_3', 12013, 3, 1, 'Skill description'),
(31080, 'Skill geo 4', 'geo_4', 12013, 4, 1, 'Skill description'),
(31081, 'Skill geo 5', 'geo_5', 12013, 5, 1, 'Skill description'),
(31082, 'Skill chem 1', 'chem_1', 12014, 1, 1, 'Skill description'),
(31083, 'Skill chem 2', 'chem_2', 12014, 2, 1, 'Skill description'),
(31084, 'Skill chem 3', 'chem_3', 12014, 3, 1, 'Skill description'),
(31085, 'Skill chem 4', 'chem_4', 12014, 4, 1, 'Skill description'),
(31086, 'Skill chem 5', 'chem_5', 12014, 5, 1, 'Skill description'),
(31087, 'Skill genie 6', 'genie_6', 12015, 6, 1, 'Skill description'),
(31088, 'Skill genie 7', 'genie_7', 12015, 7, 1, 'Skill description'),
(31089, 'Skill genie 8', 'genie_8', 12015, 8, 1, 'Skill description'),
(31090, 'Skill genie 9', 'genie_9', 12015, 9, 1, 'Skill description'),
(31091, 'Skill genie 10', 'genie_10', 12015, 10, 1, 'Skill description'),
(31092, 'Skill tacticus 6', 'tacticus_6', 12016, 6, 1, 'Skill description'),
(31093, 'Skill tacticus 7', 'tacticus_7', 12016, 7, 1, 'Skill description'),
(31094, 'Skill tacticus 8', 'tacticus_8', 12016, 8, 1, 'Skill description'),
(31095, 'Skill tacticus 9', 'tacticus_9', 12016, 9, 1, 'Skill description'),
(31096, 'Skill tacticus 10', 'tacticus_10', 12016, 10, 1, 'Skill description'),
(31097, 'Skill sniper 6', 'sniper_6', 12017, 6, 1, 'Skill description'),
(31098, 'Skill sniper 7', 'sniper_7', 12017, 7, 1, 'Skill description'),
(31099, 'Skill sniper 8', 'sniper_8', 12017, 8, 1, 'Skill description'),
(31100, 'Skill sniper 9', 'sniper_9', 12017, 9, 1, 'Skill description'),
(31101, 'Skill sniper 10', 'sniper_10', 12017, 10, 1, 'Skill description'),
(31102, 'Skill cqb 6', 'cqb_6', 12018, 6, 1, 'Skill description'),
(31103, 'Skill cqb 7', 'cqb_7', 12018, 7, 1, 'Skill description'),
(31104, 'Skill cqb 8', 'cqb_8', 12018, 8, 1, 'Skill description'),
(31105, 'Skill cqb 9', 'cqb_9', 12018, 9, 1, 'Skill description'),
(31106, 'Skill cqb 10', 'cqb_10', 12018, 10, 1, 'Skill description'),
(31107, 'Skill eskrima 6', 'eskrima_6', 12019, 6, 1, 'Skill description'),
(31108, 'Skill eskrima 7', 'eskrima_7', 12019, 7, 1, 'Skill description'),
(31109, 'Skill eskrima 8', 'eskrima_8', 12019, 8, 1, 'Skill description'),
(31110, 'Skill eskrima 9', 'eskrima_9', 12019, 9, 1, 'Skill description'),
(31111, 'Skill eskrima 10', 'eskrima_10', 12019, 10, 1, 'Skill description'),
(31112, 'Skill aegis 6', 'aegis_6', 12020, 6, 1, 'Skill description'),
(31113, 'Skill aegis 7', 'aegis_7', 12020, 7, 1, 'Skill description'),
(31114, 'Skill aegis 8', 'aegis_8', 12020, 8, 1, 'Skill description'),
(31115, 'Skill aegis 9', 'aegis_9', 12020, 9, 1, 'Skill description'),
(31116, 'Skill aegis 10', 'aegis_10', 12020, 10, 1, 'Skill description'),
(31117, 'Skill powarm 6', 'powarm_6', 12021, 6, 1, 'Skill description'),
(31118, 'Skill powarm 7', 'powarm_7', 12021, 7, 1, 'Skill description'),
(31119, 'Skill powarm 8', 'powarm_8', 12021, 8, 1, 'Skill description'),
(31120, 'Skill powarm 9', 'powarm_9', 12021, 9, 1, 'Skill description'),
(31121, 'Skill powarm 10', 'powarm_10', 12021, 10, 1, 'Skill description'),
(31122, 'Skill cbrn 6', 'cbrn_6', 12022, 6, 1, 'Skill description'),
(31123, 'Skill cbrn 7', 'cbrn_7', 12022, 7, 1, 'Skill description'),
(31124, 'Skill cbrn 8', 'cbrn_8', 12022, 8, 1, 'Skill description'),
(31125, 'Skill cbrn 9', 'cbrn_9', 12022, 9, 1, 'Skill description'),
(31126, 'Skill cbrn 10', 'cbrn_10', 12022, 10, 1, 'Skill description'),
(31127, 'Skill will 1', 'will_1', 12003, 1, 1, 'Skill description'),
(31128, 'Skill will 2', 'will_2', 12003, 2, 1, 'Skill description'),
(31129, 'Skill will 3', 'will_3', 12003, 3, 1, 'Skill description'),
(31130, 'Skill will 4', 'will_4', 12003, 4, 1, 'Skill description'),
(31131, 'Skill will 5', 'will_5', 12003, 5, 1, 'Skill description'),
(31132, 'Skill synerg 6', 'synerg_6', 12024, 6, 1, 'Skill description'),
(31133, 'Skill synerg 7', 'synerg_7', 12024, 7, 1, 'Skill description'),
(31134, 'Skill synerg 8', 'synerg_8', 12024, 8, 1, 'Skill description'),
(31135, 'Skill synerg 9', 'synerg_9', 12024, 9, 1, 'Skill description'),
(31136, 'Skill synerg 10', 'synerg_10', 12024, 10, 1, 'Skill description'),
(31137, 'Skill onverz 6', 'onverz_6', 12025, 6, 1, 'Skill description'),
(31138, 'Skill onverz 7', 'onverz_7', 12025, 7, 1, 'Skill description'),
(31139, 'Skill onverz 8', 'onverz_8', 12025, 8, 1, 'Skill description'),
(31140, 'Skill onverz 9', 'onverz_9', 12025, 9, 1, 'Skill description'),
(31141, 'Skill onverz 10', 'onverz_10', 12025, 10, 1, 'Skill description'),
(31142, 'Skill ijzvreter 6', 'ijzvreter_6', 12026, 6, 1, 'Skill description'),
(31143, 'Skill ijzvreter 7', 'ijzvreter_7', 12026, 7, 1, 'Skill description'),
(31144, 'Skill ijzvreter 8', 'ijzvreter_8', 12026, 8, 1, 'Skill description'),
(31145, 'Skill ijzvreter 9', 'ijzvreter_9', 12026, 9, 1, 'Skill description'),
(31146, 'Skill ijzvreter 10', 'ijzvreter_10', 12026, 10, 1, 'Skill description'),
(31147, 'Skill cyborg 6', 'cyborg_6', 12027, 6, 1, 'Skill description'),
(31148, 'Skill cyborg 7', 'cyborg_7', 12027, 7, 1, 'Skill description'),
(31149, 'Skill cyborg 8', 'cyborg_8', 12027, 8, 1, 'Skill description'),
(31150, 'Skill cyborg 9', 'cyborg_9', 12027, 9, 1, 'Skill description'),
(31151, 'Skill cyborg 10', 'cyborg_10', 12027, 10, 1, 'Skill description'),
(31152, 'Skill dex 1', 'dex_1', 12028, 1, 1, 'Skill description'),
(31153, 'Skill dex 2', 'dex_2', 12028, 2, 1, 'Skill description'),
(31154, 'Skill dex 3', 'dex_3', 12028, 3, 1, 'Skill description'),
(31155, 'Skill dex 4', 'dex_4', 12028, 4, 1, 'Skill description'),
(31156, 'Skill dex 5', 'dex_5', 12028, 5, 1, 'Skill description'),
(31157, 'Skill infiltr 6', 'infiltr_6', 12029, 6, 1, 'Skill description'),
(31158, 'Skill infiltr 7', 'infiltr_7', 12029, 7, 1, 'Skill description'),
(31159, 'Skill infiltr 8', 'infiltr_8', 12029, 8, 1, 'Skill description'),
(31160, 'Skill infiltr 9', 'infiltr_9', 12029, 9, 1, 'Skill description'),
(31161, 'Skill infiltr 10', 'infiltr_10', 12029, 10, 1, 'Skill description'),
(31162, 'Skill pilot 6', 'pilot_6', 12030, 6, 1, 'Skill description'),
(31163, 'Skill pilot 7', 'pilot_7', 12030, 7, 1, 'Skill description'),
(31164, 'Skill pilot 8', 'pilot_8', 12030, 8, 1, 'Skill description'),
(31165, 'Skill pilot 9', 'pilot_9', 12030, 9, 1, 'Skill description'),
(31166, 'Skill pilot 10', 'pilot_10', 12030, 10, 1, 'Skill description'),
(31167, 'Skill portal 6', 'portal_6', 12031, 6, 1, 'Skill description'),
(31168, 'Skill portal 7', 'portal_7', 12031, 7, 1, 'Skill description'),
(31169, 'Skill portal 8', 'portal_8', 12031, 8, 1, 'Skill description'),
(31170, 'Skill portal 9', 'portal_9', 12031, 9, 1, 'Skill description'),
(31171, 'Skill portal 10', 'portal_10', 12031, 10, 1, 'Skill description'),
(31172, 'Skill geotech 6', 'geotech_6', 12032, 6, 1, 'Skill description'),
(31173, 'Skill geotech 7', 'geotech_7', 12032, 7, 1, 'Skill description'),
(31174, 'Skill geotech 8', 'geotech_8', 12032, 8, 1, 'Skill description'),
(31175, 'Skill geotech 9', 'geotech_9', 12032, 9, 1, 'Skill description'),
(31176, 'Skill geotech 10', 'geotech_10', 12032, 10, 1, 'Skill description'),
(31177, 'Skill stimm 6', 'stimm_6', 12033, 6, 1, 'Skill description'),
(31178, 'Skill stimm 7', 'stimm_7', 12033, 7, 1, 'Skill description'),
(31179, 'Skill stimm 8', 'stimm_8', 12033, 8, 1, 'Skill description'),
(31180, 'Skill stimm 9', 'stimm_9', 12033, 9, 1, 'Skill description'),
(31181, 'Skill stimm 10', 'stimm_10', 12033, 10, 1, 'Skill description'),
(31182, 'Skill medevac 6', 'medevac_6', 12034, 6, 1, 'Skill description'),
(31183, 'Skill medevac 7', 'medevac_7', 12034, 7, 1, 'Skill description'),
(31184, 'Skill medevac 8', 'medevac_8', 12034, 8, 1, 'Skill description'),
(31185, 'Skill medevac 9', 'medevac_9', 12034, 9, 1, 'Skill description'),
(31186, 'Skill medevac 10', 'medevac_10', 12034, 10, 1, 'Skill description'),
(31187, 'Skill traumsurg 6', 'traumsurg_6', 12035, 6, 1, 'Skill description'),
(31188, 'Skill traumsurg 7', 'traumsurg_7', 12035, 7, 1, 'Skill description'),
(31189, 'Skill traumsurg 8', 'traumsurg_8', 12035, 8, 1, 'Skill description'),
(31190, 'Skill traumsurg 9', 'traumsurg_9', 12035, 9, 1, 'Skill description'),
(31191, 'Skill traumsurg 10', 'traumsurg_10', 12035, 10, 1, 'Skill description'),
(31192, 'Skill forensi 6', 'forensi_6', 12036, 6, 1, 'Skill description'),
(31193, 'Skill forensi 7', 'forensi_7', 12036, 7, 1, 'Skill description'),
(31194, 'Skill forensi 8', 'forensi_8', 12036, 8, 1, 'Skill description'),
(31195, 'Skill forensi 9', 'forensi_9', 12036, 9, 1, 'Skill description'),
(31196, 'Skill forensi 10', 'forensi_10', 12036, 10, 1, 'Skill description'),
(31197, 'Skill spirit 6', 'spirit_6', 12037, 6, 1, 'Skill description'),
(31198, 'Skill spirit 7', 'spirit_7', 12037, 7, 1, 'Skill description'),
(31199, 'Skill spirit 8', 'spirit_8', 12037, 8, 1, 'Skill description'),
(31200, 'Skill spirit 9', 'spirit_9', 12037, 9, 1, 'Skill description'),
(31201, 'Skill spirit 10', 'spirit_10', 12037, 10, 1, 'Skill description'),
(31202, 'Skill waker 6', 'waker_6', 12038, 6, 1, 'Skill description'),
(31203, 'Skill waker 7', 'waker_7', 12038, 7, 1, 'Skill description'),
(31204, 'Skill waker 8', 'waker_8', 12038, 8, 1, 'Skill description'),
(31205, 'Skill waker 9', 'waker_9', 12038, 9, 1, 'Skill description'),
(31206, 'Skill waker 10', 'waker_10', 12038, 10, 1, 'Skill description'),
(31207, 'Skill evangel 6', 'evangel_6', 12039, 6, 1, 'Skill description'),
(31208, 'Skill evangel 7', 'evangel_7', 12039, 7, 1, 'Skill description'),
(31209, 'Skill evangel 8', 'evangel_8', 12039, 8, 1, 'Skill description'),
(31210, 'Skill evangel 9', 'evangel_9', 12039, 9, 1, 'Skill description'),
(31211, 'Skill evangel 10', 'evangel_10', 12039, 10, 1, 'Skill description'),
(31212, 'Skill strijd 6', 'strijd_6', 12040, 6, 1, 'Skill description'),
(31213, 'Skill strijd 7', 'strijd_7', 12040, 7, 1, 'Skill description'),
(31214, 'Skill strijd 8', 'strijd_8', 12040, 8, 1, 'Skill description'),
(31215, 'Skill strijd 9', 'strijd_9', 12040, 9, 1, 'Skill description'),
(31216, 'Skill strijd 10', 'strijd_10', 12040, 10, 1, 'Skill description'),
(31217, 'Skill newage 6', 'newage_6', 12041, 6, 1, 'Skill description'),
(31218, 'Skill newage 7', 'newage_7', 12041, 7, 1, 'Skill description'),
(31219, 'Skill newage 8', 'newage_8', 12041, 8, 1, 'Skill description'),
(31220, 'Skill newage 9', 'newage_9', 12041, 9, 1, 'Skill description'),
(31221, 'Skill newage 10', 'newage_10', 12041, 10, 1, 'Skill description'),
(31222, 'Skill doaune 6', 'doaune_6', 12042, 6, 1, 'Skill description'),
(31223, 'Skill doaune 7', 'doaune_7', 12042, 7, 1, 'Skill description'),
(31224, 'Skill doaune 8', 'doaune_8', 12042, 8, 1, 'Skill description'),
(31225, 'Skill doaune 9', 'doaune_9', 12042, 9, 1, 'Skill description'),
(31226, 'Skill doaune 10', 'doaune_10', 12042, 10, 1, 'Skill description'),
(31227, 'Skill operative 6', 'operative_6', 12043, 6, 1, 'Skill description'),
(31228, 'Skill operative 7', 'operative_7', 12043, 7, 1, 'Skill description'),
(31229, 'Skill operative 8', 'operative_8', 12043, 8, 1, 'Skill description'),
(31230, 'Skill operative 9', 'operative_9', 12043, 9, 1, 'Skill description'),
(31231, 'Skill operative 10', 'operative_10', 12043, 10, 1, 'Skill description'),
(31232, 'Skill journal 6', 'journal_6', 12044, 6, 1, 'Skill description'),
(31233, 'Skill journal 7', 'journal_7', 12044, 7, 1, 'Skill description'),
(31234, 'Skill journal 8', 'journal_8', 12044, 8, 1, 'Skill description'),
(31235, 'Skill journal 9', 'journal_9', 12044, 9, 1, 'Skill description'),
(31236, 'Skill journal 10', 'journal_10', 12044, 10, 1, 'Skill description'),
(31237, 'Skill oudgeld 6', 'oudgeld_6', 12045, 6, 1, 'Skill description'),
(31238, 'Skill oudgeld 7', 'oudgeld_7', 12045, 7, 1, 'Skill description'),
(31239, 'Skill oudgeld 8', 'oudgeld_8', 12045, 8, 1, 'Skill description'),
(31240, 'Skill oudgeld 9', 'oudgeld_9', 12045, 9, 1, 'Skill description'),
(31241, 'Skill oudgeld 10', 'oudgeld_10', 12045, 10, 1, 'Skill description'),
(31242, 'Skill sjach 6', 'sjach_6', 12046, 6, 1, 'Skill description'),
(31243, 'Skill sjach 7', 'sjach_7', 12046, 7, 1, 'Skill description'),
(31244, 'Skill sjach 8', 'sjach_8', 12046, 8, 1, 'Skill description'),
(31245, 'Skill sjach 9', 'sjach_9', 12046, 9, 1, 'Skill description'),
(31246, 'Skill sjach 10', 'sjach_10', 12046, 10, 1, 'Skill description'),
(31247, 'Skill dealmk 6', 'dealmk_6', 12047, 6, 1, 'Skill description'),
(31248, 'Skill dealmk 7', 'dealmk_7', 12047, 7, 1, 'Skill description'),
(31249, 'Skill dealmk 8', 'dealmk_8', 12047, 8, 1, 'Skill description'),
(31250, 'Skill dealmk 9', 'dealmk_9', 12047, 9, 1, 'Skill description'),
(31251, 'Skill dealmk 10', 'dealmk_10', 12047, 10, 1, 'Skill description'),
(31252, 'Skill xeno 6', 'xeno_6', 12048, 6, 1, 'Skill description'),
(31253, 'Skill xeno 7', 'xeno_7', 12048, 7, 1, 'Skill description'),
(31254, 'Skill xeno 8', 'xeno_8', 12048, 8, 1, 'Skill description'),
(31255, 'Skill xeno 9', 'xeno_9', 12048, 9, 1, 'Skill description'),
(31256, 'Skill xeno 10', 'xeno_10', 12048, 10, 1, 'Skill description'),
(31257, 'Skill superextr 6', 'superextr_6', 12049, 6, 1, 'Skill description'),
(31258, 'Skill superextr 7', 'superextr_7', 12049, 7, 1, 'Skill description'),
(31259, 'Skill superextr 8', 'superextr_8', 12049, 8, 1, 'Skill description'),
(31260, 'Skill superextr 9', 'superextr_9', 12049, 9, 1, 'Skill description'),
(31261, 'Skill superextr 10', 'superextr_10', 12049, 10, 1, 'Skill description'),
(31262, 'Skill mtexpl 6', 'mtexpl_6', 12050, 6, 1, 'Skill description'),
(31263, 'Skill mtexpl 7', 'mtexpl_7', 12050, 7, 1, 'Skill description'),
(31264, 'Skill mtexpl 8', 'mtexpl_8', 12050, 8, 1, 'Skill description'),
(31265, 'Skill mtexpl 9', 'mtexpl_9', 12050, 9, 1, 'Skill description'),
(31266, 'Skill mtexpl 10', 'mtexpl_10', 12050, 10, 1, 'Skill description'),
(31267, 'Skill botjock 6', 'botjock_6', 12051, 6, 1, 'Skill description'),
(31268, 'Skill botjock 7', 'botjock_7', 12051, 7, 1, 'Skill description'),
(31269, 'Skill botjock 8', 'botjock_8', 12051, 8, 1, 'Skill description'),
(31270, 'Skill botjock 9', 'botjock_9', 12051, 9, 1, 'Skill description'),
(31271, 'Skill botjock 10', 'botjock_10', 12051, 10, 1, 'Skill description'),
(31272, 'Skill spacemine 6', 'spacemine_6', 12052, 6, 1, 'Skill description'),
(31273, 'Skill spacemine 7', 'spacemine_7', 12052, 7, 1, 'Skill description'),
(31274, 'Skill spacemine 8', 'spacemine_8', 12052, 8, 1, 'Skill description'),
(31275, 'Skill spacemine 9', 'spacemine_9', 12052, 9, 1, 'Skill description'),
(31276, 'Skill spacemine 10', 'spacemine_10', 12052, 10, 1, 'Skill description'),
(31277, 'Skill factiepoli 6', 'factiepoli_6', 12053, 6, 1, 'Skill description'),
(31278, 'Skill factiepoli 7', 'factiepoli_7', 12053, 7, 1, 'Skill description'),
(31279, 'Skill factiepoli 8', 'factiepoli_8', 12053, 8, 1, 'Skill description'),
(31280, 'Skill factiepoli 9', 'factiepoli_9', 12053, 9, 1, 'Skill description'),
(31281, 'Skill factiepoli 10', 'factiepoli_10', 12053, 10, 1, 'Skill description'),
(31282, 'Skill icclobby 6', 'icclobby_6', 12054, 6, 1, 'Skill description'),
(31283, 'Skill icclobby 7', 'icclobby_7', 12054, 7, 1, 'Skill description'),
(31284, 'Skill icclobby 8', 'icclobby_8', 12054, 8, 1, 'Skill description'),
(31285, 'Skill icclobby 9', 'icclobby_9', 12054, 9, 1, 'Skill description'),
(31286, 'Skill icclobby 10', 'icclobby_10', 12054, 10, 1, 'Skill description'),
(31287, 'Skill polgener 6', 'polgener_6', 12055, 6, 1, 'Skill description'),
(31288, 'Skill polgener 7', 'polgener_7', 12055, 7, 1, 'Skill description'),
(31289, 'Skill polgener 8', 'polgener_8', 12055, 8, 1, 'Skill description'),
(31290, 'Skill polgener 9', 'polgener_9', 12055, 9, 1, 'Skill description'),
(31291, 'Skill polgener 10', 'polgener_10', 12055, 10, 1, 'Skill description'),
(31292, 'Skill itelite 6', 'itelite_6', 12056, 6, 1, 'Skill description'),
(31293, 'Skill itelite 7', 'itelite_7', 12056, 7, 1, 'Skill description'),
(31294, 'Skill itelite 8', 'itelite_8', 12056, 8, 1, 'Skill description'),
(31295, 'Skill itelite 9', 'itelite_9', 12056, 9, 1, 'Skill description'),
(31296, 'Skill itelite 10', 'itelite_10', 12056, 10, 1, 'Skill description'),
(31297, 'Skill itarchi 6', 'itarchi_6', 12057, 6, 1, 'Skill description'),
(31298, 'Skill itarchi 7', 'itarchi_7', 12057, 7, 1, 'Skill description'),
(31299, 'Skill itarchi 8', 'itarchi_8', 12057, 8, 1, 'Skill description'),
(31300, 'Skill itarchi 9', 'itarchi_9', 12057, 9, 1, 'Skill description'),
(31301, 'Skill itarchi 10', 'itarchi_10', 12057, 10, 1, 'Skill description'),
(31302, 'Skill savant 6', 'savant_6', 12058, 6, 1, 'Skill description'),
(31303, 'Skill savant 7', 'savant_7', 12058, 7, 1, 'Skill description'),
(31304, 'Skill savant 8', 'savant_8', 12058, 8, 1, 'Skill description'),
(31305, 'Skill savant 9', 'savant_9', 12058, 9, 1, 'Skill description'),
(31306, 'Skill savant 10', 'savant_10', 12058, 10, 1, 'Skill description'),
(31307, 'Skill academy 6', 'academy_6', 12059, 6, 1, 'Skill description'),
(31308, 'Skill academy 7', 'academy_7', 12059, 7, 1, 'Skill description'),
(31309, 'Skill academy 8', 'academy_8', 12059, 8, 1, 'Skill description'),
(31310, 'Skill academy 9', 'academy_9', 12059, 9, 1, 'Skill description'),
(31311, 'Skill academy 10', 'academy_10', 12059, 10, 1, 'Skill description'),
(31312, 'Skill stratcom 6', 'stratcom_6', 12060, 6, 1, 'Skill description'),
(31313, 'Skill stratcom 7', 'stratcom_7', 12060, 7, 1, 'Skill description'),
(31314, 'Skill stratcom 8', 'stratcom_8', 12060, 8, 1, 'Skill description'),
(31315, 'Skill stratcom 9', 'stratcom_9', 12060, 9, 1, 'Skill description'),
(31316, 'Skill stratcom 10', 'stratcom_10', 12060, 10, 1, 'Skill description'),
(31317, 'Skill account 6', 'account_6', 12061, 6, 1, 'Skill description'),
(31318, 'Skill account 7', 'account_7', 12061, 7, 1, 'Skill description'),
(31319, 'Skill account 8', 'account_8', 12061, 8, 1, 'Skill description'),
(31320, 'Skill account 9', 'account_9', 12061, 9, 1, 'Skill description'),
(31321, 'Skill account 10', 'account_10', 12061, 10, 1, 'Skill description'),
(31322, 'Skill interro 6', 'interro_6', 12062, 6, 1, 'Skill description'),
(31323, 'Skill interro 7', 'interro_7', 12062, 7, 1, 'Skill description'),
(31324, 'Skill interro 8', 'interro_8', 12062, 8, 1, 'Skill description'),
(31325, 'Skill interro 9', 'interro_9', 12062, 9, 1, 'Skill description'),
(31326, 'Skill interro 10', 'interro_10', 12062, 10, 1, 'Skill description'),
(31327, 'Skill bodyguard 6', 'bodyguard_6', 12063, 6, 1, 'Skill description'),
(31328, 'Skill bodyguard 7', 'bodyguard_7', 12063, 7, 1, 'Skill description'),
(31329, 'Skill bodyguard 8', 'bodyguard_8', 12063, 8, 1, 'Skill description'),
(31330, 'Skill bodyguard 9', 'bodyguard_9', 12063, 9, 1, 'Skill description'),
(31331, 'Skill bodyguard 10', 'bodyguard_10', 12063, 10, 1, 'Skill description'),
(31332, 'Skill flash 6', 'flash_6', 12064, 6, 1, 'Skill description'),
(31333, 'Skill flash 7', 'flash_7', 12064, 7, 1, 'Skill description'),
(31334, 'Skill flash 8', 'flash_8', 12064, 8, 1, 'Skill description'),
(31335, 'Skill flash 9', 'flash_9', 12064, 9, 1, 'Skill description'),
(31336, 'Skill flash 10', 'flash_10', 12064, 10, 1, 'Skill description'),
(31337, 'Skill shishaper 6', 'shishaper_6', 12065, 6, 1, 'Skill description'),
(31338, 'Skill shishaper 7', 'shishaper_7', 12065, 7, 1, 'Skill description'),
(31339, 'Skill shishaper 8', 'shishaper_8', 12065, 8, 1, 'Skill description'),
(31340, 'Skill shishaper 9', 'shishaper_9', 12065, 9, 1, 'Skill description'),
(31341, 'Skill shishaper 10', 'shishaper_10', 12065, 10, 1, 'Skill description');

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
  MODIFY `characterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT voor een tabel `ecc_char_implants`
--
ALTER TABLE `ecc_char_implants`
  MODIFY `modifierID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `ecc_char_sheet`
--
ALTER TABLE `ecc_char_sheet`
  MODIFY `charSheetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31342;
--
-- AUTO_INCREMENT voor een tabel `ecc_skills_groups`
--
ALTER TABLE `ecc_skills_groups`
  MODIFY `primaryskill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12066;COMMIT;
