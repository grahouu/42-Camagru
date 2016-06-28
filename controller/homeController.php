<?php

class homeController extends Controller{

    public function index() {
        //$con = $this->getService("connection");

        $photosModel = new photosModel($this->getService("connection")->getConnection());
        $photos = $photosModel->getAll();

        $directory = "assets/mask";
        $masks = array_diff(scandir($directory), array('..', '.'));
        $this->title = 'home';
        Parent::render("home.php", array(
            "masks" => $masks,
            "photos" => $photos
        ));
    }
}

?>
