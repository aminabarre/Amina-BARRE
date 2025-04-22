<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuler Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php
    session_start();
    $c =mysqli_connect("localhost","root","","reservation_bd");
    if(!$c){
        die("<div class='alert alert-danger'>Erreur de connexion : " . mysqli_connect_error() . "</div>");

    }
    // Verifier si l'utilisateur est connecter
if (!isset($_SESSION['NOM']) || !isset($_SESSION['PRENOM'])) {
    die("<div class='alert alert-danger'>Acces refuser.</div>");
}
    // Verifier si un ID d'evenement est fourni
if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>Aucun evenement specifie.</div>");
}

$event_id = intval($_GET['id']);
$nom = $_SESSION['NOM'];
$prenom = $_SESSION['PRENOM'];
// Recuperer l'ID de l'utilisateur
$user_query = "SELECT ID FROM users WHERE NOM = '$nom' AND PRENOM = '$prenom'";
$user_result = mysqli_query($c, $user_query);
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['ID'];
// Vreifier si l'utilisateur a bien reserve cet evenement
$check_query = "SELECT * FROM reservations WHERE USER_ID = '$user_id' AND EVENT_ID = '$event_id'";
$check_result = mysqli_query($c, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    echo "<div class='alert alert-warning'>Vous n'avez pas reserve cet evenement.</div>";
} else {
     // Supprimer la reservation
     $delete_query = "DELETE FROM reservations WHERE USER_ID = '$user_id' AND EVENT_ID = '$event_id'";
    
     if (mysqli_query($c, $delete_query)) {
         // Mettre a jour le nombre de places disponibles
         $update_places_query = "UPDATE events SET PLACES_DISPONIBLES = PLACES_DISPONIBLES + 1 WHERE ID = '$event_id'";
         mysqli_query($c, $update_places_query);
 
         echo "<script>alert('Reservation annuler avec succes.'); window.location='accueil.php';</script>";
     } else {
         echo "<div class='alert alert-danger'>Erreur lors de l'annulation.</div>";
     }
 }
 mysqli_close($c);
?>
</body>
</html>