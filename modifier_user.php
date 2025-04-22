
<?php
// Connexion a la base
$c = mysqli_connect("localhost", "root", "", "reservation_bd");
if (!$c) {
    die("Erreur de connexion a la base de donnees");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Recuperation les donnees de l'utilisateur
    $res = mysqli_query($c, "SELECT * FROM users WHERE ID = $id");
    $user = mysqli_fetch_assoc($res);

    if (!$user) {
        echo "Utilisateur non trouver.";
        exit();
    }
} else {
    echo "Aucun ID specifie.";
    exit();
}

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $update = mysqli_query($c, "UPDATE users SET NOM='$nom', PRENOM='$prenom', EMAIL='$email', ROLE='$role' WHERE ID = $id");

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
    <title>Modifier utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Modifier l'utilisateur</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($user['NOM']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($user['PRENOM']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['EMAIL']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Rôle</label>
            <select name="role" class="form-control">
                <option value="utilisateur" <?= $user['ROLE'] == 'utilisateur' ? 'selected' : '' ?>>Utilisateur</option>
                <option value="admin" <?= $user['ROLE'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
        <a href="admin.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>

</body>
</html>