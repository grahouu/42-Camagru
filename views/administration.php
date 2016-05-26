<?php $titre= "Administration" ?>

<?php ob_start() ?>

<?php $id_user=$_COOKIE['user_id'] ?>

<div id="title">
	<h1> Administration </h1>
</div>

  <div id ="home-top">
      <h2> Données </h2>
      <a href="/controle_serveur/index.php/servers/list"> Voir la liste des serveurs </a>
      <br />
      <a href="/controle_serveur/index.php/users/list"> Voir la liste des utilisateurs </a>
      <br /><br />
      <!--<a href="/controle_serveur/index.php/setting"> Changer le mot de passe </a> !-->
      <h2> Configuration</h2>
      <a href="/controle_serveur/index.php/servers/constraint_days"> Gérer la contrainte de date </a>
      <br />
      <a href="/controle_serveur/index.php/users/show?id=<?php echo $id_user; ?>"> Mon compte </a>
      <br /><br />
  </div>
<?php $content = ob_get_clean(); ?>
 
<?php include 'views/layout.php'; ?>
