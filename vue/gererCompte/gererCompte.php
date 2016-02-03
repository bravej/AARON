<?php 
	session_start();
	require '../../modele/connexion/connexionBd.php';
	$choix = $_POST['choix'];
	$choix2 = $_POST['choix2'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>AARON</title>
		<link rel="stylesheet" type="text/css" href="/style/style.css">
		<link rel="icon" type="image/png" href="/Images/favicon.png" />
		<meta charset="UTF-8">
        <meta name="description" content="AARON est une application web qui vous permet d'enregistrer et de consulter vos articles prÈfÈrÈs provenant de diffÈrents sites." />
        <meta name="keywords" content="Flux, RSS, Twitter, AARON," />
	</head>
	<body>
		
		<header>
			<?php
			//affichage des fontion users
				if (isset($_SESSION ['login']) != ""){
					echo '<div id = "connect√©">';
					echo "Bonjour " . $_SESSION['login'] . '
						  <br/>
						  <a href="/vue/formulaire/formulaire.php">Espace membre</a><br />
						  <a href="/vue/formulaire/deconnexion.php"> Deconnexion </a>';
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
											Mot de passe oubli√© ? <a href="../../modele/formulaire/Mot_de_passe_oublie.php">On vous aide ici !</a><br />
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
					echo '<a href="/index.php">
							<li>
								<h3>Flux RSS</h3>
							</li>
						</a>
						<a href="/vue/gererCompte/choisirAction.php">
							<li>
								<h3>G√©rer Flux</h3>
							</li>
						</a>';
				}
			?>			
			<a href="/vue/Twitter/formTwitter.php">
				<li >
					<h3>Twitter</h3>
				</li>
			</a>
			<a href="/vue/blog/blog.php">
				<li>
					<h3>Blog</h3>
				</li>
			</a>
			<?php
				if (isset($_SESSION ['login']) != ""){
					echo '<a href="/vue/filActu/filactu.php">
						<li >
							<h3>Fil d\'actualit√©</h3>
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

				if ($choix == 'Categorie' && $choix2 == 'Ajout')
				{
					echo '	<form method="post" action="../../controleur/categorie/categorie.php">
								<input  id = "position" type="text" name="categorie" size="30"  placeholder="Entrer une nouvelle cat√©gorie"/><br/> 
								<input  id = "position" type="submit" name="action" value="Valider" />
							</form>'; 
				}
				else if ($choix == 'Source' && $choix2 == 'Ajout')
				{
					
					echo
					    '<form method="post" action="../../controleur/source/source.php">
							<input  id = "position" type="text" name="source" size="30"  placeholder="Entrer une nouvelle source"/>
							<SELECT name="categorie" size="1">';
							include ('../../modele/categorie/categorieDeroulant.php');					 										
					echo '  </SELECT>
							<input type="submit" name="action" value="Valider" />
						</form> ';

				}

				else if ($choix == 'Favoris' && $choix2 == 'Ajout')
				{
					echo
						'<form method="post" action="../flux/flux.php">
							<input  id = "position" type="text" name="dyn" size="30"  placeholder="Entrer une adresse"/>
							<input type="submit" name="action" value="Valider" />
			
						</form> ';
				}

				elseif ($choix == 'Source' && $choix2 == 'Supprimer')
				{
				
					echo '<form method="post" action="../../controleur/source/checkSource.php">';
					include ('../../modele/source/afficherSource.php');
					$_SESSION['source'] = $source; // tout cette partie est a mettre dans le controleur
					echo '	<input id = position type=submit name=action value=valider />
							</form>';
				}

				elseif ($choix == 'Categorie' && $choix2 == 'Supprimer')
				{
					
					echo '<form method="post" action="../../controleur/categorie/checkCategorie.php">';
					include ('../../modele/categorie/afficherCategorieCheckBox.php');
					$_SESSION['categorie'] = $categorie;
					echo '	<input id = position  type=submit name=action value=valider />
							</form>';
				}

				else 
				{
					echo '<form method="post" action="../../controleur/flux/checkFavorie.php">';				
					include ('../../modele/favori/afficherFavori.php');	
					$_SESSION['article'] = $favori;
					echo '	<input id = position  type=submit name=action value=valider />
							</form>';

				}

			?>
		</div>
		<footer>
			
		</footer>
	</body>
</html>
