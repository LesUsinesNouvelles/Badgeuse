<?php

	$bdd = new PDO ('mysql:host=localhost:8889;dbname=Badgeuse_Francois;charset=utf8','root','root',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	if (!$bdd)
	{	
		echo '<p id="erreur">La connexion à la base de données à échouée</p>';
	}

?>
