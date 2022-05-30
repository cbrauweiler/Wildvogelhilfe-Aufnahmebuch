<div class="row">
	
	<br /><br />
	
	<?php
		
		if(empty($_GET['recovery_key'])) {
			
	?>

	<form class="col s12 m8 l6 offset-m2 offset-l3 z-depth-2" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?menu=lostpw">
	
		<h4 class="center-align">Passwort vergessen?</h4>
		
		Falls deinem Account eine E-Mail-Adresse zugewiesen ist, kannst du hier die Adresse angeben um dein Passwort zurücksetzen zu lassen.
		Dazu wird dir eine E-Mail mit einem Link geschickt. <strong>Der Link ist 24 Stunden gültig</strong>.
		<br /><br />
		Falls du eine Fehlermeldung erhälst, das die E-Mail-Adresse nicht bekannt ist, prüfe diese auf Schreibfehler.
		Ist alles korrekt, dann ist bei deinem Account möglicherweise keine E-Mail-Adresse hinterlegt. Dann wende dich über das Kontaktformular an uns.
	
		<div class="input-field center-align">
			<input id="email" name="email" type="email" class="validate" required>
			<label for="email">E-Mail-Adresse</label>
		</div>
		<div class="input-field center-align">
			<button class="btn waves-effect waves-light <?php echo $colorclass; ?>" type="submit" name="recover">Password zurücksetzen
				<i class="material-icons right">lock_reset</i>
			</button>
		</div>
	
	</form>
	
	<?php
		
		}
	
		if(!empty($_GET['recovery_key'])) {
			
			$recovery_key = $_GET['recovery_key'];
			
			$query = "SELECT * FROM `benutzer` WHERE `recovery_key`='$recovery_key'";
			if($result = mysqli_query($mysqli, $query)) {
				if($row = $result->fetch_array(MYSQLI_BOTH)) {
					
					$email = $row['email'];
					$recovery_time = $row['recovery_time']+86400;
					$ts = time();
					
					if($recovery_time >= $ts) {
						
						// Neues Passwort generieren
						$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
						$newpass = array();
						$alphaLength = strlen($alphabet) - 1;
						for($i = 0; $i < 16; $i++) {
							$n = rand(0, $alphaLength);
							$newpass[] = $alphabet[$n];
						}
						$newpass = implode($newpass);
						$newpasshash = password_hash($newpass, PASSWORD_DEFAULT);
						
						$query = "UPDATE `benutzer` SET `recovery_key`='', `passwort`='$newpasshash' WHERE `email`='$email'";
						echo $query;
						mysqli_query($mysqli, $query);
						
						// E-Mail-Benachrichtigung
						$betreff = 'Aufnahmebuch - Password zurückgesetzt';
						$text = 'Dein neues Passwort lautet: '.$newpass.'<br /><br />Du kannst dich mit diesem nun wieder im Aufnahmebuch anmelden und es dort in den Einstellungen ändern.';

						$header[] = 'MIME-Version: 1.0';
						$header[] = 'Content-type: text/html; charset=UTF-8';
						$header[] = 'From: Aufnahmebuch <aufnahmebuch@wildvogelhilfe-nkse.de>';
						$header[] = 'Reply-To: Aufnahmebuch <aufnahmebuch@wildvogelhilfe-nkse.de>';
						$header[] = 'X-Mailer: PHP/' . phpversion();
						 
						mail($email, $betreff, $text, implode("\r\n", $header));
						
						$error = '<ul class="erfolg">Es wurde eine E-Mail mit einem neuem Passwort gesendet.</ul><br><br>';
						
					}
					else $error = '<ul class="fehler">Fehler! Die Gültigkeit des Links ist abgelaufen (24 Stunden).</ul><br><br>';
					
				}
				else $error = '<ul class="fehler">Fehler! Der Wiederherstellungschlüssel ist ungültig.</ul><br><br>';
			}
	
		}
				
	?>
	
</div>

<?php

	if(!empty($error)) { echo '<div class="row"><span class="col s12 center-align">'.$error.'</span></div>'; }
	
?>