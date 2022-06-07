<h2>Bestandsliste</h2>

<?php

# Datensatz löschen
if($action == "delete") {
	
	$query = "UPDATE `aufnahmebuch` SET `papierkorb`='1' WHERE `mandant`='$session_mandant' AND `id`='$_GET[id]'";
	mysqli_query($mysqli, $query);
			
	echo '<ul class="fehler">Datensatz wurde in den Papierkorb geworfen!</ul><br />';
	
}


# Ausgewählten Tab festlegen
if(!empty($_GET['tab'])) {
	
	$tab = $_GET['tab'];
	
}
else $tab = '1';

?>

<div class="row">
	<div class="col s12">
	
		<form class="valign-wrapper left" action="<?php echo $_SERVER['PHP_SELF'].'?menu=list'; ?>" method="POST">
			<div class="input-field">
				<input id="keyword" name="keyword" type="text" value="<?php if(!empty($_POST['keyword'])) { echo $_POST['keyword']; } ?>">
				<label for="keyword">Suche nach...</label>
			</div>
				
			<button class="btn waves-effect waves-light <?php echo $colorclass; ?>" type="submit" name="search" style="margin-left: 10px;">
				<i class="material-icons prefix">search</i>
			</button>
		</form>
	
	</div>
</div>
<div class="row">
	<div class="col s12">
	
		<a href="?menu=list&tab=1" class="waves-effect waves-light btn-small">Bestand</a>
		<a href="?menu=list&tab=2" class="waves-effect waves-light btn-small">Ausgewildert</a>
		<a href="?menu=list&tab=3" class="waves-effect waves-light btn-small">Weitergeleitet</a>
		<a href="?menu=list&tab=4" class="waves-effect waves-light btn-small">Verstorben</a>
		<a href="?menu=list&tab=5" class="waves-effect waves-light btn-small">Euthanasiert</a>
		
	</div>
</div>


<?php

	if(isset($_POST['search'])) {
		
		include('list_search.php');
		
	}
	else {
	
		switch($tab) {
			
			case 1: $query_condition = "`vogel_anzahl`!=vogel_ausgewildert+vogel_euthanasiert+vogel_verstorben+vogel_weitergeleitet"; $header = 'Bestand';
			break;
			
			case 2: $query_condition = "`vogel_ausgewildert`>0"; $header = 'Ausgewildert';
			break;
			
			case 3: $query_condition = "`vogel_weitergeleitet`>0"; $header = 'Weitergeleitet';
			break;
			
			case 4: $query_condition = "`vogel_verstorben`>0"; $header = 'Verstorben';
			break;
			
			case 5: $query_condition = "`vogel_euthanasiert`>0"; $header = 'Euthanasiert';
			break;
			
		}

		echo '<h3>'.$header.'</h3>';

		// Nach Jahren aufteilen
		$query = "SELECT * FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `papierkorb`='0' AND $query_condition	GROUP BY YEAR(datum) ORDER BY `datum` DESC";
		if($result = mysqli_query($mysqli, $query)) {
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
				
				$datum = $row['datum'];
				$datumjahr = explode("-", $datum);
				$datumjahr = $datumjahr[0];
				
				echo '
					<table class="striped centered">
						<thead>
							<tr>
								<th colspan="6">'.$datumjahr.'</th>
							</tr>
							<tr>
								<th onclick="self.location.href=\'?menu=list&rows='.$rows.'&order=datum\'">Datum</th>
								<th onclick="self.location.href=\'?menu=list&rows='.$rows.'&order=vogel_art\'">Art</th>
								<th onclick="self.location.href=\'?menu=list&rows='.$rows.'&order=vogel_anzahl\'">Anzahl</th>
								<th onclick="self.location.href=\'?menu=list&rows='.$rows.'&order=finder_ort\'">Ort</th>
								<th colspan="2"></th>
							</tr>
						</thead>
						<tbody>
				';
				
				$query2 = "SELECT * FROM `aufnahmebuch` WHERE `datum` LIKE '$datumjahr%' AND `mandant`='$session_mandant' AND `papierkorb`='0' AND $query_condition ORDER BY `datum` DESC";
				$sum_anzahl = 0;
				
				if($result2 = mysqli_query($mysqli, $query2)) {
					while($row2 = $result2->fetch_array(MYSQLI_BOTH)) {
						
						$db_id = $row2['id'];
						$db_datum = $row2['datum'];
						$split_date = explode("-", $db_datum);
						$db_vogel_art = $row2['vogel_art'];
						$db_vogel_stadium = $row2['vogel_stadium'];
						$db_vogel_anzahl = $row2['vogel_anzahl'];
						$db_vogel_foto_name = $row2['vogel_foto_name'];
						$db_finder_ort = $row2['finder_ort'];
						$db_vogel_ausgewildert = $row2['vogel_ausgewildert'];
						$db_vogel_weitergeleitet = $row2['vogel_weitergeleitet'];
						$db_vogel_verstorben = $row2['vogel_verstorben'];
						$db_vogel_euthanasiert = $row2['vogel_euthanasiert'];
						
						switch($tab) {
				
							case 1: $anz = $db_vogel_anzahl-$db_vogel_ausgewildert-$db_vogel_verstorben-$db_vogel_euthanasiert-$db_vogel_weitergeleitet;
							break;
							
							case 2: $anz = $db_vogel_ausgewildert;
							break;
							
							case 3: $anz = $db_vogel_weitergeleitet;
							break;
							
							case 4: $anz = $db_vogel_verstorben;
							break;
							
							case 5: $anz = $db_vogel_euthanasiert;
							break;
							
						}
						
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
						
						echo '
							<tr>
								<td align="center">'.$split_date[2].'.'.$split_date[1].'.</td>
								<td align="center">'; if(!empty($db_vogel_foto_name)) { echo '<a href="?menu=list&action=show&id='.$db_id.'">'.$db_vogel_art.' ('.$db_vogel_stadium.')</a>'; }else echo $db_vogel_art.' ('.$db_vogel_stadium.')'; echo '</td>
								<td align="center">'.$anz.' ('.$db_vogel_anzahl.')</td>
								<td align="center">'; if (strlen($db_finder_ort) > 10){ echo substr($db_finder_ort, 0, 10) . '...'; }else echo $db_finder_ort; echo '</td>
								<td align="center"><a href="?menu=edit&id='.$db_id.'"><i class="material-icons">edit</i></a></td>
								<td align="center"><a href="?menu=list&action=delete&id='.$db_id.'" onclick="return window.confirm(\'Soll dieser Datensatz wirklich gelöscht werden?\');"><i class="material-icons">delete</i></a></td>
							</tr>
						';
						
					}
					
					echo '
							</tbody>
							<thead>
								<tr>
									<th></th>
									<th><strong>Gesamt:</strong></th>
									<th><strong>'.$sum_anzahl.'</strong></th>
									<th colspan="3"></th>
								</tr>
							</thead>
						</table>
						
						<br /><br />
					';
					
				}
				
			}
			
		}
		
	}

?>
