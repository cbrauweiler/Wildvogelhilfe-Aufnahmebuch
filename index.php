<?php

	header('Cache-Control: no-cache, no-store, must-revalidate');

	session_start();

	# Config
	include('include/config.php');

	# Logout
	if($action == 'logout') {

		session_destroy();
		session_start();

	}

	# Benutzersitzung
	if(!empty($_SESSION['id'])) {

		$session_id = $_SESSION['id'];
		$session_mandant = $_SESSION['mandant'];
		$session_benutzername = $_SESSION['benutzername'];

	}

	# Login
	if(isset($_POST['login'])) {

		$login_user = htmlspecialchars($_POST['benutzername']);
		$login_pass = htmlspecialchars($_POST['passwort']);

		if($result = mysqli_query($mysqli, "SELECT * FROM `benutzer` WHERE `benutzername`='$login_user'")) {
			if($row = $result->fetch_array(MYSQLI_BOTH)) {

				$sql_mandant = $row['mandant'];
				$sql_benutzername = $row['benutzername'];
				$sql_passwort = $row['passwort'];
				$sql_version = $row['version'];

				if(password_verify($login_pass, $sql_passwort) || $sql_passwort == md5($login_pass)) {
					
					# Wenn Passwort noch MD5, dann zu neuem Format umwandeln
					if($sql_passwort == md5($login_pass)) {
						
						$newpass = password_hash($login_pass, PASSWORD_DEFAULT);
					
						mysqli_query($mysqli, "UPDATE `benutzer` SET `passwort`='$newpass' WHERE `mandant`='$sql_mandant'");
						
					}
					

					$timestamp = $now->getTimestamp();

					$_SESSION['id'] = session_id();
					$_SESSION['mandant'] = $sql_mandant;
					$_SESSION['benutzername'] = $sql_benutzername;

					$session_id = $_SESSION['id'];
					$session_mandant = $_SESSION['mandant'];
					$session_benutzername = $_SESSION['benutzername'];
					
					mysqli_query($mysqli, "UPDATE `benutzer` SET `lastlogon`='$timestamp' WHERE `mandant`='$sql_mandant'");
					
					# Einstellungen und Version abrufen
					if(!empty($_SESSION['mandant'])) {

						# Einstellungen
						$query = "SELECT * FROM `einstellungen` WHERE `mandant`='$_SESSION[mandant]'";
						if($result = mysqli_query($mysqli, $query)) {
							if($row = $result->fetch_array(MYSQLI_BOTH)) {
								
								$colorclass = $row['colorclass'];
								$primarycolor = $row['primarycolor'];
								$secondarycolor = $row['secondarycolor'];
								
							}
						}
					}			
					
				}
				else $error = '<ul class="fehler">Fehler! Das Passwort ist falsch.</ul><br><br>';

			}
			else $error = '<ul class="fehler">Fehler! Der Benutzer existiert nicht.</ul><br><br>';

		}

	}
	
	# Passwort Zurücksetzen
	if(isset($_POST['recover'])) {
		
		$email = $_POST['email'];
		
		$query = "SELECT * FROM `benutzer` WHERE `email`='$email'";
		if($result = mysqli_query($mysqli, $query)) {
			if($row = $result->fetch_array(MYSQLI_BOTH)) {
				
				// Recovery Key in DB schreiben
				$ts = time();
				$key = uniqid();
				$query = "UPDATE `benutzer` SET `recovery_key`='$key', `recovery_time`='$ts' WHERE `email`='$email'";
				mysqli_query($mysqli, $query);
				
				// E-Mail-Benachrichtigung
				$betreff = 'Aufnahmebuch - Password vergessen';
				$text = 'Du hast dein Passwort vergessen? Dann klicke innerhalb von 24 Stunden auf den folgenden Link um dein Passwort zurückzusetzen!<br /><br /><a href="https://aufnahmebuch.wildvogelhilfe-nkse.de/beta/index.php?menu=lostpw&recovery_key='.$key.'" target="_blank">https://aufnahmebuch.wildvogelhilfe-nkse.de/beta/index.php?menu=lostpw&recovery_key='.$key.'</a><br /><br />Du warst das nicht? Dann kannst du diese E-Mail ignorieren und löschen!';

				$header[] = 'MIME-Version: 1.0';
				$header[] = 'Content-type: text/html; charset=UTF-8';
				$header[] = 'From: Aufnahmebuch <aufnahmebuch@wildvogelhilfe-nkse.de>';
				$header[] = 'Reply-To: Aufnahmebuch <aufnahmebuch@wildvogelhilfe-nkse.de>';
				$header[] = 'X-Mailer: PHP/' . phpversion();
				 
				mail($email, $betreff, $text, implode("\r\n", $header));
				
				$error = '<ul class="erfolg">Es wurde eine E-Mail mit einem Link zum zurücksetzen deines Passwortes gesendet.</ul><br><br>';
				
			}
			else {
			
				$error = '<ul class="fehler">Fehler! Die E-Mail-Adresse ist nicht bekannt.</ul><br><br>';
				
			}
		}
		
	}
	
	
?>


<!DOCTYPE html>
<html lang="de">
	<head>
		<title>Wildvogelhilfe Aufnahmebuch</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

		<!--jQuery-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!--Custom JS-->
		<script>

			// Materialized Scripts
			$(document).ready(function(){
				$('.sidenav').sidenav();

				$('.dropdown-trigger').dropdown();
				
				$('select').formSelect();

				$('.modal').modal();
				$('#modal_version').modal('open');

				$(function() {
					var $einnahmen = $('#einnahmen').text();
					$('#btn_einnahmen').text($einnahmen);

					var $ausgaben = $('#ausgaben').text();
					$('#btn_ausgaben').text($ausgaben);
				});
			});

			// Ort von PLZ ermitteln
			function getort(plz) {

				// check if ort is already filled
				if (document.getElementById("finder_ort").value!="") { document.getElementById("finder_ort").value=""; }

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET", "search_plzort.php?plz=" + plz.value, true);
				xmlhttp.onreadystatechange=function() {

					if (xmlhttp.readyState==4) {

						document.getElementById("finder_ort").value=xmlhttp.responseText;

					}

				}

				xmlhttp.send(null);

			}

			// PLZ von Ort ermitteln
			function getplz(ort) {

				// check if ort is already filled
				if (document.getElementById("finder_plz").value!="") { document.getElementById("finder_plz").value=""; }

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET", "search_plzort.php?ort=" + ort.value, true);
				xmlhttp.onreadystatechange=function() {

					if (xmlhttp.readyState==4) {

						document.getElementById("finder_plz").value=xmlhttp.responseText;

					}

				}

				xmlhttp.send(null);

			}

			// Autocomplete Ort
			$(function() {
				$("#finder_ort").autocomplete({
					source: "autocomplete_ort.php",
					minLength: 3,
					select: function( event, ui ) {
						event.preventDefault();
						$("#finder_ort").val(ui.item.value);
					}
				});
			});

			// Autocomplete PLZ
			$(function() {
				$("#finder_plz").autocomplete({
					source: "autocomplete_plz.php",
					minLength: 3,
					select: function( event, ui ) {
						event.preventDefault();
						$("#finder_plz").val(ui.item.value);
					}
				});
			});

			// Instant Save Settings
			function savesettings(obj) {

				name = obj.name;
				value = obj.checked;
				let mandant = "<?php echo $_SESSION['mandant']; ?>";

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET", "include/ajax.php?func=savesettings&mandant=" + mandant + "&obj=" + name +"&value=" + value, true);

				xmlhttp.onreadystatechange=function() {

					if (xmlhttp.readyState==4) {

						console.log(xmlhttp.responseText);

					}

				}

				xmlhttp.send(null);

			}
			
			// Neue Version akzeptieren
			function saveversion() {
								
				let version = "<?php echo $system_version; ?>";
				let mandant = "<?php echo $_SESSION['mandant']; ?>";

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET", "include/ajax.php?func=versionok&version=" + version + "&mandant=" + mandant, true);

				xmlhttp.onreadystatechange=function() {

					if (xmlhttp.readyState==4) {

						console.log(xmlhttp.responseText);

					}

				}

				xmlhttp.send(null);

			}
			
			// Neues Farbschema speichern
			function setcolor(obj) {
								
				schema = obj.id;
				let mandant = "<?php echo $_SESSION['mandant']; ?>";

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET", "include/ajax.php?func=color&schema=" + schema + "&mandant=" + mandant, true);

				xmlhttp.onreadystatechange=function() {

					if (xmlhttp.readyState==4) {

						console.log(xmlhttp.responseText);

					}

				}

				xmlhttp.send(null);

			}

		</script>

		<!--Custom CSS-->
		<style>
			:root {
				--primary-color: <?php echo $primarycolor; ?>;
				--secondary-color: <?php echo $secondarycolor; ?>;
			}
		</style>
		<link rel="stylesheet" href="include/css/custom.css">

	</head>
	<body>

		<main>

			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper <?php echo $colorclass; ?>">
						<a href="#!" class="brand-logo">&nbsp; Aufnahmebuch</a>
						<a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
						<ul id="nav-mobile" class="right hide-on-med-and-down">

							<?php if(!empty($_SESSION['mandant'])) { echo $menu_angemeldet; }else { echo $menu_abgemeldet; } ?>

						</ul>
					</div>
				</nav>
			</div>
			<ul class="sidenav" id="mobile-nav">

				<?php if(!empty($_SESSION['mandant'])) { echo $menu_angemeldet; }else { echo $menu_abgemeldet; } ?>

			</ul>


			<div class="container">


				<?php

					# Eingeloggt?
					if(!empty($_SESSION['mandant'])) {
						
						# Version prüfen
						if($system_version != $sql_version) {

							echo  '
							<div id="modal_version" class="modal">
								<div class="modal-content">
									<h4>Neue Version '.$system_version.'</h4>
									<p>'.$versions_beschreibung.'</p>
								</div>
								<div class="modal-footer">
									<a href="#!" class="modal-close waves-effect waves-green btn-flat" onclick="saveversion()">Verstanden</a>
								</div>
							</div>
							';

						}

						# Menüpunkt ermitteln
						if(!empty($_GET['menu'])) {

							$menu = $_GET['menu'];

							if($menu == "new") { include('new.php'); }
							if($menu == "edit") { include('edit.php'); }
							if($menu == "list") { include('list.php'); }
							if($menu == "money") { include('money.php'); }
							if($menu == "stats") { include('stats.php'); }
							if($menu == "recyclebin") { include('recyclebin.php'); }
							if($menu == "settings") { include('settings.php'); }
							if($menu == "lostpw") { include('password_recovery.php'); }
							if($menu == "contact") { include('contact.php'); }

						}
						else { include('list.php'); }

					}
					else {
						
						if($_GET['menu'] == "lostpw") { include('password_recovery.php'); }
						elseif($_GET['menu'] == "contact") { include('contact.php'); }
						else { include('login.php'); }
						
					}

				?>

			</div>

			<br /><br />

		</main>

		<footer class="page-footer <?php echo $colorclass; ?>">
			<div class="container">
				<div class="row">
					<div class="col l6 s12">
						<h5 class="white-text">Wildvogelhilfe Aufnahmebuch</h5>
						<p class="grey-text text-lighten-4">
							Das Aufnahmebuch dient der Dokumentation der Aufgenommen Wildvögel/Wildtiere.<br />
							Bei Fragen, Problemen oder Wünschen gerne über das Kontaktformular eine Nachricht schreiben!
							<br /><br />
							Zeit: <?php echo $now->format("H:i - d.m.Y"); ?>
						</p>
					</div>
					<div class="col l4 offset-l2 s12">
						<h5 class="white-text">Links</h5>
						<ul>
							<li><a class="grey-text text-lighten-3" href="https://wildvogelhilfe-nkse.de/" target="_blank">Wildvogelhilfe-NKSE.de</a></li>
							<li><a class="grey-text text-lighten-3" href="https://vogeltaxi.wildvogelhilfe-nkse.de/" target="_blank">Vogeltaxi</a></li>
							<li><a class="grey-text text-lighten-3" href="https://www.facebook.com/wildvogelhilfe.nkse" target="_blank">Facebook "Wildvogelhilfe-NKSE"</a></li>
							<li><a class="grey-text text-lighten-3" href="https://www.facebook.com/groups/Wildvogelhilfe/" target="_blank">Facebook "Wildovgel Notfälle"</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="footer-copyright">
				<div class="container">
					© 2021 <a class="grey-text text-lighten-4" href="https://christian-brauweiler.de">Christian Brauweiler</a> - Version: <?php if(!empty($_SESSION['mandant']) && $system_version != $sql_version) { echo '<span class="red">&nbsp;'.$sql_version.'&nbsp;</span>'; }else echo $system_version; ?>
					<a class="grey-text text-lighten-4 right" href="?menu=contact">Kontakt</a>
				</div>
			</div>
		</footer>

		<!--JavaScript at end of body for optimized loading-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

	</body>
</html>
