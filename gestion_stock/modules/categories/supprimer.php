<?php
// modules/categories/supprimer.php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['id_categorie'])) {
            throw new Exception("ID catégorie manquant");
        }

        $sql = "DELETE FROM categories WHERE id_categorie = :id_categorie";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(['id_categorie' => $_POST['id_categorie']]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}