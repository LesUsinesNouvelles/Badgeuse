<?php

	/*
	 Page d'inscription d'un membre dans la base de données. 
	 Contenu :
	 	-> import de l'entête 
		-> formulaire d'inscription d'un membre.
	 	-> connexion à la base de données
		-> insertion du membre dans la base de données
	*/

	include 'entete.php';

	// On se connecte à MySQL
    include 'connect_db.php';
	// Si tout va bien, on peut continuer

?>

<div id="contenu">
	<h2>Inscription d'un nouveau membre</h2>
	<div id="avertissement">
		<p>Si vous laissez le champ du badge vide, vous devrez par la suite affecter un badge à l'utilisateur via son profil.</p>
		<p><i>Les champs marqués d'une (*) sont obligatoires</i></p>
	</div>
	<div id="formulaire">		
		<form action="inscription.php" method="post">
			<table>
				<tr>
					<td> Prenom (*) : </td>
					<td> <input type="text" name="prenom" value="<?php echo $_POST['prenom']; ?>"/> </td>
				</tr>
				<tr>
					<td> Nom (*) : </td>
					<td> <input type="text" name="nom" value="<?php echo $_POST['nom']; ?>"/> </td>
				</tr>
				<tr>
					<td> Numéro de badge : </td>
					<td> <input type="text" name="idBadge" value="<?php echo $_POST['idBadge']; ?>"/> </td>
				</tr>
				<tr>
					<td><input type="submit" value="Valider l'inscription"/></td>
				</tr>
			</table>
		</form>
	</div>
	<?php
		if(empty($_POST['prenom']) OR empty($_POST['nom']))
		{
			echo '<p id="erreur"><b>Les prénom et nom sont obligatoires pour procéder à l\'incription.</b></p>';
		}
		else
		{
			{
				// Si la connexion réussi
				// on vérifie si l'utilisateur existe déja dans la base de données
				$checkUser = $bdd->query('SELECT * FROM PERSONNES WHERE prenom="'. $_POST['prenom'] . '"AND nom="' . $_POST['nom'].'";');
				$data = $checkUser->fetch();
				
				if($data == NULL)
				{
					if(empty($_POST['idBadge']))
					{
						//si le numéro de badge est vide inscription de la personne avec une valeur de NULL pour l'attribut badge
						$inscription = $bdd->query('INSERT INTO PERSONNES (prenom, nom) VALUES ("'. $_POST['prenom'].'","'.$_POST['nom'].'")');
						echo 'Inscription sans numéro de bagde réussie';						
					}
					else
					{
						$checkBadge = $bdd->query('SELECT * FROM BADGES WHERE idBadge="'. $_POST['idBadge'].'";');
						$data = $checkBadge->fetch();
						if($data == NULL)
						{
							echo '<p id="erreur"><b>Vous utilisé un badge non reconnu par la base de données.</b></p>';
						}
						else
						{
							//inscription en base de données
							$inscription = $bdd->query('INSERT INTO PERSONNES (prenom, nom, idbadge) VALUES ("'. $_POST['prenom'].'","'.$_POST['nom'].'","'.$_POST['idBadge'].'")');
							echo 'Inscription avec numéro de bagde réussie';
						}
					}
				}
				else
				{
					echo '<p id="erreur"><b>La personne existe déjà dans la base de données</b></p>';
				}
			}
		}
	/*
	Requêtes en base de données :
		
		$stmt=$bdd->query('SELECT * FROM news ORDER BY id DESC LIMIT ' . $start . ',' . $nb);
	
		-> Avec variables :
			$req = $bdd->preppare("requête");
			$req->execute(array(données de la requête));
			
		-> Sans variables
		$reponse = $bdd->query("requête");
	*/
	
	?>
	
</div>