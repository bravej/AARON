<?php 
	require '../../modele/source/source.php';
	session_start();
	$source = $_POST["source"];
	$categorie = $_POST["categorie"];
	$maSource =  new Source ($source, $categorie);
	$maSource->ajoutSource(); 

?>