<?php
/* Sujet : 

    1- Créer une BDD "restaurants"  avec une table "restaurant" : 
        id_restaurant   PK AI INT(3)
        nom   VARCHAR(100)
        adresse   VARCHAR(255)
        telephone   VARCHAR(10)
        type   ENUM('gastronomie', 'brasserie', 'pizzeria', 'autre')
        note   INT(1)
        avis   TEXT

    2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un restaurant en BDD. Les champs type et note(de 0 à 5) sont des menus déroulants.

    3- Effectuer les vérifications nécessaires
        Le champ nom contient 2 caractères minimum
        Le champ adresse ne doit pas être vide
        Le téléphone doit contenir 10 chiffres
        Le type doit être conforme à la liste des types de la BDD 
        La note est un nombre entier entre 0 et 5
        L'avis ne doit pas être vide.
        En cas d'erreur de saisie, afficher un message au-dessus du formulaire.

    4- Ajouter un ou plusieurs restaurants à la BDD et afficher un message de succès ou d'échec lors de l'enregistrement.

*/  

// 1- Création de la base de données : 

// CREATE TABLE `restaurant` (
//   `id_restaurant` int(3) NOT NULL, `nom` varchar(100) NOT NULL, `adresse` varchar(255) NOT NULL, `telephone` varchar(10) NOT NULL, `type` enum('gastronomie','brasserie','pizzeria','autre') NOT NULL,  `note` int(1) NOT NULL, `avis` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;

// Variable, déclaration etc : 


  $message = ''; // pour afficher les messages à l'internaute

  echo '<pre>';
      print_r($_POST);
  echo '</pre>';

// 1- BIS : Connexion à la BDD :

$pdo = new PDO('mysql:host=localhost;dbname=restaurants', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));   // connexion à la BDD

// 2 Créer le formulaire : voir le formulaire ci-dessous 


// 3- Contrôle du formulaire : 

    if (!empty($_POST)) {

        // Le nom : 
        if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) $message .= '<div>Le nom doit comporter en 2 et 20 caractères.</div>'; 

        // L'adresse : 
        if (empty($_POST['adresse'])) $message .= '<div>L\'adresse doit être complétée.</div>'; 

        // Le téléphone : 
        if (!isset($_POST['telephone']) || strlen($_POST['telephone']) != 10 || !ctype_digit($_POST['telephone'])) $message .= '<div>Le téléphone est incorrect.</div>';

        // Le type : 
        if (!isset($_POST['type']) || ($_POST['type'] != 'gastronomie' && $_POST['type'] != 'brasserie' && $_POST['type'] != 'pizzeria' && $_POST['type'] != 'autre')) $message .= '<div>Le type de restaurant est incorrect.</div>';

        // La note :
        if (!isset($_POST['note']) || ($_POST['note'] != 0 && $_POST['note'] != 1 && $_POST['note'] != 2 && $_POST['note'] != 3 && $_POST['note'] != 4 &&  $_POST['note'] != 5)) $message .= '<div>La note du restaurant est incorrect.</div>';

        // L'avis : 
        if (empty($_POST['avis']))  $message .= '<div>L\'avis doit être complété.</div>'; 


        /********** Insertion en BDD **********/

        if (empty($message)) {  


            foreach ($_POST as $indice =>$valeur ) {
                $_POST[$indice] = htmlspecialchars($valeur, ENT_QUOTES);
            }
    
            
            // La requête préparée
            $result = $pdo->prepare("INSERT INTO restaurant (nom, adresse, telephone, type, note, avis) VALUES (:nom, :adresse, :telephone, :type, :note, :avis ) ");
    
            $result->bindParam(':nom', $_POST['nom']);
            $result->bindParam(':adresse', $_POST['adresse']);
            $result->bindParam(':telephone', $_POST['telephone']);
            $result->bindParam(':type', $_POST['type']);
            $result->bindParam(':note', $_POST['note']);
            $result->bindParam(':avis', $_POST['avis']);
    
            $req = $result->execute();  // la méthode execute() renvoie un booléen selon que la requête a marché (true) ou pas (false)
    
            // Afficher un message de réussite ou d'échec : 
            if ($req) {
                $message .= '<div>Le restaurant a été bien ajouté.</div>';
            } else {
                $message .= '<div>Une erreur est survenue lors de l\'enregistrement.</div>';
            }
        }
        

    }  // fin de if (!empty($_POST))



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajout de restaurant</title>
</head>
<body>

    <h1>Ajout restaurant</h1>

    <?php echo $message; ?>

    <h2>Formulaire</h2>

<form method="post" action="">
    <div>
        <label for="nom">Nom</label><br>
        <input type="text" id="nom" name="nom">
    </div>

    <div>
        <label for="adresse">Adresse</label><br>
        <textarea name="adresse" id="adresse"></textarea>
    </div>

    <div>
        <label for="telephone">Téléphone</label><br>
        <input type="text" id="telephone" name="telephone">
    </div>

    <div>
        <label for="type">Type</label><br>
        <select name="type" id="type">
                <option value="gastronomie">gastronomie</option>
                <option value="brasserie">brasserie</option>
                <option value="pizzeria">pizzeria</option>
                <option value="autre">autre</option>               
            </select>   
    </div>

    <div>
        <label for="note">Note</label><br>
       <select name="note" id="note">
            <?php 
                for ($i=0; $i < 6 ; $i++) { 
                    echo "<option>$i</option>";
                }
            
            ?>
       </select>
    </div>

    <div>
        <label for="">Avis</label><br>
        <textarea name="avis" id="avis" placeholder="Votre Avis..."></textarea>
    
    </div>

    <input type="submit" value="Envoyer">
</form><!-- fin form -->
    
</body>
</html>

