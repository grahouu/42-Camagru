<h2>Formulaire d'inscription :</h2>
<form method="POST">

    <label for="prenom">Nom : </label><br/>
    <input type="text" name="name" pattern=".{4,}"  required/><br/>

    <label for="email">Email : </label><br/>
    <input type="email" name="email" required/><br/>

    <label for="password">Password : </label><br/>
    <input type="password" name="password" value="" required/><br/><br/>

    <input type="submit" value="S'inscrire"/>

</form><br/>

<?php
    echo "<span id='info'>" . $msg . "</span>";
?>
