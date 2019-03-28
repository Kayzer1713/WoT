#!/usr/bin/php -q
<?php

// Execution en ligne de commande : php -q <nomdufichier>.php

// Inclusion de la librairie phpwebsocket
require "websocket.class.php";

// Extension de WebSocket
class Wot extends WebSocket {
  function process($user,$msg) {
    $form= json_decode($msg);
    $this->say($msg);

    $linkBd = connexionBdd();
    if($msg == "addAction"){

        $sql = "SELECT * FROM user";
        $result = mysqli_query($linkBd, $sql);

        /*while($donnees = mysqli_fetch_assoc($result))
        {
          $this->send($user->socket, $donnees['Prenom']);
        }*/
        while ( $row = $result->fetch_assoc())  {
      	$dbdata[]=$row;
        }
      //  json_encode($dbdata);
        $this->send($user->socket, json_encode($dbdata));
        // Free result set
        mysqli_free_result($result);
    }
    else if(($form->{'type'} ) == "add"){
        $titre = ($form->{'titre'});
        $date = ($form->{'date'});
        $description = ($form->{'description'});
        $lieu = ($form->{'lieu'});
        $meteo = ($form->{'meteo'});
        $sql = "INSERT INTO annonce (Titre, Description, Lieu, Meteo, Date) VALUES ($titre, $description, $lieu, $meteo, $date)";
        //mysqli_query($linkBd, $sql) or die();
        $this->send($user->socket, "ok");
    }
    else{
        $this->send($user->socket,"Pas compris !");
    }
  }
}

$master = new Wot("localhost",1337);

function connexionBdd(){
  $link = new mysqli ("localhost", "root", "","wot_bd")
  or die();
  return $link;
}
function closeBd($link){
  mysql_close($link);
}

?>
