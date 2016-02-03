<?php //Connexion Base de Donnée par PDO
try {
	$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>


<?php

// Récupération des variables nécessaires à l'activation
	$login = $_GET['log'];
	$cle = $_GET['cle'];
	
// Récupération de la clé correspondant au login dans la base de données
	$stmt = $dbh->prepare("SELECT cle,actif FROM comptes WHERE login like :login ");
	if($stmt->execute(array(':login' => $login)) && $row = $stmt->fetch())
	  {
		$clebdd = $row['cle'];	// Récupération de la clé
		$actif = $row['actif']; // $actif contiendra alors 0, 1 ou 2
	  }

// On teste la valeur de la variable $actif récupéré dans la BDD
	if($actif == '1') // Si le compte est déjà actif on prévient
	  {
		 $msg = "Votre compte est déjà actif !";
	  }
	elseif($actif == '0') // Si le compte est innactif on passe aux comparaisons
	  {
		 if($cle == $clebdd) // On compare nos deux clés	
		   {
		// Si elles correspondent on active le compte !	
			  $msg = "Votre compte a bien été activé !";
	 
		// La requête qui va passer notre champ actif de 0 à 1
			  $stmt = $dbh->prepare("UPDATE comptes SET actif = 1 WHERE login like :login ");
			  $stmt->bindParam(':login', $login);
			  $stmt->execute();
		   }
		 elseif($actif == '2') // Si le compte est bloqué on prévient
	    {
			 $msg = "Votre compte est bloqué !";
		}
		 else // Si les deux clés sont différentes on provoque une erreur...
		   {
			  $msg = "Erreur ! Votre compte ne peut être activé...";
		   }
	  }
	include ('../../vue/formulaire/Info.php');
?>
<?php //Déconnexion de la Base de Donnée
	$dbh = null; 
 ?>	
