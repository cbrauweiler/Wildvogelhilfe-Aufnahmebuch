<?php

include('mysql.php');

// Änderungen Einstellungen / Schalter direkt in mySQL speichern
if(!empty($_GET['func']) && $_GET['func'] == 'savesettings') {

	$mandant = $_GET['mandant'];
	$obj = $_GET['obj'];
	$value = $_GET['value'];

	switch($value) {
		
		case 'true': $value = 'on';
		break;
		
		case 'false': $value = 'off';
		break;
		
	}

	$query = "UPDATE `einstellungen` SET `$obj`='$value' WHERE `mandant`='$mandant'";
	echo $query;
	mysqli_query($mysqli, $query);
	
}

// Bestätigung einer neuen Version direkt in mySQL speichern
if(!empty($_GET['func']) && $_GET['func'] == 'versionok') {
	
	$version = $_GET['version'];
	$mandant = $_GET['mandant'];
	
	$query = "UPDATE `benutzer` SET `version`='$version' WHERE `mandant`='$mandant'";
	echo $query;
	mysqli_query($mysqli, $query);
	
}

// Farbe ändern
if(!empty($_GET['func']) && $_GET['func'] == 'color') {
	
	$mandant = $_GET['mandant'];
	$schema = $_GET['schema'];
	
	switch($schema) {
		
		case 'green': $new_colorclass = 'green accent-3'; $new_primarycolor = '#00e676'; $new_secondarycolor = '#b9f6ca';
		break;
		
		case 'blue': $new_colorclass = 'blue darken-3'; $new_primarycolor = '#1565c0'; $new_secondarycolor = '#bbdefb';
		break;
		
		case 'yellow': $new_colorclass = 'yellow darken-3'; $new_primarycolor = '#f9a825 '; $new_secondarycolor = '#fbc02d ';
		break;
		
		case 'red': $new_colorclass = 'red darken-4'; $new_primarycolor = '#b71c1c'; $new_secondarycolor = '#ef9a9a';
		break;
		
	}
	
	$query = "UPDATE `einstellungen` SET `colorclass`='$new_colorclass', `primarycolor`='$new_primarycolor', `secondarycolor`='$new_secondarycolor' WHERE `mandant`='$mandant'";
	echo $query;
	mysqli_query($mysqli, $query);
	
}

?>