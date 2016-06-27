<?php

	/*
	 Page d'affichage des infos concernant un badge. 
	 Contenu :
	 	-> import de l'entête 
		-> informations du badge
		-> option de Verrouillage/Dévérouillage du badge
	*/

	include 'entete.php';

	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer

	echo '<h1> Infos du badge numéro ';
	echo $_POST['idBadge'];
	echo '</h1>';

	echo 	'Status du badge : '. $_POST['status'] . '<br/>
			Nom du propriétaire : '. $_POST['userName'].'<br/><br/>'; 
	echo '<form action="infosBadge.php" method="post">
			<input type="hidden" name="userName" value="'.$_POST['userName'].'"/>
			<input type="hidden" name="idBadge" value="'.$_POST['idBadge'].'"/>';

	if($_POST['status']=="LOCK")
	{
		if($_POST['userName']==NULL)
		{
			echo '<p id="erreur">Le Badge doit être affecté à quelqu\'un pour pouvoir être dévérouillé.</p>';
		}
		else
		{
			echo 	'<input type="hidden" name="status" value="UNLOCK"/>
					<input type="submit" name="newStatus" value="Déverrouiller Badge"/>';
		}
	}
	else
	{
		echo 	'<input type="hidden" name="status" value="LOCK"/>
				<input type="submit" name="newStatus" value="Verrouiller Badge"/>';
	}
	echo '</form>';
	
	if(!($_POST['newStatus']==NULL))
	{

		{
			$result=$bdd->query('UPDATE BADGES SET status="'.$_POST['status'].'" WHERE idBadge="'.$_POST['idBadge'].'";');
			echo 'Le status du badge à été mis à jour avec succès !';		
		}
	}
?>
<form action="gestionBadges.php" method="post">
	<input type="submit" value="Retour à la liste des badges"/>
</form>

<?php 
	include 'footer.php';
?>