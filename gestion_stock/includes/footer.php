<footer class="footer mt-auto py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>INVADER </h5>
                    <p class="text-muted">Système de gestion de stock professionnel</p>
                </div>
                <div class="col-md-4 text-center">
                    <h5>Navigation Rapide</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $baseUrl; ?>/modules/produits/liste.php">Produits</a></li>
                        <li><a href="<?php echo $baseUrl; ?>/modules/categories/liste.php">Catégories</a></li>
                        <li><a href="<?php echo $baseUrl; ?>/modules/inventaires/liste.php">Inventaires</a></li>
                    </ul>
                </div>
                <div class="col-md-4 text-end">
                    <h5>Contact</h5>
                    <p class="text-muted">
                        <i class="fas fa-envelope me-2"></i>contact@invader.fr<br>
                        <i class="fas fa-phone me-2"></i>01 23 45 67 89
                    </p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <small class="text-muted">&copy; <?php echo date('Y'); ?> INVADER  - Tous droits réservés</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseUrl; ?>/assets/js/scripts.js"></script>
</body>
</html>