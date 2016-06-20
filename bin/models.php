<?php
class Models {

    private $connection;

    function __construct($con)
    {
        $this->connection = $con;
    }

    public function getConnection() {
        return $this->connection;
    }


}

foreach (glob('models/*Model.php') as $model) {
    require_once $model;
}
