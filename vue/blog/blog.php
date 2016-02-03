<?php
	session_start();
	include '../../modele/blog/Blog.php';
	
	if(!(isset($_SESSION['page']))) // Si la variable $_SESSION['page'] n'existe pas encore...
	{
		$_SESSION['page'] = 1;
	}

	$theBlog = new Blog();
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
	
			<form action="../../controleur/blog/traitement.php" method="post">
				<input placeholder="Rechercher un autre utilisateur" name="Recherche" type="text"/> <input name="Action" value="Rechercher" type="submit"/>
			</form>
					
		<?php
		$getlogin = $_GET['login'];
		if ($getlogin == ''){$getlogin = $_SESSION['login'];}
				
			$_SESSION['pageMax'] = $theBlog->display_posts($_SESSION['page'], $getlogin);
		?>
		
                <?php
                if (isset($_SESSION ['login']) != ""){
                    echo '<div class="blog-post">
                                <h2>Ajouter un post</h2>
                                <form action="../../controleur/blog/traitement.php" method="post">
                                        <input placeholder="Titre" name="Titre" type="text"/><br/>
                                        <textarea placeholder="Corps" id="corpsForm" name="Corps"></textarea><br />

                                        <input name="Action" value="Envoyer" type="submit"/><br/>
                                </form>
                        </div>';
                }
                ?>        
		
		</div>
		<footer>
			<?php
			echo '
			<nav>
				<ul class="pager">
					<form action="../../controleur/blog/traitement.php" method="post">
						<input name="Page" value="' . $_SESSION['page'] . '" type="hidden"/>';
							echo '<input name="Action" value="Previous" type="submit"/>';
							echo '<input value="' . $_SESSION['page'] . '" disabled/>';
							echo '<input name="Action" value="Next" type="submit"/>';	
					echo '</form>
				</ul>
			</nav>';
		?>
		</footer>
	</body>
</html>
