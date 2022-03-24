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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <title>Epoka | Paiement</title>
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
<center>
    <br><br>
<h2>Paiement des missions</h2>
<br><br>
<table class="table" style="width:80%; border: 1px black solid">
  <thead>
  <tr>
        <th>Nom du salarié</th>
        <th>Prénom du salarié</th>
        <th>Début de la mission</th>
        <th>Fin de la mission</th>
        <th>Lieu de la mission</th>
        <th>Montant</th>
        <th>Paiement</th>
    </tr>
  </thead>
  <?php

$stmt=$conn->prepare("SELECT *,DATE_FORMAT(date_depart, '%W %d %M %Y') as depart, DATE_FORMAT(date_rentrer, '%W %d %M %Y') as rentrer FROM mission WHERE valider = 1 AND payer = 0");
 $stmt->execute();
 $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

 foreach($stmt->fetchAll() as $k=>$v) {

  
 $date = explode(' ', $v['depart']);
 $date1 = explode(' ', $v['rentrer']);
 
 $jf = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
 $ja = array('Monday','Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
 for($i = 0; $i < 7; $i++){
   if($date[0] == $ja[$i]){
     $jf0 = $jf[$i];
   }

   if($date1[0] == $ja[$i]){
     $jf1 = $jf[$i];
   }
 }

 $mf = array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
 $ma = array('January', 'Febrary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

 for($i = 0; $i < 12; $i++){
   if($date[2] == $ma[$i]){
     $mf0 = $mf[$i];
   }

   if($date1[2] == $ma[$i]){
     $mf1 = $mf[$i];
   }
 }
      
  $stmt2=$conn->prepare("SELECT * FROM salarie WHERE id_salarie = ".$v['id_salarie']."");
  $stmt2->execute();
  $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC); 

  $stmt1=$conn->prepare("SELECT nom, code_postal FROM commune WHERE id_commune = ".$v['id_commune']."");
  $stmt1->execute();
  $m = $stmt1->fetch();


  foreach($stmt2->fetchAll() as $k=>$j) {
  


      
      echo("
      <tr>
        <td>".$j['nom']."</td>
        <td> ".$j['prenom']."</td>
        <td>  ".$jf0." ".$date[1]." ".$mf0." ".$date[3]."</td>
        <td>  ".$jf1." ".$date1[1]." ".$mf1." ".$date1[3]."</td>
        <td>  ".$m['nom']." (".$m['code_postal'].")</td>
        <td>  ".$v['prix']."€</td>
        <td><a href='paiement/payer.php?id_mission=".$v['id_mission']."'><button class='btn btn-success'>Rembourser</button></a></td>
        </tr>");
    
  }
}
        ?>
  
</tbody>
</table>
</table> 
    
</center>
</body>
</html>