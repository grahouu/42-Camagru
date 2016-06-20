<?php

class homeController extends Controller{

    public function index() {
        //$con = $this->getService("connection");

        $directory = "assets/mask";
        $masks = array_diff(scandir($directory), array('..', '.'));
        $this->title = 'home';
        Parent::render("home.php", array(
            "masks" => $masks
        ));
    }
}

?>
