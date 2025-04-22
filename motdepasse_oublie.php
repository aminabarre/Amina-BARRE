<?php
session_start();
$c = mysqli_connect("localhost", "root", "", "reservation_bd"); // adapte ce nom

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($c, $_POST['email']);

    $sql = mysqli_query($c, "SELECT * FROM users WHERE EMAIL = '$email'");
    if (mysqli_num_rows($sql) > 0) {
        // Générer un token unique
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $expiration = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Stocker dans une table temporaire (ou ajouter des colonnes dans `users`)
        mysqli_query($c, "UPDATE users SET reset_token='$token', reset_expire='$expiration' WHERE EMAIL='$email'");

        // Créer le lien de réinitialisation
        $lien = "http://localhost/projet_php/reset.php?token=$token";

        // Ici, tu peux envoyer le mail (ou afficher le lien pour test)
        echo "<div class='alert alert-success'>Lien de reinitialisation : <a href='$lien'>$lien</a></div>";
    } else {
        $erreur = "Email non trouver.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mot de passe oublie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Mot de passe oublie</h2>
    <?php if ($erreur) echo "<div class='alert alert-danger'>$erreur</div>"; ?>
    <form method="post">
        <input type="email" name="email" class="form-control mb-3" placeholder="Votre adresse email" required>
        <button type="submit" class="btn btn-primary">Reinitialiser</button>
    </form>
</body>
</html>
