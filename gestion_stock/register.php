<?php
session_start();
include 'config/database.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (!empty($nom) && !empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (nom, email, mot_de_passe, role) VALUES (?, ?, ?, 'user')";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$nom, $email, $hashed_password]);
            $message = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
        } catch(PDOException $e) {
            $message = "Erreur: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Création de compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Création de compte</h2>
        <?php if($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom complet</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Créer un compte</button>
            <a href="login.php" class="btn btn-link">Déjà un compte ? Connectez-vous</a>
        </form>
    </div>
</body>
</html>