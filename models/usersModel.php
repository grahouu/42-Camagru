<?php

class usersModel extends Models {

    function create($user) {

        if(!empty($user) && strlen($user['name'])>4 && filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $name = addslashes($user['name']);
            $email = addslashes($user['email']);
            $password = sha1($user['password']);
            $token = sha1(uniqid(rand()));

            $q = array(
                'name'=>$name,
                'email'=>$email,
                'password'=>$password,
                'token'=>$token
            );

            $sql = 'INSERT INTO user (name, email, password, token) VALUES (:name, :email, :password, :token)';
            $req = $this->getConnection()->prepare($sql);
            return $req->execute($q);
        }else{
            if(!empty($user) && strlen($user['name'])<4){
                $error_prenom = ' Votre prenom doit comporter au minimun 4 caracteres !';
            }
            if(!empty($user) && !filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
                $error_email = ' Votre Email n\'est pas valide !';
            }

        }
    }

    function update($filters, $values) {
        $sql = "UPDATE user SET ";
        $lenFilters = count($filters) - 1;
        $lenValues = count($values) - 1;
        $i = 0;

        foreach ($values as $key => $value) {
            $sql .= $key . " = :" . $key;
            if ($lenValues > $i)
                $sql .= " , ";
            $i++;
        }

        $sql .= " WHERE ";
        $i = 0;
        foreach ($filters as $key => $value) {
            $sql .= $key . " = :" . $key;
            if ($lenFilters > $i)
                $sql .= " and ";
            $i++;
        }

        $req = $this->getConnection()->prepare($sql);
        return $req->execute(array_merge($filters, $values));
    }

    public function exist($array){

        $sql = "SELECT * FROM user WHERE ";
        $len = count($array) - 1;
        $i = 0;
        
        foreach ($array as $key => $value) {
            $sql .= $key . " = :" . $key;
            if ($len > $i)
                $sql .= " AND ";
            $i++;
        }

        $req = $this->getConnection()->prepare($sql);
        $req->execute($array);

        return $req->fetch();
    }

}
