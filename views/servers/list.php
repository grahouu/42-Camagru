<?php $titre= "Liste des serveurs" ?>
<?php ob_start() ?>
<div id="title">
    <h1>Liste des serveurs</h1>
</div>

<div id="home-top-list">
	<table>
		
		<tr>
      	<th> ID </th>
      	<th> Nom </th>
      </tr>
      
      <?php foreach($servers as $server): ?>
      <tr>
      	<td>
        <?php echo $server->id; ?> 
        </td>
        <td>
        <a href="/controle_serveur/index.php/servers/show?id=<?php echo $server->id; ?>"> <?php echo $server->name; ?> </a> 
        </td>
 	  </tr>
      <?php endforeach ?>      
    </table>
    
    	<br />
    <div id="style-link">
    <a href="/controle_serveur/index.php/servers/new">Ajouter un serveur</a>    
    </div>
	<br />
    </div>
    
<?php $content = ob_get_clean(); ?>
 
<?php include 'views/layout.php'; ?>