<?php
session_start();

if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] !== 'admin') {
    header("Location: connexion.php");
    exit();
}

$c = mysqli_connect("localhost", "root", "", "reservation_bd");
if (!$c) {
    die("Erreur de connexion  la base de donnees.");
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Recuperation de l'evenement
    $result = mysqli_query($c, "SELECT * FROM events WHERE id = $id");
    $event = mysqli_fetch_assoc($result);

    if (!$event) {
        echo "Evenement introuvable.";
        exit();
    }
} else {
    echo "ID manquant.";
    exit();
}

// Mise a jour apres soumission
if (isset($_POST['modifier'])) {
    $titre = mysqli_real_escape_string($c, $_POST['titre']);
    $date = mysqli_real_escape_string($c, $_POST['date']);
    $places = (int)$_POST['places'];

    $update = mysqli_query($c, "UPDATE events SET titre='$titre', date='$date', places_disponibles=$places WHERE id=$id");

    if ($update) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Erreur lors de la mise a jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Evenement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Modifier un Evenement</h2>
    <form method="post" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="titre" value="<?= $event['TITRE'] ?>" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="date" name="date" value="<?= $event['DATE'] ?>" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="number" name="places" value="<?= $event['PLACES_DISPONIBLES'] ?>" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" name="modifier" class="btn btn-success">Enregistrer</button>
            <a href="admin.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</body>
</html>
