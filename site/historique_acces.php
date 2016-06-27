<?php

	/*
	 Page de consultation des accès enregistrés. 
	 Contenu :
	 	-> import de l'entête 
		-> connexion à la base de données
		-> affichage des accès enregistrés
	*/

	include 'entete.php';
	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer
	

	echo '<h2>Liste des accès enregistrés dans la base de données :</h2><br/>
		<div id="actions">
			<form action="historique_acces.php" method="post">
				<input type="submit" name="demande" value="Trier par machine"/>
				<input type="submit" name="demande" value="Trier par badges"/>
			</form>
		</div>
		<div id="interfaceAction">
			<div id="displayTable">
				<table class="container">
					<tr>
						<th><h1>n°</h1></th> <th><h1>Date</h1></th> <th><h1>Badge utilisé</h1></th> <th><h1>Badgeuse accédée</h1></th>
					</tr>';
		switch($_POST['demande'])
		{
			case 'Trier par machine':
			{
				$reponse = $bdd->query('SELECT * FROM ACCES ORDER BY idBadgeuse DESC');
				break;
			}
			case 'Trier par badges':
			{
				$reponse = $bdd->query('SELECT * FROM ACCES ORDER BY idBadge DESC');
				break;
			}
			default:
			{
				$reponse = $bdd->query('SELECT * FROM ACCES ORDER BY dateAcces DESC');
			}
		}
		while($donnees = $reponse->fetch())
			{
				echo '<tr><td >';
				echo $donnees['idAcces'];
				echo '</td><td>';
				echo $donnees['dateAcces'];
				echo '</td><td>';
				echo $donnees['idBadge'];
				echo '</td><td>';
				echo $donnees['idBadgeuse'];
				echo '</td></tr>';
			}
			echo '</table>
			</div>
		</div>';
	include 'footer.php';
?>