<?php
	require_once 'connexionBd.php';
				
	$dbh = connectionBd ();
				
	$stmt = $dbh->prepare("SELECT actif FROM comptes WHERE login like :login ");
	if($stmt->execute(array(':login' => $_SESSION['login'])) && $row = $stmt->fetch())
	{
		$actif = $row['actif']; // $actif contiendra alors 0, 1 ou 2
	}
				
	if($actif == '3') // Si le compte est déjà actif on prévient
	{
	echo '	<a href="../../vue/iAdmin/InterfaceAdmin.php">
				<li>
					<h3>ADMIN</h3>
				</li>
			</a>';
	}
?>	