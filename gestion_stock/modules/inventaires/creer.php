<?php
// modules/inventaires/creer.php

require_once '../../config/database.php';
include_once '../../includes/header.php';

// Récupérer tous les produits avec leur dernier inventaire
$sql = "SELECT p.*, c.nom_categorie,
        (SELECT quantite_inventaire 
         FROM produits_inventaire pi 
         WHERE pi.id_produit = p.id_produit 
         ORDER BY pi.date_inventaire DESC 
         LIMIT 1) as dernier_inventaire
        FROM produits p
        LEFT JOIN categories c ON p.categorie_id = c.id_categorie
        ORDER BY c.nom_categorie, p.nom_produit";

try {
    $produits = $pdo->query($sql)->fetchAll();
} catch(PDOException $e) {
    $produits = [];
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Nouvel Inventaire</h1>
        <a href="liste.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <form id="formInventaire" action="sauvegarder.php" method="POST">
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label for="responsable" class="form-label">Responsable</label>
                    <input type="text" class="form-control" id="responsable" name="responsable" required>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Catégorie</th>
                                <th>Produit</th>
                                <th>Conditionnement</th>
                                <th>Dernier inventaire</th>
                                <th>Nouvelle quantité</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $current_category = '';
                            foreach($produits as $produit): 
                                if($current_category != $produit['nom_categorie']):
                                    $current_category = $produit['nom_categorie'];
                            ?>
                                <tr class="table-secondary">
                                    <td colspan="5"><strong><?php echo htmlspecialchars($current_category); ?></strong></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td></td>
                                <td><?php echo htmlspecialchars($produit['nom_produit']); ?></td>
                                <td><?php echo htmlspecialchars($produit['conditionnement']); ?></td>
                                <td><?php echo $produit['dernier_inventaire'] ?? 'Aucun'; ?></td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" 
                                           name="quantites[<?php echo $produit['id_produit']; ?>]" 
                                           value="<?php echo $produit['dernier_inventaire'] ?? '0'; ?>" 
                                           min="0">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Sauvegarder l'inventaire
            </button>
        </div>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>