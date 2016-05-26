<?php
$titre= "Authentification";
global $password, $realm;

function authentificate($realm) {
  header('HTTP/1.1 401 Unauthorized');
  header('WWW-Authenticate: Digest realm="'.$realm.
         '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
}

if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
  authentificate($realm);

  die('Vous devez vous authentifier pour utiliser cette application');
}
// analyse la variable PHP_AUTH_DIGEST
elseif (!($current_user = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) || !get_user_by_login($current_user['username'])) {
  authentificate($realm);// Mauvais nom d'utilisateur ou mot de passe
} else { // ok, utilisateur & mot de passe valide
  // Génération de réponse valide
  $A1 = md5($current_user['username'] . ':' . $realm . ':' . $password);
  $A2 = md5($_SERVER['REQUEST_METHOD'].':'.$current_user['uri']);
  $valid_response = md5($A1.':'.$current_user['nonce'].':'.$current_user['nc'].':'.$current_user['cnonce'].':'.$current_user['qop'].':'.$A2);

  if ($current_user['response'] != $valid_response) {
    authentificate($realm);// Mauvais nom d'utilisateur ou mot de passe
  } else {
    $user = get_user_by_login($current_user['username']);
    $full_name = $user->firstname." ".$user->lastname;
    setcookie("user_id", $user->id);
    setcookie("username", $full_name);
    
    ob_start();
    
    echo "<div id='home-top'>";
    echo '<h3>'.$full_name.', vous êtes maintenant connecté.</h3>';
    echo "<a href='/controle_serveur/index.php/home'>Allez à la page d'accueil</a>";
    echo "</div>";
    
    $content = ob_get_clean();
    include 'views/layout.php';
  }
}

?>
