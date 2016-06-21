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

    function getByUser($idUser){

        $sql = 'SELECT * FROM photo WHERE idUser = :idUser';
        $req = $this->getConnection()->prepare($sql);
        $result = $req->execute(array(
            'idUser' => $idUser
        ));

        return $req->fetchAll();
    }

}
