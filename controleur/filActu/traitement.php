<?php
	include '../../modele/filActu/Fil.php';
	$fil = new Fil();
	session_start();

	if (isset($_POST["Action"])) {
		$action = 	$_POST["Action"];
		echo $action;
	}

	if ($action == 'Previous'){
		if ($_SESSION['pageFil'] > 1){
			--$_SESSION['pageFil'];
		}
		header('Location: ../../vue/filActu/filactu.php');
	}
	else if ($action == 'Next'){
		if ($_SESSION['pageFil'] < $_SESSION['pageMax']){
			++$_SESSION['pageFil'];
		}
		header('Location: ../../vue/filActu/filactu.php');
	}
	else{
		echo '<br/><strong>Bouton non géré !</strong><br/>';
	}
?>
