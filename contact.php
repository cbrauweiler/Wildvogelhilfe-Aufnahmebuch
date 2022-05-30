<?php

	# Kontaktformular
	if(isset($_POST['sendmail'])) {
		
		$kontakt_name = $_POST['fullname'];
		$kontakt_email = $_POST['emailaddress'];
		$kontakt_betreff = $_POST['subject'];
		$kontakt_nachricht = $_POST['message'];
		
		$nachricht = 'Neue Kontaktanfrage von <a href="mailto:'.$kontakt_email.'">'.$kontakt_name.' ('.$kontakt_email.')</a><br /><br />Nachricht:<br />'.$kontakt_nachricht;

		$header[] = 'MIME-Version: 1.0';
		$header[] = 'Content-type: text/html; charset=UTF-8';
		$header[] = 'From: Aufnahmebuch <aufnahmebuch@wildvogelhilfe-nkse.de>';
		$header[] = 'Reply-To: '.$kontakt_name.' <'.$kontakt_email.'>';
		$header[] = 'X-Mailer: PHP/' . phpversion();
		 
		mail($admin_email, $kontakt_betreff, $nachricht, implode("\r\n", $header));
		
		$error = '<ul class="erfolg">Deine Nachricht wurde erfolgreich gesendet. Wir Antworten sobald wie möglich.</ul><br><br>';
		
	}	

?>

<div class="row">
	
	<br /><br />

	<form class="col s12 m8 l6 offset-m2 offset-l3 z-depth-2" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?menu=contact">
	
		<h4 class="center-align">Kontakt</h4>
		
		<div class="input-field center-align">
			<input id="name" name="fullname" type="text" class="validate" required>
			<label for="name">Dein Name</label>
		</div>
		<div class="input-field center-align">
			<input id="email" name="emailaddress" type="email" class="validate" required>
			<label for="email">Deine E-Mail-Adresse</label>
		</div>
		<div class="input-field center-align">
			<input id="betreff" name="subject" type="text" class="validate" required>
			<label for="betreff">Betreff</label>
		</div>
		 <div class="input-field center-align">
			<textarea id="nachricht" name="message" class="materialize-textarea"></textarea>
			<label for="nachricht">Deine Nachricht</label>
        </div>
		<div class="input-field center-align">
			<button class="btn waves-effect waves-light <?php echo $colorclass; ?>" type="submit" name="sendmail">Senden
				<i class="material-icons right">send</i>
			</button>
		</div>
		<div class="center-align">
			<br /><strong>Datenschutzhinweis:</strong><br />Die Daten werden nicht dauerhaft gespeichert und lediglich zur Antwort deiner Anfrage verwendet.
		</div>
		
		
		<?php if(!empty($error)) { echo '<span class="center-align">'.$error.'</span>'; } ?>
	
	</form>
</div>