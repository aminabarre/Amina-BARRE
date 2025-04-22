<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
body {
    background-image: url("image/arriere_plan1.jpg"); /* change le nom si besoin */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
body::before {
    content: "";
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.4); /* assombrit le fond */
    z-index: -1;
}

</style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Connexion</h2>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="mot_de_passe" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                    </form>
                </div>
            </div>
            <p class="mt-3 text-center">
                Pas encore inscrit ? <a href="registre.php">S'inscrire.</a>
                ou
                <a href="motdepasse_oublie.php">Mot de passe oublié ?</a>
            </p>
        </div>
    </div>
</div>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c = mysqli_connect("localhost", "root", "", "reservation_bd");

    if (!$c) {
        die("<div class='alert alert-danger text-center'>Erreur de connexion a la base de donnees.</div>");
    }

    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    $email = mysqli_real_escape_string($c, $email);

    //Inclure le champ ROLE pour definir le role de chaque utilisateur
    $stmt = mysqli_prepare($c, "SELECT ID, NOM, PRENOM, MOT_PASSE, ROLE FROM users WHERE EMAIL = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id, $nom, $prenom, $mot_passe_hash, $role);
        $user_found = mysqli_stmt_fetch($stmt);

        if ($user_found && password_verify($mot_de_passe, $mot_passe_hash)) {
            // Stocker les infos dans la session
            $_SESSION['USER_ID'] = $user_id;
            $_SESSION['NOM'] = $nom;
            $_SESSION['PRENOM'] = $prenom;
            $_SESSION['EMAIL'] = $email;
            $_SESSION['ROLE'] = $role;

            echo "<div class='alert alert-success text-center'>Connexion reussie ! Redirection...</div>";

            //  Redirection selon le role de l'utilisateur
            if ($role === 'admin') {
                header("refresh:2;url=admin.php");
            } else {
                header("refresh:2;url=accueil.php");
            }
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Compte inexistant.</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger text-center'>Erreur de requete.</div>";
    }

    mysqli_close($c);
}
?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
