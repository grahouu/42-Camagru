<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/application.css">
    <title><?php echo $this->title ?></title>
</head>
<body>
    <div id="container">

        <?php if (isset($_SESSION["user"])) { ?>

            <div id="header" >
                <a href="logout"> Deconnexion </a>
                <?php
                    echo $_SESSION["user"]["name"] . " - " . $_SESSION["user"]["email"]
                ?>
            </div>

        <?php } ?>

        <div id="content">
            <?php echo $this->content ?>
        </div>

        <div id="footer">
            footer
        </div>
    </div>

</body>
</html>
