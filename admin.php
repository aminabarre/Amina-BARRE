<?php
session_start();

// Verification que l'utilisateur est admin
if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}

// Connexion a la base de donnees
$c = mysqli_connect("localhost", "root", "", "reservation_bd");
if (!$c) {
    die("Erreur de connexion a la base de donnees.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
body {
    background-image: url("image/arriere_plan2.jpg"); /* change le nom si besoin */
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
    <h1 class="text-center">Espace Administrateur</h1>

    <ul class="nav nav-tabs mt-4" id="adminTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#utilisateurs">Utilisateurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#evenements">Evenements</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <!-- Table des Utilisateurs -->
        <div class="tab-pane fade show active" id="utilisateurs">
            <?php
            $users = mysqli_query($c, "SELECT ID, NOM, PRENOM, EMAIL, ROLE FROM users");

            if (mysqli_num_rows($users) > 0) {
                echo '<table class="table table-bordered table-striped">';
                echo '<thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>';

                while ($u = mysqli_fetch_assoc($users)) {
                    echo "<tr>
                            <td>{$u['ID']}</td>
                            <td>{$u['NOM']}</td>
                            <td>{$u['PRENOM']}</td>
                            <td>{$u['EMAIL']}</td>
                            <td>{$u['ROLE']}</td>
                            <td>
                                <a href='modifier_user.php?id={$u['ID']}' class='btn btn-sm btn-warning'>Modifier</a>
                                <a href='supprimer_user.php?id={$u['ID']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Supprimer cet utilisateur ?')\">Supprimer</a>
                            </td>
                          </tr>";
                }

                echo '</tbody></table>';
            } else {
                echo "<div class='alert alert-info text-center'>Aucun utilisateur trouvze.</div>";
            }
            ?>
        </div>

        <!-- Table des Evenements -->
        <div class="tab-pane fade" id="evenements">
            <?php
            if (isset($_POST['ajouter_event'])) {
                $titre = mysqli_real_escape_string($c, $_POST['titre']);
                $date = mysqli_real_escape_string($c, $_POST['date']);
                $places = (int)$_POST['places'];

                if ($titre && $date && $places > 0) {
                    $insert = mysqli_query($c, "INSERT INTO events (titre, date, places_disponibles) VALUES ('$titre', '$date', $places)");
                    if ($insert) {
                        echo "<div class='alert alert-success'>Evenement ajouter avec succes.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Erreur lors de l'ajout de l'evenement.</div>";
                    }
                } else {
                    echo "<div class='alert alert-warning'>Tous les champs sont obligatoires.</div>";
                }
            }
            ?>

            <h4>Ajouter un evenement</h4>
            <form method="post" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="titre" class="form-control" placeholder="Titre" required>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="places" class="form-control" placeholder="Places disponibles" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="ajouter_event" class="btn btn-primary w-100">Ajouter</button>
                </div>
            </form>

            <?php
            $events = mysqli_query($c, "SELECT * FROM events");

            if (mysqli_num_rows($events) > 0) {
                echo '<table class="table table-bordered table-striped">';
                echo '<thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Places disponibles</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>';

                while ($e = mysqli_fetch_assoc($events)) {
                    echo "<tr>
                            <td>{$e['id']}</td>
                            <td>{$e['TITRE']}</td>
                            <td>{$e['DATE']}</td>
                            <td>{$e['PLACES_DISPONIBLES']}</td>
                            <td>
                                <a href='modifier_events.php?id={$e['id']}' class='btn btn-sm btn-warning'>Modifier</a>
                                <a href='supprimer_events.php?id={$e['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Supprimer cet événement ?')\">Supprimer</a>
                            </td>
                          </tr>";
                }

                echo '</tbody></table>';
            } else {
                echo "<div class='alert alert-info text-center'>Aucun evenement trouver.</div>";
            }
            ?>
        </div>
</div> <!-- Fin de container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
