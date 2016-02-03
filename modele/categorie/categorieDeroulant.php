<?php

	$dbh = connectionBd();
	
	$stmt = $dbh->prepare("SELECT Nom FROM categorie WHERE ID = :id");

	$stmt->bindParam(':id', $_SESSION['ID']);

	$stmt->execute();

	while ($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		echo '<OPTION name =' . $row->Nom .'>'.$row->Nom.'</OPTION>';
	} // il faudra degager cette partit qui correspond a afficherCategorie mais pour le moment je ne voit pas 
	  // comment l'implementer		


?>