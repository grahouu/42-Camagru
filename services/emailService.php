<?php

class emailService extends Service {

    private $connection = null;

    function __construct($config) {
    }

    private function sendEmail($email, $sujet, $body){
        $entete = 'From: CreatiQ.FR ::' . "\r\n";
        $entete .= "Cc:". $email ." \r\n";
        $entete .= "MIME-Version: 1.0\r\n";
        $entete .= "Content-type: text/html; charset=UTF-8\r\n";

         if (mail($email,$sujet,$body,$entete))
            return true;
        else
            return false;
    }

    function sendUserToken($email, $token) {        
        $sujet = 'Activation de votre compte';
        $body = '
        Bonjour, veuillez activer votre compte en cliquant ici ->
        <a href="http://localhost:8080/camagru/activate?token='. $token .'&email='. $email .'">Activation du compte</a>';

        return $this->sendEmail($email, $sujet, $body);       
    }

    function sendUserTokenPassword($email, $token) {
        $sujet = 'Retrouver son mot de passe';
        $body = '
        Bonjour, veuillez reinitialiser votre mot de passe en cliquant ici ->
        <a href="http://localhost:8080/camagru/changePassword?token='.$token.'&email='.$email.'">Activation du compte</a>';

        return $this->sendEmail($email, $sujet, $body);
    }

    function sendUserNewComment($emailPhoto, $emailComment, $comment) {
        $sujet = 'Un nouveau commentaire a ete posté';
        $body = ' Bonjour, voici le nouveau commentaire posté par ' . $emailComment . ' : </ br> ' . $comment;
        return $this->sendEmail($emailPhoto, $sujet, $body);
    }

}
