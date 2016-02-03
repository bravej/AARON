<?php
	
	$dbh = connectionBd();
	
	$stmt = $dbh->prepare("SELECT source FROM sources WHERE ID = :id");
	$stmt->bindParam(':id', $_SESSION['ID']);
	$stmt->execute();
	$source = array();
	$cpt = 0;
	while ($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		array_push($source, $row->source);
		echo '<input id = position type=checkbox name=choix[] value='.$cpt. '>' . $row->source . '</br>';
		++$cpt;
	}	

	$stmt->closeCursor();

?>