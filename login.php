<?php


 require 'config.php';

if($_GET['identifiant'] == "" || $_GET['mdp'] == ""){
    header("location:index.php?erreur=vide");
    
}else{

 $conn->query("SET NAMES UTF8");
 $stmt=$conn->prepare("SELECT *, count(*) as nbr FROM salarie WHERE identifiant = :identifiant AND password = :mdp ");
 $stmt->bindValue (":identifiant", $_GET ["identifiant"]);
 $stmt->bindValue (":mdp", $_GET ["mdp"]);
 $stmt->execute();
 $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

 foreach($stmt->fetchAll() as $k=>$v) {

     if($v['nbr'] == 0){
        $v['nbr'] = "false";
         header("location:connexion.php?erreur=wrong");
     }
     else if($v['nbr'] == 1){
         $v['nbr'] = "true";
         session_start();
         $_SESSION['id_sal'] = $v['id_salarie'];
         $_SESSION['prenom'] = $v['prenom'];
         $_SESSION['nom'] = $v['nom'];
         $_SESSION['payer'] = $v['payer'];
         $_SESSION['valider'] = $v['valider'];
         echo($v['nbr']);
        header("location:index.php?");
     }
     
     echo($v['id_salarie']);

 
  }

 
}


$conn = null;


?>