<?php

/* Sujet : 
    1- Créer une base de données "Contacts" avec une table "contact" : 
        id_contact      PK AI INT(3)
        nom             VARCHAR(20)
        prenom          VARCHAR(20)
        telephone       VARCHAR(10)
        annee_rencontre YEAR  
        email           VARCHAR(255)  
        type_contact    ENUM('ami', 'famille', 'professionnel', 'autre')  

     2- Créer un formulaire HTML (avec doctype...) afin d'ajouter des contacts dans la BDD. Le champ année est un menu déroulant de l'année en cours à 100 ans en arrière à rebours, et le type de contact est aussi un menu déroulant :

    3- Sur le formulaire, effectuer les contrôles nécessaires : 
        - les champs nom et prénom contiennent 2 caractères minimum
        - le champ téléphone contient 10 chiffres
        - l'année de rencontre doit être une année valide
        - le type de contact doit être conforme à la liste de contacts
        - L'email doit être valide

        En cas d'erreur de saisie, afficher les messages d'erreur au-dessus du formulaire.

    4- Ajouter les contacts à la BDD et afficher un message en cas de succès ou en cas d'échec.

*/

    // 1- CREATE TABLE `contacts`.`contact` ( `id_contact` INT(3) NOT NULL , `nom` VARCHAR(20) NOT NULL , `prenom` VARCHAR(20) NOT NULL , `telephone` VARCHAR(10) NOT NULL , `annee_rencontre` YEAR NOT NULL , `email` VARCHAR(255) NOT NULL , `type_contact` ENUM('ami','famille','professionnel','autre') NOT NULL , PRIMARY KEY (`id_contact`)) ENGINE = InnoDB;

    // Contrôle du formulaire :

        // SELECT annnée de rencontre : 

        $message = ''; // pour afficher les messages à l'internaute

    echo '<pre>';
        print_r($_POST);
    echo '</pre>';

    // 1- Connexion à la BDD

    $pdo = new PDO('mysql:host=localhost;dbname=contacts', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));   // connexion à la BDD

    // 2- Traitement du formulaire
        
if (!empty($_POST)) { 

   
        if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) $message .= '<div>Le nom doit comporter en 2 et 20 caractères.</div>'; 
        
        if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) $message .= '<div>Le prénom doit comporter en 2 et 20 caractères.</div>';
    
        if (!isset($_POST['telephone']) || strlen($_POST['telephone']) != 10 || !ctype_digit($_POST['telephone'])) $message .= '<div>Le téléphone est incorrect.</div>';
    
        if (!isset($_POST['annee_rencontre']) || !ctype_digit($_POST['annee_rencontre']) || $_POST['annee_rencontre'] > 2018 || $_POST['annee_rencontre'] < (date('Y')-100) || $_POST['annee_rencontre'] > date('Y')) $message .= '<div>La date est incorrecte.</div>';

                 
        if (!isset($_POST['type_contact']) || ($_POST['type_contact'] != 'ami' && $_POST['type_contact'] != 'professionnel' && $_POST['type_contact'] != 'famille' && $_POST['type_contact'] != 'autre')) $message .= '<div>Le type de contact est incorrect.</div>';
    
        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $message .= '<div>L\'email est incorrect </div>';   // fonctionne aussi pour valider les URL.



    // Insertion en BDD :
    if (empty($message)) {  


        foreach ($_POST as $indice =>$valeur ) {
            $_POST[$indice] = htmlspecialchars($valeur, ENT_QUOTES);
        }


        $result = $pdo->prepare("INSERT INTO contact (nom, prenom, telephone, annee_rencontre, type_contact, email) VALUES (:prenom  , :nom, :telephone, :annee_rencontre, :type_contact, :email ) ");

        $result->bindParam(':nom', $_POST['nom']);
        $result->bindParam(':prenom', $_POST['prenom']);
        $result->bindParam(':telephone', $_POST['telephone']);
        $result->bindParam(':annee_rencontre', $_POST['annee_rencontre']);
        $result->bindParam(':email', $_POST['email']);
        $result->bindParam(':type_contact', $_POST['type_contact']);

        $req = $result->execute();  // la méthode execute() renvoie un booléen selon que la requête a marché (true) ou pas (false)

        // Afficher un message de réussite ou d'échec : 
        if ($req) {
            $message .= '<div>Le contact a été bien ajouté.</div>';
        } else {
            $message .= '<div>Une erreur est survenue lors de l\'enregistrement.</div>';
        }
    }

}   // fin de if (!empty($_POST))

?> 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire de contacts</title>
</head>
<body>

    <h1>Ajout de contacts</h1>

    <?php echo $message; ?>

    <form method="post" action="">

    <div>
        <label for="prenom">Nom</label><br>
        <input type="text" id="nom" name="nom">
    </div>

    <div>
        <label for="nom">Prénom</label><br>
        <input type="text" id="prenom" name="prenom" value=""><br>
    </div>

    <div>
        <label>Téléphone</label><br>
        <input type="text" id="telephone" name="telephone" value=""><br>
    </div>

    
    <div>
        <label for="annee_rencontre">Année de rencontre</label><br>
        <select name="annee_rencontre" id="annee_rencontre">
    
        <?php 
            for ($i=date('Y'); $i >= date('Y')-100 ; $i--) { // date('Y') donne l'année en cours soit 2018
                echo "<option>$i</option>";
            }     
        ?>
        </select>
    </div>


        <div>
            <label for="type_contact">Type de contact</label><br>
            <select name="type_contact" id="contact">
                <option value="ami">ami</option>
                <option value="famille">famille</option>
                <option value="professionnel">professionnel</option>
                <option value="autre">autre</option>
            </select>   
        </div>

        <div>
            <label for="email">Email</label><br>
            <input type="text" id="email" name="email">
        </div>

    <input type="submit" value="Enregistrer le contact">

</form>
    
</body>
</html>