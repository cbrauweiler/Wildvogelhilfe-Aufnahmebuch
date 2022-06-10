<?php

	include('include/mysql.php');
	
	if(!empty($_GET['plz'])) {
	
		$plz = $_GET['plz'];
		$sql = "SELECT `plz` FROM `plzort` WHERE `plz` LIKE '$plz%'";
		$res = $mysqli->query($sql);
		
		if(!$res) {
		}
		else {
			
			while($row = $res->fetch_object()) {
				
				echo '<option value="'.$row->plz.'">';
				
			}
			
		}
		
	}
	
	if(!empty($_GET['ort'])) {
	
		$ort = $_GET['ort'];
		$sql = "SELECT `ort` FROM `plzort` WHERE `ort` LIKE '$ort%'";
		$res = $mysqli->query($sql);
		
		if(!$res) {
		}
		else {
			
			while($row = $res->fetch_object()) {
				
				echo '<option value="'.$row->ort.'">';
				
			}
			
		}
		
	}
      
    
	
?>