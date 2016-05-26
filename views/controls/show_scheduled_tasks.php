<?php $titre= "Controle choisi" ?>
<?php ob_start() ?>
<div id="title">
   <h1>Caractéristiques du contrôle:</h1>
</div>

   <div id ="controls">
   <h4><?php echo "Type de controle: $control->type "?></h4>   
   <h4><?php echo "Date du controle: Le " .timestamp_to_date($control->date_control, "date") ?></h4>
   <h4><?php echo "Utilisateur: $user->firstname $user->lastname"?></h4>
      	
     <?php foreach($tasks as $task): ?> 
     	<div id='libelle'>  
     	<?php echo $type_tasks[$task->type]["libelle"]; ?><br />
      	</div>
      	
      	<table>
      		<tr> 
          	<?php if ($task->status =='t') { ?>
          		<th> Status </th>
          		<td> <?php echo "Vérifié" ?> <br /></td>
          	 <?php
			  }else{ ?>
			  	<th> Status </th>
			  	<td> <?php echo "Pas vérifié" ?> <br /></td>
			   <?php
			  }          			  
		  ?>
		  </tr>
		  <tr>
		  	<th> Heure de vérification</th>
		  	<td><?php echo $task->verification_time; ?></td>          
      	 </tr>		  
		  <tr>
		  	<th> Commentaire</th>
		  	<td><?php echo $task->comment; ?></td>          
      	 </tr>		  
		</table>
      <?php endforeach ?>
      <br /><br />
    <a href="/controle_serveur/index.php/controls/edit?id=<?php echo $control->id."&type=".$control->type; ?>">Modifier</a> 
    <br />
    <a href="/controle_serveur/index.php/controls/delete?id=<?php echo $control->id ?>" rel="nofollow" data-method="delete" data-confirm="Êtes vous sûr?">Supprimer</a> 
    <br />
    <a href="/controle_serveur/index.php/controls/list">Retour</a> 
    <br />

<?php $content = ob_get_clean() ?>
 
<?php include 'views/layout.php'; ?>
