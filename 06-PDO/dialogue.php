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

print_r($_POST);






?>
<!-- I. formulaire de saisie de messages -->
<h1>Votre message</h1>
<form method="post" action="">
    
    <label for="pseudo">Pseudo</label><br>
    <input type="text" id="pseudo" name="pseudo" value=""><br>

    <label for="message">Message</label><br>
    <textarea id="message" name="message" ></textarea><br>

    <input type="submit" name="envoi" value="envoyer">

</form>