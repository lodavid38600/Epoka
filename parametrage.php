<?php session_start();
include 'config.php';


if (isset($_SESSION['payer'])) {
  if ($_SESSION['payer'] != 1) {
    header("location:index.php");
  }
}?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 
<!-- jQuery UI -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

  <title>Epoka | Paramétrage</title>
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

          <?php if (!isset($_SESSION['valider'])) {
            header("location:connexion.php");
          } else if (isset($_SESSION['valider'])) {
            if ($_SESSION['valider'] == 1) {
              echo ("  <li class='nav-item'>
<a class='nav-link' href='validation.php'>Validation des missions</a>
</li>");
            } else {
            }
          }
          ?>


          <?php if (!isset($_SESSION['payer'])) {
            header("location:connexion.php");
          } else if (isset($_SESSION['payer'])) {
            if ($_SESSION['payer'] == 1) {
              echo (" <li class='nav-item'>
<a class='nav-link' href='paiement.php'>Paiement des frais</a>
</li>
<li class='nav-item'>
<a class='nav-link' href='parametrage.php'>Paramétrage</a>
</li>");
            } else {
            }
          }
          ?>
          <li class="nav-item">
            <?php if (isset($_SESSION['nom'])) {
              echo ("<a class='nav-link' href='logout.php'>Déconnexion</a>");
            } else if (!isset($_SESSION['nom'])) {
              echo ("<a class='nav-link' href='connexion.php'>Connexion</a>");
            } ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <br><br>
  <center>
    <h1><u>Paramétrage de l'application</u></h1>
    <br><br>
    <h3>Montant du remboursement au km</h3>
  </center>
  <form class="row g-3" action="parametrage/remboursement" method="POST" style="width:30%; position:relative; left: 35%; top:5vh;">

    <?php
    $stmt2 = $conn->prepare("SELECT max(id_forfait) as max FROM forfait");
    $stmt2->execute();
    $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($stmt2->fetchAll() as $k => $j) {

      if (isset($j['max'])) {
        $stmt1 = $conn->prepare("SELECT * FROM forfait WHERE id_forfait = '" . $j['max'] . "'");
        $stmt1->execute();
        $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);


        foreach ($stmt1->fetchAll() as $g => $h) {
    ?>
          <div class="col-12">
            <label for="km" class="form-label">Remboursement au Km : </label>
            <input type="number" step="0.1" class="form-control" name="km" value=<?php
                                                                                  if (isset($h['forfait_km'])) {
                                                                                    echo ($h['forfait_km']);
                                                                                  }
                                                                                  ?>>
          </div>

          <div class="col-12">
            <label for="hebergement" class="form-label">Indemnité d'hébergement : </label>
            <input type="number" class="form-control" name="hebergement" value=<?php
                                                                                if (isset($h['forfait_jour'])) {
                                                                                  echo ($h['forfait_jour']);
                                                                                }
                                                                                ?>>
          </div>
          <br>
        <?php
        }
      } else {
        ?>
        <div class="col-12">
          <label for="km" class="form-label">Remboursement au Km : </label>
          <input type="number" step="0.1" class="form-control" name="km" value=<?php
                                                                                if (isset($h['forfait_km'])) {
                                                                                  echo ($h['forfait_km']);
                                                                                }
                                                                                ?>>
        </div>

        <div class="col-12">
          <label for="hebergement" class="form-label">Indemnité d'hébergement : </label>
          <input type="number" step="0.1" class="form-control" name="hebergement" value=<?php
                                                                              if (isset($h['forfait_jour'])) {
                                                                                echo ($h['forfait_jour']);
                                                                              }
                                                                              ?>>
        </div>
        <br>
    <?php
      }
    }
    ?>




    <div class="col-12">
      <button type="submit" class="btn btn-primary">Valider</button>
    </div>
  </form>
  <br><br><br>
  <center>
    <h3>Distance entre villes</h3>
  </center>
  <form class="row g-3" action="parametrage/api_distance.php" method="POST" style="width:30%; position:relative; left: 35%; top:5vh;">

  <div class="container">
  <div class="row">
     <div class="col-md-12">
     <label>De :</label>
     <input type="text" name="city1" id="search_city" placeholder="Ville de départ..." class="form-control" value=<?php if(isset($_GET['city1'])){echo(base64_decode($_GET['city1']));} ?>>  
     </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
     $( "#search_city" ).autocomplete({
       source: 'auto_comp/ajax-city-search.php',
     });
  });
</script>

<div class="container">
  <div class="row">
     <div class="col-md-12">
     <label>A :</label>
     <input type="text" name="city2" id="search_city2" placeholder="Ville de destination..." class="form-control" value=<?php if(isset($_GET['city2'])){echo(base64_decode($_GET['city2']));} ?> >  
     </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
     $( "#search_city2" ).autocomplete({
       source: 'auto_comp/ajax-city-search.php',
     });
  });
</script>
<div class="col-12">
      <button type="submit" class="btn btn-primary">Valider</button>
    </div>
    <div class="col-12">
      <label for="km" class="form-label">Distances en km : </label>
      <input type="number" id="search_distance" class="form-control" name="distance" value=<?php if(isset($_GET['km'])){echo(base64_decode($_GET['km'])."");} ?> disabled>

    </div>
  
  </form>
  <br><br><br><br>
  <center>
    <h3>Distance entre villes déjà saisies</h3>

    <br><br>
    <table class="table" style="width:50%; border: 1px black solid">
      <thead>
        <tr>
          <th scope="col">De</th>
          <th scope="col">A</th>
          <th scope="col">Km</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </center>
  <br><br><br>
</body>

</html>