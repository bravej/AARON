<?php
	require_once("../../include/inc.flux.php");
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
			<div id = "connexion">
                            <form method="post" action="../../controleur/formulaire/traitement.php">
				<label>email : </label>
                                    <input type="text" name="email" size="30" /><br />
				<label>Mot de passe : </label>
                                    <input type="password" name="pass" size="30" /><br />
				<input type="submit" name="action" value="CONNEXION" />
				<div style="margin-left:10px;">
                                    Pas encore membre ? <a href="../vue/formulaire/formulaire.php">Inscrivez-vous ici !</a><br />
                                    Mot de passe oublié ? <a href="../../modele/formulaire/Mot_de_passe_oublie.php">On vous aide ici !</a><br />
				</div>
                            </form>
			</div>
			<div id="banniere"> </div>
		</header>
		
		<nav>
			<ul>
			<a href="/index.php">
				<li>
                                    <h3>Accueil</h3>
				</li>
			</a>
                        <a href="../../vue/fluxNonconnecte/nonConnecte.php">
                            <li>
                                <h3>Chercher Flux</h3>
                            </li>
                        </a>			
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
		</ul>			
		</nav>

		<div id = "corp">
			<?php
				$url = RSS_Display($_POST['dyn']);
				foreach ($url as $article) {
					echo $article;

				}

			?>
		</div>
		<footer>
			
		</footer>
	</body>
</html>
