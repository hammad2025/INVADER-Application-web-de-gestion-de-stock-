<?php
// modules/fournisseurs/modifier.php

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['id_fournisseur']) || empty($_POST['nom_fournisseur'])) {
            throw new Exception("Données invalides");
        }

        $sql = "UPDATE fournisseurs SET 
                nom_fournisseur = :nom_fournisseur,
                contact = :contact,
                email = :email,
                adresse = :adresse 
                WHERE id_fournisseur = :id_fournisseur";
                
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'nom_fournisseur' => $_POST['nom_fournisseur'],
            'contact' => $_POST['contact'],
            'email' => $_POST['email'],
            'adresse' => $_POST['adresse'],
            'id_fournisseur' => $_POST['id_fournisseur']
        ]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}