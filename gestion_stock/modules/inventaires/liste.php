<?php
// modules/inventaires/liste.php

require_once '../../config/database.php';
include_once '../../includes/header.php';

// Récupération des inventaires avec détails
$sql = "SELECT i.* 
        FROM inventaires i 
        ORDER BY i.date_inventaire DESC";

try {
    $inventaires = $pdo->query($sql)->fetchAll();
} catch(PDOException $e) {
    $inventaires = [];
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Inventaires</h1>
        <a href="creer.php" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvel inventaire
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Responsable</th>
                            <th>Nb Produits</th>
                            <th>Produits critiques</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($inventaires as $inventaire): ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($inventaire['date_inventaire'])); ?></td>
                                <td><?php echo htmlspecialchars($inventaire['responsable']); ?></td>
                                <td><?php echo $inventaire['nb_produits']; ?></td>
                                <td><?php echo $inventaire['nb_commandes']; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info me-1" onclick="showDetails(<?php echo $inventaire['id_inventaire']; ?>)">
                                        <i class="fas fa-eye"></i>
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

<!-- Modal Détails -->
<div class="modal fade" id="detailsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de l'inventaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailsContent">
                <!-- Contenu chargé dynamiquement -->
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

<script>
function showDetails(id) {
    fetch(`get_details.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            let content = `
                <h6>Date: ${data.date_inventaire}</h6>
                <h6>Responsable: ${data.responsable}</h6>
                <hr>
                <h6>Produits inventoriés:</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>`;
            
            data.produits.forEach(p => {
                content += `
                    <tr>
                        <td>${p.nom_produit}</td>
                        <td>${p.quantite_inventaire}</td>
                        <td>
                            <span class="stock-status stock-${p.status}"></span>
                            ${p.status === 'low' ? 'Critique' : p.status === 'medium' ? 'Normal' : 'Élevé'}
                        </td>
                    </tr>`;
            });
            
            content += `</tbody></table>`;
            document.getElementById('detailsContent').innerHTML = content;
            new bootstrap.Modal(document.getElementById('detailsModal')).show();
        });
}
</script>