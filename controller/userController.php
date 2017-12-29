<?php

class userController extends Controller{

    public function index() {

        $msg = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["name"] && $_POST["password"]) {

            $usersModel = new usersModel($this->getService("connection")->getConnection());

            $_POST["password"] = sha1($_POST['password']);
            $_POST["name"] = addslashes($_POST["name"]);
            $user = $usersModel->exist($_POST);

            if ($user){
                if ($user['active']) {
                    $_SESSION["user"] = $user;
                    $_SESSION["token"] = md5(time() * rand(1, 255));
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

        $this->title = 'signin';
        Parent::render("user/signin.php", array(
            "msg" => $msg
        ));
    }

    public function signup() {
        $msg = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["email"] && $_POST["name"] && $_POST["password"] && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $_POST["password"]) ) {
            $_POST["name"] = addslashes($_POST["name"]);
            $_POST["email"] = addslashes($_POST["email"]);
            $usersModel = new usersModel($this->getService("connection")->getConnection());
            $result = $usersModel->create($_POST);
            $emailService = $this->getService("email");
            if ($result["success"])
                $msg = $emailService->sendUserToken($_POST["email"], $result["success"]);
            else
                $msg = $result["msg"];
        }

        Parent::render("user/signup.php", array(
            "msg" => $msg
        ));
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
        if ($_SERVER['REQUEST_METHOD'] == "POST" && ($_POST["password"] == $_POST["password2"]) && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $_POST["password"]) && $_POST["token"] && $_POST['email']) {
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
        $email = "";
        $msg = "";

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
                    $email = $emailService->sendUserTokenPassword($_POST["email"], $token);
                }
            }else {
                $msg = "Cet email n'exist pas !";
            }
        }else{
            $msg = "veuillez enter votre email";
        }
        Parent::render("user/recoverPassword.php", array(
            "email" => $email,
            "msg" => $msg
        ));
    }

    public function logout() {
        session_destroy();
        header('Location: signin');
    }

    public function profile(){

        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            var_dump($_POST);

            $usersModel = new usersModel($this->getService("connection")->getConnection());
            if ($_POST["email"] && filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
                $usersModel->update(["id" => $_SESSION["user"]["id"]], [ "email" => $_POST["email"]]);
            }
            if ($_POST["name"]){
                $usersModel->update(["id" => $_SESSION["user"]["id"]], ["name" => $_POST["name"]]);
            }
            if ($_POST["password"] && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $_POST["password"])){
                $usersModel->updatePassword($_POST["password"]);
            }
            if ($_POST["notif"])
                $usersModel->update(["id" => $_SESSION["user"]["id"]], ["notif" => 1]);
            else
                $usersModel->update(["id" => $_SESSION["user"]["id"]], ["notif" => 0]);
        }

        $directory = "assets/mask";
        $masks = array_diff(scandir($directory), array('..', '.'));
        $photosModel = new photosModel($this->getService("connection")->getConnection());
        $photos = $photosModel->getByUser($_SESSION["user"]["id"]);
        $this->title = 'Profile';
        Parent::render("user/profile.php", array(
            "masks" => $masks,
            "photos" => $photos,
            'idUser' => $_SESSION["user"]["id"],
            'tokenUser' => $_SESSION["token"]
        ));
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
        $datas['filters'] = json_decode($datas['filters']);

        if ($data && $success && $datas['filters']) {

            //Recuperation du mask et de la photo
            $image = imagecreatefrompng($file);

            foreach ($datas['filters'] as $key => $mask) {
                $img_mask = imagecreatefrompng("assets/mask/" . $mask->id);
                $newMask = imagecreatetruecolor($mask->width, $mask->height);
                imagealphablending($newMask, false);
                imagesavealpha($newMask,true);
                $transparent = imagecolorallocatealpha($newMask, 255, 255, 255, 127);
                imagefilledrectangle($newMask, 0, 0, $mask->width, $mask->height, $transparent);
                imagecopyresampled($newMask, $img_mask, 0, 0, 0, 0, $mask->width, $mask->height, imagesx($img_mask), imagesy($img_mask));
                
                // //Merge la photo avec le nouveau mask
                imagecopy($image, $newMask, $mask->x, $mask->y, 0, 0, $mask->width, $mask->height);
            }

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
            if ($photo && $photo["idUser"] == $_SESSION["user"]["id"] && $_SESSION["token"] == $args["token"]) {
                if (file_exists($photo["photo"]))
                    unlink($photo["photo"]);
                $success = $photosModel->deleteByIdPhoto($args["id"]);
            }
        }

        echo json_encode(array('success' => $success));
    }

    public function likePhoto() {
        header('Content-Type: application/json');
        $success = false;
        $type = null;
        $args = $this->getRoute()->getArguments();

        if ($_SERVER['REQUEST_METHOD'] == "GET" && $args["id"]){
            $photosModel = new photosModel($this->getService("connection")->getConnection());

            $photo = $photosModel->getById($args["id"]);
            if ($photo){
                if ($photosModel->likedPhoto($args["id"])){
                    $success = $photosModel->unlikePhoto($args["id"]);
                    $type = "unlike";
                }else{
                    $success = $photosModel->likePhoto($args["id"]);
                    $type = "like";
                }
            }
        }
        echo json_encode(array('success' => $success, 'type' => $type));
    }

    public function commentPhoto() {
        $args = $this->getRoute()->getArguments();
        $emailService = $this->getService("email");
        $commentsModel = new commentsModel($this->getService("connection")->getConnection());
        $photosModel = new photosModel($this->getService("connection")->getConnection());
        $response = array('success' => false);

        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            //SECURITE - enleve les balises html
            $_POST['comment'] = htmlentities($_POST['comment']);
            $_POST['comment'] = strip_tags($_POST['comment']);

            if ($commentsModel->create($_SESSION["user"]["id"], $args["id"], $_POST['comment'])){
                $photo = $photosModel->getById($args["id"], true);
                if ($photo["notif"])
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
