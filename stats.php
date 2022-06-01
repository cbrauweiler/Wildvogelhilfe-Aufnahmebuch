<?php

	// Statistikjahre
	if(!empty($_GET['statyear'])) {
		
		$statyear = $_GET['statyear'];
		
	}
	else $statyear = date("Y", time());
	
	echo '<h2>Statistiken ('.$statyear.')</h2>';

	$query = "SELECT YEAR(datum) AS 'year' FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' GROUP BY `year` ORDER BY `year` DESC";
	if($result = mysqli_query($mysqli, $query)) {
		while($row = $result->fetch_array(MYSQLI_BOTH)) {
			
			echo '
				<button class="waves-effect waves-light btn-small '.$colorclass; if($statyear == $row['year']) { echo ' active'; } echo '" type="submit" onclick="self.location.href=\'?menu=stats&statyear='.$row['year'].'\'">'.$row['year'].'</button>
			';

		}
		
	}

?>

<h4>Aufgenommene Tiere</h4>
<table class="striped centered">
	<thead>
		<tr style="background-color: #ddd;">
			<th></th>
			<th colspan="2">Nestling</th>
			<th colspan="2">Ästling</th>
			<th colspan="2">Juvenil</th>
			<th colspan="2">Adult</th>
			<th colspan="3" style="background-color: #ddd;">Gesamt</th>
		</tr>
		<tr style="background-color: #ddd;">
			<th></th>
			<th width="6%">&dagger;</th>
			<th width="6%">*</th>
			<th width="6%">&dagger;</th>
			<th width="6%">*</th>
			<th width="6%">&dagger;</th>
			<th width="6%">*</th>
			<th width="6%">&dagger;</th>
			<th width="6%">*</th>
			<th width="6%" style="background-color: #ddd;">&dagger;</th>
			<th width="6%" style="background-color: #ddd;">*</th>
			<th width="6%" style="background-color: #ddd;">=</th>
		</tr>
	</thead>
	<tbody>
<?php

	$summe_nestling_tot = '0';
	$summe_nestling_lebt = '0';
	$summe_aestling_tot = '0';
	$summe_aestling_lebt = '0';
	$summe_juvenil_tot = '0';
	$summe_juvenil_lebt = '0';
	$summe_adult_tot = '0';
	$summe_adult_lebt = '0';
	$summe_tot = '0';
	$summe_lebt = '0';
	$summe = '0';

	// Vogelarten	
	$query = "SELECT `vogel_art`, sum(vogel_anzahl) as summe_art FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' GROUP BY `vogel_art` ORDER BY `vogel_art`";
	if($result = mysqli_query($mysqli, $query)) {
		while($row = $result->fetch_array(MYSQLI_BOTH)) {
			
			$vogel_art = $row['vogel_art'];
			$summe_art = $row['summe_art'];
			$summe = $summe+$summe_art;
			
			// Nestling & Nestling befiedert
			$query2 = "SELECT sum(vogel_anzahl) as summe_anzahl, sum(vogel_weitergeleitet) as summe_weitergeleitet, sum(vogel_ausgewildert) as summe_ausgewildert, sum(vogel_euthanasiert) as summe_euthanasiert, sum(vogel_verstorben) as summe_verstorben FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' AND `vogel_art`='$vogel_art' AND `vogel_stadium` LIKE 'nestling%'";
			if($result2 = mysqli_query($mysqli, $query2)) {
				while($row2 = $result2->fetch_array(MYSQLI_BOTH)) {
					
					$nestling_anzahl = $row2['summe_anzahl'];
					$nestling_weitergeleitet = $row2['summe_weitergeleitet'];
					$nestling_ausgewildert = $row2['summe_ausgewildert'];
					$nestling_euthanasiert = $row2['summe_euthanasiert'];
					$nestling_verstorben = $row2['summe_verstorben'];
					
					$nestling_lebt = $nestling_anzahl-$nestling_euthanasiert-$nestling_verstorben;
					$nestling_tot = $nestling_euthanasiert+$nestling_verstorben;
					
					$summe_nestling_tot = $summe_nestling_tot+$nestling_tot;
					$summe_nestling_lebt = $summe_nestling_lebt+$nestling_lebt;
					
				}
				
			}
			
			// Ästling
			$query3 = "SELECT sum(vogel_anzahl) as summe_anzahl, sum(vogel_weitergeleitet) as summe_weitergeleitet, sum(vogel_ausgewildert) as summe_ausgewildert, sum(vogel_euthanasiert) as summe_euthanasiert, sum(vogel_verstorben) as summe_verstorben FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' AND `vogel_art`='$vogel_art' AND `vogel_stadium`='aestling'";
			if($result3 = mysqli_query($mysqli, $query3)) {
				while($row3 = $result3->fetch_array(MYSQLI_BOTH)) {
					
					$aestling_anzahl = $row3['summe_anzahl'];
					$aestling_weitergeleitet = $row3['summe_weitergeleitet'];
					$aestling_ausgewildert = $row3['summe_ausgewildert'];
					$aestling_euthanasiert = $row3['summe_euthanasiert'];
					$aestling_verstorben = $row3['summe_verstorben'];
					
					$aestling_lebt = $aestling_anzahl-$aestling_euthanasiert-$aestling_verstorben;
					$aestling_tot = $aestling_euthanasiert+$aestling_verstorben;
					
					$summe_aestling_tot = $summe_aestling_tot+$aestling_tot;
					$summe_aestling_lebt = $summe_aestling_lebt+$aestling_lebt;
					
				}
				
			}
			
			// Juvenil
			$query4 = "SELECT sum(vogel_anzahl) as summe_anzahl, sum(vogel_weitergeleitet) as summe_weitergeleitet, sum(vogel_ausgewildert) as summe_ausgewildert, sum(vogel_euthanasiert) as summe_euthanasiert, sum(vogel_verstorben) as summe_verstorben FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' AND `vogel_art`='$vogel_art' AND `vogel_stadium`='juvenil'";
			if($result4 = mysqli_query($mysqli, $query4)) {
				while($row4 = $result4->fetch_array(MYSQLI_BOTH)) {
					
					$juvenil_anzahl = $row4['summe_anzahl'];
					$juvenil_weitergeleitet = $row4['summe_weitergeleitet'];
					$juvenil_ausgewildert = $row4['summe_ausgewildert'];
					$juvenil_euthanasiert = $row4['summe_euthanasiert'];
					$juvenil_verstorben = $row4['summe_verstorben'];
					
					$juvenil_lebt = $juvenil_anzahl-$juvenil_euthanasiert-$juvenil_verstorben;
					$juvenil_tot = $juvenil_euthanasiert+$juvenil_verstorben;
					
					$summe_juvenil_tot = $summe_juvenil_tot+$juvenil_tot;
					$summe_juvenil_lebt = $summe_juvenil_lebt+$juvenil_lebt;
					
				}
				
			}
			
			// Adult
			$query5 = "SELECT sum(vogel_anzahl) as summe_anzahl, sum(vogel_weitergeleitet) as summe_weitergeleitet, sum(vogel_ausgewildert) as summe_ausgewildert, sum(vogel_euthanasiert) as summe_euthanasiert, sum(vogel_verstorben) as summe_verstorben FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' AND `vogel_art`='$vogel_art' AND `vogel_stadium`='adult'";
			if($result5 = mysqli_query($mysqli, $query5)) {
				while($row5 = $result5->fetch_array(MYSQLI_BOTH)) {
					
					$adult_anzahl = $row5['summe_anzahl'];
					$adult_weitergeleitet = $row5['summe_weitergeleitet'];
					$adult_ausgewildert = $row5['summe_ausgewildert'];
					$adult_euthanasiert = $row5['summe_euthanasiert'];
					$adult_verstorben = $row5['summe_verstorben'];
					
					$adult_lebt = $adult_anzahl-$adult_euthanasiert-$adult_verstorben;
					$adult_tot = $adult_euthanasiert+$adult_verstorben;
					
					$summe_adult_tot = $summe_adult_tot+$adult_tot;
					$summe_adult_lebt = $summe_adult_lebt+$adult_lebt;
					
				}
				
			}
			
			$summe_art_tot = $nestling_tot+$aestling_tot+$juvenil_tot+$adult_tot;
			$summe_art_lebt = $nestling_lebt+$aestling_lebt+$juvenil_lebt+$adult_lebt;
			
			echo '
				<tr>
					<td>'.$vogel_art.'</td>
					<td>'.$nestling_tot.'</td>
					<td>'.$nestling_lebt.'</td>
					<td>'.$aestling_tot.'</td>
					<td>'.$aestling_lebt.'</td>
					<td>'.$juvenil_tot.'</td>
					<td>'.$juvenil_lebt.'</td>
					<td>'.$adult_tot.'</td>
					<td>'.$adult_lebt.'</td>
					<td style="background-color: #ddd;">'.$summe_art_tot.'</td>
					<td style="background-color: #ddd;">'.$summe_art_lebt.'</td>
					<td style="background-color: #ddd;"><strong>'.$summe_art.'</strong></td>
				</tr>
					
			';

		}
		
	}
	
	$summe_tot = $summe_nestling_tot+$summe_aestling_tot+$summe_juvenil_tot+$summe_adult_tot;
	$summe_lebt = $summe_nestling_lebt+$summe_aestling_lebt+$summe_juvenil_lebt+$summe_adult_lebt;
	
	echo '
		<tr style="background-color: #ddd;">
			<td><strong>Gesamt</strong></td>
			<td><strong>'.$summe_nestling_tot.'</strong></td>
			<td><strong>'.$summe_nestling_lebt.'</strong></td>
			<td><strong>'.$summe_aestling_tot.'</strong></td>
			<td><strong>'.$summe_aestling_lebt.'</strong></td>
			<td><strong>'.$summe_juvenil_tot.'</strong></td>
			<td><strong>'.$summe_juvenil_lebt.'</strong></td>
			<td><strong>'.$summe_adult_tot.'</strong></td>
			<td><strong>'.$summe_adult_lebt.'</strong></td>
			<td><strong>'.$summe_tot.'</strong></td>
			<td><strong>'.$summe_lebt.'</strong></td>
			<td><strong>'.$summe.'</strong></td>
		</tr>
	';

?>
	</tbody>
</table>

<br /><br />

<h4>Aufnahmen pro Monat</h4>
<table id="noprint" class="striped centered">
	<thead>
		<tr style="background-color: #ddd;">
			<th width="25%">Monat</th>
			<th width="25%">*</th>
			<th width="25%">&dagger;</th>
			<th width="25%">Gesamt</th>
		</tr>
	</thead>
	<tbody>
	<?php

		// Monatsansicht
	$gesamt_tot = '0';
	$gesamt_lebt = '0';
	$gesamt = '0';
	
	$query = "SELECT sum(vogel_anzahl) as summe, sum(vogel_euthanasiert) as summe_euthanasiert, sum(vogel_verstorben) as summe_verstorben, MONTH(datum) as monat  FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' GROUP BY MONTH(datum) ORDER BY MONTH(datum)";
	if($result = mysqli_query($mysqli, $query)) {
		while($row = $result->fetch_array(MYSQLI_BOTH)) {
			
			$summe = $row['summe'];
			$summe_euthanasiert = $row['summe_euthanasiert'];
			$summe_verstorben = $row['summe_verstorben'];
			$monat = $row['monat'];
					
			switch($monat) {
	
				case 1:	$monat = 'Januar';
				break;
				
				case 2:	$monat = 'Februar';
				break;
				
				case 3:	$monat = 'März';
				break;
				
				case 4:	$monat = 'April';
				break;
				
				case 5:	$monat = 'Mai';
				break;
				
				case 6:	$monat = 'Juni';
				break;
				
				case 7:	$monat = 'July';
				break;
				
				case 8:	$monat = 'August';
				break;
				
				case 9:	$monat = 'September';
				break;
				
				case 10: $monat = 'Oktober';
				break;
				
				case 11: $monat = 'November';
				break;
				
				case 12: $monat = 'Dezember';
				break;
				
			}

			$summe_tot = $summe_euthanasiert+$summe_verstorben;
			$summe_lebt = $summe-$summe_tot;
			
			echo '
				<tr>
					<td align="center">'.$monat.'</td>
					<td align="center">'.$summe_lebt.'</td>
					<td align="center">'.$summe_tot.'</td>
					<td align="center">'.$summe.'</td>
				</tr>
					
			';
			
			$gesamt_tot = $gesamt_tot+$summe_tot;
			$gesamt_lebt = $gesamt_lebt+$summe_lebt;
			$gesamt = $gesamt+$summe;

		}
		
	}
		
		echo '
			<tr style="background-color: #ddd;">
				<td><strong>Gesamt</strong></td>
				<td><strong>'.$gesamt_lebt.'</strong></td>
				<td><strong>'.$gesamt_tot.'</strong></td>
				<td><strong>'.$gesamt.'</strong></td>
			</tr>
				
		';

	?>
	</tbody>
</table>

<br /><br />

<h4>Katzenopfer</h4>
<table id="noprint" class="striped centered">
	<thead>
		<tr style="background-color: #ddd;">
			<th></th>
			<th colspan="2">Nestling</th>
			<th colspan="2">Ästling</th>
			<th colspan="2">Juvenil</th>
			<th colspan="2">Adult</th>
			<th colspan="3" style="background-color: #ddd;">Gesamt</th>
		</tr>
		<tr style="background-color: #ddd;">
			<th></th>
			<th width="6%">&dagger;</th>
			<th width="6%">*</th>
			<th width="6%">&dagger;</th>
			<th width="6%">*</th>
			<th width="6%">&dagger;</th>
			<th width="6%">*</th>
			<th width="6%">&dagger;</th>
			<th width="6%">*</th>
			<th width="6%" style="background-color: #ddd;">&dagger;</th>
			<th width="6%" style="background-color: #ddd;">*</th>
			<th width="6%" style="background-color: #ddd;">=</th>
		</tr>
	</thead>
	<tbody>
	<?php

		$summe_nestling_tot = '0';
		$summe_nestling_lebt = '0';
		$summe_aestling_tot = '0';
		$summe_aestling_lebt = '0';
		$summe_juvenil_tot = '0';
		$summe_juvenil_lebt = '0';
		$summe_adult_tot = '0';
		$summe_adult_lebt = '0';
		$summe_tot = '0';
		$summe_lebt = '0';
		$summe = '0';

		// Vogelarten	
		$query = "SELECT `vogel_art`, sum(vogel_anzahl) as summe_katzenopfer FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' AND `vogel_katzenopfer`='1' GROUP BY `vogel_art` ORDER BY `vogel_art`";
		if($result = mysqli_query($mysqli, $query)) {
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
				
				$vogel_art = $row['vogel_art'];
				$summe_katzenopfer = $row['summe_katzenopfer'];
				$summe = $summe+$summe_katzenopfer;
				
				// Nestling & Nestling befiedert
				$query2 = "SELECT sum(vogel_anzahl) as summe_anzahl, sum(vogel_weitergeleitet) as summe_weitergeleitet, sum(vogel_ausgewildert) as summe_ausgewildert, sum(vogel_euthanasiert) as summe_euthanasiert, sum(vogel_verstorben) as summe_verstorben FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' AND `vogel_art`='$vogel_art' AND `vogel_stadium` LIKE 'nestling%' AND `vogel_katzenopfer`='1'";
				if($result2 = mysqli_query($mysqli, $query2)) {
					while($row2 = $result2->fetch_array(MYSQLI_BOTH)) {
					
						$nestling_anzahl = $row2['summe_anzahl'];
						$nestling_weitergeleitet = $row2['summe_weitergeleitet'];
						$nestling_ausgewildert = $row2['summe_ausgewildert'];
						$nestling_euthanasiert = $row2['summe_euthanasiert'];
						$nestling_verstorben = $row2['summe_verstorben'];
						
						$nestling_lebt = $nestling_anzahl-$nestling_euthanasiert-$nestling_verstorben;
						$nestling_tot = $nestling_euthanasiert+$nestling_verstorben;
						
						$summe_nestling_tot = $summe_nestling_tot+$nestling_tot;
						$summe_nestling_lebt = $summe_nestling_lebt+$nestling_lebt;
						
					}
					
				}
				
				// Ästling
				$query3 = "SELECT sum(vogel_anzahl) as summe_anzahl, sum(vogel_weitergeleitet) as summe_weitergeleitet, sum(vogel_ausgewildert) as summe_ausgewildert, sum(vogel_euthanasiert) as summe_euthanasiert, sum(vogel_verstorben) as summe_verstorben FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' AND `vogel_art`='$vogel_art' AND `vogel_stadium`='aestling' AND `vogel_katzenopfer`='1'";
				if($result3 = mysqli_query($mysqli, $query3)) {
					while($row3 = $result3->fetch_array(MYSQLI_BOTH)) {
						
						$aestling_anzahl = $row3['summe_anzahl'];
						$aestling_weitergeleitet = $row3['summe_weitergeleitet'];
						$aestling_ausgewildert = $row3['summe_ausgewildert'];
						$aestling_euthanasiert = $row3['summe_euthanasiert'];
						$aestling_verstorben = $row3['summe_verstorben'];
						
						$aestling_lebt = $aestling_anzahl-$aestling_euthanasiert-$aestling_verstorben;
						$aestling_tot = $aestling_euthanasiert+$aestling_verstorben;
						
						$summe_aestling_tot = $summe_aestling_tot+$aestling_tot;
						$summe_aestling_lebt = $summe_aestling_lebt+$aestling_lebt;
						
					}
					
				}
				
				// Juvenil
				$query4 = "SELECT sum(vogel_anzahl) as summe_anzahl, sum(vogel_weitergeleitet) as summe_weitergeleitet, sum(vogel_ausgewildert) as summe_ausgewildert, sum(vogel_euthanasiert) as summe_euthanasiert, sum(vogel_verstorben) as summe_verstorben FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' AND `vogel_art`='$vogel_art' AND `vogel_stadium`='juvenil' AND `vogel_katzenopfer`='1'";
				if($result4 = mysqli_query($mysqli, $query4)) {
					while($row4 = $result4->fetch_array(MYSQLI_BOTH)) {
						
						$juvenil_anzahl = $row4['summe_anzahl'];
						$juvenil_weitergeleitet = $row4['summe_weitergeleitet'];
						$juvenil_ausgewildert = $row4['summe_ausgewildert'];
						$juvenil_euthanasiert = $row4['summe_euthanasiert'];
						$juvenil_verstorben = $row4['summe_verstorben'];
						
						$juvenil_lebt = $juvenil_anzahl-$juvenil_euthanasiert-$juvenil_verstorben;
						$juvenil_tot = $juvenil_euthanasiert+$juvenil_verstorben;
						
						$summe_juvenil_tot = $summe_juvenil_tot+$juvenil_tot;
						$summe_juvenil_lebt = $summe_juvenil_lebt+$juvenil_lebt;
						
					}
					
				}
				
				// Adult
				$query5 = "SELECT sum(vogel_anzahl) as summe_anzahl, sum(vogel_weitergeleitet) as summe_weitergeleitet, sum(vogel_ausgewildert) as summe_ausgewildert, sum(vogel_euthanasiert) as summe_euthanasiert, sum(vogel_verstorben) as summe_verstorben FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' AND `vogel_art`='$vogel_art' AND `vogel_stadium`='adult' AND `vogel_katzenopfer`='1'";
				if($result5 = mysqli_query($mysqli, $query5)) {
					while($row5 = $result5->fetch_array(MYSQLI_BOTH)) {
						
						$adult_anzahl = $row5['summe_anzahl'];
						$adult_weitergeleitet = $row5['summe_weitergeleitet'];
						$adult_ausgewildert = $row5['summe_ausgewildert'];
						$adult_euthanasiert = $row5['summe_euthanasiert'];
						$adult_verstorben = $row5['summe_verstorben'];
						
						$adult_lebt = $adult_anzahl-$adult_euthanasiert-$adult_verstorben;
						$adult_tot = $adult_euthanasiert+$adult_verstorben;
						
						$summe_adult_tot = $summe_adult_tot+$adult_tot;
						$summe_adult_lebt = $summe_adult_lebt+$adult_lebt;
						
					}
					
				}
				
				$summe_art_tot = $nestling_tot+$aestling_tot+$juvenil_tot+$adult_tot;
				$summe_art_lebt = $nestling_lebt+$aestling_lebt+$juvenil_lebt+$adult_lebt;
				
				echo '
					<tr>
						<td>'.$vogel_art.'</td>
						<td>'.$nestling_tot.'</td>
						<td>'.$nestling_lebt.'</td>
						<td>'.$aestling_tot.'</td>
						<td>'.$aestling_lebt.'</td>
						<td>'.$juvenil_tot.'</td>
						<td>'.$juvenil_lebt.'</td>
						<td>'.$adult_tot.'</td>
						<td>'.$adult_lebt.'</td>
						<td style="background-color: #ddd;">'.$summe_art_tot.'</td>
						<td style="background-color: #ddd;">'.$summe_art_lebt.'</td>
						<td style="background-color: #ddd;"><strong>'.$summe_katzenopfer.'</strong></td>
					</tr>
						
				';

			}
			
		}
		
		$summe_tot = $summe_nestling_tot+$summe_aestling_tot+$summe_juvenil_tot+$summe_adult_tot;
		$summe_lebt = $summe_nestling_lebt+$summe_aestling_lebt+$summe_juvenil_lebt+$summe_adult_lebt;
		
		echo '
			<tr style="background-color: #ddd;">
				<td><strong>Gesamt</strong></td>
				<td><strong>'.$summe_nestling_tot.'</strong></td>
				<td><strong>'.$summe_nestling_lebt.'</strong></td>
				<td><strong>'.$summe_aestling_tot.'</strong></td>
				<td><strong>'.$summe_aestling_lebt.'</strong></td>
				<td><strong>'.$summe_juvenil_tot.'</strong></td>
				<td><strong>'.$summe_juvenil_lebt.'</strong></td>
				<td><strong>'.$summe_adult_tot.'</strong></td>
				<td><strong>'.$summe_adult_lebt.'</strong></td>
				<td><strong>'.$summe_tot.'</strong></td>
				<td><strong>'.$summe_lebt.'</strong></td>
				<td><strong>'.$summe.'</strong></td>
			</tr>
		';

	?>
	</tbody>
</table>

<br /><br />

<h4>Spenden</h4>
<table id="noprint" class="striped centered">
	<thead>
		<tr style="background-color: #ddd;">
			<th>Vogelart</th>
			<th>Spender/Betrag</th>
		</tr>
	</thead>
	<tbody>
	<?php

		// Spender
		$summe_spender = '0';
		$summe_spenden = '0';
		
		$query = "SELECT `vogel_art`, sum(finder_spende) as spender, sum(finder_spende_betrag) as spenden FROM `aufnahmebuch` WHERE `mandant`='$session_mandant' AND `datum` like '$statyear%' GROUP BY `vogel_art`";
		if($result = mysqli_query($mysqli, $query)) {
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
				
				echo '
					<tr>
						<td width="50%">'.$row['vogel_art'].'</td>
						<td width="50%">'.$row['spender'].' Spender / '.$row['spenden'].' €</td>
					</tr>
						
				';
				
				$summe_spender = $summe_spender + $row['spender'];
				$summe_spenden = $summe_spenden + $row['spenden'];

			}
			
		}
		
		echo '
			<tr style="background-color: #ddd;">
				<td width="50%"><strong>Gesamt</strong></td>
				<td width="50%"><strong>'.$summe_spender.' Spender / '.$summe_spenden.' €</strong></td>
			</tr>
				
		';

	?>
	</tbody>
</table>

<br /><br />

<h4>Ausgaben</h4>
<table id="noprint" class="striped centered">
	<thead>
		<tr style="background-color: #ddd;">
			<th>Kategorie</th>
			<th>Betrag</th>
		</tr>
	</thead>
	<tbody>
	<?php

		// Ausgaben
		$summe_betrag = '0';
		
		$query = "SELECT sum(betrag) as betrag, `kategorie` FROM `kassenbuch` WHERE `mandant`='$session_mandant' AND `typ`='2' AND `datum` like '$statyear%' GROUP BY `kategorie`";
		if($result = mysqli_query($mysqli, $query)) {
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
				
				echo '
					<tr>
						<td width="50%">'.$row['kategorie'].'</td>
						<td width="50%">'.round($row['betrag'], 2).' €</td>
					</tr>
						
				';
				
				$summe_betrag = $summe_betrag + $row['betrag'];

			}
			
		}
		
		echo '
			<tr style="background-color: #ddd;">
				<td width="50%"><strong>Gesamt</strong></td>
				<td width="50%"><strong>'.round($summe_betrag, 2).' €<strong></td>
			</tr>
				
		';

	?>
	</tbody>
</table>

<br />

<p><a href="javascript:window.print()"><i class="material-icons left">print</i> Statistik ausdrucken</a></p>