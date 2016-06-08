<?php

require_once 'bin/app.php';

try {
    //$connect = db_open_connexion();
    //$current_user = current_user();

    $app = new app();
    $app->run();


} catch (Exception $e) {
    $connect = null;
    throw $e;
}

db_close_connexion($connect);

?>
