<?php

require_once 'inc/init.inc.php';

// 1- Redirection si l'internaute n'est pas connecté :
if(!internauteEstConnecte()) {  // si le membre n'est pas connecté, il ne doit pas avoir accès à la page profil
    header('location:connexion.php');   // nous l'invitons à se connecter
    exit();
}

// 2- Préparation du profil à afficher : 
// debug($_SESSION);
extract($_SESSION['membre']);   // extrait tous les indices de l'array sous forme de variable auxquelles on affecte la valeur dans l'array. Exemple : $_SESSION['membre']['pseudo'] devient $pseudo = $_SESSION['membre']['pseudo'];


// ---------------------------------- AFFICHAGE ----------------------------------
require_once 'inc/haut.inc.php';
?>
    <h1 class="mt-4">Profil</h1>

    <h2>Bonjour <strong><?php echo $prenom; ?> !</strong></h2>
    
    <?php 
    if(internauteEstConnecteEtAdmin()) echo '<p>Vous êtes un administrateur.</p>';    
    ?>

    <hr>

    <h3>Voici vos informations de profil</h3>

    <p>Votre email : <?php echo $email; ?></p>
    <p>Votre adresse : <?php echo $adresse; ?></p>
    <p>Votre code postal : <?php echo $code_postal; ?></p>
    <p>Votre ville : <?php echo $ville; ?></p>

<?php
require_once 'inc/bas.inc.php';