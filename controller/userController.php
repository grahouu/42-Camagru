<?php

class userController extends Controller{

    public function index() {

        $msg = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["email"] && $_POST["password"]) {

            $usersModel = new usersModel($this->getService("connection")->getConnection());
            $_POST["password"] = sha1($_POST['password']);
            $user = $usersModel->exist($_POST);

            if ($user){
                if ($user['active']) {
                    $_SESSION["user"] = $user;
                    header('Location: home');
                }else{
                    $msg = "L'utilisateur n'est pas activé";
                }
            }else{
                $msg = "L'utilisateur n'existe pas";
            }
        }else if (isset($_SESSION["user"])){
            header('Location: home');
        }

        $this->title = 'okok';
        Parent::render("user/signin.php", array(
            "msg" => $msg
        ));
    }

    public function signup() {

        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["email"] && $_POST["name"] && $_POST["password"]) {
            $usersModel = new usersModel($this->getService("connection")->getConnection());
            if ($usersModel->create($_POST))
                header('Location: signin');
        }

        Parent::render("user/signup.php");
    }

    public function activate() {

        if(!empty($_GET)){

            $usersModel = new usersModel($this->getService("connection")->getConnection());

            if ( ($result = $usersModel->exist($_GET)) ){
                if ($result["active"])
                    $result = "Compte deja active";
                else if ($usersModel->update(array("email" => $result["email"]), array('active' => "1")))
                    $result = "Votre compte a ete active";
                else
                    $result = "Probleme d'activation";
            }else{
                $result = "Utilisateur ou token inconnu.";
            }
        }

        Parent::render("user/activate.php", array(
            "msg" => $result
        ));
    }

    public function changePassword (){
        if ($_SERVER['REQUEST_METHOD'] == "POST" && ($_POST["password"] == $_POST["password2"]) && $_POST["token"] && $_POST['email']) {
            $usersModel = new usersModel($this->getService("connection")->getConnection());
            $user = $usersModel->exist(array(
                "tokenPassword" => $_POST["token"],
                "email" => $_POST["email"]
            ));

            if ($user){
                $userUpdate = $usersModel->update(
                    array("email" => $user["email"]),
                    array(
                        'password' => sha1($_POST["password"]),
                        'tokenPassword' => ""
                    )
                );
                header('Location: signin');
            }
        }

        Parent::render("user/changePassword.php", array(
            "email" => $_GET["email"],
            "token" => $_GET["token"]
        ));
    }

    public function recoverPassword (){
        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["email"]){
            $usersModel = new usersModel($this->getService("connection")->getConnection());

            $user = $usersModel->exist(array(
                "email" => $_POST["email"]
            ));
            if ($user){
                $token = sha1(uniqid(rand()));
                $userUpdate = $usersModel->update(
                    array("email" => $user["email"]),
                    array('tokenPassword' => $token)
                );
                if ($userUpdate){
                    $emailService = $this->getService("email");
                    $emailService->sendUserTokenPassword($_POST["email"], $token);
                }
            }
        }else{
            $msg = "veuillez enter votre email";
        }
        Parent::render("user/recoverPassword.php");
    }

    public function logout() {
        session_destroy();
        header('Location: signin');
    }

    public function generateImage() {
        $datas = json_decode(file_get_contents('php://input'));

        define('UPLOAD_DIR', 'assets/images/save/');
    	$img = $datas->photo;
    	$img = str_replace('data:image/png;base64,', '', $img);
    	$img = str_replace(' ', '+', $img);
    	$data = base64_decode($img);
    	$file = UPLOAD_DIR . uniqid() . '.png';
    	$success = file_put_contents($file, $data);

        if ($success) {
            $image = imagecreatefrompng($file);
            $mask = imagecreatefrompng("assets/mask/" . $datas->filter);
            imagecopyresampled($image, $mask, 0, 0, 0, 0, imagesx($image), imagesy($image), imagesx($mask), imagesy($mask));
            imagepng($image, $file);
        }
    }
}

?>
