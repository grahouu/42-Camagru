<?php

class homeController extends Controller{

    public function index() {
        //$con = $this->getService("connection");
        $this->title = 'okok';
        Parent::render("home.php");
    }
}

?>
