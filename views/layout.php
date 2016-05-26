<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/controle_serveur/assets/application.css" />
    <script type="text/javascript" src="/controle_serveur/assets/jquery.min.js"></script>
    <script type="text/javascript" src="/controle_serveur/assets/application.js"></script>
    <title><?php echo $titre ?></title>
  </head>
  <body>
    <div id="container">
      <div id="loginbar">
        <?php
          if (array_key_exists("user_id", $_COOKIE))
            echo "Vous êtes identifié en tant que : <strong><a href='/controle_serveur/index.php/users/show?id=".$_COOKIE['user_id']."'>".$_COOKIE['username']."</a></strong>";
        ?>
        <br /><br /><br /><br />Version: 1.1.1
      </div>
    <?php
        /*$current_user =current_user();
         if(!empty($current_user))  echo $current_user["username"];*/
    ?>
    <div id="menu" >
    	<ul class="liens">
    		<li class="lien"> <a href="/controle_serveur/index.php/home" title="Ajouter ou consulter un contrôle">Accueil</a></li>
  	    <li> <a href="/controle_serveur/index.php/administration"> Administration </a> </li>
    	</ul>
    </div>
    <div id="main">
      <?php echo $content ?>
    </div>
	</div>
  </body>
</html>