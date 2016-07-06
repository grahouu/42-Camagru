<?php

class homeController extends Controller{

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
        $size = 2;
        $return = array("success" => false);

        if ($_SERVER['REQUEST_METHOD'] == "GET" && $args['page']){
            $photosModel = new photosModel($this->getService("connection")->getConnection());
            $return['success'] = true;
            $return['page'] = $args['page'];
            $return['pageMax'] = ceil($photosModel->count()['nb']/$size);
            $return['photos'] = $photosModel->paginate($args['page'], $size);
        }

        echo json_encode($return);
    }
}

?>
