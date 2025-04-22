<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deconnexion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container text-center mt-5">

    <h2>Deconnexion en cours...</h2>

    <?php
    session_start();
    session_destroy();
    header("Refresh: 2; url=connexion.php"); // Redirige apres 2 secondes vers connexion.php
    ?>

    <p>Vous allez etre redirige vers la page de connexion.</p>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
