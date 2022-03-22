

<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <title>Epoka | Connexion</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Epoka</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
        <?php if(isset($_SESSION['nom'])){
          echo("<a class='nav-link' href='logout.php'>Déconnexion</a>");
        }
         else if(!isset($_SESSION['nom'])){
           echo("<a class='nav-link' href='connexion.php'>Connexion</a>");
           }?>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php

if(isset($_GET['erreur'])){
    $erreur = $_GET['erreur'];
    if($erreur == "vide"){
        echo("Veuillez remplir le champs !");
    }
}

if(isset($_GET['erreur'])){
    $erreur = $_GET['erreur'];
    if($erreur == "wrong"){
        echo("Mauvaise authentification !");
    }
}

?>
    <center>
    <h1>Connexion</h1>
</center>
<form class="row g-3" action="login.php" method="GET" style="width:30%; position:relative; left: 35%; top:20vh;">

  <div class="col-12">
    <label for="identifiant" class="form-label">Identifiant : </label>
    <input type="text" class="form-control" name="identifiant"  placeholder="">
  </div>
  <div class="col-12">
    <label for="mdp" class="form-label">Mot-de-passe : </label>
    <input type="password" class="form-control" name="mdp" placeholder="">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Se connecter</button>
  </div>
</form>
</body>
</html>

