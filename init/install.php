<?php

$initDb = file_get_contents("db.json");
$initDb = json_decode($initDb);

$dsn = $initDb->db_driver. ":host=" .$initDb->db_host. ";dbname=" .$initDb->db_name;


//$dbh = new PDO($dsn, $initDb['db_user'], $initDb['db_password']);

//------------ Connexion db -------------
$mysqli = new mysqli($initDb->db_host, $initDb->db_user, $initDb->db_password);
if ($mysqli->connect_errno) {
    echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}else{
    echo "Connection successfully </br >";
}

//----------  Create database ----------
$sql = "CREATE DATABASE IF NOT EXISTS ". $initDb->db_name;
if ($mysqli->query($sql) === TRUE) {
    echo "Database created successfully </br >";
} else {
    echo "Error creating database: " . $mysqli->error;
    exit();
}

//-------- Create tables ----------
foreach ($initDb->db_table as $table) {

    // ------ Drop table -----
    $sql = "DROP TABLE IF EXISTS ". $initDb->db_name. "." .$table->name . ";";
    if ($mysqli->query($sql) === TRUE) {
        echo "Table ". $table->name ." droped successfully </br >";
    } else {
        echo "Error creating table: " . $mysqli->error;
        exit();
    }

    // ----- Create Table -------
    $sql = "CREATE TABLE ". $initDb->db_name. "." .$table->name ." ";

    //--------- Add field ----------
    $sql .= "(id int NOT NULL AUTO_INCREMENT, ";

    foreach ($table->field as $field) {
        $sql .= $field->name . " " . $field->type . " " . implode(" ", $field->parameters) . ",";
    }

    $sql .= "PRIMARY KEY (id));";

    // ------ Execute sql -------
    if ($mysqli->query($sql) === TRUE) {
        echo "Table ". $table->name ." created successfully </br >";
    } else {
        echo "Error creating table: " . $mysqli->error;
        exit();
    }
}


?>
