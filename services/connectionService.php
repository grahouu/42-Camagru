<?php

class connectionService extends Service {

    private $connection = null;

    function __construct($config) {
        $driver = isset($config['driver']) ? $config['driver'] : 'mysql';
        $hostname = isset($config['hostname']) ? $config['hostname'] : 'localhost';
        $username = isset($config['username']) ? $config['username'] : 'root';
        $password = isset($config['password']) ? $config['password'] : 'root';
        $dbname = isset($config['dbname']) ? $config['dbname'] : $username;

        try {
            $this->connection = new PDO("$driver:host=$hostname;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Échec lors de la connexion : ' . $e->getMessage();
        }
    }

    function getConnection() {
        return $this->connection;
    }

}
