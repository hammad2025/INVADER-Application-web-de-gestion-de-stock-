<?php
// modules/fournisseurs/supprimer.php

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['id_fournisseur'])) {
            throw new Exception("ID fournisseur manquant");
        }

        $sql = "DELETE FROM fournisseurs WHERE id_fournisseur = :id_fournisseur";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(['id_fournisseur' => $_POST['id_fournisseur']]);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}