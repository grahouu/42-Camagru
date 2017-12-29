<form class="" method="post">
    <input type="hidden" name="email" value="<?php echo $email ?>">
    <input type="hidden" name="token" value="<?php echo $token ?>">
    <input type="password" name="password" placeholder="nouveau mot de passe" minlength="4"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
    <input type="password" name="password2" placeholder="confirmation">
    <input type="submit" value="valider">
</form>