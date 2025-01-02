# Plateforme Immobilière - Site de Vente de Maisons

Ce projet est une application web complète conçue pour simuler une plateforme immobilière axée sur la vente de maisons. Il intègre le développement front-end et back-end, offrant un environnement interactif, dynamique et convivial permettant aux utilisateurs d'explorer les annonces, de s'inscrire, de se connecter et de gérer leurs achats.

## 🔗 Démo :
Une démo du projet est accessible via ce lien : [Lien Google Drive](https://drive.google.com/drive/folders/1yj4KFNEJiML35OApqRxVfAqwzFtxpT5R?usp=drive_link) accompagnée d'un test d'optimisation Google Lighthouse.

## Base de Données
La base de données, nommée **miniprojet**, comprend les tables suivantes :

```sql
CREATE TABLE items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    seller_contact VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (item_id) REFERENCES items(id)
);
```

## Fonctionnalités :

### • Développement Frontend
**HTML, CSS, JavaScript** :
- Un site multi-pages responsive, incluant une page d'accueil et des pages dédiées aux annonces immobilières.
- Intégration d'un formulaire d'inscription et de connexion avec validation JavaScript.
- Convertisseur de devises interactif pour afficher les prix des propriétés dans différentes monnaies.

### • Développement Backend
**PHP avec l’architecture MVC** :
- Gestion des utilisateurs : ajouter, supprimer, ou modifier leurs informations.
- Gestion des annonces : ajouter ou supprimer des biens immobiliers.
- Système de panier : permet d’ajouter des articles au panier et de les gérer.

