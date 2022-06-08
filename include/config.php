<?php
# Error Reporting
error_reporting(0);

# Include mySQL 
include('mysql.php');

# Administrator E-Mail
$admin_email = 'christian.brauweiler@gmail.com';

# Timestamp
$timezone = new DateTimeZone("Europe/Berlin");
$now = new DateTime();

# Menüeinträge
$menu_angemeldet = '
<li'; if(!empty($_GET['menu']) && $_GET['menu'] == 'new') { $menu_angemeldet .= ' class="active"'; } $menu_angemeldet .= '><a href="?menu=new">Neuaufnahme</a></li>
<li'; if(empty($_GET['menu']) || !empty($_GET['menu']) && $_GET['menu'] == 'list') { $menu_angemeldet .= ' class="active"'; } $menu_angemeldet .= '><a href="?menu=list">Bestandsliste</a></li>
<li'; if(!empty($_GET['menu']) && $_GET['menu'] == 'stats') { $menu_angemeldet .= ' class="active"'; } $menu_angemeldet .= '><a href="?menu=stats">Statistik</a></li>
<li'; if(!empty($_GET['menu']) && $_GET['menu'] == 'money') { $menu_angemeldet .= ' class="active"'; } $menu_angemeldet .= '><a href="?menu=money">Kassenbuch</a></li>
<li'; if(!empty($_GET['menu']) && $_GET['menu'] == 'recyclebin') { $menu_angemeldet .= ' class="active"'; } $menu_angemeldet .= '><a href="?menu=recyclebin">Papierkorb</a></li>
<li'; if(!empty($_GET['menu']) && $_GET['menu'] == 'settings') { $menu_angemeldet .= ' class="active"'; } $menu_angemeldet .= '><a href="?menu=settings">Einstellungen</a></li>
<li><a href="?action=logout">Abmelden</a></li>
';

$menu_abgemeldet = '
<li'; if(empty($_GET['menu'])) { $menu_abgemeldet .= ' class="active"'; } $menu_abgemeldet .= '><a href="?menu=">Anmelden</a></li>
<li'; if(!empty($_GET['menu']) && $_GET['menu'] == 'lostpw') { $menu_abgemeldet .= ' class="active"'; } $menu_abgemeldet .= '><a href="?menu=lostpw">Passwort vergessen</a></li>
<li'; if(!empty($_GET['menu']) && $_GET['menu'] == 'contact') { $menu_abgemeldet .= ' class="active"'; } $menu_abgemeldet .= '><a href="?menu=contact">Kontakt</a></li>
';

# Systemversion abrufen
$query = "SELECT * FROM `changelog` ORDER BY `version` DESC LIMIT 0,1";
if($result = mysqli_query($mysqli, $query)) {
	if($row = $result->fetch_array(MYSQLI_BOTH)) {
		
		$system_version = $row['version'];
		$versions_beschreibung = $row['beschreibung'];
		
	}
}


# Einstellungen und Version abrufen
if(!empty($_SESSION['mandant'])) {

	# Einstellungen
	$query = "SELECT * FROM `einstellungen` WHERE `mandant`='$_SESSION[mandant]'";
	if($result = mysqli_query($mysqli, $query)) {
		if($row = $result->fetch_array(MYSQLI_BOTH)) {
			
			$colorclass = $row['colorclass'];
			$primarycolor = $row['primarycolor'];
			$secondarycolor = $row['secondarycolor'];
			
			$form_lfdn_neu = $row['form_lfdn_neu'];
			$form_lfdn_bearbeiten = $row['form_lfdn_bearbeiten'];
			$form_lfdn_pflicht = $row['form_lfdn_pflicht'];
			
			$form_vorname_pflicht = $row['form_vorname_pflicht'];
			$form_nachname_pflicht = $row['form_nachname_pflicht'];
			$form_strhsnr_pflicht = $row['form_strhsnr_pflicht'];
			$form_plzort_pflicht = $row['form_plzort_pflicht'];
			$form_email_pflicht = $row['form_email_pflicht'];
			$form_telefon_pflicht = $row['form_telefon_pflicht'];
			
			$form_vogel_spende_neu = $row['form_vogel_spende_neu'];
			$form_vogel_spende_bearbeiten = $row['form_vogel_spende_bearbeiten'];
			$form_vogel_spende_pflicht = $row['form_vogel_spende_pflicht'];
			
			$form_vogel_spende_betrag_neu = $row['form_vogel_spende_betrag_neu'];
			$form_vogel_spende_betrag_bearbeiten = $row['form_vogel_spende_betrag_bearbeiten'];
			$form_vogel_spende_betrag_pflicht = $row['form_vogel_spende_betrag_pflicht'];
			
			$form_vogel_foto_neu = $row['form_vogel_foto_neu'];
			$form_vogel_foto_bearbeiten = $row['form_vogel_foto_bearbeiten'];
			$form_vogel_foto_pflicht = $row['form_vogel_foto_pflicht'];
			
			$form_vogel_art_neu = $row['form_vogel_art_neu'];
			$form_vogel_art_bearbeiten = $row['form_vogel_art_bearbeiten'];
			$form_vogel_art_pflicht = $row['form_vogel_art_pflicht'];
			
			$form_vogel_anzahl_neu = $row['form_vogel_anzahl_neu'];
			$form_vogel_anzahl_bearbeiten = $row['form_vogel_anzahl_bearbeiten'];
			$form_vogel_anzahl_pflicht = $row['form_vogel_anzahl_pflicht'];
			
			$form_vogel_fundumstaende_neu = $row['form_vogel_fundumstaende_neu'];
			$form_vogel_fundumstaende_bearbeiten = $row['form_vogel_fundumstaende_bearbeiten'];
			$form_vogel_fundumstaende_pflicht = $row['form_vogel_fundumstaende_pflicht'];
			
			$form_vogel_stadium_neu = $row['form_vogel_stadium_neu'];
			$form_vogel_stadium_bearbeiten = $row['form_vogel_stadium_bearbeiten'];
			$form_vogel_stadium_pflicht = $row['form_vogel_stadium_pflicht'];
			
			$form_vogel_gewicht_neu = $row['form_vogel_gewicht_neu'];
			$form_vogel_gewicht_bearbeiten = $row['form_vogel_gewicht_bearbeiten'];
			$form_vogel_gewicht_pflicht = $row['form_vogel_gewicht_pflicht'];
			
			$form_vogel_verletzungen_neu = $row['form_vogel_verletzungen_neu'];
			$form_vogel_verletzungen_bearbeiten = $row['form_vogel_verletzungen_bearbeiten'];
			$form_vogel_verletzungen_pflicht = $row['form_vogel_verletzungen_pflicht'];
			
			$form_vogel_katzenopfer_neu = $row['form_vogel_katzenopfer_neu'];
			$form_vogel_katzenopfer_bearbeiten = $row['form_vogel_katzenopfer_bearbeiten'];
			$form_vogel_katzenopfer_pflicht = $row['form_vogel_katzenopfer_pflicht'];
			
			$form_vogel_anflugtrauma_neu = $row['form_vogel_anflugtrauma_neu'];
			$form_vogel_anflugtrauma_bearbeiten = $row['form_vogel_anflugtrauma_bearbeiten'];
			$form_vogel_anflugtrauma_pflicht = $row['form_vogel_anflugtrauma_pflicht'];
			
			$form_vogel_arztbesuch_neu = $row['form_vogel_arztbesuch_neu'];
			$form_vogel_arztbesuch_bearbeiten = $row['form_vogel_arztbesuch_bearbeiten'];
			$form_vogel_arztbesuch_pflicht = $row['form_vogel_arztbesuch_pflicht'];
			
			$form_vogel_medikation_neu = $row['form_vogel_medikation_neu'];
			$form_vogel_medikation_bearbeiten = $row['form_vogel_medikation_bearbeiten'];
			$form_vogel_medikation_pflicht = $row['form_vogel_medikation_pflicht'];
			
			$form_vogel_fehlfuetterung_neu = $row['form_vogel_fehlfuetterung_neu'];
			$form_vogel_fehlfuetterung_bearbeiten = $row['form_vogel_fehlfuetterung_bearbeiten'];
			$form_vogel_fehlfuetterung_pflicht = $row['form_vogel_fehlfuetterung_pflicht'];
			
			$form_vogel_parasitenbehandlung_neu = $row['form_vogel_parasitenbehandlung_neu'];
			$form_vogel_parasitenbehandlung_bearbeiten = $row['form_vogel_parasitenbehandlung_bearbeiten'];
			$form_vogel_parasitenbehandlung_pflicht = $row['form_vogel_parasitenbehandlung_pflicht'];
			
			$form_vogel_verstorben_neu = $row['form_vogel_verstorben_neu'];
			$form_vogel_verstorben_bearbeiten = $row['form_vogel_verstorben_bearbeiten'];
			$form_vogel_verstorben_pflicht = $row['form_vogel_verstorben_pflicht'];
			
			$form_vogel_euthanasiert_neu = $row['form_vogel_euthanasiert_neu'];
			$form_vogel_euthanasiert_bearbeiten = $row['form_vogel_euthanasiert_bearbeiten'];
			$form_vogel_euthanasiert_pflicht = $row['form_vogel_euthanasiert_pflicht'];
			
			$form_vogel_weitergeleitet_neu = $row['form_vogel_weitergeleitet_neu'];
			$form_vogel_weitergeleitet_bearbeiten = $row['form_vogel_weitergeleitet_bearbeiten'];
			$form_vogel_weitergeleitet_pflicht = $row['form_vogel_weitergeleitet_pflicht'];
			
			$form_vogel_ausgewildert_neu = $row['form_vogel_ausgewildert_neu'];
			$form_vogel_ausgewildert_bearbeiten = $row['form_vogel_ausgewildert_bearbeiten'];
			$form_vogel_ausgewildert_pflicht = $row['form_vogel_ausgewildert_pflicht'];

		}		
	}
	
	# Version
	$query2 = "SELECT * FROM `benutzer` WHERE `mandant`='$_SESSION[mandant]'";
	if($result2 = mysqli_query($mysqli, $query2)) {
		if($row2 = $result2->fetch_array(MYSQLI_BOTH)) {

			$sql_version = $row2['version'];
			
		}
	}
	
}
else {
	
	$colorclass = 'green accent-3';
	$primarycolor = '#00e676';
	$secondarycolor = '#00e676';
	
}

# Sonstiges
$error = '';

if(isset($_GET['action'])) {
	
	$action = $_GET['action'];
	
}
else $action = '';