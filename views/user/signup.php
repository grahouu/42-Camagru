<h2>Formulaire d'inscription :</h2>
<form method="POST">

    <label for="prenom">Nom : </label><br/>
    <input type="text" name="name"/><br/>
    <div class="error"><?php if(isset($error_prenom)){ echo $error_prenom; } ?></div>

    <label for="email">Email : </label><br/>
    <input type="text" name="email"/><br/>
    <div class="error"><?php if(isset($error_email)){ echo $error_email; } ?></div>

    <label for="password">Password : </label><br/>
    <input type="password" name="password" value=""/><br/><br/>

    <input type="submit" value="S'inscrire"/>

</form><br/>
