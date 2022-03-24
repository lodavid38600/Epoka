
<?php
session_start();

include '../config.php';

if(!isset($_POST['city1']) || !isset($_POST['city2'])){
    header("location:../parametrage.php");
}else{

$city1 = $_POST['city1'];
$city2 = $_POST['city2'];

$json = file_get_contents('https://fr.distance24.org/route.json?stops='.$city1.'|'.$city2.'');
$obj = json_decode($json);
$km = $obj->distance * 1.61;
$date_insert = date("Y-m-d");

$sql = "insert into historique (ville_depart, ville_arriver, km, date_insert) values ('".$city1."','".$city2."','".$km."', '".$date_insert."')";
  // Prepare statement
  $stmt = $conn->prepare($sql);
  // execute the query
  $stmt->execute();

header("location:../parametrage.php?city1=".base64_encode($city1)."&city2=".base64_encode($city2)."&km=".base64_encode($km)."");
}
?>