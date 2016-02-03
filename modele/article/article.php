<?php
	session_start();
	
	$dbh = connectionBd();

	
	$stmt = $dbh->prepare("SELECT Title, Description, Lien, DatePub FROM article WHERE ID = :id AND NomCategorie = :nom ORDER BY DatePub DESC");
	
	$stmt->bindParam(':id', $_SESSION['ID']);
	$stmt->bindParam(':nom', $_GET['categorie']);
	$stmt->execute();
	$lien = array();
	$title = array();
	$description = array();
	$datePub = array();

	while ($row = $stmt->fetch(PDO::FETCH_OBJ))
	{
		//$annonce = '<a href =' . $row->Lien . '>' . $row->Title . '</a>' . '</br>' . $row->Description . '</br>' . $row->DatePub . '</br>';
		//echo $annonce;
		array_push($lien, $row->Lien);
		array_push($title, $row->Title);
		array_push($description, $row->Description);
		array_push($datePub, $row->DatePub);
	} // revoir code ajout source pour adapter
?>