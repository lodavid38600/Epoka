<?php
include '../config.php';

function get_city($conn , $term){	
    
    $stmt = $conn->prepare("SELECT * FROM commune WHERE nom LIKE '".$term."%' ORDER BY nom ASC LIMIT 10");
    $stmt->execute();
	return $stmt;	
}

if (isset($_GET['term'])) {
	$getCity = get_city($conn, $_GET['term']);
	$cityList = array();
	foreach($getCity as $city){
		$cityList[] = $city['nom'];
	}
	echo json_encode($cityList);
}
?>