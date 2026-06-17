<?php
// modules/produits/supprimer.php

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validation de l'ID
        if (!isset($_POST['id_produit']) || empty($_POST['id_produit'])) {
            throw new Exception("ID du produit manquant");
        }

        // Préparer et exécuter la requête
        $sql = "DELETE FROM produits WHERE id_produit = :id_produit";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(['id_produit' => $_POST['id_produit']]);

        // Réponse JSON
        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
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