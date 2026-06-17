<?php
// modules/fournisseurs/get_fournisseur.php

require_once '../../config/database.php';

if (isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM fournisseurs WHERE id_fournisseur = ?");
        $stmt->execute([$_GET['id']]);
        $fournisseur = $stmt->fetch();
        
        header('Content-Type: application/json');
        echo json_encode($fournisseur);
    } catch(PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
    }
}