-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gestion_stock;
USE gestion_stock;

-- ========================================
-- Table : categories
-- ========================================
CREATE TABLE categories (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100) NOT NULL UNIQUE
);

-- ========================================
-- Table : fournisseurs
-- ========================================
CREATE TABLE fournisseurs (
    id_fournisseur INT AUTO_INCREMENT PRIMARY KEY,
    nom_fournisseur VARCHAR(100) NOT NULL UNIQUE,
    contact VARCHAR(50),
    email VARCHAR(100),
    adresse TEXT
);

-- ========================================
-- Table : produits
-- ========================================
CREATE TABLE produits (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    ref_produit VARCHAR(50) UNIQUE,
    nom_produit VARCHAR(100) NOT NULL,
    categorie_id INT DEFAULT NULL,
    conditionnement VARCHAR(50),
    seuil_critique INT DEFAULT 0,
    stock_max INT DEFAULT 0,
    quantite INT DEFAULT 0,
    id_fournisseur INT NOT NULL,
    date_expiration DATE,
    FOREIGN KEY (categorie_id) REFERENCES categories(id_categorie) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (id_fournisseur) REFERENCES fournisseurs(id_fournisseur) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ========================================
-- Table : inventaires
-- ========================================
CREATE TABLE inventaires (
    id_inventaire INT AUTO_INCREMENT PRIMARY KEY,
    date_inventaire DATE NOT NULL,
    responsable VARCHAR(100) NOT NULL,
    nb_produits INT DEFAULT 0,
    nb_commandes INT DEFAULT 0
);

-- ========================================
-- Table : produits_inventaire
-- ========================================
CREATE TABLE produits_inventaire (
    id_inventaire INT,
    id_produit INT,
    quantite_inventaire INT NOT NULL,
    date_inventaire DATE NOT NULL,
    FOREIGN KEY (id_inventaire) REFERENCES inventaires(id_inventaire) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES produits(id_produit) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (id_inventaire, id_produit)
);

-- ========================================
-- Données de test
-- ========================================
INSERT INTO categories (nom_categorie) VALUES 
('Sodas'),
('Jus de fruits'),
('Eaux'),
('Boissons énergisantes'),
('Sirops');

INSERT INTO fournisseurs (nom_fournisseur, contact, email, adresse) VALUES 
('Coca-Cola Distribution', 'Jean Martin', 'contact@coca-cola.fr', '123 rue des Livreurs'),
('PepsiCo France', 'Marie Dubois', 'contact@pepsico.fr', '456 avenue des Fournisseurs'),
('Nestlé Waters', 'Pierre Durant', 'contact@nestle-waters.fr', '789 boulevard des Distributeurs');

INSERT INTO produits (ref_produit, nom_produit, categorie_id, conditionnement, seuil_critique, stock_max, quantite, id_fournisseur, date_expiration) VALUES 
('S001', 'Coca-Cola 33cl', 1, 'Pack 24', 5, 50, 25, 1, '2025-12-31'),
('S002', 'Fanta Orange 33cl', 1, 'Pack 24', 5, 40, 20, 1, '2025-12-31'),
('J001', 'Minute Maid Orange', 2, 'Bouteille 1L', 3, 30, 15, 1, '2025-06-30'),
('E001', 'Evian', 3, 'Pack 6x1.5L', 4, 35, 22, 3, '2025-12-31'),
('SI001', 'Sirop Monin Grenadine', 5, 'Bouteille 1L', 2, 15, 8, 2, '2025-12-31');

INSERT INTO inventaires (date_inventaire, responsable, nb_produits, nb_commandes) VALUES 
('2024-03-15', 'Admin', 5, 1);

INSERT INTO produits_inventaire (id_inventaire, id_produit, quantite_inventaire, date_inventaire) VALUES 
(1, 1, 25, '2024-03-15'),
(1, 2, 20, '2024-03-15'),
(1, 3, 15, '2024-03-15'),
(1, 4, 22, '2024-03-15'),
(1, 5, 8, '2024-03-15');