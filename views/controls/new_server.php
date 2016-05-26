 <?php $titre= "Controle serveur" ?>

<?php ob_start() ?>

<div id="title">
	<h1> Contrôle serveur </h1>
</div>
<?php $date = time(); ?>
<form method="post" id="new" action="/controle_serveur/index.php/controls/create?type=server">
  <div id ="controls">
    <div id="date">
      Date du contrôle: <input type="text" name="date_control" class="date" value="<?php echo timestamp_to_date(date_to_timestamp($date), "date")?>" />
    </div>
    <div id='serveur'>
      Choisir un serveur:
      <select name="server_id" >
  			<option selected value="">Choisir un serveur</option>
  			<optgroup label="A faire:">
  				<?php foreach($server_controls_by_date_control_todo as $server): ?>
  				  <option value="<?php echo $server -> id; ?>"> <?php echo "$server->name"; ?> </option>
  				<?php endforeach ?>
  			</optgroup>
  			<optgroup label="Déja fait:">
  				<?php foreach($server_controls_by_date_control as $server): ?>
  				  <option value="<?php echo $server -> id; ?>"> <?php echo "$server->name"; ?> </option>
  				<?php endforeach ?>
  			</optgroup>
      </select>
    </div>

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
  </div>
</form>

<?php $content = ob_get_clean(); ?>
<?php include 'views/layout.php' ?>