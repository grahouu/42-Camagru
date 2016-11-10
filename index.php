<?php

require_once 'bin/app.php';

try {

    $app = new app();
    $app->run();


} catch (Exception $e) {
    $connect = null;
    throw $e;
}

db_close_connexion($connect);

?>
