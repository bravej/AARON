<?php
	session_start();
	
	//On récupère le mot de passe dans la Base de Données
		$stmt = $dbh->prepare("SELECT mot_de_passe FROM comptes WHERE login like :login ");
		$stmt->bindParam(':login', $login);
		$stmt->execute();
		
		while ($row = $stmt->fetch(PDO::FETCH_OBJ))
		{
			$pass2 = $row->mot_de_passe; //On stock le mot de passe autrepart pour pouvoir le comparer avec celui rentré par user
		}
	
		if(password_verify($old_pass, $pass2)) { //Si c'est le bon mot de passe
			if($pass == $confirm_pass)
			{
				$hash = password_hash($pass,PASSWORD_BCRYPT) ;
				
			//Mise à jour du mot de passe après hashage
				$stmt = $dbh->prepare("UPDATE comptes SET mot_de_passe = :hash WHERE login like :login ");
				$stmt->bindParam(':hash', $hash);
				$stmt->bindParam(':login', $_SESSION['login']);
				$stmt->execute();
				
			//Message de confirmation à user
				$msg = 'Votre nouveau mot de passe a été enregistré';
			}else{
				$msg ='Le mot de passe n\'a pas été confirmé<br/>
						<a href="../../vue/formulaire/formulaire.php">Réessayer</a>';
			}
		} else { //Sinon
			$msg = 'mauvais mot de passe';
		}

	
	
	
	include ('../../vue/formulaire/Info.php');
?>
