<?php

	/*
	 Page de gestion des badges. 
	 Contenu :
	 	-> import de l'entête 
		-> choix des différentes options
	 	-> connexion à la base de données
		-> affichage des badges sélectionnés par l'option.
	*/

	include 'entete.php';
    	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer
?>
	<h2>Liste des badges dans la base de données :</h2><br/>

	<div id="actions">
		<form action="gestionBadges.php" method="post">
			<input type="submit" name="demande" value="Afficher les badges utilisés"/>
			<input type="submit" name="demande" value="Afficher les badges non utilisés"/>
			<input type="submit" name="demande" value="Afficher tous les badges"/>
			<!--<input type="submit" name="demande" value="Afficher tous les badges"/>-->
		</form>
	</div>

<?php

	switch($_POST['demande'])
	{
		case "Afficher les badges utilisés":
		{
			$reponse = $bdd->query('SELECT BADGES.idBadge, status, idUtilisateur, prenom, nom FROM BADGES,PERSONNES WHERE status="UNLOCK" AND PERSONNES.idBadge=BADGES.idBadge;');
	
			echo '<div id="displayTable">
					<table>
						<tr id="tabTitle">
							<td>Numéro de badge</td><td>Status du badge</td><td>Propriétaire</td>
						</tr>';
			while($data = $reponse->fetch())
			{
				echo '<tr><td>';
				echo $data['idBadge'];
				echo '</td><td>';
				echo $data['status'];
				echo '</td><td>';
				echo $data['prenom'].' '.$data['nom'];
				echo '</td><td>';
				echo '<form action="infosBadge.php" method="post">
						<input type="hidden" name="idBadge" value="'. $data['idBadge'] .'"/>
						<input type="hidden" name="status" value="'. $data['status'] .'"/>
						<input type="hidden" name="userName" value="'. $data['prenom'] . ' ' . $data0['nom'].'"/>
						<input type="submit" value="Infos Badge"/>
					</form>';
				echo '</td><td>';
				echo '<form action="profile.php" method="post">
						<input type="hidden" name="idBadge" value="'. $data['idBadge'] .'"/>
						<input type="hidden" name="idUtilisateur" value="'. $data['idUtilisateur'] .'"/>
						<input type="hidden" name="userName" value="'. $data['prenom'] . ' ' . $datad['nom'].'"/>
						<input type="submit" value="Profil propriétaire"/>
					</form>';
				echo '</td></tr>';
			}
			break;
		}
		case "Afficher les badges non utilisés":
		{
			$reponse0 = $bdd->query('SELECT BADGES.idBadge, status, idUtilisateur, prenom, nom FROM BADGES, PERSONNES WHERE status="LOCK" AND BADGES.idBadge=PERSONNES.idBadge ORDER BY idBadge DESC;');
			
			$reponse1 = $bdd->query('SELECT * FROM BADGES WHERE status="LOCK" ORDER BY idBadge DESC;');
			
			echo '<div id="displayTable">
					<table>
						<tr id="tabTitle">
							<td>Numéro de badge</td><td>Status du badge</td><td>Propriétaire</td>
						</tr>';
			while($data1 = $reponse1->fetch())
			{
				$data0 = $reponse0->fetch();
				echo '<tr><td>';
				echo $data1['idBadge'];
				echo '</td><td>';
				echo $data1['status'];
				echo '</td><td>';
				echo $data0['prenom'].' '.$data0['nom'];
				echo '</td><td>';
				echo '<form action="infosBadge.php" method="post">
						<input type="hidden" name="idBadge" value="'. $data1['idBadge'] .'"/>
						<input type="hidden" name="status" value="'. $data1['status'] .'"/>
						<input type="hidden" name="userName" value="'. $data0['prenom'] . ' ' . $data0['nom'].'"/>
						<input type="submit" value="Infos Badge"/>
					</form>';
				echo '</td><td>';
				if(!($data0['prenom']==NULL))
				{
					echo '<form action="profile.php" method="post">
						<input type="hidden" name="idBadge" value="'. $data1['idBadge'] .'"/>
						<input type="hidden" name="idUtilisateur" value="'. $data0['idUtilisateur'] .'"/>
						<input type="hidden" name="userName" value="'. $data0['prenom'] . ' ' . $data0['nom'].'"/>
						<input type="submit" name="origine" value="Profil propriétaire"/>
					</form>';
				}
				echo '</td></tr>';
			}
			echo '</table>';
			break;	
		}
		case "Afficher tous les badges":
		{
			$reponse0 = $bdd->query('SELECT BADGES.idBadge, status, idUtilisateur, prenom, nom FROM BADGES, PERSONNES WHERE BADGES.idBadge=PERSONNES.idBadge ORDER BY idBadge DESC;');
			
			$reponse1 = $bdd->query('SELECT * FROM BADGES ORDER BY idBadge DESC;');
			
			echo '<div id="displayTable">
					<table>
						<tr id="tabTitle">
							<td>Numéro de badge</td><td>Status du badge</td><td>Propriétaire</td>
						</tr>';
			while($data1 = $reponse1->fetch())
			{
				$data0 = $reponse0->fetch();
				echo '<tr><td>';
				echo $data1['idBadge'];
				echo '</td><td>';
				echo $data1['status'];
				echo '</td><td>';
				echo $data0['prenom'].' '.$data0['nom'];
				echo '</td><td>';
				echo '<form action="infosBadge.php" method="post">
						<input type="hidden" name="idBadge" value="'. $data1['idBadge'] .'"/>
						<input type="hidden" name="status" value="'. $data1['status'] .'"/>
						<input type="hidden" name="userName" value="'. $data0['prenom'] . ' ' . $data0['nom'].'"/>
						<input type="submit" value="Infos Badge" />
					</form>';
				echo '</td><td>';
				if(!($data0['prenom']==NULL))
				{
					echo '<form action="profile.php" method="post">
						<input type="hidden" name="idBadge" value="'. $data1['idBadge'] .'"/>
						<input type="hidden" name="idUtilisateur" value="'. $data0['idUtilisateur'] .'"/>
						<input type="hidden" name="userName" value="'. $data0['prenom'] . ' ' . $data0['nom'].'"/>
						<input type="submit" name="origine" value="Profil propriétaire"/>
					</form>';
				}
				echo '</td></tr>';
			}
			echo '</table>';
			break;
		}	
	}
?>

<?php
	include 'footer.php';
?>