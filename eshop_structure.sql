-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.4.3 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de table eshop. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `idcat` int NOT NULL AUTO_INCREMENT,
  `nomcat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idcat`),
  UNIQUE KEY `nomcat` (`nomcat`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table eshop. commande
CREATE TABLE IF NOT EXISTS `commande` (
  `idCom` int NOT NULL AUTO_INCREMENT,
  `montant_com` decimal(10,2) NOT NULL,
  `adresse_livraison` varchar(255) NOT NULL,
  `statut_com` enum('en attente','payée','expédiée','livrée','annulée') NOT NULL DEFAULT 'en attente',
  `mode_paiement` varchar(255) DEFAULT NULL,
  `frais_livraison` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `date_com` datetime DEFAULT CURRENT_TIMESTAMP,
  `idcli` int NOT NULL,
  PRIMARY KEY (`idCom`),
  KEY `fkcli` (`idcli`),
  CONSTRAINT `fkcli` FOREIGN KEY (`idcli`) REFERENCES `utilisateur` (`idU`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table eshop. commande_produit
CREATE TABLE IF NOT EXISTS `commande_produit` (
  `idCom_prod` int NOT NULL AUTO_INCREMENT,
  `quantite` int NOT NULL,
  `prix_unitaire` decimal(10,2) DEFAULT NULL,
  `idcom` int NOT NULL,
  `idprod` int NOT NULL,
  PRIMARY KEY (`idCom_prod`),
  KEY `fkcom` (`idcom`),
  KEY `fkprod` (`idprod`),
  CONSTRAINT `fkcom` FOREIGN KEY (`idcom`) REFERENCES `commande` (`idCom`),
  CONSTRAINT `fkprod` FOREIGN KEY (`idprod`) REFERENCES `produits` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table eshop. panier
CREATE TABLE IF NOT EXISTS `panier` (
  `idcli` int NOT NULL,
  `idProduit` int NOT NULL,
  `quantite` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idcli`,`idProduit`),
  KEY `idProduit` (`idProduit`),
  CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`idcli`) REFERENCES `utilisateur` (`idU`),
  CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `produits` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table eshop. produits
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int DEFAULT NULL,
  `id_cat` int DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_produit_cat` (`id_cat`),
  CONSTRAINT `fk_produit_cat` FOREIGN KEY (`id_cat`) REFERENCES `categorie` (`idcat`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table eshop. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idU` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(60) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `email` varchar(80) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `date_crea` datetime NOT NULL DEFAULT (now()),
  PRIMARY KEY (`idU`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
