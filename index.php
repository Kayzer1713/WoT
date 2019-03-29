<?php
session_start();
echo $_SESSION['connecte'];
if (isset($_SESSION['connecte']) && !empty($_SESSION['connecte']){
  header('location:fonctions/login.html');
}
?>

<!doctype html>
<html lang="fr">
  <head>
    <script type="text/javascript" src="JS/jquery-3.3.1.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">


    <link rel="stylesheet" type="text/css" href="JS/DataTables-1.10.18/css/jquery.dataTables.min.css"/>

    <script type="text/javascript" src="JS/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="JS/popup.js"></script>
    <title>WOT</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body onload="init()">
    <header>
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">About</h4>
          <p class="text-muted">Blab bla bla bla bla</p>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-white">Contact</h4>

        </div>
      </div>
    </div>
  </div>
  <?php if ($_SESSION['connecte'] == 'OK'): ?>
    <div class='alert alert-success' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>Succès!</strong> Vous êtes bien connecté!
    </div>
  <?php endif; ?>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="#" class="navbar-brand d-flex align-items-center">
          <strong>WOT · Aide notre planète</strong>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>
<button><a href="fonctions/deconnexion.php">Déconnexion</a></button>
<main role="main">



  <div class="album py-5 bg-light" id="main">
    <div class="container">
      <div class="row">
        <div class="col-md-10"
          <form class="form-inline ">
            <input class="form-control" type="search" placeholder="Rechercher" aria-label="Search">
          </form>
        </div>
        <div class="col-md-2">
          <button type="button" name="button"  class="btn btn-primary" onclick='ajoutAction()'>Proposer Action </button>
        </diV>
      </div>
      <br/>
      <br/>
      <br/>

      <div class="row" id="contentAdd">




  <div class="album py-5 bg-light" id="addAction">
    <div class="container">
      <div class="row">
        <div class="col-md-10">
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" id="titre" placeholder="Titre" required>
              </div>
              <div class="form-group col-md-6">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" placeholder="dd/mm/yyyy" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputAddress">Description</label>
              <textarea type="text" class="form-control" id="description" placeholder="Description de la mission....." required></textarea>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="lieu">Lieu</label>
                <input type="text" class="form-control" id="lieu" required>
              </div>
              <!--pour les values https://openweathermap.org/weather-conditions-->
              <div class="form-group col-md-6">
                <label for="inputState">Météo requise</label>
                <select id="meteo" class="form-control">
                  <option selected>Tout les temps</option>
                  <option >Temps clair</option>
                  <option >Temps clair ou nuageux</option>
                  <option >Pluie</option>
                  <option >Neige</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                  Y participer
                </label>
              </div>
            </div>
            <button onclick="retourMain()" class="btn btn-secondary">retour</button>
            <button type="button" class="btn btn-primary" onclick="AddAnnonce()">Publier</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</main>

<footer class="text-muted">
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div id="log"></div>
            <p class="float-right">
              <a href="#">Retour en haut</a>
            </p>
            <p>Kévin Nguyen | Baptiste Salvador | Ghislain Vidal</p>
      </div>
    </div>
    <div class="row">
    <br/>
    <div class="col-md-12">
      <div class="city-icon">
      <div class="city-icon-holder">
      <div id="city-name"></div>
      <img src="" alt="" id="icon">
        </div>
    </div>
    <div id="test1"></div>
    <div id="test2"></div>
  </div>
</div>
</div>


</script>
</footer>
</body>
</html>

<script>

var socket;
const appKey = "5d2adabab648a8786abe5480fc06a5df";
let latitude,longitude,city;
let metAct;
var header = document.querySelector("#contentAdd");

function init(){

  var host = "ws://127.0.0.1:1337";
  try{

    getLocation();
    socket = new WebSocket(host);
    log('WebSocket - status '+socket.readyState);
    socket.onopen    = function(msg){ log("Welcome - status "+this.readyState); };
    socket.onmessage = function(event) {
      try{
            var msgJson = JSON.parse(event.data);
         } catch (e) {
            var msg = event.data;
          }

      //var time = new Date(msg.date);
      //var timeStr = time.toLocaleTimeString();
      if(msg){
        switch (msg) {
          case "addOK":
          location.reload();
            break;
          default:
          log("pas compris");
        }
      }
      else if (msgJson){
        if(msgJson['0'].Titre)
        {

        populateHeader(msgJson);
          //showHeroes(msgJson);
          log('test: '+ msgJson['0'].Titre);
        }
      }


      }
    socket.onclose   = function(msg){ log("Disconnected - status "+this.readyState); };

    getAnnonces();

  }
  catch(ex){ log(ex); }
  //$("msg").focus();

}

function populateHeader(jsonObj) {
  var y =0;
  for (var i = 0; i < jsonObj.length; i++) {

      let searchLink = "https://api.openweathermap.org/data/2.5/weather?q="+jsonObj[i].Lieu+"&appid="+appKey;


        var response;
        var httpRequest = new XMLHttpRequest();
        httpRequest.open("GET", searchLink,true); // true for asynchronous
        httpRequest.send();

        httpRequest.onreadystatechange = () => {

          if (httpRequest.readyState == 4 && httpRequest.status == 200){
            i=y;

                 response = (httpRequest.responseText);
                 let jsonObject = JSON.parse(response);
                 metAct = jsonObject.weather['0'].description ;
                 var test = metAct;

                 if(y % 2 == 0){
                         var row = document.createElement("div");
                         row.setAttribute('class', 'row');
                         header.appendChild(row);
                         var col = document.createElement("div");
                         col.setAttribute('class', 'col-md-12');
                         row.appendChild(col);
                         var colS = document.createElement("div");
                         colS.setAttribute('class', 'card mb-4 shadow-sm art');
                         col.appendChild(colS);

                         var myH1 = document.createElement('h1');
                         var Description = document.createElement('p');
                         var Date = document.createElement('p');
                         var Lieu = document.createElement('p');
                         var Meteo = document.createElement('p');
                         var MeteoP = document.createElement('p');
                         var Button = document.createElement("BUTTON");
                         myH1.textContent = jsonObj[i].Titre;
                         Description.textContent = jsonObj[i].Description;
                         Date.textContent = "Date : "+jsonObj[i].Date;
                         Lieu.textContent = "Lieu : "+jsonObj[i].Lieu;
                         Meteo.textContent = "Meteo requise: "+jsonObj[i].Meteo;
                         MeteoP.textContent = "Meteo actuelle: "+metAct;
                         Button.innerHTML  = "Rejoindre";
                         Button.setAttribute('class', 'btn btn-light');
                         colS.appendChild(myH1);
                         colS.appendChild(Description);
                         colS.appendChild(Date);
                         colS.appendChild(Lieu);
                         colS.appendChild(Meteo);
                         colS.appendChild(MeteoP);
                         colS.appendChild(Button);

                 }
                 else{

                  var col = document.createElement("div");
                  col.setAttribute('class', 'col-md-12');
                  header.appendChild(col);
                  var colS = document.createElement("div");
                  colS.setAttribute('class', 'card mb-4 shadow-sm art');
                  col.appendChild(colS);

                  var myH1 = document.createElement('h1');
                  var Description = document.createElement('p');
                  var Date = document.createElement('p');
                  var Lieu = document.createElement('p');
                  var Meteo = document.createElement('p');
                  var MeteoP = document.createElement('p');
                  var Button = document.createElement("BUTTON");
                  var toto = jsonObj[i].Titre;
                  myH1.textContent = jsonObj[i].Titre;
                  Description.textContent = jsonObj[i].Description;
                  Date.textContent = "Date : "+jsonObj[i].Date;
                  Lieu.textContent = "Lieu : "+jsonObj[i].Lieu;
                  Meteo.textContent = "Meteo requise: "+jsonObj[i].Meteo;
                  MeteoP.textContent = "Meteo actuelle: "+metAct;
                  Button.innerHTML  = "Rejoindre";
                  Button.setAttribute('class', 'btn btn-light');
                  colS.appendChild(myH1);
                  colS.appendChild(Description);
                  colS.appendChild(Date);
                  colS.appendChild(Lieu);
                  colS.appendChild(Meteo);
                  colS.appendChild(MeteoP);
                  colS.appendChild(Button);
                }
                i++;
                y++;
          }

        }


      }







}

function getAnnonces(){
  /*  if($("lieuSearch").value == '' || $("lieuSearch").value == 'null' ){*/var lieuS = city;/*}else{ lieuS = $("lieuSearch").value }*/

  var critere = {
    type: "getAnnonces",
    /*titre: $("titreSearch").value,
    date: $("date").value,
    description: $("description").value,*/
    lieu: lieuS
    //meteo: $("meteo").value
  };
  try{socket.send(JSON.stringify(critere)); }catch(ex){ log(ex); }
}
function send(){
  var txt,msg;
  txt = $("msg");
  msg = txt.value;
  if(!msg){ alert("Message can not be empty"); return; }
  txt.value="";
  txt.focus();
  try{ socket.send(msg); log('Sent: '+msg); } catch(ex){ log(ex); }
}
function ajoutAction() {
  var user, Nom;
  user = "test";
  Nom= user;
  try{socket.send("addAction"); log('Sent: ajout action au nom de '+ Nom);
  $("main").style.display = 'none';
  $("addAction").style.display = 'inherit';
  } catch(ex){ log(ex); }
  $("lieu").setAttribute("placeholder",city);
}
function AddAnnonce(){
  if($("date").value != '' && $("titre").value != '' && $("description").value  != '' && $("lieu").value  != '' && $("meteo").value  != ''){
  var annonce = {
    type: "add",
    titre: $("titre").value,
    date: $("date").value,
    description: $("description").value,
    lieu: $("lieu").value,
    meteo: $("meteo").value
  };
  try{socket.send(JSON.stringify(annonce)); }catch(ex){ log(ex); }
}
}
function retourMain() {
  $("addAction").style.display = 'none';
  $("main").style.display = 'inherit';

}
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  latitude = position.coords.latitude;
  longitude=  position.coords.longitude;
  findWeatherDetails();

}

function quit(){
  log("Goodbye!");
  socket.close();
  socket=null;
}

// Utilities
function $(id){ return document.getElementById(id); }
function log(msg){ $("log").innerHTML+="<br>"+msg; }
function onkey(event){ if(event.keyCode==13){ send(); } }

//Utilisation API METEO lien doc : https://openweathermap.org/forecast5

let test1 = document.getElementById("test1");
let test2 = document.getElementById("test2");
let icon = document.getElementById("icon");



function checkWeather(ville){
  let searchLink = "https://api.openweathermap.org/data/2.5/weather?q="+ville+"&appid="+appKey;
   httpRequestAsync(searchLink, theResponseCheck);

}
function theResponseCheck(response) {
  let jsonObject = JSON.parse(response);
  metAct = jsonObject.weather['0'].description ;
}

function findWeatherDetails() {
  let searchLink = "https://api.openweathermap.org/data/2.5/forecast?lat="+latitude+"&lon="+longitude+"&appid="+appKey;
   httpRequestAsync(searchLink, theResponse);

 }


function theResponse(response) {
  let jsonObject = JSON.parse(response);
  test1.innerHTML = parseInt(jsonObject.list[0].main.temp - 273) + "°";
  city = jsonObject.city.name ;
  test2.innerHTML = city;
  icon.src = "http://openweathermap.org/img/w/" + jsonObject.list[0].weather[0].icon + ".png";
 getAnnonces();

}

function httpRequestAsync(url, callback)
{
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = () => {
        if (httpRequest.readyState == 4 && httpRequest.status == 200)
            callback(httpRequest.responseText);
    }
    httpRequest.open("GET", url, true); // true for asynchronous
    httpRequest.send();
}

</script>
