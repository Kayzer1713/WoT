<?php
$username = filter_input(INPUT_POST, 'username');
$nom = filter_input(INPUT_POST, 'nom');
$prenom = filter_input(INPUT_POST, 'prenom');
$password = filter_input(INPUT_POST, 'password');
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "wot_bd";
// connexion à la bd
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
if (mysqli_connect_error()){
die('Connect Error ('. mysqli_connect_errno() .') '
. mysqli_connect_error());
}
else{
// création et envoi de la requete
$sql = "INSERT INTO user (mail, nom, prenom, mdp)
values ('$username','$nom','$prenom','$password')";
if ($conn->query($sql)){
  $_SESSION['connecte'] = 'OK';
  header ('location: ../index.html');
}
else{
  $_SESSION['conecte'] = 'NO';
echo "Erreur: ". $sql ."
". $conn->error;
}
$conn->close();
}
?>
