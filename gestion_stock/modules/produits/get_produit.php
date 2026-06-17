<?php
// modules/produits/get_produit.php
require_once '../../config/database.php';

if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produit = ?");
        $stmt->execute([$_GET['id']]);
        $produit = $stmt->fetch();
        
        header('Content-Type: application/json');
        echo json_encode($produit);
    } catch(PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
    }
}