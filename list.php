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
			
			case 1: include('list_bestand.php');
			break;
			
			case 2: include('list_ausgewildert.php');
			break;
			
			case 3: include('list_weitergeleitet.php');
			break;
			
			case 4: include('list_verstorben.php');
			break;
			
			case 5: include('list_euthanasiert.php');
			break;
			
		}
		
	}

?>