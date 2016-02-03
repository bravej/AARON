<?php
	
	//require'../connexion/connexionBd.php';
	
	class Article
	{ 
		private $article;

		public function __construct ($article)
		{
			$this->article = $article;
		}

		public function ajouterArticle ()
		{ 
					
			try {
				$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
			} catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}

			foreach($_POST['choix'] as $val)
			{
				$stmt = $dbh->prepare("INSERT INTO Favori (ID, Article) VALUES (:id ,:article)");
				
				$stmt->bindParam(':id', $_SESSION['ID']);
				$stmt->bindParam(':article', $this->article[$val]);

				$stmt->execute();
			}
		}

		public function supprimerArticle()
		{
			try {
				$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
			} catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}

			$stmt = $dbh->prepare("DELETE FROM Favori WHERE ID = :id AND Article = :article ");
			
			$stmt->bindParam(':id', $_SESSION['ID']);
			$stmt->bindParam(':article', $this->article);

			$stmt->execute();

		} 
	};
?>