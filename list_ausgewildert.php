<h3>Ausgewildert</h3>

<table class="striped centered">
	<thead>
		<tr>
			<th onclick="self.location.href='?menu=list&rows=<?php echo $rows; ?>&order=datum'">Datum</th>
			<th onclick="self.location.href='?menu=list&rows=<?php echo $rows; ?>&order=vogel_art'">Art</th>
			<th onclick="self.location.href='?menu=list&rows=<?php echo $rows; ?>&order=vogel_anzahl'">Anzahl</th>
			<th onclick="self.location.href='?menu=list&rows=<?php echo $rows; ?>&order=finder_ort'">Ort</th>
			<th colspan="2"></th>
		</tr>
	</thead>
	<tbody>

<?php

	#$query = "SELECT * FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `papierkorb`='0' AND `vogel_ausgewildert`>0 AND `vogel_anzahl`!=vogel_ausgewildert+vogel_euthanasiert+vogel_verstorben+vogel_weitergeleitet ORDER BY `datum` DESC";
	$query = "SELECT * FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `papierkorb`='0' AND `vogel_ausgewildert`>0 ORDER BY `datum` DESC";
	
	$date_before = '';
	$sum_anzahl = 0;
	
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
			
			$anz = $db_vogel_ausgewildert;
			$sum_anzahl = $sum_anzahl+$anz;
			
			switch($db_vogel_stadium) {
				
				case 'nestling': $db_vogel_stadium = 'Nestling';
				break;
				
				case 'nestling-befiedert': $db_vogel_stadium = 'Nestling Befiedert';
				break;
				
				case 'aestling': $db_vogel_stadium = 'Ästling';
				break;
				
				case 'juvenil': $db_vogel_stadium = 'Juvenil';
				break;
				
				case 'adult': $db_vogel_stadium = 'Adult';
				break;
				
			}
			
			# Leerzeile bei neuem Jahr
			$split_date = explode("-", $db_datum);
			if($split_date[0] != $date_before) {
				
				echo '<tr><td colspan="6" align="center"><h5>'.$split_date[0].'</h5></td></tr>';
				
			}
			
			echo '
				<tr>
					<td align="center">'.$split_date[2].'.'.$split_date[1].'</td>
					<td align="center">'; if(!empty($db_vogel_foto_name)) { echo '<a href="?menu=list&action=show&id='.$db_id.'">'.$db_vogel_art.' ('.$db_vogel_stadium.')</a>'; }else echo $db_vogel_art.' ('.$db_vogel_stadium.')'; echo '</td>
					<td align="center">'; if(isset($_POST['search'])) { echo $db_vogel_anzahl; }else { echo $anz.' ('.$db_vogel_anzahl.')'; } echo '</td>
					<td align="center">'; if (strlen($db_finder_ort) > 10){ echo substr($db_finder_ort, 0, 10) . '...'; }else echo $db_finder_ort; echo '</td>
					<td align="center"><a href="?menu=edit&id='.$db_id.'"><i class="material-icons">edit</i></a></td>
					<td align="center"><a href="?menu=list&action=delete&id='.$db_id.'" onclick="return window.confirm(\'Soll dieser Datensatz wirklich gelöscht werden?\');"><i class="material-icons">delete</i></a></td>
				</tr>
			';
			
			$date_before = $split_date[0];
			
		}
		
	}
	
?>
	<tr>
		<td colspan="2" class="listsum"><strong>Gesamt Ausgewildert:</strong></td>
		<td class="listsum"><strong><?php echo $sum_anzahl; ?></strong></td>
		<td colspan="3" class="listsum"></td>
	</tr>
	
	</tbody>
</table>