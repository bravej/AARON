<?php
session_start();

$compte = $_POST['compte'];

$compte2 = $_GET['twitter'];

require '../../modele/Twitter/CTwitter.php';
$twitter = new CTwitter($compte);

$action = $_POST['action'];



if ($action == 'Visualiser'){
	$msg = $twitter->afficher();
	
}elseif ($action == 'Enregistrer'){
	$msg = 'twitter de @'. $compte .' enregistré';
	$twitter->sauvegarde($_SESSION['ID']);
	
}elseif ($action == 'Supprimer'){
	$msg = 'twitter de @'. $compte .' supprimé';
        
	$twitter->supprimer($_SESSION['ID']);
	
}elseif ( $compte2 != ''){
        $twitter = new CTwitter($compte2);
	$msg = $twitter->afficher();	
}else{
	$msg = "bouton non géré";
}
include('../../vue/formulaire/Info.php');
?>