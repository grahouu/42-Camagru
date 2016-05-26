<?php $titre= "Gestion des contrôles"
?>

<?php ob_start()
?>

<div id="title">
  <h1> Gestion des contrôles </h1>
</div>

<div id ="home-top">
  <h2> Ajouter un contrôle </h2>
  <a href="/controle_serveur/index.php/controls/new?type=morning"> Matin </a>
  <br />
  <a href="/controle_serveur/index.php/controls/new?type=afternoon"> Après-midi</a>
  <br />
  <a href="/controle_serveur/index.php/controls/new?type=server"> Contrôle serveur</a>
  <br />
  <a href="/controle_serveur/index.php/controls/new?type=scheduled_tasks"> Taches planifiées</a>
  <br />
  <h2> Consulter un contrôle </h2>
  <a href="/controle_serveur/index.php/controls/show_last_id"> Consulter le dernier contrôle </a>
  <br />
  <a href="/controle_serveur/index.php/controls/list"> Voir la liste des contrôles effectués</a>
  <br /><br />
</div>

<?php $content = ob_get_clean(); ?>

<?php
  include 'views/layout.php';
?>
