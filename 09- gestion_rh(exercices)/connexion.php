<?php
require_once 'inc/init.inc.php';










// --------------------------- AFFICHAGE ---------------------------
require_once 'inc/haut.inc.php';
?>

  <h1 class="mt-4">Connexion</h1>
    <?php echo $contenu; ?>

    <form method="post" action="">

        <label for="pseudo">Pseudo</label><br>
        <input type="text" name="pseudo" id="pseudo" value=""><br><br>

        <label for="mdp">Mot de passe</label><br>
        <input type="password" name="mdp" id="mdp" value=""><br><br>

        <input type="submit" value="Se connecter" class="btn">
    
    </form>
<?php
require_once 'inc/bas.inc.php';