<h2>Kassenbuch</h2>

<?php

# Neuer Eintrag
if(isset($_POST['speichern'])) {
	
	$typ = $_POST['typ'];
	$datum = $_POST['datum'];
	$bezeichnung = $_POST['bezeichnung'];
	$kategorie = $_POST['kategorie'];
	$betrag = $_POST['betrag'];
	
	$query = "INSERT INTO `kassenbuch` (`mandant`, `typ`, `datum`, `bezeichnung`, `kategorie`, `betrag`) VALUES ('$session_mandant', '$typ', '$datum', '$bezeichnung', '$kategorie', '$betrag')";
	mysqli_query($mysqli, $query);
	
	echo '<ul class="erfolg">Eintrag gespeichert...</ul><br />';
	
}

# Datensatz löschen
if($action == "delete") {
	
	$query = "DELETE FROM `kassenbuch` WHERE `mandant`='$session_mandant' AND `id`='$_GET[id]'";
	mysqli_query($mysqli, $query);
			
	echo '<ul class="fehler">Datensatz wurde gelöscht!</ul><br />';
	
}

?>

<h4>Neuer Eintrag</h4>

<form class="col s12 m6 l2 offset-m4 offset-l5" name="kassenbuch" action="?menu=money" method="POST" enctype="multipart/form-data">
	<p>
		<label>
			<input name="typ" type="radio" value="1" checked required />
			<span>Einnahme</span>
		</label>
		<label>
			<input name="typ" type="radio" value="2" required />
			<span>Ausgabe</span>
		</label>
	</p>
	<div class="input-field center-align">
		<input name="datum" type="date" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>" required>
	</div>
	<div class="input-field center-align">
		<input type="text" id="bezeichnung" name="bezeichnung" autocomplete="off" list="bez" value="" required>
		<label for="bezeichnung">Bezeichnung</label>
		<datalist id="bez">
			<?php
			
				$query = "SELECT `bezeichnung` FROM `kassenbuch` WHERE `mandant`='$session_mandant' GROUP BY `bezeichnung` ORDER BY `bezeichnung` ASC";
				if($result = mysqli_query($mysqli, $query)) {
					while($row = $result->fetch_array(MYSQLI_BOTH)) {
						
						$db_bezeichnung = $row['bezeichnung'];
						
						echo '
							<option value="'.$db_bezeichnung.'">
						';

					}
					
				}
				
			?>
		</datalist>
	</div>
	<div class="input-field center-align">
		<input type="text" id="kategorie" name="kategorie" autocomplete="off" list="kat" value="" required>
		<label for="kategorie">Kategorie</label>
		<datalist id="kat">
			<option value="Spende">
			<?php
			
				$query = "SELECT `kategorie` FROM `kassenbuch` WHERE `mandant`='$session_mandant' GROUP BY `kategorie` ORDER BY `kategorie` ASC";
				if($result = mysqli_query($mysqli, $query)) {
					while($row = $result->fetch_array(MYSQLI_BOTH)) {
						
						$db_kategorie = $row['kategorie'];
						
						echo '
							<option value="'.$db_kategorie.'">
						';

					}
					
				}
				
			?>
		</datalist>
	</div>
	<div class="input-field center-align">
		<input type="number" id="betrag" name="betrag" step="0.01" autocomplete="off" value="" required>
		<label for="betrag">Betrag</label>
	</div>
	<div class="input-field center-align">
		<button class="btn waves-effect waves-light <?php echo $colorclass; ?>" type="submit" name="speichern">Speichern
			<i class="material-icons right">save</i>
		</button>
	</div>
</form>

<br />


<?php

# Statistikjahre
if(!empty($_GET['statyear'])) {
	
	$statyear = $_GET['statyear'];
	
}
else $statyear = date("Y", time());

echo '<h3>Einnahmen & Ausgaben ('.$statyear.')</h3>';

$query = "SELECT YEAR(datum) AS 'year' FROM `kassenbuch` WHERE `mandant`='$session_mandant' GROUP BY `year` ORDER BY `year` DESC";
if($result = mysqli_query($mysqli, $query)) {
	while($row = $result->fetch_array(MYSQLI_BOTH)) {
		
		echo '
			<button class="waves-effect waves-light btn-small '.$colorclass; if($statyear == $row['year']) { echo ' active';} echo '" type="submit" onclick="self.location.href=\'?menu=money&statyear='.$row['year'].'\'">'.$row['year'].'</button>
		';

	}
	
}

$summe_spenden = 0;

?>

<br />

<h4>Übersicht</h4>
<button class="btn waves-effect waves-light green" name="einnahmen"><span id="btn_einnahmen"></span></button>
<button class="btn waves-effect waves-light red" name="ausgaben"><span id="btn_ausgaben"></span></button>

<br />

<h4>Einnahmen</h4>
<table class="striped centered">
	<thead>
		<tr>
			<th>Datum</th>
			<th>Bezeichnung</th>
			<th>Kategorie</th>
			<th>Betrag</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
		
		# Einnahmen
		$gesamt_einnahmen = 0;
				
		$query = "SELECT * FROM `kassenbuch` WHERE `mandant`='$session_mandant' AND `typ`='1' AND `datum` like '$statyear%' ORDER BY `datum` DESC";
		if($result = mysqli_query($mysqli, $query)) {
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
				
				$db_id = $row['id'];
				$db_datum = $row['datum'];
				$db_bezeichnung = $row['bezeichnung'];
				$db_kategorie = $row['kategorie'];
				$db_betrag = $row['betrag'];
				
				echo '
					<tr>
						<td align="center">'.$db_datum.'</td>
						<td align="center">'.$db_bezeichnung.'</td>
						<td align="center">'.$db_kategorie.'</td>
						<td align="center">'.$db_betrag.' €</td>
						<td align="center"><a href="?menu=money&action=delete&id='.$db_id.'" onclick="return window.confirm(\'Soll dieser Datensatz wirklich gelöscht werden?\');"><i class="material-icons">delete</i></a></td>
					</tr>
				';
				
				$gesamt_einnahmen = (int)$gesamt_einnahmen + (int)$db_betrag;

			}
			
		}
		
		$query = "SELECT sum(finder_spende_betrag) as spenden FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%'";
		if($result = mysqli_query($mysqli, $query)) {
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
								
				$summe_spenden = $summe_spenden + $row['spenden'];

			}
			
			echo '
				<tr>
					<td align="center">'.$statyear.'</td>
					<td align="center">Spenden von Findern</td>
					<td align="center">Spende</td>
					<td align="center">'.$summe_spenden.' €</td>
					<td align="center"></td>
				</tr>
			';
			
		}
		
	?>
		<tr>
			<td colspan="3"><strong>Gesamt</strong></td>
			<td align="center" id="einnahmen"><strong><?php echo (int)$gesamt_einnahmen + (int)$summe_spenden; ?> €</strong></td>
			<td></td>
		</tr>
	</tbody>
</table>

<br />

<h4>Ausgaben</h4>
<table class="striped centered">
	<thead>
		<tr>
			<th>Datum</th>
			<th>Bezeichnung</th>
			<th>Kategorie</th>
			<th>Betrag</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
		
		# Ausgaben
		
		$gesamt_ausgaben = 0;
				
		$query = "SELECT * FROM `kassenbuch` WHERE `mandant`='$session_mandant' AND `typ`='2' AND `datum` like '$statyear%' ORDER BY `datum` DESC";
		if($result = mysqli_query($mysqli, $query)) {
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
				
				$db_id = $row['id'];
				$db_datum = $row['datum'];
				$db_bezeichnung = $row['bezeichnung'];
				$db_kategorie = $row['kategorie'];
				$db_betrag = $row['betrag'];
				
				echo '
					<tr>
						<td align="center">'.$db_datum.'</td>
						<td align="center">'.$db_bezeichnung.'</td>
						<td align="center">'.$db_kategorie.'</td>
						<td align="center">'.$db_betrag.' €</td>
						<td align="center"><a href="?menu=money&action=delete&id='.$db_id.'" onclick="return window.confirm(\'Soll dieser Datensatz wirklich gelöscht werden?\');"><i class="material-icons">delete</i></a></td>
					</tr>
				';
				
				$gesamt_ausgaben = (int)$gesamt_ausgaben + (int)$db_betrag;

			}
			
		}
		
	?>
		<tr>
			<td colspan="3"><strong>Gesamt</strong></td>
			<td align="center" id="ausgaben"><strong><?php echo $gesamt_ausgaben; ?> €</strong></td>
			<td></td>
		</tr>
	</tbody>
</table>