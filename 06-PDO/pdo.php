<?php

// -----------------------------
//              PDO
// -----------------------------
// PDO pour PHP Data Objects est une extension de PHP qui définit une interface pour accéder à une base de données depuis PHP (via du SQL).


function debug($param) {
    echo '<pre>';
        var_dump($param);
    echo '</pre>';
}


// --------------------------
// 01- Connexion à la BDD
// --------------------------
echo '<h3> 01- Connexion à la BDD </h3>';

$pdo = new PDO('mysql:host=localhost;dbname=entreprise',    // driver mysql : serveur ; nom de la BDD
                'root',     // pseudo de la BDD
                '', // mot de passe de la BDD 
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,    // option 1 : pour afficher les erreurs SQL
                      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des échanges avec la BDD
                ); 

// $pdo est un objet issu de la classe prédéfinie PDO.  Il représente la connexion à la BDD. 



// -----------------------------------------
// 02- exec() avec INSERT, DELETE et UDPATE
// -----------------------------------------
echo '<h3> 02- exec() avec INSERT, DELETE et UDPATE </h3>';

// Notre première requête SQL : 
$resultat = $pdo->exec("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) 
                        VALUES ('test', 'test', 'm', 'test', '2018-03-27', 500)");

// exec() est utilisé pour la formulation de requête ne retournant pas de jeu de résultats : INSERT, DELETE et UPDATE. 

/* Valeur de retour (dans $resultat) : 
                - en cas de succès : 1 ou plus, qui correspond au nombre de lignes affectées par la requête
                - en cas d'echec   : false
*/

echo "Nombre d'enregistrements affectés par l'INSERT : $resultat <br>";
echo 'Dernier id généré après la requête : ' . $pdo->lastInsertId();    // méthode qui permet de récupérer depuis la BDD le dernier id inséré par la requête précédente


// ---------
$resultat = $pdo->exec("DELETE FROM employes WHERE prenom = 'test'"); 
echo "<br> Nombre d'enregistrements affectés par DELETE : $resultat";



// -------------------------------------------------------
// 03- query() avec SELECT ET fetch() avec 1 seul résultat
// -------------------------------------------------------
echo '<h3> 03- query() avec SELECT ET fetch() avec 1 seul résultat </h3>';

$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");

// Au contraire de exec(), query() est utilisé pour les requêtes qui retournent un ou plusieurs résultats provenant de la BDD : SELECT. Notez que query() peut être aussi utilisé avec INSERT, UDPATE ou DELETE.

/* Valeur de retours : 
            - en cas de succès  : nouvel objet issu de la classe prédéfinie PDOStatement
            - en cas d'échec    : false
*/

debug($result);

// $result est le résultat de la requête sous une forme inexploitable directement : il faut donc le transformer avec la méthode fetch() :
$employe = $result->fetch(PDO::FETCH_ASSOC);    // la méthode fetch() avec son paramètre PDO::FETCH_ASSOC permet de transformer l'objet $result en un ARRAY ASSOCIATIF exploitable (ici $employe) indexé avec le nom des champs de la table.

debug($employe);    // Pour voir l'array associatif

echo 'Je suis ' . $employe['prenom'] . ' ' . $employe['nom'] . ' du service ' . $employe['service'] . '.<br>';


// -------
// Les trois autres méthodes de fetch() : 

$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
$employe = $result->fetch(PDO::FETCH_NUM);  // transform $result en un array indexé numériquement
debug($employe); 
echo $employe[1] . '<br>';  /// affiche Daniel


$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
$employe = $result->fetch();    // sans paramètre fetch() mélange array associatif et array numérique
debug($employe);  
echo $employe['prenom'] . '<br>';   // ou alors : 
echo $employe[1] . '<br>';


$result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
$employe = $result->fetch(PDO::FETCH_OBJ);  // transforme en un objet avec les noms des champs de la table comme propriétés de cet objet
debug($employe);
echo $employe->prenom . '<br>'; 

// Attention : après une requête, il faut choisir l'un des fetch(). Si l'on veut en refaire un, il faut refaire la requête : en effet, on ne peut pas effectuer plusieurs transformations successives sur le même objet $result.




