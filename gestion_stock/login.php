<?php
session_start();
include 'config/database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        
        if ($user = $stmt->fetch()) {
            if (password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                header("Location: dashboard.php");
                exit();
            } else {
                $message = "Mot de passe incorrect";
            }
        } else {
            $message = "Email non trouvé";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-dark">
    <div class="login-container">
        <div class="card login-card">
            <div class="card-body">
                <h2 class="login-title">Connexion</h2>
                
                <?php if($message): ?>
                    <div class="alert alert-danger"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <form method="POST" class="login-form">
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control custom-input" id="email" name="email" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control custom-input" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary login-btn">Se connecter</button>
                    <div class="login-links mt-3 text-center">
                        <a href="register.php">Créer un compte</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>