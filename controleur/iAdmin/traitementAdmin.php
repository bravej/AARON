<?php
	$action = $_POST['Action'];
	if ($action == 'Rechercher') {
		$search = $_POST['Pseudo'];
		include '../../modele/iAdmin/RechercheUser.php';
	}
	elseif ($action == 'Supprimer') {
		$delete = $_POST['Condamne'];
		include '../../modele/iAdmin/SupprUser.php';
	}
	elseif ($action == 'Bloquer') {
		$block = $_POST['Condamne'];
		include '../../modele/iAdmin/BlockUser.php';
	}
	elseif($action == 'Debloquer') {
		$unblock = $_POST['Condamne'];
		include '../../modele/iAdmin/UnblockUser.php';
	}elseif($action == 'Nettoyer') {
		include '../../modele/iAdmin/CleanUsers.php';
	}else
		echo 'bouton non reconnu';
?>
