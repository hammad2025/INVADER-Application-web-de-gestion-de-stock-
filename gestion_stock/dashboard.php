<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';

// Récupérer les statistiques
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

<div class="container mt-4">
    <h1 class="page-title">Tableau de bord</h1>
    
    <!-- Statistiques -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <i class="fas fa-boxes fa-2x mb-3 text-emerald"></i>
                    <h3 class="h5">Produits</h3>
                    <p class="h2"><?php echo $stats['produits']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-3 text-warning"></i>
                    <h3 class="h5">Stock Critique</h3>
                    <p class="h2"><?php echo $stats['critique']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <i class="fas fa-truck fa-2x mb-3 text-emerald"></i>
                    <h3 class="h5">Fournisseurs</h3>
                    <p class="h2"><?php echo $stats['fournisseurs']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-2x mb-3 text-emerald"></i>
                    <h3 class="h5">Inventaires</h3>
                    <p class="h2"><?php echo $stats['inventaires']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-boxes me-2"></i>Produits</h5>
                    <p class="card-text">Gérer les produits en stock</p>
                    <a href="<?php echo $baseUrl; ?>/modules/produits/liste.php" class="btn btn-primary">Accéder</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-clipboard-list me-2"></i>Inventaires</h5>
                    <p class="card-text">Gérer les inventaires</p>
                    <a href="<?php echo $baseUrl; ?>/modules/inventaires/liste.php" class="btn btn-primary">Accéder</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-truck me-2"></i>Fournisseurs</h5>
                    <p class="card-text">Gérer les fournisseurs</p>
                    <a href="<?php echo $baseUrl; ?>/modules/fournisseurs/liste.php" class="btn btn-primary">Accéder</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>