<?php

include '../config.php';

$km = $_POST['km'];
$hebergement = $_POST['hebergement'];


$stmt = $conn->prepare("SELECT * FROM forfait WHERE CAST(`forfait_km` AS char) = CAST( ".$km." AS char) AND forfait_jour = ".$hebergement."");
$stmt->execute();


// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

foreach($stmt->fetchAll() as $k=>$v) {
    var_dump($v['id_forfait']);
    $stmt1 = $conn->prepare("DELETE FROM forfait WHERE id_forfait = '".$v['id_forfait']."'");
    $stmt1->execute();
    
}
$stmt=$conn->prepare("INSERT INTO forfait (forfait_km, forfait_jour) VALUES ('".$km."', '".$hebergement."')");
$stmt->execute();

header("location:../parametrage.php");

?>