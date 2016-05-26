<?php $titre= "Ajouter un serveur" ?>

<?php ob_start() ?>

<div id="title">
  <h1> Nouveau serveur </h1>
</div>

<div id ="home-top">
  <form method="POST" action="/controle_serveur/index.php/servers/create">


    Nom du serveur: 
    <input type="text" name="name" /><br />

    <input type="submit" id="bouton-envoyer" value="Envoyer" />

  </form>

</div>
<?php $content = ob_get_clean(); ?>

<?php include 'views/layout.php'; ?>
