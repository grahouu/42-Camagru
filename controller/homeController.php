<?php

class homeController extends Controller{

    public function galery(){
        $photosModel = new photosModel($this->getService("connection")->getConnection());
        $photos = $photosModel->getAll();
        $this->title = 'Galery';
        Parent::render("galery.php", array(
            "photos" => $photos,
        ));
    }

    public function index() {
        //$con = $this->getService("connection");

        $photosModel = new photosModel($this->getService("connection")->getConnection());
        $photos = $photosModel->getAll();
        $likes = $photosModel->getLikes();
        $comments = $photosModel->getComments();
        $directory = "assets/mask";
        $masks = array_diff(scandir($directory), array('..', '.'));
        $this->title = 'home';
        Parent::render("home.php", array(
            "masks" => $masks,
            "photos" => $photos,
            "likes" => $likes,
            "comments" => $comments
        ));
    }

    public function paginate() {
        $args = $this->getRoute()->getArguments();
        $size = 6;
        $return = array("success" => false);

        if ($_SERVER['REQUEST_METHOD'] == "GET" && $args['page']){
            $photosModel = new photosModel($this->getService("connection")->getConnection());
            $count = $photosModel->count()['nb'];
            $return['success'] = true;
            $return['page'] = $args['page'];
            $return['pageMax'] = $count ? ceil($count/$size) : 1;
            $return['photos'] = $photosModel->paginate($args['page'], $size);
            $return['TotalPhotos'] = $count;
            $return['idUser'] = $_SESSION["user"]["id"];
            $return['tokenUser'] = $_SESSION["token"];
        }

        echo json_encode($return);
    }
}

?>
