-- phpMyAdmin SQL Dump
-- version 4.0.10.20
-- https://www.phpmyadmin.net
--
-- Hostiteľ: localhost
-- Vygenerované: Ne 02.Dec 2018, 21:09
-- Verzia serveru: 5.6.40
-- Verzia PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáza: `xbarte14`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `Liecba`
--

CREATE TABLE IF NOT EXISTS `Liecba` (
  `ID_Liecby` int(11) NOT NULL,
  `Diagnoza` varchar(60) COLLATE latin2_czech_cs NOT NULL,
  `Cena` float DEFAULT NULL,
  `Datum_zahajenia` date NOT NULL,
  `Datum_ukoncenia` date DEFAULT NULL,
  `ID_Zvierata` int(11) NOT NULL,
  `ID_Veterinara` int(11) NOT NULL,
  PRIMARY KEY (`ID_Liecby`),
  KEY `ID_Zvierata` (`ID_Zvierata`),
  KEY `ID_Veterinara` (`ID_Veterinara`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;

--
-- Sťahujem dáta pre tabuľku `Liecba`
--

INSERT INTO `Liecba` (`ID_Liecby`, `Diagnoza`, `Cena`, `Datum_zahajenia`, `Datum_ukoncenia`, `ID_Zvierata`, `ID_Veterinara`) VALUES
(2, 'Underdosing of unsp drugs acting on muscles, subs encntr', 5940.85, '2017-04-11', '2018-09-22', 3, 3),
(3, 'Puncture wound w/o foreign body of thmb w damage to nail', 6910.09, '2017-12-20', '2018-10-30', 4, 4),
(4, 'Occupant of 3-whl mv injured in unsp nontraf, sequela', 4633.83, '2017-06-14', '2018-11-22', 5, 1),
(5, 'Extreme immaturity of NB, gestatnl age 24 completed weeks', 6340.99, '2017-08-14', '2018-10-17', 6, 2),
(6, 'Displ transverse fx shaft of r femr, 7thQ', 783.34, '2017-10-20', '2018-09-06', 7, 3),
(7, 'Unsp injury of msl/tnd of unsp wall of thorax, init', 3067.23, '0000-00-00', '2018-05-24', 8, 4),
(8, 'Infct of amniotic sac and membrns, unsp, first tri, unsp', 6315.03, '2017-09-09', '2018-04-02', 9, 1),
(9, 'Nondisp fx of olecran pro w/o intartic extn l ulna, 7thH', 5313.13, '2017-04-01', '2018-12-27', 10, 2),
(10, 'Supervision of young multigravida, third trimester', 6755.33, '2017-01-16', '2018-09-28', 11, 3),
(11, 'Insect bite (nonvenomous) of right elbow, subs encntr', 1193.55, '2017-06-05', '2018-06-01', 12, 4),
(12, 'Inj unsp musc/fasc/tend at wrs/hnd lv, right hand, subs', 6026.74, '2017-10-03', NULL, 13, 1),
(13, 'Type 1 diabetes mellitus with ketoacidosis', 6631.82, '0000-00-00', '2018-08-15', 14, 2),
(14, 'Superficial foreign body, left great toe, initial encounter', 3010.99, '2017-09-22', '2018-05-16', 15, 3),
(15, 'Burn of right eyelid and periocular area, initial encounter', 6931.44, '2017-05-09', '2018-04-27', 16, 4),
(16, 'Sprain of oth parts of unsp shoulder girdle, subs encntr', 5869.62, '2017-11-01', '2018-09-13', 17, 1),
(17, '2-part disp fx of surg nk of unsp humer, 7thD', 5061.23, '2017-04-11', '0000-00-00', 18, 2),
(18, 'Cerebral infarction due to thombos unsp vertebral artery', 2139.86, '2017-09-15', '2018-11-11', 19, 3),
(19, 'Wedge comprsn fx third thor vertebra, init for opn fx', 334.71, '2017-04-19', NULL, 20, 4),
(20, 'Displaced fracture of body of unspecified calcaneus, sequela', 2997.56, '2017-06-27', '2018-08-01', 21, 1),
(21, 'Intermittent exophthalmos, unspecified eye', 4047.39, '2017-01-15', '2018-08-28', 22, 2),
(22, 'Burns of 70-79% of body surface w 10-19% third degree burns', 502.81, '2017-05-02', '2018-02-14', 23, 3),
(23, 'Corrosion of second degree of nose (septum), sequela', 4121.71, '2017-05-08', '2018-11-18', 24, 4),
(24, 'Other injury of liver, initial encounter', 340, '2017-10-12', '2018-12-30', 25, 1),
(25, 'Traum hemor l cereb w LOC w dth d/t brain inj bf consc, init', 3082.76, '2017-06-12', '2018-04-07', 1, 2),
(26, 'Toxic effect of contact w unsp venomous animal, acc, subs', 1187.25, '2017-11-12', '2018-07-26', 2, 3),
(27, 'Nondisp seg fx shaft of ulna, unsp arm, 7thN', 976.02, '2017-01-25', '2018-06-19', 3, 4),
(28, 'Corros 2nd deg mul sites of left lower limb, ex ank/ft, subs', 1364.86, '2017-04-09', '2018-11-10', 4, 1),
(29, 'Nondisplaced comminuted fracture of shaft of left tibia', 3904.82, '2017-07-29', '2018-03-14', 5, 2);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `Liek`
--

CREATE TABLE IF NOT EXISTS `Liek` (
  `ID_Lieku` int(11) NOT NULL,
  `Nazov` varchar(30) CHARACTER SET latin2 COLLATE latin2_czech_cs NOT NULL,
  `Davkovanie` varchar(100) CHARACTER SET latin2 COLLATE latin2_czech_cs NOT NULL,
  `Specificka_doba_podavania` varchar(100) CHARACTER SET latin2 COLLATE latin2_czech_cs NOT NULL,
  `Typ` varchar(30) CHARACTER SET latin2 COLLATE latin2_czech_cs NOT NULL,
  `Ucinna_latka` varchar(30) CHARACTER SET latin2 COLLATE latin2_czech_cs NOT NULL,
  `Kontraindikacie` varchar(60) CHARACTER SET latin2 COLLATE latin2_czech_cs DEFAULT NULL,
  PRIMARY KEY (`ID_Lieku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `Liek`
--

INSERT INTO `Liek` (`ID_Lieku`, `Nazov`, `Davkovanie`, `Specificka_doba_podavania`, `Typ`, `Ucinna_latka`, `Kontraindikacie`) VALUES
(1, 'Metoprolol Tartrate', 'vecer', '4 dni', 'Liek', 'Informatikulum Sofistum', 'Stratum Mitospherum'),
(2, 'Promethazine Hydrochloride', 'rano a vecer', '4 tyzdne', 'Liek', 'Aeronal Fucilimu', 'Kondixum Bevernatum'),
(3, 'Salt Cedar', 'rano', '3 dni', 'Zabal', 'Aversium Sulfatum', 'Varcium Anabolikum'),
(4, 'Acetaminophen', 'obed', '2 mesiace', 'cipok', 'Multiplexum Kortikulum', ''),
(5, 'VECURONIUM BROMIDE', 'rano', '5 tyzdnov', 'Liek', 'Varcium Anabolikum', 'Stratum Mitospherum'),
(6, 'Sunmark athletes foot powder', '5 krat denne', '2 dni', 'Liek', 'Kortikulum Varcalium', ''),
(7, 'Tandem', '2x denne', '2 mesiace', 'Injekcia', 'Stratum Mitospherum', ''),
(8, 'Clear', 'raz za dva tyzdne', '4 roky', 'Injekcia', 'Varsius Manulitus', ''),
(9, 'Hyundai Moolpas F', 'rano', '4 dni', 'Liek', 'Melcium Satusfakcium', ''),
(10, 'Robongbang Propolis', 'rano', '3 dni', 'Liek', 'Stratum Mitospherum', '');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `Majitel`
--

CREATE TABLE IF NOT EXISTS `Majitel` (
  `ID_Majitela` int(11) NOT NULL,
  `Meno` varchar(20) COLLATE latin2_czech_cs NOT NULL,
  `Priezvisko` varchar(30) COLLATE latin2_czech_cs NOT NULL,
  `Titul` varchar(15) COLLATE latin2_czech_cs DEFAULT NULL,
  `Adresa` varchar(30) COLLATE latin2_czech_cs NOT NULL,
  PRIMARY KEY (`ID_Majitela`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;

--
-- Sťahujem dáta pre tabuľku `Majitel`
--

INSERT INTO `Majitel` (`ID_Majitela`, `Meno`, `Priezvisko`, `Titul`, `Adresa`) VALUES
(1, 'Melicent', 'Yalden', NULL, '07 Grasskamp Pass'),
(2, 'Simone', 'Cumberpatch', NULL, '10 Daystar Center'),
(3, 'Hatti', 'Messier', 'Ing.', '9 Straubel Hill'),
(4, 'Lancelot', 'Massimi', 'Mgr.', '66941 Westend Hill'),
(5, 'Lisha', 'McKendry', 'Ing.', '93 Amoth Park'),
(6, 'Estevan', 'Brandts', 'Mudr.', '3 Emmet Street'),
(7, 'Chariot', 'Viggers', 'Ing.', '579 Hazelcrest Alley'),
(8, 'Quincey', 'Hungerford', 'Mgr', '515 Muir Drive'),
(9, 'Georgianna', 'Devine', 'Bc.', '30 Judy Terrace'),
(10, 'Alonso', 'Smitherham', 'Ing.', '18540 Pine View Center'),
(11, 'Marcos', 'Churly', NULL, '59 Melody Junction'),
(12, 'Corissa', 'Pedroli', NULL, '46470 Upham Circle'),
(13, 'Helenelizabeth', 'Felkin', 'Ing.', '55301 Gerald Hill'),
(14, 'Paulie', 'Audas', 'Mudr.', '2579 Mendota Place'),
(15, 'Belvia', 'Bourthouloume', 'Ing.', '44338 Burrows Avenue'),
(16, 'Rodney', 'Esplin', 'Mgr', '33347 Corscot Place'),
(17, 'Christan', 'McLoney', 'Bc.', '87092 Jenna Plaza'),
(18, 'Kai', 'Oldacre', 'Ing.', '7 Burrows Parkway'),
(19, 'Junette', 'Mettricke', 'Mgr', '532 Quincy Way'),
(20, 'Ripley', 'McAlees', NULL, '49 East Avenue');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `Personal`
--

CREATE TABLE IF NOT EXISTS `Personal` (
  `Rodne_cislo` int(12) NOT NULL,
  `Meno` varchar(20) COLLATE latin2_czech_cs NOT NULL,
  `Priezvisko` varchar(30) COLLATE latin2_czech_cs NOT NULL,
  `Titul` varchar(15) COLLATE latin2_czech_cs DEFAULT NULL,
  `Adresa` varchar(30) COLLATE latin2_czech_cs NOT NULL,
  `Cislo_uctu` varchar(50) COLLATE latin2_czech_cs NOT NULL,
  `Hodinova_mzda` float NOT NULL,
  `Typ` varchar(10) COLLATE latin2_czech_cs NOT NULL,
  `ID_Sestry` int(11) DEFAULT NULL,
  `ID_Veterinara` int(11) DEFAULT NULL,
  PRIMARY KEY (`Rodne_cislo`),
  UNIQUE KEY `ID_Sestry` (`ID_Sestry`),
  UNIQUE KEY `ID_Veterinara` (`ID_Veterinara`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;

--
-- Sťahujem dáta pre tabuľku `Personal`
--

INSERT INTO `Personal` (`Rodne_cislo`, `Meno`, `Priezvisko`, `Titul`, `Adresa`, `Cislo_uctu`, `Hodinova_mzda`, `Typ`, `ID_Sestry`, `ID_Veterinara`) VALUES
(715424860, 'Evelyna', 'Dolman', 'Mudr.', '67 Tony Plaza', 'AT26 7071 4447 1787 1202', 119.58, 'veterinar', NULL, 4),
(720319942, 'Kain', 'Choat', 'Mudr.', '3 Pond Court', 'AT25 0248 9058 7960 4308', 133.32, 'veterinar', NULL, 2),
(805211504, 'Isidore', 'Johanssen', 'Mgr.', '27 Welch Street', 'GL85 5380 6030 8455 31', 157.64, 'sestra', 5, NULL),
(830208146, 'Remington', 'Duckfield', 'Mudr.', '72231 Cherokee Point', 'SI40 7548 7395 5223 051', 136.14, 'veterinar', NULL, 1),
(840228600, 'Ronalda', 'Purves', 'Bc.', '465 Trailsway Crossing', 'IL73 1186 7211 9958 4535 025', 160.8, 'sestra', 4, NULL),
(850904550, 'Gelya', 'McAviy', 'Bc.', '3061 Waywood Park', 'CH93 5621 1VWU LD5G IWD3 N', 158.98, 'sestra', 6, NULL),
(870106031, 'Ania', 'Pedley', 'Mudr.', '3475 West Plaza', 'DE38 9807 1743 5748 9779 27', 120.11, 'veterinar', NULL, 3),
(890110557, 'Noah', 'Springer', 'Bc.', '6498 Cordelia Alley', 'FR48 9973 3150 16ND Q0RU 3XY3 558', 120.43, 'sestra', 3, NULL),
(890909978, 'Prisca', 'Lord', 'Bc.', '012 Redwing Court', 'FR94 1777 2358 79EB DE2U JBVA M41', 170.16, 'sestra', 1, NULL),
(905312085, 'Britt', 'Ablott', 'Mudr.', '5826 5th Crossing', 'RO73 ZUJY ADPV 9HE6 6DWD 01UO', 133.28, 'sestra', 2, NULL);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `Podany_liek`
--

CREATE TABLE IF NOT EXISTS `Podany_liek` (
  `Rodne_cislo` int(11) NOT NULL,
  `ID_Lieku` int(11) NOT NULL,
  `ID_Liecby` int(11) NOT NULL,
  `Datum_podania` date NOT NULL,
  `Miesto_podania` varchar(30) COLLATE latin2_czech_cs NOT NULL,
  `Cas_podania` varchar(30) COLLATE latin2_czech_cs NOT NULL,
  KEY `ID_Lieku` (`ID_Lieku`),
  KEY `ID_Liecby` (`ID_Liecby`),
  KEY `Rodne_cislo` (`Rodne_cislo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;

--
-- Sťahujem dáta pre tabuľku `Podany_liek`
--

INSERT INTO `Podany_liek` (`Rodne_cislo`, `ID_Lieku`, `ID_Liecby`, `Datum_podania`, `Miesto_podania`, `Cas_podania`) VALUES
(890909978, 2, 2, '2017-11-18', 'Ordinácia', '21:49'),
(890909978, 3, 3, '2018-03-02', 'ARO', '8:58'),
(890909978, 4, 4, '2017-06-25', 'Operacny sal', '13:36'),
(890909978, 5, 5, '2017-05-08', 'Výjazd', '0:05'),
(905312085, 6, 6, '2017-05-09', 'Výjazd', '19:51'),
(905312085, 7, 7, '2017-06-22', 'Ordinácia', '4:32'),
(905312085, 8, 8, '2017-04-10', 'Ordinácia', '7:38'),
(905312085, 9, 9, '2017-09-12', 'Ordinácia', '11:50'),
(890909978, 1, 10, '2017-12-23', 'ARO', '7:04'),
(890110557, 2, 11, '2017-09-17', 'Ordinácia', '5:47'),
(890110557, 3, 12, '2017-10-20', 'ARO', '12:41'),
(890110557, 4, 13, '2018-01-30', 'Ordinácia', '12:29'),
(890909978, 5, 14, '2017-05-13', 'Ordinácia', '19:12'),
(830208146, 6, 15, '2017-10-08', 'Operacny sal', '3:50'),
(830208146, 7, 16, '2017-10-29', 'Ordinácia', '4:23'),
(870106031, 8, 17, '2017-07-11', 'Výjazd', '22:00'),
(870106031, 9, 18, '2017-11-12', 'Výjazd', '22:00'),
(720319942, 1, 19, '2018-03-15', 'ARO', '14:47'),
(850904550, 2, 20, '2017-09-28', 'ARO', '0:01'),
(850904550, 3, 21, '2017-08-02', 'Ordinácia', '0:41'),
(830208146, 4, 22, '2017-07-08', 'ARO', '14:23'),
(850904550, 5, 23, '2017-09-21', 'Operacny sal', '16:12'),
(805211504, 6, 24, '2017-09-08', 'Ordinácia', '13:42'),
(720319942, 7, 25, '2017-11-22', 'Ordinácia', '9:11'),
(870106031, 8, 26, '2017-06-04', 'Ordinácia', '2:02'),
(805211504, 9, 27, '2017-04-30', 'Ordinácia', '20:44'),
(720319942, 1, 28, '2017-12-26', 'Ordinácia', '23:18'),
(805211504, 2, 29, '2017-04-28', 'Ordinácia', '8:34'),
(805211504, 4, 2, '2018-02-17', 'Ordinácia', '4:56'),
(805211504, 5, 3, '2018-03-13', 'Ordinácia', '9:40'),
(830208146, 6, 4, '2017-06-01', 'Ordinácia', '6:37'),
(805211504, 7, 5, '2017-07-11', 'Ordinácia', '9:02'),
(805211504, 8, 6, '2017-04-16', 'Ordinácia', '2:47'),
(805211504, 9, 7, '2017-07-05', 'Ordinácia', '5:36'),
(805211504, 1, 8, '2018-03-27', 'Ordinácia', '1:20'),
(805211504, 2, 9, '2017-09-28', 'Ordinácia', '22:31'),
(805211504, 3, 10, '2017-04-15', 'Ordinácia', '19:24'),
(850904550, 4, 11, '2017-04-19', 'Ordinácia', '20:22'),
(850904550, 5, 12, '2017-12-28', 'Ordinácia', '5:48'),
(715424860, 1, 14, '2018-11-29', 'Ordinace', '13:56'),
(715424860, 1, 14, '2018-11-29', 'Ordinace', '13:56'),
(715424860, 8, 17, '2018-11-27', 'Ordinace', '12:00'),
(715424860, 8, 17, '2018-11-27', 'Ordinace', '12:00'),
(850904550, 9, 25, '2018-11-03', 'ordinace', '15:12'),
(715424860, 1, 24, '2018-11-18', 'Ordinace', '12:12'),
(805211504, 2, 24, '2018-04-10', 'Ordinace', '09:07'),
(805211504, 2, 3, '2018-11-19', 'ordinace', '09:00'),
(715424860, 1, 19, '2018-11-18', 'Ordinace', '00:12');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) COLLATE latin2_czech_cs NOT NULL,
  `password` varchar(64) COLLATE latin2_czech_cs NOT NULL,
  `role` varchar(10) COLLATE latin2_czech_cs NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=5 ;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'xbarte14', '3043e931073e63e4e67a765ae6c8a77fa93077b23b53034ab297db749d930f52', 'admin'),
(2, 'Doktor', '3043e931073e63e4e67a765ae6c8a77fa93077b23b53034ab297db749d930f52', 'doktor'),
(3, 'Sestra', '3043e931073e63e4e67a765ae6c8a77fa93077b23b53034ab297db749d930f52', 'sestra'),
(4, 'xbolsh00', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 'admin');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `Zviera`
--

CREATE TABLE IF NOT EXISTS `Zviera` (
  `ID_Zvierata` int(11) NOT NULL,
  `Meno` varchar(20) COLLATE latin2_czech_cs NOT NULL,
  `Datum_narodenia` date DEFAULT NULL,
  `Datum_poslednej_prehliadky` date NOT NULL,
  `ID_Majitela` int(11) NOT NULL,
  PRIMARY KEY (`ID_Zvierata`),
  UNIQUE KEY `ID_Zvierata` (`ID_Zvierata`),
  KEY `ID_Majitela` (`ID_Majitela`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs;

--
-- Sťahujem dáta pre tabuľku `Zviera`
--

INSERT INTO `Zviera` (`ID_Zvierata`, `Meno`, `Datum_narodenia`, `Datum_poslednej_prehliadky`, `ID_Majitela`) VALUES
(1, 'Carlina', '2009-10-20', '2001-09-20', 2),
(2, 'Charlean', '2016-04-04', '2017-04-08', 3),
(3, 'Elsie', '2012-07-07', '2017-07-23', 4),
(4, 'Alano', '2013-05-24', '2017-09-04', 5),
(5, 'Andriana', '2015-01-27', '2017-08-18', 6),
(6, 'Bessy', '2012-06-27', '2017-06-25', 7),
(7, 'Nicola', '2014-03-20', '2017-06-29', 8),
(8, 'Conway', '2017-02-17', '2017-10-21', 9),
(9, 'Jeanette', '2016-08-03', '2017-10-18', 10),
(10, 'Anne-marie', '2015-03-27', '2018-03-13', 11),
(11, 'Valerye', '2014-08-14', '2017-08-06', 12),
(12, 'Erina', '2015-01-18', '2017-11-13', 13),
(13, 'Brockie', '2016-09-09', '2017-11-17', 14),
(14, 'Herminia', '2015-08-20', '2017-10-17', 15),
(15, 'Querida', '2017-02-14', '0000-00-00', 16),
(16, 'Osmond', '2014-03-05', '2017-07-20', 17),
(17, 'Munmro', '2015-10-29', '2017-10-03', 18),
(18, 'Leighton', '2015-01-30', '0000-00-00', 19),
(19, 'HelloKitty', '2012-06-08', '2017-11-05', 20),
(20, 'Tallulah', '2015-12-31', '2017-07-28', 1),
(21, 'Nancie', '2013-05-23', '2017-08-28', 2),
(22, 'Anastasia', '2017-02-18', '2017-10-28', 3),
(23, 'Thelma', '2013-10-03', '2017-04-08', 4),
(24, 'Mariette', '2014-02-28', '2017-06-20', 5),
(25, 'Robie', '2013-10-01', '2017-11-12', 5);

--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `Liecba`
--
ALTER TABLE `Liecba`
  ADD CONSTRAINT `Liecba_ibfk_1` FOREIGN KEY (`ID_Zvierata`) REFERENCES `Zviera` (`ID_Zvierata`),
  ADD CONSTRAINT `Liecba_ibfk_2` FOREIGN KEY (`ID_Zvierata`) REFERENCES `Zviera` (`ID_Zvierata`),
  ADD CONSTRAINT `Liecba_ibfk_3` FOREIGN KEY (`ID_Zvierata`) REFERENCES `Zviera` (`ID_Zvierata`),
  ADD CONSTRAINT `Liecba_ibfk_4` FOREIGN KEY (`ID_Veterinara`) REFERENCES `Personal` (`ID_Veterinara`);

--
-- Obmedzenie pre tabuľku `Podany_liek`
--
ALTER TABLE `Podany_liek`
  ADD CONSTRAINT `Podany_liek_ibfk_1` FOREIGN KEY (`ID_Lieku`) REFERENCES `Liek` (`ID_Lieku`),
  ADD CONSTRAINT `Podany_liek_ibfk_2` FOREIGN KEY (`ID_Liecby`) REFERENCES `Liecba` (`ID_Liecby`),
  ADD CONSTRAINT `Podany_liek_ibfk_3` FOREIGN KEY (`Rodne_cislo`) REFERENCES `Personal` (`Rodne_cislo`);

--
-- Obmedzenie pre tabuľku `Zviera`
--
ALTER TABLE `Zviera`
  ADD CONSTRAINT `Zviera_ibfk_2` FOREIGN KEY (`ID_Majitela`) REFERENCES `Majitel` (`ID_Majitela`),
  ADD CONSTRAINT `Zviera_ibfk_4` FOREIGN KEY (`ID_Majitela`) REFERENCES `Majitel` (`ID_Majitela`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
