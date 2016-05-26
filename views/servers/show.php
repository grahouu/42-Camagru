<?php $titre= "Serveur choisi" ?>
<?php ob_start() ?>
<div id="title">
   <h1>Caratèristiques du serveur:</h1>
   

</div>
<div id="home-top">
   <h4><?php echo "Nom:  $server->name "?></h4>
   <h4><?php echo "Date de creation: " .timestamp_to_date($server->created_at) ?></h4>
   <h4><?php echo "Date de mise à jour: " .timestamp_to_date($server->updated_at) ?></h4>
    
    <a href="/controle_serveur/index.php/servers/edit?id=<?php echo $server->id; ?>"> Modifier serveur </a> 
    <br />
    <a href="/controle_serveur/index.php/servers/delete?id=<?php echo $server->id ?>" rel="nofollow" data-method="delete" data-confirm="Êtes vous sûr?">Supprimer</a>
    <br />
    <a href="/controle_serveur/index.php/servers/list"> Voir tous les serveurs </a>
    <br />
 </div>
<?php $content = ob_get_clean() ?>
 
<?php include 'views/layout.php'; ?>