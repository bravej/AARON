<?php
	require'../connexion/connexionBd.php';
	$dbh = connectionBd();
	
	function random($car) {// renvoie une chaine aléatoire composée de $car caractères
		$string = "";
		$chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnpqrstuvwxy0123456789";
		srand((double)microtime()*1000000);
		for($i=0; $i<$car; $i++) {
			$string .= $chaine[rand()%strlen($chaine)];
		}
		return $string;
	}
?>

<?php
	$email = $_POST['email'];
	
	$action = $_POST['action'];

if ($action == 'mdp')
	{		
		$newpass = random(7); //génération d'un mot de passe de 7 caractères
		
		$mail = 'Voici votre nouveau mot de passe : ' . $newpass; //Préparation du mail
		
		$hash = password_hash($newpass,PASSWORD_BCRYPT) ; //hashage du mot de passe
		
	//Mise à jour du mot de passe
		$stmt = $dbh->prepare("UPDATE comptes SET mot_de_passe = :hash WHERE email like :email ");
		$stmt->bindParam(':hash', $hash);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		
	//Envoye du mail
		mail($email, 'Mot de passe oublié', $mail);

	//Message de confirmation à user
		$msg = 'Votre nouveau mot de passe a été envoyé par mail';
		include ('../../vue/formulaire/Info.php');

	}else{
		$msg ='Mauvaise addresse e-mail !';
	}
	
?>
