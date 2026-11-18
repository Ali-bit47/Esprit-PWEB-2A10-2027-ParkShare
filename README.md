# ParkShare – Smart Parking Economy

## Overview

Ce projet a été réalisé dans le cadre du module PWEB – 2ème année du cycle ingénieur à **Esprit School of Engineering** (Année universitaire 2026–2027).

ParkShare est une plateforme web intelligente qui connecte propriétaires, entreprises et automobilistes en Tunisie pour **louer les places de parking inutilisées**.

**Problématique :** à Tunis, il y a trop de voitures pour trop peu de places. Le centre-ville compte environ 10 700 places de stationnement structuré, et la capitale environ 32 000 places au maximum (source : La Presse de Tunisie, 12 janvier 2026), alors que de nombreux garages, cours et parkings d'entreprise restent vides une partie de la journée. Comment valoriser les places de parking privées inutilisées tout en facilitant le stationnement des automobilistes ?

**Objectifs :**
- Mettre en relation propriétaires, entreprises et automobilistes
- Permettre la recherche et la réservation en ligne d'une place
- Recommander les meilleures places grâce à un système intelligent
- Générer un revenu à partir des places inutilisées

## Features

- **Recherche géolocalisée** et carte interactive des places autour de l'automobiliste
- **Réservation en ligne** avec vérification de disponibilité et confirmation
- **Paiement** en dinars, avec factures et historique
- **Recommandation intelligente** : classement des places selon la localisation, le prix et la durée
- **Espace propriétaire** : annonces, tarifs, disponibilités et suivi des revenus
- **Avis et favoris** sur les parkings
- **Notifications et réclamations**
- **Gestion des véhicules** de l'automobiliste
- **Back office** : validation des annonces, traitement des réclamations, modération des avis et statistiques

## Tech Stack

### Frontend
- HTML5
- CSS3
- JavaScript
- Leaflet
- OpenStreetMap

### Backend
- PHP
- PHP Orienté Objet (POO)

### Database
- MySQL
- phpMyAdmin (gestion de la base de données)

## Architecture

L'application est développée selon une architecture modulaire en cinq modules, en plus du module Gestion des utilisateurs réalisé en commun par les cinq membres.

| Membre | Module | Entités |
|---|---|---|
| Tous ensemble | Gestion des utilisateurs | Utilisateur |
| Ali Lajnef | Parkings et places | Parking, PlaceParking |
| Malek Lassoued | Réservations et disponibilités | Reservation, Disponibilite |
| Amenallah Belgesmi | Paiements et véhicules | Paiement, Vehicule |
| Elyes Hajji | Avis et favoris | Avis, Favori |
| Omar Ben Ammar | Notifications et réclamations | Notification, Reclamation |

**11 entités** au total, dont 1 commune et 10 réparties (deux par membre).

Principales relations :
- Parking 1–N PlaceParking
- Disponibilite 1–N Reservation
- Vehicule 1–N Paiement
- Reclamation 1–N Notification

**Acteurs :** Visiteur, Utilisateur, Propriétaire, Automobiliste, Administrateur et Passerelle de paiement (acteur externe).

### Interfaces

- **Front Office** : accueil avec recherche par lieu, date et durée, places recommandées, carte interactive avec les prix en dinars, réservation en un clic.
- **Back Office** : tableau de bord d'administration avec menu latéral par module, indicateurs clés et graphiques.

**Charte graphique :** Sable `#F6F3F0`, Corail `#E8623D`, Anthracite `#26323A`, Blanc cassé `#FFFDFB` ; typographies Space Grotesk (titres) et Inter (textes).

## Contributors

- Ali Lajnef – Module Parkings et places (Parking, PlaceParking)
- Malek Lassoued – Module Réservations et disponibilités (Reservation, Disponibilite)
- Amenallah Belgesmi – Module Paiements et véhicules (Paiement, Vehicule)
- Elyes Hajji – Module Avis et favoris (Avis, Favori)
- Omar Ben Ammar – Module Notifications et réclamations (Notification, Reclamation)

Le module Gestion des utilisateurs (entité Utilisateur) est réalisé en commun par les cinq membres.

## Academic Context

Développé à **Esprit School of Engineering – Tunisie**

PWEB – 2A10 | 2026–2027

**Objectifs de développement durable (ODD) visés :**

- ODD 8 : Travail décent et croissance économique (revenus complémentaires pour les propriétaires et les entreprises)
- ODD 9 : Industrie, innovation et infrastructure (technologies intelligentes pour mieux exploiter les parkings existants)
- ODD 11 : Villes et communautés durables (moins de voitures qui tournent, espace urbain mieux utilisé)
- ODD 13 : Lutte contre les changements climatiques (moins de trajets de recherche, donc moins d'émissions de CO2)

## Getting Started

### Prérequis

- Git
- PHP 8.0 ou supérieur
- MySQL
- phpMyAdmin
- Un navigateur web moderne
- VS Code (recommandé)
- XAMPP (recommandé pour Apache et MySQL)

### Installation

1. Clonez le repository :

```bash
git clone https://github.com/Ali-bit47/Esprit-PWEB-2A10-2027-ParkShare.git
cd Esprit-PWEB-2A10-2027-ParkShare
```

2. Configurez l'environnement local avec XAMPP :

- Installez XAMPP
- Démarrez Apache et MySQL
- Placez le projet dans le dossier `htdocs`

3. Créez la base de données :

- Accédez à phpMyAdmin via `http://localhost/phpmyadmin`
- Créez une base de données nommée `parkshare`
- Importez le fichier SQL du projet, si disponible

4. Configurez la connexion à la base de données dans votre fichier de configuration PHP :

```php
<?php

class Database
{
    private $host = "localhost";
    private $dbname = "parkshare";
    private $username = "root";
    private $password = "";

    private $connection;

    public function connect()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->connection;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
```

5. Lancez le projet :

- Démarrez Apache et MySQL depuis XAMPP
- Accédez au projet depuis votre navigateur :

```text
http://localhost/Esprit-PWEB-2A10-2027-ParkShare/
```

## Acknowledgments

Nous remercions nos encadrants et l'ensemble de l'équipe pédagogique de **Esprit School of Engineering** pour leur accompagnement et leur soutien tout au long de ce projet.
