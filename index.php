<?php

require_once 'bin/app.php';

try {
    $connect = db_open_connexion();
    $current_user = current_user();
    $route = new Routes();

//-------- ROUTES -------
    $routes = new Routes();
    echo $routes->url;

    if (!$enterRoute) {
        header('Status: 404 Not Found');
        require "views/404.html";
    }

} catch (Exception $e) {
    $connect = null;
    throw $e;
}

db_close_connexion($connect);

?>
