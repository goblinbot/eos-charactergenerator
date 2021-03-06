-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 04 mrt 2018 om 22:46
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
CREATE TABLE IF NOT EXISTS `ecc_characters` (
  `characterID` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `character_name` varchar(100) DEFAULT NULL,
  `ICC_number` int(15) NOT NULL DEFAULT '0',
  `oc_name` varchar(75) DEFAULT NULL,
  `faction` varchar(25) NOT NULL,
  `bloodtype` varchar(6) NOT NULL DEFAULT 'A',
  `aantal_events` int(11) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'in design',
  `psychic` varchar(10) NOT NULL DEFAULT 'false',
  `ic_birthday` varchar(25) DEFAULT NULL,
  `birthplanet` varchar(25) DEFAULT NULL,
  `homeplanet` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`characterID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_characters`
--

INSERT INTO `ecc_characters` (`characterID`, `accountID`, `character_name`, `ICC_number`, `oc_name`, `faction`, `bloodtype`, `aantal_events`, `status`, `psychic`, `ic_birthday`, `birthplanet`, `homeplanet`) VALUES
(1, 451, 'Maati Infor Danam', 0, 'Thijs Test', 'Dugo', 'O', 5, 'in design', 'false', '7 dec 239NT', 'Kaito', 'Eos'),
(2, 451, 'Bakal Duguan Tulos', 0, 'Thijs Boerma', 'Dugo', 'AB', 4, 'deceased', 'false', '0', 'Kaito', 'Noboru'),
(3, 451, 'Kadh Rusks', 0, 'Thijs Boerma', 'Aquila', 'B', 1, 'inactive', 'false', '0', 'Nadz', 'Sturnus'),
(21, 451, 'Maati Priscus Testus', 0, NULL, 'ekanesh', 'A', 1, 'in design', 'true', '12-12-240NT', 'Test2', 'Test12'),
(26, 451, 'Natasha Ispravlyat', 0, NULL, 'pendzal', 'A', 0, 'in design', 'false', '214 NT', 'Ziamlia', 'Eos');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_char_implants`
--

DROP TABLE IF EXISTS `ecc_char_implants`;
CREATE TABLE IF NOT EXISTS `ecc_char_implants` (
  `modifierID` int(11) NOT NULL AUTO_INCREMENT,
  `sheetID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `type` varchar(25) NOT NULL DEFAULT 'cybernetic',
  `skillgroup_level` int(11) NOT NULL DEFAULT '0',
  `skillgroup_siteindex` varchar(15) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'active',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`modifierID`),
  KEY `characterID` (`sheetID`),
  KEY `accountID` (`accountID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_char_implants`
--

INSERT INTO `ecc_char_implants` (`modifierID`, `sheetID`, `accountID`, `type`, `skillgroup_level`, `skillgroup_siteindex`, `status`, `description`) VALUES
(1, 1, 451, 'cybernetic', 3, 'melee', 'active', 'C.3 Kinematic Booster'),
(2, 1, 451, 'cybernetic', 1, 'besch', 'removed', 'hoi'),
(3, 4, 451, 'cybernetic', 1, 'melee', 'active', ''),
(4, 4, 451, 'symbiont', 1, 'tele', 'active', ''),
(5, 4, 451, 'cybernetic', 5, 'cond', 'active', ''),
(6, 4, 451, 'cybernetic', 1, 'geo', 'active', ''),
(7, 4, 451, 'cybernetic', 1, 'geo', 'active', ''),
(8, 4, 451, 'cybernetic', 1, 'geo', 'active', ''),
(9, 1, 451, 'cybernetic', 1, 'geo', 'removed', ''),
(10, 11, 451, 'flavour', 0, 'none', 'active', 'Machine to Brain Capture Interface\r\n\r\nThis multi-chip interface augmentation contains a DirectDigitalInput chip, a PersonalControlUnit chip, and a SignalSender&Inhibitor chip.\r\n\r\nThese allow for control over the machine body.'),
(11, 11, 451, 'flavour', 0, 'none', 'active', 'MMI Network Chip:\r\nThis chip connects the entire body to the local MMI Network and runs propriatary MMI software.'),
(12, 11, 451, 'flavour', 0, 'none', 'active', 'A fully functioning defibrillator that can also act as Taser when altering the power settings.'),
(13, 1, 451, 'flavour', 0, 'none', 'active', 'CTZN \"Overseer\" class neural-chip.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_char_sheet`
--

DROP TABLE IF EXISTS `ecc_char_sheet`;
CREATE TABLE IF NOT EXISTS `ecc_char_sheet` (
  `charSheetID` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(32) DEFAULT NULL,
  `characterID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'ontwerp',
  `aantal_events` int(11) NOT NULL DEFAULT '0',
  `versionNumber` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`charSheetID`),
  KEY `characterID` (`characterID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_char_sheet`
--

INSERT INTO `ecc_char_sheet` (`charSheetID`, `nickname`, `characterID`, `accountID`, `status`, `aantal_events`, `versionNumber`) VALUES
(1, 'testje41', 1, 451, 'ontwerp', 5, 2),
(4, '', 2, 451, 'ontwerp', 4, 1),
(5, NULL, 23, 808, 'ontwerp', 0, 0),
(6, NULL, 21, 451, 'ontwerp', 0, 0),
(7, NULL, 3, 451, 'ontwerp', 0, 0),
(8, NULL, 22, 451, 'ontwerp', 0, 0),
(9, NULL, 24, 451, 'ontwerp', 0, 0),
(10, NULL, 25, 451, 'ontwerp', 0, 0),
(11, NULL, 26, 451, 'ontwerp', 0, 0),
(12, NULL, 26, 451, 'ontwerp', 3, 1),
(13, 'vreemd', 23, 451, 'ontwerp', 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_char_skills`
--

DROP TABLE IF EXISTS `ecc_char_skills`;
CREATE TABLE IF NOT EXISTS `ecc_char_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_id` int(11) NOT NULL,
  `char_sheet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

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
(28, 31300, 1),
(29, 31012, 4),
(30, 31013, 4),
(31, 31014, 4),
(32, 31017, 4),
(33, 31022, 4),
(34, 31023, 4),
(35, 31027, 4),
(36, 31028, 4),
(37, 31029, 4),
(38, 31032, 4),
(39, 31033, 4),
(40, 31034, 4),
(41, 31042, 4),
(42, 31043, 4),
(43, 31044, 4),
(44, 31045, 4),
(45, 31046, 4),
(46, 31297, 4),
(47, 31298, 4),
(48, 31299, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_factionmodifiers`
--

DROP TABLE IF EXISTS `ecc_factionmodifiers`;
CREATE TABLE IF NOT EXISTS `ecc_factionmodifiers` (
  `factionID` int(11) NOT NULL AUTO_INCREMENT,
  `faction_siteindex` varchar(20) NOT NULL DEFAULT 'aquila',
  `type` varchar(10) NOT NULL DEFAULT 'strong',
  `skill_id` int(11) NOT NULL,
  `cost_modifier` int(5) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`factionID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

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
CREATE TABLE IF NOT EXISTS `ecc_skills_allskills` (
  `skill_id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(50) NOT NULL,
  `skill_index` varchar(15) NOT NULL,
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `description` varchar(1280) NOT NULL,
  PRIMARY KEY (`skill_id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=31343 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ecc_skills_allskills`
--

INSERT INTO `ecc_skills_allskills` (`skill_id`, `label`, `skill_index`, `parent`, `level`, `version`, `description`) VALUES
(31012, 'Ballistiek beginner', 'guns_1', 12000, 1, 1, 'Je hebt je beginnerscursus afgerond en leren omgaan met simpele vuurwapens. Het gaat\r\nhierbij om wapens met een klein magazijn. Veel kolonisten hebben op zijn minst een simpel\r\nvuurwapen bij zich waar ze bedreven mee zijn.\r\nWat je mag gebruiken:\r\nâ€‹\r\n enkelschots wapens, eventueel met klein intern magazijn (max 3\r\nschoten). Denk aan de Jolt, Firestrike en Triad modellen.'),
(31013, 'Ballistiek amateur', 'guns_2', 12000, 2, 1, 'Je kan omgaan met semi-automatische pistolen en jachtgeweren, vaak geladen met een intern magazijn. Dit is het niveau van de meeste wetshandhavers, sportschutters,\r\nsportjagers en coloniale milities op zitten. Je mag op dit niveau ook archaÃ¯sche wapens zoals bogen gebruiken, wat voor sommige facties nog een ceremoniÃ«le waarde heeft.\r\nWat je mag gebruiken:\r\nâ€‹\r\n simpele jachtgeweren met of zonder magazijn, revolver. Denk aan de\r\nMaverick, Hammershot en Barrel Break'),
(31014, 'Ballistiek professional', 'guns_3', 12000, 3, 1, 'Je kan omgaan met semi-automatische wapens met variabele magazijnen, en kent de basis van standaard explosieven zoals granaten. Vrijwel alle militairen trainen tot minimaal dit\r\nniveau ongeacht factie, en vaak zijn prive-beveiligers en huurlingen ook op dit niveau (al dan niet ex-militair).\r\nWat je mag gebruiken: \r\nâ€‹\r\nsemi-automatische wapens met 6-18 schots rechte magazijnen\r\n(geen drums) en multischot wapens. Denk aan de Recon, Stryfe, Longshot en Sledgefire.\r\nVanaf dit niveau ben je ook in staat om granaten gebruiken.'),
(31015, 'Ballistiek specialist', 'guns_4', 12000, 4, 1, 'Je kunt omgaan met semi- en volautomatische wapens met grote munitiedrums, en multischots wapens die in staat zijn enorme schade te doen in een enkel salvo. Bijzondere Bijstands Teams, militairen die dienen op de periferie en professionele huurlingen zijn goede voorbeelden.\r\n\r\nWat je mag gebruiken: volautomatisch wapens met magazijnen en magazijndrums tot 25 en grote wapens die veel schoten tegelijk afvuren. Denk aan de Stampede, RapidFire en Diatron.'),
(31016, 'Ballistiek expert / Leren van de meester', 'guns_5', 12000, 5, 1, 'Je mag omgaan met elke denkbare vorm van draagbaar vuurwapen, van raketwerpers tot lichte machinegeweren. Dit is het niveau van ervaren veteranen en instructeurs, en je expertise is zo groot dat je anderen mee kunt nemen in de fijne kneepjes van het vak:\r\n\r\nWat je mag gebruiken: the sky is the limit wat betreft draagbare vuurwapens. Denk aan de Vulcans en Rhinos met munitie-drums.\r\n\r\nLeren van de meester: Als je fysiek voor iemand anders herlaad, dan mag die persoon de clip gebruiken ongeacht level aan ballistiek, totdat deze leeg is.'),
(31017, 'Duel basics', 'melee_1', 12001, 1, 1, 'Wapenlengte 45 cm\r\n\r\nDeze techniek is alleen te gebruiken tijdens een duel: Je kunt ervoor kiezen om de flat of the blade te gebruiken, zodat je geen schade doet met je wapen.'),
(31018, 'Duelling defense', 'melee_2', 12001, 2, 1, 'Wapenlengte 85 cm\r\n\r\nDeze techniek is alleen te gebruiken tijdens een duel: Je mag voor het duel een ledemaat aangeven die immuun is voor schade totdat er een ander ledemaat geraakt is. Je mag hiermee actief blokkeren. (je moet je tegenstander hiervan op de hoogte stellen, of je wikkelt je arm in met een cloak zodat het voor het zicht duidelijk is.)'),
(31019, 'Duelling mark / Steel wall', 'melee_3', 12001, 3, 1, 'Wapenlengte 115 cm\r\n\r\nDeze skill is alleen te gebruiken tijdens een duel: Je geeft duidelijk aan welk ledemaat je gaat slaan. Indien je dat specifieke ledemaat raakt, dan kan de ander dit ledemaat niet meer gebruiken om mee aan te vallen.\r\n\r\nJe mag je melee wapens gebruiken om nerfdarts te blocken. Als je het projectiel weet te raken, doet het noch jou nog je wapen schade. NB: dit is een experimentele regel, we zijn nog niet overtuigd van dat dit echt een rendabele vaardigheid is. Kan na evaluatie worden aangepast of geschrapt.'),
(31020, 'Duelling feint', 'melee_4', 12001, 4, 1, 'Wapenlengte 160 cm\r\n\r\nIn het begin van het duel krijg je een free hit op je opponent, tenzij de ander ook duelling feint heeft in welk geval er niets gebeurt. (uiteraard overleg je dit van tevoren en speel je het leuk uit hoe die hit er komt. Showmanship for the win!).'),
(31021, 'Duelling master', 'melee_5', 12001, 5, 1, 'Wapenlengte 250 cm\r\n\r\nJe mag tijdens het duel een tweede keer duelling defense gebruiken.'),
(31022, 'Source-choice', 'besch_1', 12002, 1, 1, 'AP 1\r\n\r\nJe mag 1x evenement vaststellen of je je AP vanuit je harnas wilt, of vanuit je krachtveld, of een combinatie van beiden. Wil je deze keuze tijdens het evenement wijzigen, mag dat alleen binnen het bastion tezamen met een ingenieur. Dit kan je uitspelen door middel van het opvoeren van je schildgenerator en/of het aanpassen van je pantser.'),
(31023, 'Radiation shield / Agile in armor', 'besch_2', 12002, 2, 1, 'AP 2\r\n\r\nHiervoor heb je een actieve 2 AP krachtveld nodig. Je mag ten kosten van een extra powercell 5 minuten zware straling buiten houden, of een hele dag lichte (fallout) straling.\r\n\r\n\r\nMinimaal 2 AP in pantser. Je mag expert taken zoals ingenieur, medische handelingen, chemie, geologie etc in je harnas uitvoeren.'),
(31024, 'Quick fix', 'besch_3', 12002, 3, 1, 'Met noodreparaties en reserve-energy mag je 1x op missie buiten een gevecht je volledige AP waarde herstellen. Je hebt hier een repair kit voor nodig.'),
(31025, 'Field projection / Bolwerk', 'besch_4', 12002, 4, 1, 'AP 3\r\n\r\nMinimaal 3 ap schild. Je verleent de helft van je schild (naar boven afgerond) aan een ander die je aanraakt. Dit mag stacken met de al aanwezige bescherming tot de maximale cap.\r\n\r\nMinimaal 3 ap harnas. De eerste granaat inslag doet halve schade. Reset na reparatie.'),
(31026, 'Energy dissipation', 'besch_5', 12002, 5, 1, 'AP 4\r\n\r\nJe pakt zolang je 1 AP schild of harnas hebt 1 HP minder schade van tasers.'),
(31027, 'Kruipen', 'will_1', 12003, 1, 1, 'Als je neergaat mag je met wilskracht 1 naast roepen ook nog kruipen. De normale doodbloedregels blijven tellen.'),
(31028, 'Bezielen', 'will_2', 12003, 2, 1, 'Door te praten mag je je niveau wilskracht met 1 ander persoon delen. Die persoon krijgt een tijdelijke Wilskracht niveau gelijk aan dat van jou min Ã©Ã©n indien dat hoger is dan zijn of haar eigen wilskracht, zolang je tegen hem blijft praten, je moet minstens Ã©Ã©n minuut praten. Alleen de bescherming tegen telepsychica door het hebben van een hoger Wilskracht niveau wordt gedeeld.'),
(31029, 'Pijnverbijten', 'will_3', 12003, 3, 1, 'Als je op 0 HP komt, mag jij mag wegstrompelen in plaats van wegkruipen. Krijg je nog een klap/kogel, val je alsnog om en mag je alleen nog maar roepen. Verder heb je tijdens medische handelingen (en eventueel andere roleplay toepasselijke situaties) geen pijnstillers nodig indien je uitspeelt dat je de pijn verbijt.'),
(31030, 'Demper', 'will_4', 12003, 4, 1, 'Als je iemand met telepsychische gaven op de schouder aanraakt, kun je ervoor kiezen om zijn gaven te dempen indien jouw wilskracht hoger is dan die van de ander. Je kan ten allen tijde maar een persoon tegelijk â€˜dempenâ€™.'),
(31031, 'Mentale blokkade', 'will_5', 12003, 5, 1, '1x per evenement mag je een telepsychisch effect ongeacht level weerstaan, mits je een tirade, kata, mantra of een andere manier van uitspelen van 30 seconden afsteekt tegen je opponent. Tijdens de 30 seconden mag je weglopen en verplaatsen maar geen inspannende offensieve acties ondernemen - je hebt al je concentratie nodig om de aanval te weerstaan.'),
(31032, 'Doodbloeden / Medical tolerance', 'cond_1', 12004, 1, 1, 'Normaal als je op 0 HP komt, bloed je in 5 minuten dood. Per niveau krijg je 1 minuut tijd erbij.\r\n\r\nZonder negatieve effecten mogen er per dag je conditie +1 stimms toegediend worden. Indien je meer stims geeft aan iemand dan wat hij mag hebben, zie â€˜overdosisâ€™ onder algemene regels.'),
(31033, 'Skill cond 2', 'cond_2', 12004, 2, 1, 'Max bionic 1'),
(31034, 'Skill cond 3', 'cond_3', 12004, 3, 1, 'Max bionic 2'),
(31035, 'Skill cond 4', 'cond_4', 12004, 4, 1, 'Max bionic 3'),
(31036, 'Die hard', 'cond_5', 12004, 5, 1, 'Max bionic 4\r\n\r\nAls je neergaat (HP staat op 0) mag je gevechtshandelingen uit blijven voeren zolang je bij bewustzijn bent. Je mag je niet verplaatsen met deze techniek, daar zijn wilskracht 1 of 3 voor.'),
(31037, 'Hergebruik', 'engi_1', 12005, 1, 1, 'Je kan oude apparatuur afbreken om de nog bruikbare componenten te recupereren. Om een voorwerp te recycleren moet je minimaal dezelfde level hebben als die je nodig hebt om het voorwerp te maken. Vervolgens krijg je een percentage van de basisgrondstoffen terug.\r\nMeld je hiervoor bij de infobalie.'),
(31038, 'Crafting', 'engi_2', 12005, 2, 1, 'Je beschikt over de nodige kennis om apparatuur/halffabricaten te maken, mits je de nodige grondstoffen hebt. Hogere levels laten je toe meer en betere dingen te maken. Om te zien welke voorwerpen je kan vervaardigen, zie het Frontier Boek 2 - Crafting.'),
(31039, 'Herstellen', 'engi_3', 12005, 3, 1, 'Je kan een beschadigd apparaat herstellen. Als je het kan maken, kun je het repareren. Dit kan alleen op de kolonie of een andere plek waar je in redelijke rust met een goed verlichte werkbank aan de slag kan. Belangrijk is wel dat je bij het voorwerp kunt. Als het bijvoorbeeld een interne bionic betreft is het verstandig om er een dokter bij te halenâ€¦'),
(31040, 'Noodreparatie', 'engi_4', 12005, 4, 1, 'Je kunt per missie in het veld twee harnassen herstellen. (meestal je eigen harnas en van een van je buddies). Ook mag je 2 krachtveldgeneratoren herstellen met een extra energycell. Zowel de harnassen en krachtveldgeneratoren zijn hierna onherstelbaar beschadigd en kun je weggooien.'),
(31041, 'Emergency power', 'engi_5', 12005, 5, 1, 'Zes keer per dag kan je een apparaat of bionic dat uitgeschakeld is vanwege een gebrek aan Energy Cells voor 2 uur normaal functioneren. Dit werkt niet op krachtveldgeneratoren.'),
(31042, 'IT beginner', 'it_1', 12006, 1, 1, 'Je kunt complexe programmaâ€™s bedienen en daarmee bijvoorbeeld simpele websites bouwen. Ook kun je dingen opzoeken in databases. Hacking: je hebt een hacker login. Je snapt de basics van hacking en kunt simpele passwords hacken als er geen goede beveiliging tegen is. Je kunt sites hacken, maar kunt alleen een specifiek soort Ice hacken (genaamd: Kama).'),
(31043, 'IT amateur', 'it_2', 12006, 2, 1, 'Je kunt programmeren en zelf sites bouwen. Hacking: je kunt alle reguliere typen Ice hacken (alles behalve Jagannatha).\r\n'),
(31044, 'IT professional', 'it_3', 12006, 3, 1, 'Je kunt sites maken die een basale verdediging hebben tegen hackers. Hacking: je kunt sites scannen voorafgaand aan een hack en zo een plan maken voor hoe de site het best te hacken is.'),
(31045, 'Netwerkspecialist', 'it_4', 12006, 4, 1, 'Je kunt een (lokaal) netwerk opzetten of een permanente verbinding opzetten met een extern systeem. Hacking: Je hacking netwerk geeft je dagelijks toegang tot hacking scripts, je kunt ieder script 1x per dag gebruiken: Analyze (1x) je kunt een Ice layer vooraf analyseren en de puzzel vooraf oplossen Snoop (1x) je kunt een passcode vault, local core of syscon vooraf analyseren en leren wat er te halen valt. Mask (1x) Je krijgt extra tijd voor een hack (1 minuut)'),
(31046, 'Security expert', 'it_5', 12006, 5, 1, 'Je kunt alle reguliere Ice layers inzetten in de verdediging van je eigen sites. Hacking: Je hacking netwerk geeft je dagelijks toegang tot extra scripts: Analyze (3x) - In totaal nu 4 per dag. Snoop (2x) - In totaal nu 3 per dag'),
(31047, 'Tactical field care / Medicijnen toedienen', 'firstaid_1', 12007, 1, 1, 'Je kunt mensen in je eentje stabiliseren in de buitenlucht met drukverbanden, triage en bloedstollers, zolang er geen gevechtshandelingen meer plaatsvinden.\r\n\r\n\r\nJe kunt standaard medicijnen toedienen zonder dat de toediening problemen veroorzaakt. Je kan nog wel een overdosis veroorzaken. Je hebt Strengthen Metabolism nodig om stims (steroide drugs) toe te dienen.'),
(31048, 'Donâ€™t you die on me', 'firstaid_2', 12007, 2, 1, 'Tijdens het gevecht kun je iemand in leven houden, indien je bij die persoon blijft. Door het bloeden te stelpen geef je hem of haar een kans om het te overleven. Zolang jij erbij blijft, dan bloed deze persoon niet meer dood.'),
(31049, 'Medic motivation', 'firstaid_3', 12007, 3, 1, 'Door een slachtoffer uit de gevechtszone te schreeuwen, coachen, motiveren, kan het slachtoffer zich nog voortbewegen richting de gewondenhulp om verzorging te ontvangen.'),
(31050, 'Care under fire', 'firstaid_4', 12007, 4, 1, 'Je kunt mensen stabiliseren zoals bij Tactical Field Care terwijl er gevechtshandelingen plaatsvinden: Je kunt â€˜donâ€™t you die on meâ€™ en â€˜care under fireâ€™ niet tegelijkertijd gebruiken.'),
(31051, 'Strengthen metabolism', 'firstaid_5', 12007, 5, 1, 'Je kunt twee hitpoints â€˜genezenâ€™ door een stim toe te dienen. Deze persoon functioneert effectief tot de volgende maaltijd alsof ze genezen zijn. Deze hitpoints kan hij dus ook weer verliezen. Na de volgende maaltijd loopt de stim af en stort de persoon in. Alle wonden die hij heeft ontvangen tellen op en complicaties zijn te verwachten. Indien je meer stims toedient dan Conditie toelaat, dan ontstaan er complicaties en is er een arts nodig die een overdosis kan behandelen.'),
(31052, 'Beoordeel status / Diagnose / Drugs toedienen', 'surgery_1', 12008, 1, 1, 'Je beschikt over genoeg vaardigheid om te zien hoe ernstig iemand gewond is, als het om uitwendige verwondingen gaat. Je weet ook door je kennis, hoe je deze wonden kunt behandelen, of wie je daarvoor nodig hebt. Je rolt hiervoor op de generator. Voor deze vaardigheid is een Mediscanner of andere â€œbeoordelingsâ€physrep nodig, of je speelt een lichamelijk onderzoek uit gedurende 1 minuut (minimaal)\r\n\r\nJe kan ziekten en giffen herkennen. Als je iemand onderzoekt meldt deze welke symptonen hij vertoont. Aan de hand van deze symptomen kan je op een loresheet zien welke ziekte of vergiftiging hij mogelijk heeft en welke medicatie daar tegen kan werken. Per level geneeskude worden 2 giffen en 2 ziektes toegevoegd aan je loresheet. Hoewel deze informatie tussen verschillende geneeskundigen mag worden uitgewisseld, mag enkel de speler met deze informatie op zijn originele loresheet de nodige medicatie toedienen om een ziek iemand te genezen.\r\n\r\nJe kunt standaard drugs toedienen zonder dat dit problemen veroorzaakt. Je kan nog wel een overdosis veroorzaken. Naast stims, kan iemand zijn HP aan drugs per dag veilig toegediend krijgen. Indien je meer dan iemands HP aan drugs toedient overdoseer je de persoon en rol je op de OD-generator. Je hebt Strengthen Metabolism n'),
(31053, 'Identificeer medicatie / Bloed afnemen / Operat', 'surgery_2', 12008, 2, 1, '\r\nJe kan door het uitvoeren van een eenvoudige test een medicijn herkennen. Hiervoor krijg je een loresheet met codes. Op deze loresheet staan alle codes van alle drugs, medicatie en anti-giffen die je op deze manier kan herkennen. Welke codes je kent is afhankelijk van je level geneeskude\r\n.\r\n\r\nJe beschikt over genoeg vaardigheid om bloed af te nemen. Bloed kan alleen afgenomen worden van levende personen. Je kan maximaal 2 bloedzakken per persoon per dag afnemen. Teveel bloed afnemen kan dodelijk zijn. Je hebt kennis van het protocol omtrent bloed afnemen, gereed maken voor donatie en bewaarcondities.\r\n\r\n\r\nJe mag een chirurgische operatie assisteren. Als je een Chirurg assisteert mogen jullie samen de operatie doen. Je mag echter zelf niet opereren, zelfs niet met nog een tweede Operatie Assistent.'),
(31054, 'Identificeer bloed / Overdosis behandelen', 'surgery_3', 12008, 3, 1, 'Op basis van bloedtransfusie (3 bloedzakken), Medicatie, roleplay (braken, klysma) een overdosis kunnen behandelen.\r\n\r\nJe beschikt over de vaardigheid door middel van een eenvoudige sneltest een bloedgroepbepaling te doen. Hierdoor weet je welke bloedgroep een patient heeft, of welke bloedgroep er in een bloedzak zit. Je weet niet of het bloed vrij is van ziektes, modificatie, antifstoffen of giffen Physrep sneltest benodigd.'),
(31055, 'Chirurgische operatie', 'surgery_4', 12008, 4, 1, 'Vanaf niveau 4 kan je een medische operatie uitvoeren op gewonde figuren. Hiervoor heb je minstens of een andere chirurg of operatie assistent nodig. Oftewel een operatie dient met minstens 2 personenen uit gevoerd te worden waarbij 1 minstens level 4 en de ander minstens level 2 geneeskunde hebben.\r\nEen operatie dient altijd om iemand terug zijn volledige hitpoints te geven. Als iemand op 0 hitpoints staat moet je een intensieve operatie uitvoeren om hem te genezen. Als je een operatie wilt uitvoeren op iemand die nog een deel van zijn hitpoints heeft, ongeacht hoeveel dit er zijn, volstaat het om een meer standaard â€˜behandelingâ€™ uit te voeren.\r\nEen intensieve operatie duurt zo ongeveer 15 minuten en vereist 8 bloedzakken.\r\nEen standaardoperatie duurt zo ongeveer 10 minuten en vereist 5 bloedzakken.\r\nMeerdere levels in Geneeskunde zorgen ervoor dat je minder tijd en bloedzakken nodig hebt voor een operatie. Genezen spelers dienen zich te beseffen dat als zij genezen zijn, zij niet zonder meer aan allerlei activiteiten kunnen deelnemen. Hoe er rekening mee dat je tot ongeveer een uur na de operatie geen zware activiteiten kan uitvoeren, al zijn er manieren om deze tijd te verminderen.\r\n\r\nLet op, bloedzakken die gebruikt worden tijdens een operatie moeten e'),
(31056, 'Onderdruk symptomen', 'surgery_5', 12008, 5, 1, 'Operatie reductie -1 minuut\r\nBloedzak reductie -1\r\n\r\nJe kan giffen en ziektes 20 minuten vertragen alvorens ze een effect beginnen te hebben op het lichaam.\r\n\r\n'),
(31057, 'Mairâ€™s Blessing', 'tele_1', 12009, 1, 1, '(Aanraak) (onbeperkt bruikbaar)\r\nJe kunt een voorwerp zegenen met de kracht van Mair. Deze zegeningen worden weergegeven door witte linten met zwarte tribals erop. Iedereen voelt dat een voorwerp gezegend is met de kracht van Mair als ze de linten kunnen zien. Je mag als priester maximaal 5 voorwerpen gezegend hebben tegelijk. Na het volgende gevecht is deze zegening verlopen. Een gezegend wapen kan soms vijanden meer pijn doen als ze recht tegenover Mair staan.\r\n(Term: Zegening!)'),
(31058, 'MaÃ¯râ€™s Hand', 'tele_2', 12009, 2, 1, '(Aanraak) (1x per dagdeel)\r\nHet doel van deze power heeft een psychisch schild om zich heen. Dit schild heeft 2 AP. Het\r\nwerkt regeltechnisch hetzelfde als een krachtveld, maar zonder de noodzaak voor een frep of energy cell. Mairâ€™s Hand blijft actief tot het is vernietigd, of tot de volgende ochtend.'),
(31059, 'Mairâ€™s Prevention', 'tele_3', 12009, 3, 1, '(Aanraak, of Aandachts- & Stembereik voor de Ceremonievariant) (Ceremonie) (1x per dag)\r\nDe eerst volgende ziekte die deelnemers tijdens dit evenement krijgen, wordt automatisch geprobeerd te genezen (1x cure level 1 disease) of te dempen indien niveau 1 te weinig is. Indien reeds zieken zijn als de mis begint, zal de genezing van deze zieken onderdeel moeten zijn van de Ceremonie.\r\nSpecial: 1x per evenement mag je bij 1 persoon een ziekte genezen ongeacht level. De patient mag IC en OC weigeren, tenzij de patient een Mair-gelovige is.'),
(31060, 'Mairâ€™s Shout', 'tele_4', 12009, 4, 1, '(Aandachts- & Stembereik) (1x per gevecht)\r\nJe kunt door de woorden van Mair in iemand zijn/haar richting te schreeuwen een stukje laten â€˜vliegenâ€™. Het doel van de spreuk word 5 meter naar achter geslagen.\r\n(Term: Terugslag!)'),
(31061, 'MaÃ¯râ€™s Journey', 'tele_5', 12009, 5, 1, '(Zelf) (onbeperkt) (1x per gevecht)\r\nJe kunt zelf onzichtbaar worden zolang je levensbedreigd wordt in een gevecht, en je kunt buffen, crowdcontrollen (bijv. Mairâ€™s Shout) en gewondenhulp gebruiken. Alle kleding, wapens en voorwerpen die je aan hebt of mee draagt worden ook onzichtbaar, maar zaken die je oppakt nadat je onzichtbaar bent geworden, blijven zichtbaar. Mensen kun je niet onzichtbaar maken en je kunt geen explosieven of wapens bij je dragen. Op het moment dat je schade aan iemand toebrengt eindigt de onzichtbaarheid en krijg je 1 schade. Iemand met niveau 7 wilskracht ziet door je onzichtbaarheid heen.'),
(31062, 'Ontcijfer', 'intel_1', 12010, 1, 1, 'Je bent in staat nieuwe talen en moeilijke documenten te ontcijferen. Deze handeling heeft zowel effect op geschreven taal of cijfer-overzichten. Je wordt beter in deze handeling naar mate je meer niveauâ€™s in Informatie-analyse neemt - je zal sneller kunnen vertalen en moeilijkere sleutels kunnen ontcijferen. Vraag de SL om een vertaling. Naar gelang je level krijg je een kleiner of groter gedeelte van de vertaling.'),
(31063, 'Sociological Knowledge', 'intel_2', 12010, 2, 1, 'Tijdens het event kan je extra informatie opvragen over de nieuwsberichten die op het Gaia netwerk verschijnen. Meld je hiervoor bij een SL. Voor elke 2 levels in Informatie-analyse kan je van een extra bericht informatie opvragen, tot een maximaal van 5 berichten.'),
(31064, 'Detecteer vervalsing', 'intel_3', 12010, 3, 1, 'Je hebt geleerd hoe je vervalsingen moet ontdekken, zolang het een officiÃ«le bron heeft.\r\nDeze skill gaat over officiÃ«le (virtuele) objecten zoals identiteitspapieren, geld, contracten, waardepapieren en dergelijken. Je checkt authenticiteit op basis van niveau: B.V. De authenticiteit van geld & bankrekeningnummer *wel*â€‹, maar hoe de persoon aan dat geld gekomen is *nietâ€‹*.\r\nOp niveau 3 heb je alleen kennis over de documenten van je eigen factie plus twee naar keuze. Per niveau Informatie-analyse krijg je kennis over de documenten van een andere factie naar keuze, totdat je op niveau 5 alle documenten van alle facties kent.'),
(31065, 'PersattachÃ©', 'intel_4', 12010, 4, 1, 'Een bericht (laten) plaatsen is een ding, maar weten hoe deze ontvangen gaat worden is een andere. Vier keer per evenement mag je een opiniepeiling doen om te testen hoe een pers-uiting ontvangen zal worden door een factie naar keuze. Je gaat hiervoor naar de Overlord die je het resultaat geeft.'),
(31066, 'Paralegal', 'intel_5', 12010, 5, 1, 'Juridisch advies (indekken/coverup): 1 keer per evenement mag je een mailtje te sturen naar de overlord waarin je een situatie juridisch indekt. Hoe meer mensen over 1 situatie mailen, hoe beter jullie de situatie juridisch indekken. Daarnaast mag je wel een rechtszaak aanhangig maken (formeel laten beginnen), maar mag je (nog) geen verdediging voeren.'),
(31067, 'Antecedenten-onderzoek', 'politic_1', 12011, 1, 1, '(aka Is hij wie hij zegt dat hij is?)\r\n4 keer per evenement mag je vragen of iemand binnen je factie of het ICC te vertrouwen is.\r\nIn principe is dit gelimiteerd tot ja/nee, maar een SL kan overwegen meer informatie geven.\r\nBij Aquila kun je denken aan een NAW-gegevens check. Bij de Sona kun je denken aan zijn kredietwaardigheid opvragen. Bij de Dugo kun je denken aan zijn eer navragen. Bij de Ekanesh kun je denken aan zijn lidmaatschap opvragen bij zijn congregatie. Bij de Pendzal kun je denken aan rondvragen bij zijn clan.\r\nDe Dugo noemen deze skill: Tatak checken: Ik check de Tatak om zeker te weten dat hij eer heeft.'),
(31068, 'Trust me', 'politic_2', 12011, 2, 1, '3 keer per evenement mag je mensen uit je netwerk binnen je factie of het ICC via de mail voor je laten vouchen zodat een oldspace-target je vertrouwd. In eerste instantie is dit vertrouwen broos en laat je alleen weten dat je bent wie je bent. Door dit te herhalen kun je bestaande relaties sterker maken. Deze skill gebruik je vaak samen met andere politieke skills. Uiteraard kan dit niet gebruikt worden op politieke vijanden.'),
(31069, 'Conversational Topic / Political plan', 'politic_3', 12011, 3, 1, '2 keer per evenement mag je een figurant OC vragen wat zijn/haar het favoriete gespreksonderwerp is. Indien een figurant zijn/haar conversational topic vergeten is, stem dan voor dat moment met elkaar een nieuwe af. (pak b.v. ICCN films/series, ruimteschepen of een hobby) Op deze wijze kun je gemakkelijk een praatje maken met elke figurant waar je toevallig even mee moet wachten in een lift of voor een vergadering.\r\n\r\n\r\nOm politieke doelen te halen, heb je politieke plannen nodig. Met deze skill verkrijg je meta-inzicht welke skillniveau\'s je nodig hebt om jouw, of je baas haar politieke plan uit te voeren.\r\nOp basis van je meta-inzicht besluit je of je het plan tot uitvoer wil brengen.Je mag maximaal 3 political plans tegelijkertijd hebben. Plannen maken & schrappen altijd in samenspraak met de SL\'s tussen evenementen. De uitvoering (en hopelijk vervolmaking) van het plan juist wel op het evenement.'),
(31070, 'Email-introduction', 'politic_4', 12011, 4, 1, '1 keer per evenement kun je aan je netwerk vragen om geÃ¯ntroduceerd te worden aan iemand in oldspace binnen je factie of het ICC van gelijk of lager niveau. (SL\'s hebben het recht om de introductie te physreppen door een NPC)'),
(31071, 'Doing a favour', 'politic_5', 12011, 5, 1, '1 keer per evenement krijg je een gunstverzoek van iemand, als je daar OC om vraagt. Je kunt ervoor kiezen om het iemand te laten zijn die je al kent, of een SL gekozen persoon.\r\nLinksom of rechtsom: Iemand zal jou iets vragen om voor hen te doen. Lukt het je, dan kun je een favor terugvragen en mag je deze skill opnieuw gebruiken. Lukt het niet, maar probeerde je het wel, adviseren we je om dat te vertellen: Dan heb je op zn minst het vertrouwen van deze persoon gewonnen.'),
(31072, 'Skill eco 1', 'eco_1', 12012, 1, 1, 'Budgetmacht (100 s)'),
(31073, 'Bedrijfsinformatie bestellen', 'eco_2', 12012, 2, 1, 'Budgetmacht (200 s)\r\n\r\nVoor 1 sonuur mag je de bedrijfsinformatie van 1 bedrijf opvragen, ongeacht de factie. De bedrijfsnaam moet correct aangeleverd worden. Dit is gelimiteerd tot 4 keer per evenement.\r\nDe termijn van deze aanvragen zal variÃ«ren tussen enkele IC minuten (indien de speler/SL deze informatie in het juiste template gezet heeft), tot enkele IC dagen (oftewel het volgende OC evenement).'),
(31074, 'Recruitment', 'eco_3', 12012, 3, 1, 'Budgetmacht (300 s)\r\n\r\nPer evenement mag je 1 keer gratis een kernwereld-specialist inhuren ter hoogte van 1-5. Deze specialisten werken alleen remote (zijn niet fysiek aanwezig en worden niet gefrept)'),
(31075, 'Skill eco 4', 'eco_4', 12012, 4, 1, 'Budgetmacht (400 s)'),
(31076, 'Noodtransportkorting', 'eco_5', 12012, 5, 1, 'Budgetmacht (500 s)\r\n\r\nHet portaal gebruiken is duur: 100.000 sonuren per keer, of 200.000 sonuren voor een retourtrip. Voor de standaard dagelijkse leveringen vanuit de kernwerelden betaalt het ICC.\r\nDeze skill zorgt ervoor dat je per weekend eenmaal 25% korting krijgt op een (retour)noodtransport. Deze bonus is te stacken met andere economen met niveau 5 economie, zodat met 4 personen 1 retourtrip 100% gratis wordt.'),
(31077, 'Prospect / Harvesting robot / Bodemanalyse', 'geo_1', 12013, 1, 1, 'Equipment slot 1\r\n\r\nJe krijgt van de SL een kaart met een algemene indicatie van waar je mineralen zou kunnen vinden. Je speelt dan uit dat je de bodem gaat onderzoeken op zoek naar mineralen. Op drie plaatsen op de kaart mag je een markering zetten van waar je hebt uitgespeeld dat je hebt gezocht. Je gaat hiermee terug naar de SL en deze kan je vertellen of daar mineralen zitten of niet. Je mag deze handeling zo vaak uitvoeren als je levels in geologie hebt.\r\n\r\nGeologen krijgen op level 1 een harvesting robot. Deze robot heeft 5 â€˜equipmentslotsâ€™ en kan niet gehacked worden. Per niveau geologie kan een geoloog een extra slot benutten. De level 1 equipementslot is altijd een miningdrill.\r\nPer <tijdseenheid> genereert de harvesting robot grondstoffen (rolt op een tabel), die opgehaald moeten worden door de geoloog.'),
(31078, 'Prospect module', 'geo_2', 12013, 2, 1, 'Equipment slot 2\r\n\r\nJe robot kan nu ook prospecten als hij niet aan het minen is. De robot mag alleen in veilig (speler gecontroleerd) gebied gebruikt worden.'),
(31079, 'Secondary robot', 'geo_3', 12013, 3, 1, 'Equipment slot 2\r\n\r\nDe skills van de geoloog zijn zo ver gegroeid dat hij 2 robots kan onderhouden. Let op dat je voor beide robots een keer moet prospecten om ze aan de praat te houden.'),
(31080, 'Knutselaar', 'geo_4', 12013, 4, 1, 'Equipment slot 4\r\n\r\nMet de grondstoffen die qua waarde equivalent zijn aan de grondstoffen die je nodig zou hebben voor Bevoorrading kun je bots en je drilboor zelf onderhouden.'),
(31081, 'Finely tuned bots', 'geo_5', 12013, 5, 1, 'Equipment slot 5\r\n\r\nJe krijgt +10 de generator-rol, zodat catastrofale resultaten onwaarschijnlijker worden.'),
(31082, 'Grondstof extractie / Synthese', 'chem_1', 12014, 1, 1, 'Je kan grondstoffen winnen uit de omgeving (e.g. flora, fauna, erts). De snelheid waarmee je de macromoleculen uit de grondstof kan halen hangt af van je niveau. Je mag maximaal grondstoffen winnen van 1 locatie.\r\n\r\nDoor het combineren van macromoleculen kan de chemist materialen en producten maken.\r\nDe standaard synthese-routes staan in Frontier Boek 2 - Crafting.'),
(31083, 'Analytische chemie', 'chem_2', 12014, 2, 1, 'Door verschillende technieken te gebruiken kan de chemist de grondstof onderzoeken en de totale aantal grondstoffen die in deze grondstof kunnen identificeren. Dit is een destructieve test, informatie voor het vernietigen van deze grondstof - door een klein beetje van een eventuele vondst zo te verbruiken kan je efficiÃ«ntie winnen.'),
(31084, 'Thin Layer Chromatografie (TLC)', 'chem_3', 12014, 3, 1, 'Door het gebruik van dunne laag chromatografie zijn resultaten sneller te behalen en dus op twee locaties grondstoffen te kunnen halen.'),
(31085, 'Zelf-reparerende polymeren', 'chem_4', 12014, 4, 1, 'Door het slimme gebruik van zelf-reparerende polymeren kun je je eigen apparatuur onderhouden. Het equivalent van onderhoud aan grondstoffen (minimaal 20 sonuur) is nodig om deze self-healing polymers te onderhouden.'),
(31086, 'Massa spectrometrie', 'chem_5', 12014, 5, 1, 'Door de exacte massa en gedrag van de macromoleculen te kennen heb je minder risico op catastrophale reactor run-away reacties. Hierdoor krijg je meer grondstoffen bij extractie.'),
(31087, 'Ontmantelen', 'genie_6', 12015, 6, 1, 'Je kan (relatief) veilig bommen en vallen ontmantelen en plaatsen. Indien er geen physrep aanwezig is, zie jij de bom wel.'),
(31088, 'Incendiary Hack', 'genie_7', 12015, 7, 1, 'Je kan een wapen, schildgenerator of mechtool zo saboteren dat het een onstabiel, geÃ¯mproviseerd explosief wordt. Dit kost 10 seconden en moet je daarna gelijk neerleggen of gooien (doe het veilig indien het geen werpwapens zijn). Deze explodeert na vijf seconden met de kracht van een standaard granaat. Het voorwerp wat je gebruikt is onherroepelijk vernietigd.'),
(31089, ' Hobbyist', 'genie_8', 12015, 8, 1, 'Je klust graag bij en spaart regelmatig reserve-onderdelen uit van je ontmantelprojectjes. Je krijgt een gratis granaat per evenement-dag.'),
(31090, 'Fog of War', 'genie_9', 12015, 9, 1, 'Je modificeert een standaard granaat naar een rookgranaat. Deze doet geen schade maar iedereen die is geraakt is 10 seconden blind.'),
(31091, 'Vals Alarm!', 'genie_10', 12015, 10, 1, 'Volgens collegaâ€™s heb jij een engeltje op je schouder - wanneer een explosief of bom waar jij aan werkt af gaat mag je 1 x per dag verklaren dat dit een Vals Alarm was. Het explosief is dan onmiddellijk onschadelijk.'),
(31092, 'Dynamic Combat Shift', 'tacticus_6', 12016, 6, 1, 'Je mag als leider een teamgenoot aantikken die onzichtbaar naar een door jou aangewezen beschutte plek binnen je gezichtsveld mag lopen. 1 x per missie.\r\n'),
(31093, 'Castle on the Kingâ€™s Side', 'tacticus_7', 12016, 7, 1, 'je mag een teamgenoot aantikken die dan van positie wisselt met een door jou aangewezen teamgenoot. Beiden moeten nog mobiel zijn. Ze doen dit met hun hand omhoog en zijn tijdens de wissel onschendbaar. De â€œkoningâ€ is op de heenweg onschendbaar, de â€œtorenâ€ is op de terugweg onschendbaar. 2 x per missie.\r\n'),
(31094, 'Hold The Line', 'tacticus_8', 12016, 8, 1, 'Alle leden van je team kunnen de eerstvolgende granaatinslag die ze incasseren tijdens het gevecht waarin je dit roept voor halve schade tellen en eventuele bijzondere effecten zoals Flash of EMP negeren. Zaken die blijven â€˜hangenâ€™ zoals gas hebben hebben vol effect. 1 x per missie.\r\n\r\n(Definitief) Rapid Deployment - als je er tijdens een missie achterkomt dat een team een vaardigheid, materieel of talent mist in het veld mag je een vrijwilliger naar keuze aanwezig op het Bastion door middel van â€˜Rapid Deploymentâ€™ onmiddellijk naar de missie-zone halen. Deze persoon wordt zo snel mogelijk via shuttle, grav-chute of drop-pod ( speel het leuk uit ) binnen 10 meter van de missie-leider afgeleverd en kan direct aan het werk. Indien deze persoon weigert of niet beschikbaar is faalt deze vaardigheid, maar wordt deze vaardigheid NIET verbruikt.  Dit werkt alleen om iemand in het veld te droppen - 1 x per dag.\r\n'),
(31095, 'To Hell And Back', 'tacticus_9', 12016, 9, 1, 'je hebt je team zo goed op elkaar ingespeeld dat ze zich over hun eigen problemen heen kunnen zetten. Ze mogen elk het eerste mentale effect negeren waardoor ze een lijn zouden breken of de missie in gevaar zouden brengen. Dit dient goed uitgespeelt te worden, en na het gevecht moeten degenen die van deze vaardigheid gebruik hebben gemaakt om een effect te negeren langs de psycholoog of een kapayapaan doen om acute PTSS te voorkomen. 1 x per dag\r\n'),
(31096, 'Last Stand', 'tacticus_10', 12016, 10, 1, 'Door Last Stand uit te roepen mogen allen om je heen die je kunnen zien doorvechten zolang ze mogen kruipen. Normale regels wat betreft doodbloeden blijven van kracht. 1 x per evenement. Onder Dugo staat deze vaardigheid bekend als â€œJust another dayâ€¦â€'),
(31097, 'Suppressing Fire', 'sniper_6', 12017, 6, 1, 'Indien je alle vijanden in je sight hebt gehad, dan mag je aan het einde van de combat 1 HP â€˜genezen.â€™ Dit representeert dat je de vijand neergehaald/onderdrukt hebt, voordat de wond door de vijand gemaakt was. Indien je een spotter bij je hebt, dan krijgt deze ook 1 HP â€˜genezing.'),
(31098, 'Snipers confidence', 'sniper_7', 12017, 7, 1, 'Je kunt je teamleden voor gevechten eraan herinneren dat jij meegaat. Iedereen die jij (en/of je spotter) van tevoren eraan herinnert, mag tijdens het volgende gevecht kruipen (zoals bij wilskracht 1). Indien zij reeds wilskracht 1 hebben, dan mogen ze wegstrompelen (zoals wilskracht 3, maar zonder het verwijderen van de pijnstillers). Indien ze reeds wilskracht 3 hebben, heeft deze skill geen effect.'),
(31099, 'Striking fear in the hearts and minds', 'sniper_8', 12017, 8, 1, 'Indien je alle vijanden in je sight hebt gehad, dan tast je het moraal van de vijand aan. Bij de volgende encounter (ongeacht of jij erbij bent of niet), hebben alle vijanden minus 1 niveau wilskracht. Indien je een spotter hebt, zijn het de eerste 2 encounters.'),
(31100, 'Head shot', 'sniper_9', 12017, 9, 1, '(spotter vereist) 1 keer per evenement, 1 keer per combat mag je een headshot uitvoeren. Jullie kiezen gezamenlijk 1 target. Jij en je spotter tellen gezamenlijk af vanaf 10, indien je de target in je vizier houdt, mag de spotter OC naar de target toelopen en de vijand gelijk op 0 zetten.'),
(31101, 'Double head shot', 'sniper_10', 12017, 10, 1, '(spotter vereist) Je mag nog een keer per evenement, 1 keer per combat een headshot uitvoeren. Jullie kiezen gezamenlijk 1 target. Jij en je spotter tellen gezamenlijk af vanaf 10, indien je de target in je vizier houdt, mag de spotter OC naar de target toelopen en de vijand gelijk op 0 zetten.'),
(31102, 'Point man', 'cqb_6', 12018, 6, 1, 'Indien de voorste persoon van een team deze vaardigheid heeft mag het team tot 3 AP doneren aan deze persoon. Deze AP gaat van andere leden van het team af, en blijven gedurende het gevecht actief op de â€˜point manâ€™. Voor elke extra CQBâ€™er in het team mag er een extra AP worden gedoneert.'),
(31103, 'Planning', 'cqb_7', 12018, 7, 1, 'Met solide planning en een plattegrond van de locatie die je op het punt staat binnen te vallen is iedereen voorbereid en krijgt je hele team 1 AP extra (maximaal 10 personen).'),
(31104, 'Skill cqb 8', 'cqb_8', 12018, 8, 1, 'Tijdens CQB mag je een ballistisch schild gebruiken, van eender welke grote (veilige physrep vereist). Dit schild blokkeert alle normale munitie en slagen, maar een directe granaatinslag vernietigd het schild. Deze granaatinslag doet dan echter geen schade aan de gebruiker.'),
(31105, 'Instinct', 'cqb_9', 12018, 9, 1, '2 x per dag als je tijdens CQB een val af laat gaan (lasermijn bijv) merk je het net op tijd en pak je er maar halve schade van. Als je een ballistisch schild hebt is het niet stuk.'),
(31106, 'Exfiltration', 'cqb_10', 12018, 10, 1, 'Je kan je hele team twee kamers verplaatsen ongeacht hun medische conditie.'),
(31107, 'Ground fighting', 'eskrima_6', 12019, 6, 1, 'Je mag als je op 0 HP staat naast wegkruipen ook je melee wapen nog gebruiken.\r\n'),
(31108, 'Dueling Takedown', 'eskrima_7', 12019, 7, 1, 'Aan het begin van het gevecht werk je je tegenstander op de grond behalve als je tegenstander ook Dueling Takedown heeft (uiteraard overleg je dit van te voren met je tegenstander en speel je het leuk uit - wederom is showmanship belangrijk).'),
(31109, 'Second Wind', 'eskrima_8', 12019, 8, 1, 'Als je tijdens een gevecht tot 0 HP wordt gereduceerd mag je 2 x per dag het gevecht weer terug in stormen met het effect van een stim pack. Dit geldt niet voor je stim-limiet.'),
(31110, 'Dueling Flow', 'eskrima_9', 12019, 9, 1, 'Door precieze plaatsing van slagen doe je tijdens een duel in melee per slag 2 schade. Zeg dit voordat je duel begint aan je tegenstander'),
(31111, 'Gun Kata', 'eskrima_10', 12019, 10, 1, 'Zo lang je een melee-wapen in je hand(en) hebt en je bent in staat jezelf te verdedigen doen kogels maar 1 schade.'),
(31112, 'Operationele flexibiliteit', 'aegis_6', 12020, 6, 1, 'Je mag een beschermende vaardigheid laten gelden zonder dat je daar de juiste AP in schilden of pantsers voor hebt. Van deze vaardigheid vervalt dus de AP vereiste. Zo mag je er voor kiezen om met 4 AP in pantser de Radiation Shield vaardigheid te laten gelden.'),
(31113, '+1 AP, Discrete Field', 'aegis_7', 12020, 7, 1, 'Je veld is zeer subtiel en niet te zien op standaard scans.\r\nPantservaardigheid: Auto-Stabilize - 1x per evenement bloed je niet dood. Dit kost een stimpack.'),
(31114, 'Tactical Source Choice', 'aegis_8', 12020, 8, 1, 'Je mag 1x per dag in het veld je beschermingskeuzes en geldende vaardigheden wijzigen, in plaats van dat dit in een werkplaats met een ingenieur moet. Je moet dit wel kunnen physreppen.'),
(31115, '+1 AP, Krachtveld: Field Expansion', 'aegis_9', 12020, 9, 1, 'Je mag alle bijzondere vaardigheden en bescherming van je shield delen met een ander op aanraking tot een maximale totale HP van 14. Dit kost een extra energy cell. Versteviging: 1 combat per evenement doen kogels 1 schade ipv 2. Dit kost een repairkit en moet geinstalleerd worden door een ingenieur.'),
(31116, '+1 AP, Nano-bots', 'aegis_10', 12020, 10, 1, 'Nano-bots - deze voeren continue auto reparatie uit. 1 x per dag mag je de Aegis naar naar volle werkzaamheid herstellen buiten combat.\r\n'),
(31117, 'Life support', 'powarm_6', 12021, 6, 1, 'Ziektes, giffen en straling worden onderdrukt zolang je in je pantser zit, zodra je eruit gaat, zullen deze alsnog beginnen te werken.'),
(31118, '+1 AP (alleen pantser) Uitgebreid bolwerk', 'powarm_7', 12021, 7, 1, 'Granaten doen standaard halve schade en je bent immuun voor EMP.\r\n'),
(31119, '+1 AP (alleen pantser)', 'powarm_8', 12021, 8, 1, '2 keer per evenement mag je een mass earthquake gooien.'),
(31120, '+1 AP (alleen pantser) Augmented strength', 'powarm_9', 12021, 9, 1, 'Een keer per dag kun je een deur of voorwerp kapotmaken.'),
(31121, '+1 AP (alleen pantser) Complete repair', 'powarm_10', 12021, 10, 1, 'Een keer per evenement repair all armourpoints instantly. Na deze combat ben je door al je power heen en sta je stil. Je kunt herstarten door 2 nieuwe energycellen te gebruiken, uit je pak komen zonder power kost je 10 minuten.'),
(31122, 'Dreigingsanalyse / Redding & Decontaminatie', 'cbrn_6', 12022, 6, 1, 'Je kan veelvoorkomende CBRN bedreigingen detecteren, identificeren en isoleren. Bij zo een type ongeval kan je de schade beperken tot een ruimte of gebied, en dit afzetten op zo een manier dat contaminatie zich niet verspreid. Je kan gegeven tijd en materialen een doeltreffende decontaminatie straat opbouwen waarmee personen zonder risico op verspreiding het getroffen gebied in en uit kunnen. Wanneer de situatie eenmaal is geÃ¯soleerd kun je indien het nog niet bekend is bij de spelleiding vragen wat voor CBRN bedreiging het precies is.\r\n\r\nZolang je het proces begeleid samen met iemand met Gewondenverzorging kun je slachtoffers uit een getroffen gebied halen en direct ontsmetten - dit kost zo veel tijd als een standaard stabilisatie. Hierna zullen ze nog behandeld moeten\r\nworden maar zijn ze stabiel en zullen effecten van CBRN dreigingen zijn verwijdert.'),
(31123, 'Joint Doctrine', 'cbrn_7', 12022, 7, 1, 'Je kennis over gevaarlijke stoffen helpt anderen te beschermen. Onderzoekers, ingenieurs of genie-troepen die bezig zijn met zaken zoals opruimen, ontmantelen of reparen in een CBRN situatie krijgt volledige bescherming tegen de CRBN elementen van die situatie - speel dit bij voorkeur uit met props zoals luchtfilters en pakken. Deze personen hoeven zelf geen CBRN kennis te hebben, en je kan zoveel personen begeleiden als je niveau in deze specialisatie (van 2 mensen vanaf niveau 7 tot 5 mensen op niveau 10). Indien ze zelf geen pakken te hebben, moeten ze jou blijven aanraken.'),
(31124, 'Nah, itâ€™s harmless / Massa-Decontaminatie', 'cbrn_8', 12022, 8, 1, 'Na de nodige blootstelling tijdens training en incidenten heb je het vermogen ontwikkelt om gas en straling langer te weerstaan dan anderen. Zelfs zonder bescherming heb je 1 x per dag het vermogen om 5 minuten in een ruimte met deze zaken normaal te functioneren.\r\n\r\nGoederen, spullen en grondstoffen die zijn geborgen uit een CBRN incident zijn voor jou relatief gemakkelijk te ontsmetten. Ook kan je hiermee wanneer eenmaal een bedreiging is verwijdert uit een gebied dit weer veilig maken voor gebruik. In geval van een ruimte kost het nog een uur na decontaminatie voordat deze weer bruikbaar is, in geval van een buitengebied een weekend.'),
(31125, 'Consequence Management Operations / Dirty bomb', 'cbrn_9', 12022, 9, 1, 'Je kan 1 x per weekend een CBRN ongeluk reconstrueren en traceren naar zijn bron. Dit moet worden uitgespeeld - interviews met getroffenen en experts, opvragen van camera-beelden, onderzoeken van het getroffen gebied, scans en dergelijke zaken. Aan het einde van het proces kan je de spelleiding vragen wat er precies is gebeurd en hoe.\r\n\r\nJe kan een in samenwerking met een ingenieur of genie 1 x per weekend een bom of explosief voorzien van een CBRN element. Doe dit in overleg met de spelleiding.'),
(31126, ' COLPRO (Collective Protection)', 'cbrn_10', 12022, 10, 1, 'Tijdens een onverwachte crisis kan snel ingrijpen om de veiligheid te garanderen. Je benut bekende elementen in ICC-constructie zoals overdruk, luchtfilters, krachtvelden en andere slimmigheden om de bedreiging buiten te houden - je bent 1 x per dag in staat om een vertrek, gebouw of ander complex van ruimtes voor een periode te vrijwaren van CBRN elementen.\r\n\r\nHet is wel belangrijk dat je hulp hebt - je kan zelf een ruimte vrijwaren, maar voor elke extra ruimte heb je een persoon nodig die je instructies kan gevenâ€¦ en die er op let dat niemand per ongeluk een raampje open zet - deze personen hoeven zelf niet de CBRN vaardigheid te bezitten zolang ze met jou kunnen communiceren ( porto, briefjes, hard schreeuwenâ€¦). Je improvisatie houdt het minstens een uur uit, maar het is wel zaak om een permanente oplossing te vinden of te evacueren.'),
(31127, 'Walk it off, pussy', 'psyops_6', 12023, 6, 1, 'Met een ferm, motiverend gesprek met iemand halveer je de hersteltijd na operaties van die persoon. Dit effect stackt met andere vaardigheden die hersteltijd beÃ¯nvloeden.'),
(31128, 'Snap out of it', 'psyops_7', 12023, 7, 1, 'Je kan door 10 seconden tegen iemand te praten een lopende Telepsychische kracht verbreken wanneer je Wilskracht gelijk of hoger is aan het niveau van de kracht.'),
(31129, 'Bliksemafleider', 'psyops_8', 12023, 8, 1, 'Je absorbeert een telepsychische kracht die iemand in de buurt incasseert (praatafstand). Je kan deze weerstaan of doorlaten op de gebruikelijke wijze.\r\n'),
(31130, 'Battle Mind', 'psyops_9', 12023, 9, 1, 'De personen die je aanraakt tijdens een gevecht geef je jouw niveau aan Wilskracht. Je kan al je vaardigheden nog gebruiken. Zodra je loslaat vervalt je bescherming.'),
(31131, 'Be careful out there', 'psyops_10', 12023, 10, 1, '(1 x per dag)\r\nNa een briefing of speech geef je alle toehoorders 1 extra Wilskracht die dag.'),
(31132, 'Stigmata', 'synerg_6', 12024, 6, 1, 'Voor zowel jezelf als voor anderen die je aanraakt mag je je eigen HP omzetten naar een telepsychische kracht - dit omzeilt de restrictie dat een kracht maar een beperkt aantal maal per dagdeel mag worden gebruikt. De wonden die dit oplevert zijn extatische pijn en onderbreken daarmee je eventuele eigen krachten niet. Je kan er wel door sterven als je te veel van jezelf geeft.'),
(31133, 'Missionaris', 'synerg_7', 12024, 7, 1, 'Normaal mogen mensen slechts eenmaal een ceremonie per evenement meedoen maar als jij meedoet met de ceremonie mogen mensen die al eerder aan een ceremonie mee hebben gedaan nogmaals meedoen.'),
(31134, 'Catalyst', 'synerg_8', 12024, 8, 1, 'Door twee beoefenaars van Telepsychica aan te raken stel je hen in staat om energie en Telepsychica vaardigheden uit te wisselen voor een door hun bepaalde periode van maximaal 12 uur. Hiermee kunnen zelfs Ekanesh van verschillende scholen krachten van elkaar â€˜lenenâ€™. Dit kan een Synergist 2x per dag'),
(31135, 'Conversie', 'synerg_9', 12024, 9, 1, 'Je bent in beperkte mate in staat om elektriciteit te converteren naar Telepsychische kracht. Voor 3 Energy Cells kun je een extra gebruik van een 1-5 kracht\r\ngenereren, en voor 9 Energy Cells kun je een 6-10 kracht een extra gebruik per dag geven.\r\nJe kan maximaal 30 Energy Cells per dag converteren voor je lichaam niet meer kan verdragen. Deze mag je deze extra kracht met aanraking ook direct aan anderen geven.'),
(31136, 'Breinbreker', 'synerg_10', 12024, 10, 1, 'Door al je krachten te bundelen met een Telepsychica gebruiker (dit mag niet jezelf zijn) ben je 1 x per dag in staat een Telepsychische vaardigheid door elke vorm van verdediging heen te slaan. Dit vereist aanraking. Dit eist echter zijn tol op de Synergist - de rest van de dag geld je effectieve Wilskracht als 0 door extreme mentale vermoeidheid.\r\nJe mag je vaardigheden nog wel gebruiken.'),
(31137, 'Psychometrie', 'onverz_6', 12025, 6, 1, 'Detectie / aanvoelen van het gebruik van telepsychische krachten in de nabije omgeving, kan in de morgen een call bij de spelleiding over worden gehaald.'),
(31138, 'Zelfvertrouwen', 'onverz_7', 12025, 7, 1, 'Als je Wilskracht een telepsychische kracht blokkeert heb je de rest van het gevecht geen last meer van die kracht, zelfs als deze boven je niveau wordt gebruikt.\r\n'),
(31139, 'Onschuldig aura', 'onverz_8', 12025, 8, 1, 'Door mentale controle ben je in staat om te doen alsof je minder sterk bent in het verzetten van mentale krachten dan je bent. Je kan hier mee doen alsof je bent beÃ¯nvloed door een power zonder dat je er last van hebt. Hoe lang je doel het gelooft ligt aan je uitspeelvermogen, maar het kan precies genoeg zijn om dicht te naderen tot je doel...'),
(31140, 'Twijfel', 'onverz_9', 12025, 9, 1, 'Als je iemand dempt duurt het tot het einde van het gevecht voordat die persoon Telepsychische vaardigheden boven 5 mag aanwenden.\r\n'),
(31141, 'Mentaal Fort', 'onverz_10', 12025, 10, 1, 'Je kan 10 x in een weekend een niveau 5 effect of lager compleet negeren ongeacht de het niveau van de beoefenaar.'),
(31142, 'Ik kan het hebben', 'ijzvreter_6', 12026, 6, 1, '+1 HP, +1 minuut doodbloeden'),
(31143, 'Aan mijn lijf geen polonaise', 'ijzvreter_7', 12026, 7, 1, 'Uiteenlopend van natuurlijke omgevingen zoals zinderende woestijnen of jungles gevuld met giftige diersoorten tot door straling schoongeveegde industriecomplexen, niets krijgt de overlever klein. Immuun voor giffen, slaapgebrek en uitdroging. +1 minuut doodbloeden'),
(31144, 'Ik kan meer hebben', 'ijzvreter_8', 12026, 8, 1, '+1 HP, +1 minuut doodbloeden'),
(31145, 'Hyper-effectieve lever', 'ijzvreter_9', 12026, 9, 1, '+1 minuut doodbloeden. Je hebt een orgaan dat continue je hele systeem schoonspoelt en kan effectief niet meer overdosen op stimms. Het nadeel is dat je ook heel moeilijk dronken wordt.'),
(31146, 'Controlled autonomic nervous system', 'ijzvreter_10', 12026, 10, 1, 'Tenzij je het wil hebben warmte, kou, straling en ziektes en soortgelijke condities geen effect meer op je behalve in de meest extreme vormen. +1 HP, +1 minuut doodbloeden.'),
(31147, 'Repareerbaar', 'cyborg_6', 12027, 6, 1, 'Verwondingen op je ledematen kunnen naast worden genezen ook worden gerepareerd - bloed kan worden vervangen door repair kits.'),
(31148, 'Cyber-web', 'cyborg_7', 12027, 7, 1, 'Je vervangt je torso door een cyber-organisch web waar je organen in functioneren. In dit web kan je een mod installeren. Dit is een definitieve stap weg van de menselijke norm en stims hebben geen effect meer op je. Repair kits werken vanaf dat moment op je als stimms.');
INSERT INTO `ecc_skills_allskills` (`skill_id`, `label`, `skill_index`, `parent`, `level`, `version`, `description`) VALUES
(31149, 'Craniale her-configuratie', 'cyborg_8', 12027, 8, 1, 'Je laat je brein verplaatsen naar je torso en vervangt je hoofd door een plasteel replica. In dit hoofd kan je nog een extra mod plaatsen. Je bloed niet meer dood maar verbruikt 1 extra energiecel per dag - als je die niet hebt verlies je het voordeel van je hoofd-modificatie. Je kan nog wel doelbewust worden vernietigd door je te blijven beschadigen (vijf klappen of kogels nadat je op 0 bent of equivalente schade).'),
(31150, 'Synth-Skin Pantser', 'cyborg_9', 12027, 9, 1, 'Je hebt geen HP meer, alleen nog maar AP. Je krijgt 6 AP om mee te beginnen en bent volledig repareerbaar. Dit stackt met alle andere vormen van pantser en\r\nkrachtvelden tot het gebruikelijke maximum. Tasers doen 2 AP schade - als dit je laatste AP zijn dan heeft een taser het gebruikelijke effect op je.'),
(31151, 'Transhumanisme', 'cyborg_10', 12027, 10, 1, 'Je hebt een livelink backup van je brein. Mocht je komen te overlijden kan je terugkomen als een androide of kloon van jezelf. Je herinnert je dood en weet dat je nieuwe lichaam het nog twee evenementen volhoudt. Daarna is de data gecorrumpeerd en ben je effectief overleden.'),
(31152, 'Balance / Vliegbrevet', 'dex_1', 12028, 1, 1, 'Als een effect je tegen de grond zou werpen kan je effect negeren. Je staat dan gewoon 2 seconden onwennig terwijl je je evenwicht behoud, maar je hoeft niet op de grond gaan liggen.\r\n\r\nJe mag vliegen in non-combat vliegtuigen. Zie dit als het autorijbewijs van de toekomst.'),
(31153, 'Bodyguard', 'dex_2', 12028, 2, 1, 'Voor een gevecht stel je iemand aan die je wilt beschermen. Je blijft bij deze persoon tijdens een gevecht. Na een gevecht mag je 1 klap of schot overnemen van die persoon.'),
(31154, 'Melee ambidex / Onbedwingbaar', 'dex_3', 12028, 3, 1, 'Je mag in elke hand een eenhandig melee wapen gebruiken (mits je de melee wapens kunt gebruiken, zie melee).\r\n\r\nJe bent zo behendig dat je niet door een persoon in bedwang kan worden gehouden. Er zijn 2 of meerdere personen hier voor nodig. Als 1 persoon je probeert te bedwingen, geef even subtiel aan dat je deze techniek hebt.'),
(31155, 'Melee/pistool ambidex', 'dex_4', 12028, 4, 1, 'Je mag een eenhandig melee wapen en een pistool gebruiken (mits je deze wapens kunt gebruiken, zie melee & ballistiek).'),
(31156, 'Pistool&pistool ambidex / Boeienkoning', 'dex_5', 12028, 5, 1, 'Je mag in elke hand een semi-automatisch pistool gebruiken.\r\n\r\nJe bent zo lenig in je handen en voeten dat je jezelf kan ontdoen van enige boeien. Je kan je 1 keer per evenement je ontdoen van je boeien (handboeien, touw, tape, tiewraps, eender welke)'),
(31157, 'Concealed goods', 'infiltr_6', 12029, 6, 1, 'Je mag een pakketje ter grootte 10 bij 10 bij 10 centimeter op je persoon verstoppen en deze kan niet gevonden worden. Dit pakketje mag geen actieve acties uitvoeren zoals scannen, energie absorberen of uitzenden, aftellen naar een onvermijdelijke explosie of dergelijke zaken - anders wordt het alsnog gevonden.'),
(31158, 'Concealed weapon', 'infiltr_7', 12029, 7, 1, 'Je mag een combinatie van 2 pistolen, dolken, of tasers aanwijzen als â€˜verstoptâ€˜ als een concealed en deze kunnen niet gevonden worden. Dit moet je wel physreppen.'),
(31159, 'Hyper-flexible', 'infiltr_8', 12029, 8, 1, '1 keer per evenement mag je uit een kamer ontsnappen, waar je tegen je wil wordt gehouden. Niemand snapt hoe je eruit gekomen bent, soms jijzelf niet eens, maar je mag niemand meenemen. (indien je deze skill gebruikt, ga je samen met een SL een cool verhaal verzinnen hoe het je gelukt is)'),
(31160, 'False Identity', 'infiltr_9', 12029, 9, 1, 'Een keer evenement mag je voor jezelf of voor een ander een valse identiteit aan laten maken. Het niveau van de identiteit is afhankelijk hoeveel geld je er aan uit geeft. (50 sonuren per level)'),
(31161, 'The Great Escape', 'infiltr_10', 12029, 10, 1, '1 keer per evenement mag je samen met een groep uit een gevangenis ontsnappen. Kan niet gebruikt worden als de bewaker in de kamer staat. (indien je deze skill gebruikt, ga je samen met een SL een cool verhaal verzinnen hoe het je gelukt is)'),
(31162, 'Dynamic Entry', 'pilot_6', 12030, 6, 1, 'Je bent getraind om landingen uit te voeren terwijl je onder vuur ligt. Zelfs al wordt je beschoten kunnen al je passagiers veilig uitstijgen.'),
(31163, 'Lights out', 'pilot_7', 12030, 7, 1, 'Je gooit alle onnodige systemen in je schip uit bij de landing en komt aan zonder dat je gehoord of gedetecteerd kunt worden'),
(31164, 'In the spaghetti', 'pilot_8', 12030, 8, 1, 'Indien je jager of shuttle neergeschoten wordt, kun je samen met ingenieurs je shuttle provisorisch repareren om alsnog thuis te komen.'),
(31165, 'Any landing you can walk away fromâ€¦', 'pilot_9', 12030, 9, 1, 'Mocht je bewust of onverhoopt neerstorten kan je je voertuig opofferen om er voor te zorgen dat je passagiers en jij er met louter wat builen en schrammen van weg lopen.'),
(31166, 'They came from behind', 'pilot_10', 12030, 10, 1, 'Tijdens een lucht- of ruimtegevecht mag je 3x per weekend verklaren dat je ineens achter een vijand opduikt en neerschiet zonder dat deze Ã¼berhaupt door had dat je er was.'),
(31167, 'Operatie certificaat', 'portal_6', 12031, 6, 1, 'De speler weet hoe het portaal moet worden gestart en herstart, en hoe deze gedeactiveerd kan worden zonder permanente schade. Daarnaast kan de technicus de protocollen voor het zenden en ontvangen van mensen en objecten door het portaal uitvoeren. De portaal technicus kan twee keer per evenement door een briefing ook een ander persoon instructie geven om het portaal te bedienen.'),
(31168, 'Storing Specialist', 'portal_7', 12031, 7, 1, 'Met behulp van een diagnostic tool en je eigen kennis kan je binnen 10 minuten 1 probleem/storing met het portaal achterhalen. Tevens kan je X aantal andere ingenieurs (lees de niet-specialisten Portaal tech. lvl6 = 1 ingenieur, lvl8 = 2 ingenieurs) aanstellen om je te helpen met het oplossen van dit probleem - zolang jij aanwezig bent en helpt met het oplossen er van. De tijd en materialen die het kost om het probleem op te lossen is afhankelijk van de maximale ingenieur vaardigheden aanwezig en de moeilijkheidsgraad aangegeven door de spelleiding.'),
(31169, 'Virtual Quantum Entanglement', 'portal_8', 12031, 8, 1, 'Je kan een portaal verbinden met andere portalen binnen bereik door het portaalkristal te omzeilen en een andere handtekening te simuleren. Raadpleeg een spelleider.'),
(31170, 'Skill portal 9', 'portal_9', 12031, 9, 1, '1x per dag, is het mogelijk om een pakket materiaal met een maximale diameter van 1 meter te â€˜taggenâ€™. Deze teleporteert onmiddellijk naar de â€˜thuisâ€™-portaalruimte van de Portaaltechnicus.'),
(31171, 'Emergency extraction', 'portal_10', 12031, 10, 1, '1 x per dag is het mogelijk om een groep personen in een cirkel van 3 meter rond een â€˜recall deviceâ€™ terug te teleporteren naar de â€˜thuisâ€™-portaalruimte van de Portaaltechnicus. Dit recall device hoeft niet door de Portaaltechnicus te worden bedient en kan ook worden overgedragen aan een andere Ingenieur voor de duur van 1 missie.'),
(31172, 'Salvage expert', 'geotech_6', 12032, 6, 1, 'Als je recycled krijg je alle grondstoffen minus 1 naar keuze terug. (normaal verlies je 2 grondstoffen met salvagen) Je kan er ook voor kiezen om een specifiek onderdeel te bergen uit een apparaat echter krijg je dan minder grondstoffen maar wel de grondstof of het functionele apparaat dat je wil hebben.'),
(31173, 'Veldwerk', 'geotech_7', 12032, 7, 1, 'dit stelt je 1 x per dag in staat om â€œon the spotâ€ (vaste plaats diameter 5 meter) een technische oplossing te improviseren. Je zal daar Energy Cells en grondstoffen aan moeten spenderen. Elke Ingenieur kan je hier bij helpen maar alleen iemand met deze vaardigheid kan dit initiÃ«ren en zal het moeten leiden. Bij specifieke gevallen kunnen ook andere experts je helpen maar dat is afhankelijk van het spel. Deze improvisaties zijn meestal tijdelijk en notoire instabiel. Als je er ambitieus bent en er fouten worden gemaakt zou dit best eens kunnen ontploffen in je gezicht. Het is aan de spelleiding om te bepalen of het beoogde effect wordt behaald.'),
(31174, 'Nanite Hack (De-)Construction', 'geotech_8', 12032, 8, 1, 'Door je eigen speciale nanites toe toe voegen aan een minifactorum zoals een schip of een basis heeft mag je 3 keer per dag een level 1-5 engineering skill instant laten gebeuren zolang je de materialen hebt. There are many like it but this one is mine - door het type werk wat je doet heb je je uitrusting gespecialiseerd en gemodificeerd om beter te kunnen functioneren. Kies een onderdeel van je uitrusting je mag het effect van dit stuk uitrusting verbeteren of een ander effect er aan toevoegen hoe heftig het effect mag zijn hangt van je totale engineering level af. Dit kan alleen in overleg met een SL en alleen tussen de evenementen. Het is niet mogelijk om tijdens een event dit aan te passen.'),
(31175, 'Reverse engineering', 'geotech_9', 12032, 9, 1, 'Je mag 1 keer per event een extra bijdrage leveren aan een actief research project (moet wel passen bij ingenieur). Deze skill stelt je ook in staat om te leren van recyclen, hoe vaker je een apparaat uit elkaar haalt de meer je er van weet. Je kan eventueel nieuwe blauwdrukken leren van recyling - het is aan de SL om te bepalen hoe vaak je apparaat gesloopt moet hebben voor dat je die kennis hebt.'),
(31176, 'Planetary Engineering', 'geotech_10', 12032, 10, 1, 'Je hebt toegang tot kennis en blauwdrukken voor grootschalige projecten. Voor de helft van de budgetsonuren aan waarde en een plausibele oplossing zoals bijvoorbeeld een salvage permit op een basis of scheepswrak mag je op een evenement een upgrade aan het Bastion bouwen van de kolonie-goederen lijst. Hier ga je wel een team nodig hebben met een gecombineerd niveau aan Ingenieur (alleen de basisvaardigheid, geen specialisaties meegeteld) gelijk aan de waarde van het koloniegoed gedeeld door 500. Zo zou je in een weekend een nieuwe shuttle kunnen bouwen met 10 niveauâ€™s aan ingenieurs. En natuurlijk, hoe ambitieuzer het project des te groter de kans op complicatiesâ€¦'),
(31177, 'Double Sip', 'stimm_6', 12033, 6, 1, 'Als je stimms toedient kun je per stimm 2 personen stimmen. Je kunt een stimm niet 2 keer op 1 persoon gebruiken, maar door de stimm precies af te meten wel op 2 verschillende personen.'),
(31178, 'Precise Dosage', 'stimm_7', 12033, 7, 1, 'Je kan iemand 1 stimm per dag toedienen zonder dat deze meetelt voor zijn of haar stimm limiet. Dit werkt zelfs als iemand een overdosis heeft al moet dat nog wel worden behandeld.'),
(31179, 'Thatâ€™s the stufffâ€¦', 'stimm_8', 12033, 8, 1, 'Je expertise op het gebied van toediening zorgt voor sterk toegenomen efficiÃ«ntie, en Stimms helpen nu het lichaam mee in plaats van dat het een opdonder krijgt. Stimms geven nu 3 HP terug in plaats van de gebruikelijke 2 HP.'),
(31180, 'Reset Limit', 'stimm_9', 12033, 9, 1, 'Je mag 1 keer per dag bij iemand anders de stimm counter weer op 0 zetten. (dit geneest een overdosis volledig)'),
(31181, 'Anabole steroide', 'stimm_10', 12033, 10, 1, 'Je mag per persoon per combat 1 stimm van tevoren inbrengen. Deze stimm activeert zodra nodig tijdens dit gevecht. Deze stimm telt dubbel voor zijn/haar limiet en is verbruikt.'),
(31182, 'On Ice', 'medevac_6', 12034, 6, 1, 'Je kunt op 2 personen tegelijkertijd â€œdont you die on meâ€ gebruiken.'),
(31183, 'Pre-Op Triage', 'medevac_7', 12034, 7, 1, 'Operaties die op jouw patienten worden uitgevoerd, kosten ipv 1 uur hersteltijd, slechts een half uur. Dit stackt met soortgelijke vaardigheden.'),
(31184, 'Donâ€™t you die on me, really!', 'medevac_8', 12034, 8, 1, 'Je kunt mensen in leven houden die door ziekte, giffen, radiatie aan het sterven zijn. Zodra jij deze persoon niet meer verzorgt, begint de sterftijd weer te lopen.'),
(31185, 'Hunker down', 'medevac_9', 12034, 9, 1, 'Terwijl je aan het genezen bent, kun je 2 kogels negeren. Deze skill reset aan het einde van een combat.'),
(31186, 'Veldhospitaal', 'medevac_10', 12034, 10, 1, 'Je kunt 1 keer per evenement 20 vierkante meter prepareren (alleen 30 minuten preparatietijd minus 5 minuten per willekeurige helper). Binnen deze plek kan iedereen hun geneeskunde skills gebruiken en jij telt hier binnen als level 4 geneeskunde. Dit betekent dat je binnen dit veldhospitaal kunt opereren. Zodra je het veldhospitaal verlaat, verdwijnt het veldhospitaal.'),
(31187, 'Als het scherp is, is het een mes', 'traumsurg_6', 12035, 6, 1, 'Je kunt met geÃ¯mproviseerde middelen adequate medische zorg verlenen. Zelfs zonder je medische instrumenten kan 2x per dag iemand stabiliseren met behulp van gescheurde kleding als verbanden, een werpmes als scalpel en een rietje als adembuis.'),
(31188, 'Fuck it, weâ€™ll do it live', 'traumsurg_7', 12035, 7, 1, 'Je kan aan een operatie beginnen voordat een patient stabiel is - je stabiliseert een patiÃ«nt terwijl je ze voor de operatie prept. Zo lang je opereert overlijden ze niet, al gaat de teller weer lopen mocht je onverhoopt worden onderbroken. -1 minuut opereren, -1 bloedzak'),
(31189, ' It is all about the blood', 'traumsurg_8', 12035, 8, 1, '3x per dag weet je door middel van een snelle test gelijk of het bloed vrij is van ziektes, modificaties, antistoffen en giffen. Als het niet zo is mag je het bloed direct zuiveren voor infusie. -2 minuten opereren, -2 bloedzakken.'),
(31190, 'Auto-infusie', 'traumsurg_9', 12035, 9, 1, 'Je kan voor 2 operaties per dag alle bloedzakken uitsparen door verloren bloed van de patiÃ«nt te gebruiken als infusie. -3 minuten opereren, -3 bloedzakken.'),
(31191, 'Xeno-operaties', 'traumsurg_10', 12035, 10, 1, 'Je kan zelfs dingen opereren die de menselijke anatomie benaderen in zeer brede zin. Dieren, buitenaardse wezens, Stalkers, het is een pot nat. Met een combinatie van verkennende chirurgie en improvisatievermogen kun je 1 keer per weekend een niet-menselijk wezen succesvol opereren.'),
(31192, 'Pathaloog-Anatoom', 'forensi_6', 12036, 6, 1, 'Na onderzoek aan een lijk mag je bij de overlord of SL navragen hoe iemand gestorven is. Ook ben je in staat om overledenen respectvol op te baren voor bijvoorbeeld begrafenis of transport naar huis.'),
(31193, 'Virale Propagatie', 'forensi_7', 12036, 7, 1, 'Je kan door analyse van hoe bacteriÃ«n, virussen en fungi zich hebben gepropageerd door het lichaam de precieze tijd van overlijden vaststellen. Als het lichaam niet is verplaatst weet je ook de precieze omstandigheden van de doodsoorzaak.'),
(31194, 'Analyse van Bloedspatten', 'forensi_8', 12036, 8, 1, 'Je kunt achterhalen of het lichaam/de lichamen verplaatst zijn en een ruwe beschrijving van een eventuele dader of daders. Als er lichamen en wapens ontbreken weet jij dit ook, en wat voor wapens er zijn gebruikt.'),
(31195, 'Forensische Anthropologie', 'forensi_9', 12036, 9, 1, 'Normaal heb je een lichaam nodig je onderzoek te mogen doen, maar nu heb je ook voldoende kennis om al je analyses van 6-8 te mogen doen op botten en botresten.'),
(31196, 'Vergelijkende Anatomie', 'forensi_10', 12036, 10, 1, 'Je mag al je analyses uitvoeren op niet-menselijke wezens. Je ontdekt ook wat eventuele bijzondere kwetsbaarheden, allergieÃ«n en zwakheden buitenaardse wezens hebben.'),
(31197, 'Mairâ€™s Confession', 'spirit_6', 12037, 6, 1, '(Zelf) (voor het evenement)\r\n\r\nDe eerste stap van de spiritualist is je ziel zuiveren en gezuiverd houden. Met deze vaardigheid krijg je van Mair te horen hoe je je ziel kunt zuiveren. Vaak zal Mair je ook hints geven naar het pad waar Mair je op wil zien lopen.'),
(31198, 'Mairâ€™s Bond', 'spirit_7', 12037, 7, 1, '(Zelf) (1x per dagdeel)\r\n\r\nDoor je volledig af te zonderen en in diepe meditatie te gaan, creeer je een connectie met Mairs spiritualiteit. Als je schade krijgt in deze trance, dan krijg je een enorme klap: Tot de volgende maaltijd krijg je een geestesziekte naar je eigen keuze om uit te spelen.\r\nIn deze trance kun je naar Mair toegaan (aka naar de overlord lopen/mailen) en hem een ja/nee/onbekend vraag stellen. Indien je een onbekend krijgt, dan zal Mair je later een ja nee antwoord geven. De overlord meld het medium. Indien je in het veld staat en er is een SL vrij, dan kun je het aan hem/haar vragen. \r\nDeze power werkt als de Ekanesh Power, maar dan met een zekere kans dat je direct antwoord krijgt.'),
(31199, 'Mairâ€™s Exorcism', 'spirit_8', 12037, 8, 1, '(Aandachts- & Stembereik) (Ceremonie) (1x per dag)\r\n\r\nJe kunt per priester die er mee doet aan de ceremonie bij iemand krachten weghalen die zijn geest beinvloeden. Deze persoon moet aanwezig zijn bij de ceremonie, maar hoeft niet vrijwillig te zijn. Sommige hele sterke krachten kunnen alleen worden weggehaald met de samenwerking van meerdere priesters.'),
(31200, 'Mairâ€™s Miracle', 'spirit_9', 12037, 9, 1, '(Aanraak) (1x per dag)\r\n\r\nDoor iemand mee te nemen en deze persoon begeleid met meditatie, kun je lichamelijke wonderen verrichten: Sowieso zijn de volgende dingen mogelijk:\r\nâ— Een blinde kun je permanent weer laten zien.\r\nâ— Een lamme kun je permanent weer laten lopen,\r\nâ— Biotech kan je vervangen door weer normaal werkende lichaamsdelen (biotech wordt geabsorbeerd)\r\nâ— Sterfelijkheid door ouderdom kan worden uitgesteld (voor anderen, niet voor jezelf).\r\nAls je andere lichamelijke wonderen kunt bedenken, neem ze even door met de hoofd SL, dan updaten we deze lijst.'),
(31201, 'Mairâ€™s Divine Purpose', 'spirit_10', 12037, 10, 1, '(Zelf) (1x per evenement)\r\n\r\nElk evenement mag je in overleg met de (enige echte) Mair (Hoofd SL). Je mag dan samen met haar de doelen van Mair voor deze keer doornemen. Zelf mag je suggesties inbrengen, maar Mair (hoofd SL) heeft VETO-recht. Dit doe doe je sâ€™nachts in je slaap als je over Mair droomt.'),
(31202, 'Mairâ€™s Shield', 'waker_6', 12038, 6, 1, '(Zelf) (1x per dagdeel)\r\n\r\nJe hebt een psychisch schild om je heen van 5 AP. Deze houdt de eerste vijf schade tegen. Het stackt niet met andere schilden, maar wel met harnas tot max 10 QP. Mairâ€™s Shield blijft actief tot het is vernietigd, of de volgende zonsopkomst.'),
(31203, 'Mairâ€™s Riddance', 'waker_7', 12038, 7, 1, '(Aandachts- & Stembereik) (1x per gevecht)\r\n\r\nVerwijder een Telepsychische aanval van jou niveau of lager van jezelf of een ander.\r\n(Term: Verwijder!)'),
(31204, 'Mairâ€™s Protect the Flock', 'waker_8', 12038, 8, 1, '(Aandachts- & Stembereik) (Ceremonie) (1x per dag)\r\n\r\nDeze power werkt als Mairâ€™s Hand, maar dan als Ceremonietechniek.'),
(31205, '9 Mairâ€™s Travel', 'waker_9', 12038, 9, 1, '(Aanraak) (1x per gevecht)\r\n\r\nJe mag jezelf en maximaal 1 iemand anders waarmee jij een band hebt verplaatsen naar een persoon die je kent binnen 1 km. Je mag je hand opsteken en naar deze persoon toelopen. Daar aangekomen doe gaat je hand weer omlaag en verschijn je. Voordat je deze power wilt gebruiken, geef je de spelleiding 1 uur waarschuwing zodat ze voorbereidingen kunnen treffen.'),
(31206, 'Mairâ€™s Redirection', 'waker_10', 12038, 10, 1, '(Aanraak) (1x per gevecht)\r\n\r\nJe kunt door iemand aan te raken alle negatieve effecten van deze persoon veplaatsen. Alle schade en negatieve effecten die deze persoon had gaat naar een ander vrijwillig persoon.\r\n(Term: Verplaats-effect!)'),
(31207, 'Mairâ€™s Cure', 'evangel_6', 12039, 6, 1, ' (Aandachts- & Stembereik) (1x per dagdeel)\r\n\r\nJe kunt als je aanwezig bent in een veld-ziekenhuis of een ander medisch centrum een groep mensen tegelijk helpen. Je mag 1 operatiekamer tegelijkertijd helpen. Iedereen die aanwezig is en effect van deze kracht heeft moet je kunnen horen. Als de personen bloedzakken krijgen dan maakt het niet uit welke bloedzakken er gebruikt worden, alle bloedzakken kunnen op iedereen gebruikt worden, dit heeft geen negatieve effecten voor de patient. Dit kun je maximaal 1 keer doen per dokter.'),
(31208, 'Mairâ€™s Double Clamp', 'evangel_7', 12039, 7, 1, '(Aandachts- & Stembereik) (1x per gevecht)\r\n\r\nZodra je de aandacht van iemand hebt en tegen hem blijft spreken staat die persoon vastgenageld aan de grond. De persoon kan alles behalve zijn voeten bewegen: Schieten, vechten, ontwijken (voorzover mogelijk met zijn voeten aan de grond) is allemaal mogelijk. Vervolgens mag je je naar iemand anders draaien en ook hem op dezelfde wijze vastnagelen aan de grond.\r\n(Term: Stilstaan!!)'),
(31209, 'Mairâ€™s Emotion', 'evangel_8', 12039, 8, 1, '(Aandachts- & Stembereik) (Ceremonie) (1x per dag)\r\n\r\nTijdens een mis kun je iedere aanwezigen een overdaad geven van een emotie die jij kiest. Geef dit voor het evenement aan bij de SL want deze kunnen dan â€˜pre-reffenâ€™ wat voor effecten er aan zitten, die jij dan zelf door mag geven. Natuurlijk moet alles binnen de comfort-zone blijven van de deelnemers.'),
(31210, 'Mairâ€™s Dream', 'evangel_9', 12039, 9, 1, '(1 Persoon) (1x per dag)\r\n\r\nJe kunt s nachts iemand in zijn dromen bezoeken en op deze manier met hem praten. Dit kan met iemand van wie je de naam weet of een goede beschrijving van hebt. Ook kun je in deze droom een klein ongevaarlijk object achterlaten of meenemen. Dit object moet in iemand zijn hand passen en in het bezit zijn van een van jullie. In tegenstelling tot het bericht, wat alleen in iemand zijn droom plaats vind, word het object daadwerkelijk getransporteerd.\r\n(OC kan dit via de mail, indien de persoon zich in de kernwerelden bevindt)'),
(31211, 'Mairâ€™s Choosen', 'evangel_10', 12039, 10, 1, '(aanraak) (1x per gevecht)\r\n\r\nJe kunt iemand anders aangeven als Mairâ€™s Choosen je begint een preek waarom jij vind dat deze persoon de Choosen is van Mair en hierdoor zal deze persoon krachten krijgen van Mair. De lijst van krachten waaruit je kunt kiezen zal hier onder komen te staan wanneer dit overlegd is door de SLâ€™s.'),
(31212, 'Mairâ€™s Reflect', 'strijd_6', 12040, 6, 1, '(Zelf) (1x per gevecht)\r\n\r\nJe kunt een TP kracht van iemand terugkaatsen zonder er zelf er last van te hebben. Jou level van TP moet hoger op gelijk zijn aan dat van de ander. (Term: Reflecteer!). De eerste keer dat je een TP kracht tegenkomt reflecteer je hem niet, maar krijg je de mogelijkheid om de spreuk te onderzoeken.'),
(31213, 'Mairâ€™s Vessel', 'strijd_7', 12040, 7, 1, '(Zelf) (1x per gevecht)\r\n\r\nJe kunt er voor kiezen om je levenskracht zo te versterken dat je op het maximum van 10 HP komt te staan voor de duur van een gevecht. Als het gevecht voorbij is sta je op 0 HP..'),
(31214, 'MaÃ¯râ€™s Embrace', 'strijd_8', 12040, 8, 1, '(Aandachts- & Stembereik) (1x per gevecht)\r\n\r\nÃ‰Ã©n persoon op waar je tegen praat, word vast gegrepen door een onzichtbare beknellende greep. Hij kan zich zolang je praat niet bewegen, als er schade gedaan wordt, blijft de persoon verstijfd.\r\n(Term: Bevries!)'),
(31215, 'Mairâ€™s Purge', 'strijd_9', 12040, 9, 1, '(Aanraak) (1x per dagdeel)\r\n\r\nJe onttrekt alle bij-effecten van stims uit iemand zijn lichaam. Het telt voor deze persoon alsof hij deze dag nog geen stims heeft ontvangen. Deze power werkt maar een keer per evenement per persoon.'),
(31216, 'Mairâ€™s Smite', 'strijd_10', 12040, 10, 1, '(Aandachts- & Stembereik) (1x per gevecht)\r\n\r\nJe kunt een kort gebed aangaan waarbij je een persoon die je kan zien kan overpoweren met de kracht van Mair. In het geval van een NPC gaat deze in een keer neer en is aan het doodbloeden. Als je deze power gebruikt op een medespeler, overleg dan met deze speler wat leuk spel is en wat er gebeurt.\r\n(Term: KETTER!)'),
(31217, 'Mairâ€™s Power', 'newage_6', 12041, 6, 1, '(Aanraak) (onbeperkt bruikbaar)\r\n\r\nJe kunt een electrisch aparaat aanraken en daardoor voorzien van energie. Dit extreem pijnlijk voor jou. Deze power telt niet voor krachtveldgeneratoren. Per 5 minuten dat je deze power gebruikt krijg je 1 punt schade.'),
(31218, 'Mairâ€™s Forcefield', 'newage_7', 12041, 7, 1, '(Aandachts- & Stembereik) (Ceremonie) (1x per dag)\r\n\r\nAlle personen met krachtveld aanwezig krijgen +1 AP van hun krachtveld tot het einde van het volgende gevecht. Werkt alleen op elektronische krachtvelden'),
(31219, 'Mairâ€™s Creation', 'newage_8', 12041, 8, 1, '(Zelf) (1x per dagdeel)\r\n\r\nJe mag uit het niets een zeldzame grondstof laten verschijnen, deze grondstof moet binnen 15 minuten verwerkt worden in een recept of product anders vervalt het.'),
(31220, 'Mairâ€™s Maintenance', 'newage_9', 12041, 9, 1, '(Aandachts- & Stembereik) (Ceremonie) (1x per dag)\r\n\r\nIedereen die aanwezig is mag een extra voorwerp gratis onderhouden zonder dat er maintenance kits voor nodig zijn.'),
(31221, 'Mairâ€™s Portal', 'newage_10', 12041, 10, 1, '(Aanraak) (1x per dagdeel)\r\n\r\nAls je deze kracht gebruikt raak je een Portaal aan. Je mag jezelf en maximaal 5 andere Mairianen die je aanraakt verplaatsen naar een ander portaal binnen het netwerk. Je mag je hand opsteken en naar deze plek toelopen. Daar aangekomen doe gaat je hand weer omlaag en verschijn je. Indien de andere portaal niet in gebruik is verschijn je in het portaal waarvan je vertrok. Je gaat hiermee om de standaard protocollen heen van het portaal en deze gebruikt daardoor ook geen energie.'),
(31222, 'Background check', 'doaune_6', 12042, 6, 1, 'Je kunt van alle nieuwe gearriveerden een background check opvragen, waarmee je de informatie krijgt die nieuwe spelers moeten inleveren bij het maken van hun nieuwe karakter. Dit is gelimiteerd tot 4 personen per evenement en er moet een voor- en achternaam aangeleverd worden. (indien een speler/SL de template niet heeft ingevuld, dan kan dit 1 evenement duren.)'),
(31223, 'Bomb sniffer', 'doaune_7', 12042, 7, 1, 'Als er een voor de douanebeambte schadelijk pakketje aankomt, dan detecteer je deze voordat je hem openmaakt. Deze skill zorgt er alleen voor dat je het schadelijke pakketje detecteert, anderen zijn nodig voor ontmanteling, veilige afvoer of gecontroleerde detonatie.'),
(31224, 'Informele bestelling', 'doaune_8', 12042, 8, 1, 'Je kunt twee keer per evenement een gereguleerd goed kopen met normale sonuren ipv budgetsonuren.'),
(31225, 'Restrict travel', 'doaune_9', 12042, 9, 1, 'Je mag een figurant op de black list zetten, waardoor ze niet meer kunnen reizen voor de rest van dit evenement. De enige die dit kan opheffen is deze douanebeambte of kernwereld ICC douaneleden.'),
(31226, 'Trade embargo', 'doaune_10', 12042, 10, 1, '1 keer per evenement kan een product voor de rest van dat evenement op de illegale lijst worden gezet. De enige die dit embargo kan opheffen is deze douanebeambte.'),
(31227, 'Secure room', 'operative_6', 12043, 6, 1, 'Je kunt een kamer afluisterproof maken met een slot op de deur voor zolang het gesprek duurt.'),
(31228, 'Taser Knockout', 'operative_7', 12043, 7, 1, ' 1 keer per evenement kun je een (officieel schriftelijke) verdachte 4 HP subdue taseren.'),
(31229, 'Person of Interest', 'operative_8', 12043, 8, 1, 'Je kunt ervoor zorgen dat een figurant telefonisch contact opneemt. At the overlords discretion kan er ook gekozen worden voor een summons, of een APB, of in overleg met een rechter een warrant.'),
(31230, 'Crowd control', 'operative_9', 12043, 9, 1, 'Mass calm person.'),
(31231, 'Fabricating the evidence', 'operative_10', 12043, 10, 1, 'Je kan een keer per evenement een figurant framen voor de wet van zijn thuisfactie voor een misdaad die hij niet heeft begaan. Dit kan verdere gevolgen hebben. (overleg met spelleiding)'),
(31232, 'Persmomentje', 'journal_6', 12044, 6, 1, 'Je kunt een topic trending maken.'),
(31233, 'No comment', 'journal_7', 12044, 7, 1, 'Door no comment te gebruiken hoef je geen antwoord te geven op de vraag, maar vind de vragensteller het antwoord wel acceptabel.'),
(31234, 'â€œFactâ€ check', 'journal_8', 12044, 8, 1, 'Je kunt een zelfgeschreven rectificatie laten plaatsen over een verhaal en het originele verhaal laten intrekken.'),
(31235, 'Broncontrole', 'journal_9', 12044, 9, 1, '100% zeker weten wie de bron is van een verhaal'),
(31236, 'Canâ€™t stop the signal', 'journal_10', 12044, 10, 1, '1 x per evenement een verhaal naar buiten brengen naar alle newsoutlets zonder mogelijkheid tot spin of censuur.'),
(31237, 'Creative accounting', 'oudgeld_6', 12045, 6, 1, 'Je mag je overgebleven budgetsonuren meenemen naar het volgende evenement. (max 2x je huidige budget) - 700 budgetsonuren'),
(31238, 'Trust Fund', 'oudgeld_7', 12045, 7, 1, '1000 budgetsonuren'),
(31239, 'Maecenas', 'oudgeld_8', 12045, 8, 1, 'Je kunt een research of kunstproject financieren - 1400 budgetsonuren'),
(31240, 'Strategic Reserves', 'oudgeld_9', 12045, 9, 1, '2000 budgetsonuren'),
(31241, 'Private Wealth Management', 'oudgeld_10', 12045, 10, 1, '3000 budgetsonuren. Je mag je budgetsonuren verdubbelen, indien je een conclaaf lid erop af kunt laten tekenen.'),
(31242, 'Van de Vrachtwagen gevallen', 'sjach_6', 12046, 6, 1, 'Je kunt 2 standaardgoederen per evenement de 10x modifier laten vallen.'),
(31243, 'Special delivery', 'sjach_7', 12046, 7, 1, 'Je kunt per evenement 2 drugs bestellen met normale sonuren, ook als het op de gereguleerde lijst staat. Deze goederen staan officieel niet op jouw naam geregistreerd en kunnen officieel niet verkocht worden.'),
(31244, 'Witwassen', 'sjach_8', 12046, 8, 1, 'Je kunt zwart geld â€˜officieelâ€™ maken door er 10% belasting over te betalen. Je sonuren zijn dan officieel van jou.'),
(31245, 'Uit de Shuttle gevallen', 'sjach_9', 12046, 9, 1, 'Je kunt 5 standaardgoederen per evenement de 10x modifier laten vallen.'),
(31246, 'Foute Vrienden', 'sjach_10', 12046, 10, 1, 'Je kunt onbeperkt drugs bestellen, ook als deze op de gereguleerde goederen lijst staat en dit met normale sonuren betalen. Je mag via je special delivery in plaats van 2 drugs 1 gereguleerd goed met normale sonuren bestellen. Deze goederen staan officieel niet op jouw naam geregistreerd en kunnen officieel niet verkocht worden.'),
(31247, 'Overtures', 'dealmk_6', 12047, 6, 1, 'Als je een in een gelaagde deal (hoofdeal) een subdeal op tafel legt, moet de ander ook een subdeal op tafel leggen'),
(31248, 'Walkaway option', 'dealmk_7', 12047, 7, 1, 'Als je je eigen walkaway optie deelt, dan moet de ander zijn walkaway optie ook op tafel leggen.\r\n'),
(31249, 'Navigating the playingfield', 'dealmk_8', 12047, 8, 1, 'Je hebt altijd een andere aanbieder en weet zijn prijs.'),
(31250, 'Business psychologist', 'dealmk_9', 12047, 9, 1, 'Je mag aan de andere partij op voorhand vragen wat zijn grootste belang is en deze geeft dit.'),
(31251, 'A little something on the side', 'dealmk_10', 12047, 10, 1, 'Wanneer je een grote deal namens een andere partij regelt, dan krijg je 10% van de waarde in budgetsonuren toebedeelt.'),
(31252, 'Lysische Centrifuge', 'xeno_6', 12048, 6, 1, 'Door het zorgvuldig verzamelen en analyseren van specimen en zaden heb je planten geÃ¯dentificeerd waarmee je de werking van medicijnen kan simuleren. Aan het begin van het weekend mag je 2 dosissen van een medicijn uit de standaard goederen hebben geproduceerd (verzin een goede reden hoe je die gemaakt hebt met bijv. kweek).'),
(31253, 'Selectieve Druk', 'xeno_7', 12048, 7, 1, 'Je mag 5x per evenement een andere grondstof gebruiken dan de grondstof die je normaal gesproken nodig hebt voor een voorwerp.\r\n'),
(31254, 'Botanische Xeno-Scanner', 'xeno_8', 12048, 8, 1, 'Je begrijpt de levenscyclus van de lokale fauna en kan deze kennis omzetten in praktische applicaties. Aan het begin van het weekend mag je 5 dosissen van een medicijn uit de standaard goederen hebben geproduceerd. Ook mag je wanneer grondstoffen wint er direct voor kiezen om deze om te zetten in medicijnen zonder de grondstoffen te hoeven bewerken omdat je weet wat het optimale moment is om deze grondstoffen te winnen.'),
(31255, 'Gefaseerde Extractie', 'xeno_9', 12048, 9, 1, 'Je kunt uit 2 geologische grondstoffen 1 biochemische grondstof naar keuze extraheren.'),
(31256, 'Circulaire Xeno-Biomen / Lokale Hyper Evolutie', 'xeno_10', 12048, 10, 1, 'Het principe dat ziekte en genezing evolueren in nabijheid van elkaar zorgt ervoor dat je lokale medicijnen in grote hoeveelheden kunt synthetiseren. Aan het begin van het weekend mag je 10 dosissen van een door jou bekend medicijn (alleen standaard goederen) gemaakt hebben.\r\n\r\nJe bijdragen aan onderzoek naar lokale ziekten om snel een genezing te vinden door versneld door de levensloop van de conditie heen te lopen - 1 x per weekend kun je na onderzoek een nieuwe ziekte of conditie identificeren en 10 dosissen genezing daar voor fabriceren. Ook kun je vervolgens anderen leren hoe je dit maakt.'),
(31257, 'Prudent analysis', 'superextr_6', 12049, 6, 1, 'Als je analytische chemie toepast, vernietig je je samples niet. Je verbruikt dus geen grondstof meer.'),
(31258, 'Measure twice, extract once', 'superextr_7', 12049, 7, 1, 'als je het resultaat van je rol niets vind, mag je kiezen om te rerollen. Het resultaat van de tweede rol staat.'),
(31259, 'Perfect extractor', 'superextr_8', 12049, 8, 1, 'Je krijgt een tweede plus 10 op de generator rol waardoor je nooit meer catastrofale resultaten zullen behalen.'),
(31260, 'Analysis paralysis', 'superextr_9', 12049, 9, 1, 'Je analyses zijn zo grondig, dat je een entry mag inzien. Deze wordt random getoond.'),
(31261, 'Superkritische extractie', 'superextr_10', 12049, 10, 1, 'Een keer per dag rol je niet op de tabel, maar mag je kiezen welke 5 grondstoffen je uit extraheert.'),
(31262, 'Deep Layer prospecting', 'mtexpl_6', 12050, 6, 1, 'Je weet zo goed te minen, dat je een entry mag inzien. Deze wordt random getoond.'),
(31263, 'Veteran driller', 'mtexpl_7', 12050, 7, 1, 'als je het resultaat van je rol niets vind, mag je kiezen om te rerollen. Het resultaat van de tweede rol staat.\r\n'),
(31264, 'Perfect prospector', 'mtexpl_8', 12050, 8, 1, 'Je krijgt een tweede plus 10 op de generator rol waardoor je robots nooit meer catastrofale resultaten zullen behalen.\r\n'),
(31265, 'Deep bots', 'mtexpl_9', 12050, 9, 1, ' Al je robots hebben automatisch hardened drills en zijn aquatic'),
(31266, 'Mantel Kern Winning', 'mtexpl_10', 12050, 10, 1, 'Een keer per dag rol je niet op de tabel, maar mag je kiezen welke 5 grondstoffen je uit de mantel wint.'),
(31267, 'Expert bots I', 'botjock_6', 12051, 6, 1, 'Je bots krijgen een extra equipment slot. In totaal nu 6 equipment slots.'),
(31268, 'Expert bots II', 'botjock_7', 12051, 7, 1, 'Je bots krijgen een extra equipment slot. In totaal nu 7 equipment slots.'),
(31269, 'Tertiary Robot', 'botjock_8', 12051, 8, 1, 'Je krijgt het voor elkaar om een derde robot in de lucht te houden.'),
(31270, 'Expert bots III', 'botjock_9', 12051, 9, 1, 'Je bots krijgen een extra equipment slot. In totaal nu 8 equipment slots.'),
(31271, 'Drone swarm', 'botjock_10', 12051, 10, 1, 'Je bots vallen uiteen in miljoenen autonome onderdelen die in 1 keer een node volledig leegtrekken. Je krijgt alle resources uit de node naar de oppervlakte in 1 keer per evenement.'),
(31272, 'Space robots', 'spacemine_6', 12052, 6, 1, 'Je modificeert je robots zodat ze in zero-G omstandigheden werken'),
(31273, ' Flyby bots', 'spacemine_7', 12052, 7, 1, 'Je hoeft je robots niet meer op te halen, maar kunt de robots besturen om terug te keren naar je schip.\r\n'),
(31274, 'Hoarding hole', 'spacemine_8', 12052, 8, 1, 'Je bots hollen een gedeelte van de astroide uit om hun resources in op te slaan.\r\n'),
(31275, 'Tertiary Robot', 'spacemine_9', 12052, 9, 1, 'Je krijgt het voor elkaar om een derde robot in de lucht te houden, maar alleen in space.\r\n'),
(31276, 'Miningstation', 'spacemine_10', 12052, 10, 1, 'Je bots kunnen een rudimentaire verdediging bouwen van de resources die je hebt. In plaats van harvesten kunnen robots automatische verdedigingen voor je bouwen,'),
(31277, 'Asking a favour', 'factiepoli_6', 12053, 6, 1, '1 keer per evenement mag je een groot verzoek doen aan iemand binnen je factie. Je kansen dat de ander mee zal werken, worden verhoogd als je de persoon je kent, vertrouwt, je eerder samen hebt gewerkt. Als je nuttige dingen kunt betekenen voor deze persoon en dit op tafel legt, gaat je kans ook omhoog.'),
(31278, 'Full Background check', 'factiepoli_7', 12053, 7, 1, '1 keer per evenement mag je een background check laten uitvoeren op iemand binnen je factie. Alles wat officieel op papier staat wordt een conclusie aan verbonden. Binnen je factie of de ICC geeft deze skill je de absolute papieren en sociale waarheid over dat personage. Buiten je factie alleen de absolute papieren waarheid (wordt niet gephyrepped maar gecalled)'),
(31279, 'Friend of a Friend', 'factiepoli_8', 12053, 8, 1, 'Door middel van je contacten kan je 1 x per weekend bijzondere zaken zoals vergunningen, toestemmingen of de diensten van een specialist tot en met niveau 8 krijgen voor 1 dienst of vraag. Je kan natuurlijk op termijn wel een wedervraag verwachten.'),
(31280, 'Blackmail', 'factiepoli_9', 12053, 9, 1, '1 keer per evenement krijg je een stukje informatie over iemand binnen je factie waar je deze persoon potentieel mee kunt blackmailen.'),
(31281, 'An offer you canâ€™t refuse', 'factiepoli_10', 12053, 10, 1, '1 keer per evenement kom je erachter wat een vijand binnen de kernwerelden het allerbelangrijkst vind. Bijvoorbeeld: Het meest favoriete paard, zoon, auto van je vijand. De persoon waartegen je dit inzet wordt een enemy for life maar je krijgt wel gedaan wat je gedaan moet krijgen.'),
(31282, 'Friends on the Other Side I', 'icclobby_6', 12054, 6, 1, 'Je mag 1 extra factie kiezen, waarbij je expertise gewaardeerd wordt. Door via het ICC adviezen neer te leggen bij de juiste partijen, kun je proberen sturing te geven aan andere partijen.'),
(31283, 'Friends on the Other Side II', 'icclobby_7', 12054, 7, 1, 'Je mag 1 extra factie kiezen, waarbij je expertise gewaardeerd wordt. Door via het ICC adviezen neer te leggen bij de juiste partijen, kun je proberen sturing te geven aan andere partijen.'),
(31284, 'Friends on the Other Side III', 'icclobby_8', 12054, 8, 1, 'Je mag 1 extra factie kiezen, waarbij je expertise gewaardeerd wordt. Door via het ICC adviezen neer te leggen bij de juiste partijen, kun je proberen sturing te geven aan andere partijen.'),
(31285, 'Friends on the Other Side IV', 'icclobby_9', 12054, 9, 1, 'Je mag 1 extra factie kiezen, waarbij je expertise gewaardeerd wordt. Door via het ICC adviezen neer te leggen bij de juiste partijen, kun je proberen sturing te geven aan andere partijen.'),
(31286, 'The power of the Veto', 'icclobby_10', 12054, 10, 1, '1 keer per evenement mag je een opdracht vanuit het ICC weigeren zonder negatieve consequenties voor jou of de kolonie.'),
(31287, 'Skill polgener 6', 'polgener_6', 12055, 6, 1, 'Je mag 1 extra aandachtsgebied kiezen en antecedentenonderzoek (Politicologie 1) is voor al je aandachtsgebieden te gebruiken.'),
(31288, 'Skill polgener 7', 'polgener_7', 12055, 7, 1, 'Je mag 1 extra aandachtsgebied kiezen en Trust me (Politicologie 2) is voor al je aandachtsgebieden te gebruiken.'),
(31289, 'Skill polgener 8', 'polgener_8', 12055, 8, 1, 'Je mag 1 extra aandachtsgebied kiezen en Conversational topic (Politicologie 1) is voor al je aandachtsgebieden te gebruiken.\r\n'),
(31290, 'Skill polgener 9', 'polgener_9', 12055, 9, 1, 'Je mag 1 extra aandachtsgebied kiezen en Email introductie (Politicologie 1) is voor al je aandachtsgebieden te gebruiken.'),
(31291, 'Skill polgener 10', 'polgener_10', 12055, 10, 1, 'Doing a favour is voor al je aandachtsgebieden te gebruiken.'),
(31292, 'Parallaxing', 'itelite_6', 12056, 6, 1, 'Door slimme quantumprocessoren lijkt het alsof je op twee plekken tegelijkertijd aan het hacken bent. Je kan een dubbel aantal standaard oplossingen voorbereiden.'),
(31293, 'Packet Storm', 'itelite_7', 12056, 7, 1, 'Zelfs de allerbeste Elites worden een keertje gepakt. Je mag 2 x per dag elk bewijs van een gefaalde poging uitwissen, zowel die van jezelf als die van anderen. Servers crashen, logs vallen uit het geheugen en notificaties worden onderschept - het lijkt voor normale beheerders op een crash â€˜die nu eenmaal wel eens gebeurtâ€™'),
(31294, 'Echelon', 'itelite_8', 12056, 8, 1, 'De geruchten dat de verschillende geheime diensten achterdeurtjes laten inbouwen in software kloppen, en jij kent er meerdere van. Je mag 1 hack per dag \r\nâ€˜previewenâ€™ en zo precies weten wat je nodig hebt om alle puzzels op te lossen. Ook mag je vier maal zo veel standaard oplossingen voorbereiden.'),
(31295, 'Logic Trap', 'itelite_9', 12056, 9, 1, 'Je kan bij een succesvolle hack een val achterlaten bij een hack voor een nieuwe hackpoging of counterhack. Maak een puzzel en voeg deze toe aan de hack - als opvolgende hack of counterhack pogingen falen deze puzzel op te lossen zijn ze onmiddellijk gedetecteerd en faalt de hackpoging automatisch.'),
(31296, 'Zero Day', 'itelite_10', 12056, 10, 1, 'Per evenement kun je automatisch 1 hacking of counter-hacking poging laten slagen door een tot dan onbekende beveiligingsbug te exploiteren.'),
(31297, 'Code Protected Cordon', 'itarchi_6', 12057, 6, 1, 'Bij een poging om een netwerk wat je beheert te hacken mag je een server actief beschermen waardoor deze niet gehackt kan worden. De bescherming houdt op zodra je iets anders gaat doen.'),
(31298, 'Firewall of doom', 'itarchi_7', 12057, 7, 1, 'Je primary firewall is anderhalf maal zo efficient. Pogingen die falen hier voorbij te komen worden automatisch gedetecteerd.'),
(31299, 'Sea of Simulation', 'itarchi_8', 12057, 8, 1, 'Je kan een simulatieomgeving, een zgn â€˜Honeypotâ€™ bouwen die praktisch echt lijkt. Naast het voordeel dat bevriende hackers kunnen oefenen mag je 2x per weekend als je netwerk wordt gehackt verklaren dat ze de simulatie hebben gehackt in plaats van je eigen omgeving.'),
(31300, 'Hidden pocket', 'itarchi_9', 12057, 9, 1, 'Je creÃ«ert een information node die ontraceerbaar is, waar je 10 documenten op kunt slaan die onhackbaar is. Deze 10 documenten kunnen nooit remote accessed worden.'),
(31301, 'City of Light', 'itarchi_10', 12057, 10, 1, 'Dit vereist dat je gedeeltelijk of geheel een groot netwerk beheert zoals dat van een militaire basis, schip of Bastion Eos. Iedereen die Informatica gebruikt binnen je netwerk mag 1x per dag een extra wachtwoordvakje of firewallvakje omdraaien door het inzetten van het volledige potentieel van je netwerk.'),
(31302, 'Skill savant 6', 'savant_6', 12058, 6, 1, 'Skill description'),
(31303, 'Skill savant 7', 'savant_7', 12058, 7, 1, 'Skill description'),
(31304, 'Skill savant 8', 'savant_8', 12058, 8, 1, 'Skill description'),
(31305, 'Skill savant 9', 'savant_9', 12058, 9, 1, 'Skill description'),
(31306, 'Skill savant 10', 'savant_10', 12058, 10, 1, 'Skill description'),
(31307, 'Lector ', 'academy_6', 12059, 6, 1, 'naast actief onderzoeker draag je ook bij aan lezingen en informatie voor universiteits leerlingen binnen je vakgebied. Door je contacten slim in te zetten heb je per weekend de beschikking over twee junior onderzoekers die Level 3 hebben in twee door jou gekozen research vaardigheden. Dit breidt zich uit naar vier junior onderzoekers op Level 8 en zes op Level 10. Deze TOAâ€™s zijn naar wens in te zetten bij onderzoek.\r\n'),
(31308, 'Steen van Rosetta', 'academy_7', 12059, 7, 1, 'Peer-reviewing - als er op Gaia een artikel verschijnt wat relevante informatie bevat voor je onderzoeksgebied mag je een gebruik van Sociological Knowledge inruilen voor een extra gebruik van Research omdat je het voor elkaar krijgt om deel te zijn van het Peer-reviewing proces.\r\nSteen van Rosetta - je vaardigheden kunnen een dode taal nieuw leven inblazen. Als je Decypher script gebruikt in de context van een onderzoek mag je als je er binnen een uur niet uitkomt hints gaan halen bij de spelleiding. \r\n'),
(31309, ' Onverwacht Resultaat Dus Nieuwe Hypothese', 'academy_8', 12059, 8, 1, ' Zelfs als een onderzoek faalt zie je er nog nuttige data uit te halen. Als een onderzoek waaraan jij meewerkt onverhoopt niet slaagt mag je het onderzoek â€˜resettenâ€™ - iedereen die heeft deelgenomen mag opnieuw zijn of haar vaardigheid in het onderzoek stoppen om te kijken of het nu wel lukt. (tokens worden gerefund)\r\n'),
(31310, 'Onderzoeksbeurs ', 'academy_9', 12059, 9, 1, 'je doet mee aan een ICC subsidieronde. Als er kosten aan een het eindresultaat van het onderzoek verbonden zitten (zoals het maken van een prototype), dan kan je 1 x per weekend de helft van de (budget-)Sonuren uitsparen. Deze vaardigheid stackt, dus als twee Academici samenwerken is het mogelijk om een prototype volledig te laten subsidiÃ«ren. Er wordt natuurlijk wel van je verwacht dat je verantwoordelijkheid afdraagt aan je project - een levensreddende bionic zal er zeker doorkomen, maar een nieuw massavernietigingswapen zit de academische wereld niet op te wachten. \r\n'),
(31311, 'Eredoctoraat ', 'academy_10', 12059, 10, 1, 'je bent op meerdere universiteiten geÃ«erd als lichtend voorbeeld en levende legende binnen de moderne wetenschap. Je mag 1 x per weekend iedereen binnen een specifiek onderzoek waar jij leiding aan geeft al het Research teruggeven aan iedereen die heeft deelgenomen, ongeacht of dit een succes was. In essentie is al het research aan dat onderwerp tot dan aan toe â€˜gratis geweestâ€™. Dit vertegenwoordigt het feit dat je contacten aanspreekt en zaken regelt om de beste offworld faciliteiten en post-doc studenten beschikbaar te maken voor je onderzoeksteam. Speel dit toepasselijk uit.\r\n'),
(31312, ' Combat ready check', 'stratcom_6', 12060, 6, 1, 'Dubbelcheck met de SL (of SL ingezette figurant die volledig op de hoogte is) of alle bekende missie vereisten zijn vervuld qua personeel. Heeft deze unit alles om deze missie af te ronden? 3x per evenement.'),
(31313, 'Reinforcements', 'stratcom_7', 12060, 7, 1, 'als je er tijdens een missie achterkomt dat een team een vaardigheid, materieel of talent mist in het veld mag je een vrijwilliger naar keuze aanwezig op het Bastion door middel van â€˜Rapid Deploymentâ€™ onmiddellijk naar de missie-zone sturen. Deze persoon wordt via shuttle, grav-chute of drop-pod ( speel het leuk uit ) binnen 10 meter van de missie-leider afgeleverd en kan direct aan het werk. Dit kost je 1.000 budgetsonuren.'),
(31314, 'Actionable intelligence', 'stratcom_8', 12060, 8, 1, 'Voordat je een missie op pad stuurt, mag je aan een SL (of SL ingezette figurant die volledig op de hoogte is) vragen of hij denkt dat je alle informatie hebt, die je nodig hebt om de situatie goed in te schatten. 3x per evenement.\r\n\r\n-Call in the Specialist. Dit is een zeer ervaren compaan met precies de slagvaardigheid heeft die je nodig hebt voor de missie. Jij bepaalt hierbij de vaardigheden en vereisten. Dit is een DPC voor 1 missie of special maximaal 3x per weekend. Het heeft onze sterke voorkeur dat je een medespeler vraagt om deze DPC tijdelijk te spelen - we zetten hier voor alleen een figurant in als het extreem noodzakelijk is. Een â€œfigurant nooit, tenzijâ€ beleid is hier van toepassing. Onze motivatie hier in is dat zo ook non-combat spelers mee kunnen gaan op het slagveld of missie en eventueel zelfs een vaste DPC rol kunnen krijgen als de samenwerking bevalt. \r\n'),
(31315, 'Angels of Mercy', 'stratcom_9', 12060, 9, 1, 'Soms heb je een missieteam erop uit gestuurd, maar blijk je ze toch voor iets anders nodig te hebben. Je haalt het hele missie team in 1 klap terug, in de staat waarin ze zich bevinden. Vind hier een goede IC uitleg voor. Dit kost je 5 duizend budgetsonuren.\r\n'),
(31316, 'At least they did not die for nothing', 'stratcom_10', 12060, 10, 1, 'Een keer per evenement mag je een missie die volledig misgelopen is, omzetten naar een volledige win situatie ondanks alle te betreuren doden en gewonden. Dit kost 10 duizend budgetsonuren.'),
(31317, 'Visionary accounting', 'account_6', 12061, 6, 1, 'Voor iemand anders die â€œcreative accountingâ€ (oud geld 6) heeft, kun jij hun reserve omhoog gooien met een factor 10. Ze kunnen dan maximaal 60.000 Bson (oud geld 10) meenemen naar het volgende evenement. Dit kun je voor 3 personen doen, maar dit kun je niet voor jezelf.   '),
(31318, 'Bang for your buck', 'account_7', 12061, 7, 1, 'De kernwereld-specialist die je gratis kunt inhuren via â€˜recruitment,â€™ mag hetzelfde niveau zijn als je hoogste economie specialisatie. (normaal 1-5, nu maximaal 1-10)\r\n'),
(31319, 'Show me the moneeeeyyy!!!', 'account_8', 12061, 8, 1, 'Jij kunt voor een weekend de budgetsonuren van een ander verdubbelen. Deze verdubbeling stackt met de verdubbeling van Private Wealth Management (oud geld 10) waardoor het aantal 18.000 wordt. Je kunt dit voor 5 mensen doen.  \r\n'),
(31320, 'Audit', 'account_9', 12061, 9, 1, 'Je bevriest de assets van een old-space bedrijf, of van een medespeler. De medespeler heeft geen toegang tot zijn sonuren tot de volgende morgen. (loop langs de speler en vertel hem hoe het werkt) '),
(31321, ' Bad Debt', 'account_10', 12061, 10, 1, 'Een keer per jaar mag je een lening die afgesloten is door de kolonie tot 100.000 budgetsonuren af laten schrijven als een â€˜bad debt.â€™'),
(31322, 'Skill interro 6', 'interro_6', 12062, 6, 1, 'Skill description'),
(31323, 'Skill interro 7', 'interro_7', 12062, 7, 1, 'Skill description'),
(31324, 'Skill interro 8', 'interro_8', 12062, 8, 1, 'Skill description'),
(31325, 'Skill interro 9', 'interro_9', 12062, 9, 1, 'Skill description'),
(31326, 'Skill interro 10', 'interro_10', 12062, 10, 1, 'Skill description'),
(31327, 'Trained bodyguard', 'bodyguard_6', 12063, 6, 1, 'Je mag voor het evenement een mark uitkiezen en dit is de persoon die je beschermt. Je mag voor deze persoon ten alle tijden klap of schot overnemen, als je in de buurt bent en je je mark aan het verdedigen was in die situatie. Je kunt nooit meer klappen of schoten overnemen dat je zelf kunt nemen. '),
(31328, 'Eyes in the back of your head', 'bodyguard_7', 12063, 7, 1, 'Je mag 1 extra mark hebben. Als beide marks bij elkaar zijn en je bent in de buurt (bv in dezelfde ruimte), mits je je mark aan het verdedigen was in die situatie mag je van allebei de marks klap of schot overnemen. Per maaltijd bepaal je welke 2 marks je tot de volgende maaltijd hebt.\r\n');
INSERT INTO `ecc_skills_allskills` (`skill_id`, `label`, `skill_index`, `parent`, `level`, `version`, `description`) VALUES
(31329, 'Taking the bullet', 'bodyguard_8', 12063, 8, 1, 'Je mag 1 keer per evenement je mark uit een gevechtssituatie halen, ongeacht de schade aan jezelf. Je moet echter wel de gevechtssituatie zo snel mogelijk met je mark verlaten. Het is expliciet niet de bedoeling dat je doorgaat met vechten, tenzij er echt geen andere optie is. Je gaat pas neer, nadat je mark in de dichtsbijzijnde medbay ligt.\r\n'),
(31330, 'Bond of trust', 'bodyguard_9', 12063, 9, 1, 'Als je in de buurt bent van je mark, krijgt je mark 3 minuten extra tijd om dood te bloeden. (als je vredig bent in een stressvolle situatie door de aanwezigheid van je bodyguard, leef je langer)\r\n'),
(31331, 'The final sacrifice', 'bodyguard_10', 12063, 10, 1, 'Als je mark sterft, dan mag je zijn/haar plaats innemen, ongeacht de OC afstand op dat moment. Zelfs al was je mark aan de andere kant van de planeet, je mag voor hem/haar sterven: Samen verzin je OC (eventueel met hulp van een SL) een manier waarop dit gebeurt is, maar jij sterft in plaats van je mark. '),
(31332, 'Featherlight training', 'flash_6', 12064, 6, 1, 'Je kunt je wapen gebruiken op de snelheid zoals je een larp wapen kunt gebruiken. Er zijn veel roleplay verklaringen om sneller met je wapen om te leren gaan. Gedeeltelijke vervanging met carbon nanotubes in je wapen, high-gravity training of je armen vol pompen met nanobots. Door deze skill te nemen zijn zware wapens een stuk beter hanteerbaar (en hoef je in feite niet zo zwaar het gewicht meer uit te spelen).\r\n'),
(31333, 'Faster than the machine', 'flash_7', 12064, 7, 1, 'Skill description Je mag een cloak field generator die reeds is aangezet 1x 10 stappen rennend verplaatsen, zonder dat het de generator uitzet. Als je de generator voor een tweede keer beweegt tijdens de 10 minuten duratie, dan stopt de generator.\r\n\r\nHidden blade: Je hebt ergens op je lichaam een verborgen compartiment waar een dolk in past. Deze is niet te detecteren, zelfs niet met bijvoorbeeld een metaaldetector. Dugo gebruiken dit vaak voor hun Salita.\r\n'),
(31334, 'Bullet bypass', 'flash_8', 12064, 8, 1, 'Vlijmscherpe reflexen zorgt ervoor dat de eerste kogel per gevecht (dat er plaats vindt, niet per vijand) je niet eens raakt.'),
(31335, 'Blinding speed', 'flash_9', 12064, 9, 1, '200-meter sprint training komt goed van pas wanneer je onvolgbaar snel weet te zijn. 3x daags kan je tien stappen lang onzichtbaar rennen (Handgebaar: Vinger in de lucht). Het gebruik van een rookgranaat zorgt ervoor dat je twee mensen mee kan nemen in je sprint.\r\nNote: Deze skill vereist dat je rent, maar let wel op je veiligheid en rem op tijd af! Je stappen tellen dan alsnog.\r\n'),
(31336, 'Gyroscopic Bleed', 'flash_10', 12064, 10, 1, 'Door de kinetische energie van je slagen op te slaan en deze los te laten op het moment dat je getroffen wordt, weet je de schade te ontwijken. Elke drie slagen die je op een vijand land geeft je een tijdelijk armour point voor de rest van het gevecht.\r\n'),
(31337, 'Overextended shields', 'shishaper_6', 12065, 6, 1, 'Zo lang je contact houd met een voorwerp kan je je schild eromheen werpen. Dit zorgt er alleen wel voor dat je je eigen schild kwijt raakt en je effectieve schild alleen werkt op het voorwerp. (Drie keer per dag mits je BP dat toe laat.)\r\n'),
(31338, 'Extended Field Projection', 'shishaper_7', 12065, 7, 1, '(+1BP): Door contact te houden met twee personen mag je beiden beschermen met je schild. (Krijgen allebei 2 BP van je eigen schild)\r\n'),
(31339, 'I got it!', 'shishaper_8', 12065, 8, 1, '(+1 BP): Door je op een explosief te werpen mag je in ruil voor 2 van je beschermingspunten van je schild het effect van het explosief teniet doen.\r\n'),
(31340, 'Bullet Magnet', 'shishaper_9', 12065, 9, 1, '(+1 BP): Je laat zoveel energie door je schild stromen dat je een dubbel schild krijgt die het aankomende gevecht de kogels maar 1 schade laat doen. (Ã‰Ã©n keer per dag, dubbel zo makkelijk te detecteren op sensoren) \r\n'),
(31341, 'Get behind me!', 'shishaper_10', 12065, 10, 1, '+1BP): Je vergroot je schild zodat je team in je schild kan staan. Je team mag van je schild profiteren zolang ze binnen twee meter van je staan. (Dit kan in combinatie met de andere vaardigheden in de specialisatie)\r\n');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ecc_skills_groups`
--

DROP TABLE IF EXISTS `ecc_skills_groups`;
CREATE TABLE IF NOT EXISTS `ecc_skills_groups` (
  `primaryskill_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `siteindex` varchar(15) NOT NULL,
  `psychic` varchar(6) NOT NULL DEFAULT 'false',
  `parents` varchar(100) DEFAULT 'none',
  `status` varchar(15) DEFAULT 'active',
  PRIMARY KEY (`primaryskill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12066 DEFAULT CHARSET=latin1;

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
(12023, 'Psy-Ops', 'psyops', 'false', 'will', 'active'),
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
