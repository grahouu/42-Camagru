<?php

class emailService extends Service {

    private $connection = null;

    function __construct($config) {
    }

    function sendUserToken($email) {

        $to = $email;
        $sujet = 'Activation de votre compte';
        $body = '
        Bonjour, veuillez activer votre compte en cliquant ici ->
        <a href="http://camagru.localhost/index.php/activate?token='.$token.'&email='.$to.'">Activation du compte</a>';
        $entete = "MIME-Version: 1.0\r\n";
        $entete .= "Content-type: text/html; charset=UTF-8\r\n";
        $entete .= 'From: CreatiQ.FR ::' . "\r\n" .
        'Reply-To: contact@creatiq.fr' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        if (mail($to,$sujet,$body,$entete))
            return true;
        else
            return false;
    }

    function sendUserTokenPassword($email, $token) {

        $to = $email;
        $sujet = 'Retrouver son mot de passe';
        $body = '
        Bonjour, veuillez reinitialiser votre mot de passe en cliquant ici ->
        <a href="http://camagru.localhost/index.php/activate?token='.$token.'&email='.$to.'">Activation du compte</a>';
        $entete = "MIME-Version: 1.0\r\n";
        $entete .= "Content-type: text/html; charset=UTF-8\r\n";
        $entete .= 'From: CreatiQ.FR ::' . "\r\n" .
        'Reply-To: contact@creatiq.fr' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        if (mail($to,$sujet,$body,$entete))
            return true;
        else
            return false;
    }

}
