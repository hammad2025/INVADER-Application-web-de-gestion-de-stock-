<?php
// modules/categories/liste.php

require_once '../../config/database.php';
include_once '../../includes/header.php';

// Récupération des catégories avec count des produits
$sql = "SELECT c.*, COUNT(p.id_produit) as nb_produits 
        FROM categories c 
        LEFT JOIN produits p ON c.id_categorie = p.categorie_id 
        GROUP BY c.id_categorie 
        ORDER BY c.nom_categorie";

try {
    $categories = $pdo->query($sql)->fetchAll();
} catch(PDOException $e) {
    $categories = [];
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Catégories</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutCategorieModal">
            <i class="fas fa-plus me-2"></i>Ajouter une catégorie
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Nombre de produits</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $categorie): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($categorie['nom_categorie']); ?></td>
                                <td><?php echo $categorie['nb_produits']; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary me-1" onclick="editCategorie(<?php echo $categorie['id_categorie']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteCategorie(<?php echo $categorie['id_categorie']; ?>)">
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

<!-- Modal Ajout -->
<div class="modal fade" id="ajoutCategorieModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formAjoutCategorie" action="ajouter.php" method="POST" onsubmit="return false;">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom_categorie" class="form-label">Nom de la catégorie</label>
                        <input type="text" class="form-control" id="nom_categorie" name="nom_categorie" required>
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


<!-- Modal Edition -->
<div class="modal fade" id="editCategorieModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditCategorie" action="modifier.php" method="POST" onsubmit="return false;">
                <input type="hidden" id="edit_id_categorie" name="id_categorie">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nom_categorie" class="form-label">Nom de la catégorie</label>
                        <input type="text" class="form-control" id="edit_nom_categorie" name="nom_categorie" required>
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

<?php include '../../includes/footer.php'; ?>


<script>
function editCategorie(id) {
    fetch(`get_categorie.php?id=${id}`)
        .then(response => response.json())
        .then(categorie => {
            document.getElementById('edit_id_categorie').value = categorie.id_categorie;
            document.getElementById('edit_nom_categorie').value = categorie.nom_categorie;
            new bootstrap.Modal(document.getElementById('editCategorieModal')).show();
        });
}

function deleteCategorie(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
        fetch('supprimer.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id_categorie=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) location.reload();
            else alert(data.message || 'Erreur lors de la suppression');
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire pour le formulaire d'édition
    document.getElementById('formEditCategorie').addEventListener('submit', function(e) {
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

    // Gestionnaire pour le formulaire d'ajout
    document.getElementById('formAjoutCategorie').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('ajouter.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert(data.message || 'Erreur lors de l\'ajout');
            }
        })
        .catch(error => {
            alert('Erreur lors de l\'ajout');
            console.error('Error:', error);
        });
    });
});
</script>