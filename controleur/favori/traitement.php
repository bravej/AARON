<?php
	session_start();
	
	if (isset($_POST["Page"])) { //lors de la navigation des pages (pagination)
		$page = 	$_POST["Page"];
	}

	if (isset($_POST["Action"])) { 
		$action = 	$_POST["Action"];
	}

	if ($action == 'Previous'){
		if ($_SESSION['pageFav'] > 1){
			--$_SESSION['pageFav'];
		}
		header('Location: ../../vue/favori/favori.php');
	}
	else if ($action == 'Next'){
		if ($_SESSION['pageFav'] < $_SESSION['pageMax']){
			++$_SESSION['pageFav'];
		}
		header('Location: ../../vue/favori/favori.php');
	}
	else{
		echo '<br/><strong>Bouton non géré !</strong><br/>';
	}
?>
