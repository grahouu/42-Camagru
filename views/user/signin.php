<form class="pure-form pure-form-stacked" method="post">
    <fieldset>
        <input type="text" name="name"placeholder="Your name">
        <input type="password" name='password' placeholder="Password">
        <a href="recoverPassword"> forgot password </a> </br>

        <button type="submit" class="pure-button pure-button-primary center">Sign in</button>
    </fieldset>
    <?php echo $msg; ?>
</form>
