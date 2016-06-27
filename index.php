<?php

	/*
	 Page d'accueil du site de gestion. 
	 Contenu :
	 	-> import de l'entête
		-> accueil
	*/

	include 'entete.php';
	//contient l'entête plus la navigation du site avec l'overture de la balise <body>
?>
	<h2>Voici les différentes pages de gestions accessibles :</h2><br/>
		<div id="contenu">
			<p id="inscription">
				Page d'incription des nouveaux membres <a href="inscription.php">inscription</a> L'inscription d'un nouveau membre l'ajoute en base de donnée et permet aussi de mémoriser son niveau de compétences et aussi de pouvoir lui attribuer un badge.
			</p>
			<p id="affichageMembres">
				Page d'affichage des adérants aux Usines Nouvelles <a href="affichage_inscription.php">Liste des inscrits</a> Permet de consulter l'ensemble des membres inscrits dans la base de données 
			</p>
			<p id="historiqueAcces">
				Page d'affichage des différents accès aux différents matériels et lieux <a href="historique_acces.php">historique des accès</a> L'affichage de l'historique des accès fait une recherche en base de données et affiche tous les accès ayant été enregistés par les badgeuses.
			</p>
			<p>
				<a href="test_badgeuse.php">test_badgeuse</a> 
			</p>
		</div>
<?php
	include 'footer.php'
	//contient le pied de page avec la balise <footer></footer> et la fermeture de la balise </body>
?>