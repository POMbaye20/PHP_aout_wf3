<?php
// -----------------------------------------------
// Cas pratique :espaces de commentaires
// -----------------------------------------------

// Objectif : créer un formulaire pour poster des commentaires et le sécuriser.


/* Créer une BDD : dialogue
    Table        : commentaire
    Champs       : id_commentaire       INT(3) PK - AI
                   pseudo               VARCHAR(20)
                   message              TEXT
                   date_enregistrement  DATETIME
*/

// II. Connexion à la BDD et traitement de $_POST :
$pdo = new PDO('mysql:host=localhost;dbname=dialogue', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); 

// print_r($_POST);

if(!empty($_POST)) {    //  signifie si le formulaire est rempli

    // Traitement contre les failles JS (XSS) ou les failles CSS : on parle d'échappement des données reçues : 
    // on commence par mettre du code CSS dans le champ "message" : <style>body{display:none}</style>
    // pour s'en prémunir : 
    $_POST['pseudo'] = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);  // convertit les caractères spéciaux (<, >, &, "", '') en entités HTML (exmeple : le  < devient &lt;) ce qui permet de rendre inoffensives les balises HTML. On parle d'échappement des données reçues.
    $_POST['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);




    // Insertion du commentaire de l'internaute en BDD : nous allons faire une première requête qui n'est pas protégée contre les injections et qui n'accepte pas les apostrophes :
    // $resultat = $pdo->query("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES ('$_POST[pseudo]', NOW(), '$_POST[message]')"); 


    // Nous faisons l'injection SQL suivante dans le champ "message" :    ok');DELETE FROM commentaire;(
    // Pour se prémunir des injections SQL, nous faisons une requête préparée. Par ailleurs, elle permettra la saisie d'apostrophes par l'internaute :
    $resultat = $pdo->prepare("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES (:pseudo, NOW(), :message)"); 

    $resultat->bindParam(':pseudo', $_POST['pseudo']);
    $resultat->bindParam(':message', $_POST['message']);

    $resultat->execute();

    // Comment ça marche ? le fait de mettre des marqueurs dans la requête permet de ne pas concaténer les instructions SQL avec l'injection SQL. Par ailleurs, en faisant un bindParam(), les instructions SQL sont dissociées les une des autres et neutralisées par PDO  qui les transforme en strings inoffensifs. En effet, le SGBD attend des valeurs à la place des marqueurs dont il sait qu'elles ne sont pas du code à exécuter.

}

?>
<!-- I. formulaire de saisie de messages -->
<h1>Votre message</h1>
<form method="post" action="">
    
    <label for="pseudo">Pseudo</label><br>
    <input type="text" id="pseudo" name="pseudo" value="<?php echo $_POST['pseudo'] ?? ''; ?>"><br><!-- l'opérateur "??" en PHP7 signifie "prend le premier qui existe". Ici on affiche donc $_POST['pseudo'] s'il existe, sinon un string vide -->

    <label for="message">Message</label><br>
    <textarea id="message" name="message" ><?php echo $_POST['message'] ?? ''; ?></textarea><br>

    <input type="submit" name="envoi" value="envoyer">

</form>


<?php
// III. Affichage des messages :
$resultat = $pdo->query("SELECT pseudo, message, DATE_FORMAT(date_enregistrement, '%d/%m/%Y') AS datefr, DATE_FORMAT(date_enregistrement, '%H:%i:%s') AS heurefr FROM commentaire ORDER BY date_enregistrement DESC");

echo '<h2>' . $resultat->rowCount() . ' commentaires</h2>';

while ($commentaire = $resultat->fetch(PDO::FETCH_ASSOC)) {
    // var_dump($commentaire); 

    echo '<p>Par ' . $commentaire['pseudo'] . ' le ' . $commentaire['datefr'] . ' à ' . $commentaire['heurefr'] . '</p>';
    echo '<p>' . $commentaire['message'] .  '</p><hr>';
    

}


// Conclusion : faire systématiquement sur les données reçues : 1 htmlspecialchars() et une requête préparée !