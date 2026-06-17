<?php
// modules/produits/ajouter.php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validation des données
        $required_fields = ['ref_produit', 'nom_produit', 'categorie_id', 
                          'id_fournisseur', 'conditionnement', 'seuil_critique', 
                          'stock_max', 'quantite'];
        
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                throw new Exception("Le champ $field est requis");
            }
        }

        // Insertion du produit
        $sql = "INSERT INTO produits (ref_produit, nom_produit, categorie_id, id_fournisseur, 
                                    conditionnement, seuil_critique, stock_max, quantite) 
                VALUES (:ref_produit, :nom_produit, :categorie_id, :id_fournisseur, 
                        :conditionnement, :seuil_critique, :stock_max, :quantite)";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'ref_produit' => $_POST['ref_produit'],
            'nom_produit' => $_POST['nom_produit'],
            'categorie_id' => $_POST['categorie_id'],
            'id_fournisseur' => $_POST['id_fournisseur'],
            'conditionnement' => $_POST['conditionnement'],
            'seuil_critique' => $_POST['seuil_critique'],
            'stock_max' => $_POST['stock_max'],
            'quantite' => $_POST['quantite']
        ]);

        header('Location: liste.php?success=create');
        exit;

    } catch (Exception $e) {
        header('Location: liste.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}

header('Location: liste.php');
exit;