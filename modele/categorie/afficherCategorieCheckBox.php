<?php

	$dbh = connectionBd();
	$stmt = $dbh->prepare("SELECT Nom FROM categorie WHERE ID = :id");
	$stmt->bindParam(':id', $_SESSION['ID']);
	$stmt->execute();
	
	$categorie = array();
	$cpt = 0;
	while ($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		array_push($categorie, $row->Nom);
		echo '<input id = position type=checkbox name=choix[] value='.$cpt. '>' . $row->Nom . '</br>';
		++$cpt;
	}	


?>