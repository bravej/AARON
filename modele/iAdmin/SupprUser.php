<?php
	try {
		$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca');
		$req = $db->prepare('DELETE FROM comptes WHERE login = ?');
		$req->bindParam(1, $delete);
		if ($req->execute()) {
			$msg = $delete . ' supprime<br/>
				<a href="../../vue/iAdmin/InterfaceAdmin.php">retour</a><br />';
		}
	}
	catch(PDOException $ex) {
		$msg = "An Error occured!"; //user friendly message 
	}
	
	include ('../../vue/formulaire/Info.php');
?>
