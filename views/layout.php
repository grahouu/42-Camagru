<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo $this->title ?></title>
</head>
<body>
    <div id="container">

        <?php if ($_SESSION["user"]) { ?>

            <div id="menu" >
                <ul class="liens">
                    <li class="lien"> <a href="/controle_serveur/index.php/home" title="Ajouter ou consulter un contrôle">Accueil</a></li>
                    <li> <a href="/controle_serveur/index.php/administration"> Administration </a> </li>
                    <li> <a href="logout"> Deconnexion </a> </li>
                </ul>
            </div>

        <?php } ?>

        <div id="main">
            <?php echo $this->content ?>
        </div>
    </div>
</body>
</html>
