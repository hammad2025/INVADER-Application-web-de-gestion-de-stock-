<?php
require_once '../../config/database.php';

if (isset($_GET['id'])) {
    try {
        // Récupérer les informations de l'inventaire
        $stmt = $pdo->prepare("
            SELECT i.*, pi.quantite_inventaire, p.nom_produit, p.seuil_critique, p.stock_max
            FROM inventaires i
            JOIN produits_inventaire pi ON i.id_inventaire = pi.id_inventaire
            JOIN produits p ON pi.id_produit = p.id_produit
            WHERE i.id_inventaire = ?
        ");
        $stmt->execute([$_GET['id']]);
        
        $resultats = $stmt->fetchAll();
        
        if (count($resultats) > 0) {
            $inventaire = [
                'date_inventaire' => date('d/m/Y', strtotime($resultats[0]['date_inventaire'])),
                'responsable' => $resultats[0]['responsable'],
                'produits' => []
            ];
            
            foreach ($resultats as $row) {
                $status = 'medium';
                if ($row['quantite_inventaire'] <= $row['seuil_critique']) {
                    $status = 'low';
                } elseif ($row['quantite_inventaire'] >= $row['stock_max']) {
                    $status = 'high';
                }
                
                $inventaire['produits'][] = [
                    'nom_produit' => $row['nom_produit'],
                    'quantite_inventaire' => $row['quantite_inventaire'],
                    'status' => $status
                ];
            }
            
            header('Content-Type: application/json');
            echo json_encode($inventaire);
        }
    } catch(PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
    }
}