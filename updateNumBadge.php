<?php

	/*
	 Page de mise à jour du badge associé à un utilisateur. 
	 Contenu :
	 	-> import de l'entête 
		-> formulaire de saisie du nouveau badge
	 	-> connexion à la base de données
		-> mise à jour en base de données 
	*/

	include 'entete.php';
    
	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer

	{
		//On vérifie d'abord que le badge existe et est disponible
		$check = $bdd->query('SELECT * FROM BADGES WHERE idBadge="'.$_POST['newIdBadge'].'";');
		$data = $check->fetch();
		if($data == NULL)
		{
			echo '<p id="erreur">Le badge choisi n\'est pas enregistré dans la base de données</p>';
		}
		else
		{
			$check = $bdd->query('SELECT * FROM PERSONNES WHERE idBadge="'.$_POST['newIdBadge'].'";');
			$data = $check->fetch();
			if($data == NULL)
			{
				$reponse = $bdd->query('UPDATE PERSONNES SET idBadge="'.$_POST['newIdBadge'].'" WHERE idUtilisateur ='.$_POST['idUtilisateur'].';');
				echo 	'<h1>Numéro de badge changé avec succès !</h1>';
			}
			else
			{
				echo '<p id="erreur">Le badge choisi est déjà affecté à ';echo $data['prenom'].' '. $data['nom']. '</p>';
			}
		}
		echo '<form action="affichage_inscription.php" method="post">
				<input type="submit" value="Retour à la liste des inscrits" />
			</form>';
	}
	include'footer.php';
?>