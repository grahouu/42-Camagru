<?php $titre= "Administration" ?>

<?php ob_start() ?>

<?php $id_user=$_COOKIE['user_id'] ?>

<div id="title">
	<h1> Administration </h1>
</div>

	<div id ="home-top">
		<div id="text">
		Cette page vous permet de modifier la contrainte de date qui s'applique sur la liste déroulante dans le contrôle d'un serveur,
		elle permet de classer les serveurs (Contrôlés/Non contrôlés). La contrainte est mise en nombre de jours.
		Exemple: contrainte de 5 jours, si on contrôle le serveur X aujourd'hui il se mettra dans le groupe "deja fait" et après 5 jours, 
		passé, il sera dans le groupe "A faire". 
		</div>
			<form method="POST" action="/controle_serveur/index.php/servers/update_contraint_days">

			Entrer le nombre de jour: 
			<input type="text" name="days" /><br />

			<input type="submit" id = "bouton-envoyer" value="Envoyer" />
					  
			</form>
	</div>
<?php $content = ob_get_clean(); ?>
 
<?php include 'views/layout.php'; ?>