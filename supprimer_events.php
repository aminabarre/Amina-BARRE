<?php
session_start();

if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] !== 'admin') {
    header("Location: connexion.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $c = mysqli_connect("localhost", "root", "", "reservation_bd");
    if (!$c) {
        die("Erreur de connexion a la base de donnees.");
    }

    // Supprimer les reservations associees d'abord
    mysqli_query($c, "DELETE FROM reservation WHERE id_even = $id");

    // Puis supprimer l'evenement
    $delete = mysqli_query($c, "DELETE FROM events WHERE id = $id");

    if ($delete) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    echo "ID manquant.";
}
?>
