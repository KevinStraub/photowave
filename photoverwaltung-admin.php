<?php
include 'includes/config.php';
$menu_active = '';
$title = 'Photoverwaltung - Administrator';
include 'includes/header-include.php';
############################
######## Main Part #########
############################

if($_SESSION["groupid"] == 1) {

	// Löschen eines Fotos
	if (isset($_POST['remove_foto'])) {
		
		// Check gibt es "FOTO"?
		$sql = 	'
			SELECT *
			FROM tblfoto
			WHERE
				FotoID = "'.mysql_real_escape_string($_POST['id']).'"
		';
		$foto_sql = mysql_query($sql);
		
		if ($foto = mysql_fetch_array($foto_sql)) {
			
			// Foto löschen HD
			unlink('./uploads/'.$foto['FotoName']);
			unlink('./uploads/thumb_'.$foto['FotoName']);
			
			// Foto löschen DB
			$sql = '
				DELETE
				FROM tblfoto 
				WHERE
					FotoID = "'.mysql_real_escape_string($_POST['id']).'"
			';
			mysql_query($sql);
		}
	}
	
	// Main Part
	$sql = 	'
		SELECT *
		FROM tblfoto
		ORDER by Datum DESC
	';
	
	$ergebnis = mysql_query($sql);
	$anzahl = @mysql_num_rows($ergebnis);
	if ($anzahl > 0) {
		while ($zeile = mysql_fetch_array($ergebnis)) {
			echo '
			<div>
				<form action="" method="post">
					<input type="hidden" name="id" value="'.$zeile['FotoID'].'" />
					<img src="uploads/thumb_'.$zeile['FotoName'].'" alt="Thumbnail">
					<input type="submit" name="remove_foto" value="Foto löschen" />
				</form>
			</div>';
		}
	} else {
		echo '<p>Du hast keine Fotos</p>';
	}
} else {
	echo 'Sie sind nicht berechtigt diese Seite zu sehen.';
}

############################
########### End ############
############################
include 'includes/sidebar-include.php';
include 'includes/footer-incude.php';
?>