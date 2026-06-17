<?php
// modules/produits/liste.php

require_once '../../config/database.php';
include_once '../../includes/header.php';

// Récupération des produits avec leurs catégories
$sql = "SELECT p.*, c.nom_categorie, f.nom_fournisseur 
        FROM produits p 
        LEFT JOIN categories c ON p.categorie_id = c.id_categorie 
        LEFT JOIN fournisseurs f ON p.id_fournisseur = f.id_fournisseur 
        ORDER BY p.nom_produit";
try {
    $stmt = $pdo->query($sql);
    $produits = $stmt->fetchAll();
} catch(PDOException $e) {
    $produits = [];
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Liste des Produits</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutProduitModal">
            <i class="fas fa-plus me-2"></i>Ajouter un produit
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Stock</th>
                            <th>État</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($produits as $produit): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($produit['ref_produit']); ?></td>
                                <td><?php echo htmlspecialchars($produit['nom_produit']); ?></td>
                                <td><?php echo htmlspecialchars($produit['nom_categorie']); ?></td>
                                <td><?php echo $produit['quantite']; ?></td>
                                <td>
                                    <?php
                                    $stockStatus = '';
                                    if ($produit['quantite'] <= $produit['seuil_critique']) {
                                        $stockStatus = 'low';
                                    } elseif ($produit['quantite'] >= $produit['stock_max']) {
                                        $stockStatus = 'high';
                                    } else {
                                        $stockStatus = 'medium';
                                    }
                                    ?>
                                    <span class="stock-status stock-<?php echo $stockStatus; ?>"></span>
                                    <?php
                                    switch($stockStatus) {
                                        case 'low': echo 'Critique'; break;
                                        case 'medium': echo 'Normal'; break;
                                        case 'high': echo 'Élevé'; break;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary me-1" onclick="editProduit(<?php echo $produit['id_produit']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduit(<?php echo $produit['id_produit']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajout Produit -->
<?php include 'modal_ajout.php'; ?>

<!-- Modal Modification Produit -->
<?php include 'modal_edit.php'; ?>

<?php include '../../includes/footer.php'; ?>

<script>
function editProduit(id) {
    // Récupérer les données du produit
    fetch(`get_produit.php?id=${id}`)
        .then(response => response.json())
        .then(produit => {
            // Remplir le formulaire
            document.getElementById('edit_id_produit').value = produit.id_produit;
            document.getElementById('edit_ref_produit').value = produit.ref_produit;
            document.getElementById('edit_nom_produit').value = produit.nom_produit;
            document.getElementById('edit_categorie_id').value = produit.categorie_id;
            document.getElementById('edit_id_fournisseur').value = produit.id_fournisseur;
            document.getElementById('edit_conditionnement').value = produit.conditionnement;
            document.getElementById('edit_seuil_critique').value = produit.seuil_critique;
            document.getElementById('edit_stock_max').value = produit.stock_max;
            document.getElementById('edit_quantite').value = produit.quantite;
            
            // Ouvrir le modal
            new bootstrap.Modal(document.getElementById('editProduitModal')).show();
        })
        .catch(error => {
            alert('Erreur lors du chargement des données');
            console.error('Error:', error);
        });
}

function deleteProduit(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        fetch('supprimer.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id_produit=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Erreur lors de la suppression');
            }
        })
        .catch(error => {
            alert('Erreur lors de la suppression');
            console.error('Error:', error);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formEditProduit').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('modifier.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert(data.message || 'Erreur lors de la modification');
            }
        })
        .catch(error => {
            alert('Erreur lors de la modification');
            console.error('Error:', error);
        });
    });
});
</script>