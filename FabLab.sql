-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 02, 2016 at 03:17 PM
-- Server version: 5.7.12
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `FabLab`
--

-- --------------------------------------------------------

--
-- Table structure for table `ACCES`
--

CREATE TABLE IF NOT EXISTS `ACCES` (
  `idAcces` int(11) NOT NULL AUTO_INCREMENT,
  `dateAcces` datetime NOT NULL,
  `idBadge` varchar(255) DEFAULT NULL,
  `idBadgeuse` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idAcces`),
  KEY `fk_ACCES_BADGE` (`idBadge`),
  KEY `fk_ACCES_BADGEUSE` (`idBadgeuse`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `ACCES`
--

INSERT INTO `ACCES` (`idAcces`, `dateAcces`, `idBadge`, `idBadgeuse`) VALUES
(13, '2016-05-27 16:33:35', '123456789', 'sloubi2'),
(14, '2016-05-27 16:33:58', '123456789', 'sloubi'),
(16, '2016-05-30 10:25:00', '2172071451', 'sloubi2'),
(17, '2016-05-30 11:24:54', '2172071451', 'sloubi2'),
(18, '2016-05-30 11:47:06', '2172071451', 'sloubi2'),
(19, '2016-05-30 11:48:15', '2172071451', 'sloubi2'),
(20, '2016-05-30 12:00:34', '2172071451', 'sloubi2'),
(21, '2016-05-30 13:59:33', '2172071451', 'sloubi2'),
(22, '2016-05-30 14:09:18', '2172071451', 'sloubi'),
(23, '2016-05-30 14:09:24', '2172071451', 'sloubi2'),
(24, '2016-05-30 14:13:05', '2172071451', 'sloubi'),
(25, '2016-05-30 14:13:18', '2172071451', 'sloubi2');

-- --------------------------------------------------------

--
-- Table structure for table `BADGES`
--

CREATE TABLE IF NOT EXISTS `BADGES` (
  `idBadge` varchar(255) NOT NULL DEFAULT '000000',
  `status` varchar(6) NOT NULL DEFAULT 'LOCK',
  PRIMARY KEY (`idBadge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `BADGES`
--

INSERT INTO `BADGES` (`idBadge`, `status`) VALUES
('12', 'LOCK'),
('12345678', 'UNLOCK'),
('123456789', 'LOCK'),
('2172071451', 'UNLOCK'),
('6664269', 'LOCK');

-- --------------------------------------------------------

--
-- Table structure for table `BADGEUSES`
--

CREATE TABLE IF NOT EXISTS `BADGEUSES` (
  `idBadgeuse` varchar(255) NOT NULL,
  PRIMARY KEY (`idBadgeuse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `BADGEUSES`
--

INSERT INTO `BADGEUSES` (`idBadgeuse`) VALUES
('sloubi'),
('sloubi2');

-- --------------------------------------------------------

--
-- Table structure for table `PERSONNES`
--

CREATE TABLE IF NOT EXISTS `PERSONNES` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `niveauAcces` int(11) DEFAULT NULL,
  `dateInscription` datetime NOT NULL,
  `idBadge` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`),
  UNIQUE KEY `uq_PERSONNES` (`idBadge`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `PERSONNES`
--

INSERT INTO `PERSONNES` (`idUtilisateur`, `prenom`, `nom`, `niveauAcces`, `dateInscription`, `idBadge`) VALUES
(1, 'François', 'Barc', NULL, '2016-05-13 12:15:58', '2172071451'),
(2, 'Cyril', 'Chesse', NULL, '2016-05-13 12:16:30', '6664269'),
(3, 'Victor', 'Lecoq', NULL, '2016-05-13 12:17:07', '123456789'),
(4, 'Julien', 'Rat', NULL, '2016-06-02 14:32:13', '12'),
(5, 'Quentin', 'Deyna', NULL, '2016-06-02 14:33:01', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ACCES`
--
ALTER TABLE `ACCES`
  ADD CONSTRAINT `fk_ACCES_BADGE` FOREIGN KEY (`idBadge`) REFERENCES `BADGES` (`idBadge`),
  ADD CONSTRAINT `fk_ACCES_BADGEUSE` FOREIGN KEY (`idBadgeuse`) REFERENCES `BADGEUSES` (`idBadgeuse`);

--
-- Constraints for table `PERSONNES`
--
ALTER TABLE `PERSONNES`
  ADD CONSTRAINT `fk_PERSONNES_BADGES` FOREIGN KEY (`idBadge`) REFERENCES `BADGES` (`idBadge`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
