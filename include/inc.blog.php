<?php
	function display_posts($pageActuelle) {
		try {
			$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca');
			$messagesParPage=6; //Nous allons afficher 5 messages par page.
			
			$retour_total = $db->query('SELECT COUNT(*) AS total FROM posts'); //Nous récupérons le contenu de la requête dans $retour_total
			$total = $retour_total->execute(array()); //On range retour sous la forme d'un tableau.
			//$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
			//Nous allons maintenant compter le nombre de pages.
			$nombreDePages=ceil($total/$messagesParPage);
						
			if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
			{
			  $pageActuelle=$nombreDePages;
			}
			else if($pageActuelle<0)
			{
				$pageActuelle=1;
			}
			
			$premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire

			foreach($db->query('SELECT * FROM posts ORDER BY DATE_POST DESC LIMIT '.$premiereEntree.', '.$messagesParPage) as $row) {
				echo '<div class="blog-post">
						<h2 class="blog-post-title">' . $row['TITRE'] . '</h2>
						<p class="blog-post-meta">' . $row['DATE_POST'] . ' par <a href="#"> Moi</a></p>

						<p>' . $row['CORPS'] . '</p>
				</div><!-- /.blog-post -->';
			}
			
			/*echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
			for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
			{
				 //On va faire notre condition
				 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
				 {
					 echo ' [ '.$i.' ] '; 
				 }	
				 else //Sinon...
				 {
					  echo ' <a href="blog.php?page='.$i.'">'.$i.'</a> ';
				 }
			}
			echo '</p>';*/
		}
		catch(PDOException $ex) {
			echo "An Error occured!"; //user friendly message
		}
	}

	function display_index() { //code mis en fonction pour pouvoir afficher x posts par page ; solution pas encore trouvée
		echo '
		<div class="blog-masthead">
			<div class="container">
				<nav class="blog-nav">
				  <a class="blog-nav-item active" href="#">Home</a>
				  <a class="blog-nav-item" href="#">New features</a>
				  <a class="blog-nav-item" href="#">Press</a>
				  <a class="blog-nav-item" href="#">New hires</a>
				  <a class="blog-nav-item" href="#">About</a>
				</nav>
			</div>
		</div>

		<div class="container">

			<div class="blog-header">
				<h1 class="blog-title">The Bootstrap Blog</h1>
				<p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>
			</div>

			<div class="row">

				<div class="col-sm-8 blog-main">';
					display_posts();
		echo '
					<div class="blog-post">
						<h2>Ajouter un post</h2>
						<form action="../../controleur/blog/traitement.php" method="post">
							<input placeholder="Titre" name="Titre" type="text"/><br/>
							<textarea placeholder="Corps" id="corpsForm" name="Corps"></textarea><br />

							<input name="Action" value="Envoyer" type="submit"/><br/>
						</form>
					</div>

					<nav>
						<ul class="pager">
						  <li><a href="#">Previous</a></li>
						  <li><a href="#">Next</a></li>
						</ul>
					</nav>

				</div><!-- /.blog-main -->

				<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
					  <div class="sidebar-module sidebar-module-inset">
						<h4>About</h4>
						<p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
					  </div>
					  <div class="sidebar-module">
						<h4>Archives</h4>
						<ol class="list-unstyled">
						  <li><a href="#">March 2014</a></li>
						  <li><a href="#">February 2014</a></li>
						  <li><a href="#">January 2014</a></li>
						  <li><a href="#">December 2013</a></li>
						  <li><a href="#">November 2013</a></li>
						  <li><a href="#">October 2013</a></li>
						  <li><a href="#">September 2013</a></li>
						  <li><a href="#">August 2013</a></li>
						  <li><a href="#">July 2013</a></li>
						  <li><a href="#">June 2013</a></li>
						  <li><a href="#">May 2013</a></li>
						  <li><a href="#">April 2013</a></li>
						</ol>
					  </div>
					  <div class="sidebar-module">
						<h4>Elsewhere</h4>
						<ol class="list-unstyled">
						  <li><a href="#">GitHub</a></li>
						  <li><a href="#">Twitter</a></li>
						  <li><a href="#">Facebook</a></li>
						</ol>
					  </div>
				</div><!-- /.blog-sidebar -->
			</div><!-- /.row -->
		</div><!-- /.container -->
		';
	}
?>