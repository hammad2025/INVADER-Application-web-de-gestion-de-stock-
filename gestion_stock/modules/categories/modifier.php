<?php
// modules/categories/modifier.php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['id_categorie']) || empty($_POST['nom_categorie'])) {
            throw new Exception("Données invalides");
        }

        $sql = "UPDATE categories SET nom_categorie = :nom_categorie WHERE id_categorie = :id_categorie";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'nom_categorie' => $_POST['nom_categorie'],
            'id_categorie' => $_POST['id_categorie']
        ]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}