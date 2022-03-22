
<?php
session_start();
$city1 = $_POST['city1'];
$city2 = $_POST['city2'];

$json = file_get_contents('https://fr.distance24.org/route.json?stops='.$city1.'|'.$city2.'');
$obj = json_decode($json);
$km = $obj->distance * 1.61;

header("location:../parametrage.php?city1=".base64_encode($city1)."&city2=".base64_encode($city2)."&km=".base64_encode($km)."");
?>