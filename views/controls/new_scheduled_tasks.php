<?php $titre= "Controle serveur S19" ?>

<?php ob_start() ?>

<div id="title">
	<h1> Contrôle du serveur S19 </h1>
</div>
<?php $date = time(); ?>
<form method="post" id="new" action="/controle_serveur/index.php/controls/create?type=scheduled_tasks"> 
  <div id ="controls">
    <?php if ($server_by_name == NULL) {
      echo "Le serveur S19 n'existe pas !";
    } else { ?>
      <div id='date'>	
        Date du contrôle:<INPUT type="text" name="date_control" class='date' value="<?php echo timestamp_to_date(date_to_timestamp($date), "date")?>" />
      </div>
      <input type="hidden" name="server_id" value="<?php echo $server_by_name->id ?>" >
      <?php $i = 1; ?>
      <?php foreach($tasks as $type=>$task): ?>
        <div class="control">
          <div id="libelle-<?php echo $i ?>" class="libelle">
            <?php echo $task["libelle"]; ?>
          </div>
    
          <div id="bon-mauvais-<?php echo $i ?>" class="bon_mauvais">
            <input type="checkbox" />Vérifié
            <input type="hidden" id="tasks-new-<?php echo $i ?>-status" name="tasks[new_<?php echo $i ?>][status]" value="0" /> 
    
            à:<input type="text" class="heure" name="tasks[new_<?php echo $i ?>][verification_time]" id="tasks-new-<?php echo $i ?>-verification_time" readonly="readonly"/>
          </div>
    
          <div id="comment-<?php echo $i ?>" class="comment">
            <textarea id="tasks-new-<?php echo $i ?>-comment" name="tasks[new_<?php echo $i ?>][comment]" title="Commentaires"></textarea>
          </div>
          <input type="hidden" name="tasks[new_<?php echo $i ?>][type]" value="<?php echo $type ?>"/>
          <?php  $i++; ?>
        </div>
      <?php endforeach ?>
      <div id="actions">
        <input type="submit" id="bouton-envoyer" value="Envoyer" name="new" />
      </div>
    <?php	} ?>
  </div>
</form>

<?php $content = ob_get_clean(); ?>
<?php include 'views/layout.php' ?>