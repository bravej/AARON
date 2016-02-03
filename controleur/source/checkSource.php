<?php 
// on fait une correspondance entre les cases coché et la bd  
	session_start();
	$source = $_SESSION['source'];
	require '../../modele/source/source.php';
	error_reporting(E_ALL);
	if(!empty($_POST['choix']))
	{	
		foreach($_POST['choix'] as $val)
		{
			$maSource = new Source ($source[$val]); 
			$maSource->supprimerSource();
		}
		$msg = "Source supprimé";
		include ('../../vue/formulaire/Info.php');			
	}
	else
	{
		$msg = 'Erreur dans la récuperation des sources';
		include ('../../vue/formulaire/Info.php');			
	}
?>