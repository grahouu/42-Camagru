<?php

class connexionController extends Controller{

    public function index() {
        //$con = $this->getService("connection");
        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["email"] && $_POST["name"] && $_POST["password"]) {

            
            header('Location: home');
        }else if ($_SESSION["user"])
            header('Location: home');

        $this->title = 'okok';
        Parent::render("connexion.php");
    }

    public function logout() {
        session_destroy();
        header('Location: connexion');
    }
}

?>
