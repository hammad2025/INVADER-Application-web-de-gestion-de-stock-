<?php
// modules/fournisseurs/ajouter.php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['nom_fournisseur']) || empty($_POST['nom_fournisseur'])) {
            throw new Exception("Le nom du fournisseur est requis");
        }

        $sql = "INSERT INTO fournisseurs (nom_fournisseur, contact, email, adresse) 
                VALUES (:nom_fournisseur, :contact, :email, :adresse)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom_fournisseur' => $_POST['nom_fournisseur'],
            'contact' => $_POST['contact'],
            'email' => $_POST['email'],
            'adresse' => $_POST['adresse']
        ]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}