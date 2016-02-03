<?php
	session_start();
	include '../../modele/blog/Blog.php';
	$blog = new Blog();
	$login = $_GET['login'];

	if (isset($_POST['Titre'])) { //lors de l'ajout d'un post
		$titre =	$_POST['Titre'];
	}
	
	if (isset($_POST['Corps'])) { //lors de l'ajout d'un post
		$corps = 	$_POST['Corps'];
	}
	
	if (isset($_POST["Page"])) { //lors de la navigation des pages (pagination)
		$page = 	$_POST["Page"];
	}

	if (isset($_POST["Recherche"])) { //lors de la recherche d'un utilisateur à suivre ou voir son blog (le début du pseudo)
		$recherche = 	$_POST["Recherche"];
	}
	
	if (isset($_POST["userRecherche"])) { //lors de la recherche d'un utilisateur à suivre ou voir son blog (le pseudo)
		$userRecherche = $_POST["userRecherche"];
	}

	if (isset($_POST["Action"])) { //envoyer si ajout de post, suivant ou précédant si pagination, rechercher si on cherche un utilisateur, suivre l'utilisateur après qu'on l'ait trouvé   
		$action = 	$_POST["Action"];
	}

	if($action == 'Envoyer'){
		$blog->ajouterPost($titre, $corps);
	}
	else if ($action == 'Previous'){
		if ($_SESSION['page'] > 1){
			--$_SESSION['page'];
		}
		header('Location: ../../vue/blog/blog.php');
	}
	else if ($action == 'Next'){
		if ($_SESSION['page'] < $_SESSION['pageMax']){
			++$_SESSION['page'];
		}
		header('Location: ../../vue/blog/blog.php');
	}
	else if ($action == 'Rechercher'){
		$msg = $blog->rechercherUser($recherche);
	}
	else if ($action == 'Follow'){
		$msg = $blog->follow($userRecherche);
	}
        else if ($action == 'Unfollow'){
		$msg = $blog->unfollow($userRecherche);
	}
	else{
		$msg = '<br/><strong>Bouton non géré !</strong><br/>';
	}
        
        include('../../vue/formulaire/Info.php');
?>
