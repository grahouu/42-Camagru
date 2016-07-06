<?php

class commentsModel extends Models {

    function create($idUser, $idPhoto, $comment) {
        $sql = 'INSERT INTO comments (idUser, idPhoto, comment) VALUES (:idUser, :idPhoto, :comment)';
        $req = $this->getConnection()->prepare($sql);
        return $req->execute(array(
            'idUser' => $idUser,
            'idPhoto' => $idPhoto,
            'comment' => $comment
        ));
    }

    function getByIdPhoto($idPhoto) {
        $sql = 'SELECT comments.*, user.email FROM comments INNER JOIN user ON comments.idUser = user.id WHERE idPhoto = :idPhoto';
        $req = $this->getConnection()->prepare($sql);
        $req->execute(array(
            'idPhoto' => $idPhoto
        ));

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

}
