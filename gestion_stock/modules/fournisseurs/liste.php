<?php
// modules/fournisseurs/liste.php

require_once '../../config/database.php';
include_once '../../includes/header.php';

// Récupération des fournisseurs avec count des produits
$sql = "SELECT f.*, COUNT(p.id_produit) as nb_produits 
        FROM fournisseurs f 
        LEFT JOIN produits p ON f.id_fournisseur = p.id_fournisseur 
        GROUP BY f.id_fournisseur 
        ORDER BY f.nom_fournisseur";

try {
    $fournisseurs = $pdo->query($sql)->fetchAll();
} catch(PDOException $e) {
    $fournisseurs = [];
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Fournisseurs</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutFournisseurModal">
            <i class="fas fa-plus me-2"></i>Ajouter un fournisseur
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Nombre de produits</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
  <?php foreach($fournisseurs as $fournisseur): ?>
        <tr>
            <td><?php echo htmlspecialchars($fournisseur['nom_fournisseur']); ?></td>
            <td><?php echo htmlspecialchars($fournisseur['contact']); ?></td>
            <td><?php echo htmlspecialchars($fournisseur['email']); ?></td>
            <td><?php echo htmlspecialchars($fournisseur['adresse']); ?></td>
            <td><?php echo $fournisseur['nb_produits']; ?></td>
            <td>
                <button class="btn btn-sm btn-primary me-1" onclick="editFournisseur(<?php echo $fournisseur['id_fournisseur']; ?>)">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteFournisseur(<?php echo $fournisseur['id_fournisseur']; ?>)">
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
<div class="modal fade" id="ajoutFournisseurModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un fournisseur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formAjoutFournisseur" action="ajouter.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom_fournisseur" class="form-label">Nom du fournisseur</label>
                        <input type="text" class="form-control" id="nom_fournisseur" name="nom_fournisseur" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea class="form-control" id="adresse" name="adresse" rows="3"></textarea>
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
<div class="modal fade" id="editFournisseurModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le fournisseur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditFournisseur" action="modifier.php" method="POST" onsubmit="return false;">
                <input type="hidden" id="edit_id_fournisseur" name="id_fournisseur">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nom_fournisseur" class="form-label">Nom du fournisseur</label>
                        <input type="text" class="form-control" id="edit_nom_fournisseur" name="nom_fournisseur" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="edit_contact" name="contact">
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="edit_adresse" class="form-label">Adresse</label>
                        <textarea class="form-control" id="edit_adresse" name="adresse" rows="3"></textarea>
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
function editFournisseur(id) {
    fetch(`get_fournisseur.php?id=${id}`)
        .then(response => response.json())
        .then(fournisseur => {
            document.getElementById('edit_id_fournisseur').value = fournisseur.id_fournisseur;
            document.getElementById('edit_nom_fournisseur').value = fournisseur.nom_fournisseur;
            document.getElementById('edit_contact').value = fournisseur.contact;
            document.getElementById('edit_email').value = fournisseur.email;
            document.getElementById('edit_adresse').value = fournisseur.adresse;
            new bootstrap.Modal(document.getElementById('editFournisseurModal')).show();
        });
}

function deleteFournisseur(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')) {
        fetch('supprimer.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id_fournisseur=${id}`
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
    document.getElementById('formEditFournisseur').addEventListener('submit', function(e) {
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
    document.getElementById('formAjoutFournisseur').addEventListener('submit', function(e) {
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

function editFournisseur(id) {
    fetch(`get_fournisseur.php?id=${id}`)
        .then(response => response.json())
        .then(fournisseur => {
            document.getElementById('edit_id_fournisseur').value = fournisseur.id_fournisseur;
            document.getElementById('edit_nom_fournisseur').value = fournisseur.nom_fournisseur;
            document.getElementById('edit_contact').value = fournisseur.contact;
            document.getElementById('edit_email').value = fournisseur.email;
            document.getElementById('edit_adresse').value = fournisseur.adresse;
            new bootstrap.Modal(document.getElementById('editFournisseurModal')).show();
        });
}

</script>