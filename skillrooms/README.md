# 🎮 SkillRooms — Gestion de salles eSport

Application web réalisée dans le cadre d'un projet de **Licence 3 Informatique à l'UBO**.  
SkillRooms permet de gérer une plateforme de salles d'entraînement eSport avec des espaces distincts pour les **administrateurs** et les **membres**.

## ✨ Fonctionnalités

- Authentification et gestion de session
- Gestion des rôles administrateur / membre
- Consultation et modification du profil utilisateur
- Gestion des comptes par l'administrateur
- Gestion des salles eSport
- Consultation des réservations par date
- Prise en compte des indisponibilités des salles
- Formulaire de contact et suivi des messages
- Tableau de bord avec indicateurs principaux
- Liste des membres

## 🛠️ Technologies utilisées

- **PHP 8.1+**
- **CodeIgniter 4**
- **MySQL / MariaDB**
- **HTML5 / CSS3**
- **Bootstrap**
- **JavaScript**
- **Git**

## 🗂️ Structure principale

```text
app/
├── Config/          # Routes et configuration de l'application
├── Controllers/     # Contrôleurs HTTP
├── Models/          # Accès aux données
└── Views/           # Interfaces utilisateur
public/              # Point d'entrée et ressources publiques
database/schema.sql  # Schéma SQL public, sans données personnelles
docs/screenshots/    # Captures d'écran du projet
```

## 🚀 Installation locale

### Prérequis

- PHP 8.1 ou supérieur
- MySQL ou MariaDB
- Extensions PHP `intl` et `mbstring`

### 1. Cloner le projet

```bash
git clone https://github.com/ghassan-james/skillrooms.git
cd skillrooms
```

### 2. Configurer l'environnement

Dupliquez `.env.example` en `.env` puis adaptez les paramètres de connexion à votre base locale.

```bash
cp .env.example .env
```

Sous Windows, vous pouvez aussi simplement copier le fichier depuis l'explorateur.

### 3. Créer la base de données

Créez une base appelée `skillrooms`, puis importez :

```text
database/schema.sql
```

> Le dépôt public ne contient volontairement aucune donnée utilisateur issue de l'environnement de développement d'origine.

### 4. Lancer l'application

```bash
php spark serve
```

Puis ouvrez :

```text
http://localhost:8080
```

## 📸 Captures d'écran

Les captures de l'application seront ajoutées dans `docs/screenshots/`.

## 🔐 Sécurité et confidentialité

Les identifiants de base de données, fichiers `.env`, journaux, sessions et données utilisateurs de l'environnement d'origine ne sont pas versionnés dans ce dépôt.

## ⚠️ Projet académique

Ce projet a été réalisé dans un contexte pédagogique. Certaines parties peuvent encore être améliorées, notamment les tests automatisés et la séparation de certaines responsabilités applicatives. La version publique utilise `password_hash()` / `password_verify()` et des requêtes préparées pour les opérations d'authentification.

## 👤 Auteur

**Ghassan James**  
Licence Informatique — Université de Bretagne Occidentale (UBO)  
GitHub : [@ghassan-james](https://github.com/ghassan-james)
