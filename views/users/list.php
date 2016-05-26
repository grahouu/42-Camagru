<?php $titre= "Liste des utilisateurs" ?>
<?php ob_start() ?>
<div id="title">
  <h1>Liste des utilisateurs</h1>
</div>
<div id="home-top-list">
  <table>		
    <tr>
    	<th> Prénom/Nom </th>
    </tr>
    <?php foreach($users as $user): ?>
      <tr>
      	<td>
          <?php echo "<a href='/controle_serveur/index.php/users/show?id=$user->id'>$user->firstname $user->lastname</a>"; ?> 
        </td>
 	    </tr>
    <?php endforeach ?>
  </table>
</div>
<?php $content = ob_get_clean() ?>
<?php include 'views/layout.php'; ?>
