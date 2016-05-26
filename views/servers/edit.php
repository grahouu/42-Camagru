<?php $titre= "Modification" ?>

<?php ob_start() ?>

<div id="title">
	<h1> Modifier serveur </h1>
</div>

<div id ="home-top">
<form method="post" name="edit" action="/controle_serveur/index.php/servers/update?id=<?php echo $server->id ?>">

			Nom:
			<input type="text" name="name" value= "<?php echo $server->name ?>" /> <br />

			<input type="submit" value="Envoyer" name="edit" />

</form>
</div>

<?php $content = ob_get_clean(); ?>
<?php include 'views/layout.php' ?>