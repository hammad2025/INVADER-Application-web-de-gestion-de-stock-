<?php
require_once 'config/database.php';
include 'includes/header.php';

// Récupération des statistiques
try {
    $stats = [
        'produits' => $pdo->query("SELECT COUNT(*) FROM produits")->fetchColumn(),
        'critique' => $pdo->query("SELECT COUNT(*) FROM produits WHERE quantite <= seuil_critique")->fetchColumn(),
        'fournisseurs' => $pdo->query("SELECT COUNT(*) FROM fournisseurs")->fetchColumn(),
        'inventaires' => $pdo->query("SELECT COUNT(*) FROM inventaires")->fetchColumn()
    ];
} catch(PDOException $e) {
    $stats = ['produits' => 0, 'critique' => 0, 'fournisseurs' => 0, 'inventaires' => 0];
}
?>

<div class="hero-section mb-5">
    <div class="container">
        <h1 class="display-4 text-white">INVADER Bar</h1>
        <p class="lead text-white opacity-75">Système de gestion de stock</p>
    </div>
</div>

<div class="container">
    <!-- Statistiques -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <i class="fas fa-boxes fa-2x mb-3 text-emerald"></i>
                    <h3 class="card-title h5">Produits</h3>
                    <p class="card-text h2"><?php echo $stats['produits']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-3 text-warning"></i>
                    <h3 class="card-title h5">Stock Critique</h3>
                    <p class="card-text h2"><?php echo $stats['critique']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <i class="fas fa-truck fa-2x mb-3 text-emerald"></i>
                    <h3 class="card-title h5">Fournisseurs</h3>
                    <p class="card-text h2"><?php echo $stats['fournisseurs']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-2x mb-3 text-emerald"></i>
                    <h3 class="card-title h5">Inventaires</h3>
                    <p class="card-text h2"><?php echo $stats['inventaires']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-plus-circle me-2"></i>Nouvel Inventaire</h5>
                    <p class="card-text">Démarrer un nouvel inventaire du stock</p>
                    <a href="modules/inventaires/creer.php" class="btn btn-primary">Commencer</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-boxes me-2"></i>Gérer les Produits</h5>
                    <p class="card-text">Voir et modifier la liste des produits</p>
                    <a href="modules/produits/liste.php" class="btn btn-primary">Accéder</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>