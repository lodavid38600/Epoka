<?php

include 'config.php';

$stmt = $conn->prepare("SELECT * FROM commune ORDER BY nom");
$stmt->execute();

// set the resulting array to associative
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$ville = array();

foreach($stmt->fetchAll() as $k=>$v) {
    array_push($ville, array(
        'ville'=>$v['nom'],
        'cp'=>$v['code_postal']
    ));
  //echo json_encode($v);


}
echo json_encode($ville);



?>