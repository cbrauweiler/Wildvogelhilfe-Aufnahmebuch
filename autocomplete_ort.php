<?php

include('include/mysql.php');

// Get search term 
$searchTerm = $_GET['term']; 
 
// Fetch matched data from the database 
$query = $mysqli->query("SELECT * FROM `plzort` WHERE `ort` LIKE '$searchTerm%' ORDER BY `ort` ASC"); 
 
// Generate array with skills data 
$skillData = array(); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $data['id'] = $row['plz']; 
        $data['value'] = $row['ort']; 
        array_push($skillData, $data); 
    } 
} 
 
// Return results as json encoded array 
echo json_encode($skillData);
 
?>