<?php
	try {
		$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca');
		$req = $db->prepare('DELETE FROM comptes WHERE actif = 0');
		$req->execute();
		$msg = 'Comptes nettoyés !<br/><a href="../../vue/iAdmin/InterfaceAdmin.php">Retour</a>';
	}
	catch(PDOException $ex) {
		$msg = "An Error occured!"; //user friendly message 
	}
	
	include ('../../vue/formulaire/Info.php');
?>