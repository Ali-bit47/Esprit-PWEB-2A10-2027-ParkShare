# ParkShare – Smart Parking Economy

## Overview

Ce projet a été réalisé dans le cadre du module PWEB – 2ème année du cycle ingénieur à **Esprit School of Engineering** (Année universitaire 2026–2027).

ParkShare est une plateforme web intelligente qui connecte propriétaires, entreprises et automobilistes en Tunisie pour **louer les places de parking inutilisées**.

**Problématique :** à Tunis, il y a trop de voitures pour trop peu de places. Le centre-ville compte environ 10 700 places de stationnement structuré, et la capitale environ 32 000 places au maximum (source : La Presse de Tunisie, 12 janvier 2026), alors que de nombreux garages, cours et parkings d'entreprise restent vides une partie de la journée. Comment valoriser les places de parking privées inutilisées tout en facilitant le stationnement des automobilistes ?

**Objectifs :**

- Mettre en relation propriétaires, entreprises et automobilistes
- Permettre la recherche et la réservation en ligne d'une place
- Recommander les meilleures places grâce à l'IA
- Générer un revenu à partir des places inutilisées

## Features

- **Recherche géolocalisée** et carte interactive des places autour de l'automobiliste
- **Réservation en ligne** avec vérification de disponibilité et confirmation immédiate
- **Paiement sécurisé** en dinars, avec factures et historique
- **Recommandation par IA** : classement des places selon la localisation, le prix et la durée
- **Espace propriétaire** : annonces, tarifs, disponibilités et suivi des revenus
- **Avis et favoris** sur les parkings
- **Notifications et réclamations**
- **Gestion des véhicules** de l'automobiliste
- **Back office** : validation des annonces, traitement des réclamations, modération des avis et statistiques

## Tech Stack

### Frontend

- HTML5
- CSS3
- Leaflet et OpenStreetMap (cartographie)

### Backend

- Django REST Framework
- PostgreSQL et PostGIS

## Architecture

L'application suit une **architecture modulaire en cinq modules**, en plus du module Gestion des utilisateurs réalisé en commun par les cinq membres.

| Membre | Module | Entités |
|---|---|---|
| Tous ensemble | Gestion des utilisateurs | Utilisateur |
| Ali Lajnef | Parkings et places | Parking, PlaceParking |
| Malek Lassoued | Réservations et disponibilités | Reservation, Disponibilite |
| Amenallah Belgesmi | Paiements et véhicules | Paiement, Vehicule |
| Elyes Hajji | Avis et favoris | Avis, Favori |
| Omar Ben Ammar | Notifications et réclamations | Notification, Reclamation |

**11 entités** au total, dont 1 commune et 10 réparties (deux par membre). Principales relations :

- Parking 1–N PlaceParking
- Disponibilite 1–N Reservation
- Vehicule 1–N Paiement
- Reclamation 1–N Notification

**Acteurs :** Visiteur, Utilisateur, Propriétaire, Automobiliste, Administrateur et Passerelle de paiement (acteur externe).

**Interfaces :**

- **Front Office** : accueil avec recherche par lieu, date et durée, places recommandées par l'IA, carte interactive avec les prix en dinars, réservation en un clic.
- **Back Office** : tableau de bord d'administration avec menu latéral par module, indicateurs clés et graphiques.

**Charte graphique :** Sable `#F6F3F0`, Corail `#E8623D`, Anthracite `#26323A`, Blanc cassé `#FFFDFB` ; typographies Space Grotesk (titres) et Inter (textes).

## Contributors

- [Ali Lajnef](https://github.com/utilisateur1) – Module Parkings et places (Parking, PlaceParking)
- [Malek Lassoued](https://github.com/utilisateur2) – Module Réservations et disponibilités (Reservation, Disponibilite)
- [Amenallah Belgesmi](https://github.com/utilisateur3) – Module Paiements et véhicules (Paiement, Vehicule)
- [Elyes Hajji](https://github.com/utilisateur4) – Module Avis et favoris (Avis, Favori)
- [Omar Ben Ammar](https://github.com/utilisateur5) – Module Notifications et réclamations (Notification, Reclamation)

Le module Gestion des utilisateurs (entité Utilisateur) est réalisé en commun par les cinq membres.

## Academic Context

Développé à **Esprit School of Engineering – Tunisie**

PWEB – 2A10 | 2026–2027

**Objectifs de développement durable (ODD) visés :**

- ODD 8 : Travail décent et croissance économique (revenus complémentaires pour les propriétaires et les entreprises)
- ODD 9 : Industrie, innovation et infrastructure (IA et géolocalisation pour mieux exploiter les parkings existants)
- ODD 11 : Villes et communautés durables (moins de voitures qui tournent, espace urbain mieux utilisé)
- ODD 13 : Lutte contre les changements climatiques (moins de trajets de recherche, donc moins d'émissions de CO2)

## Getting Started

### Prérequis

- [Git](https://git-scm.com/)
- [Python](https://www.python.org/) 3.10 ou supérieur
- [PostgreSQL](https://www.postgresql.org/) avec l'extension [PostGIS](https://postgis.net/)

### Installation

1. Clonez le repository :

```bash
git clone https://github.com/<votre-utilisateur>/Esprit-PWEB-2A10-2027-ParkShare.git
cd Esprit-PWEB-2A10-2027-ParkShare
```

2. Installez le backend (Django REST Framework) :

```bash
cd backend
python -m venv venv
source venv/bin/activate        # Windows : venv\Scripts\activate
pip install -r requirements.txt
```

3. Créez la base de données PostgreSQL avec PostGIS :

```sql
CREATE DATABASE parkshare;
\c parkshare
CREATE EXTENSION postgis;
```

4. Configurez la connexion à la base de données dans le fichier `.env` du backend (adaptez le nom du fichier et les valeurs) :

```
DB_NAME=parkshare
DB_USER=postgres
DB_PASSWORD=votre_mot_de_passe
DB_HOST=localhost
DB_PORT=5432
```

5. Appliquez les migrations et lancez le serveur :

```bash
python manage.py migrate
python manage.py createsuperuser
python manage.py runserver
```

6. Lancez le frontend (HTML et CSS) : ouvrez le fichier `frontend/index.html` dans votre navigateur, ou utilisez l'extension **Live Server** de VS Code (clic droit sur `index.html`, puis *Open with Live Server*).

7. Accédez à l'application :

- Frontend : `http://127.0.0.1:5500` avec Live Server (ou directement le fichier `index.html`)
- API Django : `http://localhost:8000`

## Acknowledgments

Nous remercions nos encadrants et l'ensemble de l'équipe pédagogique de **Esprit School of Engineering** pour leur accompagnement et leur soutien tout au long de ce projet.
