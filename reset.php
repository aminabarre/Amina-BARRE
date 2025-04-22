<?php
session_start();
$c = mysqli_connect("localhost", "root", "", "reservation_bd");
$token = isset($_GET['token']) ? $_GET['token'] : '';
$erreur = "";
$succes = "";

// Vérifier si formulaire soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Vérifier que le token existe et est encore valide
    $sql = mysqli_query($c, "SELECT * FROM users WHERE reset_token='$token' AND reset_expire > NOW()");
    if (mysqli_num_rows($sql) > 0) {
        // Mettre à jour le mot de passe
        mysqli_query($c, "UPDATE users SET MOT_PASSE='$new_password', reset_token=NULL, reset_expire=NULL WHERE reset_token='$token'");
        $succes = "Mot de passe réinitialisé avec succès. <a href='connexion.php'>Se connecter</a>";
    } else {
        $erreur = "Lien invalide ou expiré.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialiser le mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Réinitialiser votre mot de passe</h2>

    <?php if ($erreur) echo "<div class='alert alert-danger'>$erreur</div>"; ?>
    <?php if ($succes) echo "<div class='alert alert-success'>$succes</div>"; ?>

    <?php if (!$succes): ?>
    <form method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="password" name="password" class="form-control mb-3" placeholder="Nouveau mot de passe" required>
        <button type="submit" class="btn btn-success">Changer le mot de passe</button>
    </form>
    <?php endif; ?>
</body>
</html>
