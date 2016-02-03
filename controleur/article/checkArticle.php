<?php
	session_start();
	require'../../modele/connexion/connexionBd.php';
	require'../../modele/flux/Article.php';
	require '../../modele/blog/Blog.php';
	$action = $_POST['action'];
	error_reporting(E_ALL);
	if(!empty($_POST['choix']))
	{	
		
		if ($action == 'Favori')
		{
			$article  = $_SESSION["urls"];
			$monArticle = new Article ($article);
			$monArticle->ajouterArticle();
			$msg = "Article(s) saugardé(s) dans favori";
			include ('../../vue/formulaire/Info.php');
		}
		else
		{
			$blog = new  Blog ();
			$title = $_SESSION['title'];
			$description = $_SESSION['description'];
			foreach($_POST['choix'] as $val)
			{
				$blog->ajouterPost($title[$val], $description[$val]);
			}
			$msg = "Article(s) saugardé(s) dans blog";
			include ('../../vue/formulaire/Info.php');	
		}
	}
	else
	{
		echo 'Erreur dans la récuperation des favories';

	}
?>