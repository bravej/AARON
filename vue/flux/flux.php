<?php
	session_start();
	require_once("../../include/inc.flux.php");
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
					echo '<a href="../../index.php">
							<li>
								<h3>Flux RSS</h3>
							</li>
						</a>
						<a href="../../vue/gererCompte/choisirAction.php">
							<li>
								<h3>G√©rer Flux</h3>
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
				<form method="post" action="../../controleur/flux/fluxFavorie.php">
					<?php		
						if (isset ($_POST["dyn"]) == "")
						{

						}
						else
						{
							if (isset( $_POST ))
								$posted= &$_POST ;			
							else
								$posted= &$HTTP_POST_VARS ;	

							if($posted!= false && count($posted) > 0)
							{	
								$url= $posted["dyn"];
								if($url != false)
								{
									$Cpt = 0;
									$urls = RSS_Display($url);
									if ($urls[0] == 'erreur')
									{
										$msg = "Le fichier XML n'existe pas";
										echo '<p class="titre"><a>Information</a></p>		
											  <fieldset id="coordonnees">'				  	
									          .$msg.'
										</fieldset>';		
									// ici j'ai du recopier info.php car je peux tout simplement pas faire un include 
									}
									else
									{

										foreach ($urls as $variable ) {
											$variable =  "<input type='checkbox' name='choix[]' value=\"$Cpt\"/>" . $variable;
											echo $variable;
											++$Cpt;
										}
										$_SESSION["urls"] = $urls;
										echo '<input type="submit" name="action" value="Favori" />
											  <input type=submit name=action value=Blogger />';
									}
								}
							}
						}
					?>
				</form>
			</div>
			<footer>
				
			</footer>
		</body>
	</html>
