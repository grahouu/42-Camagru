<?php

class photosModel extends Models {

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

}
