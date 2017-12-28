
    <form class="pure-form pure-form-stacked" method="post">
        <fieldset>
            <input type="text" name="name"placeholder="Your name">
            <input type="password" name='password' placeholder="Password">

            <button type="submit" class="pure-button pure-button-primary center">Sign in</button>
        </fieldset>
        <?php echo $msg; ?>
    </form>
    <!-- <div class="row signin">
        <form class="form-signin col s12" method="post">
            <div class="row">
                <input type="text" name="name" placeholder="name">
            </div>

            <div class='row'>
                <div class='input-field col s12'>
                <input class='validate' type='password' name='password' id='password' />
                <label for='password'>Enter your password</label>
                </div>
                <label style='float: right;'>
                    <a class='pink-text' href='recoverPassword'><b>Forgot Password?</b></a>
                </label>
            </div>

            <button class="btn waves-effect waves-light" type="submit" name="action" >connexion
                <i class="material-icons right">send</i>
            </button>

        </form>

        <a href="signup">Creer un compte</a>

        <?php echo $msg; ?>
    </div> -->
