<?php
session_start();
?>
<html>
<head>
  <meta charset="utf-8" />
  <title>Page de connection</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/login.css">
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="JS/popup.js"></script>
  <script type="text/javascript" src="JS/login.js"></script>
</head>

<body>
  <?php if (isset($_SESSION['id']) && $_SESSION['id'] == 'ErrMDP'){ ?>
    <div class='alert alert-danger' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>Erreur!</strong> Mauvais mot de passe
    </div>
  <?php } ?>

  <div class="form">

    <ul class="tab-group">
      <li class="tab active"><a href="#signup">S'inscrire</a></li>
      <li class="tab"><a href="#login">Se connecter</a></li>
    </ul>

    <div class="tab-content">
      <div id="signup">
        <h1>S'inscrire gratuitement</h1>

        <form action="fonctions/inscription.php" method="post">

          <div class="top-row">
            <div class="field-wrap">
              <label>
                Prénom<span class="req">*</span>
              </label>
              <input name="prenom" type="text" required autocomplete="off" />
            </div>

            <div class="field-wrap">
              <label>
                Nom<span class="req">*</span>
              </label>
              <input name="nom" type="text"required autocomplete="off"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email<span class="req">*</span>
            </label>
            <input name="username" type="email"required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              Mot de passe<span class="req">*</span>
            </label>
            <input name="password" type="password"required autocomplete="off"/>
          </div>

          <button type="submit" class="button button-block"/>Let's clean</button>

        </form>

      </div>

      <div id="login">
        <h1>Bienvenue !</h1>

        <form action="fonctions/connexion.php" method="post">

          <div class="field-wrap">
            <label>
              Email<span class="req">*</span>
            </label>
            <input name="username" type="email"required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              Mot de passe<span class="req">*</span>
            </label>
            <input name="password" type="password"required autocomplete="off"/>
          </div>

          <p class="forgot"><a href="#">Mot de passe oublié?</a></p>

          <button class="button button-block"/>Connexion</button>

        </form>

      </div>

    </div><!-- tab-content -->

  </div> <!-- /form -->
</body>
