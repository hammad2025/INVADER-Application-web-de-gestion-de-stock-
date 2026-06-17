
<div class="modal fade" id="editProduitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditProduit" action="modifier.php" method="POST" onsubmit="return false;">
                <input type="hidden" id="edit_id_produit" name="id_produit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_ref_produit" class="form-label">Référence</label>
                        <input type="text" class="form-control" id="edit_ref_produit" name="ref_produit" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nom_produit" class="form-label">Nom du produit</label>
                        <input type="text" class="form-control" id="edit_nom_produit" name="nom_produit" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_categorie_id" class="form-label">Catégorie</label>
                        <select class="form-select" id="edit_categorie_id" name="categorie_id" required>
                            <option value="">Sélectionner une catégorie</option>
                            <?php foreach($categories as $categorie): ?>
                                <option value="<?php echo $categorie['id_categorie']; ?>">
                                    <?php echo htmlspecialchars($categorie['nom_categorie']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_id_fournisseur" class="form-label">Fournisseur</label>
                        <select class="form-select" id="edit_id_fournisseur" name="id_fournisseur" required>
                            <option value="">Sélectionner un fournisseur</option>
                            <?php foreach($fournisseurs as $fournisseur): ?>
                                <option value="<?php echo $fournisseur['id_fournisseur']; ?>">
                                    <?php echo htmlspecialchars($fournisseur['nom_fournisseur']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_conditionnement" class="form-label">Conditionnement</label>
                        <input type="text" class="form-control" id="edit_conditionnement" name="conditionnement" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_seuil_critique" class="form-label">Seuil critique</label>
                        <input type="number" class="form-control" id="edit_seuil_critique" name="seuil_critique" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="edit_stock_max" class="form-label">Stock maximum</label>
                        <input type="number" class="form-control" id="edit_stock_max" name="stock_max" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="edit_quantite" class="form-label">Quantité</label>
                        <input type="number" class="form-control" id="edit_quantite" name="quantite" required min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>