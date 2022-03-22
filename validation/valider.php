<?php
include '../config.php';

$id_mission = $_GET['id_mission'];

$sql = "UPDATE mission SET valider='1' WHERE id_mission = '".$id_mission."'";

  // Prepare statement
  $stmt = $conn->prepare($sql);

  // execute the query
  $stmt->execute();

  header("location:../validation.php")


?>