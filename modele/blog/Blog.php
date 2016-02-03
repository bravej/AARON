<?php
	class Blog {
		function ajouterPost($titre, $corps){ //ajouter un post : paramètres -> titre et corps 
			try {
				$today = date('Y-m-d, H:i:s'); //aujourd'hui au format 2016-mois-jour, heure:min:sec
				$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca');
				$db->exec('INSERT INTO posts (TITRE, DATE_POST, CORPS) VALUES (\'' . $titre . '\', \'' . $today . '\', \'' . $corps . '\')'); // insert le post
				$id_insere = $db->query('SELECT max(ID) AS maxid FROM posts'); //Nous récupérons l'id du dernier tuple inséré dans posts : c'est le max des id à cause de l'auto incremente 
				while($row = $id_insere->fetch(PDO::FETCH_ASSOC)) {
					$donnees_total = $row['maxid'];//opérateur de calcul vertical : renvoie un unique tuple;
				}

				$db->exec('INSERT INTO postsComptes (idCompte, idPost) VALUES (\'' . $_SESSION['ID'] . '\', \'' . $donnees_total . '\')'); // insert l'association utilisateur post

			}
			catch(PDOException $ex) {
				echo '<h1>An Error occured!</h1>'; //user friendly message 
			}
		}
		
		function changerPage($page){
			$_SESSION['Page'] = $page;
			header('Location: ../../vue/blog/blog.php');
		}

		function display_posts($pageActuelle, $getlogin) {
			try {
				$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				$messagesParPage=5; //Nous allons afficher 5 messages par page.

				$retour_total = $db->query('SELECT COUNT(*) AS total FROM postsComptes WHERE idCompte IN (SELECT ID FROM comptes WHERE login = \'' . $getlogin.'\')'); //on compte le nb de tuples
				while($row = $retour_total->fetch(PDO::FETCH_ASSOC)) {
					$donnees_total = $row['total'];
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
				
				$req = $db->query('SELECT *
									FROM postsComptes pc JOIN posts ON pc.idPost = posts.ID 
														JOIN comptes ON pc.idCompte = comptes.ID
									WHERE idCompte IN (SELECT ID FROM comptes WHERE login = \'' . $getlogin.'\')
									ORDER BY posts.DATE_POST DESC
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

		function rechercherUser($user) { // rechercher les utilisateurs commençants par $user
			$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$req = $db->prepare('SELECT login FROM comptes WHERE login LIKE :login');
			if ($req->execute(array(':login' => $user . '%'))) {
                            $msg = '';
				while ($row = $req->fetch(PDO::FETCH_OBJ)) {
					$msg .=
					'
					<div class="container">
						<div class="row">
							<form action="../../controleur/blog/traitement.php" method="post">
								<input name="userRecherche" value="' . $row->login . '" type="hidden">' . $row->login . '<br/>
								<a href="../../vue/blog/blog.php?login=' . $row->login . '">Acces</a> 
								<input name="Action" value="Follow" type="submit"/>
							</form></br>
						</div>
					</div>
					';
				}
			}
                        return $msg;
		}

		function follow($user){	//Suivre $user en l'insert dans la table d'association entre l'utilisateur et $user
			try {
				$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				$stmt = $db->query('SELECT ID FROM comptes WHERE login = \'' . $user . '\'');
				$id = $stmt->fetch(PDO::FETCH_ASSOC);
				$db->exec('INSERT INTO comptesSuivis VALUES (\'' . $_SESSION['ID'] . '\', \'' . $id['ID'] . '\')');
				$msg = 'Vous suivez maintenant ' . $user . '<br/>';
				$msg .= '<a href="../../vue/blog/blog.php">Retour au blog</a>';
			}
			catch(PDOException $ex) {
				$msg = 'Une erreur est survenue. Vous suivez peut etre deja cette personne.'; //user friendly message 
			}
                        return $msg;
		}
	}
?>
