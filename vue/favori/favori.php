<?php 
	session_start();

	if(!(isset($_SESSION['pageFav']))) // Si la variable $_SESSION['page'] n'existe pas encore...
	{
		$_SESSION['pageFav'] = 1;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>AARON</title>
		<link rel="stylesheet" type="text/css" href="/style/style.css">
		<link rel="icon" type="image/png" href="/Images/favicon.png" />
		<meta charset="UTF-8">
        <meta name="description" content="AARON est une application web qui vous permet d'enregistrer et de consulter vos articles pr�f�r�s provenant de diff�rents sites." />
        <meta name="keywords" content="Flux, RSS, Twitter, AARON," />
	</head>
	<body>
		
		<header>
			<?php
			//affichage des fontion users
				if (isset($_SESSION ['login']) != ""){
					echo '<div id = "connecté">';
					echo "Bonjour " . $_SESSION['login'] . '
						  <br/>
						  <a href="../../vue/formulaire/formulaire.php">Espace membre</a><br />
						  <a href="../../vue/formulaire/deconnexion.php"> Deconnexion </a>';
					echo'</div>';
				}else{
					echo '<div id = "connexion">
								<form method="post" action="../../controleur/formulaire/traitement.php">
										<label>email : </label>
											<input type="text" name="email" size="30" /><br />
										<label>Mot de passe : </label>
											<input type="password" name="pass" size="30" /><br />
										<input type="submit" name="action" value="CONNEXION" />
										<div style="margin-left:10px;">
											Pas encore membre ? <a href="../../vue/formulaire/formulaire.php">Inscrivez-vous ici !</a><br />
											Mot de passe oublié ? <a href="../../modele/formulaire/Mot_de_passe_oublie.php">On vous aide ici !</a><br />
										</div>
								</form>
							</div>';
					}
				?>
			<div id="banniere"> </div>
		</header>
		
		<nav>
			<ul>
			
			<?php
				if (isset($_SESSION ['login']) == ""){
					echo '<a href="../../index.php">
							<li>
								<h3>Accueil</h3>
							</li>
						</a>
                                <a href="../../vue/fluxNonconnecte/nonConnecte.php">
							<li>
								<h3>Chercher Flux</h3>
							</li>
						</a>';
				}else{
					echo '<a href="../../index.php">
							<li>
								<h3>Flux RSS</h3>
							</li>
						</a>
						<a href="../../vue/gererCompte/choisirAction.php">
							<li>
								<h3>Gérer Flux</h3>
							</li>
						</a>';
				}
			?>			
			<a href="../../vue/Twitter/formTwitter.php">
				<li >
					<h3>Twitter</h3>
				</li>
			</a>
			<a href="../../vue/blog/blog.php">
				<li>
					<h3>Blog</h3>
				</li>
			</a>
			<?php
				if (isset($_SESSION ['login']) != ""){
					echo '<a href="../../vue/filActu/filactu.php">
						<li >
							<h3>Fil d\'actualité</h3>
						</li>
					</a>';
				}
			?>
			<?php
				include ('../../modele/connexion/AdminAccess.php');
			?>
		</ul>			
		</nav>

		<div id = "corp">
			<?php
				if (isset($_SESSION ['login']) != "")
				{
					include '../../modele/favori/favori.php';
					$fav = new Favori();
					$_SESSION['pageMax'] = $fav->pagination($_SESSION['pageFav']);
				}
			?>
		</div>
		<footer>
			<?php
			echo '
			<nav>
				<ul class="pager">
					<form action="../../controleur/favori/traitement.php" method="post">
						<input name="Page" value="' . $_SESSION['pageFav'] . '" type="hidden"/>';
							echo '<input name="Action" value="Previous" type="submit"/>';
							echo '<input value="' . $_SESSION['pageFav'] . '" disabled/>';
							echo '<input name="Action" value="Next" type="submit"/>';	
					echo '</form>
				</ul>
			</nav>';
		?>
		</footer>
	</body>
</html>
