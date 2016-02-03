<?php
	
	$msg = '';
	try {
		$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca');
		$req = $db->prepare('SELECT login FROM comptes WHERE login LIKE :login');
		if ($req->execute(array(':login' => $search . '%'))) {
			while ($row = $req->fetch(PDO::FETCH_OBJ)) {
				$msg .=
				'
				<div class="container">
					<div class="row">
						<form action="../../controleur/iAdmin/traitementAdmin.php" method="post">
							<input name="Condamne" value="' . $row->login . '" type="hidden">' . $row->login . '<br/>
							<input name="Action" value="Supprimer" type="submit"/>
							<input name="Action" value="Bloquer" type="submit"/>
							<input name="Action" value="Debloquer" type="submit"/>
						</form></br>
					</div>
				</div>
				';
			}
		}
	}
	catch(PDOException $ex) {
		echo "An Error occured!"; //user friendly message 
	}
	include ('../../vue/formulaire/Info.php');
?>
