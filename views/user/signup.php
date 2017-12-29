<div class="center">
<h2>Sigup</h2>

<form class="pure-form pure-form-aligned" method="post">

    <div class="pure-control-group">
        <label for="prenom">Nom : </label>
        <input type="text" name="name" pattern=".{4,}"  required/>
    </div>

    <div class="pure-control-group">
        <label for="email">Email : </label>
        <input type="email" name="email" required/>
    </div>

    <div class="pure-control-group">
        <label for="password">Password : </label>
        <input type="password" name="password" minlength="4"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
            required
        />
    </div>

    <button type="submit" class="pure-button pure-button-primary center" />Sign up</button>

</form><br/>

<?php
    echo "<span id='info'>" . $msg . "</span>";
?>

</div>
