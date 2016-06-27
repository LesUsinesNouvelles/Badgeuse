<?php

	/*
	 Page d'affichage des infos d'une personne. 
	 Contenu :
	 	-> import de l'entête 
		-> informations de la personne
	 	-> option d'affichage des statistiques d'utilisation des matériel
		-> option de changement de badge
	*/

	include 'entete.php';

	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer

/*==================================================================*/
// Affichage du titre de la page web
/*==================================================================*/
	echo '<h1> Profil personnel de ';
		echo $_POST['userName'];
	echo '</h1>';

/*==================================================================*/
// Collecte de données dans la base
/*==================================================================*/
	// On cherche si le numéro de badge est dans le formulaire
	if(isset($_POST['idBadge']))
	{	//si oui on l'affecte à la variable $idBadge
		$idBadge = $_POST['idBadge'];
	}
	else
	{	//si non on va le chercher en base de données

		$reponse = $bdd->query('SELECT idBadge FROM PERSONNES WHERE idUtilisateur="'.$_POST['idUtilisateur'].'";');
		//On récupère le tableau contenant les réponses renvoyé par la base de données
		$idBadge = $reponse->fetch();
		//On récupère le premier élément du tableau 
		$idBadge = $idBadge[0];
	}

/*==================================================================*/
// Affichage des données personnelles de l'adhérent
/*==================================================================*/
	echo '<div id="donneesPerso">Numéro d\'adhérent : ';
		echo $_POST['idUtilisateur'];
		echo '<br/>Numéro de badge : ';
		echo $idBadge;
	echo '</div>';

/*==================================================================*/
// Affichage du menu des différentes actions possibles
/*==================================================================*/
	//création de la zone contenant les différentes options et création
	//formulaire pour l'envoi de données utilisateur
	echo '<div id="actions">		
			<form action="profile.php" method="post">
				<input type="hidden" name="userName" value="'; echo $_POST['userName']; echo '"/>';
	echo '<input type="hidden" name="idUtilisateur" value="'; echo $_POST['idUtilisateur']; echo '"/>';
	echo '<input type="hidden" name="idBadge" value="'; echo $idBadge; echo '"/>';
	
	//création des boutons pour les différentes options.
	echo 		'<input type="submit" name="demande" value="Utilisation des machines"/>
				<input type="submit" name="demande" value="Changer badge"/>
				'//<input type="submit" name="demande" value="Voir compétences"/>
			.'</form>
	 	</div>';

/*==================================================================*/
// Traitement de la fonction demandée par l'utilisateur
/*==================================================================*/
	echo '<div id="interfaceAction">';

		switch($_POST['demande'])
		{
			case 'Utilisation des machines':
			{
				echo '<h2>Liste des accès</h2>';
				
				
				$badgeuses = $bdd->query('SELECT * FROM BADGEUSES');
				while($reponse = $badgeuses->fetch())
				{
					$heuresTotal = 0;
					$minutesTotal = 0;
					$secondesTotal = 0;
						
					$nomBadgeuse = $reponse['idBadgeuse'];
					$reponse = $bdd->query('SELECT * FROM ACCES WHERE idBadge="'.$idBadge.'" AND idBadgeuse="'.$reponse['idBadgeuse'].'" ORDER BY dateAcces ASC');
					if(!($reponse == NULL))
					{
						echo '<br/><div id="displayTable">
							<table>
								<tr id="tabTitle">
									<td>Date</td>
									<td>Badgeuse '.$nomBadgeuse.'</td>
								</tr>';
						$duo = false;
						while($use = $reponse->fetch())
						{
							echo '<tr><td>';
							echo $use['dateAcces'];
							echo '</td><td>';

							if($duo)
							{
								//La fonction floor() permet d'obtenir un arrondie de la valeur passée en paramètre.
								$date2 = date_default_timezone_set($use['dateAcces']);	//Convertion d'un string en time
								$duo = false;
								$duree = ($date2 - $date1);				//calcul de la durée en secondes
								$secondes = ($duree % 60);				//calcul du nombre de secondes
								$minutes = floor(($duree / 60) % 60);	//calcul du nombre de minutes
								$heures = floor($duree / 3600 );		//calcul du nombre d'heures
								
								//on vérifie si le temps calculé est positif.
								if(!(($heures<0) or ($minutes<0) or ($secondes<0)))
								{
									
									echo $heures.'h '.$minutes.'m '.$secondes.'s'; //affichage du résultat
									// Calcul de la durée d'une utilisation
									$heuresTotal += $heures;
									$minutesTotal += $minutes;
									$secondesTotal += $secondes;
								}
							}
							else
							{
								$date1 = date_default_timezone_set($use['dateAcces']);
								$duo = true;
							}
							echo '</td></tr>';
						}
					echo 	'</table>';
					// Calcul du temps total avec formatage HH MM SS
					if($secondesTotal > 60)
					{
						$minutesTotal += $secondesTotal / 60;
						$secondesTotal = $secondesTotal % 60;
					}
					if($minutesTotal > 60)
					{
						$heuresTotal += $minutesTotal / 60;
						$minutesTotal = $minutesTotal % 60;
					}
					echo 'Temp d\'utilisation total : '.floor($heuresTotal).' h '.$minutesTotal.' m '.$secondesTotal.' s';
					echo '</div>';
					}
				}
				break;
			}
			case 'Changer badge':
			{
				echo '<h2> Changement de numéro de badge</h2>
					<div>
						Numéro de badge actuel : '; echo $idBadge;
				echo '<br/>
						<form action=updateNumBadge.php method="post">
							Nouveau numéro de badge : <input type="text" name="newIdBadge" />
							<input type="hidden" name="userName" value="'; echo $_POST['userName']; echo '"/>';
				echo 		'<input type="hidden" name="idUtilisateur" value="'; echo $_POST['idUtilisateur']; echo '"/>';
				echo 		'<input type="submit" name="Valider"/>
					</form>';
				break;
			}
			case 'Voir compétences':
			{
				echo 'je veux voir les compétences'; 
				
				break;
			}
		}

	echo 	'</div>
			<br/>
			<form action="affichage_inscription.php" method="post">
				<input type="submit" value="Retour à la liste des inscrits" />
			</form>
			<form action="gestionBadges.php" method="post">
				<input type="submit" value="Retour à la liste des badges" />
			</form>';
	include 'footer.php';
?>