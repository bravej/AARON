<?php
	function afficherCategorie ()
	{
		try {
			$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage() . "<br/>";
			die();
		}
		
		$stmt = $dbh->prepare("SELECT Nom FROM categorie WHERE ID = :id");
		
		$stmt->bindParam(':id', $_SESSION['ID']);

		$stmt->execute();
		$categorie = array ();
		while ($row = $stmt->fetch(PDO::FETCH_OBJ))
		{
			array_push($categorie, $row->Nom);
		//	echo $row->Nom;
		} // revoir code ajout source pour adapter

		return $categorie;
	}

?>