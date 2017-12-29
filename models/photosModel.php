<?php

class photosModel extends Models {

    function getLikes($id = null) {
        $sql = 'SELECT idPhoto, COUNT(*) AS nb FROM likes GROUP BY idPhoto';
        $return = [];
        foreach ($this->getConnection()->query($sql) as $row) {
            $return[$row['idPhoto']] = $row['nb'];
        }
        return $return;
    }

    function getLikesById($id){
        if ($id){
            $sql = 'SELECT COUNT(*) AS nb FROM likes WHERE idPhoto=' . $id;
            $req = $this->getConnection()->prepare($sql);
            $req->execute();
            return $req->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    }

    function getComments() {
        $sql = 'SELECT * FROM comments';
        $return = [];
        foreach ($this->getConnection()->query($sql) as $row) {
            $return[$row['idPhoto']][] = $row['comment'];
        }
        return $return;
    }

    function getCommentsById($id){
        if ($id){
            $sql = 'SELECT COUNT(*) AS nb FROM comments WHERE idPhoto=' . $id;
            $req = $this->getConnection()->prepare($sql);
            $req->execute();
            return $req->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    }

    function save($idUser, $namePhoto){

        $sql = 'INSERT INTO photo (idUser, photo) VALUES (:idUser, :namePhoto)';
        $req = $this->getConnection()->prepare($sql);
        return $req->execute(array(
            'idUser' => $idUser,
            'namePhoto' => $namePhoto
        ));
    }

    function getById($id, $user = false) {
        if ($user)
            $sql = 'SELECT photo.*, user.id, user.email, user.notif FROM photo INNER JOIN user ON photo.idUser = user.id WHERE photo.id = ' . $id;
        else
            $sql = 'SELECT * FROM photo WHERE id = ' . $id;

        $req = $this->getConnection()->prepare($sql);
        $result = $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC);
    }

    function getByUser($idUser){
        $sql = 'SELECT * FROM photo WHERE idUser = :idUser';
        $req = $this->getConnection()->prepare($sql);
        $result = $req->execute(array(
            'idUser' => $idUser
        ));

        return $req->fetchAll();
    }

    function deleteByIdPhoto($idPhoto) {
        $sql = 'DELETE FROM photo WHERE id = :id';
        $req = $this->getConnection()->prepare($sql);
        $result = $req->execute(array(
            'id' => $idPhoto
        ));

        return $result;
    }

    function likedPhoto($idPhoto) {
        $sql = "SELECT * FROM likes WHERE idUser = :idUser and idPhoto = :idPhoto";
        $req = $this->getConnection()->prepare($sql);
        $res = $req->execute(array(
            'idUser' => $_SESSION["user"]["id"],
            'idPhoto' => $idPhoto
        ));
        if (!$req->rowCount())
            return false;
        else
            return true;
    }

    public function likePhoto($idPhoto) {
        $sql = 'INSERT INTO likes (idUser, idPhoto) VALUES (:idUser, :idPhoto)';
        $req = $this->getConnection()->prepare($sql);
        return $req->execute(array(
            'idUser' => $_SESSION["user"]["id"],
            'idPhoto' => $idPhoto
        ));
    }

    public function unlikePhoto($idPhoto){
        $sql = "DELETE FROM likes WHERE idUser = :idUser AND idPhoto= :idPhoto";
        $req = $this->getConnection()->prepare($sql);
        return $req->execute(array(
            'idUser' => $_SESSION["user"]["id"],
            'idPhoto' => $idPhoto
        ));
    }

    function getAll(){

        $sql = 'SELECT * FROM photo ORDER BY created ASC';
        $req = $this->getConnection()->prepare($sql);
        $result = $req->execute();

        return $req->fetchAll();
    }

    function paginate($page, $size){
        $return = array();
        $start = ($page - 1) * $size;
        $sql = "SELECT * FROM photo ORDER BY created ASC LIMIT " . $start . "," . $size;
        $req = $this->getConnection()->prepare($sql);
        $result = $req->execute();

        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $key => $photo) {
            $photo["nbLikes"] = $this->getLikesById($photo['id'])['nb'];
            $photo["nbComments"] = $this->getCommentsById($photo['id'])['nb'];
            $return[] = $photo;
        }

        return $return;
    }

    function count(){
        $sql = 'SELECT COUNT(id) AS nb FROM photo';
        $req = $this->getConnection()->prepare($sql);
        $result = $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC);
    }

}
