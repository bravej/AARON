<?php //Connexion Base de Donnée par PDO
	session_start();
?>

<?php
	
	class User{
		
		private $login;
		private $pass;
		private $email;
		private $etat; //activé/innactif/bloqué/admin

		
		
		function __construct($login, $pass, $email, $etat){
			$this->login = $login;
			$this->pass = $pass;
			$this->email = $email;
			$this->etat = $etat;			
		}
		
		/*public function afficher(){
			echo "Pseudo : " . $this->login . '<br/>MDP : ' . $this->pass . '<br/>E-mail : ' . $this->email . '<br/>Etat : ' . $this->etat;
		
		}*/
		
		public function connexion(){
			try {
				$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
			} catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}
		//On récupère la variable $actif dans la Base de Données
			$stmt = $dbh->prepare("SELECT actif FROM comptes WHERE email like :email ");
			$stmt->bindParam(':email', $this->email);
			$stmt->execute();
			
			while ($row = $stmt->fetch(PDO::FETCH_OBJ))
			{
				$actif=$row->actif;
			}
			
		// On teste la valeur de la variable $actif récupéré dans la Base de Données
			if($actif == '1' || $actif == '3') // Si le compte est actif ou admin
			{
			//On récupère le mot de passe dans la Base de Données
				$stmt = $dbh->prepare("SELECT mot_de_passe FROM comptes WHERE email like :email ");
				$stmt->bindParam(':email', $this->email);
				$stmt->execute();
				
				$stmt2 = $dbh->prepare("SELECT ID FROM comptes WHERE email = :email ");
				$stmt2->bindParam(':email', $this->email);
				$stmt2->execute();
				
				while ($row = $stmt->fetch(PDO::FETCH_OBJ))
				{
					$pass2 = $row->mot_de_passe; //On stock le mot de passe autrepart pour pouvoir le comparer avec celui rentré par user
				}
			

				while ($row2 = $stmt2->fetch())
				{
					$id = $row2['ID']; 
				}
			

				if(password_verify($this->pass, $pass2)) { //Si c'est le bon mot de passe
					
					$stmt = $dbh->prepare("SELECT login FROM comptes WHERE email = :email ");
					$stmt->bindParam(':email', $this->email);
					$stmt->execute();
					
					while ($row = $stmt->fetch(PDO::FETCH_OBJ))
					{
						$login=$row->login;
					}
			
					$_SESSION['login'] = $login;
					$_SESSION['ID'] = $id;
					header('Location:../../index.php');
					exit();
				} else { //Sinon
					$msg = 'mauvais mot de passe';
				}
			}
			elseif ($actif == '0') // Si le compte est innactif on prévient
			{
				$msg = "veuillez activer votre compte";
			}
			elseif($actif == '2') // Si le compte est bloqué on prévient
			{
				 $msg = "Votre compte est bloqué !";
			}
			else //Sinon le compte on retourne une erreur
			{
				$msg = "ce compte n'existe pas";
			}
                        return $msg;
		}
		
		public function inscription($confirm_pass){
			try {
				$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
			} catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}
			$msg = ''; //Message renvoyé à user suite à l'inscription (diffère celon les cas)
	
		//Si l'utilisateur oublie un champs
			if ($this->login == '')
				$msg .= "Vous n'avez pas spécifié votre login </br>";
			if ($this->pass =='')
				$msg .= "Vous n'avez pas spécifié votre mot de passe </br>";
			if ($this->pass != $confim_pass)
				$msg .= "Votre mot de passe n'est pas confirmé </br>";
			if ($this->email == '')
				$msg .= "Vous n'avez pas spécifié votre adresse e-mail </br>";
			
		//Si tous les champs sont remplis
			if ($this->login != '' && $this->pass != '' && $this->email != '' && $this->pass == $confirm_pass)
			{
			//Recherche du Login dans la Base de Données
				$stmt = $dbh->prepare('SELECT login FROM comptes WHERE login LIKE :login') or exit(print_r($bdd->errorInfo()));
				$stmt->bindParam(':login', $this->login);
				$stmt->execute();
				
				while ($row = $stmt->fetch(PDO::FETCH_OBJ))
				{
					$bisLogin=$row->login; //On stock le login autrepart pour pouvoir le comparer avec celui rentré par user
				}
				
			//Recherche de l'adresse mail dans la Base de Données	
				$stmt = $dbh->prepare('SELECT email FROM comptes WHERE email LIKE :email') or exit(print_r($bdd->errorInfo()));
				$stmt->bindParam(':email', $this->email);
				$stmt->execute();
				$bisEmail;
				while ($row = $stmt->fetch(PDO::FETCH_OBJ))
				{
					$bisEmail=$row->email;//On stock l'e-mail autrepart pour pouvoir la comparer avec celle rentrée par user
				}
			
				if ($this->login == $bisLogin){ //Vérification de la disponnibilitée du login
					$msg = 'Ce pseudo est déjà utilisé';
				}elseif ($this->email == $bisEmail){ //Vérification de la disponnibilitée de l'addresse e-mail
					$msg = 'Cette adresse e-mail est déjà utilisée';
				}else{ //Si Login et addresse e-mail disponnible	
				//Hashage du mot de passe
					$hash = password_hash($this->pass,PASSWORD_BCRYPT) ;
					
				//Stockage du compte dans la Base de Données
					$stmt = $dbh->prepare('INSERT INTO comptes(login, mot_de_passe, email) VALUES(:login, :pass, :email)') or exit(print_r($bdd->errorInfo()));
					$stmt->bindParam(':login', $this->login);
					$stmt->bindParam(':pass', $hash);
					$stmt->bindParam(':email', $this->email);
					$stmt->execute();
					
					
				// Génération aléatoire d'une clé
					$cle = md5(microtime(TRUE)*100000);
					
				// Insertion de la clé dans la Base de Donnéess		
					$stmt = $dbh->prepare("UPDATE comptes SET cle=:cle WHERE login like :login");
					$stmt->bindParam(':cle', $cle);
					$stmt->bindParam(':login', $this->login);
					$stmt->execute();
				
				//Préparation du mail de validation
					$mail = 'Bienvenue sur notre site
								Vos identifiants sont :
									Pseudo : ' . $this->login . '
									e-mail : ' . $this->email . '
									Mot de passe : ' . $this->pass . '
									
								Pour activer votre compte, veuillez cliquer qur le lien ci dessous
								http://projetphp2015.alwaysdata.net/modele/formulaire/validation_cpt.php?log='.urlencode($this->login).'&cle='.urlencode($cle);
								
				//Envoye du mail				
					mail($this->email, 'Inscription', $mail);
					
					$_SESSION ['login'] = $_POST['login'];
					
				//Message renvoyé à user si inscription conforme	
					$msg = "Votre compte a été créé. <br/>
							Toutefois, ce forum requiert que votre compte soit activé, et donc une clef d'activation a été envoyée à l'adresse e-mail que vous avez fournie. <br/>
							Veuillez vérifier votre boîte e-mail pour de plus amples informations.<br /><br />
							Si vous utilisez un système de messagerie comme hotmail, vérifiez que cet email n'est pas placé dans le dossier 'Courrier indésirable'.<br/>
							Ajoutez-le à votre liste blanche pour pouvoir recevoir les notifications et autres informations en provenance du forum.<br /><br />";
				}
			}
			include ('../../vue/formulaire/Info.php');
		}
		
		public function changermdp($confirm_pass, $old_pass){
			try {
				$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
			} catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}
		//On récupère le mot de passe dans la Base de Données
			$stmt = $dbh->prepare("SELECT mot_de_passe FROM comptes WHERE login like :login ");
			$stmt->bindParam(':login', $_SESSION['login']);
			$stmt->execute();
			
			$pass2;
			
			while ($row = $stmt->fetch(PDO::FETCH_OBJ))
			{
				$pass2 = $row->mot_de_passe; //On stock le mot de passe autrepart pour pouvoir le comparer avec celui rentré par user
			}

		
			if(password_verify($old_pass, $pass2)) { //Si c'est le bon mot de passe
				if($this->pass == $confirm_pass)
				{
					$hash = password_hash($this->pass,PASSWORD_BCRYPT) ;
					
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
						
				$msg = 'Mauvais mot de passe<br/>
							<a href="../../vue/formulaire/formulaire.php">Réessayer</a>';
			}

		
		
		
		include ('../../vue/formulaire/Info.php');
		}
		
		public function mail($boxmail, $email, $pass){
			if ($boxmail == 'Gmail'){
			$boxmail = 'gmail.com';
		}else{
			$boxmail = 'mail.yahoo.com';
		}
		 $mails = FALSE;
		 $mbox =imap_open("{imap.".$boxmail.":993/imap/ssl}", $email, $pass);
		 
		  if (FALSE === $mbox) {
				$err = "Connexion impossible !<br/>
						Soit vaux identifiants sont incorrects<br/>
						Soit vous tentez de vous connecter sur un systeme de messagerie autre que Gmail ou Yahoo<br/><br/>
						
						Si vous essayez de vous connecter avec un compte Gmail, vous devez activer le protocole IMAP<br/>
						Pour activer le protocole IMAP dans vos paramètres Gmail<br/>
						1.Connectez-vous à Gmail.<br/>
						2.Cliquez sur l'icône représentant une roue dentée en haut à droite de l'écran, puis sélectionnez Paramètres.<br/>
						3.Cliquez sur Transfert et POP/IMAP.<br/>
						4.Sélectionnez Activer IMAP.<br/>
						5.Cliquez sur Enregistrer les modifications.<br/><br/>
						
						Vous devez aussi autoriser les applications moins sécurisées
						pour cela cliquez <a href=\"https://www.google.com/settings/security/lesssecureapps\">ici</a> après vous êtres connecté.";
			   
			  
			  }else{
				  $info = imap_check($mbox);
				  if (FALSE !== $info){
					$nbMsg = min(50, $info->Nmsgs);
					$mails = imap_fetch_overview($mbox, '1:' . $nbMsg, 0);
				  }else{
					$err = 'echec de la quete';
				  }
				  imap_close($mbox);
			  }
			
			if (FALSE === $mails){
				  $msg = $err;
			  }else{
				  $temps = 24*3600;
				  setcookie ("email", $email, time() + $temps);
				  setcookie ("pass", $pass, time() + $temps);
				  setcookie ("boxmail", $boxmail, time() + $temps);
				  $msg = '<br/>La boite au mail contient ' . $info->Nmsgs.' message(s) dont ' .
													  $info->Recent.' recent(s)<br/><br/>';
				  foreach ($mails as $i){
						$msg .= $i->from.
						' <a href="detail.php?uid='. $i->uid.'">' .
						$i->subject.'</a> '.
						$i->date.'<br/>';
				  }
			  }
			
		}
		
	}
	
	



?>