<?php
// modules/categories/get_categorie.php
require_once '../../config/database.php';

if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id_categorie = ?");
        $stmt->execute([$_GET['id']]);
        $categorie = $stmt->fetch();
        
        header('Content-Type: application/json');
        echo json_encode($categorie);
    } catch(PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
    }
}