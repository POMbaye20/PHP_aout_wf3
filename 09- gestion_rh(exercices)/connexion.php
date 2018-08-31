<?php
require_once 'inc/init.inc.php';

// 2- Déconnexion de l'internaute : 
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {   // si l'internaute a cliqué sur "se déconnecter"
    session_destroy();  // on supprime toute la session du membre. Rappel : ctte instruction ne s'exécute qu'en fin des script.
}

// 3- On vérifie si l'internaute est déjà connecté :
if (internauteEstConnecte()) {  // s'il est connecté, on le renvoie vers son profil :
    header('location:profil.php');
    exit(); // pour quitter le script
}

// 1- Traitement du formulaire :
    if(!empty($_POST)){  // Si le formulaire est soumis

        // Validation des champs :
        if(!isset($_POST['email']) || empty($_POST['email']))
            $contenu .= '<div class="bg-danger">Le email est requis.</div>';
        
        if(!isset($_POST['mdp']) || empty($_POST['mdp']))
            $contenu .= '<div class="bg-danger">Le mot de passe est requis.</div>';

        if(empty($contenu)){
            $membre = executeRequete("SELECT * FROM admin WHERE email = :email AND mdp = :mdp", 
            array(':email' => $_POST['email'], ':mdp' => $_POST['mdp']));

        if($membre->rowCount() > 0){ // Si le nombre de ligne est supérieur à 0, alors le login et le mot de passe existent ensemble en BDD
            // On crée une session avec les informations du membre :
            $informations = $membre->fetch(PDO::FETCH_ASSOC); // On fait un fetch pour transfomer l'objet $membre en un array associatif qui contient en indices le nom de tous les champs de la requête
            debug ($informations); 

            $_SESSION['admin'] = $informations;    //  nous créons une session avec les infos du membre qui proviennent de la BDD

            header('location:profil.php');
            exit(); // on redirige l'internaute vers sa page de profil, et on quitte ce script avec la fonction exit().

        }else{
            // Sinon c'est qu'il y a erreur sur les identifiants (il n'existe pas ou pas pour le même membre)
            $contenu .= '<div class="bg-danger">Erreur sur les identifiants.</div>';
        }



    }

}// fin du if(!empty($_POST))




// --------------------------- AFFICHAGE ---------------------------
require_once 'inc/le_haut.inc.php';
?>

  <h1 class="mt-4">Connexion</h1>
    <?php echo $contenu; ?>

    <form method="post" action="">

        <label for="email">Email</label><br>
        <input type="text" name="email" id="email" value=""><br><br>

        <label for="mdp">Mot de passe</label><br>
        <input type="password" name="mdp" id="mdp" value=""><br><br>

        <input type="submit" value="Se connecter" class="btn">
    
    </form>
<?php
require_once 'inc/le_bas.inc.php';