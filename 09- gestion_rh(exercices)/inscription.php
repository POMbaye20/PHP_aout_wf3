<?php
require_once 'inc/init.inc.php';

// 1-  Création de la base de données : 
// nom : gestion_rh 
// table salariés :  CREATE TABLE `salaries` ( `id_salarie` int(3) NOT NULL, `nom` int(20) NOT NULL, `prenom` int(20) NOT NULL, `date_naissance` date NOT NULL, `civilite` enum('m','f','','') NOT NULL, `poste` varchar(30) NOT NULL, `service` varchar(20) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

// table services : CREATE TABLE `services` (`id_service` int(3) NOT NULL, `nom` varchar(20) NOT NULL, `id_salarie` int(3) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;

// table projets : CREATE TABLE `projets` (`id_projet` int(3) NOT NULL,`nom` varchar(20) NOT NULL,`id_service` int(3) NOT NULL,`date_debut` date NOT NULL, `date_fin` date NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;




// 2- Ajout salarié : 

// a) Connexion à la BDD : 
$pdo = new PDO('mysql:host=localhost;dbname=gestion_rh', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// b) Traitement du formulaire : 

    $message = '';  // pour afficher le message à l'internaute

    echo '<pre>';
        print_r($_POST);
    echo '</pre>';

    if (!empty($_POST)) { // traitement du formulaire

        // Email : 
        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $message .= '<div class="bg-danger">Email est incorrect </div>';

        // Mot de passe : 
        if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 20) $message .= '<div class="bg-danger">Le mot de passe doit comporter en 4 et 20 caractères.</div>';

    

    // ---- fin du b)

    // 3- Insertion en BDD

    // Insertion en BDD :
    if (empty($message)) {  


        foreach ($_POST as $indice =>$valeur ) {
            $_POST[$indice] = htmlspecialchars($valeur, ENT_QUOTES);
        }


        $result = $pdo->prepare("INSERT INTO admin (email, mdp) VALUES (:email, :mdp) ");

        $result->bindParam(':email', $_POST['email']);
        $result->bindParam(':mdp', $_POST['mdp']);

        $req = $result->execute();  // la méthode execute() renvoie un booléen selon que la requête a marché (true) ou pas (false)

        // Afficher un message de réussite ou d'échec : 
        if ($req) {
            $message .= '<div>L\'employé a été bien inscrit.</div>';
        } else {
            $message .= '<div>Une erreur est survenue lors de l\'inscription.</div>';
        }

        // 1- Redirection si l'internaute n'est pas connecté :
    
    header('location:connexion.php');   // nous l'invitons à se connecter
    exit();
}
    

}   // fin de if (!empty($_POST))

// --------------------------- AFFICHAGE ---------------------------
require_once 'inc/le_haut.inc.php';










?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salariés</title>
</head>
<body>

<h1>Veuillez vous inscrire</h1>

    <?php echo $message; ?>

    <form method="post" action="">

     

    
        <div>
            <label for="email">Email</label><br>
            <input type="text" name="email" id="email">
        </div>
        
        <div>
            <label for="mdp">Mot de passe</label><br>
            <input type="password" name="mdp" id="mdp">
        </div>

       <div><input type="submit" value="Enregistrement"></div>

        
    
    
    
    </form>
    
</body>
</html>

<?php 
require_once 'inc/le_bas.inc.php';


