<?php
	session_start();
?>

<?php //Récupération donnée du formulaire

	
	$login = $_POST['login'];
	
	$pass = $_POST['pass'];
	$confirm_pass = $_POST['confirm_pass'];
	$old_pass = $_POST['old_pass'];
	
	$email = $_POST['email'];
	$boxmail = $_POST['boxmail'];
	
	$action = $_POST['action']; 
	
	include('../../modele/formulaire/User.php');
		$user = new User($login, $pass, $email, $etat);
?>

<?php
	if ($action == 'INSCRIPTION')
	{		
		$user->inscription($confirm_pass);
	}
	elseif ($action == 'CONNEXION')
	{
		$msg = $user->connexion();
	}
	elseif ($action == 'Changer')
	{
		$user->changermdp($confirm_pass, $old_pass);
	}
	elseif ($action == 'mail')
	{
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
	include('../../vue/formulaire/Info.php');
?>

<?php //Déconnexion de la Base de Donnée
	$dbh = null; 
 ?>	
