<?php $titre= "Controle choisi" ?>
<?php ob_start() ?>
<div id="title">
   <h1>Caratèristiques du contrôles:</h1>
</div>

<form method="post" name="edit" action="/controle_serveur/index.php/controls/update?id=<?php echo $control->id ?>">
  <div id ="controls">
    <div id='date'>	
      Date du contrôle: <input type="text" name="date_control" value="<?php echo timestamp_to_date($control->date_control, "date") ?>" size=23/> 
    </div>
    
    <?php foreach($tasks as $task): ?> 
      <div class="control">
        <input type="hidden" name="tasks[edit_<?php echo $task->id ?>][id]" value="<?php echo $task->id ?>" />
        <div id="libelle-<?php echo $i ?>" class="libelle">
          <?php echo $type_tasks[$task->type]["libelle"]; ?><br /> 
        </div>
        <div id="bon-mauvais-<?php echo $i ?>" class="bon_mauvais">
          <input type="checkbox" <?php  if($task->status == 't') echo "checked='checked'"; ?> />Vérifié
          <input type="hidden" id="tasks-edit-<?php echo $task->id ?>-status" 
            name="tasks[edit_<?php echo $task->id ?>][status]" value="<?php echo ($task->status =='t') ? '1' : '0'; ?>" />

          à:<input type="text" class='heure' value="<?php echo $task->verification_time ?>" name="tasks[edit_<?php echo $task->id ?>][verification_time]" id="tasks-edit-<?php echo $task->id ?>-verification_time" />
        </div>

        <div id="comment-<?php echo $i ?>" class="comment">
          <textarea id="tasks-edit-<?php echo $task->id ?>-comment" name="tasks[edit_<?php echo $task->id ?>][comment]"><?php echo $task->comment ?></textarea>
        </div>
      </div>
    <?php endforeach ?>
    <div id="actions">
      <input type="submit" id="bouton-envoyer" value="Envoyer" name="new" />
    </div>
  </div>
</form>

<?php $content = ob_get_clean(); ?>
<?php include 'views/layout.php' ?>
