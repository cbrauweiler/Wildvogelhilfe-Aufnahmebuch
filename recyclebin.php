<h2>Papierkorb</h2>

Hier werden alle Datensätze angezeigt die in den Papierkorb geworfen wurden. Erst wenn man hier den Datensatz löscht, ist er wirklich unwiederbringlich weg!

<br /><br />

<table class="striped centered">
	<thead>
		<tr>
			<th onclick="self.location.href='?menu=list&rows=<?php echo $rows; ?>&order=datum'">Datum</th>
			<th onclick="self.location.href='?menu=list&rows=<?php echo $rows; ?>&order=vogel_art'">Art</th>
			<th onclick="self.location.href='?menu=list&rows=<?php echo $rows; ?>&order=vogel_anzahl'">Anzahl</th>
			<th onclick="self.location.href='?menu=list&rows=<?php echo $rows; ?>&order=finder_ort'">Ort</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

<?php

# Datensatz wiederherstellen
if($action == "restore") {
	
	$query = "UPDATE `aufnahmebuch` SET `papierkorb`='0' WHERE `mandant`='$session_mandant' AND `id`='$_GET[id]'";
	mysqli_query($mysqli, $query);
			
	echo '<ul class="erfolg">Datensatz wurde wiederhergestellt!</ul><br />';
	
}

# Datensatz löschen
if($action == "delete") {
	
	$query = "DELETE FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `id`='$_GET[id]'";
	mysqli_query($mysqli, $query);
			
	echo '<ul class="fehler">Datensatz wurde endgültig gelöscht!</ul><br />';
	
}

# Papierkorb leeren
if($action == "recycleall") {
	
	$query = "DELETE FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `papierkorb`='1'";
	mysqli_query($mysqli, $query);
			
	echo '<ul class="fehler">Papierkorb wurde geleert!</ul><br />';
	
}


$query = "SELECT * FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `papierkorb`='1' ORDER BY `datum` DESC";
if($result = mysqli_query($mysqli, $query)) {
	while($row = $result->fetch_array(MYSQLI_BOTH)) {
		
		$db_id = $row['id'];
		$db_datum = $row['datum'];
		$db_vogel_art = $row['vogel_art'];
		$db_vogel_stadium = $row['vogel_stadium'];
		$db_vogel_anzahl = $row['vogel_anzahl'];
		$db_vogel_foto_name = $row['vogel_foto_name'];
		$db_finder_ort = $row['finder_ort'];
		$db_vogel_ausgewildert = $row['vogel_ausgewildert'];
		$db_vogel_verstorben = $row['vogel_verstorben'];
		$db_vogel_euthanasiert = $row['vogel_euthanasiert'];
		$db_vogel_weitergeleitet = $row['vogel_weitergeleitet'];
		
		echo '
			<tr>
				<td align="center">'.$db_datum.'</td>
				<td align="center">'; if(!empty($db_vogel_foto_name)) { echo '<a href="?menu=recyclebin&action=show&id='.$db_id.'">'.$db_vogel_art.' ('.$db_vogel_stadium.')</a>'; }else echo $db_vogel_art.' ('.$db_vogel_stadium.')'; echo '</td>
				<td align="center">'.$db_vogel_anzahl.'</td>
				<td align="center">'.$db_finder_ort.'</td>
				<td align="center">
					<a href="?menu=recyclebin&action=restore&id='.$db_id.'"><i class="material-icons">restore</i></a>
					<a href="?menu=recyclebin&action=delete&id='.$db_id.'" onclick="return window.confirm(\'Soll dieser Datensatz wirklich gelöscht werden?\');"><i class="material-icons">delete</i></a>
				</td>
			</tr>
		';
		
	}
	
}

?>

	</tbody>
</table>

<br />

<center>
	<form name="recycleall" action="?menu=recyclebin&action=recycleall" method="POST">
		<button class="waves-effect waves-light btn-small <?php echo $colorclass; ?>" type="submit" onclick="return window.confirm('Soll der Papierkorb wirklich geleert werden?');">Papierkorb leeren
			<i class="material-icons right">delete_forever</i>
		</button>
	</form>
</center>