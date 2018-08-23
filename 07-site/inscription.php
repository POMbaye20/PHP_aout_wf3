<?php
require_once 'inc/init.inc.php';

$inscription = false;   // pour savoir si l'internaute vient de s'inscrire (on mettra la variable à true) et ne plus afficher le formulaire d'inscription 

// var_dump($_POST);  

// Traitement du formulaire
if (!empty($_POST)) {   // si le formulaire est soumis

    // Validation des champs du formulaire :
    if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20) $contenu .= '<div class="bg-danger">Le pseudo doit contenir entre 4 et 20 caractères.</div>';

    if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 20) $contenu .= '<div class="bg-danger">Le mot de passe doit contenir entre 4 et 20 caractères.</div>';

    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) $contenu .= '<div class="bg-danger">Le nom de passe doit contenir entre 4 et 20 caractères.</div>';

    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 4 || strlen($_POST['prenom']) > 20) $contenu .= '<div class="bg-danger">Le Prénom de passe doit contenir entre 4 et 20 caractères.</div>';

    if (!isset($_POST['ville']) || strlen($_POST['ville']) < 2   || strlen($_POST['ville']) > 20) $contenu .= '<div class="bg-danger">La ville de passe doit contenir entre 2  et 20 caractères.</div>';

    if (!isset($_POST['civilite']) || ($_POST['civilite']) != 'm' && ($_POST['civilite'] != 'f')) $contenu .= '<div class="bg-danger">La civilité est incorrecte" </div>';

    if (!isset($_POST['adresse']) || strlen($_POST['adresse']) < 2 || strlen($_POST['adresse']) > 50) $contenu .= '<div class="bg-danger">L\'adresse doit contenir entre 2 et 50 caractères.</div>';

    if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $contenu .= '<div class="bg-danger">Email est incorrecte </div>';  // filter_var() avec l'argument  FILTER_VALIDATE_EMAIL valide que $_POST['email] est bien de format d'un email.  Notez que cela marche aussi pour valdier les URL avec FILTER_VALIDIATE_URL

    if(!isset($_POST['code_postal']) || !ctype_digit($_POST['code_postal']) || strlen($_POST['code_postal']) != 5) $contenu .= '<div class="bg-danger"> Le code postal est incorrect </div>';   // la fonction ctype_digit() permet de vérifier qu'un string contient un nombre entier (utilisé pour les formulaires qui ne retourne que des strings avec le type "text")


        // --------------
        // Si pas d'erreur sur le formulaire, on vérifie que le pseudo est disponible dans la BDD :
        if(empty($contenu)) {   // si $contenu est vide, c'est qu'il n'y a pas d'erreur

            // Vérification du pseudo : 
            $membre = executeRequete("SELECT * FROM membre WHERE pseudo =:pseudo", array(':pseudo' => $_POST['pseudo']));   // on sélectionne en base les éventuels membres dont le pseudo correspond au pseudo donné par l'internaute lors de l'inscription
            
            if ($membre->rowCount() > 0) {  //  si la requête retourne 1 ou plusieurs résultats, c'est que le pseudo existe en BDD
                $contenu .= '<div class="bg-danger">le pseudo est indisponible. Veuillez en choisir un autre </div>';
            } else {
                // sinon, le pseudo étant disponible, on enregistre le membre en BDD :
                executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, 0)", 
                            array(':pseudo'     => $_POST['pseudo'],
                                  ':mdp'        => $_POST['mdp'],
                                  ':nom'        => $_POST['nom'],
                                  ':prenom'     => $_POST['prenom'],
                                  ':email'      => $_POST['email'],
                                  ':civilite'   => $_POST['civilite'],
                                  ':ville'      => $_POST['ville'],
                                  ':code_postal'=> $_POST['code_postal'],
                                  ':adresse'    => $_POST['adresse']                                              
                            ));
                $contenu .= '<div class="bg-success"> Vous êtes inscrit à notre site. <a href="connexion.php">Cliquez ici pour vous connecter.</div>';
                $inscription = true;    // pour ne plus afficher le formulaire sur cette page
            }   // fin du else

        } // fin du if(empty($contenu))
} // fin du if (!empty($_POST))




// ------------------- AFFICHAGE ---------------------
require_once 'inc/haut.inc.php';    
echo $contenu;  // pour afficher les messages à l'internaute 
?>
    <h1 class="mt-4">Inscription</h1>
<?php 
if ($inscription == false) :    // nous entrons dans la condition si $inscription vaut false. Syntaxe en if (condition) : ...endif;
?>    
    <p>Veuillez renseigner le formulaire pour vous inscrire.</p>

    <form method="post" action="">
        <label for="pseudo">Pseudo</label><br>
        <input type="text" name="pseudo" id="pseudo" value=""><br><br> 

        <label for="mdp">Mot de passe</label><br>
        <input type="text" name="mdp" id="mdp" value=""><br><br> 
    
        <label for="nom">Nom</label><br>
        <input type="text" name="nom" id="nom" value=""><br><br> 
    
        <label for="prenom">Prénom</label><br>
        <input type="text" name="prenom" id="prenom" value=""><br><br> 

         <label for="email">Email</label><br>
        <input type="text" name="email" id="email" value=""><br><br> 

         <label>Civilité</label><br>
        <input type="radio" name="civilite" value="m" checked> Homme
        <input type="radio" name="civilite" value="f"> Femme <br><br>
        
        <label for="ville">Ville</label><br>
        <input type="text" name="ville" id="ville" value=""><br><br> 

        <label for="code_postal">Code postal</label><br>
        <input type="text" name="code_postal" id="code_postal" value=""><br><br> 

        <label for="adresse">Adresse</label><br>
        <textarea name="adresse" id="adresse"></textarea><br><br>

        <input type="submit" name="inscription" value="S'inscrire" class="btn"><br><br> 

    </form>

<?php
endif;
require_once 'inc/bas.inc.php'; 
