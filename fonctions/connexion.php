<?php
session_start();
echo session_id();
 $username = filter_input(INPUT_POST, 'username');
 $password = filter_input(INPUT_POST, 'password');

 try
{
	$bdd = new PDO('mysql:host=localhost;dbname=wot_bd;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$req = $bdd->prepare('SELECT mdp FROM user WHERE mail = :username;');
$req->execute(array(
    'username' => $username));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
if ( $password == $resultat['mdp']){
  session_start();
  $_SESSION['id'] = $username;
  header ('location: ../index.php');
}else{
  $_SESSION['id'] = 'ErrMDP';
  header ('location: ../login.php');
}
?>
