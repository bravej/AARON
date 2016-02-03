<?php
	class Categorie 
	{
		private $nomCategorie;
		private $dbh;

		public function __construct ( $nomCategorie)
		{
			$this->nomCategorie = $nomCategorie;
			$this->dbh = connectionBd();
		}

		public function afficherCategorie ()
		{
			
			$stmt = $this->dbh->prepare("SELECT Nom FROM categorie WHERE ID = :id");
			
			$stmt->bindParam(':id', $_SESSION['ID']);

			$stmt->execute();
			$categorie = array ();
			while ($row = $stmt->fetch(PDO::FETCH_OBJ))
			{
				array_push($categorie, $row->Nom);

			} // revoir code ajout source pour adapter

			return $categorie;
		}

		public function ajoutCategorie ()
		{
			$stmt = $this->dbh->prepare("INSERT INTO categorie (Nom, ID) VALUES (:nom, :id)");

			$stmt->bindParam(':nom', $this->nomCategorie);
			$stmt->bindParam(':id', $_SESSION['ID']);
			$stmt->execute();
		}

		public function supprimerCategorie ()
		{
			$this->supSourceEtArticle();
			$stmt = $this->dbh->prepare("DELETE FROM categorie WHERE Nom = :nom  AND ID = :id");
			
			$stmt->bindParam(':nom', $this->nomCategorie);
			$stmt->bindParam(':id', $_SESSION['ID']);
			$stmt->execute();


		}

		public function supSourceEtArticle ()
		{

			$stmt2 = $this->dbh->prepare("DELETE FROM article WHERE ID = :id AND NomCategorie = :categorie ");
			$stmt2->bindParam(':id', $_SESSION['ID']);
			$stmt2->bindParam(':categorie', $this->nomCategorie);
			$stmt2->execute();

			$stmt = $this->dbh->prepare("DELETE FROM source WHERE ID = :id AND NomCategorie = :categorie ");
			$stmt->bindParam(':id', $_SESSION['ID']);
			$stmt->bindParam(':categorie', $this->nomCategorie);
			$stmt->execute();

			
		}// probleme de redondance mais également probleme de genericité dans la classe source a revoir

		public function afficher ()
		{

			$stmt = $dbh->prepare("SELECT Nom FROM categorie WHERE ID = :id");

			$stmt->bindParam(':id', $_SESSION['ID']);

			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_OBJ))
			{
				echo '<OPTION name =' . $row->Nom .'>'.$row->Nom.'</OPTION>';
			} 		
		}
	}

?> 