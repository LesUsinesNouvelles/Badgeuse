<?php

	/*
	 Page d'ajout de badgeuses. 
	 Contenu :
	 	-> import de l'entête 
		-> formulaire d'ajout de badgeuses
	 	-> connexion à la base de données
		-> insertion de la badgeuse dans la base de données
	*/

	include 'entete.php';
    	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer
?>

<div id="contenu">
	<h2>Ajout d'une badgeuse </h2>
	<div id="formulaire">
		<form action="ajoutBadgeuse.php" method="post">
			Identification de la badgeuse : <input type="text" name="idBadgeuse"/> 
			<br/>
			<br/>
			<input type="submit" value="Valider l'ajout"/>
		</form>
	</div>
<?php
	if($_POST['idBadgeuse']==NULL)
	{
		echo '<p id="erreur">Vous devez saisir un identifiant pour la badgeuse</p>';
	}
	else
	{
		{
			$check = $bdd->query('SELECT * FROM BADGEUSES WHERE idBadgeuse="'.$_POST['idBadgeuse'].'";');
			$data = $check->fetch();
			if($data == NULL)
			{
				$bdd->query('INSERT INTO BADGEUSES (idBadgeuse) VALUES ("'.$_POST['idBadgeuse'].'");');
				echo '<br/>Badgeuse ajouté avec succès !';
			}
			else
			{
				echo '<p id="erreur"> L\'identifiant de la badgeuse '.$_POST['idBadgeuse'].' existe déjà.</p>';
			}
		}
	}
?>
</div>