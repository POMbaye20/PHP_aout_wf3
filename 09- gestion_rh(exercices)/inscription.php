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

    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) $message .= '<div>Le nom doit comporter en 2 et 20 caractères.</div>'; 

    // Prénom : 
    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) $message .= '<div>Le prénom doit comporter en 2 et 20 caractères.</div>'; 

    // Date de naissance : 
    if (empty($_POST['date_naissance'])) $message .= '<div>Veuillez indiquer votre date de naissance.</div>'; 

    // Civilité : 
    if (empty($_POST['civilite'])) $message .= '<div>Veuillez préciser la civilité.</div>'; 

    // Poste : 
    if (empty($_POST['poste'])) $message .= '<div>Veuillez préciser votre poste.</div>'; 

    // Service : 
    if (empty($_POST['service'])) $message .= '<div>Veuillez préciser votre service dans lequel vous vous trouvez.</div>'; 

    // ---- fin du b)

    // 3- Insertion en BDD

    // Insertion en BDD :
    if (empty($message)) {  


        foreach ($_POST as $indice =>$valeur ) {
            $_POST[$indice] = htmlspecialchars($valeur, ENT_QUOTES);
        }


        $result = $pdo->prepare("INSERT INTO salaries (nom, prenom, date_naissance, civilite, poste, id_service) VALUES (:nom  , :prenom, :date_naissance, :civilite, :poste, :id_service ) ");

        $result->bindParam(':nom', $_POST['nom']);
        $result->bindParam(':prenom', $_POST['prenom']);
        $result->bindParam(':date_naissance', $_POST['date_naissance']);
        $result->bindParam(':civilite', $_POST['civilite']);
        $result->bindParam(':poste', $_POST['poste']);
        $result->bindParam(':id_service', $_POST['id_service']);

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
require_once 'inc/haut.inc.php';










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
            <label for="nom">Nom</label><br>
            <input type="text" name="nom" id="nom">
        </div>
    
        <div>
            <label for="prenom">Prénom</label><br>
            <input type="text" name="prenom" id="prenom">
        </div>
    
        <div>
            <label for="date_naissance">Date de naissance</label><br>
            <input type="date" name="date_naissance" id="date_naissance">
        </div>
        
        <div>
            <label for="civilite">Civilité</label><br>
            <input type="radio" name="civilite" value="Madame" checked> Madame
            <input type="radio" name="civilite"  value="Monsieur"> Monsieur
        </div>

         <div>
            <label for="poste">Poste</label><br>
            <input type="text" name="poste" id="poste">
       
        </div>

         <div>
            <label for="service">Service</label><br>
            <input type="text" name="service" id="service"> 
        </div>

       <div><input type="submit" value="Enregistrement"></div>

        
    
    
    
    </form>
    
</body>
</html>

<?php 
require_once 'inc/bas.inc.php';


