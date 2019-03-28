#!/usr/bin/php -q
<?php

// Execution en ligne de commande : php -q <nomdufichier>.php

// Inclusion de la librairie phpwebsocket
require "websocket.class.php";

// Extension de WebSocket
class Wot extends WebSocket {
  function process($user,$msg) {


    $this->say("< ".$msg);

    $linkBd = connexionBdd();
    switch($msg){

      case "addAction" :
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



      break;
      default:
        //$this->send($user->socket,"Pas compris !");

      break;
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
