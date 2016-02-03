<?php
	require '../../modele/categorie/categorie.php'; 
	require '../../modele/connexion/connexionBd.php';
	session_start();
	$categorie = $_POST["categorie"];
	//$image = $_POST["image"];
	$maCategorie = new Categorie (/*$image, */$categorie);
	$maCategorie->ajoutCategorie();
	$msg = "Categorie ajouté";
	include ('../../vue/formulaire/Info.php');

?>