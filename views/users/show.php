<?php $titre= "Votre compte" ?>
<?php ob_start() ?>
<div id="title">
   <h1>Caratèristiques du compte:</h1>
   
   
</div>
<div id="home-top">
   <h4><?php echo "Nom:  $user->firstname "?></h4>
   <h4><?php echo "Prénom:  $user->lastname " ?></h4>
   <h4><?php echo "Votre login:  $user->login "  ?></h4>
    

</div>
<?php $content = ob_get_clean() ?>
 
<?php include 'views/layout.php'; ?>

