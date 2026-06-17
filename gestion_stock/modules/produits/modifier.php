<?php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validation des données
        if (!isset($_POST['id_produit']) || empty($_POST['id_produit'])) {
            throw new Exception("ID du produit manquant");
        }

        // Préparer la requête
        $sql = "UPDATE produits SET 
                ref_produit = :ref_produit,
                nom_produit = :nom_produit,
                categorie_id = :categorie_id,
                id_fournisseur = :id_fournisseur,
                conditionnement = :conditionnement,
                seuil_critique = :seuil_critique,
                stock_max = :stock_max,
                quantite = :quantite
                WHERE id_produit = :id_produit";

        $stmt = $pdo->prepare($sql);
        
        // Exécuter la requête
        $result = $stmt->execute([
            'ref_produit' => $_POST['ref_produit'],
            'nom_produit' => $_POST['nom_produit'],
            'categorie_id' => $_POST['categorie_id'],
            'id_fournisseur' => $_POST['id_fournisseur'],
            'conditionnement' => $_POST['conditionnement'],
            'seuil_critique' => $_POST['seuil_critique'],
            'stock_max' => $_POST['stock_max'],
            'quantite' => $_POST['quantite'],
            'id_produit' => $_POST['id_produit']
        ]);

        // Réponse JSON pour AJAX
        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
        }

    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Si ce n'est pas une requête POST, redirection
header('Location: liste.php');
exit;