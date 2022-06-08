<h2>Einstellungen</h2>

<?php

# Benutzer löschen
if($action == 'deluser' && $session_mandant <= '2') {
	
	$delid = $_GET['mandant'];
	
	$query = "DELETE FROM `benutzer` WHERE `mandant`='$delid';";
	mysqli_query($mysqli, $query);
	
	$query = "DELETE FROM `einstellungen` WHERE `mandant`='$delid';";
	mysqli_query($mysqli, $query);
	
	$query = "DELETE FROM `aufnahmebuch` WHERE `mandant`='$delid';";
	mysqli_query($mysqli, $query);
	
	$query = "DELETE FROM `kassenbuch` WHERE `mandant`='$delid';";
	mysqli_query($mysqli, $query);

	echo '<ul class="warnung">Benutzer wurde gelöscht...</ul><br />';
}


# Passwort ändern
if(isset($_POST['passwort_aendern'])) {

	$passwort1 = htmlspecialchars($_POST['passwort1']);
	$passwort2 = htmlspecialchars($_POST['passwort2']);
	
	if($passwort1 == $passwort2) {
		
		$newpass = password_hash($passwort1, PASSWORD_DEFAULT);
		
		$query = "UPDATE `benutzer` SET `passwort`='$newpass' WHERE `mandant`='$session_mandant'";
		mysqli_query($mysqli, $query);
		
		echo '<ul class="erfolg">Passwort geändert...</ul><br />';
		
	}
	else echo '<ul class="fehler">Die Passwörter stimmen nicht überein!</ul><br />';
	
}


# Neuer Benutzer
if(isset($_POST['neu'])) {
	
	$neu_mandant = $_POST['mandant'];
	$neu_benutzername = htmlspecialchars($_POST['benutzername']);
	$neu_passwort = htmlspecialchars($_POST['passwort']);
	$neu_passwort = password_hash($neu_passwort, PASSWORD_DEFAULT);
	$neu_email = htmlspecialchars($_POST['email']);
	
	$query_benutzer = "INSERT INTO `benutzer` (`benutzername`, `passwort`, `email`) VALUES ('$neu_benutzername', '$neu_passwort', '$neu_email')";
	mysqli_query($mysqli, $query_benutzer);
	
	$query_einstellungen = "INSERT INTO `einstellungen` (`mandant`) VALUES ('$neu_mandant')";
	mysqli_query($mysqli, $query_einstellungen);
	
	echo '<ul class="erfolg">Neuer Benutzer angelegt...</ul><br />';
	
}

?>

<h4>Passwort ändern</h4>
<form class="col s12" name="passwort" action="<?php echo '?menu=settings' ?>" method="POST">

	<div class="row">
	
		<div class="input-field col s12 m4">
			<input class="validate" type="password" id="passwort1" name="passwort1" size="28" autocomplete="off" required>
			<label for="passwort1">Neues Passwort</label>
		</div>
		<div class="input-field col s12 m4">
			<input class="validate" type="password" id="passwort2" name="passwort2" size="28" autocomplete="off" required>
			<label for="passwort2">Neues Passwort bestätigen</label>
		</div>
		<div class="input-field col s12 m4 center-align">
			<button class="btn waves-effect waves-light <?php echo $colorclass; ?>" type="submit" name="passwort_aendern">Neues Passwort speichern
				<i class="material-icons right">save</i>
			</button>
		</div>
		
	</div>
	
</form>

<form class="col s12" name="einstellungen" action="<?php echo '?menu=settings' ?>" method="POST">	
	<div class="row">
	
		
	
	</div>
</form>

<br /><br />

<form class="col s12" name="formularfelder" action="<?php echo '?menu=settings' ?>" method="POST">

<h4>Farbenschema</h4>

	<div class="row">
		<div class="card-panel white-text green accent-3 col s12 m3 center-align" id="green" onclick="setcolor(this);" style="cursor: pointer;">Hell-Grün</div>
		<div class="card-panel white-text green darken-3 col s12 m3 center-align" id="darkgreen" onclick="setcolor(this);" style="cursor: pointer;">Grün</div>
		<div class="card-panel white-text teal darken-4 col s12 m3 center-align" id="teal" onclick="setcolor(this);" style="cursor: pointer;">Blau-Grün</div>
		<div class="card-panel white-text cyan darken-3 col s12 m3 center-align" id="cyan" onclick="setcolor(this);" style="cursor: pointer;">Türkis</div>
		<div class="card-panel white-text light-blue accent-4 col s12 m3 center-align" id="lightblue" onclick="setcolor(this);" style="cursor: pointer;">Hell-Blau</div>
		<div class="card-panel white-text blue darken-3 col s12 m3 center-align" id="blue" onclick="setcolor(this);" style="cursor: pointer;">Blau</div>
		<div class="card-panel white-text purple darken-4 col s12 m3 center-align" id="purple" onclick="setcolor(this);" style="cursor: pointer;">Lila</div>
		<div class="card-panel white-text red darken-4 col s12 m3 center-align" id="red" onclick="setcolor(this);" style="cursor: pointer;">Rot</div>
	</div>

<br /><br />

<h4>Eingabeformular</h4>

	<div class="row">
		<span class="col s3 center-align"><strong>Eingabefeld</strong></span>
		<span class="col s3 center-align"><strong>Neu</strong></span>
		<span class="col s3 center-align"><strong>Bearbeiten</strong></span>
		<span class="col s3 center-align"><strong>Pflichtfeld</strong></span>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Laufende Nummer</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_lfdn_neu" onchange="savesettings(this);"<?php if($form_lfdn_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_lfdn_bearbeiten" onchange="savesettings(this);"<?php if($form_lfdn_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_lfdn_pflicht" onchange="savesettings(this);"<?php if($form_lfdn_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Vorname</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vorname_neu" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vorname_bearbeiten" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vorname_pflicht" onchange="savesettings(this);"<?php if($form_vorname_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Nachname</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_nachname_neu" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_nachname_bearbeiten" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus<input type="checkbox" name="form_nachname_pflicht" onchange="savesettings(this);"<?php if($form_nachname_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Straße & Hausnummer</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_strhsnr_neu" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_strhsnr_bearbeiten" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_strhsnr_pflicht" onchange="savesettings(this);"<?php if($form_strhsnr_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">PLZ & Ort</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_plzort_neu" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_plzort_bearbeiten" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_plzort_pflicht" onchange="savesettings(this);"<?php if($form_plzort_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">E-Mail</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_email_neu" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_email_bearbeiten" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_email_pflicht" onchange="savesettings(this);"<?php if($form_email_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Telefon</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_telefon_neu" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_telefon_bearbeiten" checked disabled>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_telefon_pflicht" onchange="savesettings(this);"<?php if($form_telefon_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Spende erhalten</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_spende_neu" onchange="savesettings(this);"<?php if($form_vogel_spende_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_spende_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_spende_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_spende_pflicht" onchange="savesettings(this);"<?php if($form_vogel_spende_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Spendenbescheinigung</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_spende_betrag_neu" onchange="savesettings(this);"<?php if($form_vogel_spende_betrag_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_spende_betrag_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_spende_betrag_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_spende_betrag_pflicht" onchange="savesettings(this);"<?php if($form_vogel_spende_betrag_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Foto</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_foto_neu" onchange="savesettings(this);"<?php if($form_vogel_foto_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_foto_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_foto_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_foto_pflicht" onchange="savesettings(this);"<?php if($form_vogel_foto_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Art</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_art_neu" onchange="savesettings(this);"<?php if($form_vogel_art_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_art_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_art_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_art_pflicht" onchange="savesettings(this);"<?php if($form_vogel_art_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Anzahl</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_anzahl_neu" onchange="savesettings(this);"<?php if($form_vogel_anzahl_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_anzahl_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_anzahl_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_anzahl_pflicht" onchange="savesettings(this);"<?php if($form_vogel_anzahl_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Fundumstände</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_fundumstaende_neu" onchange="savesettings(this);"<?php if($form_vogel_fundumstaende_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_fundumstaende_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_fundumstaende_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_fundumstaende_pflicht" onchange="savesettings(this);"<?php if($form_vogel_fundumstaende_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Stadium</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_stadium_neu" onchange="savesettings(this);"<?php if($form_vogel_stadium_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_stadium_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_stadium_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_stadium_pflicht" onchange="savesettings(this);"<?php if($form_vogel_stadium_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Gewicht</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_gewicht_neu" onchange="savesettings(this);"<?php if($form_vogel_gewicht_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_gewicht_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_gewicht_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_gewicht_pflicht" onchange="savesettings(this);"<?php if($form_vogel_gewicht_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Verletzungen</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_verletzungen_neu" onchange="savesettings(this);"<?php if($form_vogel_verletzungen_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_verletzungen_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_verletzungen_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_verletzungen_pflicht" onchange="savesettings(this);"<?php if($form_vogel_verletzungen_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Katzenopfer</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_katzenopfer_neu" onchange="savesettings(this);"<?php if($form_vogel_katzenopfer_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_katzenopfer_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_katzenopfer_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_katzenopfer_pflicht" onchange="savesettings(this);"<?php if($form_vogel_katzenopfer_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Anflugtrauma</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_anflugtrauma_neu" onchange="savesettings(this);"<?php if($form_vogel_anflugtrauma_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_anflugtrauma_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_anflugtrauma_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_anflugtrauma_pflicht" onchange="savesettings(this);"<?php if($form_vogel_anflugtrauma_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Arztbesuch</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_arztbesuch_neu" onchange="savesettings(this);"<?php if($form_vogel_arztbesuch_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_arztbesuch_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_arztbesuch_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_arztbesuch_pflicht" onchange="savesettings(this);"<?php if($form_vogel_arztbesuch_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Medikation</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_medikation_neu" onchange="savesettings(this);"<?php if($form_vogel_medikation_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_medikation_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_medikation_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_medikation_pflicht" onchange="savesettings(this);"<?php if($form_vogel_medikation_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Fehlfütterung</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_fehlfuetterung_neu" onchange="savesettings(this);"<?php if($form_vogel_fehlfuetterung_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_fehlfuetterung_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_fehlfuetterung_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_fehlfuetterung_pflicht" onchange="savesettings(this);"<?php if($form_vogel_fehlfuetterung_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Parasiten-behandlung</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_parasitenbehandlung_neu" onchange="savesettings(this);"<?php if($form_vogel_parasitenbehandlung_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_parasitenbehandlung_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_parasitenbehandlung_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_parasitenbehandlung_pflicht" onchange="savesettings(this);"<?php if($form_vogel_parasitenbehandlung_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Verstorben</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_verstorben_neu" onchange="savesettings(this);"<?php if($form_vogel_verstorben_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_verstorben_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_verstorben_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_verstorben_pflicht" onchange="savesettings(this);"<?php if($form_vogel_verstorben_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Euthanasiert</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_euthanasiert_neu" onchange="savesettings(this);"<?php if($form_vogel_euthanasiert_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_euthanasiert_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_euthanasiert_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_euthanasiert_pflicht" onchange="savesettings(this);"<?php if($form_vogel_euthanasiert_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Weitergeleitet</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_weitergeleitet_neu" onchange="savesettings(this);"<?php if($form_vogel_weitergeleitet_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_weitergeleitet_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_weitergeleitet_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_weitergeleitet_pflicht" onchange="savesettings(this);"<?php if($form_vogel_weitergeleitet_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>
	
	<div class="row">
		<span class="col s3 center-align">Ausgewildert</span>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_ausgewildert_neu" onchange="savesettings(this);"<?php if($form_vogel_ausgewildert_neu == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_ausgewildert_bearbeiten" onchange="savesettings(this);"<?php if($form_vogel_ausgewildert_bearbeiten == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
		<div class="col s3 center-align switch">
			<label>
				Aus
				<input type="checkbox" name="form_vogel_ausgewildert_pflicht" onchange="savesettings(this);"<?php if($form_vogel_ausgewildert_pflicht == 'on') { echo ' checked'; } ?>>
				<span class="lever"></span>
				An
			</label>
		</div>
	</div>

</form>


<!-- Nur für Admins -->
<?php if($session_mandant <= '2') { ?>

<br />

<h4>Benutzerverwaltung</h4>

<table class="striped centered">
	<thead>
		<tr>
			<th>#</th>
			<th>Benutzer</th>
			<th>Version</th>
			<th>Letzter Login</th>
			<th>Einträge</th>
			<th>Aktion</th>
		</tr>
	</thead>
	<tbody>
		
<?php

# Benutzer auslesen
$query = "SELECT * FROM `benutzer` ORDER BY `mandant` ASC";
if($result = mysqli_query($mysqli, $query)) {
	while($row = $result->fetch_array(MYSQLI_BOTH)) {
		
		$benutzer_mandant = $row['mandant'];
		$benutzer_version = $row['version'];
		$benutzer_lastlogon = $row['lastlogon'];
		$benutzer_benutzername = $row['benutzername'];
		$benutzer_email = $row['email'];
		
		$query2 = "SELECT count(id) FROM `aufnahmebuch` WHERE `mandant`='$benutzer_mandant'";
		if($result2 = mysqli_query($mysqli, $query2)) {
			if($row2 = $result2->fetch_array(MYSQLI_BOTH)) {
				
				$sum_eintraege = $row2['0'];
				
			}
			
		}
		
		$query3 = "SELECT `colorclass` FROM `einstellungen` WHERE `mandant`='$benutzer_mandant'";
		if($result3 = mysqli_query($mysqli, $query3)) {
			if($row3 = $result3->fetch_array(MYSQLI_BOTH)) {
				
				$benutzer_colorclass = $row3['colorclass'];
				
			}
			
		}
				
		
		echo '
		<tr>
			<td align="center" class="white-text '.$benutzer_colorclass.'">'.$benutzer_mandant.'</td>
			<td align="center">'; if(!empty($benutzer_email)) { echo '<a href="mailto:'.$benutzer_email.'" title="'.$benutzer_email.'">'.$benutzer_benutzername.'</a>'; } else { echo $benutzer_benutzername; } echo'</td>
			<td align="center">'.$benutzer_version.'</td>
			<td align="center">'.date("d.m.y - H:i", $benutzer_lastlogon).' Uhr</td>
			<td align="center">'.$sum_eintraege.'</td>
			<td align="center">'; if(!empty($benutzer_mandant != $session_mandant)) { echo '<a href="?menu=settings&action=deluser&mandant='.$benutzer_mandant.'" onclick="return window.confirm(\'Soll der Benutzer '.$benutzer_benutzername.' wirklich gelöscht werden?\');"><i class="material-icons">delete</i></a>'; } echo'</td>
		</tr>
		';

	}
	
}

# Nächste freie Benutzer ID auslesen
$query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='wildvogelhilfe' AND TABLE_NAME='benutzer'";
if($result = mysqli_query($mysqli, $query)) {
	while($row = $result->fetch_array(MYSQLI_BOTH)) {
	
		$naechster_mandant = $row['0'];
	
	}
}

?>
	</tbody>
</table>
	
<br />
	
<h4>Neuen Benutzer anlegen</h4>

<form name="benutzer" action="<?php echo '?menu=settings' ?>" method="POST">
	
	<input type="hidden" name="mandant" value="<?php echo $naechster_mandant; ?>">
	<div class="row">
	
		<div class="input-field col s12 m3">
			<input type="text" id="benutzername" name="benutzername" autocomplete="off" required>
			<label for="benutzername">Benutzername</label>
		</div>
		<div class="input-field col s12 m3">
			<input type="password" id="passwort" name="passwort" autocomplete="off" required>
			<label for="passwort">Passwort</label>
		</div>
		<div class="input-field col s12 m3">
			<input type="text" id="email" name="email" autocomplete="off">
			<label for="email">E-Mail-Adresse</label>
		</div>
		<div class="input-field col s12 m3 center-align">
			<button class="btn waves-effect waves-light <?php echo $colorclass; ?>" type="submit" name="neu">Speichern
				<i class="material-icons right">create</i>
			</button>
		</div>
	</div>
	
</form>

<?php

}

?>