<?php
session_start();

 require '../config.php';

if($_GET['date_depart'] == "" || $_GET['date_rentrer'] == "" || $_GET['ville_dest'] == "" ||$_GET['sess_id'] == ""){
    header("location:../index.php?erreur=vide");

}else{

    $str_d=$_GET['date_depart'];
    $str_d = explode("/",$str_d);
    $jour_d = $str_d[0];
    $mois_d = $str_d[1];
    $annee_d = $str_d[2];
    $newdate_depart = $annee_d."-".$mois_d."-".$jour_d;
    echo($newdate_depart);

    $str_r=$_GET['date_rentrer'];
    $str_r = explode("/",$str_r);
    $jour_r = $str_r[0];
    $mois_r = $str_r[1];
    $annee_r = $str_r[2];
    $newdate_rentrer = $annee_r."-".$mois_r."-".$jour_r;
    echo($newdate_rentrer);



    $stmt = $conn->prepare("SELECT * FROM commune WHERE nom = '".$_GET['ville_dest']."'");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $ville = array();

    foreach($stmt->fetchAll() as $k=>$v) {
      $ville_dest = $v['id_commune'];
    }

    $stmt1 = $conn->prepare("SELECT max(id_forfait) as  max FROM forfait ");
    $stmt1->execute();

    // set the resulting array to associative
    $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);
    

    foreach($stmt1->fetchAll() as $g=>$h) {
      
 $conn->query("SET NAMES UTF8");
 
 $date_now = date('Y-m-d');

 if($_SESSION['id_sal'] == "" && $_GET['sess_id'] != ""){

  $stmt=$conn->prepare("SELECT id_agence from salarie where id_salarie = '".$_GET['sess_id']."'");
  $stmt->execute();
  foreach($stmt->fetchAll() as $k=>$v) {
    $id_agence = $v['id_agence'];
  }
  
  
  $stmt=$conn->prepare("SELECT ville FROM agence where id_agence = '".$id_agence."'");
  $stmt->execute();
  
  foreach($stmt->fetchAll() as $k=>$v) {
    $ville_agence = $v['ville'];
  }
  
  $json = file_get_contents('https://fr.distance24.org/route.json?stops='.$ville_agence.'|'.$_GET['ville_dest'].'');
  $obj = json_decode($json);
  $km = $obj->distance * 1.61;
  
  $prix = $km * 0.8;
  $prix = round($prix);

 $stmt=$conn->prepare("INSERT INTO mission (id_salarie, id_forfait, date_depart, date_rentrer, Id_commune, date_creation, prix) VALUES ('".$_GET['sess_id']."', '".$h['max']."', '".$newdate_depart."', '".$newdate_rentrer."', '".$ville_dest."', '".$date_now."', '".$prix."')");
 $stmt->execute();


 }else if($_SESSION['id_sal'] != "" && $_GET['sess_id'] == ""){

  $stmt=$conn->prepare("SELECT id_agence from salarie where id_salarie = '".$_SESSION['id_sal']."'");
  $stmt->execute();
  foreach($stmt->fetchAll() as $k=>$v) {
    $id_agence = $v['id_agence'];
  }
  
  
  $stmt=$conn->prepare("SELECT ville FROM agence where id_agence = '".$id_agence."'");
  $stmt->execute();
  
  foreach($stmt->fetchAll() as $k=>$v) {
    $ville_agence = $v['ville'];
  }
  
  $json = file_get_contents('https://fr.distance24.org/route.json?stops='.$ville_agence.'|'.$_GET['ville_dest'].'');
  $obj = json_decode($json);
  $km = $obj->distance * 1.61;
  
  $prix = $km * 0.8;
  $prix = round($prix);

    $stmt=$conn->prepare("INSERT INTO mission (id_salarie, id_forfait, date_depart, date_rentrer, Id_commune, date_creation, prix) VALUES ('".$_SESSION['id_sal']."', '".$h['max']."', '".$newdate_depart."', '".$newdate_rentrer."', '".$ville_dest."', '".$date_now."', '".$prix."')");
    $stmt->execute();
 }

}




}



$conn = null;


?>