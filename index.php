<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <title>Epoka | Accueil</title>
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

      <?php if(!isset($_SESSION['valider'])){header("location:connexion.php");}
else if(isset($_SESSION['valider'])){
  if($_SESSION['valider'] == 1){
echo("  <li class='nav-item'>
<a class='nav-link' href='validation.php'>Validation des missions</a>
</li>");
  }else{

  }
}
 ?>
       
       <?php if(!isset($_SESSION['payer'])){header("location:connexion.php");}
else if(isset($_SESSION['payer'])){
  if($_SESSION['payer'] == 1){
echo(" <li class='nav-item'>
<a class='nav-link' href='paiement.php'>Paiement des frais</a>
</li>
<li class='nav-item'>
<a class='nav-link' href='parametrage.php'>Paramétrage</a>
</li>");
  }else{

  }
}
 ?>
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
    
<?php if(!isset($_SESSION['nom'])){header("location:connexion.php");}
else if(isset($_SESSION['nom'])){
echo("Bonjour ".$_SESSION['prenom']." ".$_SESSION['nom']." ".$_SESSION['payer']." ".$_SESSION['valider']);
}
 ?>

</body>
</html>