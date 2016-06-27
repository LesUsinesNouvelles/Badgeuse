<?php

	/*
	 Page d'affichage des badgeuses enregistrées du site de gestion. 
	 Contenu :
	 	-> import de l'entête 
	 	-> connexion à la base de données
		-> affichage des badgeuses contenues dans la base de données dans un tableau
	*/

	include 'entete.php';
	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer

	// On récupère tout le contenu de la table jeux_video
	$reponse = $bdd->query('SELECT * FROM BADGEUSES');
	echo '<h2>Liste des Badgeuses dans la base de données :</h2><br/>';

	echo '<div id="displayTable">';
		echo '<table>
				<tr id="tabTitle">
					<td>Identifiant de la badgeuse</td>
				</tr>';
		while($donnees = $reponse->fetch())
		{
			echo '<tr><td>';
			echo $donnees['idBadgeuse'];
			echo '</td><td><form action="affichageBadgeuse.php" method="post">
			<input type="hidden" name="idBadgeuse" value="'.$donnees['idBadgeuse'].'"/><input type="submit" name="action" value="Supprimer"/></form></td></tr>';
		}
		echo '</table>';
	echo '</div>';

		if($_POST['action']=='Supprimer')
		{
			echo '<h2>Êtes vous sûr de vouloir supprimer la badgeuse ?</h2><br/>
			<form action="affichageBadgeuse.php" method="post">
				<input type="hidden" name="idBadgeuse" value="'.$_POST['idBadgeuse'].'"/>
				<input type="submit" name="action" value="Oui"/>
				<input type="submit" name="actionConfirm" value="Non"/>
			</form>';
		}

		if($_POST['action']=='Oui')
		{
			$bdd = new PDO ('mysql:host=localhost;dbname=FabLab;charset=utf8','root','mysql',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			$bdd->query('DELETE FROM BADGEUSES WHERE idBadgeuse="'.$_POST['idBadgeuse'].'"');
			echo '<h2>Suppression effectuée !</h2><br/>
			<form action="affichageBadgeuse.php" method="post">
				<input type="submit" value="Mettre à jour la liste des badgeuses"/>
			</form>';
		}
		elseif($_POST['actionConfirm']=='Non')
		{
			echo '<h2>Voulez vous annuler la supression ?</h2><br/>
			<form action="affichageBadgeuse.php" method="post">
				<input type="hidden" name="idBadgeuse" value="'.$_POST['idBadgeuse'].'"/>
				<input type="submit" name="actionConfirm" value="Oui"/>
				<input type="submit" value="Retour"/>
			</form>';
		}
		elseif($_POST['actionConfirm']=='Oui')
		{
			echo '<h2>Supression annulée</h2><br/>';
		}
		
	include 'footer.php';
?>
