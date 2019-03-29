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


        
    }
    else if(($form->{'type'} ) == "add"){
        $titre = ($form->{'titre'});
        $date = ($form->{'date'});
        $description = ($form->{'description'});
        $lieu = ($form->{'lieu'});
        $meteo = ($form->{'meteo'});
        $sql = "INSERT INTO annonce (Titre, Description, Lieu, Meteo, Date) VALUES ('$titre', '$description', '$lieu', '$meteo', '$date')";
        if(mysqli_query($linkBd, $sql)){
          $this->send($user->socket, "addOK");
        }
    }
    else if(($form->{'type'} ) == "getAnnonces"){
  /*    $titre = ($form->{'titre'});
      $date = ($form->{'date'});
      $description = ($form->{'description'});*/
      $lieu = ($form->{'lieu'});
      //$meteo = ($form->{'meteo'});
      $this->say("test");
      $this->say("$lieu");
      $sql = "SELECT * FROM annonce WHERE Lieu like '%".$lieu."%'";
      $this->say($sql);
      $result = mysqli_query($linkBd, $sql);
      if($result != 'null'){
      while ( $row = $result->fetch_assoc())  {
      $dbdata[]=$row;
      }
      json_encode($dbdata);
      $this->send($user->socket, json_encode($dbdata));
    }

      // Free result set
      mysqli_free_result($result);
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
