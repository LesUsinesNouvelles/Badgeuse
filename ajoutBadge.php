<?php

	/*
	 Page d'ajout de badges. 
	 Contenu :
	 	-> import de l'entête 
		-> formulaire d'ajout de badge
	 	-> connexion à la base de données
		-> insertion du badge dans la base de données
	*/

	include 'entete.php';
	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer
?>

<div id="contenu">
	<h2>Ajout d'un badge</h2>
	<div id="formulaire">		
		<form action="ajoutBadge.php" method="post">
			Numéro de badge : <input type="text" name="idBadge" value="<?php echo $_POST['idBadge']; ?>"/>
			<br/>
			<br/>
			<input type="submit" value="Valider l'ajout"/>
		</form>
	</div>
<?php
	if($_POST['idBadge']==NULL)
	{
		echo '<p id="erreur">Vous devez saisir un numéro de badge</p>';
	}
	
    else
		{
			$check = $bdd->query('SELECT * FROM BADGES WHERE idBadge="'.$_POST['idBadge'].'";');
			$data = $check->fetch();
			if($data == NULL)
			{
				$bdd->query('INSERT INTO BADGES (idBadge) VALUES ("'.$_POST['idBadge'].'");');
				echo 'Badge ajouté avec succès !';
			}
			else
			{
				echo '<p id="erreur"> Le numéro de badge '.$_POST['idBadge'].' existe déjà.</p>';
			}
		}
	
?>
</div>