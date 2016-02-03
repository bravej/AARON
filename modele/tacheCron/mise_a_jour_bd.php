<?php
	// script utilisé seulement par la tâche cron pour actualiser la bd 
	try {
		$dbh = new PDO('mysql:host=mysql-projetphp2015.alwaysdata.net;dbname=projetphp2015_db',"116439","caca", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (PDOException $e) {
		print "Erreur !: " . $e->getMessage() . "<br/>";
		die();
	}
	
	$stmt0 = $dbh->prepare("DELETE FROM article");
	$stmt0->execute();

	$users = array();

	$stm = $dbh->prepare ("SELECT ID FROM comptes");
	$stm->execute();

	while ($row = $stm->fetch(PDO::FETCH_OBJ))
	{
		array_push($users, $row->ID);
	}
	$stm->closeCursor();
	//pour tout les utilisateurs
	foreach ($users as $user)
	{
		$stmt = $dbh->prepare("SELECT source, NomCategorie FROM sources WHERE ID = :id");
		
		$stmt->bindParam(':id', $user);

		$stmt->execute();
		// parcour des sources 
		while ($row = $stmt->fetch(PDO::FETCH_OBJ))
		{

			$rss = simplexml_load_file($row->source);
			$cpt = 0;

			// parcour des flux

			if ($rss)
			{
				foreach ($rss->channel->item as $item) 
				{ 

					$link = $item->link;
					$title = $item->title;
					$description = $item->description;
					$date =  DateTime::createFromFormat('l, j M Y H:i:s +',  $item->pubDate); // on specifie le format de la date
					$date = date_format($date, 'Y-m-d H:i:s'); 
			
					$stmt2 = $dbh->prepare("INSERT INTO article (ID, Title, Description, Lien, DatePub, NomCategorie, source) VALUES (:id ,:title, :description, :lien, :datePub, :nom, :source)");
			
					$stmt2->bindParam(':id', $user);
					$stmt2->bindParam(':title', $title);
					$stmt2->bindParam(':description', $description);
					$stmt2->bindParam(':lien', $link);
					$stmt2->bindParam(':datePub', $date);
					$stmt2->bindParam(':nom', $row->NomCategorie);
					$stmt2->bindParam(':source', $row->source);
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
	}
?>