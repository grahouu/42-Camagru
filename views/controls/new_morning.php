<?php $titre= "Creation matin" ?>

<?php ob_start() ?>

<div id="title">
	<h1> Contrôle matinée </h1>
</div>
<?php $date = time(); ?>
<form method="post" id="new" action="/controle_serveur/index.php/controls/create?type=morning">
  <div id ="controls">
  	<div id='date'>
  	 Date du contrôle: <INPUT type="text" class='date' name="date_control" value="<?php echo timestamp_to_date(date_to_timestamp($date), "date")?>" /> 
  	</div>
  	<?php $i = 1; ?>
    <?php foreach($tasks as $type=>$task): ?>
      <div class="control">
        <div id="libelle-<?php echo $i ?>" class="libelle">
          <?php echo $task["libelle"]; ?>
        </div>
  
        <div id="bon-mauvais-<?php echo $i ?>" class="bon_mauvais">
          <!-- javascript:disabled_checkbox(this,document.getElementById('tasks-new-<?php echo $i ?>-verification_time'), document.getElementById('tasks-new-<?php echo $i ?>-status')) -->
          <input type="checkbox" />Vérifié
          <input type="hidden" id="tasks-new-<?php echo $i ?>-status" name="tasks[new_<?php echo $i ?>][status]" value="0" /> 
  
          à:<input type="text" class="heure" name="tasks[new_<?php echo $i ?>][verification_time]" id="tasks-new-<?php echo $i ?>-verification_time" />
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
  </div>
</form>

<?php $content = ob_get_clean(); ?>
<?php include 'views/layout.php' ?>