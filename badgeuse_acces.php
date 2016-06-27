<meta charset='utf-8'><?php
	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer
	if(empty($_GET['idBadge']) or empty($_GET['idBadgeuse']))
	{
		echo 'Manque de donnees <br/>';
	}
	else
	{

			echo 'Validation acces<br/>';
			$dateAcces = date("Y-m-d H:i:s");
			$bdd->query('INSERT INTO ACCES(idBadge,idBadgeuse) VALUES("'.$_GET['idBadge'].'","'. $_GET['idBadgeuse'].'");');
			echo $dateAcces;
			echo '<br/>';
			echo 'Acces enregistre<br/>';
		}
	}
//exemple d'url avec envoi de données : GestionBadgeuses/badgeuse_acces.php?idBadge=6664269&idBadgeuse=2
?>