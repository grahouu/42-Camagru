<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="assets/application.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>
        <?php echo $this->title ?>
    </title>
</head>

<body>
    <div class="header">
        <div class="home-menu pure-menu pure-menu-horizontal">
            <a class="pure-menu-heading" href="home">Camagru</a>

            <ul class="pure-menu-list">
                <?php if (isset($_SESSION["user"])) { ?>
                    <li class="pure-menu-item">
                        <?php echo "<a href='profile'>". $_SESSION["user"]["name"] . " </a> - " . $_SESSION["user"]["email"] ?>
                    </li>
                    <li class="pure-menu-item">
                        <a href="logout" class="pure-menu-link">Logout</a>
                    </li>
                <?php }else{ ?>
                    <li class="pure-menu-item">
                        <a href="signin" class="pure-menu-link">Login</a>
                    </li>
                    <li class="pure-menu-item">
                        <a href="signup" class="pure-menu-link">Signup</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="title">
             <?php echo $this->title ?>
        </div>
    </div>


    <div id="container">
        <?php echo $this->content ?>
    </div>

    <div class="footer">
        Created with PureCss
    </div>

</body>

</html>