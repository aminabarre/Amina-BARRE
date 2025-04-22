<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
body {
    background-image: url("image/arriere_plan.jpg"); /* change le nom si besoin */
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
  <div class="contenu container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h2>ESPACE D'INSCRIPTION</h2>
                </div>
                <div class="card-body">
                    <form method="POST" onsubmit="return validerEmail()">
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prenom</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required oninput="verifierEmail()">
                            <small id="emailErreur" class="text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="mot_passe" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                    </form>
                </div>
            </div>
            <p class="mt-3 text-center text-white">
                Deja inscrit ? <a href="connexion.php">Se connecter</a>
            </p>
        </div>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $mot_passe = password_hash($_POST['mot_passe'], PASSWORD_DEFAULT);

    // Connexion a la base de donnees
    $c = mysqli_connect("localhost", "root", "", "reservation_bd");

    if (!$c) {
        die("<div class='alert alert-danger text-center'>Erreur de connexion a la base de donnees</div>");
    }

    // Verification si l'email existe deja
    $check = mysqli_query($c, "SELECT * FROM users WHERE EMAIL='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<div class='alert alert-warning text-center'>Cet email est deja utilise.</div>";
    } else {
        // Insertion des donnees
        $r = mysqli_query($c, "INSERT INTO users (NOM, PRENOM, EMAIL, MOT_PASSE, ROLE) VALUES ('$nom', '$prenom', '$email', '$mot_passe', 'user')");
 
        if ($r) {
            echo "<div class='alert alert-success text-center'>Inscription reussie ! Redirection...</div>";
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "connexion.php";
                    }, 2000);
                  </script>';
            exit(); // Stopper l'execution du script
        } else {
            echo "<div class='alert alert-danger text-center'>Erreur lors de l'inscription.</div>";
        }
    }
    mysqli_close($c);
}
?>

<script>
function verifierEmail() {
    let email = document.getElementById("email").value;
    let emailErreur = document.getElementById("emailErreur");

    // Verifie si l'email se termine bien par "@gmail.com"
    if (!email.endsWith("@gmail.com")) {
        emailErreur.textContent = "L'email doit se terminer par @gmail.com.";
    } else {
        emailErreur.textContent = "";
    }
}

function validerEmail() {
    let email = document.getElementById("email").value;
    if (!email.endsWith("@gmail.com")) {
        alert("L'email doit se terminer par @gmail.com.");
        return false;
    }
    return true;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
