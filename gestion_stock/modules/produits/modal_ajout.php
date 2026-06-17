<!-- modules/produits/modal_ajout.php -->
<div class="modal fade" id="ajoutProduitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formAjoutProduit" action="ajouter.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ref_produit" class="form-label">Référence</label>
                        <input type="text" class="form-control" id="ref_produit" name="ref_produit" required>
                    </div>
                    <div class="mb-3">
                        <label for="nom_produit" class="form-label">Nom du produit</label>
                        <input type="text" class="form-control" id="nom_produit" name="nom_produit" required>
                    </div>
                    <div class="mb-3">
                        <label for="categorie_id" class="form-label">Catégorie</label>
                        <select class="form-select" id="categorie_id" name="categorie_id" required>
                            <option value="">Sélectionner une catégorie</option>
                            <?php
                            $categories = $pdo->query("SELECT * FROM categories ORDER BY nom_categorie")->fetchAll();
                            foreach($categories as $categorie) {
                                echo "<option value='" . $categorie['id_categorie'] . "'>" . htmlspecialchars($categorie['nom_categorie']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_fournisseur" class="form-label">Fournisseur</label>
                        <select class="form-select" id="id_fournisseur" name="id_fournisseur" required>
                            <option value="">Sélectionner un fournisseur</option>
                            <?php
                            $fournisseurs = $pdo->query("SELECT * FROM fournisseurs ORDER BY nom_fournisseur")->fetchAll();
                            foreach($fournisseurs as $fournisseur) {
                                echo "<option value='" . $fournisseur['id_fournisseur'] . "'>" . htmlspecialchars($fournisseur['nom_fournisseur']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="conditionnement" class="form-label">Conditionnement</label>
                        <input type="text" class="form-control" id="conditionnement" name="conditionnement" required>
                    </div>
                    <div class="mb-3">
                        <label for="seuil_critique" class="form-label">Seuil critique</label>
                        <input type="number" class="form-control" id="seuil_critique" name="seuil_critique" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="stock_max" class="form-label">Stock maximum</label>
                        <input type="number" class="form-control" id="stock_max" name="stock_max" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité initiale</label>
                        <input type="number" class="form-control" id="quantite" name="quantite" required min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>