<?php

function vardump($array) {
    print("<pre>".print_r($array,true)."</pre>");
}

function render($view) {
    global $content;
    $content = file_get_contents("views/" . $view);
    include("views/layout.php");
}


function redirect($path) {
    header("location: " . $path);
    exit();
}

global $connect;
function db_open_connexion() {
    $initDb = file_get_contents("init/db.json");
    $initDb = json_decode($initDb);
    $dsn = $initDb->db_driver. ":host=" .$initDb->db_host. ";dbname=" .$initDb->db_name;

    return new PDO($dsn, $initDb->db_user, $initDb->db_password);
}

function db_close_connexion($connect) {
    $connect = null;
}

//Date au format PostGres SQL PHP
function date_to_timestamp($time) {
    return date('Y-m-d H:i:s.u', $time);
}

//Timestamp postgresSQL au format lisible
function timestamp_to_date($timestamp, $format = "dateheure") {
    $time = strtotime($timestamp);

    //Applique le fuseau horaire de la France
    date_default_timezone_set('Europe/Paris');
    $date = date('Y-m-d H:i:s.u', $time);
    date_default_timezone_set('UTC');

    $timestampunix = strtotime($date);
    if ($format == "date")
    return date('d/m/Y', $timestampunix);
    else
    return 'Le ' . date('d/m/Y', $timestampunix) . ' &agrave; ' . date('H:i:s', $timestampunix);
}

// fonction pour analyser l'en-tête http auth
function http_digest_parse($txt) {
    // protection contre les données manquantes
    $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

function current_user() {
    if (isset($_SESSION["user"])){
        return $_SESSION["user"];
    } else {
        return null;
    }
}

function checkUrl($route) {
    $uri = $route;
}
?>
