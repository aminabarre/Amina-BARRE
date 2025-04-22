<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Connexion a la base de donnees
$c = mysqli_connect("localhost", "root", "", "reservation_bd");

if (!$c) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

session_start();
$user_id = $_SESSION['USER_ID'];  // le stockage de l'ID en session
$event_id = $_GET['id'];  // Recupere l'ID de l'evenement a reserver

// Verification s'il reste des places disponibles
$check_places_query = "SELECT PLACES_DISPONIBLES FROM events WHERE ID = '$event_id'";
$check_places_result = mysqli_query($c, $check_places_query);
$event = mysqli_fetch_assoc($check_places_result);

if ($event['PLACES_DISPONIBLES'] > 0) {
    // Inserer la reservation
    $insert_reservation_query = "INSERT INTO reservations (USER_ID, EVENT_ID, DATE_RESERVATION) VALUES ('$user_id', '$event_id', NOW())";
    mysqli_query($c, $insert_reservation_query);

    // Mettre a jour le nombre de places disponibles (-1)
    $update_places_query = "UPDATE events SET PLACES_DISPONIBLES = PLACES_DISPONIBLES - 1 WHERE ID = '$event_id'";
    mysqli_query($c, $update_places_query);

    echo "<script>alert('Reservation effectuee avec succes!'); window.location.href='accueil.php';</script>";
} else {
    echo "<script>alert('Desole, il n\'y a plus de places disponibles pour cet evenement.'); window.location.href='accueil.php';</script>";
}

mysqli_close($c);
?>

 
</body>
</html>