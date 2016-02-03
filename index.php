<?php 
	session_start();
	require 'modele/connexion/connexionBd.php';
	require 'modele/categorie/categorie.php';
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
							  <a href="/vue/formulaire/formulaire.php">Espace membre</a><br />
							  <a href="/vue/formulaire/deconnexion.php"> Deconnexion </a>';
						echo'</div>';
					}else{
						echo '<div id = "connexion">
									<form method="post" action="controleur/formulaire/traitement.php">
											<label>email : </label>
												<input type="text" name="email" size="30" /><br />
											<label>Mot de passe : </label>
												<input type="password" name="pass" size="30" /><br />
											<input type="submit" name="action" value="CONNEXION" />
											<div style="margin-left:10px;">
												Pas encore membre ? <a href="vue/formulaire/formulaire.php">Inscrivez-vous ici !</a><br />
												Mot de passe oublié ? <a href="modele/formulaire/Mot_de_passe_oublie.php">On vous aide ici !</a><br />
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
				include ('modele/connexion/AdminAccess.php');
			?>
		</ul>			
		</nav>

		<div id = "corp">
			<?php
				
				if (isset($_SESSION ['login']) != ""){
					$categorie = array();
					$cat = new Categorie('');
					$categorie = $cat->afficherCategorie();
                                        $i = 0;
                                        echo '<div id=position>'; 
					foreach ($categorie as $cat)
					{
						echo  '<a href=vue/article/article.php?categorie='.$cat .'>' . $cat . '</a>' ;
                                                if ($i == 3){
                                                    echo ' <br/>';
                                                }else{
                                                    echo ' | ';
                                                }
					}
					echo '<a href=vue/favori/favori.php> Favoris </a></div>'; 
				}else{
					echo '	<p class="titre"><a>AARON ? Késako ?</a></p>
							<fieldset id="coordonnees">
								Artificial Applications Rebooting On Nokia, dit AARON, est une application web qui vous permet d’enregistrer et de consulter vos articles préférés provenant de différents sites.<br/>
								Ainsi vous pouvez constituer facilement et librement votre propre flux d’informations personnel sur internet.<br/>
								Cela nécessite tout de même un compte utilisateur, nous vous recommandons donc de créer un compte sur notre site pour pouvoir profiter de nos services.<br/>
								Une partie Blog vous permet d’échanger avec les autres utilisateurs ou de contacter plus facilement les administrateurs d’AARON.<br/>
								Nous vous souhaitons de passer un agréable moment.<br/><br/>
								AARON est une application web à but pédagogique.<br/>
							</fieldset>';
				}
			?>
		</div>
		<footer>
			
		</footer>
	</body>
</html>
