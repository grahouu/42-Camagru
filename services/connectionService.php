<?php

class connectionService extends Service {

    private $connection = null;

    function __construct($config) {
        $driver = isset($config['driver']) ? $config['driver'] : 'mysql';
        $hostname = isset($config['hostname']) ? $config['hostname'] : 'localhost';
        $username = isset($config['username']) ? $config['username'] : 'root';
        $password = isset($config['password']) ? $config['password'] : 'root';
        $dbname = isset($config['dbname']) ? $config['dbname'] : $username;

        //echo "$driver:host=$hostname;dbname=$dbname", " ", $username, " ", $password, "\n";
        $this->connection = new PDO("$driver:host=$hostname;dbname=$dbname", $username, $password);
    }

    function getConnection() {
        return $this->connection;
    }

}
