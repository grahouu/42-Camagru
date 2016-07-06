<?php

class photosModel extends Models {

    function getLikes() {
        $sql = 'SELECT idPhoto, COUNT(*) AS nb FROM likes GROUP BY idPhoto';
        $return = [];
        foreach ($this->getConnection()->query($sql) as $row) {
            $return[$row['idPhoto']] = $row['nb'];
        }
        return $return;
    }

    function getComments() {
        $sql = 'SELECT * FROM comments';
        $return = [];
        foreach ($this->getConnection()->query($sql) as $row) {
            $return[$row['idPhoto']][] = $row['comment'];
        }
        return $return;
    }

    function save($idUser, $namePhoto){

        $sql = 'INSERT INTO photo (idUser, photo) VALUES (:idUser, :namePhoto)';
        $req = $this->getConnection()->prepare($sql);
        return $req->execute(array(
            'idUser' => $idUser,
            'namePhoto' => $namePhoto
        ));
    }

    function getById($id) {
        $sql = 'SELECT * FROM photo WHERE id = ' . $id;
        $result = $this->getConnection()->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $result;
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

    function likeByIdPhoto($idPhoto) {
        $sql = 'INSERT INTO likes (idUser, idPhoto) VALUES (:idUser, :idPhoto)';
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
        $start = ($page - 1) * $size;
        $sql = "SELECT * FROM photo ORDER BY created ASC LIMIT " . $start . "," . $size;
        $req = $this->getConnection()->prepare($sql);
        $result = $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    function count(){
        $sql = 'SELECT COUNT(id) AS nb FROM photo';
        $req = $this->getConnection()->prepare($sql);
        $result = $req->execute();

        return $req->fetch(PDO::FETCH_ASSOC);
    }

}
