<?php
// modules/categories/ajouter.php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['nom_categorie']) || empty($_POST['nom_categorie'])) {
            throw new Exception("Le nom de la catégorie est requis");
        }

        $sql = "INSERT INTO categories (nom_categorie) VALUES (:nom_categorie)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(['nom_categorie' => $_POST['nom_categorie']]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

header('Location: liste.php');
exit;