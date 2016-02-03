<?php
	session_start();
?>

<!DOCTYPE html>
	<html>
		<head>
            <title>AARON</title>
            <link rel="stylesheet" type="text/css" href="/style/style.css">
            <link rel="icon" type="image/png" href="/Images/favicon.png" />
            <meta charset="UTF-8">
            <meta name="description" content="AARON est une application web qui vous permet d'enregistrer et de consulter vos articles préférés provenant de différents sites." />
            <meta name="keywords" content="Flux, RSS, Twitter, AARON," />
        </head>

		<body>
			
			<header>
				<div id="banniere"> </div>
			</header>
			
			<nav>			
			</nav>

			<div id = "corp">		
				<?php
					echo 'Vous avez Ã©tÃ© deconnectÃ©(e)<br/><br/>
						  Retour Ã  l\'<a href="../../index.php">accueil</a><br /><br/>
						  <img src="../../Images/bye.gif"><br/>
						  Ã  la prochaine !';
				?>
			</div>
			<footer>
				
			</footer>
		</body>
	</html>

<?php //Fin de la session
	session_destroy();
?>