<?php 
	session_start();
	require '../../modele/connexion/connexionBd.php';
	require '../../modele/categorie/categorie.php';
	$categorie = $_SESSION['categorie'];
	error_reporting(E_ALL);
	if(!empty($_POST['choix']))
	{	
		foreach($_POST['choix'] as $val)
		{
			$maCategorie = new Categorie ($categorie[$val]); 
			$maCategorie->supprimerCategorie();
		}
		$msg = "Categorie supprimé";
		include ('../../vue/formulaire/Info.php');

	}
	else
	{
		echo 'Erreur dans la récuperation des sources';
	}
?>