
<?php
// supprimer_user.php

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Connexion a la base de donnees
    $c = mysqli_connect("localhost", "root", "", "reservation_bd");

    if (!$c) {
        die("Erreur de connexion a la base de donnees");
    }

    // Supprimer l'utilisateur
    $supprimer = mysqli_query($c, "DELETE FROM users WHERE ID = $id");

    if ($supprimer) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }

    mysqli_close($c);
} else {
    echo "Aucun identifiant fourni.";
}
?>

</body>
</html>