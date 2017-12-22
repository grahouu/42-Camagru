<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../assets/application.css">
    <title>
        <?php echo $this->title ?>
    </title>
</head>

<body>
    <div class="header">
        <div class="home-menu pure-menu pure-menu-horizontal">
            <a class="pure-menu-heading" href="">Photo Gallery</a>

            <ul class="pure-menu-list">
                <?php if (isset($_SESSION["user"])) { ?>
                    <li>
                        <?php echo $_SESSION["user"]["name"] . " - " . $_SESSION["user"]["email"] ?>
                    </li>
                    <li class="pure-menu-item">
                        <a href="logout" class="pure-menu-link">About</a>
                    </li>
                <?php }else{ ?>
                    <li class="pure-menu-item">
                        <a href="signin" class="pure-menu-link">Connexion</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="pure-g">
    </div>
    <!-- <nav class="light-blue lighten-1" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="#" class="brand-logo">Logo</a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <a href="gallery">Galerie</a>
                </li>
                
            </ul>

            <ul id="nav-mobile" class="side-nav">
                <li>
                    <a href="#">Navbar Link</a>
                </li>
            </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse">
                <i class="material-icons">menu</i>
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 m4"> </div>
                <div class="col s12 m4">
                    <?php echo $this->content ?>
                </div>
                <div class="col s12 m4"> </div>
            </div>
        </div>
    </div> -->

    <div class="footer">
        View the source of this layout to learn more. Made with love by the YUI Team.
    </div>

</body>

</html>