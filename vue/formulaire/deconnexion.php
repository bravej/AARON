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
            <meta name="description" content="AARON est une application web qui vous permet d'enregistrer et de consulter vos articles pr�f�r�s provenant de diff�rents sites." />
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
					echo 'Vous avez été deconnecté(e)<br/><br/>
						  Retour à l\'<a href="../../index.php">accueil</a><br /><br/>
						  <img src="../../Images/bye.gif"><br/>
						  à la prochaine !';
				?>
			</div>
			<footer>
				
			</footer>
		</body>
	</html>

<?php //Fin de la session
	session_destroy();
?>