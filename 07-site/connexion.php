<?php

require_once 'inc/init.inc.php';
// debug($_POST);

// 1- Traitement du formulaire :
    if(!empty($_POST)){  // Si le formulaire est soumis

        // Validation des champs :
        if(!isset($_POST['pseudo']) || empty($_POST['pseudo']))
            $contenu .= '<div class="bg-danger">Le pseudo est requis.</div>';
        
        if(!isset($_POST['mdp']) || empty($_POST['mdp']))
            $contenu .= '<div class="bg-danger">Le mot de passe est requis.</div>';

        if(empty($contenu)){
            $membre = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo AND mdp = :mdp", 
            array(':pseudo' => $_POST['pseudo'], ':mdp' => $_POST['mdp']));

        if($membre->rowCount() > 0){ // Si le nombre de ligne est supérieur à 0, alors le login et le mot de passe existent ensemble en BDD
            // On crée une session avec les informations du membre :
            $informations = $membre->fetch(PDO::FETCH_ASSOC); // On fait un fetch pour transfomer l'objet $membre en un array associatif qui contient en indices le nom de tous les champs de la requête
            debug ($informations); 

            $_SESSION['membre'] = $informations;    //  nous créons une session avec les infos du membre qui proviennent de la BDD

            header('location:profil.php');
            exit(); // on redirige l'internaute vers sa page de profil, et on quitte ce script avec exit().

        }else{
            // Sinon c'est qu'il y a erreur sur les identifiants (il n'existe pas ou pas pour le même membre)
            $contenu .= '<div class="bg-danger">Erreur sur les identifiants.</div>';
        }




        } // Fin du if(empty($contenu))
        

    }  // Fin if(!empty($_POST))

//************** AFFICHAGE **************
require_once 'inc/haut.inc.php'; // DOCTYPE, header, nav
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
require_once 'inc/bas.inc.php'; // footer et fermetures des balises