<?php
	session_start();
	require('../../modele/flux/Article.php');
	error_reporting(E_ALL);
	if(!empty($_POST['choix']))
	{	
		$article = array();
		$article = $_SESSION['article'];
		foreach($_POST['choix'] as $val)
		{
			$monArticle = new Article ($article[$val]);	
			$monArticle->supprimerArticle();

		}
		$msg = "Article supprime";
		include ('../../vue/formulaire/Info.php');
	}
	else
	{
		echo 'Erreur dans la récuperation des favories';

	}
?>