<?php
	class Fil {
		function display_posts($pageActuelle, $session) {
			try {
				$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				$messagesParPage=5; //Nous allons afficher 5 messages par page.

				$retour_total = $db->query('SELECT COUNT(*) AS total
											FROM comptesSuivis cs
											JOIN postsComptes pc ON pc.idCompte = cs.userSuivi
											WHERE cs.user = ' . $session); //on compte le nb de tuples
				while($row = $retour_total->fetch(PDO::FETCH_ASSOC)) {
					$donnees_total = $row['total']; //On range retour sous la forme d'un tableau.
				}
				$retour_total->closeCursor();
				
				//Nous allons maintenant compter le nombre de pages.
				$nombreDePages=ceil($donnees_total/$messagesParPage);
		
				if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
				{
					$pageActuelle=$nombreDePages;
				}
				else if($pageActuelle<=0) // Si la valeur de $pageActuelle (le numéro de la page) est inferieure que $nombreDePages...
				{
					$pageActuelle=1;
				}
			
				$premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire
				if ($premiereEntree < 0){
					$premiereEntree = 0;
				}

				$req = $db->query('SELECT c.login, p.TITRE, p.DATE_POST, p.CORPS
									FROM comptes c
									JOIN comptesSuivis cs ON c.ID = cs.userSuivi
									JOIN postsComptes pc ON pc.idCompte = cs.userSuivi
									JOIN posts p ON p.ID = pc.idPost
									WHERE cs.user = '. $_SESSION['ID'] . 
									' ORDER BY p.DATE_POST DESC
									LIMIT ' . $premiereEntree . ', ' . $messagesParPage);

				while($row = $req->fetch(PDO::FETCH_ASSOC)){
					echo '<div class="blog-post">
							<h2 class="blog-post-title">' . $row['TITRE'] . '</h2>
							<p class="blog-post-meta">' . $row['DATE_POST'] . ' par <a href="#">' . $row['login'] . '</a></p>

							<p>' . $row['CORPS'] . '</p>
					</div><!-- /.blog-post -->';
				}

				return $nombreDePages; //on return le nb de pages max de la pagination 
			}
			catch(PDOException $ex) {
				echo "An Error occured!"; //user friendly message
			}
		}
	}
?>