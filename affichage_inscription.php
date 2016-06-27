<?php

	/*
	 Page d'affichage des membres inscrits du site de gestion. 
	 Contenu :
	 	-> import de l'entête 
	 	-> connexion à la base de données
		-> affichage des données dans un tableau
	*/

	include 'entete.php';
	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer

	// On récupère tout le contenu de la table jeux_video
	$reponse = $bdd->query('SELECT * FROM PERSONNES ORDER BY dateInscription DESC');

	echo '<h2>Liste des inscrits dans la base de données :</h2><br/>
		<div id="displayTable">
			<table class="container">
				<tr>
					<th><h1>Prénom</h1></th><th><h1>Nom</h1></th><th><h1>Numéro de badge</h1></th><th><h1>Date d\'inscription</h1></th><th><h1>Niveau de compétences</h1></th>
				</tr>';
		while($donnees = $reponse->fetch())
		{
			echo '<tr><td>';
			echo $donnees['prenom'];
			echo '</td><td>';
			echo $donnees['nom'];
			echo '</td><td>';
			echo $donnees['idBadge'];
			echo '</td><td>';
			echo $donnees['dateInscription'];
			//echo '</td><td>';
			//echo $donnees['niveauAcces'];
			echo '</td><td>';
			echo '<form action="profile.php" method="post">';
				echo '<input type=hidden name="userName" value ="';
				echo $donnees['prenom'];
				echo ' ';
				echo $donnees['nom'];
				echo '" />';
				echo '<input type ="hidden" name="idUtilisateur" value="';echo $donnees['idUtilisateur'];echo '" />';
				echo '<input type="hidden" name="idBadge" value="'; echo $donnees['idBadge']; echo '"/>';
				echo '<input type="submit" name="origine" value="Voir Profil"/>';
			
			echo '</form>';
			echo '</td></tr>';
		}
		echo '</table>';
	echo '</div>';
	include 'footer.php';
?>
