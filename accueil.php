<!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>evenements Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
body {
    background-image: url("image/arriere_plan5.jpg"); /* change le nom si besoin */
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
<body class="container mt-5">

<?php
$c = mysqli_connect("localhost", "root", "", "reservation_bd");
if (!$c) {
    die("<div class='alert alert-danger'>Erreur de connexion : " . mysqli_connect_error() . "</div>");
}

session_start();

if (!isset($_SESSION['USER_ID'])) {
    die("<div class='alert alert-danger'>Erreur : utilisateur non connecte.</div>");
}

$user_id = $_SESSION['USER_ID'];
$nom = $_SESSION['NOM'];
$prenom = $_SESSION['PRENOM'];

$events_query = "SELECT ID, TITRE, DATE, PLACES_DISPONIBLES FROM events";
$events_result = mysqli_query($c, $events_query);

$reservations_query = "SELECT e.ID, e.TITRE, e.DATE 
                       FROM reservations r
                       JOIN events e ON r.EVENT_ID = e.ID
                       WHERE r.USER_ID = '$user_id'";

$reservations_result = mysqli_query($c, $reservations_query);
$reservations_exist = mysqli_num_rows($reservations_result) > 0;
?>

<!-- 🎉 Carrousel de festivites -->
<h2 class="text-center mb-4 text-white">🎉 Nos Festivités</h2>
<style>
.carousel-inner img {
  height: 300px;
  object-fit: cover;
  object-position: top;
}
</style>


<div id="carouselFestivites" class="carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner rounded">
    <div class="carousel-item active">
      <img src="image/festival.jpg" class="d-block w-100" alt="Festival 1">
    </div>
    <div class="carousel-item">
      <img src="image/festival2.jpg" class="d-block w-100" alt="Festival 2">
    </div>
    <div class="carousel-item">
      <img src="image/festival3.jpg" class="d-block w-100" alt="Festival 3">
    </div>
    <div class="carousel-item">
      <img src="image/festival4.jpg" class="d-block w-100" alt="Festival 4">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselFestivites" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselFestivites" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </button>
</div>

<!-- Tableau des evenements -->
<h2 class="text-center text-white">evenements Disponibles</h2>
<table class="table table-striped mt-4">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Date</th>
            <th>Places Disponibles</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($event = mysqli_fetch_assoc($events_result)) : ?>
            <tr>
                <td><?= htmlspecialchars($event['ID']) ?></td>
                <td><?= htmlspecialchars($event['TITRE']) ?></td>
                <td><?= htmlspecialchars($event['DATE']) ?></td>
                <td><?= htmlspecialchars($event['PLACES_DISPONIBLES']) ?></td>
                <td>
                    <a href="reserver.php?id=<?= $event['ID'] ?>" class="btn btn-success btn-sm">Réserver</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php if ($reservations_exist) : ?>
    <h2 class="text-center mt-5 text-white">Mes Reservations</h2>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($reservation = mysqli_fetch_assoc($reservations_result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['ID']) ?></td>
                    <td><?= htmlspecialchars($reservation['TITRE']) ?></td>
                    <td><?= htmlspecialchars($reservation['DATE']) ?></td>
                    <td>
                        <a href="annuler.php?id=<?= $reservation['ID'] ?>" class="btn btn-danger btn-sm">Annuler</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<?php endif; ?>

<a href="logout.php" class="btn btn-danger mt-3">Se déconnecter</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 