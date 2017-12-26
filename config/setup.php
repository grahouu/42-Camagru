<?php

include "database.php";

$initDb = file_get_contents("db.json");
$initDb = json_decode($initDb);

$dsn = $initDb->db_driver. ":host=" .$initDb->db_host. ";port=" .$initDb->db_port. ";";

print($dsn);

try {
    //------------ Connexion db -------------
    $mysqli = new PDO($dsn, $initDb->db_user, $initDb->db_password);
    $mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successfully </br >";

    //----------  Create database ----------
    $sql = "CREATE DATABASE IF NOT EXISTS ". $initDb->db_name;
    $mysqli->query($sql);
    echo "Database created successfully </br >";

    //-------- Create tables ----------
    foreach ($initDb->db_table as $table) {

        // ------ Drop table -----
        $sql = "DROP TABLE IF EXISTS ". $initDb->db_name. "." .$table->name . ";";
        $mysqli->query($sql);
        echo "Table ". $table->name ." droped successfully </br >";

        // ----- Create Table -------
        $sql = "CREATE TABLE ". $initDb->db_name. "." .$table->name ." ";

        //--------- Add field ----------
        if (!isset($table->id) || $table->id)
            $sql .= "(id int NOT NULL AUTO_INCREMENT, ";
        else
            $sql .= "(";

        foreach ($table->field as $field) {
            $sql .= $field->name . " " . $field->type . " " . implode(" ", $field->parameters) . ",";
        }

        if (isset($table->pk))
            $sql .= "PRIMARY KEY (". $table->pk .")); ";
        else
            $sql .= "PRIMARY KEY (id)); ";

        // ------ Execute sql -------
        $mysqli->query($sql);
        echo "Table ". $table->name ." created successfully </br >";
        if (isset($table->insert)){
            $mysqli->query(implode($table->insert));
            echo "Element add in Table </br >";
        }
    }

} catch (PDOException $e) {
    echo 'ERROR : ' . $e->getMessage();
    exit();
}

?>
