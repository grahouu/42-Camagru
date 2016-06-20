<form class="" method="post">
    <input type="hidden" name="email" value="<?php echo $email ?>">
    <input type="hidden" name="token" value="<?php echo $token ?>">
    <input type="password" name="password" placeholder="nouveau mot de passe">
    <input type="password" name="password2" placeholder="confirmation">
    <input type="submit" value="valider">
</form>

<?php

echo $email;
echo $token;
