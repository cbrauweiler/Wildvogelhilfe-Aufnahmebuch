<div class="row">
	
	<br /><br />

	<form class="col s12 m8 l6 offset-m2 offset-l3 z-depth-2" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	
		<h4 class="center-align">Anmeldung</h4>
	
		<div class="input-field center-align">
			<input id="benutzername" name="benutzername" type="text" class="validate" required>
			<label for="benutzername">Benutzername</label>
		</div>
		<div class="input-field center-align">
			<input id="passwort" name="passwort" type="password" class="validate" required>
			<label for="passwort">Passwort</label>
		</div>
		<div class="input-field center-align">
			<button class="btn waves-effect waves-light <?php echo $colorclass; ?>" type="submit" name="login">Anmelden
				<i class="material-icons right">send</i>
			</button>
		</div>
		<div class="input-field center-align">
			<a href="?menu=lostpw">Passwort vergessen?</a>
		</div>
		
		<?php if(!empty($error)) { echo '<span class="center-align">'.$error.'</span>'; } ?>
	
	</form>
</div>