<?php
class Favori {
	function pagination($pageActuelle){
		try{
			$db = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db;charset=utf8', '116439', 'caca', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$messagesParPage=5; //Nous allons afficher 5 messages par page.

			$retour_total = $db->query('SELECT COUNT(*) AS total FROM Favori WHERE ID = ' . $_SESSION['ID']); //on compte le nb de tuples
			while($row = $retour_total->fetch(PDO::FETCH_ASSOC)) {
				$donnees_total = $row['total'];
			}
			$retour_total->closeCursor();

			//Nous allons maintenant compter le nombre de pages.
			$nombreDePages=ceil($donnees_total/$messagesParPage);

			if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
			{
			  $pageActuelle=$nombreDePages;
			}
			else if($pageActuelle<=0) // Si la valeur de $pageActuelle (le numéro de la page) est inferieure que $nombreDePages...
			{
				$pageActuelle=1;
			}

			$premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire
			if ($premiereEntree < 0){
				$premiereEntree = 0;
			}
			
			$stmt = $db->query('SELECT Article FROM Favori WHERE ID = ' . $_SESSION['ID'] . ' LIMIT ' . $premiereEntree . ', ' . $messagesParPage);
			while ($row = $stmt->fetch(PDO::FETCH_OBJ))
			{
				$article = $row->Article . '</br>';		

				echo $article;		
			} 
			
			return $nombreDePages; //on return le nb de pages max de la pagination 
								
		}
		catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage() . "<br/>";
			die();
		}
	}
}
?>