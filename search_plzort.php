<?php

include('include/mysql.php');

# Suche PLZ/ORT
$returnvalue = "ERROR";
$notvalid = "ungültige PLZ";

if(!empty($_GET['plz'])) {
	
	$plz = $_GET['plz'];
	$query = "SELECT `ort` FROM `plzort` WHERE `plz`='$plz'";
	
	if($result = mysqli_query($mysqli, $query)) {
		if($row = $result->fetch_array(MYSQLI_BOTH)) {
		
			$returnvalue = $row['ort'];
		
		}
		else {
			
			$returnvalue = $notvalid;
			
		}
		
	}
	
}

if(!empty($_GET['ort'])) {
	
	$ort = $_GET['ort'];
	$query = "SELECT `plz` FROM `plzort` WHERE `ort`='$ort'";
	
	if($result = mysqli_query($mysqli, $query)) {
		if($row = $result->fetch_array(MYSQLI_BOTH)) {
		
			$returnvalue = $row['plz'];
		
		}
		else {
			
			$returnvalue = $notvalid;
			
		}
		
	}
	
}

echo $returnvalue;