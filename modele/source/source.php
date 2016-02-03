<?php 
// les sources correspondent aux liens vers les pages de flux rss 
	require '../../modele/connexion/connexionBd.php';
	class Source
	{
		private $source;
		private $nomCategorie;
		private $dbh;
		public function __construct ($source = 0, $nomCategorie = 0)
		{
			$this->source = $source;
			$this->nomCategorie = $nomCategorie; 
			$this->dbh = connectionBd();
		}  

		public function ajoutSource ()
		{
			libxml_use_internal_errors (true); // on eteint le warning que le flux n'existe pas 
			// on test si le flux existe  
			$rss = simplexml_load_file($this->source);
			if ($rss)
			{
				$stmt2 = $this->dbh->prepare("INSERT INTO sources (NomCategorie, ID,  source) VALUES (:nom , :id,  :source)");
				$stmt2->bindParam(':id', $_SESSION['ID']);
				$stmt2->bindParam(':nom', $this->nomCategorie);
				$stmt2->bindParam(':source', $this->source);
				// si la source n'est pas deja dans la bd on la rentre
				if ($stmt2->execute())
				{
					// on va chercher les derniers articles correspondant a notre source
					$this->mise_a_jour_article();
					$msg = "Source ajouté";
					include ('../../vue/formulaire/Info.php');
				}
				else 
				{
					$msg = "La source n'a pas etait ajouté car elle est déjà présente";
					include ('../../vue/formulaire/Info.php');	
				}

			}
			else 
			{
				$msg = "Votre source n'est pas un flux rss";
				include ('../../vue/formulaire/Info.php');

			}
		}

		public function supprimerSource ()
		{
			$stmt = $this->dbh->prepare("DELETE FROM sources WHERE ID = :id AND source = :source ");
			$stmt->bindParam(':id', $_SESSION['ID']);
			$stmt->bindParam(':source', $this->source);
			$stmt->execute();
			$this->suplesarticle();

		}
		// si oon supprime une source on veux également supprimer les articles associés
		private function suplesarticle ()
		{
			$stmt = $this->dbh->prepare("DELETE FROM article WHERE ID = :id AND source = :source ");
			$stmt->bindParam(':id', $_SESSION['ID']);
			$stmt->bindParam(':source', $this->source);
			$stmt->execute();
			
		} 

		private function mise_a_jour_article ()
		{
			$rss = simplexml_load_file($this->source);
			$cpt = 0;
			// parcour des flux

			if ($rss != false)
			{
				foreach ($rss->channel->item as $item) 
				{ 
					$link = $item->link;
					$title = $item->title;
					$description = $item->description;
					$date =  DateTime::createFromFormat('l, j M Y H:i:s +',  $item->pubDate); // on specifie le format de la date
					$date = date_format($date, 'Y-m-d H:i:s'); 

					$stmt2 = $this->dbh->prepare("INSERT INTO article (ID, Title, Description, Lien, DatePub, NomCategorie, source) VALUES (:id ,:title, :description, :lien, :datePub, :nom, :source)");
			
					$stmt2->bindParam(':id', $_SESSION['ID']);
					$stmt2->bindParam(':title', $title);
					$stmt2->bindParam(':description', $description);
					$stmt2->bindParam(':lien', $link);
					$stmt2->bindParam(':datePub', $date);
					$stmt2->bindParam(':nom', $this->nomCategorie);
					$stmt2->bindParam(':source', $this->source);
					$stmt2->execute();
					// on prend les 5 1er articles
					++$cpt;	
					if ($cpt == 5)
					{	
						break;
					}
				}
			} 
		}
	};

?>