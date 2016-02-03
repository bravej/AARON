<?php
	$dbh = connectionBd();
	$stmt = $dbh->prepare("SELECT Article FROM Favori WHERE ID = :id");
	$stmt->bindParam(':id', $_SESSION['ID']);
	$stmt->execute();

	$favori = array();
	$cpt = 0;
	while ($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		array_push($favori, $row->Article);
		echo '<input type=checkbox name=choix[] value='.$cpt. '>' . $row->Article . '</br>';
		++$cpt;
	}

?>