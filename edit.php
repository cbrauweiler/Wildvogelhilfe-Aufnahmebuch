<h2>Fundvogel bearbeiten</h2>

<?php
if(isset($_POST['speichern'])) {
	
	$datum = $_POST['datum'];
	$lfdn = $_POST['lfdn'];
	$finder_vorname = $_POST['finder_vorname'];
	$finder_name = $_POST['finder_name'];
	$finder_strasse = $_POST['finder_strasse'];
	$finder_hausnummer = $_POST['finder_hausnummer'];
	$finder_plz = $_POST['finder_plz'];
	$finder_ort = $_POST['finder_ort'];
	$finder_email = $_POST['finder_email'];
	$finder_telefon = $_POST['finder_telefon'];
	$finder_spende = $_POST['finder_spende'];
	$finder_spende_betrag = $_POST['finder_spende_betrag'];
	$finder_spendenbescheinigung = $_POST['finder_spendenbescheinigung'];
	if(empty($finder_spendenbescheinigung)) { $finder_spendenbescheinigung = '0'; }
	
	$vogel_foto_loeschen = $_POST['vogel_foto_loeschen'];
	
	if($vogel_foto_loeschen == 'on') {
		
		$vogel_foto_info = getimagesize($_FILES['vogel_foto']['tmp_name']);
		$vogel_foto_filename = basename($_FILES['vogel_foto']['name']);
		$vogel_foto_filetype = $vogel_foto_info['mime'];
		$vogel_foto_content_base64 = base64_encode(file_get_contents($_FILES['vogel_foto']['tmp_name']) );
		$vogel_foto_content = 'data:'.$vogel_foto_filetype.';base64,'.$vogel_foto_content_base64;
		
	}
	else {
			
		$vogel_foto_content = '';
		$vogel_foto_filename = '';
		
	}
	
	$vogel_art = $_POST['vogel_art'];
	$vogel_anzahl = $_POST['vogel_anzahl'];
	$vogel_fundumstaende = $_POST['vogel_fundumstaende'];
	$vogel_stadium = $_POST['vogel_stadium'];
	$vogel_gewicht = $_POST['vogel_gewicht'];
	$vogel_verletzungen = $_POST['vogel_verletzungen'];
	$vogel_katzenopfer = $_POST['vogel_katzenopfer'];
	$vogel_anflugtrauma = $_POST['vogel_anflugtrauma'];
	$vogel_arztbesuch = $_POST['vogel_arztbesuch'];
	$vogel_medikation = $_POST['vogel_medikation'];
	$vogel_fehlfuetterung = $_POST['vogel_fehlfuetterung'];
	$vogel_parasiten_advocate = $_POST['vogel_parasiten_advocate']; if(empty($vogel_parasiten_advocate)) { $vogel_parasiten_advocate = '0000-00-00'; }
	$vogel_parasiten_baycoxx = $_POST['vogel_parasiten_baycoxx']; if(empty($vogel_parasiten_baycoxx)) { $vogel_parasiten_baycoxx = '0000-00-00'; }
	$vogel_parasiten_sonstige = $_POST['vogel_parasiten_sonstige'];
	$vogel_verstorben = $_POST['vogel_verstorben'];
	$vogel_verstorbendatum = $_POST['vogel_verstorbendatum']; if(empty($vogel_verstorbendatum)) { $vogel_verstorbendatum = '0000-00-00'; }
	$vogel_euthanasiert = $_POST['vogel_euthanasiert'];
	$vogel_euthanasiertdatum = $_POST['vogel_euthanasiertdatum']; if(empty($vogel_euthanasiertdatum)) { $vogel_euthanasiertdatum = '0000-00-00'; }
	$vogel_ausgewildert = $_POST['vogel_ausgewildert'];
	$vogel_auswilderungsdatum = $_POST['vogel_auswilderungsdatum']; if(empty($vogel_auswilderungsdatum)) { $vogel_auswilderungsdatum = '0000-00-00'; }
	$vogel_weitergeleitet = $_POST['vogel_weitergeleitet'];
	if(empty($vogel_weitergeleitet)) { $vogel_weitergeleitet = '0'; }
	$vogel_weiterleitungsdatum = $_POST['vogel_weiterleitungsdatum']; if(empty($vogel_weiterleitungsdatum)) { $vogel_weiterleitungsdatum = '0000-00-00'; }
	$vogel_weiterleitungan = $_POST['vogel_weiterleitungan'];
	
	
	$query = "UPDATE `aufnahmebuch` SET `datum`='$datum', `lfdn`='$lfdn', `finder_vorname`='$finder_vorname', `finder_name`='$finder_name', `finder_strasse`='$finder_strasse', `finder_hausnummer`='$finder_hausnummer', `finder_plz`='$finder_plz', `finder_ort`='$finder_ort', `finder_email`='$finder_email', `finder_telefon`='$finder_telefon', `finder_spende`='$finder_spende', `finder_spende_betrag`='$finder_spende_betrag', `finder_spendenbescheinigung`='$finder_spendenbescheinigung', `vogel_foto`='$vogel_foto_content', `vogel_foto_name`='$vogel_foto_filename', `vogel_art`='$vogel_art', `vogel_anzahl`='$vogel_anzahl', `vogel_fundumstaende`='$vogel_fundumstaende', `vogel_stadium`='$vogel_stadium', `vogel_gewicht`='$vogel_gewicht', `vogel_verletzungen`='$vogel_verletzungen', `vogel_katzenopfer`='$vogel_katzenopfer', `vogel_anflugtrauma`='$vogel_anflugtrauma', `vogel_arztbesuch`='$vogel_arztbesuch', `vogel_medikation`='$vogel_medikation', `vogel_fehlfuetterung`='$vogel_fehlfuetterung', `vogel_parasiten_advocate`='$vogel_parasiten_advocate', `vogel_parasiten_baycoxx`='$vogel_parasiten_baycoxx', `vogel_parasiten_sonstige`='$vogel_parasiten_sonstige', `vogel_ausgewildert`='$vogel_ausgewildert', `vogel_verstorben`='$vogel_verstorben', `vogel_verstorbendatum`='$vogel_verstorbendatum', `vogel_euthanasiert`='$vogel_euthanasiert', `vogel_euthanasiertdatum`='$vogel_euthanasiertdatum', `vogel_auswilderungsdatum`='$vogel_auswilderungsdatum', `vogel_weitergeleitet`='$vogel_weitergeleitet', `vogel_weiterleitungsdatum`='$vogel_weiterleitungsdatum', `vogel_weiterleitungan`='$vogel_weiterleitungan' WHERE `mandant`='$session_mandant' AND `id`='$_GET[id]'";
	#echo '<br /><br />'.$query;
	mysqli_query($mysqli, $query);
	
	echo '<ul class="erfolg">Datensatz gespeichert...</ul><br />';
	
}
	
$query = "SELECT * FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `id`='$_GET[id]'";
if($result = mysqli_query($mysqli, $query)) {
	if($row = $result->fetch_array(MYSQLI_BOTH)) {
		
		$db_id = $row['id'];
		$db_datum = $row['datum'];
		$db_lfdn = $row['lfdn'];
		
		$db_finder_vorname = $row['finder_vorname'];
		$db_finder_name = $row['finder_name'];
		$db_finder_strasse = $row['finder_strasse'];
		$db_finder_hausnummer = $row['finder_hausnummer'];
		$db_finder_plz = $row['finder_plz'];
		$db_finder_ort = $row['finder_ort'];
		$db_finder_email = $row['finder_email'];
		$db_finder_telefon = $row['finder_telefon'];
		$db_finder_spende = $row['finder_spende'];
		$db_finder_spende_betrag = $row['finder_spende_betrag'];
		$db_finder_spendenbescheinigung = $row['finder_spendenbescheinigung'];
		
		$db_vogel_foto = $row['vogel_foto'];
		$db_vogel_foto_name = $row['vogel_foto_name'];
		$db_vogel_art = $row['vogel_art'];
		$db_vogel_fundumstaende = $row['vogel_fundumstaende'];
		$db_vogel_anzahl = $row['vogel_anzahl'];
		$db_vogel_stadium = $row['vogel_stadium'];
		$db_vogel_gewicht = $row['vogel_gewicht'];
		$db_vogel_verletzungen = $row['vogel_verletzungen'];
		$db_vogel_katzenopfer = $row['vogel_katzenopfer'];
		$db_vogel_anflugtrauma = $row['vogel_anflugtrauma'];
		$db_vogel_arztbesuch = $row['vogel_arztbesuch'];
		$db_vogel_medikation = $row['vogel_medikation'];
		$db_vogel_fehlfuetterung = $row['vogel_fehlfuetterung'];
		$db_vogel_parasiten_advocate = $row['vogel_parasiten_advocate'];
		$db_vogel_parasiten_baycoxx = $row['vogel_parasiten_baycoxx'];
		$db_vogel_parasiten_sonstige = $row['vogel_parasiten_sonstige'];
		$db_vogel_verstorben = $row['vogel_verstorben'];
		$db_vogel_verstorbendatum = $row['vogel_verstorbendatum'];
		$db_vogel_euthanasiert = $row['vogel_euthanasiert'];
		$db_vogel_euthanasiertdatum = $row['vogel_euthanasiertdatum'];
		$db_vogel_ausgewildert = $row['vogel_ausgewildert'];
		$db_vogel_auswilderungsdatum = $row['vogel_auswilderungsdatum'];
		$db_vogel_weitergeleitet = $row['vogel_weitergeleitet'];
		$db_vogel_weiterleitungsdatum = $row['vogel_weiterleitungsdatum'];
		$db_vogel_weiterleitungan = $row['vogel_weiterleitungan'];

?>

<form class="col s12" name="editieren" action="?menu=edit&id=<?php echo $db_id; ?>" method="POST" enctype="multipart/form-data" onsubmit="return validate()">
	
	<div class="row">
		<div class="input-field col s3">
			<label>						  
				<input type="date" name="datum" value="<?php echo $db_datum; ?>" max="<?php echo date("Y-m-d"); ?>" class="validate" required>
				<span>Aufnahmedatum</span>
			</label>
		</div>
	</div>
	
	<br /><br /><br />
		
	<?php if($form_lfdn_bearbeiten == 'on') {?>
	<div class="row">
		<div class="input-field col s3">
			<input type="text" id="lfdn" name="lfdn" value="<?php echo $db_lfdn; ?>" autocomplete="off" <?php if($form_lfdn_pflicht == 'on') { echo ' class="validate" required'; } ?>>
			<label for="lfdn">Laufende Nummer</label>
		</div>
	</div>
	<?php } ?>
	
	<br /><br /><br />
	
	<div class="row">		
		<h4 class="col s12">Finderdaten</h4>
		
		<div class="input-field col s12">
			<input id="finder_vorname" name="finder_vorname" type="text" value="<?php echo $db_finder_vorname; ?>" autocomplete="off" <?php if($form_vorname_pflicht == 'on') { echo ' class="validate" required'; } ?>>
			<label for="finder_vorname">Vorname</label>
		</div>
		
		<div class="input-field col s12">
			<input id="finder_name" name="finder_name" type="text" value="<?php echo $db_finder_name; ?>" autocomplete="off" <?php if($form_nachname_pflicht == 'on') { echo ' class="validate" required'; } ?>>
			<label for="finder_name">Nachname</label>
		</div>
		
		<div class="input-field col s8">
			<input id="finder_strasse" name="finder_strasse" type="text" value="<?php echo $db_finder_strasse; ?>" autocomplete="off" <?php if($form_strhsnr_pflicht == 'on') { echo ' class="validate" required'; } ?>>
			<label for="finder_strasse">Straße</label>
		</div>
		<div class="input-field col s4">
			<input id="finder_hausnummer" name="finder_hausnummer" type="number" value="<?php echo $db_finder_hausnummer; ?>" autocomplete="off" <?php if($form_strhsnr_pflicht == 'on') { echo ' class="validate" required'; } ?>>
			<label for="finder_hausnummer">Hausnummer</label>
		</div>
		
		<div class="input-field col s6">
			<input id="finder_plz" list="plz" name="finder_plz" type="text" value="<?php echo $db_finder_plz; ?>" onblur="getort(this)" autocomplete="off" <?php if($form_strhsnr_pflicht == 'on') { echo ' class="validate" required'; } ?>>
			<label for="finder_plz">PLZ</label>
			<datalist id="plz"></datalist>
		</div>
		<div class="input-field col s6">		
			<input id="finder_ort" list="ort" name="finder_ort" type="text" value="<?php echo $db_finder_ort; ?>" onblur="getplz(this)" autocomplete="off" <?php if($form_strhsnr_pflicht == 'on') { echo ' class="validate" required'; } ?>>
			<label for="finder_ort">Ort</label>
			<datalist id="ort"></datalist>
		</div>
		
		<div class="input-field col s12">
			<input id="finder_email" name="finder_email" type="email" value="<?php echo $db_finder_email; ?>" autocomplete="off" <?php if($form_email_pflicht == 'on') { echo ' class="validate" required'; } ?>>
			<label for="finder_email">E-Mail</label>
		</div>
		
		<div class="input-field col s12">
			<input id="finder_telefon" name="finder_telefon" type="tel" value="<?php echo $db_finder_telefon; ?>" autocomplete="off" <?php if($form_telefon_pflicht == 'on') { echo ' class="validate" required'; } ?>>
			<label for="finder_telefon">Telefon</label>
		</div>
		
		<?php if($form_vogel_spende_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<p>
				<label>
					<input type="radio" name="finder_spende" value="0" class="validate" required <?php if($db_finder_spende == "0") { echo 'checked'; } ?> onclick="disable()" />
					<span>Keine Spende erhalten</span>
				</label>
			</p>
		</div>
		<div class="input-field col s6">
			<p>
				<label>
					<input type="radio" name="finder_spende" value="1" class="validate" required <?php if($db_finder_spende == "1") { echo 'checked'; } ?> onclick="enable()" />
					<span>Spende erhalten</span>
				</label>
			</p>
		</div>
		<div class="input-field col s6">
			<input id="finder_spende_betrag" id="finder_spende_betrag" name="finder_spende_betrag" type="text" value="<?php echo $db_finder_spende_betrag; ?>" autocomplete="off" <?php if($db_finder_spende == "0") { echo 'disabled'; } ?>>
			<label for="finder_spende_betrag">Spendenbetrag in Euro</label>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_spende_betrag_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<p>
				<label>
					<input type="checkbox" name="finder_spendenbescheinigung" value="1" <?php if($db_finder_spendenbescheinigung == "1") { echo 'checked'; } ?>>
					<span>Spendenbescheinigung ausgestellt?</span>
				</label>
			</p>
		</div>
		<?php } ?>
	</div>
	
	<div class="row">	
		<h4 class="col s12">Aufnahmedaten</h4>
		
		<?php if($form_vogel_foto_bearbeiten == 'on') {?>
		
		
			<?php
				
				if(!empty($db_vogel_foto_name)) {
					
					echo '
						<div class="input-field col s6">
							<img src="'.$db_vogel_foto.'" width="200" alt="'.$db_vogel_foto_name.'" title="'.$db_vogel_foto_name.'">
						</div>
						<div class="input-field col s6">
							<p>
								<label>
									<input type="checkbox" name="vogel_foto_loeschen">
									<span>Bild löschen?</span>
								</label>
							</p>
						</div>
					';
					
				}
				else {
					echo '
						<div class="file-field input-field col s12">
							<div class="btn waves-effect waves-light '.$colorclass.'">
								<span>Foto</span>
								<input type="file" name="vogel_foto" accept="image/*" '; if($form_vogel_foto_pflicht == 'on') { echo 'class="validate" required'; } echo '>
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text" placeholder="Upload one or more files">
							</div>
						</div>
					';
				}
			
			?>
		
		<?php } ?>
		
		<?php if($form_vogel_art_neu == 'on') { ?>
		<div class="input-field col s12">
			<input type="text" name="vogel_art" value="<?php echo $db_vogel_art; ?>" size="28" autocomplete="off" list="art"<?php if($form_vogel_art_pflicht == 'on') { echo 'class="validate" required'; } ?>>
			<label for="vogel_art">Art</label>
			<datalist id="art">
			<?php
			
				$query = "SELECT `vogel_art` FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' GROUP BY `vogel_art` ORDER BY `vogel_art` ASC";
				if($result = mysqli_query($mysqli, $query)) {
					while($row = $result->fetch_array(MYSQLI_BOTH)) {
						
						$db_vogel_art = $row['vogel_art'];
						
						echo '
							<option value="'.$db_vogel_art.'">
						';

					}
					
				}
				
			?>
			</datalist>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_anzahl_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<input type="number" name="vogel_anzahl" value="<?php echo $db_vogel_anzahl; ?>" autocomplete="off"<?php if($form_vogel_anzahl_pflicht == 'on') { echo 'class="validate" required'; } ?>>
			<label for="vogel_anzahl">Anzahl</label>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_fundumstaende_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<textarea class="materialize-textarea" name="vogel_fundumstaende" rows="5" cols="30"<?php if($form_vogel_fundumstaende_pflicht == 'on') { echo 'class="validate" required'; } ?>><?php echo $db_vogel_fundumstaende; ?></textarea>
			<label for="vogel_fundumstaende">Fundumstände</label>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_stadium_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<span>Stadium</span>
			<div class="row">
				<p class="col s12 m2">
					<label>
						<input type="radio" name="vogel_stadium" value="nestling"<?php if($form_vogel_stadium_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_stadium == "nestling") { echo ' checked'; } ?>>
						<span>Nestling</span>
					</label>
				</p>
				<p class="col s12 m2">
					<label>
						<input type="radio" name="vogel_stadium" value="nestling-befiedert"<?php if($form_vogel_stadium_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_stadium == "nestling-befiedert") { echo ' checked'; } ?>> 
						<span>Nestling (befiedert)</span>
					</label>
				</p>
				<p class="col s12 m2">
					<label>
						<input type="radio" name="vogel_stadium" value="aestling"<?php if($form_vogel_stadium_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_stadium == "aestling") { echo ' checked'; } ?>> 
						<span>Ästling</span>
					</label>
				</p>
				<p class="col s12 m2">
					<label>
						<input type="radio" name="vogel_stadium" value="juvenil"<?php if($form_vogel_stadium_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_stadium == "juvenil") { echo ' checked'; } ?>>
						<span>Juvenil</span>
					</label>
				</p>
				<p class="col s12 m2">
					<label>
						<input type="radio" name="vogel_stadium" value="adult"<?php if($form_vogel_stadium_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_stadium == "adult") { echo ' checked'; } ?>>
						<span>Adult</span>
					</label>
				</p>
			</div>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_gewicht_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<textarea class="materialize-textarea" name="vogel_gewicht" rows="5" cols="30"<?php if($form_vogel_gewicht_pflicht == 'on') { echo 'class="validate" required'; } ?>><?php echo $db_vogel_gewicht; ?></textarea>
			<label for="vogel_gewicht">Gewicht</label>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_verletzungen_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<textarea class="materialize-textarea" name="vogel_verletzungen" rows="5" cols="30"<?php if($form_vogel_verletzungen_pflicht == 'on') { echo 'class="validate" required'; } ?>><?php echo $db_vogel_verletzungen; ?></textarea>
			<label for="vogel_verletzungen">Befund</label>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_katzenopfer_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<span>Katzenopfer</span>
			<div class="row">
				<p class="col s3">
					<label>
						<input type="radio" name="vogel_katzenopfer" value="0" checked<?php if($form_vogel_katzenopfer_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_katzenopfer == "0") { echo ' checked'; } ?>>
						<span>Nein</span>
					</label>
				</p>
				<p class="col s3">
					<label>
						<input type="radio" name="vogel_katzenopfer" value="1"<?php if($form_vogel_katzenopfer_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_katzenopfer == "1") { echo ' checked'; } ?>>
						<span>Ja</span>
					</label>
				</p>
			</div>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_anflugtrauma_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<span>Anflugtrauma</span>
			<div class="row">
				<p class="col s3">
					<label>
						<input type="radio" name="vogel_anflugtrauma" value="0" checked<?php if($form_vogel_anflugtrauma_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_anflugtrauma == "0") { echo ' checked'; } ?>>
						<span>Nein</span>
					</label>
				</p>
				<p class="col s3">
					<label>
						<input type="radio" name="vogel_anflugtrauma" value="1"<?php if($form_vogel_anflugtrauma_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_anflugtrauma == "1") { echo ' checked'; } ?>>
						<span>Ja</span>
					</label>
				</p>
			</div>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_arztbesuch_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<span>Arztbesuch</span>
			<div class="row">
				<p class="col s3">
					<label>
						<input type="radio" name="vogel_arztbesuch" value="0" checked<?php if($form_vogel_arztbesuch_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_arztbesuch == "0") { echo ' checked'; } ?>>
						<span>Nein</span>
					</label>
				</p>
				<p class="col s3">
					<label>
						<input type="radio" name="vogel_arztbesuch" value="1"<?php if($form_vogel_arztbesuch_pflicht == 'on') { echo 'class="validate" required'; } ?> <?php if($db_vogel_arztbesuch == "1") { echo ' checked'; } ?>>
						<span>Ja</span>
					</label>
				</p>
			</div>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_medikation_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<textarea class="materialize-textarea" name="vogel_medikation" rows="5" cols="30"<?php if($form_vogel_medikation_pflicht == 'on') { echo 'class="validate" required'; } ?>><?php echo $db_vogel_medikation; ?></textarea>
			<label for="vogel_medikation">Medikation</label>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_fehlfuetterung_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<textarea class="materialize-textarea" name="vogel_fehlfuetterung" rows="5" cols="30"<?php if($form_vogel_fehlfuetterung_pflicht == 'on') { echo 'class="validate" required'; } ?>><?php echo $db_vogel_fehlfuetterung; ?></textarea>
			<label for="vogel_fehlfuetterung">Fehlfütterung</label>
		</div>
		<?php } ?>
		
		<?php if($form_vogel_parasitenbehandlung_bearbeiten == 'on') { ?>
		<div class="input-field col s12">
			<span>Parasitenbehandlung</span>
			<div class="row">
				<p class="col s3">
					<label>
						<input type="date" name="vogel_parasiten_advocate" value="<?php echo $db_vogel_parasiten_advocate; ?>" max="<?php echo date("Y-m-d"); ?>"<?php if($form_vogel_parasitenbehandlung_pflicht == 'on') { echo 'class="validate" required'; } ?>>
						<span>Advocate (Datum)</span>
					</label>
				</p>
				<p class="col s3">
					<label>
						<input type="date" name="vogel_parasiten_baycoxx" value="<?php echo $db_vogel_parasiten_baycoxx; ?>" max="<?php echo date("Y-m-d"); ?>"<?php if($form_vogel_parasitenbehandlung_pflicht == 'on') { echo 'class="validate" required'; } ?>>
						<span>Baycoxx (Datum)</span>
					</label>
				</p>
				<p class="col s6">
					<label>
						<textarea class="materialize-textarea" name="vogel_parasiten_sonstige" rows="5" cols="30"<?php if($form_vogel_parasitenbehandlung_pflicht == 'on') { echo 'class="validate" required'; } ?>><?php echo $db_vogel_parasiten_sonstige; ?></textarea>
						<span>Sonstige</span>
					</label>
				</p>
			</div>
		</div>
		<?php } ?>		
		
		<?php if($form_vogel_verstorben_bearbeiten == 'on') { ?>
		<div class="input-field col s3">
			<input type="number" name="vogel_verstorben" value="<?php echo $db_vogel_verstorben; ?>"<?php if($form_vogel_verstorben_pflicht == 'on') { echo 'class="validate" required'; } ?>>
			<label for="vogel_verstorben">Verstorben</label>
		</div>
		<p class="col s9">
			<label>
				<input type="date" name="vogel_verstorbendatum" value="<?php echo $db_vogel_verstorbendatum; ?>" max="<?php echo date("Y-m-d"); ?>"<?php if($form_vogel_verstorben_pflicht == 'on') { echo 'class="validate" required'; } ?>>
				<span>Datum</span>
			</label>
		</p>
		<?php } ?>
		
		<?php if($form_vogel_euthanasiert_bearbeiten == 'on') { ?>
		<div class="input-field col s3">
			<input type="number" name="vogel_euthanasiert" value="<?php echo $db_vogel_euthanasiert; ?>"<?php if($form_vogel_euthanasiert_pflicht == 'on') { echo 'class="validate" required'; } ?>>
			<label for="vogel_euthanasiert">Euthanasiert</label>
		</div>
		<p class="col s9">
			<label>
				<input type="date" name="vogel_euthanasiertdatum" value="<?php echo $db_vogel_euthanasiertdatum; ?>" max="<?php echo date("Y-m-d"); ?>"<?php if($form_vogel_euthanasiert_pflicht == 'on') { echo 'class="validate" required'; } ?>>
				<span>Datum</span>
			</label>
		</p>
		<?php } ?>
		
		<?php if($form_vogel_weitergeleitet_bearbeiten == 'on') { ?>
		<div class="input-field col s3">
			<input type="number" name="vogel_weitergeleitet" value="<?php echo $db_vogel_weitergeleitet; ?>"<?php if($form_vogel_weitergeleitet_pflicht == 'on') { echo 'class="validate" required'; } ?>>
			<label for="vogel_weitergeleitet">Weitergeleitet</label>
		</div>
		<p class="col s3">
			<label>
				<input type="date" name="vogel_weiterleitungsdatum" value="<?php echo $db_vogel_weiterleitungsdatum; ?>" max="<?php echo date("Y-m-d"); ?>"<?php if($form_vogel_weitergeleitet_pflicht == 'on') { echo 'class="validate" required'; } ?>>
				<span>Datum</span>
			</label>
		</p>
		<p class="col s6">
			<label>
				<textarea class="materialize-textarea" name="vogel_weiterleitungan" rows="5" cols="30"<?php if($form_vogel_weitergeleitet_pflicht == 'on') { echo 'class="validate" required'; } ?>><?php echo $db_vogel_weiterleitungan; ?></textarea>
				<span>Weitergeleitet an...</span>
			</label>
		</p>
		<?php } ?>
		
		<?php if($form_vogel_ausgewildert_bearbeiten == 'on') { ?>
		<div class="input-field col s3">
			<input type="number" name="vogel_ausgewildert" value="<?php echo $db_vogel_ausgewildert; ?>" <?php if($form_vogel_ausgewildert_pflicht == 'on') { echo 'class="validate" required'; } ?>>
			<label for="vogel_ausgewildert">Ausgewildert</label>
		</div>
		<p class="col s9">
			<label>
				<input type="date" name="vogel_auswilderungsdatum" value="<?php echo $db_vogel_auswilderungsdatum; ?>" max="<?php echo date("Y-m-d"); ?>"<?php if($form_vogel_ausgewildert_pflicht == 'on') { echo 'class="validate" required'; } ?>>
				<span>Datum</span>
			</label>
		</p>
		<?php } ?>
		
		<div class="row">
			<div class="input-field col s12 center-align">
				<button class="btn waves-effect waves-light <?php echo $colorclass; ?>" type="submit" name="speichern">Eintrag speichern
					<i class="material-icons right">save</i>
				</button>
			</div>
		</div>
		
	</div>
</form>

<?php
		
	}

}

?>