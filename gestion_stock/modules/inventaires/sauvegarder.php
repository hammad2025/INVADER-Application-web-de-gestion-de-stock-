<?php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['responsable']) || empty($_POST['responsable'])) {
            throw new Exception("Le responsable est requis");
        }
        
        if (!isset($_POST['quantites']) || !is_array($_POST['quantites'])) {
            throw new Exception("Aucune quantité saisie");
        }

        $pdo->beginTransaction();

        // Créer l'inventaire
        $sql = "INSERT INTO inventaires (date_inventaire, responsable, nb_produits, nb_commandes) 
                VALUES (NOW(), :responsable, :nb_produits, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'responsable' => $_POST['responsable'],
            'nb_produits' => count($_POST['quantites'])
        ]);
        
        $id_inventaire = $pdo->lastInsertId();
        $nb_commandes = 0;

        // Insérer les quantités et mettre à jour les produits
        foreach ($_POST['quantites'] as $id_produit => $quantite) {
            // Insérer dans produits_inventaire
            $sql = "INSERT INTO produits_inventaire (id_inventaire, id_produit, quantite_inventaire, date_inventaire) 
                    VALUES (:id_inventaire, :id_produit, :quantite, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id_inventaire' => $id_inventaire,
                'id_produit' => $id_produit,
                'quantite' => $quantite
            ]);

            // Mettre à jour la quantité du produit
            $sql = "UPDATE produits SET quantite = :quantite WHERE id_produit = :id_produit";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'quantite' => $quantite,
                'id_produit' => $id_produit
            ]);

            // Vérifier si le produit est en état critique
            $sql = "SELECT seuil_critique FROM produits WHERE id_produit = :id_produit";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id_produit' => $id_produit]);
            $produit = $stmt->fetch();
            
            if ($quantite <= $produit['seuil_critique']) {
                $nb_commandes++;
            }
        }

        // Mettre à jour le nombre de produits à commander
        $sql = "UPDATE inventaires SET nb_commandes = :nb_commandes WHERE id_inventaire = :id_inventaire";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nb_commandes' => $nb_commandes,
            'id_inventaire' => $id_inventaire
        ]);

        $pdo->commit();
        header('Location: liste.php?success=create');
        
    } catch (Exception $e) {
        $pdo->rollBack();
        header('Location: creer.php?error=' . urlencode($e->getMessage()));
    }
    exit;
}

header('Location: liste.php');
exit;