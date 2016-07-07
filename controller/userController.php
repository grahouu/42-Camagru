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
        header('Content-Type: application/json');

        $datas = $_POST;
        $photosModel = new photosModel($this->getService("connection")->getConnection());

        define('UPLOAD_DIR', 'assets/images/save/');
    	$img = $datas['photo'];
        $pattern = "/^data:image\/(png|jpeg|jpg);base64,/";
    	$img = preg_replace($pattern, '', $img);
    	$img = str_replace(' ', '+', $img);
    	$data = base64_decode($img);
    	$file = UPLOAD_DIR . uniqid() . '.png';
    	$success = file_put_contents($file, $data);

        if ($success && $datas['filter']) {

            //Recuperation du mask et de la photo
            $image = imagecreatefrompng($file);
            $mask = imagecreatefrompng("assets/mask/" . $datas['filter']);

            //Creation du nouveau mask
            $newMask = imagecreatetruecolor($datas["filterWidth"], $datas["filterHeight"]);
            imagealphablending($newMask, false);
            imagesavealpha($newMask,true);
            $transparent = imagecolorallocatealpha($newMask, 255, 255, 255, 127);
            imagefilledrectangle($newMask, 0, 0, $datas["filterWidth"], $datas["filterHeight"], $transparent);
            imagecopyresampled($newMask, $mask, 0, 0, 0, 0, $datas["filterWidth"], $datas["filterHeight"], imagesx($mask), imagesy($mask));

            //Merge la photo avec le nouveau mask
            imagecopy($image, $newMask, $datas["filterX"], $datas["filterY"], 0, 0, $datas["filterWidth"], $datas["filterHeight"]);

            //sauvegarde de la nouvelle image
            imagepng($image, $file);
            $photosModel->save($_SESSION['user']['id'], $file);
            echo json_encode(array(
                'success' => true,
                "file" => $file,
                'id' => $this->getService("connection")->getConnection()->lastInsertId()
            ));
        }else{
            echo json_encode(array(
                'success' => flase,
                'msg' => $success
            ));
        }
    }

    public function deletePhoto() {
        header('Content-Type: application/json');
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
            $photosModel = new photosModel($this->getService("connection")->getConnection());
            $args = $this->getRoute()->getArguments();
            $photo = $photosModel->getById($args["id"]);
            if ($photo && $photo["idUser"] == $_SESSION["user"]["id"] && unlink($photo["photo"])) {
                $success = $photosModel->deleteByIdPhoto($args["id"]);
            }
        }

        echo json_encode(array('success' => $success));
    }

    public function likePhoto() {
        header('Content-Type: application/json');
        $success = false;
        $args = $this->getRoute()->getArguments();

        if ($_SERVER['REQUEST_METHOD'] == "GET" && $args["id"]){
            $photosModel = new photosModel($this->getService("connection")->getConnection());

            $photo = $photosModel->getById($args["id"]);
            if ($photo)
                $success = $photosModel->likeByIdPhoto($args["id"]);
        }
        echo json_encode(array('success' => $success));
    }

    public function commentPhoto() {
        $args = $this->getRoute()->getArguments();
        $emailService = $this->getService("email");
        $commentsModel = new commentsModel($this->getService("connection")->getConnection());
        $photosModel = new photosModel($this->getService("connection")->getConnection());
        $response = array('success' => false);

        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            if ($commentsModel->create($_SESSION["user"]["id"], $args["id"], $_POST['comment'])){
                $photo = $photosModel->getById($args["id"], true);
                $emailService->sendUserNewComment($photo['email'], $_SESSION['user']['email'], $_POST['comment']);
                $response["comment"] = $_POST['comment'];
                $response["user"] = $_SESSION['user']['email'];
                $response["success"] = true;
            }

        }else if ($_SERVER['REQUEST_METHOD'] == "GET"){
            if ( ($result = $commentsModel->getByIdPhoto($args["id"])) ){
                $response["data"] = $result;
                $response["success"] = true;
            }
        }

        echo json_encode($response);
    }
}

?>
