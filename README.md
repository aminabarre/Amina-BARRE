# 🎫 Projet : Application de Gestion de Mini Réservation

Ce projet est une mini application web développée en PHP, qui permet aux utilisateurs de s’inscrire, de se connecter, de consulter des événements, et de réserver une place pour y participer.

## 🧰 Fonctions principales

- ✅ Inscription et connexion des utilisateurs
- 📅 Affichage des événements disponibles
- 📝 Réservation d’événements
- 🔐 Espace admin pour la gestion des événements et des utilisateurs
- 📄 Génération de fichier PDF (extrait de naissance par exemple)
- 👀 Interface avec Bootstrap

## 🗃️ Structure de la base de données

- **User** : stocke les informations des utilisateurs (nom, email, mot de passe…)
- **Events** : stocke les événements (titre, date, description, places disponibles…)
- **Reservation** : gère les réservations (utilisateur, événement, date de réservation)

## 🛠️ Technologies utilisées

- HTML / CSS
- PHP (procédural et début d’orienté objet)
- MySQL
- Bootstrap 5

## 📂 Arborescence du projet
/projet-mini-reservation
│
├── index.php
├── register.php
├── connexion.php
├── events.php
├── admin.php
├── admi.php
├── connaissances.php
├── includes/
│ └── db.php
├── assets/
│ └── style.css
└── README.md

