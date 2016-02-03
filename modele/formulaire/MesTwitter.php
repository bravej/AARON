<?php
	function ListeTwitter ($id){
		try {
			$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca");
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage() . "<br/>";
			die();
		}
		
		$stmt = $dbh->prepare("SELECT twitter FROM Twitter WHERE ID like :ID ");
		$stmt->bindParam(':ID', $id);
		$stmt->execute();
		
		while ($row = $stmt->fetch(PDO::FETCH_OBJ))
		{
			echo '<a href="../../controleur/Twitter/twitter.php?twitter='. $row->twitter .'">@' . $row->twitter . '<br/>';
		}
	}
	
?>